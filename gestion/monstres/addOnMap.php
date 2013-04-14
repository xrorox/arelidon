<?php
/*
 * Created on 15 sept. 2009
 *


 */
 
 
 if($_GET['add'] == 1)
 {
 	$monster = new monster($_POST['idmstr'],'idmstr');
 	$monster->addMonsterOnMap($_POST['abs'],$_POST['ord'],$_POST['map']);
 }
 
 echo '<div style="text-align:center;">';
	echo '<div style="text-align:left;margin-left:260px;border:solid 1px white;width:250px;">';

	echo '<div style="margin-20px;">';
	echo '<div style="text-align:center;font-weight:700;"> Ajouter une image sur le serveur </div><br />';
	$arrayMonster = monster::getAllMonsters();
	echo '<form method="post" action="panneauAdmin.php?category=6&add=1&norefresh=1">
	 Monstre : <select name="idmstr" />';
	$arrayMonster = monster::getAllMonsters();
	foreach($arrayMonster as $monster)
	{
		echo '<option value="'.$monster['id'].'">'.$monster['nom'].'</option>';
	}
	echo '</select><br />';
echo 'abs : <input type="text" name="abs" size="3" /><br />' .
	 'ord : <input type="text" name="ord" size="3" /><br />' .
	 'carte : <input type="text" name="map" size ="3" /><br />' .
	   		'<div style="text-align:center;"><input type="submit" value="ajouter le monstre" /></div>
	</form>';
	echo '</div>';
	echo '</div>';
	
?>
