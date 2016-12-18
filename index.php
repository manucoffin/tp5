<?php

//on définit les constantes qui nous permettrons d'inclure nos fichier n'importe où
define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));

if (in_array('mod_rewrite', apache_get_modules())) {
    echo "Yes, Apache supports mod_rewrite.";
}

else {
    echo "Apache is not loading mod_rewrite.";
}

//on inclu le coeur de notre MVC
require(ROOT . 'core/core.php');
require(ROOT . 'core/controller.php');
require(ROOT . 'core/model.php');

//Si on a une url du type www.monsite.com/controller/action on récupère le controller et l'action
if(isset($_GET['p']) && !empty($_GET['p']))
{
	$param = explode('/', $_GET['p']);
	$controller = $param[0];
    
    if(isset($param[1]) && !empty($param[1]) )
    {
        $action = $param[1];
    }
    else
    {
        $action = "index";
    }
}
else
{
	//sinon on défini un controller et une action par défaut
	$controller = 'Accueil';
	$action = 'index';
}

$controller .= 'Controller';

//on instancie notre controller, $controller est une variable nommée qui vaudra par exemple AccueilControlelr, ça reviendrai donc à faire new AccueilController
$cont = new $controller();

if(method_exists($controller, $action)){
	//comme pour le controlleur, l'action est une variable nommée, ça équivaut à faire $cont->index(); par exemple
	$cont->$action();
}else{
	echo '404 - method not found';
	die();
}