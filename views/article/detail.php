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
                <span>
                    <img src="<?php echo (file_exists(ROOT.'upload/profilePics/'.$author['id'].'_profile.jpg'))?WEBROOT.'upload/profilePics/'.$author['id'].'_profile.jpg':WEBROOT.'upload/profilePics/anon_50.png'; ?>" alt="Miniature de la photo de profil">
                    <strong><a href="<?php echo WEBROOT.'user/detail?id='.$author['id'] ?>"><?php echo $author['name'] ?></a></strong> 
                    a publié cet article le <?php echo $article->datetime ?>
                </span>
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

