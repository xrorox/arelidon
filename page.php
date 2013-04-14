<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server . 'require.php');

$user = unserialize($_SESSION['user']);
$char = unserialize($_SESSION['char']);

if (empty($_GET['action']))
    $_GET['action'] = "default";

if (empty($_GET['category']))
    $_GET['category'] = "default";


switch ($_GET['category']) {
    case 'profil':
        // Gestion du profil		
        require_once($server . 'pageig/profil.php');
        break;

    case 'regulating':
        require_once($server . 'pageig/regulating.php');
        break;

    case 'quetes':
        switch ($_GET['action']) {
            case 'accepte':
                require_once($server . 'pageig/quetes/accepte_quete.php');
                break;
            case 'show_step':
                require_once($server . 'pageig/quetes/show_step.php');
                break;

            default:
                require_once($server . 'pageig/quetes.php');
                break;
        }
        break;
    case 'shop':
        // Gestion des magasins
        require_once($server . 'pageig/shop.php');
//		$sql="INSERT INTO `busy` (char_id) VALUES(".$char->getId().")";
//		loadSqlExecute($sql);
        break;
    case 'shop_skill':
        // Gestion des magasins
        require_once($server . 'pageig/shop/shop_skill.php');
        $sql = "INSERT INTO `busy` (char_id) VALUES(" . $char->getId() . ")";
        loadSqlExecute($sql);
        break;
    case 'guild_pnj':
        // Gestion des guildes
        require_once($server . 'pageig/guild/gestion.php');
        break;
    case 'guilde':
        // Gestion de sa guilde
        if ($char->getGuildId() > 0) {
            switch ($_GET['action']) {
                default:
                    require_once($server . 'pageig/guild/my_guild.php');
                    break;
            }
        } else {
            require_once($server . 'pageig/guild/noguild.php');
        }
        break;
    case 'bank_guild':
        require_once $server . 'pageig/bank/gestionBanqueGuilde.php';
        $sql = "INSERT INTO `busy` (char_id) VALUES(" . $char->getId() . ")";
        loadSqlExecute($sql);
        break;
    case 'messagerie':
        // Gestion de la messagerie
        switch ($_GET['action']) {
            case 'new':
                require_once($server . 'pageig/messagerie/new_message.php');
                break;
            case 'show_box':
                require_once($server . 'pageig/messagerie/show_box.php');
                break;
            case 'view_message':
                require_once($server . 'pageig/messagerie/view.php');
                break;
            case 'send_box':
                require_once($server . 'pageig/messagerie/send_box.php');
                break;
            case 'friends_list':
                require_once($server . 'pageig/messagerie/friends_list.php');
                break;
            case 'regulating':
                require_once($server . 'pageig/messagerie/regulating.php');
                break;
            default:
                require_once($server . 'pageig/messagerie/box.php');
                break;
        }
        break;

    case 'tchat' :

        $zoom = 1;
        echo '<div id="tchatcontainerbody_zoom" style="min-height:430px;float:left;">';
        echo '<div id="tchatcontainer_zoom">';
        echo '<div id="waiter_tchat"></div>';
        require_once($server . 'tchat/tchatcontainer.php');
        echo '</div>';
        echo '</div>';
        break;

    case 'worldmap' :

        echo '<div id="world_map" style="">';
        require_once($server . 'pageig/worldmap.php');
        echo '</div>';
        break;

    case 'atelier' :
        switch ($_GET['action']) {
            case 'do_craft':
                require_once($server . 'pageig/atelier/do_craft.php');
                break;

            default:
                require_once($server . 'pageig/atelier/atelier.php');
                break;
        }
        $sql = "INSERT INTO `busy` (char_id) VALUES(" . $char->getId() . ")";
        loadSqlExecute($sql);
        break;

    case 'classement' :
        require_once($server . 'pageig/rank.php');
        break;

    case 'trade':
        switch ($_GET['action']) {
            case 'tarification':
                require_once($server . 'pageig/trade/tarification.php');
                break;

            default:
                require_once($server . 'pageig/trade/box.php');
                break;
        }
        break;

    case 'bank':
        switch ($_GET['action']) {

            default:
                require_once($server . 'pageig/bank/gestionBanque.php');
                break;
        }
        $sql = "INSERT INTO `busy` (char_id) VALUES(" . $char->getId() . ")";
        loadSqlExecute($sql);
        break;

    case 'gestion_group':
        require_once($server . 'pageig/group/gestion.php');
        break;
    case 'hdv':
        require_once($server . 'pageig/bank/hdv.php');
        $sql = "INSERT INTO `busy` (char_id) VALUES(" . $char->getId() . ")";
        loadSqlExecute($sql);
        break;
}
?>

