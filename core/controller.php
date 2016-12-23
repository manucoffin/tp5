<?php

class Controller{
	public $vars = array('menu'=>array('accueil'=>'Accueil', 'adminarticle'=>'Articles', 'admincommentaire'=>'Commentaires', 'adminuser'=>'Membres', 'user'=>'Profil'));

	function set($d){
		$this->vars = array_merge($this->vars, $d);
	}

	function render($view){
         
        session_start();
        
        //remove the "controller" part of the class name
		$controller = strtolower(substr(get_class($this), 0, -10));
        extract($this->vars); // this extract the array so that we can use $menu afterwards
        
        
        // First we include the header in which we do:
        //      - Start or restore session
        //      - Create the <html> and <head> tags
        //      - Create the main navigation
    
        // set title for each page
        switch ($controller) {
            case 'adminarticle':
                $pageName = "Articles";
                break;
            case 'adminuser':
                $pageName = "Membres";
                break;
            case 'admincommentaire':
                $pageName = "Commentaires";
                break;
            case 'accueil':
                $pageName = "Accueil";
                break;
            case 'user':
                $pageName = "Profil";
                break;
            default:
                $pageName = "";
        }
        
        require(ROOT.'views/header.php');
        
        
        // Then we include the content of the page
		
		if(file_exists(ROOT.'views/'.$controller.'/'.$view.'.php')){
			require(ROOT.'views/'.$controller.'/'.$view.'.php');
		}else{
			echo '404 - view not found';
			die();
		}
        
        // And a footer
        require(ROOT.'views/footer.php');
	}
}