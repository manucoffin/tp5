<?php

class CommentaireModel extends Model{
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

    public static function getAll(){
		$model = self::getInstance();
        $req = $model->bdd->prepare('SELECT id FROM commentaire');
        $req->execute();
        $commentaires = array();
        while($row = $req->fetch()){
            $commentaire = new CommentaireModel($row['id']);
            $commentaires[] = $commentaire;
        }
        return $commentaires;
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

}
