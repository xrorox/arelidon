<?php
/*
 * Created on 1 nov. 2009
 *
 * Gestion des messages envoy�s
 */

if(empty($_GET['min'])) $_GET['min'] = 0;
if(empty($_GET['max'])) $_GET['max'] = 10;
if(empty($_GET['do'])) $_GET['do'] = ''; //TODO voir valeur par défaut

$char = unserialize($_SESSION['char']);
require_once($server.'class/message.class.php');

echo '<div style="margin-left:20px;">';	
	echo '<div style="margin-top:10px;margin-right:20px;">';
		echo '<form id="box_messages_form" method="POST">';
		echo '<table style="width:100%;" border="0" class="backgroundBodyNoRadius" cellspacing="0">';
			echo '<tr style="font-weight:700;" class="backgroundMenuNoRadius">';
				$onclick = "checkAll(document.forms['box_messages_form'].elements['mess[]'])";
				echo '<td style="width:20px;text-align:center;"><input type="checkbox" onclick="'.$onclick.'" /></td>';
				echo '<td style="width:20px;text-align:center;">lu</td>';
				echo '<td style="padding-left:10px;"> Destinataire </td>';
				echo '<td style="width:50%;padding-left:10px;"> Titre </td>';		
				echo '<td style="width:25%;padding-left:10px;"> Date </td>';	
			echo '</tr>';
 
 			$allmessage = message::getAllMessageSend($char,$_GET['min'],$_GET['max']);
			if(count($allmessage)>= 1)
			{
				foreach($allmessage as $message_values)
				{
					$message = new message($message_values);
					echo '<tr style="color:#FFFFFF;">';
						echo '<td>';
							echo '<input value="'.$message->getId().'" type="checkbox" name="mess[]" />';
						echo '</td>';
						echo '<td>';
							if($message->isread(new char($message->getTo())))
								echo '<img src="pictures/utils/read.gif" alt="lu" title="le destinataire as lu votre message" />';
							else
								echo '<img src="pictures/utils/noread.gif" alt="non lu" title="le destinataire n\'as pas encore lu votre message" />';
						echo '</td>';
						echo '<td style="text-align:center;">';
							echo char::getNameById($message->getTo());
						echo '</td>';
						echo '<td style="padding-left:25px;">';
							echo '<a href="#" style="text-decoration:none;color:#FFFFFF;" onclick="viewMessage(\''.$message->getId().'\');">'.$message->getTitle().'</a>';
						echo '</td>';
						echo '<td>';
							getDateText($message->getTime(),'classic','yes');
						echo '</td>';
					echo '</tr>';
					echo '<tr id="view_mess_'.$message->getId().'_container" style="display:none;">';
						echo '<td colspan="5"><div id="view_mess_'.$message->getId().'"></div></td>';
					echo '</tr>';
					
					
					// Ici le d�tail en cach�
				}
			}else{
				echo '<tr><td colspan="5" style="font-weight:700;">Vous n\'avez pas envoyer de nouveaux messages</td></tr>';
			}
		echo '</table>';
		
		$url = "page.php?category=messagerie&action=show_box&do=del";
		$onclick = "HTTPPostCall('$url','box_messages_form','box_container');";
		echo '<input type="button" class="button" value="Supprimer" onclick="'.$onclick.'" style="margin-left:2px;" />';
		
		if($_GET['min'] >= 10)
		{
			$temp_min = $_GET['min'] - 10;
			$temp_max = $_GET['max'] - 10;
			$url = "page.php?category=messagerie&action=show_box&min".$temp_min."&max=".$temp_max."&tri=".$tri;
			$onclick = "HTTPTargetCall('$url','box_container');";	
			echo '<div style="float:right;"><input type="button" class="button" value="Pr&eacute;c&eacute;dent" onclick="'.$onclick.'" /></div>';
		}
		
		$count = message::countMessageNoDelete($char);
		if($count >= (11 + $_GET['min']))
		{
			$temp_min = $_GET['min'] + 10;
			$temp_max = $_GET['max'] + 10;
			$url = "page.php?category=messagerie&action=show_box&min".$temp_min."&max=".$temp_max."&tri=".$tri;
			$onclick = "HTTPTargetCall('$url','box_container');";	
			echo '<div style="float:right;"><input type="button" class="button" value="Suivant" onclick="'.$onclick.'" /></div>';
		}

		echo '</form>';
	echo '</div>';
echo '</div>';
?>
