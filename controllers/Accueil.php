<?php

class AccueilController extends Controller{

	public function index(){
		/** @todo Lister sur l'accueil les 10 derniers articles CHECK */
        $articles = ArticleModel::getLimit(10,0);
		$this->set(array('articles'=>$articles));
		$this->render('index');
	}
    
    public function postprocess(){
        if(count($_POST))
        {
            if(isset($_POST['register-form']))
            {
                echo "register";
            }
            else if(isset($_POST['signin-form']))
            {
                echo "connexion";
            }
        }
    }
}