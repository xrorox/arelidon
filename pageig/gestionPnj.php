<?php

if($_GET['refresh'] != 1)
{
	require_once('class/pnj.class.php');
	require_once('class/quete.class.php');
	require_once('class/step.class.php');
        require_once('class/char_inv.class.php');
        
}else{
	require_once('../class/pnj.class.php');
	require_once('../class/quete.class.php');
	require_once('../class/step.class.php');
        require_once('../class/char_inv.class.php');
}

if( empty($_GET['id']))
	$_GET['id'] = 0;

	
$pnj = new pnj($_GET['id']);

if (preg_match("*MSIE*", $_SERVER["HTTP_USER_AGENT"]))
	$validNavigator = false;
else
	$validNavigator = true;	

echo '<div id="window_pnj">';
	echo '<div style="float:left;">';
		echo '<img src="pictures/face/'.$pnj->getFace().'" style="border:solid 2px black;background:grey;width: 96px; height: 96px;" />';
	echo '</div>';
	
	echo '<div style="margin-left:20px;">';
		echo '<div id="name_pnj" style="margin-left:100px;font-size:18px;">';
			echo $pnj->getName();
		echo '</div>';

			echo '<hr />';
		echo '<div id="title_pnj" style="margin-left:85px;font-size:14px;">  ';
			echo $pnj->getTitle();
		echo '</div>';
	echo '</div>';
echo '</div>';
if (!$validNavigator)
	echo '<hr /><br /><br />';
else
	echo '<hr /><br /><div>***************************************</div>';

echo '<div id="text_pnj" style="margin:6px;"><p>';


$txt ='';
// Renvoi un tableau d'information si une qu�te est en cours sur ce PNJ
	$step_id = $pnj->hasAQuest($char);
	if($step_id !== false)
	{
		$step = new step($step_id);
		$state = $step->getStepState($char);
		switch($state)
		{
			case 0:
				// Début d'une quête
				if($pnj->getId() == $step->getPnj())
				{
					$txt .= $step->getTextPnj();
					
					$txt .= '<div class="clean"></div>';
					$txt .= '<div id="valid_go_quest" style="text-align:center;margin-top:25px;">';
					$onclick = "HTTPTargetCall('page.php?category=quetes&action=accepte&idstep=".$step->getId()."&pnj_id=".$step->getId()."','valid_go_quest');";	
					if ($step->satisfyPrerequisites($char) && $step->hasNotBeenStarted($char)){			
						$txt .= createButton('Accepter',$onclick,"","","7",true);
						
					}
					else{
						$txt.= "Tu n'as pas encore le niveau pour cette qu&ecirc;te.";
					}
					$txt .= '</div>';
				}else{
					$txt = $pnj->getTextDecode();
				}
			break;
			
                        case 1:
				// Qu�te en cours
				$is_good_pnj = $step->isGoodPnj($pnj);
				
				if($is_good_pnj !== true)
				{
					$txt .= $pnj->getTextDecode();
					
					$txt .= '<div class="clean"></div>';
					$txt .= '<div id="valid_go_quest" style="text-align:center;margin-top:25px;">';									
						$txt .= ' Qu&ecirc;te en cours ';
					$txt .= '</div>';					
				}else{
					// C'est le pnj a qui on doit parler , a bah ca alors !
					$txt .= $step->getTextPnjQuest();
					$step->validatePnJ($pnj, $char);		
				}

			break;
                        
			case 2 :
				
				// La quête a besoin d'être validée , et comme par mazard , c'est le bon PNJ				
				if($pnj->getId() == $step->getPnjValid())
					$txt .= $step->validStep($char,true);	

				
				// qu�te est finie , et merde ! c'est pas le bon PNJ '				
				if(($pnj->getId() == $step->getPnj() or $pnj->getId() == $step->id_need) && $pnj->getId() != $step->getPnjValid())
				{
					$name_pnj = pnj::getNameById($step->getPnjValid());
					$txt .= '<div style="'.$styleText.';text-align:center;margin-right:50px;">';
						$txt .= "Vous devez retourner voir $name_pnj pour valider cette &eacute;tape";
					$txt .= '</div>';
				}	
			break;			
                        
                        case 3:
				// quête déjà terminée , on affiche le texte de base
				$txt .= $pnj->getTextDecode();
			break;
		}				
	}else{
		$txt = $pnj->getTextDecode();
	}	
// ----------- V�rification si besoin d'avoir onglet suivant -------------------------
	$arrayInfoQuest_next = $pnj->hasAQuest($char);

	if(is_array($arrayInfoQuest_next))
	{
		$idstep = $arrayInfoQuest_next['idetape'];
		$step = new step($idstep);
		
		$state = $step->getStepState($char->getId());
		// Si l'�tape a d�j� �t� finie mais besoin de valider et c'est le pnj a qui on doit valider
		// OU si l'�tape est pas encore finis et c'est a ce perso qu'on doit parler
		if(($state == 3 && $pnj->getId() == $step->getPnjValid()) or ($state == 4 && !($step->type != 2 or $step->id_need != $pnj->getId())))
		{
			$onclick = "loadObject('pnj','1','".$pnj->getId()."');";
			$txt .= '<div style="text-align:center;margin-top:5px;"><input class="button" type="button" value="Suite" onclick="'.$onclick.'" /></div>';
		}
	}
	
	
	
	$style_add = array('margin-left'=>'5px','align'=>'center','width'=>'190px','font-weight'=>'500');
	$style_empty = array();
	createTexte($txt,$style_empty,$style_add);
	

	
// ##############################################################################################
/** 
 *  Si le PNJ poss�de une fonction
 */	
switch($pnj->getFonction())
{	
	case 1:
		// Magasin	
		$url = "page.php?category=shop&pnj=".$pnj->getId();
		$onclick = "HTTPTargetCall('$url','bodygameig');cleanMenu();";	
		createButton('Voir le magasin',$onclick);
	break;
	case 2:
		// Guilde
		$url = "page.php?category=guild_pnj&pnj=".$pnj->getId();
		$onclick = "HTTPTargetCall('$url','bodygameig');cleanMenu();";	
		createButton('En savoir plus',$onclick);
	break;
	case 3:
		// Magasin de sort
		$url = "page.php?category=shop_skill&pnj=".$pnj->getId();
		$onclick = "HTTPTargetCall('$url','bodygameig');cleanMenu();";	
		createButton('Voir le magasin',$onclick);
	break;
	case 4:
		// Banque
		$url = "page.php?category=bank&pnj=".$pnj->getId();
		$onclick = "HTTPTargetCall('$url','bodygameig');cleanMenu();";	
		createButton('Voir votre coffre',$onclick);
	
	if($char->getGuildId() > 0){	
		$url = "page.php?category=bank_guild&pnj=".$pnj->getId();
		$onclick = "HTTPTargetCall('$url','bodygameig');cleanMenu();";	
		createButton('Voir le coffre de guilde',$onclick);
	}
	
	break;
	case 5:
		// Maitre d'ar�ne
		$array_teleport = $pnj->getTeleporterInfos();
			
		$onclick = "teleport('".$array_teleport['map']."','".$array_teleport['abs']."','".$array_teleport['ord']."','".$array_teleport['id']."');cleanMenu();";	
		$can_teleport = $pnj->canTeleport($char,$array_teleport);
		
		// Si le t�l�porteur ne m�ne pas dans le vide
		if($array_teleport['map'] >= 1)
			if($can_teleport == "ok")
				createButton('On y va !',$onclick);
			else
				echo $can_teleport;
	break;
	
	case 6:
		// Garde du donjon
		
		// Si le personnage a un groupe
		if(group::getAGroup($char->getId()))
		{
			echo '<br />';
			
			$group = new group(group::getGroup($char->getId()));
			
			$donjon = new donjon($pnj->getFonctionId());
			
			if($donjon->isFinish($group->getId()) && $group->getDonjonId() == $pnj->getFonctionId())
			{
				$donjon->clean($group->getId());
				$group->setDonjonId(0);
			}	
			
			// Si on a d�j� associer au groupe l'id de ce donjon et qu'il n'est pas finis
			if($group->getDonjonId() == $pnj->getFonctionId())
			{
				
				$onclick = "teleport('".$donjon->getMapBegin()."','".$donjon->getAbsBegin()."','".$donjon->getOrdBegin()."','999');cleanMenu();";
				createButton('Rentrer !',$onclick);
			}else{
				$group->setDonjonId($pnj->getFonctionId());
				$donjon->createDonjon($group->getId());
				
				$onclick = "teleport('".$donjon->getMapBegin()."','".$donjon->getAbsBegin()."','".$donjon->getOrdBegin()."','999');cleanMenu();";	
				
				createButton('Rentrer !',$onclick);
			}
			
		}else{
			echo '<br />Vous devez avoir un groupe pour rentrer.';
		}
		

	break;	
	case 7:
		//vente aux joueurs
		
		$url = "page.php?category=hdv&pnj=".$pnj->getId();
		$onclick = "HTTPTargetCall('$url','bodygameig');cleanMenu();";	
		createButton('Entrer &agrave l\'h&ocirc;tel des ventes.',$onclick);
	break;
}	
echo '</p></div>';


?>
