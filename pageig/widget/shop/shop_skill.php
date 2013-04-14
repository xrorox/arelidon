<?php
/*
 * Created on 21 oct. 2009
 *
 */

if($_GET['action'] != "")
	require_once('require.php');
 
$pnj = new pnj($_GET['pnj']);
$shop = new shop_skill($pnj->fonction_id);
echo '<div class="clear"></div>';

echo '<div>';
	// Contiendra le conteneur de texte
	echo '<div style="float:left;width:560px;border-right:1px;margin-left:10px;">';
		
		echo '<div id="shop_text_container">';
			switch($action)
			{
				case 'buy':
					
					$txt = '<div id="shop_text">';
					$skill = new skill($_GET['skill_id']);
					$qte = $_GET['qte'];
					$price = $skill->getPrice();
					
					if($char->getGold() >= $price)
					{
						if($char->getLevel() >= $skill->getLevelReq())
						{
							$learn = $char->learnSkill($skill->getId());
							if($learn == 1)
							{
								$goldneg = (-1)*$price;
								$char->updateMore('gold',$goldneg);
								$pict = ' <img src="pictures/skill/'.$skill->getId().'.gif" alt="'.$skill->name.'" />';
								$txt .= "<div>Merci pour ton achat de <b>$skill->name </b> $pict </div><br /> <div> pour la somme de <b>$price</b> <img src=\"pictures/utils/or.gif\" title=\"pi&egrave;ce d\'or\" alt=\"or\" /></div>";
								$txt .= "<br /><div> N'h&eacute;sites pas &agrave; revenir me voir tr&egrave;s vite ! </div>";
							}elseif($learn == 2){
								$txt .= "<div> Vous poss&eacute;dez d&eacute;j&agrave; ce sort. </div>";
							}else{
								$txt .= "<div> Vous ne pouvez pas apprendre ce sort </div>";
							}						
						}else{
							$txt .= "<div> Vous n'avez pas le niveau pour apprendre ce sort </div>";
						}


					}else{
						$txt .= " Tu n'a pas suffisament d'or pour t'acheter $qte $skill->name";
					}
					
					$txt .= '</div>';
					
				break;

				default:
					$txt = ' <div id="shop_text">Bienvenue dans le magasin , pour acheter un objet , il vous suffit de cliquer dessus.</div>';
				break;
			}

			$style_add = array('margin-top'=>'20px','height'=>'170px','align'=>'center','width'=>'85%','font-weight'=>'500');
			$style_empty = array();
			createTexte($txt,$style_empty,$style_add);
		echo '</div>';
		
	echo '</div>';
	
	
	
	// Liste des objets que l'utilisateur pourra vendre
	echo '<div  style="float:left;margin-right:5px;margin-top:25px;">';
		echo '<div class="backgroundBody" style="width:200px;">';
		
		echo '<div class="backgroundMenu">';
			echo '<div style="margin-left:15px;">Vos objets</div>';
		echo '</div>';
		echo '<div id="skill_container" style="height:170px;">';
			
			echo '<div style="font-weight:500;text-align:center;"> Votre bourse : '.$char->getGold().' <img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="or" /></div>';
			echo '<div></div>';
			//$char->printItemInTable('','0','25',false,"5",$pnj);
		echo '</div>';
	
	/**
		echo '<div id="Prev/next" style="text-align:center;">';
			echo 'Précédent Suivant';
		echo '</div>';
	*/
		echo '</div>';
	
		echo '<div></div>';
			$link = "ingame.php";
			createButton('Sortir',"",'exit',$link);
	
	echo '</div>';

echo '</div>';


	// Liste des objets en vente
	echo '<div  style="float:left;margin-right:5px;margin-top:5px;margin-left:20px;">';
		echo '<div class="backgroundBody" style="width:380px;">';
		
		echo '<div class="backgroundMenu">';
			echo '<div style="margin-left:15px;"> Sorts en vente</div>';
		echo '</div>';
		echo '<div id="skill_container" style="height:120px;">';
			echo '<div></div>';
			
			$shop->loadItemCollection();
			$skill_collection = $shop->getItemCollection();
			$i = 1;
			$j = 1;
			
			/**
			 * @ paramètre du tableau : 
			 */
			$limiteByLine = 15; 
			$url_target = "pageig/shop/text_shop_skill.php?action=buy&pnj=".$pnj->id;
			$div_target = "shop_text";
			 
			$str .= '<table>';	
			$count = count($skill_collection);		
			
			
			foreach($skill_collection as $skill_id)
			{
				$skill = new skill($skill_id);			
	
				if($i == 1 or $j == 1)
					$str .= '<tr>';	
				
				$url_picture = 'pictures/skill/'.$skill->getId().'.gif';
				$text = $skill->getDescription();
				
				// Création du onclick si besoin		
				$url_onclick = $url_target."&skill_id=".$skill->getId();
				$target = $div_target;
		
				if($target != "")	
					$onclick = "HTTPTargetCall('$url_onclick','$target');";
				else
					$onclick = "";
		
				$style = "";
				$spanstyle= "width:150px;";
				
				$str .= '<td>';
				$str .= imgWithTooltip($url_picture,$text,$onclick,'',$style,$spanstyle,'true');
				$str .= '</td>';

				if($j == $limiteByLine or $i == $count)
				{
					$str .= '</tr>';
					$j = 0;
				}	
				
				$i++;	
				$j++;
				
			}
		$str .= '</table>';	
		
		echo $str;
			
		echo '</div>';
		echo '</div>';
	
	echo '</div>';
	
	// Le Pnj qui vend
	echo '<div  style="float:left;margin-right:5px;margin-top:5px;margin-left:20px;">';
		echo '<div class="backgroundBody" style="width:150px;">';
		
		echo '<div class="backgroundMenu">';
			echo '<div style="margin-left:15px;"> Marchand </div>';
		echo '</div>';
		echo '<div id="face_container" style="height:120px;">';
			echo '<div style="text-align:center;margin-top:15px;">';
				echo '<img src="pictures/face/'.$pnj->face.'" style="border:solid 2px black;background:grey;" />';
			echo '</div>';
		echo '</div>';
		echo '</div>';
	
	echo '</div>';

?>
