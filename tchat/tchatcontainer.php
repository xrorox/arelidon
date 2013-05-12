<?php
/*
 * Created on 17 sept. 2009
 */
 
if(!empty($_GET['refresh']))
{

        if(!isset($_SESSION))
        {
            session_start();
            $server = $_SESSION['server'];
        }
require_once($server.'require.php');
	require_once('../class/tchat.class.php');

	
	$user = $_SESSION['user'];
	
	$char = unserialize($_SESSION['char']);	
}else{
	require_once('class/tchat.class.php');
	require_once('class/group.class.php');
}
 

 
if(isset($_GET['add']) && $_GET['add'] == 1)
{
	$tchat = new tchat();
	
	$message = $_POST['message'];
	
	$time = time();
	
	$canal = $tchat->getCharParameter($char->getId());
	
	if($canal == 2)
		$id_canal = $char->getGuildId();
	elseif($canal == 4)
		$id_canal = group::getGroup($char->getId());
	
	if($canal == 2 && $id_canal == 0)
		$canal = 0;
		
	if($canal == 4 && ($id_canal == 0 or $id_canal == ''))
		$canal = 0;
	
	if($message != '')
	{
		if($id_canal == '')
			$id_canal = 0;
		
		$message = cleanString($message);
		tchat::addMessage($char->getId(),$message,$time,$canal,$id_canal);
	}
	}	


// Chargement des param�tres : zoom = 1 : aggrandi    zoom = 0 : petite fen�tre en haut � droite

if(!isset($zoom))
	$zoom = 0;

if($zoom == 0 && isset($_GET['zoom']))
	$zoom = $_GET['zoom'];

$height = array();

if($zoom == 1)
{
	$height[1] = '400';
	$height[2] = '400';
	
	if (@ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])) {
    	$width = 774;
	}else if (@ereg("^Mozilla/", $_SERVER["HTTP_USER_AGENT"])) {
	    $width = 774;
	} else if (@ereg("^Opera/", $_SERVER["HTTP_USER_AGENT"])) {
		$width = 774;
	}else{
		$width = 774;
	}	
	
	if (@ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])) {
	    $size = 480;
	} else if (@ereg("^Mozilla/", $_SERVER["HTTP_USER_AGENT"])) {
	    $size = 510;
	} else if (@ereg("^Opera/", $_SERVER["HTTP_USER_AGENT"])) {
		$size = 510;
	}else{
		$size = 510;
	}
	
	$suffixe = '_zoom';
	
}else{
	$height[1] = '67';
	$height[2] = '66';
	
	if (preg_match("/MSIE/", $_SERVER["HTTP_USER_AGENT"])) {
    	$width = 483;
	}else if (preg_match("/^Mozilla/", $_SERVER["HTTP_USER_AGENT"])) {
	    $width = 523;
	}else{
		$width = 503;
	}
	
//	if (preg_match("/MSIE/", $_SERVER["HTTP_USER_AGENT"])) {
//	    $size = 250;
//	}else{
		$size = 280;
//	}
	
	$suffixe = '';
}

echo '<table style="">';
		echo '<tr><td colspan="3" style="height:'.$height[1].'px;vertical-align:text-top;">';
			echo '<div id="tchattext'.$suffixe.'" style="border-bottom:solid 1px white;">';
				require_once('tchattext.php'); 
			echo '</div>';
		echo '</td></tr>';
		$tchat = new tchat();
		$param = $tchat->getCharParameter($char->getId());
		
		for($i=0;$i<5;$i++)
		{
			if($i==$param)
				$array[]="SELECTED = SELECTED";
			else
				$array[]='';
		}
		
		if($zoom == '')
			$zoom = 0;
		
		echo '<tr><td style="font-weight:700;">' .
				'<select onchange="swapChannel(this.value,'.$zoom.')">' .
				'	<option value="0" '.$array[0].'> Public </option>' .
				'	<option value="1" '.$array[1].'> Commerce </option>' .
				'	<option value="2" '.$array[2].'> Guilde </option>' .
				'	<option value="3" '.$array[3].'> Recrutement </option>' .
				'	<option value="4" '.$array[4].'> Groupe </option>' .
				'</select>' .
				'<div id="swap_channel" style="display:block;"></div>' .
				'</td>';
		echo '<td style="margin-bottom:0px;">';
			
			echo '<form onSubmit="return false" id="form_tchat_public'.$suffixe.'" method="post" action="#">';
			echo '<input id="input_message" name="message" type="text" style="width:'.$size.'px;" onclick="setIsSendingMessage();" onblur="removeIsSendingMessage();" />' .
					' <input class="button" type="button" value="envoyer" onclick="sendMessage(\'0\',\''.$zoom.'\');removeIsSendingMessage();" />';
			echo '</form>';
			
		echo '</td>';
		echo '<td>';
			
			$onclick_zoom = "HTTPTargetCall('page.php?category=tchat','bodygameig');";
			echo ' <img src="pictures/utils/agrandir.png" onclick="'.$onclick_zoom.'" alt="Zoom tchat" title="Agrandir le tchat" /> ';
			$online_players = user::getPlayersOnline();
			$onclick = "loadObject('players_online','1','0');";
			echo '<b>'.$online_players.'</b> ' .
			'<img src="pictures/utils/playersonline.png" onclick="'.$onclick.'" title="Joueurs en ligne" alt=" players online" style="margin-right:2px;" /> ';
		echo '</td>';
	echo '</tr>';
echo '</table>'; 

// permet de r�cup�r� le canal
echo '<div id="canal" style="display:none;">'.$param.'</div>';


 if($zoom == 1)
 {
 	echo '<div id="tchat_zoom_value" style="display:none;">1</div>';
 	
 	echo '<hr />';
 	
 	echo '<div style="margin-left:20px;">Liste des smileys</div>';
 	echo '<table style="margin:auto;" border="1">';
 		
		 	// affichage des codes smiley
		 	$array = getSmileyArray();
		 	$i = 1;
		 	foreach($array as $key=>$pict)
		 	{
		 		
				$picts[$i] = $pict;
				$keys[$i] = $key;
				$i++;
		 	}

			
			echo '<tr class="backgroundMenu">';
			for($j=1;$j<=count($array);$j++)
			{
				echo '<td style="width:32px;text-align:center;padding-top:5px;">'.$picts[$j].'</td>';
			}
			echo '</tr>';
			
			echo '<tr>';
			for($j=1;$j<=count($array);$j++)
			{
				echo '<td style="width:32px;text-align:center;padding-top:5px;">'.$keys[$j].'</td>';
			}
			echo '</tr>';

 	echo '</table>';
 	
 	
 }
 
 
 
?>
