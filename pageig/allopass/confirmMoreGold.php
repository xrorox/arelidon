<?php
/*
 * Created on 14 mai 2010
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

	$goldmore = getGoldForLevel($char->getLevel());

	$char->updateMore('gold',$goldmore);

	
	header("Location:../../ingame.php?page=allopass&action=end");
		

?>
