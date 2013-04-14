<?php
 
require_once('../../require.php');
require_once('effect_description.php');
require_once($server.'class/effect.class.php');

if($_GET['skill_id'] >= 1)
{
	/* TODO */
	
//	$skill = new skill($_GET['skill_id'],$char->getId());
//	echo '<div style="margin:10px;">';
//		
//		// title
//		echo '<div style="height:40px;">';
//			echo '<div style="float:left;">';
//				echo '<img src="pictures/skill/'.$skill->id.'.gif" alt="" />';
//			echo '</div>';
//			
//			echo '<div>';
//				echo '<div style="padding-left:70px;font-size:17px;font-weight:600;width:80%;font-family:New Roman;">';
//					echo $skill->getName();
//				echo '</div>';
//				echo '<div style="padding-left:120px;font-size:12px;font-weight:400;float:left;">';
//					switch($skill->getTypeSort())
//					{
//						case '1':
//							echo 'Attaque/sort';
//						break;
//						case '2':
//							echo 'Soin';
//						break;
//						case '3':
//							echo 'Enchantement';
//						break;
//						case '4':
//							echo 'Mal&eacute;diction';
//						break;
//						case '5':
//							echo 'Passive';
//						break;
//					}
//						
//					echo '<a href="#" style="text-decoration:none;'.$stylea.'" class="tooltip">';
//						echo ' <img src="pictures/utils/help16x16.gif" style="width:12px;height:12px;border:0px;" />';
//					echo '<em style="margin-top:5px;min-width:200px;"><span></span> ';
//						echo 'Il y a 5 types de comp&eacute;tences, les ataques/sorts, qui sont les comp&eacute;tences offensives. Les soins pour se reg&eacute;n&egrave;rer' .
//								' Les mal&eacute;dictions, utilis&eacute;es pour affaiblir l\'ennemi, contrairement aux enchantements qui sont utilis&eacute;s' .
//								' pour vous am&eacute;liorer. Et enfin les passives qui n\'ont pas besoin d\'&ecirc;tre lanc&eacute;s';
//					echo ' </em></a>';
//				echo '</div>';
//				
//				echo '<div style="float:right;margin-top:-20px;width:32px;height:32px;background-image:url(\'pictures/utils/cadre32x32.png\');">';
//					echo '<div class="number" style="margin:6px;margin-left:12px;font-weight:700;font-size:17px;">';
//						echo $skill->level;
//					echo '</div>';
//				echo '</div>';
//			echo '</div>';
//		echo '</div>';
//		
//		// Description du sort
//		echo '<div style="margin-top:5px;padding-left:80px;padding-right:80px;">';
//			echo $skill->getDescription();
//		echo '</div>';
//		
//		// Infos compl�mentaire
//		
//		echo '<div style="margin-top:15px;font-weight:700;">';
//			echo '<div style="float:left;margin-left:0px;height:80px;width:40%;border-right:solid 1px black;text-align:right;padding-right:30px;">';
//				echo '<div>';
//					if($skill->getDmg($char,true) >= 0)
//						echo ' D&eacute;g&acirc;ts : '.$skill->getDmg($char,true);
//					else{
//						$heal = $skill->getDmg($char,true) * (-1);
//						echo ' Soin : '.$heal;
//					}
//				
//				echo '</div>';
//				
//				echo '<div style="margin-top:5px;">';
//					if($skill->getTypeSort() <= 2)
//						echo ' Caract : '.$skill->getBase();
//					else
//						echo ' Caract : aucune';
//				echo '</div>';
//			
//				echo '<div style="margin-top:5px;">';
//					if($skill->getEffectId() >= 1)
//					{
//						echo ' Effet : ';
//						echo ''.$skill->getEffectPourcent().'% ';
//						
//						showEffectInfo($skill);
//					}else
//						echo ' Effet : aucun';
//				echo '</div>';
//				
//			echo '</div>';
//		
//			echo '<div style="float:left;margin-left:30px;height:100px;width:40%;">';
//				echo '<div>';
//					echo ' Mana : '.$skill->getManaCost();
//				echo '</div>';
//				
//				echo '<div style="margin-top:5px;">';
//					echo ' Pa : 1';
//				echo '</div>';
//			
//				echo '<div style="margin-top:5px;">';
//					echo ' Port&eacute;e : '.$skill->getRangeMin().'-'.$skill->getRangeMax();
//				echo '</div>';
//			echo '</div>';			
//			
//			echo '</div>';
//		
//		echo '</div>';
//	
//		// bouton permettant d'augmenter le sort'
//		echo '<div style="text-align:right;padding-right:25px;padding-bottom:5px;">';
//			// Delete in new version
//		echo '</div>';	
	
	
	echo '</div>';
}else{
	echo 'pas de sort s&eacute;l&eacute;ctionn&eacute;';
}
?>
