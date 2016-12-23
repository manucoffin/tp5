<a class="btn waves-effect waves-light" href="<?php echo WEBROOT.'admincommentaire/exportCommentsCSV' ?>">
    <i class="material-icons right">file_download</i>
    Télécharger les commentaires
</a>   

<ul class="pagination">
    <li class="waves-effect <?php if($_GET['page']<=0){echo 'disabled';} ?>"><a href="<?php echo ($_GET['page']<=0)?'#':WEBROOT.'admincommentaire/index?page='.($_GET['page']-1) ?>"><i class="material-icons">chevron_left</i></a></li>
    
<?php
    for($i=0; $i<=count($allComments)/$limit; $i++)
    { 
?>
        <li class="waves-effect <?php echo ($_GET['page']==$i)?'active':''; ?>"><a href="<?php echo WEBROOT.'admincommentaire/index?page='.$i ?>"><?php echo $i+1; ?></a></li>
<?php 
    } 
?>

    <li class="waves-effect"><a href="<?php echo WEBROOT.'admincommentaire/index?page='.($_GET['page']+1) ?>"><i class="material-icons">chevron_right</i></a></li>
</ul>


<table class="striped centered">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Date</th>
            <th>Auteur</th>
            <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']){ ?>
            <th>Action</th>
            <?php } ?>
        </tr>
	</thead>
	
	<tbody>
	<?php foreach($comments as $com){ ?>
		<tr>
			<td><?php echo $com['titre'] ?></td>
			<td><?php echo $com['datetime'] ?></td>
			<td><a href="<?php echo WEBROOT.'user/detail?id='.$com['author']['id'] ?>"><?php echo $com['author']['name'] ?></a></td>

			<?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']){ ?>
			<td>
				<a class="material-icons" href="<?php echo WEBROOT.'admincommentaire/createedit?id='.$com['id'] ?>">mod_edit</a>
				<a class="material-icons" href="<?php echo WEBROOT.'admincommentaire/delete?id='.$com['id'] ?>">delete</a>
			</td>
            <?php } ?>
		</tr>
	<?php } ?>
	</tbody>
</table>