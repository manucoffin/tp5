<?php

class ArticleController extends Controller{
    
    public function detail(){        
        $id = $_GET['id'];
        $article = new ArticleModel($id);
        $author = $article->getAuthor($article->id_user);
        $comments = CommentaireModel::getAll($id);
        $this->set(array('article'=>$article));
        $this->set(array('author'=>$author));
        $this->set(array('comments'=>$comments));   
    
        $article->updateVisits($id);
            
        $this->render('detail');
	}
    
    public function shareByEmail(){
        if(isset($_POST['share-form']))
        {       
            $sender = new UserModel($_POST['sender']);
            $msg = "Bonjour, ".$sender->name." a partagé avec vous l'article suivant : \n".$_POST['title']."\n".$_POST['content']."\n Publié par ".$_POST['author'];

            mail($_POST['dest'],$sender->name." veut partager un article avec vous.",$msg);
            header('Location: ' . WEBROOT . 'article/detail?id='.$_GET['articleId'].'&share=success');
        }
    }
}