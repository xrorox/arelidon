<?php

// Convert Monster For Dungeon

/*
 * 
 * Notice : 
 * 
 * Utiliser pour transférer des monstres de monsteronmap , dans monster_donjon 
 * afin qu'ils puissent être utilisé en instance de donjon
 */


require_once('class/connection.class.php');
require_once('require.php');


$sql = "SELECT * FROM monsteronmap mom 
JOIN mapworld mw ON mom.map = mw.id WHERE donjon_group_id = 0 and mw.room_id > 0  ";

$result = loadSqlResultArrayList($sql);

foreach($result as $new_monster)
{
	$sql = "INSERT INTO `monster_donjon` (`id` ,`idmstr` ,`room_id` ,`abs` ,`ord`)
	VALUES ('', '".$new_monster['idmstr']."', '".$new_monster['room_id']."', '".$new_monster['abs_base']."', '".$new_monster['ord_base']."');";

	loadSqlExecute($sql);
}