<h1>Administration</h1>
<ul>
	<?php foreach($menu as $key=>$m){ ?>
		<li><a href="<?php echo WEBROOT.$key.'/index' ?>"><?php echo $m ?></a></li>
	<?php } ?>
</ul>
<h2>Edition/création d'utilisateurs</h2>

<form action="<?php echo WEBROOT.'adminuser/postprocess?id='.$user->id ?>" method="post" enctype="multipart/form-data">
	<label for="name">Name :</label><input type="text" id="name" name="name" value="<?php echo $user->name ?>" /><br />
	<label for="email">Email :</label><input type="text" id="email" name="email" value="<?php echo $user->email ?>" /><br />
	<label for="password">Mot de passe :</label><input type="password" id="password" name="password" value="" /><br />
	<label for="actif">Actif :</label>
	<input type="radio" id="actif" name="actif" value="1" <?php echo ($user->actif)?'checked':'' ?> /><label for="actif">Oui</label>
	<input type="radio" id="actif_non" name="actif" value="0" <?php echo ($user->actif)?'':'checked' ?> /><label for="actif_non">Non</label>
	<br />
	<label for="admin">Admin :</label>
	<input type="radio" id="admin" name="admin" value="1" <?php echo ($user->admin)?'checked':'' ?> /><label for="admin">Oui</label>
	<input type="radio" id="admin_non" name="admin" value="0" <?php echo ($user->admin)?'':'checked' ?> /><label for="admin_non">Non</label>
	<br />
	
    Profile Picture: <input type="file" name="photo"><br />

	<input type="submit" value="Enregistrer" />
</form>