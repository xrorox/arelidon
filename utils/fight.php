<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}

	//require_once($server.'/class/char.class.php');
 require_once($server.'class/effect.class.php');
  require_once($server.'class/skill.class.php');
  
 
 // $char=new char($idchar);
 // Affichage du statut du joueur (menu combat)
function showCharStatut($player)
{
	// On raffraichit les donn�es du joueur
	$player->loadChar($player->getId());
	
	echo '<div style="height:70px;margin-top:5px;">';
	
	// Affichage de l'image de la classe'
	echo '<div style="margin-top:10px;text-align:center;margin:2px;margin-bottom:5px;margin-top:5px;float:left;border:0px;width:54px;height:64px;">';
	echo '<img src="'.$player->getUrlPicture('ico',1).'" />';
	echo '</div>';
	
	
	// Affichage nom , vie et niveau
	echo '<div style="margin-left:40px;">';
	
	echo '<div id="char_name" style="margin-left:20px;"> '.$player->getName().' </div>';
	echo '<div id="char_level" style="margin-left:40px;font-size:10px;"> Niveau '.$player->getLevel().' </div>';
	
	echo '<div class="barre" style="margin-left:20px;border:solid 1px black;height:5px;width:150px;background-color:black;">';
		$pourcentVie = ($player->getLife() / $player->getLifeMax()) * 100; 
		$pourcentVie = $pourcentVie * 1.5;
	
		echo '<div class="barre" style="width:'.$pourcentVie.'px;height:5px;background-color:red;"></div>';
	echo '</div>';
	
	echo '<div class="barre" style="margin-left:20px;border:solid 1px black;height:5px;width:150px;background-color:black;margin-top:2px;">';
		$pourcentMana = ($player->getMana() / $player->getManaMax()) * 100; 
		$pourcentMana = $pourcentMana * 1.5;
	
		echo '<div class="barre" style="width:'.$pourcentMana.'px;height:5px;background-color:blue;"></div>';
	echo '</div>';
	
	echo '<div style="float:right;margin-top:-47px;margin-right:15px;">';
		echo '<img src="pictures/faction/'.$player->getFaction().'-24.png" />';
	echo '</div>';
	
	echo '<div>';
		$alleffect = effect::getAllEffectOnChar($player);
                if(count($alleffect) > 0)
                {
                    foreach($alleffect as $effect)
                    {
                            $effect = new effect('char_id',$effect['effect_id'],$player->getId());

                            $duree_restante = $effect->getDureeRestante($player->getId(),'char_id');

                            $urlimg = 'pictures/effect/'.$effect->getId().'.gif';
                            $txt = "<div>" .
                                            "	<u>" .$effect->getName().
                                            "</u></div><hr /><div>" .
                                            "" .$effect->getDescription().
                                            "</div><hr />" .
                                            "<div> dur&eacute;e restante : " .$duree_restante.
                                            "</div>";
                            imgWithTooltip($urlimg,$txt,'','','width:200px;','width:250px;');
                    }
		
                }
	echo '</div>';
	
	echo '</div>';
	echo '</div>';
	echo '</div>';
}


function saveAttack($char,$char2)
{
	$timemax = time();
	
	$sql = "DELETE FROM `attacks` WHERE (char_id = ".$char->getId()." AND target_id = ".$char2->getId().") or timestamp < $timemax";
	loadSqlExecute($sql);
	
	$time = time() + 5; // 5 secondes entre deux attaques
	
	$sql = "INSERT INTO `attacks` (`char_id` ,`target_id` ,`timestamp`)
			VALUES ('".$char->getId()."', '".$char2->getId()."', '".$time."');";
			
	loadSqlExecute($sql);
}

function timeBeforeAttack($char,$char2)
{
	
	$timemax = time();
	
	$sql = "SELECT * FROM `attacks` WHERE (char_id = ".$char->getId()." AND target_id = ".$char2->getId().") or timestamp > ".time()." LIMIT 1";
	$result = loadSqlResultArray($sql);
	
	$time = $result['timestamp'];
	
	
	
	$time_before_attack = $time - time();
	
	if($time_before_attack > 0)
		return $time_before_attack;
	else
		return 0;
}

function canAttack($char,$char2)
{
	$level_min = $char->getLevel() - 5;
	$level_max = $char->getLevel() + 5;
	
	$sql="SELECT count(char_id) FROM `busy` WHERE char_id=".$char2->getId();
	$busy=loadSqlResult($sql);
	
	if($level_min <= $char2->getLevel() and $char2->getLevel() <= $level_max and !$busy)
		return true;
	else
		return false;
}

function selectSkill($monster,$char,$distance)
 {
 	$skills_array = $monster->getSkillArrray();
 	
 	// Si un seul sort, facile ^^
 	if(count($skills_array) == 1)
 	{
 		$skill1 = new skill();
 		$skill1->loadSkillInfoMonster($skills_array[0][skill_id],$skills_array[0][level]);
 		$skill_return = $skill1;
 	}else{
 		
 		// On filtre les sorts non utilisables (mana,port�e,chance de lancer l'attaque)
 		$i = 0;
 		
 		foreach($skills_array as $skill_array)
 		{
 			$skill = new skill();
 			$skill->loadSkillInfoMonster($skill_array[skill_id],$skill_array[level]);
 			
 			// Pour chaque sort on va tester si il est lancable (port�e,mana,rate)
 			// Rate 0.3 => le monstre a 30% de chance de lancer ce sort
 			
 			$valid = true;
 			
 			if($distance > $skill->getRangeMax() and ($skill->getTypeSort() == 1 or $skill->getTypeSort() == 4))
 			{
 				$valid = false;
 			}	
 			
 			if($skill->getManaCost() > $monster->getMana() or ($skill->getManaCost() >= 1 && $monster->isSilence()))
 			{
 				$valid = false;
 			}	
 				
 			$rand = mt_rand(1,100);	
 			if($rand > $skill_array['rate'])
 			{
 				$valid = false;
 			}	
 			
 			// Si effet d�j� sur le lanceur
 			if($skill->getEffectCible() == 1 and $monster->isEffectBy($skill->getEffectId()) and $skill->getEffectId() != 0)	
 			{
 				$valid = false;
 			}
 			
 			if($skill->getEffectCible() != 1 and $char->isEffectBy($skill->getEffectId()) and $skill->getEffectId() != 0)	
 			{
 				$valid = false;
 			}	
 			
 			// S�lection intelligente d'un sort :
 			/*
 			 * Full life = on lance attaque , mal�diction ou enchantement
 			 * bas life = soin si on a sinon 
 			 * sinon attaque simple
 			 */
 			 
 			 $full_life = round($monster->getLifeMax() * 0.75);
 			 $low_life = round($monster->getLifeMax() * 0.25);
 			 
 			 // Si full life, et que c'est un sort de soin'
 			 if($monster->getLife() >= $full_life and $skill->getTypeSort() == 2)
 			 {
 			 	$valid = false;
 			 }	
 			 
 			 if($monster->getLife() <= $low_life and ($skill->getTypeSort() == 3 or $skill->getTypeSort() == 4))
 			 {
 			 	$valid = false;
 			 }	
 			
 			 if($valid)
 			 	$skill_step_2[] = $skill_array;
 			
 		}
 		
 		
 		// Si apr�s les filtres il en reste qu'un , facile !
 		if(count($skill_step_2) == 1)
 		{
 			$skill2 = new skill();
	 		$skill2->loadSkillInfoMonster($skill_step_2[0][skill_id],$skill_step_2[0][level]);
	 		$skill_return = $skill2;
 		
 		
 		}else{
 			
 			//exception dans le cas ou on aurait tout filtr�
 			// On retente de lancer charge en sachant que le monstre sera trop loin
 			if(count($skill_step_2) == 0)
 			{
 				$skill3 = new skill();
		 		$skill3->loadSkillInfoMonster($skills_array[0][skill_id],$skills_array[0][level]);
		 		$skill_return = $skill3;
 			}
 			
 			$rand = mt_rand(0,count($skill_step_2)-1);
 			$skill = new skill();
	 		$skill->loadSkillInfoMonster($skill_step_2[$rand][skill_id],$skill_step_2[$rand][level]);
	 		$skill_return = $skill;
 		}	
 	}
 	
 	return $skill_return;
 }


?>
