<h1><?=$title?></h1>
 
<?php foreach ($users as $user) : ?>
<p>
	<?php $thisUser = $user->getProperties(); ?>
	<i>ID:</i> <?=$thisUser['id']?><br>
	<i>Acronym:</i> <?=$thisUser['acronym']?><br>
	<i>Email:</i> <?=$thisUser['email']?><br>
	<i>Name:</i> <?=$thisUser['name']?><br>
	<i>Created:</i> <?=$thisUser['created']?><br>
	<i>Active:</i> <?=$thisUser['active']?><br>
	<?php 
	if($thisUser['updated'])
	{
		echo "<i>Updated: </i>" . $thisUser['updated'] . "<br>";
	}

	if($thisUser['deleted'])
	{
		echo "<i>Deleted: </i>" . $thisUser['deleted'] . "<br>";
	}
	?>

</p>

<?php endforeach; ?>
 