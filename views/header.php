<?php //session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageName ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script>
        $(window).load(function(){ 
            $('ul.tabs').tabs();
            $('select').material_select();
        });
    </script>
    
    <style>
        h1{
            text-align: center;
            width: 100%;
        }
        
        .alert{
            width: 100%;
            height: 50px;
            line-height: 50px;
            color: white;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    if(isset($_GET['register']) && $_GET['register'] == 'success'){ 
    ?>
        <span class="alert light-green">Votre inscription a bien été prise en compte. Vous pouvez désormais <a href="<?php echo WEBROOT.'user/index' ?>">vous connecter</a></span>
    <?php } ?>
    <nav>
        <ul class="container">
            <?php 
            foreach($menu as $key=>$m){ 
                if($key != "user"){ 
            ?>
                    <li><a href="<?php echo WEBROOT.$key.'/index' ?>"><?php echo $m ?></a></li>
                <?php 
                } 
                else
                {
                    if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
                    ?>
                        <li><a href="<?php echo WEBROOT.$key.'/index' ?>"><?php echo $m ?></a></li>
                    <?php
                    }
                    else
                    {
                    ?>
                        <li><a href="<?php echo WEBROOT.$key.'/index' ?>">Connexion</a></li>
                    <?php
                    }
                } 
                ?>
            <?php 
            } 
            
            if(isset($_SESSION['is_admin'])){ ?>
                <li class="right"><a class="" href="<?php echo WEBROOT.'user/disconnect' ?>">Me déconnecter</a></li>
            <?php } ?>
        </ul>
    </nav>
    
    <h1><?php echo $pageName; ?></h1>
    <div class="container">