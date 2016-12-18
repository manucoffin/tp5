<?php

Class ArticleModel extends Model{
	public $id;
	public $titre;
	public $contenu;
	public $id_user;
	public $datetime;

	public function __construct($id=null) {
		parent::__construct();
		if(!is_null($id)){
			$data = $this->select($id);
			$this->id = $data['id'];
			$this->titre = $data['titre'];
			$this->contenu = $data['contenu'];
			$this->id_user = $data['id_user'];
			$tmpDate = DateTime::createFromFormat('Y-m-d H:i:s', $data['datetime']);
			$tmpDate = $tmpDate !== false ? $tmpDate->format('d/m/Y à H:i:s') : $data['datetime'];
			$this->datetime = $tmpDate;
		}
	}

	public function create(){
		$req = $this->bdd->prepare('INSERT INTO article (titre, contenu, id_user, datetime)'
			. ' VALUES(:titre, :contenu, :id_user, NOW())');
		$req->bindValue('titre', $this->titre, PDO::PARAM_STR);
		$req->bindValue('contenu', $this->contenu, PDO::PARAM_STR);
		$req->bindValue('id_user', $this->id_user, PDO::PARAM_INT);
		$req->execute();
		$this->id = $this->bdd->lastInsertId();
	}
	public function select($id){
		$req = $this->bdd->prepare('SELECT * FROM article WHERE id = :id');
		$req->bindValue('id', $id, PDO::PARAM_INT);
		$req->execute();
		return $req->fetch();
	}
	public function update(){
		$req = $this->bdd->prepare('UPDATE article SET titre=:titre, contenu=:contenu, '
			. 'id_user = :id_user WHERE id = :id');
		$req->bindValue('id', $this->id, PDO::PARAM_INT);
		$req->bindValue('titre', $this->titre, PDO::PARAM_STR);
		$req->bindValue('contenu', $this->contenu, PDO::PARAM_STR);
		$req->bindValue('id_user', $this->id_user, PDO::PARAM_INT);
		$req->execute();
	}
	public function delete(){
		CommentaireModel::deleteByArticle($this->id);
		$req = $this->bdd->prepare('DELETE FROM article WHERE id = :id');
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

	public static function getAll($user_id = null){
		$model = self::getInstance();
		if(!is_null($user_id))
			$req = $model->bdd->prepare('SELECT id FROM article WHERE id_user = '.$user_id.'ORDER BY datetime DESC');
		else
			$req = $model->bdd->prepare('SELECT id FROM article ORDER BY datetime DESC');

		$req->execute();
		$articles = array();
		while($row = $req->fetch()){
			$article = new ArticleModel($row['id']);
			$articles[] = $article;
		}
		return $articles;
	}
    
    public static function getLimit($nb, $offset = null){
        $model = self::getInstance();
        
        $req = $model->bdd->prepare('SELECT id FROM article ORDER BY datetime DESC LIMIT :nb OFFSET :offset');
        $req->bindValue('nb', $nb, PDO::PARAM_INT);
        $req->bindValue('offset', $offset, PDO::PARAM_INT);
        $req->execute();
        $articles = array();
        while($row = $req->fetch()){
            $article = new ArticleModel($row['id']);
            $articles[] = $article;
        }
        return $articles;
    }
}