<?php

if (!empty($_GET['refresh'])) {

    if(!isset($_SESSION))
    {
        session_start();
        $server = $_SESSION['server'];
    }
    require_once($server . 'require.php');
}
$char = unserialize($_SESSION['char']);
// r�cup�ration des variables
if (!empty($_GET['refresh'])) {
    $distance = (!empty($_GET['distance']))? $_GET['distance']: null;
    $id = (!empty($_GET['id']))? $_GET['id']: null;
    $mode = (!empty($_GET['mode']))? $_GET['mode']: null;

    if (!empty($_GET['pvp']))
        $pvp = true;
}else {
    if (isset($_POST['mode']))
        $mode = $_POST['mode'];
    else
        $mode = "";
}


echo '<div id="menuig" style="text-align:left;margin-top:0px;font-weight:700;paddin-right:5px;width:235px;">';

switch ($mode) {
    case 'coffre' :
        require_once($server . 'pageig/gestionCoffre.php');
        break;

    case 'monster' :

        require_once($server . 'pageig/gestionMonster.php');
        break;

    case 'pnj' :

        require_once($server . 'pageig/gestionPnj.php');
        break;

    case 'player' :
        require_once($server . 'pageig/gestionPlayer.php');
        break;

    case 'profil' :
        require_once($server . 'pageig/profil_player.php');
        break;

    case 'ramasser' :
        require_once($server . 'pageig/map/ramasser.php');
        break;

    case 'action' :
        require_once($server . 'pageig/gestionRessources.php');
        break;

    case 'interaction' :
        require_once($server . 'pageig/gestionInteraction.php');
        break;

    case 'atelier' :
        require_once($server . 'pageig/gestionAtelier.php');
        break;

    case 'players_online' :
        require_once($server . 'pageig/list_players_online.php');
        break;

    case 'box_letter' :
        require_once($server . 'pageig/trade/menu_box_letter.php');
        break;

    case 'invit_group' :
        require_once($server . 'pageig/group/invit.php');
        break;

    default :

        break;
}

$itemOnMap = map::getItemOnCase($char);
if (count($itemOnMap) >= 1) {
    foreach ($itemOnMap as $item_id) {
        $item = new item($item_id);
        echo '<div class="boutonItem" style="margin-top:5px;height:30px;width:98%;border:solid 1px black;color:black;font-size:13px;">';
        echo '<img src="pictures/item/' . $item->item . '.gif" alt="Objet" title="' . $item->name . '" style="margin-left:5px;margin-right:5px;" /> ';
        echo $item->name;
        echo '<div style="float:right;margin-right:5px;margin-top:2px;">';
        $url = "include/menuig.php?refresh=1&mode=ramasser&item_ramasse=" . $item->item . "&abs_char=" . $char->getAbs() . "&ord_char=" . $char->getOrd();
        $onclick = "HTTPTargetCall('$url','menuig')";
        echo '<img src="pictures/utils/hand.gif" alt="Prendre" title="Ramasser l\'objet" style="cursor:pointer;" onclick="' . $onclick . ';refreshMap();" />';
        echo '</div>';
        echo '</div>';
    }
}

echo '</div>';
?>