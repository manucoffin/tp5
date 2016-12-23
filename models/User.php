<?php

class UserModel extends Model{
    public $id;
    public $name;
    public $email;
    public $password;
    public $actif;
    public $admin;

    public function __construct($id=null) {
		parent::__construct();
        if(!is_null($id)){
            //on récupère en base
            $data = $this->select($id);
            $this->id = $data['id'];
            $this->name = $data['name'];
            $this->email = $data['email'];
            $this->password = $data['password'];
            $this->actif = $data['actif'];
            $this->admin = $data['admin'];
        }
    }

    public function create(){
        $req = $this->bdd->prepare('INSERT INTO user (name, email, password, actif, admin)'
                . ' VALUES(:name, :email, :password, :actif, :admin)');
        $req->bindValue('name', $this->name, PDO::PARAM_STR);
        $req->bindValue('email', $this->email, PDO::PARAM_STR);
        $req->bindValue('password', $this->password, PDO::PARAM_STR);
        $req->bindValue('actif', $this->actif, PDO::PARAM_BOOL);
        $req->bindValue('admin', $this->admin, PDO::PARAM_BOOL);
        $req->execute();
        $this->id = $this->bdd->lastInsertId();
    }
    public function select($id){
        $req = $this->bdd->prepare('SELECT * FROM user WHERE id = :id');
        $req->bindValue('id', $id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch();
    }

    public function update(){
        $req = $this->bdd->prepare('UPDATE user SET name=:name, email=:email, '
                . 'password = :password, actif = :actif, admin = :admin WHERE id = :id');
        $req->bindValue('id', $this->id, PDO::PARAM_INT);
        $req->bindValue('name', $this->name, PDO::PARAM_STR);
        $req->bindValue('email', $this->email, PDO::PARAM_STR);
        $req->bindValue('password', $this->password, PDO::PARAM_STR);
        $req->bindValue('actif', $this->actif, PDO::PARAM_BOOL);
        $req->bindValue('admin', $this->admin, PDO::PARAM_BOOL);
        $req->execute();
    }

    public function delete(){
		//on supprime les commentaires
		CommentaireModel::deleteByUser($this->id);
		//on récuère ses articles
		$articles = ArticleModel::getAllArticlesOnly($this->id);
		foreach($articles as $article){
			//pour chaque article, on supprime les commentaire
			//puis les articles
			$article->delete();
		}
		//on supprime enfin le user
        $req = $this->bdd->prepare('DELETE FROM user WHERE id = :id');
        $req->bindValue('id', $this->id, PDO::PARAM_INT);
        $req->execute();
    }

    public function save(){
        if($this->id){
            $this->update();
        }else{
            $this->create();
        }
    }
    
    public function selectByName($name){
        $req = $this->bdd->prepare('SELECT * FROM user WHERE name = :name');
        $req->bindValue('name', $name, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch();
    }
    
    public function selectByEmail($mail){
        $req = $this->bdd->prepare('SELECT * FROM user WHERE email = :mail');
        $req->bindValue('mail', $mail, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch();
    }
    
    public function getArticles($id){
        $req = $this->bdd->prepare('SELECT * FROM article WHERE id_user = :id');
        $req->bindValue('id', $id, PDO::PARAM_INT);
        $req->execute();
        
        $articles = array();
        while($row = $req->fetch()){
            $article = new ArticleModel($row['id']);
            $articles[] = $article;
        }
        return $articles;
    }
    
    public function getComments($id){
        $req = $this->bdd->prepare('SELECT * FROM commentaire WHERE id_user = :id');
        $req->bindValue('id', $id, PDO::PARAM_INT);
        $req->execute();
        
        $comments = array();
        while($row = $req->fetch()){
            $comment = new ArticleModel($row['id']);
            $comments[] = $comment;
        }
        return $comments;
    }

    public static function getAll($actif=null){
		$model = self::getInstance();
        
        if(!is_null($actif))
            $req = $model->bdd->prepare('SELECT id FROM user WHERE actif = TRUE');
        else
            $req = $model->bdd->prepare('SELECT id FROM user');
        $req->execute();
        $users = array();
        while($row = $req->fetch()){
            $user = new UserModel($row['id']);
            $articles = $user->getArticles($user->id);
            $comments = $user->getComments($user->id);
            $user = (array)$user;
            $user['articles'] = $articles;
            $user['comments'] = $comments;
            
            $users[] = $user;
        }
        return $users;
    }
    
    public static function getLimit($nb, $offset = null){
        $model = self::getInstance();
        
        $req = $model->bdd->prepare('SELECT id FROM user ORDER BY id DESC LIMIT :nb OFFSET :offset');
        $req->bindValue('nb', $nb, PDO::PARAM_INT);
        $req->bindValue('offset', $offset, PDO::PARAM_INT);
        $req->execute();
        $users = array();
        while($row = $req->fetch()){
            $user = new UserModel($row['id']);
            $articles = $user->getArticles($user->id);
            $comments = $user->getComments($user->id);
            $user = (array)$user;
            $user['articles'] = $articles;
            $user['comments'] = $comments;
            
            $users[] = $user;
        }
        return $users;
    }
    
    
}
