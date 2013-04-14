<?php

if (isset($_POST["name"])){
	$id=char::getIdByName($_POST['name']);
	$sql="INSERT mute SET char_id=1, target=".$id;
	loadSqlExecute($sql);
	
	pre_dump("Il est mute !!!");
}

if (isset($_POST['login2'])){
	$id=char::getIdByName($_POST['login2']);
	$sql="UPDATE char_move SET map=".$_POST['map'].",abs=".$_POST['abs'].",ord=".$_POST['ord']." WHERE char_id=".$id;
	loadSqlExecute($sql);
}

?>

<form method="post" action="panneauAdmin.php?category=22">
	<p>
		<label for="name"> Nom du joueur à mettre en mute </label>
		<input type="text" id="name" name="name"/>
		<input type="submit" value="Mute"/>
	</p>
</form>

<br/>
<br/>
<fieldset>
	<legend> Deplacement d'un joueur</legend>
	<form method="post" action="panneauAdmin.php?category=22">
	<p>
		<label for="login2"> Nom du joueur à deplacer </label>
		<input type="text" id="login2" name="login2"/>
		<br/>
		<label for="map"> map </label>
		<input type="text" id="map" name="map"/>
		<br/>
		<label for="map"> abs </label>
		<input type="text" id="abs" name="abs"/>
		<br/>
		<label for="map"> ord </label>
		<input type="text" id="ord" name="ord"/>
		<br/>
		<input type="submit" value="deplacez"/>
	</p>
</form>
</fieldset>