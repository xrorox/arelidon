<?php

require_once('../require.php');

$sql = "SELECT * FROM `char` ";

$chars = loadSqlResultArrayList($sql);



foreach($chars as $char)
{
	$sql2 = "INSERT INTO `skillonchar` (`skill_id` ,`char_id` ,`level`)VALUES ('1', '".$char['id']."', '1');";
	loadSqlExecute($sql2);
	
	$sql3 = "INSERT INTO `skill_shortcut` (`num` ,`char_id` ,`skill_id`)VALUES ('1', '".$char['id']."', '1');";
	loadSqlExecute($sql3);
	
}