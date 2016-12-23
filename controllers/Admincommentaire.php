<?php

/** @todo sécuriser l'administration avec une connexion user */
class AdminCommentaireController extends Controller{

	public function index(){
        
        $limit = 10;
        
        if(isset($_GET['page']))
        {
            $comments = CommentaireModel::getLimit($limit, $_GET['page']*$limit);
        }
        else
        {
            // if the get variable is not set we want to get the first page
            $comments = CommentaireModel::getLimit($limit, 0);
        }
		$allComments = CommentaireModel::getAll();
        
        $this->set(array('limit'=>$limit));
        $this->set(array('comments'=>$comments));
		$this->set(array('allComments'=>$allComments));
		$this->render('index');
	}
    
    public function createedit(){
		$id = isset($_GET['id'])?$_GET['id']:null;
		$comment = new CommentaireModel($id);
		$this->set(array('comment'=>$comment));        
		$this->render('createedit');
	}

	public function delete(){
		$commentaire = new CommentaireModel($_GET['id']);
		$commentaire->delete();
		header('Location: ' . WEBROOT . 'admincommentaire/index');
	}
    
    public function exportCommentsCSV(){
        $comments = CommentaireModel::getAll();
        
        $list = array();
        // set the header of the CSV file
        $list[] = array('id', 'titre', 'contenu', 'date', 'id auteur', 'id article');
        foreach($comments as $c){
            $list[] = array($c['id'], $c['titre'], $c['contenu'], $c['datetime'], $c['id_user'], $c['id_article']);
        }
        
        $fp = fopen('comments.csv', 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        
        // Force the download of the file
        $file = 'comments.csv';

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            // We delete the file as we don't want to keep it on the server
            unlink(ROOT.'comments.csv');
            exit;
        }    
    }
}