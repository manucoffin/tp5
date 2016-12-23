<?php

class AccueilController extends Controller{

	public function index(){

        $limit = 10;
        if(isset($_GET['page']))
        {
            $articles = ArticleModel::getLimit($limit, $_GET['page']*$limit);
        }
        else
        {
            // if the get variable is not set we want to get the first page
            $articles = ArticleModel::getLimit($limit, 0);
        }
        $allArticles = ArticleModel::getAll();
        
		$this->set(array('articles'=>$articles));
        $this->set(array('allArticles'=>$allArticles));
        $this->set(array('limit'=>$limit));
		$this->render('index');
	}
}