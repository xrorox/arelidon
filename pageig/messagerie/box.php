<?php
/*
 * Created on 30 oct. 2009
 *
 * Messagerie , gestion envoie et réception message 
 */
 
 
// Liste des menus
echo '<div style="margin-top:50px;margin-left:80px;">';
	echo '<div style="height:25px;">';
		$url = "page.php?category=messagerie&action=new";
		$onclick = "HTTPTargetCall('$url','box_container');";	
		createButton('Nouveau message',$onclick,'','','7',false,'display:inline;');
		
		$url = "page.php?category=messagerie&action=show_box";
		$onclick = "HTTPTargetCall('$url','box_container');";	
		createButton('Boite de r&eacute;ception',$onclick,'','','7',false,'display:inline;');
		
		$url = "page.php?category=messagerie&action=send_box";
		$onclick = "HTTPTargetCall('$url','box_container');";	
		createButton('Boite d\'envoi',$onclick,'','','7',false,'display:inline;');
		
		$url = "page.php?category=messagerie&action=friends_list";
		$onclick = "HTTPTargetCall('$url','box_container');";	
		createButton('Liste d\'amis',$onclick,'','','7',false,'display:inline;');
		
		$url = "page.php?category=messagerie&action=regulating";
		$onclick = "HTTPTargetCall('$url','box_container');";	
		createButton('R&eacute;glages',$onclick,'','','7',false,'display:inline;');
	echo '</div>';
	
	echo '<div style="width:650px;min-height:250px;border:solid 2px grey;background-image:url(\'css/design/fond-menu.png\');">';
		echo '<div id="box_container">';
			require_once('show_box.php');
		echo '</div>';
	echo '</div>';
echo '</div>';
	 

?>
