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
			<table border="0" width="436" height="411" style="border: 1px solid #E5E3FF;margin:auto;" cellpadding="0" cellspacing="0">
			 <tr>
			  <td colspan="2" width="436">
			   <table width="436" border="0" cellpadding="0" cellspacing="0">
			    <tr height="27">
			     <td width="127" align="left" bgcolor="#D0D0FD">
			      <a href="http://www.allopass.com/" target="_blank"><img src="http://payment.allopass.com/imgweb/common/access/logo.gif" width="127" height="27" border="0" alt="Allopass"></a>
			     </td>
			         <td width="309" align="right" bgcolor="#D0D0FD">
			      <font style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000084; font-style : none; font-weight: bold; text-decoration: none;">
			       Solution de micro paiement sécurisé<br>Secure micro payment solution
			      </font>
			     </td>
			    </tr>
			    <tr height="30">
			     <td colspan="2" width="436" align="center" valign="middle" bgcolor="#F1F0FF">
			      <font style="font-family: Arial, Helvetica, sans-serif; font-size: 9px; color: #000084; font-style : none; font-weight: bold; text-decoration: none;">
			       Pour acheter ce contenu, insérez le code obtenu en cliquant sur le drapeau de votre pays      </font>
			      <br>
			      <font style="font-family: Arial, Helvetica, sans-serif; font-size: 9px; color: #5E5E90; font-style : none; font-weight: bold; text-decoration: none;">
			       To buy this content, insert your access code obtained by clicking on your country flag
			      </font>
			     </td>
			    </tr>
			        <tr height="2"><td colspan="2" width="436" bgcolor="#E5E3FF"></td></tr>
			   </table>
			  </td>
			 </tr>
			 <tr height="347">
			  <td width="284">
			   <iframe name="APsleft"  width="284" height="347" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="http://payment.allopass.com/acte/scripts/iframe/left.apu?ids=216949&amp;idd=864446&amp;lang=fr"></iframe>
			  </td>
			  <td width="152">
			   <iframe name="APsright" width="152" height="347" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="http://payment.allopass.com/acte/scripts/iframe/right.apu?ids=216949&amp;idd=864446&amp;lang=fr"></iframe>
			  </td>
			 </tr>
			 <tr height="5"><td colspan="2" bgcolor="#D0D0FD" width="436"></td></tr>
			</table>	
			
			<hr />
			
			<div style="text-align:center;font-weight:700;">
				Les paiements paypal sont généralement validé sous 24 à 48h. Après votre paiement 
				n'hésitez pas à envoyer un message privé à Admin(dans le jeu) en précisant le numéro 
				de transaction
			</div>
			
			<div style="margin-top:25px;text-align:center;">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
				">
				<input type="image" src="https://www.paypal.com/fr_FR/FR/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
				<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
			</form>
			
			</div>
					
			<?php
			}
		break;
		
		
	}
	
	
	
	
	
 echo '</div>';
 
?>
