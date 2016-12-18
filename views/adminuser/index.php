<h1>Administration</h1>

<h2>Liste des users</h2>
<a href="<?php echo WEBROOT.'adminuser/createedit' ?>">Ajouter un utilisateur</a><br />
<table>
	<tr>
		<th>Name</th>
		<th>Email</th>
		<th>Statut</th>
		<th>Admin/Visiteur</th>
		<th>Action</th>
	</tr>
	<?php foreach($users as $user){ ?>
		<tr>
		    <td><img src="<?php echo WEBROOT.'upload/profilePics/'.$user->id.'_profile.jpg' ?>" alt="profile picture"></td>
			<td><?php echo $user->name ?></td>
			<td><?php echo $user->email ?></td>
			<td><?php echo $user->actif?'Actif':'Inactif' ?></td>
			<td><?php echo $user->admin?'Admin':'Visiteur' ?></td>
			<td>
				<a href="<?php echo WEBROOT.'adminuser/createedit?id='.$user->id ?>">Modifier</a>
				<a href="<?php echo WEBROOT.'adminuser/delete?id='.$user->id ?>">Supprimer</a>
			</td>
		</tr>
	<?php } ?>
</table>