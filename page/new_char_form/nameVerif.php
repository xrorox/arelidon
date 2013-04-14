<?php

if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'require.php');


$sql ="SELECT count(*) FROM `char` WHERE `name` = '".$_GET['name']."'";
$free = loadSqlResultArray($sql); // 1 = no , 0 = yes	

if ($free['count(*)'] == 0 && $lenght <= 16) 
{
	echo "V";
}
else 
{
	echo "X";
}