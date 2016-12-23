<form action="<?php echo WEBROOT.'adminarticle/postprocess?id='.$article->id ?>" method="post" enctype="multipart/form-data">
    <legend><?php echo (!empty($article))?'Modifier l\'article':'Écrire un article'; ?></legend>
	
	<div class="input-field">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" value="<?php echo $article->titre ?>" />
	</div>
	<br />
	<div class="input-field">
        <label for="contenu">Contenu :</label><br />
        <textarea class="materialize-textarea" id="contenu" name="contenu"><?php echo $article->contenu ?></textarea><br />
    </div>
	<?php 
    if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']){ 
    ?>
	
	<div class="input-field col s12">
        <select id="auteur" name="auteur" >
            <option value="" disabled selected>Choisissez un auteur</option>
            <?php foreach($users as $user){ p($user); ?>
                <option value="<?php echo $user['id'] ?>" <?php echo $user['id'] == $article->id_user?'selected':'' ?>><?php echo $user['name'] ?></option>
            <?php } ?>
        </select>
        <label>Auteurs</label>
    </div>

	<br />
	<?php 
    } 
    else
    {
    ?>
    <input name="auteur" type="hidden" readonly='readonly' value="<?php echo $_SESSION['user_id'] ?>">
    <?php
    }
    ?>

    <div class="file-field input-field">
        <div class="btn">
            <span>Photo de couverture</span>
            <input type="file" name="cover">
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>
    </div>
    
    <br />
    
	<button class="btn waves-effect waves-light" type="submit" name="comment-form">Enregistrer
        <i class="material-icons right">send</i>
    </button>
</form>


<script>
    $("#auteur").material_select();
</script>