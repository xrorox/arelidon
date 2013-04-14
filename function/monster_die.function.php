<?php
/*
 * Created on 9 oct. 2009
 */
 require_once($server.'/class/step.class.php');
function action_on_monster_die($char,$monster)
{
	
	$old_abs = $monster->abs;
	$old_ord = $monster->ord;

	// On respawn le monstere
	$monster->updateRespawn();	

	
	// r�cup�ration des �tapes en cours :
	$step_list = step::getAllStepDoing($char);
	
	// Pour chaque qu�te en cours on met � jours
	if(count($step_list >= 1) && is_array($step_list))
	{
		foreach($step_list as $step)
		{
			$step = new step($step['id']);
			$step->upGet($char,$monster->getIdMstr());
		}		
	}

	// Gestion des drops
	$gold_win_theory = $monster->level * 2;
	$bonus = ($gold_win_theory * mt_rand(-25,25)) / 100;
	$gold_win = round($gold_win_theory + $bonus);
	
	if($char->isVip());
		$goldwin = round($goldwin * 1.25);
	

	$group_id = group::getGroup($char->getId());
	if( !empty($group_id))
	{
		
		$group = new group($group_id);
		
		$members_list_result = $group->getMembersList();
		$i = 0;
		foreach($members_list_result as $member)
		{
			$members_list[$i] = new char($member['char_id']);
			$i++;
		}
		
		$exp_tot = $monster->getExp();
		
if ( $i == 1){
	
// Gestion de l'�cart de niveau
	if($group->getShareExp() != 3)
	{
		if($monster->getLevel() != $char->getLevel())
		{
			$ecart_level = $char->getLevel() - $monster->getLevel();
			if($ecart_level > 10)
				$ecart_level = 9.5;
			if ( $ecart_level < -5){
								$malus_exp=0;
							}
							elseif( $ecart_level < -10){
								$expwin=2;
							}
							else{
	
			$malus_exp = (($ecart_level) * 0.1) * $exp_tot; // 10% de perte par �cart de niveau
			$expwin = $exp_tot - $malus_exp;
							}
			if($expwin < 0)
				$expwin = 0;
			
			$exp_win = round($expwin);
			$exp_to_win = 1;
			
			$char->updateExp($exp_win);
		}		
		
	}
	
	
	
}	else{	
		// Partage de l'exp		
		switch($group->getShareExp())
		{
			// Partage par niveau
			case 1 :
				foreach($members_list as $memb)
					$sum_level = $sum_level + $memb->getLevel();
				
				for($i=0;$i<$group->getNumberInGroup();$i++)
				{
					$exp_win_member = round($exp_tot * ($members_list[$i]->getLevel()/$sum_level));
					
					// Gestion de l'�cart de niveau
					if($monster->getLevel() != $members_list[$i]->getLevel())
					{
						$ecart_level = $members_list[$i]->getLevel() - $monster->getLevel();
						if($ecart_level > 10)
							$ecart_level = 10;
						
						$malus_exp = (($ecart_level) * 0.1) * $exp_win_member; // 20% de perte par �cart de niveau

						$expwin = $exp_win_member - $malus_exp;

						if($expwin < 0)
							$expwin = 0;
					}
					
					$members_list[$i]->updateExp($expwin);
					
					if($members_list[$i]->getId() == $char->getId())
					{
						$exp_win = $expwin;
						$exp_to_win = 1;
					}		
					
				}	
			break;
			
			// Partage �gal
			case 2 :
				for($i=0;$i<$group->getNumberInGroup();$i++)
				{
					$exp_win_member = round($exp_tot / $group->getNumberInGroup());
					
					// Gestion de l'�cart de niveau
					if($monster->getLevel() != $members_list[$i]->getLevel())
					{
						$ecart_level = $members_list[$i]->getLevel() - $monster->getLevel();
						if($ecart_level > 10)
							$ecart_level = 5;
						
						$malus_exp = (($ecart_level) * 0.1) * $exp_win_member; // 20% de perte par �cart de niveau
						$expwin = $exp_win_member - $malus_exp;
						
						if($expwin < 0)
							$expwin = 0;
					}
					
					$members_list[$i]->updateExp($expwin);
					
					if($members_list[$i]->getId() == $char->getId())
					{
						$exp_win = round($expwin);
						$exp_to_win = 1;
					}

					
				}	
			break;
			
			// Chacun pour soi
			case 3 :
			
			break;
		}
}
	
		switch($group->getShareGold())
		{
			// Partage par niveau
			case 1 :
				foreach($members_list as $memb)
					$sum_level = $sum_level + $memb->getLevel();
				
				for($i=0;$i<$group->getNumberInGroup();$i++)
				{
					$gold_win_member = round($gold_win * ($members_list[$i]->getLevel()/$sum_level));
					$members_list[$i]->updateMore('gold',$gold_win_member);
					
					if($members_list[$i]->getId() == $char->getId())
						$gold_win = $gold_win_member;
				}	
				
			break;
			
			// Partage �gal
			case 2 :
				$gold_per_member = round($gold_win / $group->getNumberInGroup());
				
				for($i=0;$i<$group->getNumberInGroup();$i++)
				{
					$char_object = $members_list[$i];
					$char_object->updateMore('gold',$gold_per_member);
				}
				
				$gold_win = $gold_per_member;
			break;
			
			// Chacun pour soi
			case 3 :
				$char->updateMore('gold',$gold_win);
			break;
		}
	
	}else{
		$char->updateMore('gold',$gold_win);
	}


	// Affichage du texte	
	$str .= '<hr />';
	$str .= '<div>';
		
		$str .= '<div style="padding-left:5px;"> Gains : </div>';
		
		if($exp_to_win > 0)
		{
			
			$str .= '<div style="margin-top:4px;padding-left:15px;">';
			$str .= 'exp : '.$exp_win;
			$str .= '</div>';			
		}
		
		$str .= '<div style="margin-top:4px;padding-left:15px;">';
		$gold_string = getGoldPict(true);
		$str .= 'or gagn&eacute; : '.$gold_win.' '.$gold_string;
		$str .= '</div>';
		
		
		
		
		$drop_array = $monster->getDrops();
		$nb_drop = 0;
		
		foreach($drop_array as $drop)
		{
			// G�n�ration d'un nombre al�atoire pour voir si l'objet tombe
			$rand = mt_rand(0,1000);
			
			$ratio_bonus = 0;
			$ratio_bonus = ($char->getTot('cha') / 100);
			
			
			$drop_bonus = $drop['pourcent'] * $ratio_bonus;
		
			$drop_base = $drop['pourcent'];
			
			if($char->isVip())
				$drop_base = $drop_base + ($drop_base * 0.5);
				
			$rand_drop = $drop_base + $drop_bonus;
			
			if($rand_drop > 80)
				$rand_drop = 80;
			
			$chance = $rand / 10;
			
			if($chance < $rand_drop)
			{
				// R�ussi
				item::addItemOnMap($drop['item'],$monster->map,$old_abs,$old_ord);
				$item = new item($drop['item']);
				
				$str2 =  '<div class="boutonItem" style="margin-top:5px;height:30px;width:98%;border:solid 1px black;color:black;font-size:13px;">';
				
					$str2 .= '<img src="pictures/item/'.$item->item.'.gif" alt="Objet" title="'.$item->name.'" style="margin-left:5px;margin-right:5px;" /> ';
					$str2 .= $item->name;
					$str2 .=  '<div style="float:right;margin-right:5px;margin-top:2px;">';
						$url = "include/menuig.php?refresh=1&mode=ramasser&item_ramasse=".$item->item."&abs_char=".$old_abs."&ord_char=".$old_ord;
						$onclick = "HTTPTargetCall('$url','menuig')";
						$str2 .=  '<img src="pictures/utils/hand.gif" alt="Prendre" title="Ramasser l\'objet" style="cursor:pointer;" onclick="'.$onclick.';refreshMap();" />';
					$str2 .=  '</div>';
			
				$str2 .=  '</div>';
				$nb_drop++;
			}
		}
		
		if($nb_drop >= 1)
		{
			$str .= '<div style="padding-left:5px;margin-top:8px;"> Objets tomb&eacute;s : </div>';
			$str .= '<div style="padding-left:15px;">';
				$str .= $string;
			$str .= '</div>';			
		}
		
		$str .= $str2;
		
		

		
	$str .= '</div>';

	return $str;
	
}
 
?>
