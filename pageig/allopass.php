<?php
/*
 * Created on 13 mai 2010
 */

 echo '<div style="min-height:700px;">';
	
	echo '<hr />';
	echo '<div style="margin-top:5px;margin-left:25px;">';
		echo '<a href="ingame.php?page=allopass&sub_page=getPoints">';
 			echo '<input style="width:180px;height:30px;" type="button" class="button" value="Obtenir des points" />';
 		echo '</a>';
 		
 		//echo ' <a href="ingame.php?page=allopass&sub_page=usePoints">';
 		$onclick="HTTPTargetCall('ingame.php?page=allopass&sub_page=usePoints','subbody');";
 		//?page=allopass&sub_page=usePoints
 			echo "<input style='width:180px;height:30px;' onclick=".$onclick." type='button' class='button' value='Utiliser vos points' />";
 		//echo '</a>';
 		
 		echo ' <a href="ingame.php?page=allopass&sub_page=help">';
 			echo '<input style="width:180px;height:30px;" type="button" class="button" value="Aide" />';
 		echo '</a>';
 		
 		echo ' <a href="#">';
 			echo '<input style="width:180px;height:30px;" type="button" class="button" value="Vos points : '.$char->getPoints().'" />';
 		echo '</a>';
 		
 		
	echo '</div>';
	echo '<hr />';	
	
	switch($_GET['sub_page'])
	{
		case 'usePoints':
			echo '<div style="margin-top:5px;margin-left:25px;">';
	 			$onclick="HTTPTargetCall('ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=moreChar','subbody');";
	 			echo '<input style="width:120px;height:25px;" type="button" class="button" onclick="'.$onclick.'" value="3&egrave;me personnage" />';
	 			
	 			$onclick="HTTPTargetCall('ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=morePA','subbody');";
	 				echo '<input style="width:120px;height:25px;" type="button" class="button" onclick="'.$onclick.'" value="PA suppl&eacute;mentaire" />';
	 			echo '</a>';
	 			
	 			$onclick="HTTPTargetCall('ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=moreGold','subbody');";
	 			echo '<input style="width:120px;height:25px;" type="button" class="button" onclick="'.$onclick.'" value="OR suppl&eacute;mentaire" />';
	 			echo '</a>';
	 			
	 			$onclick="HTTPTargetCall('ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=moreVIP','subbody');";
	 				echo '<input style="width:120px;height:25px;" type="button" class="button" onclick="'.$onclick.'" value="Devenir VIP" />';
	 			echo '</a>';
	 			
	 			$onclick="HTTPTargetCall('ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=box','subbody');";
	 				echo '<input style="width:120px;height:25px;" type="button" class="button" onclick="'.$onclick.'" value="Coffre" />';
	 			echo '</a>';
	 			
	 			$onclick="HTTPTargetCall('ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=shop','subbody');";
	 				echo '<input style="width:120px;height:25px;" type="button" class="button" onclick="'.$onclick.'" value="Skins" />';
	 			echo '</a>';
	 			
	 			$onclick="HTTPTargetCall('ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=morePP','subbody');";
	 				echo '<input style="width:120px;height:25px;" type="button" class="button" onclick="'.$onclick.'" value="PP supl&eacute;mentaires" />';
	 			echo '</a>';
	 			
	 			$onclick="HTTPTargetCall('ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=magasin','subbody');";
	 				echo '<input style="width:120px;height:25px;" type="button" class="button" onclick="'.$onclick.'" value="Magasin " />';
	 			echo '</a>';
	 			
	 		echo '</div>';
	 		
	 		echo '<hr />';
	 		
	 		require_once('allopass/gestionConfirm.php');
	 		echo $str;
	 		
	 		
		break;
		
		case 'help':
			echo 'help';
		break;
		
		default:
			
			if($_GET['confirm_buy'] == 1)
			{
				printConfirm("Merci de votre achat, vous pouvez maintenant d&eacute;pensez vos points.",false,"white");
			}else{
			?>
			<div style="text-align:center;">
				<b> 1 Allopass = 100 Points || 5€ par paypal = 350 points</b><br /><br />
				
				<!-- 
					<h3><span style="color:red"> Exceptionnellement ce samedi 6 novembre, les gains de points sont doublés ! (tout achat par paypal daté du 6 nov sera doublé aussi) </span></h3>
				 -->
			</div>
			
			
			<hr />
			
			<div style="text-align:center;font-weight:700;">
				Les paiements paypal sont généralement validé sous 24 à 48h. Après votre paiement 
				n'hésitez pas à envoyer un message privé à Admin(dans le jeu) en précisant le numéro 
				de transaction
			</div>
			
			<div style="margin-top:25px;text-align:center;">
			
			
			</div>
					
			<?php
			}
		break;
		
		
	}
	
	
	
	
	
 echo '</div>';
 
?>
