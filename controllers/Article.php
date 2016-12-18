<?php

class ArticleController extends Controller{
	/** @todo créer une méthode "detail" pour afficher un article, son auteur et les commentaire */
    
    public function detail(){
		//si on a un id en GET, on charge l'article, sinon on charge un article vide pour la création
//		$id = isset($_GET['id'])?$_GET['id']:null;
//		$article = new ArticleModel($id);
//		$activeUers = UserModel::getAll(true);
//
//		$this->set(array('article'=>$article));
		
//		$this->render('createedit');
        
        $id = $_GET['id'];
        $article = new ArticleModel($id);
        $this->set(array('article'=>$article));
        $this->render('detail');
	}
}