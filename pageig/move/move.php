<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'class/user.class.php');
require_once($server.'utils/database.php');
require_once($server.'class/admin.class.php');
require_once($server.'savelog.inc.php');
require_once($server.'class/map.class.php');
require_once($server.'class/char.class.php');
require_once($server.'utils/utils.php');

$char=unserialize($_SESSION['char']);
if(!empty($_GET['map']))
		$map_id = $_GET['map'];
	else
		$map_id = $char->getMap();
if(empty($_GET['die']) and !empty($_GET['abs']) and !empty($_GET['ord']))
{	 
	
// Cas ou l'on est téléporter par un téléporteur
	if(!empty($_GET['telep']))	
	{
		$char->setMap($_GET['map']);
		$char->setAbs($_GET['abs']);
		$char->setOrd($_GET['ord']);
                $char->addFatigue(1);
	
		// On utilise 999 pour les téléportations sans prix
		if($_GET['telep'] != 999)
			$gold = map::getPriceOfTeleportation($_GET['telep']);
			$gold2 = $char->getGold();
			$new_gold= $gold2 - $gold;
			$char->update('gold',$new_gold);
	}		
	

		if(!empty($_GET['changemap']) )
		{
                    
				$char->setMap($_GET['changemap']);
				$char->setAbs($_GET['abs']);
				$char->setOrd($_GET['ord']);
                                $char->addFatigue(1);
                                
							
		}else{
			
				$char->setFace($_GET['face']);
				$char->setAbs($_GET['abs']);
				$char->setOrd($_GET['ord']);
				$char->setMap($map_id);
                                $char->addFatigue(1);
			}
				

	
	

}elseif(!empty($_GET['die']) && $_GET['die'] == 1){
	
	$time = time();
	$time_die = $char->getTimeDie();

	if($time >= $time_die or $_GET['die'] ==2)
	{
		
		$map = new map($map_id);
		$array = $map->getMapRespawn();
		
		$char->setMap($array['refmap']);
		$char->setAbs($array['refabs']);
		$char->setOrd($array['reford']);
		$sql= "UPDATE `char` SET life = 1,time_die = 0 WHERE id = ".$char->getId()." ;";
		loadSqlExecute($sql);
		if(!$char->isInPvp())
			$char->loseXP();
	}
	
}
$_SESSION['char']=serialize($char);
$char=null;
?>
