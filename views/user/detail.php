<div class="col s12 m7">
    <div class="card horizontal">
        <div class="card-image">
            <img src="<?php echo (file_exists(ROOT.'upload/profilePics/'.$user->id.'_500.jpg'))?WEBROOT.'upload/profilePics/'.$user->id.'_500.jpg':WEBROOT.'upload/profilePics/anon_500.png'; ?>" alt="photo de profil">
        </div>
        <div class="card-stacked">
            <div class="card-content">
                <h2><?php echo $user->name ?></h2>
                <p>Ce profil a été vu <?php echo $user->visits+1 ?> fois.</p>
                <br>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque assumenda autem est commodi alias sint, suscipit sapiente, a obcaecati ipsam amet quam saepe illo. Quae repudiandae porro quibusdam nulla deleniti.</p>
            </div>
            <div class="card-action">
                <span>Me contacter : <a href="mailto:<?php echo $user->email ?>"><?php echo $user->email ?></a></span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <ul class="tabs">
            <li class="tab col s6"><a class="active" href="#articles">Voir ses articles</a></li>
            <li class="tab col s6"><a href="#commented">Voir ceux qu'il a commenté</a></li>
        </ul>
    </div>
</div>

<section id="articles">
    <table class="striped centered">
        <thead>
            <tr>
                <th></th>
                <th>Titre</th>
                <th>Date</th>
                <th>Nombre de commentaires</th>
            </tr>
        </thead>
        
        <tbody>
        <?php foreach($articles as $article){ ?>
            <tr>
                <td><img src="<?php echo (file_exists(ROOT.'upload/articleCovers/mini_'.$article['id'].'_cover.jpg'))?WEBROOT.'upload/articleCovers/mini_'.$article['id'].'_cover.jpg':WEBROOT.'upload/articleCovers/mini_default_cover.jpg'; ?>" alt="Miniature de la photo de couverture"></td>
                <td><a href="<?php echo WEBROOT.'article/detail?id='.$article['id'] ?>"><?php echo $article['titre'] ?></a></td>
                <td><?php echo $article['datetime']; ?></td>
                <td><?php echo count($article['comments']); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</section>


<section id="commented">
    <table class="striped centered">
        <thead>
            <tr>
                <th></th>
                <th>Titre</th>
                <th>Date</th>
                <th>Auteur</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach($articleCommented as $article){ ?>
            <tr>
                <td><img src="<?php echo (file_exists(ROOT.'upload/articleCovers/mini_'.$article['id'].'_cover.jpg'))?WEBROOT.'upload/articleCovers/mini_'.$article['id'].'_cover.jpg':WEBROOT.'upload/articleCovers/mini_default_cover.jpg'; ?>" alt="Miniature de la photo de couverture"></td>
                <td><a href="<?php echo WEBROOT.'article/detail?id='.$article['id'] ?>"><?php echo $article['titre'] ?></a></td>
                <td><?php echo $article['datetime']; ?></td>
                <td><?php echo $article['author']['name'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</section>