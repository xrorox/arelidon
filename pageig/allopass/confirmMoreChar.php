<?php
/*
 * Created on 13 mai 2010
 */
 	require_once($server.'require.php');
 
	$sql = "UPDATE users SET moreChar = 1 WHERE id = ".$char->getIdaccount();
	loadSqlExecute($sql);
	
	header("Location:../ingame.php?page=allopass&action=end");
?>
