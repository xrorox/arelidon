<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'require.php');
	require_once('../class/tchat.class.php');
	$user = new user;
	$user->loadUser($login);
	
	$char = new char;
	$char->loadChar($idchar);	
	
	$tchat = new tchat();
	$tchat->swapChannel($char->getId(),$_GET['channel']);
?>
