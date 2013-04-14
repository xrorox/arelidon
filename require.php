<?php

/*
 * Created on 20 oct. 2009
 *
 */

function isInLocal2() {
    $site = $_SERVER['HTTP_HOST']; // test pour savoir si on est en ligne ou en local

    if ($_SERVER["DOCUMENT_ROOT"] == "/")
        return "";

    if (($site == "127.0.0.1" || $site == "localhost")) {
        return true;
    } else {
        return false;
    }
}

//function $server {
//
//    if (isInLocal2() == "")
//        return "";
//
//    if (isInLocal2()) {
//        return $_SERVER["DOCUMENT_ROOT"] . '/arelidon/';
//    } else {
//        return "/dns/com/olympe-network/arelidon/";
//    }
//}

$site=$_SERVER['HTTP_HOST']; // test pour savoir si on est en ligne ou en local
if(($site == "127.0.0.1" || $site == "localhost"))
{
        $server=$_SERVER["DOCUMENT_ROOT"].'/arelidon/';
}
else{
        $server="/dns/com/olympe-network/arelidon/";
}

require_once($server . 'class/char.class.php');
require_once($server . 'class/map.class.php');
require_once($server . 'class/faction.class.php');
require_once($server . 'class/item.class.php');
require_once($server . 'utils/utils.php');
require_once($server . 'class/PDO2.class.php');
require_once($server . 'utils/database.php');



require_once($server . 'class/user.class.php');

if (empty($index))
    $index = 0;

if ($index != 1) {
    require_once($server . 'savelog.inc.php');
}

//a eliminer 	aussi
?>