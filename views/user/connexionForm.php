<form action="<?php echo WEBROOT.'user/postprocess' ?>" method="post">
    <?php 
    if(isset($_GET['conn']) && $_GET['conn']=='failure')
    {
    ?>
        <span class="alert red">Login et/ou Mot de passe incorrect.</span>
    <?php
    } ?>
    <div class="input-field">
        <label for="username">Pseudo : </label>
        <input name="username" type="text">
    </div>
    <div class="input-field">
        <label for="password">Mot de passe : </label>
        <input name="password" type="password">
    </div>
    <input class="btn" type="submit" name="signin-form" value="Se connecter">
</form>