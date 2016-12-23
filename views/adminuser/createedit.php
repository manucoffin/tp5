<h2>Modifier les informations :</h2>

<form action="<?php echo WEBROOT.'adminuser/postprocess?id='.$user->id ?>" method="post" enctype="multipart/form-data">
    <div class="input-field">
        <label for="name">Pseudonyme :</label>
        <input type="text" id="name" name="name" value="<?php echo $user->name ?>" /><br />
	</div>
	
	<div class="input-field">
        <label for="email">Email :</label>
        <input type="text" id="email" name="email" value="<?php echo $user->email ?>" /><br />
    </div>
    
    <div class="input-field">
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" value="" /><br />
    </div>
    
	<?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']){ ?>
	
	<label for="actif">Actif :</label>
	<input type="radio" id="actif" name="actif" value="1" <?php echo ($user->actif)?'checked':'' ?> /><label for="actif">Oui</label>
	<input type="radio" id="actif_non" name="actif" value="0" <?php echo ($user->actif)?'':'checked' ?> /><label for="actif_non">Non</label>
	<br />
	<label for="admin">Admin :</label>
	<input type="radio" id="admin" name="admin" value="1" <?php echo ($user->admin)?'checked':'' ?> /><label for="admin">Oui</label>
	<input type="radio" id="admin_non" name="admin" value="0" <?php echo ($user->admin)?'':'checked' ?> /><label for="admin_non">Non</label>
	<br />
	
	<?php } ?>
	
    <div class="file-field input-field">
        <div class="btn">
            <span>Photo de profil</span>
            <input type="file" name="photo">
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>
    </div>
    
    <br>
<!--    Profile Picture: <input type="file" name="photo"><br />-->

	<button class="btn waves-effect waves-light" type="submit" name="modify-form">Enregistrer
        <i class="material-icons right">send</i>
    </button>
</form>