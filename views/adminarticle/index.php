<a class="btn waves-effect waves-light" href="<?php echo WEBROOT.'adminarticle/exportArticlesCSV' ?>">
    <i class="material-icons right">file_download</i>
    Télécharger les articles
</a>
   
<ul class="pagination">
    <li class="waves-effect <?php if($_GET['page']<=0){echo 'disabled';} ?>"><a href="<?php echo ($_GET['page']<=0)?'#':WEBROOT.'adminarticle/index?page='.($_GET['page']-1) ?>"><i class="material-icons">chevron_left</i></a></li>
    
<?php
    for($i=0; $i<=count($allArticles)/$limit; $i++)
    { 
?>
        <li class="waves-effect <?php echo ($_GET['page']==$i)?'active':''; ?>"><a href="<?php echo WEBROOT.'adminarticle/index?page='.$i ?>"><?php echo $i+1; ?></a></li>
<?php 
    } 
?>

    <li class="waves-effect"><a href="<?php echo WEBROOT.'adminarticle/index?page='.($_GET['page']+1) ?>"><i class="material-icons">chevron_right</i></a></li>
</ul>

<?php if(isset($_SESSION['user_id'])){ ?>
<a class="btn" href="<?php echo WEBROOT.'adminarticle/createedit' ?>">Ajouter un article</a><br />
<?php } ?>

<table class="striped centered">

    <thead>
        <tr>
            <th></th>
            <th>Titre</th>
            <th>Date</th>
            <th>Auteur</th>
            <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']){ ?>
            <th>Action</th>
            <?php } ?>
        </tr>
	</thead>
	
	<tbody>
	<?php foreach($articles as $article){ ?>
		<tr>
		    <td><img src="<?php echo (file_exists(ROOT.'upload/articleCovers/mini_'.$article['id'].'_cover.jpg'))?WEBROOT.'upload/articleCovers/mini_'.$article['id'].'_cover.jpg':WEBROOT.'upload/articleCovers/mini_default_cover.jpg'; ?>" alt="Miniature de la photo de couverture"></td>
			<td><a href="<?php echo WEBROOT.'article/detail?id='.$article['id'] ?>"><?php echo $article['titre'] ?></a></td>
			<td><?php echo $article['datetime'] ?></td>
			<td><a href="<?php echo WEBROOT.'user/detail?id='.$article['author']['id'] ?>"><?php echo $article['author']['name'] ?></a></td>
			<?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']){ ?>
			<td>
				<a class="material-icons" href="<?php echo WEBROOT.'adminarticle/createedit?id='.$article['id'] ?>">mode_edit</a>
				<a class="material-icons" href="<?php echo WEBROOT.'adminarticle/delete?id='.$article['id'] ?>">delete</a>
			</td>
            <?php } ?>
            
		</tr>
	<?php } ?>
	</tbody>
</table>