<?php
if(isset($user))
{
?>
    <h2>Bienvenue, <?php echo $user->name; ?>.</h2>
    
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3"><a href="#modify">Modifier mes infos</a></li>
                <li class="tab col s3"><a class="active" href="#articles">Voir mes articles</a></li>
            </ul>
        </div>
    </div>
    
    <section id="modify">
        <?php include ROOT.'views/adminuser/createedit.php' ?>
    </section>
    
    <section id="articles">
        <table class="striped centered">

            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
            <?php foreach($user_articles as $article){
                ?>
                <tr>
                    <td><?php echo $article['titre'] ?></td>
                    <td><?php echo $article['datetime'] ?></td>
                    <td><a href="<?php echo WEBROOT.'article/detail?id='.$article['id'] ?>">Voir l'article</a></td>
                </tr>
            <?php } ?>

            </tbody>

        </table>
    </section>

<?php
}
else
{
?>

<div class="row">
    <div class="col s12">
        <ul class="tabs">
            <li class="tab col s3"><a href="#connexion">Se connecter</a></li>
            <li class="tab col s3"><a class="active" href="#register">Créer un compte</a></li>
        </ul>
    </div>
    <div id="connexion" class="col s12"><?php include 'connexionForm.php'; ?></div>
    <div id="register" class="col s12"><?php include 'registerForm.php'; ?></div>
</div>

<?php
}

