<a class="btn waves-effect waves-light" href="<?php echo WEBROOT.'adminuser/exportUsersCSV' ?>">
    <i class="material-icons right">file_download</i>
    Télécharger la liste des membres
</a>

<?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']){ ?>
<a class="btn" href="<?php echo WEBROOT.'adminuser/createedit' ?>">Ajouter un utilisateur</a><br />
<?php } ?>


<ul class="pagination">
    <li class="waves-effect <?php if($_GET['page']<=0){echo 'disabled';} ?>"><a href="<?php echo ($_GET['page']<=0)?'#':WEBROOT.'adminuser/index?page='.($_GET['page']-1) ?>"><i class="material-icons">chevron_left</i></a></li>
    
<?php
    for($i=0; $i<=count($allUsers)/$limit; $i++)
    { 
?>
        <li class="waves-effect <?php echo ($_GET['page']==$i)?'active':''; ?>"><a href="<?php echo WEBROOT.'adminuser/index?page='.$i ?>"><?php echo $i+1; ?></a></li>
<?php 
    } 
?>

    <li class="waves-effect"><a href="<?php echo WEBROOT.'adminuser/index?page='.($_GET['page']+1) ?>"><i class="material-icons">chevron_right</i></a></li>
</ul>

<table class="striped centered">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Email</th>
            <th>Nombre d'articles</th>
            <th>Nombre de commentaires</th>
            <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']){ ?>
            <th>Action</th>
            <?php } ?>
        </tr>
    </thead>
    
    <tbody>
	<?php foreach($users as $user){ ?>
		<tr>
        <?php 
        // File exists needs the path on server, not the url
        $src = (file_exists(ROOT.'upload/profilePics/'.$user['id'].'_profile.jpg'))?WEBROOT.'upload/profilePics/'.$user['id'].'_profile.jpg':WEBROOT.'upload/profilePics/anon_50.png';
        ?>
		    <td><img src="<?php echo $src ?>" alt="profile picture"></td>
			<td><a href="<?php echo WEBROOT.'user/detail?id='.$user['id'] ?>"><?php echo $user['name'] ?></a></td>
			<td><?php echo $user['email'] ?></td>
			<td><?php echo count($user['articles']) ?></td>
			<td><?php echo count($user['comments']) ?></td>
			<?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']){ ?>
			<td>
				<a class="material-icons" href="<?php echo WEBROOT.'adminuser/createedit?id='.$user['id'] ?>">mod_edit</a>
				<a class="material-icons" href="<?php echo WEBROOT.'adminuser/delete?id='.$user['id'] ?>">delete</a>
			</td>
			<?php } ?>
		</tr>
	<?php } ?>
	</tbody>
</table>