<?php
/*
 * Created on 25 mai 2010
 */
 
 
	echo '<img src="pictures/utils/box_letter.gif" alt="" />'; 
	echo ' Pigeon Poste';
	
	echo '<br />';
	echo '<hr />';
	echo '<br />';	
	
	echo '<div style="text-align:center;">';
		
		$onclick = "HTTPTargetCall('page.php?category=trade&action=send','bodygameig')";
		echo '<input type="button" onclick="'.$onclick.'" class="button" value="Envoyer un colis" /><br /><br />';
	
	
		$onclick = "HTTPTargetCall('page.php?category=trade&action=recieve','bodygameig')";
		$number_letter = 0;
		
		echo '<input type="button" onclick="'.$onclick.'" class="button" value="Reception de colis ('.$number_letter.')" /><br /><br />';
		
		$onclick = "HTTPTargetCall('page.php?category=trade&action=tarification','bodygameig')";
		
		echo '<input type="button" onclick="'.$onclick.'" class="button" value="Tarification" />';
	echo '</div>';
	

?>
