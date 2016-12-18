<h1>Administration</h1>

<h2>Liste des commentaire</h2>

<table>
	<tr>
		<th>Titre</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	<?php foreach($commentaires as $commentaire){ ?>
		<tr>
			<td><?php echo $commentaire->titre ?></td>
			<td><?php echo $commentaire->datetime ?></td>
			<td>
				<a href="<?php echo WEBROOT.'admincommentaire/delete?id='.$commentaire->id ?>">Supprimer</a>
			</td>
		</tr>
	<?php } ?>
</table>