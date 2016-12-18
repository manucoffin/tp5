<form action="<?php echo WEBROOT.'accueil/postprocess' ?>" method="post">
    <legend>Connexion</legend>
    <label for="username">Pseudo : </label>
    <input name="username" type="text">
    <label for="password">Mot de passe : </label>
    <input name="password" type="password">
    <input type="submit" name="signin-form" value="Se connecter">
</form>

<form action="<?php echo WEBROOT.'accueil/postprocess' ?>" method="post">
    <legend>Inscription</legend>
    <label for="mail">Adresse mail : </label>
    <input name="mail" type="email">
    <label for="username">Pseudo : </label>
    <input name="username" type="text">
    <label for="password">Mot de passe : </label>
    <input name="password" type="password">
    <label for="password">Vérification du mot de passe : </label>
    <input name="password" type="password">
    <input type="submit" name="register-form" value="S'enregistrer">
</form>



<h2>Les derniers articles</h2>

<table>
	<tr>
		<th>Titre</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
    <?php foreach($articles as $article){ ?>
        <tr>
            <td><a href="<?php echo WEBROOT.'article/detail?id='.$article->id ?>"><?php echo $article->titre ?></a></td>
            <td><?php echo $article->datetime ?></td>
            <td>TODO</td>
        </tr>
    
    <?php } ?>
</table>