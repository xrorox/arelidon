<?php
/*
 * Created on 1 sept. 2009
 *
 */

require_once($server.'function/monster_die.function.php');
 
// Gestion de l'attaque (v�rification de la vie , des pa , etc ...)
function doAttack($idskill,$idchar,$idchar2,$pvp=false,$distance=1)
{
	$char = new char($idchar);
	if($pvp)
		$char2 = new char($idchar2);
	else
	{
		$char2 = new monster($idchar2);
		$skillm = new skill();
		$skillm->loadSkillInfoMonster($idskill,$char2->levelattack);	
	}	
	
	$skill = new skill;
	$skill->loadSkillInfo($idskill,$idchar);
	
	if($pvp)
		$time_before_attack = timeBeforeAttack($char,$char2);
	
	if((canAttack($char,$char2) or !$pvp) or $skill->getTypeSort() == 2 or $skill->getTypeSort() == 3)
	{
		if($time_before_attack == 0 or !$pvp)
		{
			if($char2->getLife() > 0 or ($skill->canRez()))
			{
				if($char->pa >= 1)
				{
					if($char->mana >= $skill->getManaCost())
					{
							
						// On inflige les brulures et poison	
						$txt .= takeDomageOfEffect($char,$char2,$pvp);
						
						//--------------------------- On lance les attaques !!-----------------------------------
						
						// On regarde qui poss�de le plus de dext�rit� pour savoir qui commence
						if($char->getTot('dex') > $char2->getTot('dex'))
						{
							// Le joueur attaque en premier
							$txtarray = doAttackPlayer($skill,$char,$char2,$pvp,$distance);
							$txt .= $txtarray['txt1'];
							
							$txt .= "<br />";
							
							// le monstre peut riposte que si c'est une attaque
							if($skill->getTypeSort() == 1 && !$pvp)
							{
								if ($char2->life > 0){
								$txt .= doAttackMonster($skillm,$char2,$char,$pvp,$distance);
								decrementeEffect($char,$char2,$pvp);
								}
							}	
							
							$txt .= "<br /><br />";
		
							// Affichage du gain d'exp apr�s le texte du monstre
							$txt .= $txtarray['txt2'];
							
						}else{
							// Le monstre attaque en premier
							if($skill->getTypeSort() == 1 && !$pvp)
							{
								$txt .= doAttackMonster($skillm,$char2,$char,$pvp,$distance);
								decrementeEffect($char,$char2,$pvp);
							}	
							
							$txt .= "<br />";
							
							$txtarray = doAttackPlayer($skill,$char,$char2,$pvp,$distance);
							$txt .= $txtarray['txt1'];
							
							$txt .= "<br />";
							$txt .= $txtarray['txt2'];
						}
						
						
						// V�rification si le monstre/joueur est mort
						if($char2->getLife() == 0)
						{
							 // en pvp = gain d'honneur ou perte selon ou le joueur a �t� attaquer
							 if($pvp)
							 {
							 	if($char->isInArena())
							 	{
							 		$char->setHonnor($char->getHonnor() + 10);
							 		$char->update('kills',$char->getKills()+1);
							 		$char2->update('deaths',$char->getDeaths()+1);
							 		$txt .= "<br /> Vous gagnez 10 d'honneur";
							 	}else{
							 		$char->setHonnor($char->getHonnor() - 25);
							 		$char->update('kills',$char->getKills()+1);
							 		$char2->update('deaths',$char->getDeaths()+1);
							 		$txt .= "<br /> Vous perdez 25 d'honneur";
							 	}	
							 }else{
							 	//Besoin de faire texte + gain monstre
							 	$txt .= action_on_monster_die($char,$char2);
							 } 		
						}
					
		
					}else{
						// pas assez de mana
						$txt = '<div style="font-size:15px;font-weight:700">'; 
						$txt .= 'vous n\'avez pas assez de mana pour r&eacute;aliser cette attaque';
						$txt .= '</div>';
					}	
					
				
				}else{
					$txt = '<div style="font-size:15px;font-weight:700">'; 
					$txt .= 'vous n\'avez pas assez de Point d\'action pour r&eacute;aliser cette attaque';
					$txt .= '</div>';
				}
			
			}else{
				$txt = '<div style="font-size:15px;font-weight:700">'; 
				$txt .= 'Le joueur est malheureusement<br /> mort !';
				$txt .= '</div>';
			}		
		}else{
			$txt = '<div style="font-size:15px;font-weight:700">'; 
				$txt .= 'Vous ne pouvez pas encore attaquer ce joueur : <br /> Temps restant : '.$time_before_attack.' secondes';
			$txt .= '</div>';
		}
	}else{
		$txt = '<div style="font-size:15px;font-weight:700">'; 
			$txt .= 'L\'&eacute;cart de niveau est trop grand ou le joueur est occup&eacute;.';
		$txt .= '</div>';
	}

	return $txt;
}
 
############################## Functions ##############################################################


// R�alisation d'une attaque d'un joueur (calcul taux de r�ussite , CC , d�gat , effet)
 function doAttackPlayer($skill,$char,$char2,$pvp=false,$distance=1)
 {
	$array = useSkill($skill,$char,$char2,$pvp,$distance);
	return $array ;
 }
 
 function doAttackMonster($skillm,$monster,$char,$pvp=false,$distance=1)
 {
 	if($monster->isTaunt())
 	{
 		// test si il peut taper le guerrier qui a provoqu�
 		$taunt_by = new char($monster->tauntBy());
 		
 		$new_distance = calculDistance($taunt_by->getAbs(),$taunt_by->getOrd(),$monster->getAbs(),$monster->getOrd(),$monster->getTaille());
 	
 		if($new_distance <= $monster->getRangeMax())
 		{
 			$distance = $new_distance;
 			$taunt = true;
 			$char = $taunt_by;
 		}else{
 			$taunt = false;
 		}
 	}
 	
 	// En cas de PVP , la cible ne riposte pas
 	if($pvp)
 	{
 		$txt = '';
 	}else{	
		$skillm = selectSkill($monster,$char,$distance);
		
		if($skillm->getTypeSort() == 2 or $skillm->getTypeSort() == 3)
			$array = useSkill($skillm,$monster,$monster,$pvp,$distance);
		else
			$array = useSkill($skillm,$monster,$char,$pvp,$distance);
 	}
	return $array['txt1'];
 }
 
 // R�alisation d'une attaque d'un joueur (calcul taux de r�ussite , CC , d�gat , effet)
 /*
  * char => correspond � l'attaquant (peut �tre un personnage ou un monstre)
  * char2 => la cible , de m�me char ou monstre
  * 
  */
 function useSkill($skill,$char,$char2,$pvp=false,$distance=1)
 {
	
	if($pvp)
	{
		saveAttack($char,$char2);
	}
	
	if($distance > 1)
	{
		switch($distance)
		{
			case 2 :
				$malus_dis = 0.95;
			break;
			case 3 :
				$malus_dis = 0.90;
			break;
			case 4 :
				$malus_dis = 0.85;
			break;
			case 5 :
				$malus_dis = 0.80;
			break;
			default :
				$malus_dis = 0.75;
			break;
		}
	}else{
		$malus_dis = 1;
	}	

	
	if($distance <= $skill->getRangeMax() or $skill->typesort == 2 or $skill->typesort ==3)
	{
	 	switch($skill->typesort)
		{
			// Attaque
			case 1 :
				
				// Dans le cas o� c'est du pvp, on enregistre l'attaque effectu�e (1 attaque / 5 sec)
				$dmgback = 0;
				$txt = '<div style="font-size:15px;font-weight:700">'; 
				
				if($char instanceof char)
					$txt .= '<div>Vous utilisez <font style="font-family:New Roman;font-size:17px;">'.$skill->getName().'</font><br />';
				else
					$txt .= '<div>Le monstre utilise <font style="font-family:New Roman;font-size:17px;">'.$skill->getName().'</font><br />';
				
				
				// On regarde si l'attaque est r�ussie
				if(successAttackChar($char,$char2,$skill,$distance))
				{
					// Dommages effectu�s par le joueur
					$dmg = $skill->getDmg($char);
						
					$ale = selectRandRate();
					$dmg = $dmg + ($dmg * $ale);
	
					// D�duction des d�gats de l'armure
					$dmg = $dmg - $char2->getTot('res');
					$dmg = round($dmg);	
					
					// Test si un coup critique est effectu�
					if(sucessCriticalHit($char,$char2,$skill))
					{
						$txt .= '<div style="padding-left:20px;color:#336600;"> Critique !!! </div>';
						$dmg = $dmg * 2;
					}	

					// D�duction des d�gats selon la distance
					$dmg = $dmg * $malus_dis;
					$dmg = round($dmg);
					
					if($dmg <= 0)
						$dmg = 0;
					
					
					// Mise a jour de la vie de la cible
					if($pvp)
						$char2->updateLife($dmg,$char->getId());
					else
						$char2->updateLife($dmg);
					
					
					// Calcul de l'exp gagn�e
					if(($char2 instanceof monster) and (!$char instanceof monster))
					{
						// Calcul du % de vie enlev�e
						$pourcentLifeDo = ($dmg / $char2->getLifeMax());
						if($pourcentLifeDo > 100)
							$pourcentLifeDo = 100;
						
						
						// Calcul de l'exp pour 100% de la vie du monstre (75% de l'exp total + 25% a la mort)
						$expForLife = round($char2->getExp() * 0.75);
						$expForDeath = $char2->getExp() - $expForLife;
						
						$expwin = $pourcentLifeDo * $expForLife;

						if($char2->getLife() == 0)
						{
							$expwin += $expForDeath;
							$monster_is_death = true;
						}
						
						
						if($expwin > $char2->exp)
							$expwin = $char2->exp;

						
						if($char2->getLevel() != $char->getLevel())
						{
							
							$malus_exp = (($char->getLevel() - $char2->getLevel()) * 0.2) * $expwin; // 10% de perte par �cart de niveau
							
							if ($malus_exp > 0)
								$malus_exp = $malus_exp * -1;
								
							if (($char2->getLevel() - $char->getLevel()) >5)
								$malus_exp*3;
							
							$expwin = $expwin - $malus_exp;
							if($expwin < 0)
								$expwin = 0;
						}
						
						if($char->getLevel() < 5)
							$expwin = $expwin + 1;
						
					}else{
						// Combat d'un joueur
						$expwin = $char2->getLevel() + ($char2->getLevel() - $char->getLevel());
					}
	
					$expwin = round($expwin);
					
					if($expwin <= 0)
						$expwin = 0;			
					
					if($char instanceof char)
						$txt .= 'Vous infligez '.$dmg.' d&eacute;g&acirc;ts</div>';
					else
						$txt .= 'Le monstre inflige '.$dmg.' d&eacute;g&acirc;ts</div>';
					
				}else{
					if($char instanceof char)
						$txt .= 'Vous ratez la cible';
					else
						$txt .= 'Le monstre rate la cible';
				}
				
				// On a un effet a mettre et la cible n'est pas morte (bah ouais si il est mort sa sert a rien)
				if($char2->getLife() >0 && $skill->getEffectId() > 0)
				{
					$rand = mt_rand(1,100);
					
					if($rand <= $skill->getEffectPourcent())
					{
						$effect = new effect($skill->getEffectId(),$skill->getLevel());
						if($skill->effect_cible == 0)
						{
							// Effet sur la cible
							if($pvp or $char2 instanceof char)
							{
								$effect->addEffect($char2,'char_id',$skill->getLevel(),$char->getId());
							}	
							else
							{
								$effect->addEffect($char2,'mstr_id',$skill->getLevel(),$char->getId());
							}	
						
						}elseif($skill->getEffectCible() == 1){
							// Effet sur le lanceur
							if($char instanceof char)
								$effect->addEffect($char,'char_id',$skill->getLevel(),$char->getId());
							else
								$effect->addEffect($char,'mstr_id',$skill->getLevel(),$char->getId());
						}					
					}
				}
				
				
				
			break;
		
			// Soin
			case 2 :
				// Dommages effectu�s par le joueur
				if (($char instanceof char and $char2 instanceof char) or ($char instanceof monster and $char2 instanceof monster))
				{
						$distance = calculDistance($char->getAbs(),$char->getOrd(),$char2->getAbs(),$char2->getOrd(),2);
						
						if ($distance < $skill->getRangeMax())
						{
							$dmg = $skill->getDmg($char);
					
							$ale = selectRandRate();
							$dmg = $dmg + ($dmg * $ale);
				
				
							$dmg = round($dmg);
							if($dmg >= 0)
								$dmg = 0;
							$life=$char2->getLife();
					
							$max_life=$char2->getLifeMax();
							// Mise a jour de la vie de la cible
							if($pvp && $char2->getFaction() == $char->getFaction())
								$char2->updateLife($dmg);
							else
							{
							if($char2 instanceof char and $char instanceof char)
								$char2->updateLife($dmg);
							else
								$char->updateLife($dmg);
					
							}	
							if($char2 instanceof char){
					
					
								$dmg2=$max_life-$life+$dmg;
					
							if ($dmg2 >= 0){
								$expwin = ($dmg/4) * -1;
							}else{
								$expwin=(($dmg-$dmg2)/4)*-1;
						
							}
								
						if ($expwin >50){
							$expwin=$expwin * 0.75;
						}
						elseif($expwin >100){
							$expwin=$expwin*0.675;
						}
						elseif($expwin >200){
							$expwin=$expwin*0.6;
						}
						$expwin = round($expwin);
						
					}
				
				if($expwin == 0)
					$expwin = 1;
	
				$dmgback = 0;
				$txt = '<div style="font-size:15px;font-weight:700">'; 
				
				if($char instanceof char)
					$txt .= '<div>Vous utilisez <font style="font-family:New Roman;font-size:17px;">'.$skill->getName().'</font><br /><br />';
				else
					$txt .= '<div>Le monstre utilise <font style="font-family:New Roman;font-size:17px;">'.$skill->getName().'</font><br /><br />';
				
				if($dmg2>=0){
					$dmg_reverse=$dmg *-1;
				}
				else{
					$dmg_reverse=$max_life-$life;
				}
				$txt .= 'Effet : '.$dmg_reverse.' soins</div>';
						}	
				}
			break;	
			
			// Enchantement
			case 3 :
				
				
				// V�rification que l'enchantement r�ussi
				
				if(($char2 instanceof $char) && $char->getId() != $char2->getId())
				{
					// On tente de le lancer sur un alli�
					if($skill->isUsableOnAlly())
					{
						$effect = new effect($skill->getEffectId(),$skill->getLevel());
						
						$effect->addEffect($char2,'char_id',$skill->getLevel(),$char->getId());
						
						$txt = '<div style="font-size:15px;font-weight:700">'; 
						$txt .= '<div>Vous utilisez <font style="font-family:New Roman;font-size:17px;">'.$skill->getName().'</font> sur '.$char->getName().'<br /><br />';
						$txt .= 'Effet : '.$effect->getName().'</div>';					
					}else{
						$txt = 'Vous ne pouvez lancer cet enchantement que sur vous m&ecirc;me';
					}				
					
				}else{
					
					
					// On tente de le lancer sur soi m�me
					if($skill->isUsableOnHimself())
					{
						if($char instanceof char)
						{
							$effect = new effect($skill->getEffectId(),$skill->getLevel());
							$effect->addEffect($char,'char_id',$skill->getLevel(),$char->getId());
							
							$txt = '<div style="font-size:15px;font-weight:700">'; 
							$txt .= '<div>Vous utilisez <font style="font-family:New Roman;font-size:17px;">'.$skill->getName().'</font> sur vous <br /><br />';
							$txt .= 'Effet : '.$effect->getName().'</div>';								
						}else{
							// Le monstre se buff lui m�me
							$effect = new effect($skill->getEffectId(),$skill->getLevel());
							$effect->addEffect($char,'mstr_id',$skill->getLevel(),$char->getId());
							
							$txt = '<div style="font-size:15px;font-weight:700">'; 
							$txt .= '<div>Le monstre utilise <font style="font-family:New Roman;font-size:17px;">'.$skill->getName().'</font> sur lui<br /><br />';
							$txt .= 'Effet : '.$effect->getName().'</div>';		
						}
				
					
					}else{
						$txt = 'Vous ne pouvez lancer cet enchantement que sur des alli&eacute;s';
					}
	
				}
				break;
				
				case 4:
						
						$effect = new effect($skill->getEffectId(),$skill->getLevel());
						if($pvp)
						{	
							if($char2->getFaction() != $char->getFaction())
							{
									$txt .= '<div>Vous utilisez <font style="font-family:New Roman;font-size:17px;">'.$skill->getName().'</font> sur '.$char2->getName().' <br /><br />';
									$effect->addEffect($char2,'char_id',$skill->getLevel(),$char->getId());
							}else{
								$txt = 'Vous ne pouvez lancer cette mal&eacute;diction sur un membre de votre faction';
							}
						}
						else
						{
							if($char2 instanceof monster)
							{
								$effect->addEffect($char2,'mstr_id',$skill->getLevel(),$char->getId());
							}	
							else
							{
								$txt .= '<div>Le monstre utilise <font style="font-family:New Roman;font-size:17px;">'.$skill->getName().'</font> sur '.$char2->getName().' <br /><br />';
								$effect->addEffect($char2,'char_id',$skill->getLevel(),$char->getId());
							}
								
						}	
				break;
	
				
			break;			
		}	
		
		if($char instanceof char)
		{
			if($expwin == '')
				$expwin = 0;
			
			if($char->getLevel() <= 5 && $expwin == 0)
			{
				$expwin = 1;	
			}
			
			$group_id = group::getGroup($char->getId());
			
			if($group_id >= 1)
			{
				// Si le joueur a un groupe, on g�rera l'exp gagn�e � la mort du monstre (monster_die.function.php)
				$group = new group($group_id);
				
				if($group->getShareExp() != 3)
				{
					$expwin = 0;
				}	
				else
				{
					$lvlup = $char->updateExp($expwin);
					$txt2 .= '<div style="color:black;margin-top:10px;"> Gain :  '.$expwin.' exp';
					$txt2 .= '</div>';
				}
			
			}else
			{
				$lvlup = $char->updateExp($expwin);
				$txt2 .= '<div style="color:black;margin-top:10px;"> Gain :  '.$expwin.' exp';
				$txt2 .= '</div>';
			}
			
			
			
			
			if($lvlup == 1)
			{
				$txt2 .= '<div style="color:green;"><img src="pictures/utils/up.gif" alt="UP" /> Vous montez d\'un niveau</div>';
			}
			
			$char->updateMore('pa',-1);		
		}
	
		$char->updateMana($skill->getManaCost());
		
		$array = array('txt1'=>$txt,'txt2'=>$txt2);		
		
	}else{
		if($char instanceof monster)
		{
			//$char->updateMana($skill->getManaCost());
			$txt = 'Le monstre est trop loin pour vous attaquer. <br />';
			$array = array('txt1'=>$txt);		
			
		}else{
			$txt = 'Vous &ecirc;tes trop loin pour attaquer. <br />';
			$array = array('txt1'=>$txt);	
		}
	}

	
	
	return $array ;
 }
 

//############################################################################################

// Fonction suppl�mentaire de calcul (notamment taux de r�ussite)
// Retourne true si l'attaque est r�ussie
function successAttackChar($char,$char2,$skill,$distance=1)
{
	switch($skill->getTypeSort())
	{
		case 1:
			
			if($distance > 1)
			{
				switch($distance)
				{
					case 2 :
						$malus_dis = -10;
					break;
					case 3 :
						$malus_dis = -20;
					break;
					case 4 :
						$malus_dis = -30;
					break;
					case 5 :
						$malus_dis = -40;
					break;
					default :
						$malus_dis = -50;
					break;
				}
			}else{
				$malus_dis = 0;
			}
			
			if($skill->getTypeDmg() == 'str')
			{
				// Attaque physique
				$valeur_perso = $char->getTot('dex');
				$valeur_cible = round($char2->getTot('dex') * 0.75);
				
				$malus = $valeur_cible - $valeur_perso;
				
				$missing_rate = 10 + $malus + $malus_dis;
				
				if($missing_rate > 80)
					$missing_rate = 80;
					
				// Si taux d'echec = 0, alors attaque r�ussite
				if($missing_rate == 0)
					return true;
				else{
					$rand = mt_rand(1,100);
					
					// Si rand <= taux d'echec , alors attaque �chou�e
					if($rand <= $missing_rate)
						return false;
					else
						return true;
				}		
			}else{
				// Attaque magique
				$valeur_perso = $char->getTot('sag');
				$valeur_cible = round($char2->getTot('res') * 0.75);
				
				$malus = $valeur_cible - $valeur_perso;
				
				$missing_rate = 10 + $malus + $malus_dis;
				
				if($missing_rate > 50)
					$missing_rate = 50;
				
				// Si taux d'echec = 0, alors attaque r�ussite
				if($missing_rate == 0)
					return true;
				else{
					$rand = mt_rand(1,100);
					
					// Si rand <= taux d'echec , alors attaque �chou�e
					if($rand <= $missing_rate)
						return false;
					else
						return true;
				}		
			}		
		break;
		case 2 :
			return true;
		break;
		case 3 :
			return true;
		break;
		case 4 :
			return true;
		break;	
	}
	
	return true;
	
}

function sucessCriticalHit($char,$char2,$skill,$distance=1)
{
	if($skill->getTypeDmg() == 'str')
		$valeur_perso = $char->getTot('dex');
	else
		$valeur_perso = $char->getTot('sag');
	
	
	$valeur_cible = round($char2->getTot('con'));
	
	$bonus = $valeur_cible - $valeur_perso;
					
	$success_rate = 10 + $bonus;
	
	if($success_rate > 80)
		$success_rate = 80;
	
	// Si taux de r�ussite = 0, alors critique �chou�
	if($success_rate == 0)
		return false;
	else{
		$rand = mt_rand(1,100);
		
		// Si rand <= taux de r�ussite , alors critique r�ussi
		if($rand <= $success_rate)
			return true;
		else
			return false;
	}	
}

function decrementeEffect($char,$char2,$pvp=false)
{
	// On d�cr�mente les effets par attaque
	
	// Sur le joueur
	$array_effect_tour = effect::getAllEffectWithTurnDurationOnChar($char->getId());
	foreach($array_effect_tour as $effect_array)
	{
		$effect = new effect('char_id',$effect_array['effect_id'],$char->getId());
		$effect->reduceTourOnChar();
	}
	
	if($pvp)
	{
		$array_effect_tour = effect::getAllEffectWithTurnDurationOnChar($char2->getId());
		foreach($array_effect_tour as $effect_array)
		{
			$effect = new effect('char_id',$effect_array['effect_id'],$char2->getId());
			$effect->reduceTourOnChar();
		}		
	}else{
		// Sur le monstre
		$array_effect_tour = effect::getAllEffectWithTurnDurationOnMonster($char2->getId());
		foreach($array_effect_tour as $effect_array)
		{
			$effect = new effect('mstr_id',$effect_array['effect_id'],$char2->getId());
			$effect->reduceTourOnChar();
		}		
	}

}

function takeDomageOfEffect($char,$char2,$pvp=false)
{
	
	// On inflige les DOT sur le joueur
	$effects_array = effect::getAllDamageEffectOnChar($char);
	
	foreach($effects_array as $effect_array)
	{
		$txt = infligeEffectDamage($effect_array,$char,$char2,$pvp);
	}
	
	if($char2 instanceof monster)
		$effects_array = effect::getAllDamageEffectOnChar($char2,'mstr_id');
	else
		$effects_array = effect::getAllDamageEffectOnChar($char2,'char_id');
		
	foreach($effects_array as $effect_array)
	{
		$txt = infligeEffectDamage($effect_array,$char2,$char,$pvp);
	}
	
	return $txt;
	
}

function infligeEffectDamage($effect_array,$char,$char2,$pvp=false)
{
	$eff = new effect($effect_array['id'],$effect_array['skill_level']);
	
	if($pvp)
		$char->updateLife($eff->getDmg(),$char2->getId());
	else
		$char->updateLife($eff->getDmg());

	$txt = $eff->getPict()." : ".$char->getName()." subit ".$eff->getDmg()." d&eacute;g&acirc;ts <br /><br />";
	
	return $txt;
}


?>
