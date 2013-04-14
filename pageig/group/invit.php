<?php
 
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'require.php');
 
 $char = unserialize($_SESSION['char']);
 $group = new group($char);

 if ($group->sendInvitation($_GET['char_id'])){
 	echo 'L\'invitation a bien &eacute;t&eacute; envoy&eacute; au joueur';
 }
 else{
 	echo 'Le joueur est d&eacute;j&agrave; en groupe ou a trop de niveaux d\'&eacute;carts.';
 }
?>
