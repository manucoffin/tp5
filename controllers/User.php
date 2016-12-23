<?php

class UserController extends Controller{
    
    public function index(){
        // We need to start a session here even though it is already started in the core controller 
        // Otherwise we cannot user $_SESSION
        session_start();
        
        if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
        {
            $user = new UserModel($_SESSION['user_id']);
            $user_articles = ArticleModel::getAll($_SESSION['user_id']);
            $this->set(array('user'=>$user));
            $this->set(array('user_articles'=>$user_articles));
        }
		$this->render('index');
	}
    
    public function detail(){
        $userId = $_GET['id'];
        $user = new UserModel($userId);
        $user_articles = ArticleModel::getAll($userId);
        
        $articles = array();
        foreach($user_articles as $article){
            // get comments for each article
            $articleComments = CommentaireModel::getAll($article['id']);
            // transform the article object into array
            $article = (array)$article;
            // and add the comments to the article array
            $article['comments'] = $articleComments;
            
            // add the one article into the articles array
            $articles[] = $article;
        }
        
        $articleCommented = ArticleModel::getAllCommentedBy($userId);
        
        // we update visits count here but the user data are already fetched.
        // So we need to do +1 in the view to get the correct count
        $user->updateVisits($userId);
        
        $this->set(array('user'=>$user));
        $this->set(array('articles'=>$articles));
        $this->set(array('articleCommented'=>$articleCommented));
        
        $this->render('detail');
    }
    
    // Method that handles registration and connexion of users
    // Modifying the profile is handled in adminuser
    public function postprocess(){
        if(count($_POST))
        {
            session_start();
            
            $user = new UserModel();
            
            // REGISTER
            if(isset($_POST['register-form']))
            {
                // check if the User already exists in the db
                // We should do the same for the email but I can't be bothered to do it now
                $name = $user->selectByName($_POST['username']);
                $mail = $user->selectByEmail($_POST['mail']);
                if($name)
                {
                    header('Location: ' . WEBROOT . 'user/index?register=nameErr');
                }
                else if($mail)
                {
                    header('Location: ' . WEBROOT . 'user/index?register=mailErr');
                }
                else
                {
                    // We also need to check if the two passwords match
                    if($_POST['password'] == $_POST['password-check'])
                    {
                        $user->name = $_POST['username'];
                        $user->email = $_POST['mail'];
                        $user->password = hash('sha256', $_POST['password']);
                        $user->actif = 1;
                        $user->admin = 0; // by default when a user register he is can't be an admin
                        $user->save();
                        header('Location: ' . WEBROOT . 'accueil/index?register=success');
                    }
                    else
                    {
                        header('Location: ' . WEBROOT . 'accueil/index?register=pwdErr');
                    }
                }
            }    
            // CONNEXION
            else if(isset($_POST['signin-form']))
            {
                $data = $user->selectByName($_POST['username']);
                
                // check that the password matches the one in db
                if(hash('sha256', $_POST['password']) == $data['password'])
                {
                    $_SESSION['user_id'] = $data['id'];
                    $_SESSION['is_admin'] = $data['admin'];
                    header('Location: ' . WEBROOT . 'accueil/index?conn=success');
                }
                else
                {
                    header('Location: ' . WEBROOT . 'user/index?conn=failure');
                }
            }
        }
    }
    
    public function disconnect(){
        
        // Initialize the session.
        // If you are using session_name("something"), don't forget it now!
        session_start();

        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        
        header('Location: ' . WEBROOT . 'accueil/index');
    }

}