<?php
	
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'require.php');
require_once($server.'class/group.class.php');
require_once($server.'class/faction.class.php');
require_once($server.'class/classe.class.php');
require_once($server.'class/effect.class.php');
	
$char =unserialize($_SESSION['char']);
$group = new group($char);	

if(isset($_GET['action']))	
	switch($_GET['action'])
	{
		case 'createGroup':
			group::createGroup($char->getId());
		break;
		
		case 'expulse':
			$groupe->leave($_GET['target_id']);
		break;
		
		case 'leave':
			$group->leave($char->getId());
		break;
		
		case 'disloc':
			$group->disloc();
		break;
		
		case 'accept':
			$group->acceptInvitation($char->getId());
		break;
		
		case 'refuse':
			$group->refuseInvitation($char->getId());
		break;
	}

$array_invitation = group::hasInvitation($char->getId());

if(isset($array_invitation['group_id']) && $array_invitation['group_id'] > 0)
{
	$group = new group($array_invitation['group_id']);
	
	$group_invit = $group->getId();
	$leader = char::getNameById($group->getLeader());
	$has_invit = 1;
}else{
	$has_invit = 0;
	$leader = "";
	$group_invit = 0;
}

// Gestion des divs qu'on va récupérer en DOM
echo '<div id="has_invitation" style="display:none;">'.$has_invit.'</div>';
echo '<div id="invit_by" style="display:none;">'.$leader.'</div>';
echo '<div id="group_invit_id" style="display:none;">'.$group_invit.'</div>';


echo '<fieldset><legend style="font-weight:700;"> <img src="pictures/icones/group.gif" alt="X" /> <b>Groupe</b></legend>';
 
if($char->getGroupId() > 0)
{
        //réactualisé
	$group = new group($char);
        
	if(count($group->getMembersList()) >= 1)
	{
		echo '<div style="min-height:140px;">';
		foreach($group->getMembersList() as $member)
		{
			echo '<div style="float:left;margin-left:5px;">';
				$group->showMember($member['char_id'],$char);
			echo '</div>';
		}		
		echo '</div>';
		
		
		// Bouton et information
		
		
		
		echo '<div style="float:right;margin-top:5px;text-align:right;margin-right:5px;">';
		if($char->getId() == $group->getLeader())
		{
			$url = "page.php?category=gestion_group&group_id=".$group->getId();
			$onclick = "HTTPTargetCall('".$url."','map_container');";
			echo ' <input onclick="'.$onclick.'" class="button" type="button" value="Gestion" /> ';
			
			$url = "pageig/group/show.php?refresh=1&action=disloc";
			$onclick = "if(confirm('voulez vous vraiment dissoudre le groupe ?'))" .
					"{
						HTTPTargetCall('".$url."','group');
					}";
			echo ' <input onclick="'.$onclick.'" class="button" type="button" value="Dissoudre" /> ';
		}else{
			
			$url = "page.php?category=gestion_group&group_id=".$group->getId();
			$onclick = "HTTPTargetCall('".$url."','map_container');";
			echo ' <input onclick="'.$onclick.'" class="button" type="button" value="Gestion" /> ';
			
			$url = "pageig/group/show.php?refresh=1&action=leave";
			$onclick = "if(confirm('voulez vous vraiment quitter le groupe ?'))" .
					"{
						HTTPTargetCall('".$url."','group');
					}";
			echo '<input onclick="'.$onclick.'" class="button" type="button" value="Quitter" />';
		}
		
	echo '</div>';
	
	
	echo '<div style="float:left;margin-top:5px;text-align:left;margin-right:200px;">';
			echo '<u><b>Partage :</b></u>  ' .
					'Exp : ' .$group->getShareText($group->getShareExp()).
					' | ' .
					'Or : '.$group->getShareText($group->getShareGold()).'';
	echo '</div>';
	}
}else{
	
	echo 'Vous n\'avez pas de groupe ';
	
	$url = "pageig/group/show.php?refresh=1&action=createGroup";
	$target = "group";
	$onclick = "HTTPTargetCall('".$url."','".$target."')";
	
	echo '<input class="button" type="button" onclick="'.$onclick.'" value="cr&eacute;er un groupe" />';
	
}
 
echo '</fieldset>';
 
?>
