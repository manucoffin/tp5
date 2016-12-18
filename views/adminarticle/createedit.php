<h1>Administration</h1>
<ul>
	<?php foreach($menu as $key=>$m){ ?>
		<li><a href="<?php echo WEBROOT.$key.'/index' ?>"><?php echo $m ?></a></li>
	<?php } ?>
</ul>
<h2>Edition/création d'articles</h2>

<form action="<?php echo WEBROOT.'adminarticle/postprocess?id='.$article->id ?>" method="post">
	<label for="titre">Titre :</label><input type="text" id="titre" name="titre" value="<?php echo $article->titre ?>" /><br />
	<label for="contenu">Contenu :</label><br />
	<textarea id="contenu" name="contenu"><?php echo $article->contenu ?></textarea><br />
	<label for="auteur">Auteur :</label>
	<select id="auteur" name="auteur">
		<?php foreach($users as $user){ ?>
			<option value="<?php echo $user->id ?>" <?php echo $user->id == $article->id_user?'selected':'' ?>><?php echo $user->name ?></option>
		<?php } ?>
	</select><br />
	<input type="submit" value="Enregistrer" />
</form>