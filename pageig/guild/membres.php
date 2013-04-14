<?php
require_once($server.'/class/guild.class.php');

if(empty($_GET['show']))
 $_GET['show'] = 0;
$char = unserialize($_SESSION['char']);

$guild = new guild($char->getGuildId());
if(empty($_GET['do'])) $_GET['do'] = '';

if(empty($_GET['member_id'])) $_GET['member_id'] = '';


switch($_GET['do'])
{
	case 'delete':
		$guild->deleteMember(new char($_GET['member_id']),$char->getId());
	break;
}


	echo '<div style="text-align:right;padding-right:25px;">';
		$url = "page.php?category=guilde&mode=membres&show=1";
		$onclick = "HTTPTargetCall('".$url."','bodygameig');";
		echo '<img onclick="'.$onclick.'" src="pictures/utils/enarbre.png" title="Afficher les fiches des membres" alt="afficher les fiches des utilisateur en arbre" />';
		$url = "page.php?category=guilde&mode=membres&show=2";
		$onclick = "HTTPTargetCall('".$url."','bodygameig');";
		echo ' <img onclick="'.$onclick.'" src="pictures/utils/enliste.gif" style="width:24px;height:24px;" title="Afficher la liste des membres" alt="afficher les fiches des utilisateur en liste" />';
	echo '</div>'; 

if(!empty($_GET['show']))
{	
	echo '<div style="margin-top:5px;text-align:center;">';
	
		echo '<div class="backgroundBody" style="width:160px;height:175px;margin:auto;background-image:none;">';
			echo '<div class="backgroundMenu" style="border:solid 1px black;margin:auto;background-image:none;">';
				echo 'Meneur';
			echo '</div>';
			echo '<div style="width:200px;height:160px;">';
				$style="-moz-border-radius-bottomleft: 10px;-moz-border-radius-bottomright: 10px;";
                                $meneur = new char($guild->getMeneur());
                                
				getFicheUser($meneur,$style,$style);
			echo '</div>';
		echo '</div>';
		
		echo '<div>';
		echo '<div class="backgroundBody" style="width:670px;height:175px;margin:auto;background-image:none;margin-top:20px;">';
			echo '<div class="backgroundMenu" style="border:solid 1px black;margin:auto;background-image:none;">';
				echo 'Seigneurs';
			echo '</div>';
			$lordList= $guild->getLordList();
			$i = 0;
			if(count($lordList) >= 1)
			foreach($lordList as $member_id)
			{
				
				if($i == 0)
				{
					echo '<div>';
					$style="float:left;margin-left:3px;";
					$style.="float:left;-moz-border-radius-bottomleft: 10px;";
				}else{
					$style="float:left;margin-left:3px;";
				}		
					getFicheUser(new char($member_id),$style,$style);
				
				$i++;
				if($i == 5)
				{
					$i = 0;	
					echo '</div><div style="margin-top:3px;"></div>';
				}			
			}
		echo '</div>';
		echo '</div>';
		
		echo '<div>';
		echo '<div class="backgroundBody" style="width:670px;height:175px;margin:auto;background-image:none;margin-top:20px;">';
			echo '<div class="backgroundMenu" style="border:solid 1px black;margin:auto;background-image:none;">';
				echo 'Soldat';
			echo '</div>';
			$paysan_list = $guild->getPaysanList();
			$i = 0;
			if(count($paysan_list) >= 1)
			foreach($paysan_list as $member_id)
			{
				
				if($i == 0)
				{
					echo '<div>';
					$style="float:left;margin-left:3px;";
					$style.="float:left;-moz-border-radius-bottomleft: 10px;";
				}else{
					$style="float:left;margin-left:3px;";
				}		
					getFicheUser(new char($member_id),$style,$style);
				
				$i++;
				if($i == 5)
				{
					$i = 0;	
					echo '</div><div style="margin-top:3px;"></div>';
				}			
			}
		echo '</div>';	
		echo '</div>';
		echo '<div style="height:15px;"></div>';
	echo '</div>';
}else{
	$list = array($guild->getMeneur());
	$lordList = $guild->getLordList();
	if(count($lordList) >= 1)
	foreach($guild->getLordList() as $lord)
		$list[] = $lord;
	$soldierList = $guild->getPaysanList();
	if(count($soldierList) >= 1)
	foreach($soldierList as $paysan)
		$list[] = $paysan;
	
	echo '<div style="margin:auto;margin-top:50px;text-align:center;">';
	echo '<table class="backgroundBodyNoRadius" style="margin:auto;min-width:650px;font-weight:700;" cellspacing="0">';
		echo '<tr class="backgroundMenuNoRadius" style="margin-right:0px;">';
			echo '<td style="width:20px;"> Online</td>';
			echo '<td style="100px;"> Membre </td>';
			echo '<td style="20px;"> Niveau </td>';
			echo '<td style="40px;"> Rang </td>';
			echo '<td style="150px;"> Localisation </td>';
			echo '<td> Mess </td>';
			echo '<td> Gold donn&eacute;</td>';
			echo '<td>  grade  </td>';
			if($char->isMeneur())
				echo '<td> Exclure </td>';
		echo '</tr>';	
	foreach($list as $member_id)
	{
		$member = new char($member_id);
		
		echo '<tr>';
			if($member->isConnect())
			{
				$statut = 'online';
				$txt = 'en ligne';
			}else{
				$statut = 'offline';
				$txt = 'hors ligne';
			}
				
			echo '<td> <img src="pictures/utils/'.$statut.'.png" title="'.$txt.'" alt="'.$txt.'" /></td>';
			echo '<td> '.$member->getName().' </td>';
			echo '<td> '.$member->getLevel().' </td>';
			echo '<td> '.getRankGuild($member->getGuildRank(),true).' </td>';
			echo '<td> '.$member->getLocalisation().' </td>';
			echo '<td> '.getLinkSendMessage($member,true,true).' </td>';
			echo '<td>'.$member->getGoldGivenToGuilde().' <img src="pictures/icones/dondor.gif" alt="Ca ne marche pas !!!"/></td>';
			
			if($char->isMeneur())
			{
				echo '<td> '.$member->ArrowUpArrowDown().'</td>';
				echo '<td> ';
					if($char->getId() != $member->getId())
					{
						$url = "page.php?category=guilde&mode=membres&show=2&do=delete&member_id=".$member->getId();
						$onclick = "if(confirm('Exclure ce membre ?')){HTTPTargetCall('$url','bodygameig');}";
						echo '<img style="z-index:36;" src="pictures/utils/no.gif" onclick="'.$onclick.'" alt="X" title="Exclure ce member" />';
					}
				echo '</td>';				
			}
		echo '</tr>';		
	}	
	echo '</table>';
	echo '</div>';
}
?>
