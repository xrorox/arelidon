<?php
if(empty($_GET['do'])) $_GET['do'] = '';

if($_GET['do'] == "add_friend")
{
	$friend_id = char::getIdByName($_POST['friend_name']);
	$sql = "INSERT INTO friends (`char_id`,`friend_id`) VALUES ('".$char->getId()."',$friend_id)";
	loadSqlExecute($sql);  
}

if($_GET['do'] == "del_friend")
{
    $sql = "DELETE FROM friends WHERE char_id = '".$char->getId()."' AND friend_id =".$_GET['friend_id'];
	loadSqlExecute($sql);
}

 
echo '<div style="margin-top: 10px; margin-right: 20px;margin-left:20px;">';
echo '<table style="width:100%;font-weight:700;" border="0" class="backgroundBodyNoRadius" cellspacing="0">';
	echo '<tr style="font-weight:700;" class="backgroundMenuNoRadius">';
		$onclick = "checkAll(document.forms['box_messages_form'].elements['mess[]'])";
		echo '<td style="width:20px;text-align:center;"><img src="pictures/utils/online.png" /></td>';
		echo '<td style="width:25%;padding-left:25px;">Nom</td>';
		echo '<td style="text-align:center;"> Classe</td>';
		echo '<td style="text-align:center;"> Niv</td>';
		echo '<td style="width:40%;padding-left:10px;"> Guilde </td>';		
		echo '<td style="width:5%;"> Mess </td>';	
		echo '<td style="width:5%;"> Supp </td>';	
	echo '</tr>'; 

 
$sql = "SELECT c.* FROM `friends` AS f LEFT JOIN `char` AS c ON f.friend_id = c.id  WHERE f.char_id = '".$char->getId()."'";
	$allFriend = loadSqlResultArrayList($sql);

	if(count($allFriend) >= 1)
	{
		foreach($allFriend as $friend_values)
		{
			$friend = new char($friend_values);
			
			echo '<tr style="height:24px;">';
				echo '<td style="height:24px;">';
					$time_to_last = time() - $friend->getTimeConnexion();
					if($time_to_last <= 600) // Temps d'innactivit� : 10 minutes
					{
						$src = "pictures/utils/online.png";
						$title = " En ligne";
					}else{
						$src = "pictures/utils/offline.png";
						$title = 'Hors ligne depuis '.getTextFromSecondes($time_to_last);
					}
					echo '<img src="'.$src.'" title="'.$title.'" alt="en ligne" style="height:24px;border:0px;" />';
				echo '</td>';
				echo '<td style="padding-left:15px;">';
					echo $friend->getName();
				echo '</td>';
				echo '<td style="text-align:center;">';
					$src = $friend->getUrlPicture('mini');
					$title = $friend->getFactionName();
					echo '<img src="'.$src.'" title="'.$title.'" alt="'.$title.'" style="height:24px;border:0px;" />';
				echo '</td>';
				echo '<td style="text-align:center;">';
					echo $friend->getLevel();
				echo '</td>';
				echo '<td>';
					if($friend->getGuildId() >= 1)
					{
						$guild_name = guild::getNameById($friend->getGuildId());
						echo $guild_name;
					}else{
						echo ' Pas de guilde';
					}
					
				echo '</td>';
				echo '<td>';
					getLinkSendMessage($friend);
				echo '</td>';
				echo '<td>';
					$url = "page.php?category=messagerie&action=friends_list&do=del_friend&friend_id=".$friend->getId();
					$target = "box_container";
					$onclick = "HTTPTargetCall('$url','$target');";
					echo '<img onclick="if(confirm(\'Supprimer cet ami ?\')){'.$onclick.'}" src="pictures/utils/delete.gif" title="supprimer ce joueur de votre liste d\'amis" alt="Supprimer le joueur" />';
				echo '</td>';
			echo '</tr>';
		}
	}else{
		echo '<tr><td colspan="5" style="font-weight:700"> Vous n\'avez pas encore d\'amis </td></tr>';
	}

echo '</table>';
echo '<div style="margin-top:10px;margin-left:25px;color:black;">';
	echo 'Ajouter un joueur &agrave; sa liste d\'amis <br />';
	$array = getAutocomplete('chars',array($char->getId()));
	echo '<form id="add_friend_form" method="POST"><input id="friend_name" onfocus="autoComplete(\'friend_name\',\''.$array.'\');" type="text" name="friend_name" /> <input type="button" class="button" value="Ajouter" onclick="addFriend();" /></form>'; 
echo '</div>';

echo '</div>';
  
?>
