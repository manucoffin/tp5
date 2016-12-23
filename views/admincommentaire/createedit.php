<?php
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
{
?>    
<form action="<?php echo WEBROOT.'commentaire/postprocess?id='.$_GET['id'] ?>" method="post">
    <legend><?php echo (!empty($comment))?'Modifier le commentaire :':'Écrire un commentaire :'; ?></legend>
    <div class="input-field">
        <label for="title">Titre</label>
        <input type="text" name="title" value="<?php echo (!empty($comment))?$comment->titre:''; ?>">
    </div>
    <div class="input-field">
        <label for="content">Commentaire</label>
        <input type="text" name="content" value="<?php echo (!empty($comment))?$comment->contenu:''; ?>">
    </div>
    <input type="hidden" readonly="readonly" name="article_id" value="<?php echo $_GET['id'] ?>">
    <button class="btn waves-effect waves-light" type="submit" name="comment-form">Envoyer
        <i class="material-icons right">send</i>
    </button>
</form>
<?php  
}
else
{
    echo 'Vous devez être connecté pour poster un commentaire.';
}
?>