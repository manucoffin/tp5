<?php

class CommentaireModel extends Model implements SplSubject{
    // METTRE L4OBSERVER ICI
    public $id;
    public $titre;
    public $contenu;
    public $id_user;
    public $id_article;
    public $datetime;

    public function __construct($id=null) {
		parent::__construct();
        if(!is_null($id)){
            //on récupère en base
            $data = $this->select($id);
            $this->id = $data['id'];
            $this->titre = $data['titre'];
            $this->contenu = $data['contenu'];
            $this->id_user = $data['id_user'];
            $this->id_article = $data['id_article'];
            $this->datetime = $data['datetime'];
        }
    }

    public function create(){
        
        $req = $this->bdd->prepare('INSERT INTO commentaire (titre, contenu, id_user, id_article, datetime)'
                . ' VALUES(:titre, :contenu, :id_user, :id_article, NOW())');
        $req->bindValue('titre', $this->titre, PDO::PARAM_STR);
        $req->bindValue('contenu', $this->contenu, PDO::PARAM_STR);
        $req->bindValue('id_user', $this->id_user, PDO::PARAM_INT);
        $req->bindValue('id_article', $this->id_article, PDO::PARAM_INT);
        $req->execute();
        $this->id = $this->bdd->lastInsertId();
    }
    public function select($id){
        
        $req = $this->bdd->prepare('SELECT * FROM commentaire WHERE id = :id');
        $req->bindValue('id', $id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch();
    }
    public function update(){
        
        $req = $this->bdd->prepare('UPDATE commentaire SET titre=:titre, contenu=:contenu, '
                . 'id_user = :id_user, id_article = :id_article WHERE id = :id');
        $req->bindValue('id', $this->id, PDO::PARAM_INT);
        $req->bindValue('titre', $this->titre, PDO::PARAM_STR);
        $req->bindValue('contenu', $this->contenu, PDO::PARAM_STR);
        $req->bindValue('id_user', $this->id_user, PDO::PARAM_INT);
        $req->bindValue('id_article', $this->id_article, PDO::PARAM_INT);
        $req->execute();
    }
    public function delete(){
        
        $req = $this->bdd->prepare('DELETE FROM commentaire WHERE id = :id');
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
    
    public function getAuthor($comment_user_id){
        $model = self::getInstance();
        
        $req = $model->bdd->prepare('SELECT user.id, user.name, user.actif, user.admin, user.email FROM user WHERE id = :id');
        $req->bindValue('id', $comment_user_id, PDO::PARAM_INT);
        $req->execute();
        
        return $req->fetch();
    }

    public static function getLimit($nb, $offset = null){
        $model = self::getInstance();
        
        $req = $model->bdd->prepare('SELECT id FROM commentaire ORDER BY datetime DESC LIMIT :nb OFFSET :offset');
        $req->bindValue('nb', $nb, PDO::PARAM_INT);
        $req->bindValue('offset', $offset, PDO::PARAM_INT);
        $req->execute();
        $comments = array();
        while($row = $req->fetch()){
            $comment = new CommentaireModel($row['id']);
            $author = $comment->getAuthor($comment->id_user);
            $comment = (array)$comment;
            $comment['author'] = $author;
            $comments[] = $comment;
        }
        return $comments;
    }
    
    public static function getAll($id_article = null){
		$model = self::getInstance();
        
        if($id_article)
        {
            $req = $model->bdd->prepare('SELECT id FROM commentaire WHERE id_article = :id');
            $req->bindValue('id', $id_article, PDO::PARAM_INT);
        }
        else
        {
            $req = $model->bdd->prepare('SELECT id FROM commentaire');
        }

        $req->execute();
        $comments = array();
        while($row = $req->fetch()){
            $comment = new CommentaireModel($row['id']);
            $author = $comment->getAuthor($comment->id_user);
            $comment = (array)$comment;
            $comment['author'] = $author;
            $comments[] = $comment;
        }
        
        return $comments;
    }

    public static function deleteByArticle($id_article){
		$model = self::getInstance();

        $reqCom = $model->bdd->prepare('DELETE FROM commentaire WHERE id_article = :id');
        $reqCom->bindValue('id', $id_article, PDO::PARAM_INT);
        $reqCom->execute();
    }

    public static function deleteByUser($id_user){
		$model = self::getInstance();

        $req = $model->bdd->prepare('DELETE FROM commentaire WHERE id_user = :id');
        $req->bindValue('id', $id_user, PDO::PARAM_INT);
        $req->execute();
    }
    
    // Ceci est le tableau qui va contenir tous les objets qui nous observent.
    protected $observers = [];
    // Dès que cet attribut changera on notifiera les classes observatrices.
    protected $data;
    
    public function attach(SplObserver $observer){
        $this->observers[] = $observer;
    }
    
    public function detach(SplObserver $observer){
        if (is_int($key = array_search($observer, $this->observers, true))){
            unset($this->observers[$key]);
        }
    }
    
    public function notify(){
        foreach ($this->observers as $observer){
            $observer->update($this);
        }
    }
    
    public function getData(){
        return $this->data;
    }
    
    public function setData($data){
        $this->data = $data;
        $this->notify();
    }

}
