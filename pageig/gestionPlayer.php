<?php
$site=$_SERVER['HTTP_HOST']; // test pour savoir si on est en ligne ou en local
if(($site == "127.0.0.1" || $site == "localhost"))
{
        $server=$_SERVER["DOCUMENT_ROOT"].'/arelidon/';
}
else{
             $server="/dns/com/olympe-network/arelidon/";
}


$action ='';
if(!empty($_GET['refresh']))
{
    if(!empty($_GET['action']))
	$action = $_GET['action'];
    
    if(!empty($_GET['idskill']))
	$idskill = $_GET['idskill'];
    
    if(!empty($_GET['id']))
	$idmonster = $_GET['id'];
}else{
	if(@file('../function/fight.function.php'))
		require_once('../function/fight.function.php');
	
	
	$action = $_POST['action'];
	$idskill = $_POST['idskill'];
	$idmonster = $_POST['idmonster'];
	$player = $_POST['player'];
	
}
require_once('../require.php');
require_once($server.'function/fight.function.php');
require_once($server.'utils/fight.php');


$player = new char($_GET['id']);
$char=unserialize($_SESSION['char']);

if($action == 'skill')
{
	if($char->getLife() >= 1)
	{
		$skill = new skill($idskill);

		if(($skill->isUsableOnAlly() and $char->getId() != $player->getId())
			or ($skill->isUsableOnHimself() and $char->getId() == $player->getId())
			 or ($char->getFaction() != $player->getFaction()))
		{	
			$error = verifDistance($char->getId(),$player->getId(),$idskill);
			
			if($error <= 1)
			{
				// On récupère la distance
				$distance = $_GET['distance'];
				$txtFight = doAttack($idskill,$char->getId(),$idmonster,true,$distance);
			}else{
				$txtFight = $error ;
			}
		}else{
			if($char->getFaction() == $player->getFaction())
				$txtFight = 'Vous ne pouvez pas attaquer un membre de votre faction';
			elseif(!$skill->isUsableOnAlly() and $char->getId() != $player->getId())
				$txtFight = 'Ce sort n\'est pas utilisable sur les alli&eacute;s';
			else
				$txtFight = 'Ce sort n\'est pas utilisable sur vous m&ecirc;me';
		}		
	}else{
		$txtFight = " Malgr&egrave;s votre courage vous avez succomb&eacute; aux attaques du monstre";
	}
}	

$player->loadChar($player->getId());
if(!($action == 'fiche') AND !($action == 'ma_fiche')){
// Affichage du statut du joueur
showCharStatut($char);
echo "<div id='toto'></div>";
if ($char->getLife() == 0){
$onclick="HTTPTargetCall('pageig/move/move.php?die=2&map=".$char->getMap()."','toto');";
createButton('Aller au cimeti&egrave;re',$onclick);
}
echo '</div></hr>';
}


if(($player->getId() != $char->getId()))
{
	
	showCharStatut($player);
	
	echo '<hr />';
	
	// Liste des actions disponible sur ce joueur
		
	echo '<div style="min-height:35px;">';
		
		createButtonActionShowPlayer('dondor','','Donner de l\'or','margin-left:20px;');
		
		$onclick2 = "cleanMenu();HTTPTargetCall('page.php?category=messagerie','bodygameig');";
		$onclick2 .= "HTTPTargetCall('page.php?category=messagerie&action=new&to_prevalue=".$player->getName()."','box_container');";
		createButtonActionShowPlayer('envoyermessage',$onclick2,'Envoyer un message','margin-left:10px;');
		
		$onclick3 = "cleanMenu();HTTPTargetCall('pageig/game.php?refresh=1&switch_place=1&target_id=".$player->getId()."','bodygameig');";
		createButtonActionShowPlayer('changerplace',$onclick3,'Changer de place','margin-left:10px;');
		
		$onclick4="cleanMenu();HTTPTargetCall('include/menuig.php?refresh=1&mode=profil&char_id=".$player->getId()."&action=fiche','tdmenuig');";
		createButtonActionShowPlayer('profil',$onclick4,'Voir fiche','margin-left:10px;');
		
		// Si le joueur est leader d'un groupe et que le joueur cliqué n'a pas de groupe
	
		if((group::getGroup($char->getId()) >= 1) and (group::getGroup($player->getId()) == 0))
		{
			$group_id = group::getGroup($char->getId());
			$group = new group($group_id);
			
			if($group->getLeader() == $char->getId())
			{
				$onclick4="cleanMenu();HTTPTargetCall('pageig/group/invit.php?char_id=".$player->getId()."&group_id=".$group->getId()."','tdmenuig');";
				createButtonActionShowPlayer('group',$onclick4,'Inviter dans le groupe','margin-left:10px;');
			}
		}
		
	echo '</div>';	
	
	echo '<hr />';
}

	$stylea='';
	// Liste des compétence
	if (!($action == 'fiche') AND !($action == 'ma_fiche') ){
		getSkillListMenu($char,$stylea,$player,true);
	}
	
	echo '<hr />';


// Affichage du texte des actions

 echo '<div>';
 switch($action)
 {
	case 'skill':
		echo '<div style="margin-left:8px;">';
			echo $txtFight;
		echo '</div>';
		// En cas de mort du monstre

	break;
	
	default :
	 	
 	break;
 }
 echo '</div>';





// ###########################""""" Liste des fonctions ################################################


function createButtonActionShowPlayer($img,$onclick,$alt="",$style="")
{
	echo '<div onclick="'.$onclick.'" style="cursor:pointer;background-image:url(\'pictures/utils/cadre32x32.png\');float:left;height:32px;width:32px;'.$style.'">';
		echo '<img style="margin-left:4px;margin-top:4px;" src="pictures/icones/'.$img.'.gif" alt="'.$alt.'" title="'.$alt.'" />';
	echo '</div>';
}

?>
