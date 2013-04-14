<?php

require_once('../../require.php');
require_once($server.'class/recette.class.php');
$metier = new metier();
$metier->loadMetierJoinChar($_GET['id'],$char->getId());

echo '<div style="height:25px;margin-top:7px;padding-left:20px;width:100%;background-image:url(\'css/design/fond-menu-black.png\');border-top:solid 1px black;border-bottom:solid 1px black">';
	// Icone du métier
	echo '<div style="float:left;margin-left:120px;">';
		echo '<img src="pictures/metier/'.strtolower($metier->getName()).'.gif" alt="'.$metier->getName().'"';
	echo '</div>';	
	
	echo '<div style="float:left;margin-left:20px;font-size:18px;">';
		echo $metier->getName();
	echo '</div>';


echo '</div>';

echo '<div class="backgroundBodyNoRadius" style="width:628px;">';
	echo '<div style="margin-top:20px;padding-left:40px;">';
		
		// Listes des outils utilisables :
		$onclick = "show('outils_container');switchArrow('arrow_outils');";
		echo '<div onclick="'.$onclick.'" style="cursor:pointer;">' .
				'<img id="arrow_outils" src="pictures/utils/arrow_right.gif" alt=">" />' .
				' Outils utilisables :' .
			 '</div>';
		
		echo '<div id="outils_container" style="display:block;margin-left:30px;margin-top:7px;">';
			foreach($metier->getOutils() as $outil)
			{
				$imgurl = "pictures/item/".$outil['id'].".gif";
				$txt = $outil['name'];
				imgWithTooltip($imgurl,$txt,'','','width:120px;');
			}
		echo '</div>';
	echo '</div>';
	
	if($metier->hasRecolte())
	{
		echo '<div style="margin-top:20px;padding-left:40px;">';
			
			// Listes des ressources récoltable :
			$onclick = "show('ressources_container');switchArrow('arrow_ressources');";
			echo '<div onclick="'.$onclick.'" style="cursor:pointer;">' .
					'<img id="arrow_ressources" src="pictures/utils/arrow_right.gif" alt=">" />' .
					' Ressources r&eacute;coltables :' .
				 '</div>';
			
			echo '<div id="ressources_container" style="display:block;margin-left:30px;margin-top:7px;">';
				foreach($metier->getRessourcesRecotable() as $ressource)
				{
					$imgurl = "pictures/item/".$ressource['id'].".gif";
					$txt = $ressource['name'];
					imgWithTooltip($imgurl,$txt,'','','width:120px;');
				}
			echo '</div>';
		echo '</div>';	
	}
	
	if($metier->hasRecette())
	{
		echo '<div style="margin-top:20px;padding-left:40px;">';
			
			// Listes des recettes disponnibles :
			$onclick = "show('recettes_container');switchArrow('arrow_recettes');";
			echo '<div onclick="'.$onclick.'" style="cursor:pointer;">' .
					'<img id="arrow_recettes" src="pictures/utils/arrow_right.gif" alt=">" />' .
					' Recettes disponnibles :' .
				 '</div>';
				 
			$recettes = recette::getAllRecettes($metier->getId(),$metier->getLevel(),$_GET['nb_ingredient']);
			
			echo '<div id="recettes_container" style="display:block;margin-left:30px;margin-top:7px;">';
				echo '<table style="margin-left:0px;text-align:center;">';
				
				
				
				
				foreach($recettes as $recette_info)
				{
					echo '<tr>';
					$recette = new recette($recette_info['id']);
					
					$compte = 0;
					for($i=4;$i>=0;$i--)
					{
						if($recette->getNumberOfIngredient() >= ($i + 1))
						{
							echo '<td style="width:60px;text-align:center;">';
					
							if($compte >0)
								echo ' + ';
								
							$ingredient_array = $recette->getIngredientArray();
							$ingredient = new item($ingredient_array[$i]['objet']);
							
							echo $ingredient_array[$i]['nb_objet'];
							$ingredient->getPicture();
									
							echo '</td>';
					
					
							$compte++;
						}else{
							echo '<td style="width:50px;"></td>';
						}
						
					}
					
					echo '<td style="width:30px;text-align:center;"> = </td>';
					
					$objet_win = new item($recette->getObjetWin());
					echo '<td style="width:50px;">';
						echo $recette->getNbObjetWin();
						$objet_win->getPicture();
					echo '</td>';
				
					echo '<td>';
						$url = "page.php?category=atelier&action=do_craft&recette_id=".$recette->getId();
						$onclick = "HTTPTargetCall('".$url."','div_craft');";
					echo '</td>';
				}				
				echo '</tr>';

				echo '</table>';
			echo '</div>';
		echo '</div>';	
	}
echo '</div>';
?>