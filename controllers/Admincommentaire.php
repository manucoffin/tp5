<?php

/** @todo sécuriser l'administration avec une connexion user */
class AdminCommentaireController extends Controller{

	public function index(){
		$commentaires = CommentaireModel::getAll();
		$this->set(array('commentaires'=>$commentaires));
		$this->render('index');
	}

	public function delete(){
		$commentaire = new CommentaireModel($_GET['id']);
		$commentaire->delete();
		header('Location: ' . WEBROOT . 'admincommentaire/index');
	}
}