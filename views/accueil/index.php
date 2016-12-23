<ul class="pagination">
    <li class="waves-effect <?php if($_GET['page']<=0){echo 'disabled';} ?>"><a href="<?php echo ($_GET['page']<=0)?'#':WEBROOT.'accueil/index?page='.($_GET['page']-1) ?>"><i class="material-icons">chevron_left</i></a></li>
    
<?php
    for($i=0; $i<=count($allArticles)/$limit; $i++)
    { 
?>
        <li class="waves-effect <?php echo ($_GET['page']==$i)?'active':''; ?>"><a href="<?php echo WEBROOT.'accueil/index?page='.$i ?>"><?php echo $i+1; ?></a></li>
<?php 
    } 
?>

    <li class="waves-effect"><a href="<?php echo WEBROOT.'accueil/index?page='.($_GET['page']+1) ?>"><i class="material-icons">chevron_right</i></a></li>
</ul>

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
	<?php foreach($articles as $article){ ?>
		<tr>
		    <td><img src="<?php echo (file_exists(ROOT.'upload/articleCovers/mini_'.$article['id'].'_cover.jpg'))?WEBROOT.'upload/articleCovers/mini_'.$article['id'].'_cover.jpg':WEBROOT.'upload/articleCovers/mini_default_cover.jpg'; ?>" alt="Miniature de la photo de couverture"></td>
			<td><a href="<?php echo WEBROOT.'article/detail?id='.$article['id'] ?>"><?php echo $article['titre'] ?></a></td>
			<td><?php echo $article['datetime'] ?></td>
            <td><a href="<?php echo WEBROOT.'user/detail?id='.$article['author']['id'] ?>"><?php echo $article['author']['name'] ?></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>