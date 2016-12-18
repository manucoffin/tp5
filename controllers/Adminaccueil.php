<?php
/** @todo sécuriser l'administration avec une connexion user */
class AdminAccueilController extends Controller{

	public function index(){
		$this->render('index');
	}
}