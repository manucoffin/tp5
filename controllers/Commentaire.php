<?php

class CommentaireController extends Controller{
	/** @todo créer une méthode "postprocess" qui permet à un utilisateur conneté de poster un commentaire, si l'utilisateur n'est pas connecté, afficher le formulaire de connexion */
    
    public function postprocess(){
        if(isset($_POST['comment-form']))
        {
            session_start();
			$comment = new CommentaireModel();
            
            // Create new user and new article in order to get the informations we need to send a proper email
            $user = new UserModel($_SESSION['user_id']);
            $article = new ArticleModel($_POST['article_id']);
            $author = $article->getAuthor($article->id_user);
            $data = array();
            $data['user'] = $user;
            $data['article'] = $article;
            $data['author'] = $author;
            
            
            $comment->attach(new CommentObserver);
            $comment->setData($data);
            
            $comment->titre = $_POST['title'];
            $comment->contenu = $_POST['content'];
            $comment->id_user = $_SESSION['user_id'];
            $comment->id_article = $_POST['article_id'];
            $comment->datetime = date('Y-m-d H:i:s');
            
			$comment->save();
        }
        
        header('Location: ' . WEBROOT . 'article/detail?id='.$_GET['id']);
    }

}