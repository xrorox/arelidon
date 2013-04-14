<?php

require_once($server.'class/faction.class.php');
require_once($server.'class/classe.class.php');
$array_players = user::getListPlayersOnline();

echo 'Connect&eacute;s : <br />';

echo '<div style="margin-left:15px;">';
foreach($array_players as $player)
{
	$player_object = new char($player);
	$url = 'ingame.php?page=profil_player_extend&showed_id='.$player['id'];

	echo '<img title="'.faction::getFactionText($player['faction']).'" src="pictures/faction/'.$player['faction'].'-24.png" style="width:18px;height:18px;"> ' .
 			 '<img src="pictures/classe/ico-'.$player['classe'].'.gif" title="'.classe::GetClasseNameById($player['classe']).'" alt="" style="width:18px;height:18px;" />' .
 			 ' <a href="'.$url.'" style="text-decoration:none;font:black;"> '.$player_object->getNameWithColor().' </a>( niv '.$player['level'].')<br />';
}

echo '</div>';
?>

