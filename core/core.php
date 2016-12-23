<?php

define('DEBUG', true);

if(DEBUG){
	error_reporting(-1);
	ini_set('display_errors', '1');
}

//DATABASE
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_DATABASE', 'filrouge');

//include automatique des classes
//cette fonction sera appelée à chaque new MaClasse si MaClasse n'a pas déjà été incluse
spl_autoload_register(function ($class) {
	if(preg_match("/[a-zA-Z0-9\_]+Controller$/", $class))
    {
		//remove the "controller" part of the class name
		$controller = ucfirst(substr($class, 0, -10));
		if(file_exists(ROOT.'controllers/' . $controller . '.php'))
			require ROOT.'controllers/' . $controller . '.php';
		else
        {
			echo '404 - Controller ' . $class . ' not found';
			die();
		}
	}
    else if(preg_match("/[a-zA-Z0-9\_]+Observer$/", $class))
    {
		//remove the "controller" part of the class name
		$observer = ucfirst(substr($class, 0, -8));
		if(file_exists(ROOT.'observers/' . $observer . '.php'))
			require ROOT.'observers/' . $observer . '.php';
		else
        {
			echo '404 - Observer ' . $class . ' not found';
			die();
		}
	}
    else if(preg_match("/[a-zA-Z0-9\_]+Model$/", $class)){
		//remove the "controller" part of the class name
		$model = substr($class, 0, -5);
		if(file_exists(ROOT.'models/' . $model . '.php'))
			require ROOT.'models/' . $model . '.php';
		else
        {
			echo '404 - Model ' . $class . ' not found';
			die();
		}
	}
});

function p($data = null)
{
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}
function d($data = null)
{
	p($data);
	die();
}
