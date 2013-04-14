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
 	require_once('../../savelog.inc.php');
 	require_once('../../class/char.class.php');
 	
 	$char = new char($idchar);

	if($char->timeBeforeCanBuyPA() > 1 * 24 * 3600)
	{
		$char->updateMore('pa',240);
		$sql = "INSERT INTO `log_morePA` (char_id,timestamp) VALUES (".$char->getId().",".time().")";
		loadSqlExecute($sql);
		
		header("Location:../../ingame.php?page=allopass&action=end");
		
	}else{
		echo 'Vous ne pouvez pas encore acheter de points d\'Actions';
	}
?>
