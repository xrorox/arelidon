<?php
if(!empty($_GET['refresh']))
{
	require('../../../require.php');
	require_once('../../../class/fight/Fight.class.php');

	$char=unserialize($_SESSION['char']);

	$fight_id = $_GET['fight_id'];
	
	$fight = new Fight($fight_id);
}

/* need fixed */

$time = $fight->getTurnTimer() - time();

if($time < 0)
	echo 0;
else 
	echo $time;

