<?php

require_once('../require.php');

$sql = "SELECT * FROM `char` ";

$chars = loadSqlResultArrayList($sql);

$sql2 = "UPDATE `char` SET level = '1',aexp = '300',exp = '0',vip = '0',guild_id = '0',honnor = '0',guild_rank='0',
							kills = '0',deaths = '0', pa ='0',pp = '0',gold = '0',boostpoint = '0',skillpoint = '0',
							str = '2',con = '2',dex = '2',`int` = '2',sag = '2',res = '2',cha = '2',
							astr = '0',acon = '0',adex = '0',`aint` = '0',asag = '0',ares = '0',acha = '0',
							life = '12', mana = '7', time_die = '0' ";

loadSqlExecute($sql2);


foreach($chars as $char)
{
	$sql3 = "DELETE FROM `char_move` WHERE char_id = '".$char['id']."'";
	loadSqlExecute($sql3);
	
		
	// Insertion du char_move
	$faction = new faction($char['faction']);
		
	$sql4 = "INSERT INTO `char_move` (`char_id` ,`abs` ,`ord` ,`face` ,`map`) 
			VALUES ('".$char['id']."', '".$faction->getAbs()."', '".$faction->getOrd()."', '3', '".$faction->getMap()."');";
	loadSqlExecute($sql4);	
	
	echo 'char : '.$char['id'].'<br />';
	
}