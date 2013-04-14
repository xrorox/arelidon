<?php
/*
 * Created on 2 févr. 2010
 */

/**
 * 
 * Liste des réglages
 * 
 *  Type de déplacement : 
 *  	1)  1 => déplacement clavier
 *     		2 => déplacement flèche
 *  
 *  Type de déplacement clavier
 *  	2)  1 => flèche clavier
 *      	2 => azerty
 *      	3 => qwerty
 * 
 *  Type de déplacement par flèche
 *  	3)  1 => flèche
 *      	2 => carré
 * 
 * 
 */

if($_GET['confirm'] == 1)
{
	unset($_POST['undefined']);
	foreach($_POST as $regulating=>$value)
	{
		$char->updateRegulating($regulating,$value);
	}
	echo '<div style="margin-top:20px;margin-left:50px;">';
		printConfirm('La mise &agrave; jours a bien &eacute;t&eacute; prise en compte');
	echo '</div>';
	echo '<br /><br />';
}

$array = $char->loadRegulating();	

echo '<div style="margin-top:20px;width:90%;margin-left:5%;">';

	echo '<fieldset>';
		echo '<legend> R&eacute;glages </legend>';


		echo '<form id="form_regulating" method="POST">';
		echo '<p>';
		
			echo '<u> Type de d&eacute;placement </u> <br /><br />';
			
			if($array['1'] == 3){
				$checked3 = 'checked=checked';
				$display3 = 'block';
				$display2 = 'block';
			}elseif($array['1'] == 2)
			{
				$checked2 = 'checked=checked';
				$display3 = 'block';
				$display2 = 'none';
			}else{
				$checked1 = 'checked=checked';
				$display2 = 'block';
				$display3 = 'block';
			}
			
			echo '<input type="radio" name="1" value="1"  onclick="show(\'regulating_2\');hide(\'regulating_3\');" '.$checked1.' /> D&eacute;placement au clavier <br />';
			echo '<input type="radio" name="1" value="2" onclick="show(\'regulating_3\');hide(\'regulating_2\');" '.$checked2.'  /> D&eacute;placement &agrave; la souris <br /> ';
			echo '<input type="radio" name="1" value="3" onclick="justShow(\'regulating_3\');justSshow(\'regulating_2\');" '.$checked3.'  /> Les deux ';
		
			echo '<div id="regulating_2" style="display:'.$display2.'">';
				echo '<u> Type de d&eacute;placement au clavier </u> <br /><br />';
				
				if($array['2'] == 3)
				{
					$checked2_3 = 'checked=checked';
				}elseif($array['2'] == 2){
					$checked2_2 = 'checked=checked';
				}else{
					$checked2_1 = 'checked=checked';
				}
				
				echo '<input type="radio" name="2" value="1" '.$checked2_1.' /> fl&egrave;ches directionnelles <br />';
				echo '<input type="radio" name="2" value="2" '.$checked2_2.' /> clavier AZERTY (utilisation de zqsd) <br />';
				echo '<input type="radio" name="2" value="3" '.$checked2_3.' /> clavier QWERTY (utilisation de wasd) ';
				
				echo '<br /><br />';
			echo '</div>';
			
			
			
			echo '<div id="regulating_3" style="display:'.$display3.'">';
				echo '<u> Type de d&eacute;placement &agrave; la souris </u> <br /><br />';
				
				if($array['3'] == 1){
					$checked3_1 = 'checked=checked';
				}else{
					$checked3_2 = 'checked=checked';
				}
				
				echo '<input type="radio" name="3" value="2" '.$checked3_2.' /> carr&eacute;s transparents <br />';
				echo '<input type="radio" name="3" value="1" '.$checked3_1.' /> fl&egrave;ches rouges ';
				
			
				echo '<br /><br />';
			echo '</div>';
		
		echo '</p>';


		echo '<div style="margin-right:40px;text-align:right">';
			$onclick = "HTTPPostCall('page.php?category=regulating&confirm=1','form_regulating','bodygameig')";
			echo '<input class="button" type="button" value="sauvegarder" onclick="'.$onclick.'" />';
		echo '</div>';	
		echo '</form>';
	echo '</fieldset>';			// Choix des skins		require_once('skin.inc.php');	
echo '</div>'; 
 
 
?>
