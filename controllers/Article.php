<?php

class ArticleController extends Controller{
	/** @todo créer une méthode "detail" pour afficher un article, son auteur et les commentaire */
    
    public function detail(){        
        $id = $_GET['id'];
        $article = new ArticleModel($id);
        $author = $article->getAuthor($article->id_user);
        $comments = CommentaireModel::getAll($id);
        $this->set(array('article'=>$article));
        $this->set(array('author'=>$author));
        $this->set(array('comments'=>$comments));   
    
        $this->render('detail');
	}
}