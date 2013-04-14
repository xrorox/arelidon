<?php
/*
 * Created on 31 mai 2010
 */
require_once("class/skin.class.php");

echo  '<div style="text-align:center;height:30px;"></div>';
 
if($_GET['confirm'] == 1)
{
	if($char->canUsePoint())
	{
		switch($_GET['sub_sub_page'])
		{
			case 'moreChar':
				
				if($char->getUser()->getMoreChar() == 0)
					if($char->getPoints() >= 300)
					{
						$sql = "UPDATE users SET moreChar = 1 WHERE id = ".$char->getIdaccount();
						loadSqlExecute($sql);
						
						$char->updateMore('points',-300,1);
						$confirm = true;
					}	
					else
						$error = "Vous n'avez pas assez de points pour cette option";
				else
					$error = "Vous avez d&eacute;j&agrave; cette option";
			break;
			
			case 'morePA':
				
				if($char->timeBeforeCanBuyPA() > 1 * 24 * 3600)
					if($char->getPoints() >= 100)
					{
						$char->updateMore('pa',250);
						$sql = "INSERT INTO `log_morePA` (char_id,timestamp) VALUES (".$char->getId().",".time().") ON DUPLICATE KEY UPDATE timestamp = ".time();
						loadSqlExecute($sql);
						
						$char->updateMore('points',-100,2);
						$confirm = true;
					}	
					else
						$error = "Vous n'avez pas assez de points pour cette option";
				else
				{
					$error = "Vous ne pouvez pas encore acheter de points d'Actions. Temps restant : ".convertSecondToHour(1 * 24 * 3600 - $char->timeBeforeCanBuyPA());
				}	
			break;
			
			case 'morePP':
				
					if($char->getPoints() >= 100)
					{
						$char->updateMore('pp',200);
						
						loadSqlExecute($sql);
						
						$char->updateMore('points',-100,8);
						$confirm = true;
					}	
					else
						$error = "Vous n'avez pas assez de points pour cette option";
			break;
			
			case 'moreGold':
				if($char->getPoints() >= 100)
				{
					$goldmore = getGoldForLevel($char->getLevel());
					$char->updateMore('gold',$goldmore);
					
					$char->updateMore('points',-100,3);
					$confirm = true;
				}	
				else
					$error = "Vous n'avez pas assez de points pour cette option";
	
			break;
			
			case 'moreVIP':
				
				if($char->getPoints() >= 100)
				{
					$vip = $char->vip;
	
					if($vip < time())
						$vip = time();
					
					$moreVIP = $vip + (15 * 24 * 3600);
					
					$char->update('vip',$moreVIP);
					
					$char->updateMore('points',-100,4);
					
					$confirm = true;
									
				}	
				else
					$error = "Vous n'avez pas assez de points pour cette option";
	
			break;
			case 'box':
				
				if($char->getPoints() >= 100)
				{
					$bank = new bank();
					$bank->loadBank($char->getId());
					$bank->addPlace(100);
					
					$char->updateMore('points',-100,5);
					
					$confirm = true;
									
				}	
				else
					$error = "Vous n'avez pas assez de points pour cette option";
			break;		
			
			case 'shop': //skins
				$skin_id = $_GET['skin_id'];
				$skin = new skin($skin_id);
				
				if($char->getPoints() >= $skin->getPrice())
				{
					$skin->addToUser($user->getId());
					$confirm = true;
					
					$char->updateMore('points',-1*$skin->getPrice(),6);
					
				}else{
					$error = "Vous n'avez pas assez de points pour ce skin";
					$confirm = false;
				}
			break;
			case 'magasin':
			
				$item= new item($_GET['item']);
				if($char->getPoints() >= $item->price)
				{
					$item->addItemToChar($char->GetId(),1);
					$char->updateMore('points',-1*$item->price,7);
				}else{
					$error = "Vous n'avez pas assez de points pour ces objets";
					$confirm = false;
				}
			break;
		}
		
		echo '<div style="margin-left:120px;">';
			if($confirm)
				echo printConfirm("Votre achat a bien &eacute;t&eacute; valid&eacute;",true,"white");
			else
				echo printAlert($error,true,"white");
		echo '</div>';
	
		echo  '</div>';		
	}else{
		echo "<div>".printConfirm("Votre achat a bien &eacute;t&eacute; valid&eacute;",true,"white")."</div>";
	}
	
}
else
{
	echo  '<div style="text-align:center;">';
	
	switch($_GET['sub_sub_page'])
	{
		case 'moreChar':
			echo  'L\'option "Personnage suppl&eacute;mentaire" vous permet de cr&eacute;er un troisi&egrave;me personnage (300 points) ';
			
			if($char->getUser()->getMoreChar() == 0)
				if($char->getPoints() >= 300)
					$confirm = true;
				else
					$error = "Vous n'avez pas assez de points pour cette option";
			else
				$error = "Vous avez d&eacute;j&agrave; cette option";
		break;
		
		case 'morePA':
			echo  'L\'option "PA suppl&eacute;mentaires" vous permet d\'obtenir des PA une fois par jour (100 points = 250 PA) ';
			
			if($char->timeBeforeCanBuyPA() > 1 * 24 * 3600)
				if($char->getPoints() >= 100)
					$confirm = true;
				else
					$error = "Vous n'avez pas assez de points pour cette option";
			else
			{
				$error = "Vous ne pouvez pas encore acheter de points d'Actions. <br /> Temps restant : ".convertSecondToHour(1 * 24 * 3600 - $char->timeBeforeCanBuyPA());
			}	
		break;
		
		case 'morePP':
			echo  'L\'option "PP suppl&eacute;mentaires" vous permet d\'obtenir des PP (100 points = 200 PP). Attention la limite de pp stock&eacute;e est de 400, ce nombre ne peut &ecirc;tre d&eacute;pass&eacute;.';

				if($char->getPoints() >= 100)
					$confirm = true;
				else
					$error = "Vous n'avez pas assez de points pour cette option";	
		break;
		
		case 'moreGold':
			$goldmore = getGoldForLevel($char->getLevel());
			echo  'L\'option "OR suppl&eacute;mentaire" vous permet d\'obtenir '.$goldmore.' pi&egrave;ces (d&eacute;pend de votre niveau) pour 100 pointsq. ';
			
			if($char->getPoints() >= 100)
				$confirm = true;
			else
				$error = "Vous n'avez pas assez de points pour cette option";

		break;
		
		case 'moreVIP':
			$goldmore = getGoldForLevel($char->getLevel());
			echo  '100 points vous permet de devenir VIP durant 15 jours . <br /> <br />' .
					' Bonus VIP : <br /> ' .
					'+ 50% de drop suppl&eacute;mentaire <br />' .
					'+ 25% d\'or gagn&eacute; suppl&eacute;mentaire' .
					'<br /><br />';
			
			if($char->isVip())
				echo  'Vous &ecirc;tes encore VIP pendant : '.convertSecondToHour($char->getVip() - time());
				
			
			if($char->getPoints() >= 100)
				$confirm = true;
			else
				$error = "Vous n'avez pas assez de points pour cette option";

		break;
		
		case 'box':
			$goldmore = getGoldForLevel($char->getLevel());
			echo  '100 points vous permet d\'augmenter 100 de place suppl&eacute;mentaire dans votre coffre . <br />';
			
			if($char->getPoints() >= 100)
				$confirm = true;
			else
				$error = "Vous n'avez pas assez de points pour cette option";

		break;
		
		case 'shop':
			require_once('boutique.php');
		break;
		
		case 'magasin':
			require_once('magasin.php');
		break;
		
		
	}
	
	if($confirm)
	{
		echo  '<br /><br />';
		
		$onclick="HTTPTargetCall('ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=".$_GET['sub_sub_page']."&confirm=1&skin_id=".$skin_id."','subbody');";
		
		echo  '<input class="button" type="button" style="height:30px;" onclick="'.$onclick.'" value="Confirmer l\'achat" />';
		
	}else{
		
		if($_GET['sub_sub_page'] != '')
		{
			echo  '<br /><br />';
			echo printAlert($error,true,"white");			
		}

	}
	
	
	echo  '</div>';

	
}
 
 
 
 
 
 
?>
