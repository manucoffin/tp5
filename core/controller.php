<?php

class Controller{
	public $vars = array('menu'=>array('accueil'=>'Accueil', 'adminarticle'=>'Articles', 'admincommentaire'=>'Commentaires', 'adminuser'=>'Users'));

	function set($d){
		$this->vars = array_merge($this->vars, $d);
	}

	function render($view){
        //remove the "controller" part of the class name
		$controller = strtolower(substr(get_class($this), 0, -10));
        extract($this->vars); // this extract the array so that we can use $menu afterwards
        
        // set title for each page
        switch ($controller) {
            case 'adminarticle':
                $pageName = "Articles";
                break;
            case 'adminuser':
                $pageName = "Utilisateurs";
                break;
            case 'admincommentaire':
                $pageName = "Commentaires";
                break;
            case 'accueil':
                $pageName = "Accueil";
                break;
        }
        
        // Header
        require(ROOT.'views/header.php');
        
		// Main content
		if(file_exists(ROOT.'views/'.$controller.'/'.$view.'.php')){
			require(ROOT.'views/'.$controller.'/'.$view.'.php');
		}else{
			echo '404 - view not found';
			die();
		}
        
        // et un footer ici
	}
}