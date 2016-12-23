<form action="<?php echo WEBROOT.'user/postprocess' ?>" method="post">
    <?php
    if(isset($_GET['register']) && $_GET['register']=='mailErr')
    {
    ?>
        <span class="alert red">Cet email est déjà utilisé par un autre membre.</span>
    <?php
    } ?>
    <div class="input-field">
        <label for="mail">Adresse mail : </label>
        <input name="mail" type="email">
    </div>
    <?php
    if(isset($_GET['register']) && $_GET['register']=='nameErr')
    {
    ?>
        <span class="alert red">Ce nom d'utilisateur est déjà pris.</span>
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
    <?php
    if(isset($_GET['register']) && $_GET['register']=='pwdErr')
    {
    ?>
        <span class="alert red">Le deuxième mot de passe ne correspond pas.</span>
    <?php
    }
    ?>
    <div class="input-field">
        <label for="password-check">Vérification du mot de passe : </label>
        <input name="password-check" type="password">
    </div>
    
    <input class="btn" type="submit" name="register-form" value="S'enregistrer">
</form>