<?php
/*
 * Created on 21 mai 2010
 */
 
 	// Vérification qu'on puisse acheter des PA
 require_once(absolutePathway().'class/connection.class.php'); 
	    require_once(absolutePathway().'utils/database.php');
	    require_once(absolutePathway().'utils/math.php');
	    require_once(absolutePathway().'utils/utils.php'); 
	    require_once(absolutePathway().'utils/fight.php');
 	require_once(absolutePathway().'savelog.inc.php');
 	require_once(absolutePathway().'class/char.class.php');
 
$char = new char($idchar); 
 
$vip = $char->vip;

if($vip < time())
	$vip = time();

$moreVIP = $vip + (15 * 24 * 3600);

$char->update('vip',$moreVIP);

header("Location:../../ingame.php?page=allopass&action=end");

?>
