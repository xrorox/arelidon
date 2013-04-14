<?php
/*
 * Created on 6 mars 2010
 */
require_once($server.'class/atelier.class.php');
require_once($server.'class/char_equip.class.php');
 $atelier = new atelier($_GET['id']);
 
 $char = unserialize($_SESSION['char']);
 $char_equip = new char_equip($char->getId());
 
	echo '<div style="margin-left:30px;">';
 		echo '<img src="pictures/utils/pp.png" alt="" /> Atelier';
 		
		// On regarde l'outil �quip�
 		$outil = $char_equip->getToolEquiped();
 	
 		
 		
 		if($outil > 0)
                {
 			echo ' ('.$metier->getName().')';
                        $metier = new metier(metier::getMetierIdByOutil($outil));
                }
 	echo '</div>';
 	
 	echo '<hr />';
 	
 	 echo '<div style="text-align:center;">';
 		$url = "page.php?category=atelier&id=".$atelier->getId();
		$onclick = "HTTPTargetCall('$url','bodygameig');cleanMenu();";	
		
		if($outil > 0)
			createButton('Utiliser',$onclick);
		else
			$txt = 'Vous devez &eacute;quiper un outil pour utiliser cet atelier';
		echo $txt;
		
		
	 echo '</div>';
 
 
 
?>
