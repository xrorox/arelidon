<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'require.php');
 	
 	
 	$char = new char($idchar);

	
	$char->updateMore('points',100);

	
	header("Location:../../ingame.php?page=allopass&confirm_buy=1");
		

?>