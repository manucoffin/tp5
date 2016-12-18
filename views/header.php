<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageName ?></title>
</head>
<body>
    <h1><?php echo $pageName; ?></h1>
    <nav>
        <ul>
            <?php foreach($menu as $key=>$m){ ?>
                <li><a href="<?php echo WEBROOT.$key.'/index' ?>"><?php echo $m ?></a></li>
            <?php } ?>
        </ul>
    </nav>