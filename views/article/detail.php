<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-image">
                <img src="<?php echo (file_exists(ROOT.'upload/articleCovers/'.$article->id.'_cover.jpg'))?WEBROOT.'upload/articleCovers/'.$article->id.'_cover.jpg':WEBROOT.'upload/articleCovers/default_cover.jpg'; ?>" alt="Photo de couverture">
                <span class="card-title"><?php echo $article->titre ?></span>
            </div>
           
            <div class="card-content">
                <p><?php echo $article->contenu ?></p>
                <hr>
                <div class="row">
                    <div class="col s8">
                        <img class="left" src="<?php echo (file_exists(ROOT.'upload/profilePics/'.$author['id'].'_profile.jpg'))?WEBROOT.'upload/profilePics/'.$author['id'].'_profile.jpg':WEBROOT.'upload/profilePics/anon_50.png'; ?>" alt="Miniature de la photo de profil">
                        <strong><a href="<?php echo WEBROOT.'user/detail?id='.$author['id'] ?>"><?php echo $author['name'] ?></a></strong> 
                        a publié cet article le <?php echo $article->datetime ?>
                        <br>
                        <span class="">Cet article a été visité <?php echo $article->visits+1 ?> fois.</span>
                    </div> 

                    <div class="col s4">
                    <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){ ?>
                        <span class="card-title activator right">Partager <i class="material-icons">share</i></span>
                    <?php } ?>
                    </div>
                </div>
            </div>
               
            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4">Partager par email<i class="material-icons right">close</i></span>

                <form action="<?php echo WEBROOT.'article/shareByEmail?articleId='.$article->id ?>" method="post" class="">
                    <div class="input-field">
                        <label for="dest">Destinataire</label>
                        <input type="email" name="dest">
                    </div>
                    <input type="hidden" value="<?php echo $article->titre ?>" name="title">
                    <input type="hidden" value="<?php echo $article->contenu ?>" name="content">
                    <input type="hidden" value="<?php echo $author['name'] ?>" name="author">
                    <input type="hidden" value="<?php echo $_SESSION['user_id'] ?>" name="sender">
                    <div class="">
                        <button class="btn waves-effect waves-light" type="submit" name="share-form">Envoyer
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>    
                
            
        </div>
    </div>
</div>

<section class="row">
    <h3>Commentaires</h3>
    <?php 
    foreach($comments as $com){
    ?>
    <div class="row">
        <div class="col s12">
            <div class="card #eceff1 blue-grey lighten-5">
                <div class="card-content">
                    <span class="card-title"><?php echo $com['titre'] ?></span>
                    <p><?php echo $com['contenu'] ?></p>
                    <hr>
                    <p>Publié le <?php echo $com['datetime'] ?> par <strong><a href="<?php echo WEBROOT.'user/detail?id='.$com['author']['id'] ?>"><?php echo $com['author']['name'] ?></a></strong></p>
                </div>
            </div>
        </div>
    </div>
    <?php    
    } 
    ?>  
</section>

<?php require(ROOT.'views/admincommentaire/createedit.php');

