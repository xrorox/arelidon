<?php
require_once('require.php');
require_once($server . 'class/pnj.class.php');
require_once($server . 'class/monster.class.php');
require_once($server . 'class/interaction.class.php');
require_once($server . 'class/box.class.php');
require_once($server . 'class/metier.class.php');

$char = unserialize($_SESSION['char']);
include($server . 'deb.inc.php');

$date = date('Y-m-d', time());

$sql = "SELECT COUNT(*) FROM `maintenance` WHERE date_server = '$date'";
$result = loadSqlResultArray($sql);

if ($result['COUNT(*)'] == 0 && $_SERVER['HTTP_HOST'] != "127.0.0.1" && $_SERVER['HTTP_HOST'] != 'localhost') {
    require_once('cron/pa_minuit.php');
}




include($server . 'css/allcss.php');

include($server . 'js/alljs.php');
?>

</head>
<body style="padding-top: 0px !important">

    <table style="margin:auto;" border="0" style="font-size: 0px;" cellspacing="0" cellpadding="0">
        <tr>
            <td style="font-size: 0px !important;padding-top: 0px !important;vertical-align:top !important;" cellspacing="0" cellpadding="0">
                <img height="753" alt="" src="pictures/horscadre_02.jpg" style="max-width:112px;width:100%">
            </td>
            <td>
                <div id="subbody">
                    <table class="bodytable" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="cote" cellspacing="0" cellpadding="0">
                                <div>
                                    <img height="125" alt="" src="css/design/menu-top-separator.gif" style="width:24px !important;">	
                                </div>
                                <div style="height:585px;">&nbsp;
                                </div>
                            </td>
                            <td border="0" cellspacing="0" cellpadding="0" style="vertical-align:top !important;">
                                <?php // corps du site  ?>
                                <div id="header_waiter"></div>
                                <div id="headerig"><?php include($server . 'include/headerig.php'); ?></div>

                                <table id="subbodytable" cellpadding="0" cellspacing="0" style="vertical-align:text-top;border:0px;">
                                    <tr>
                                        <td class="bodygame" style="width:780px;vertical-align:text-top;min-height:400px;border:0px;" >
                                            <div id="tdbodygame">
                                                <?php
                                                if (empty($_GET['page']) or $_GET['page'] == 'game') {
                                                    include($server . 'pageig/game.php');
                                                } elseif ($_GET['page'] == 'page') {

                                                    include($server . 'page.php');
                                                } else {
                                                    if ($_GET['page'] == 'help') { // possibilit� d'avoir acc�s � l'aide apr�s la connexion
                                                        $ingame = 1;
                                                        include($server . 'page/help.php');
                                                    } else {
                                                        include($server . 'pageig/' . $_GET['page'] . '.php');
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <br />
                                            <div style="text-align:center;">
                                            </div>
                                            <?php
                                            if ($char->getId() == 1)
                                                $display = "block";
                                            else
                                                $display = "none";
                                            ?>

                                            <div id="update_position" style="display:<?php echo $display; ?>;"></div>

                                            <div id="sleep_php" style="display:none;"></div>


                                        </td>
                                        <td class="coteig">

                                        </td>
                                        <td id="tdmenuig" class="menuig">
                                            <?php include($server . 'include/menuig.php'); ?>
                                        </td>
                                    </tr>
                                </table>

                                <?php include($server . 'include/footer.php'); ?>		


                            </td>
                            <td class="cote">
                                <div>
                                    <img height="125" alt="" src="css/design/menu-top-separator.gif" style="width:24px !important;">	
                                </div>
                                <div style="height:585px;">&nbsp;
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="bordure-area-bot">
                                    <img alt="" src="css/design/bordure-fin-bot.gif" />
                                </div>
                            </td>
                            <td>
                                <div class="barrehori"> </div>
                            </td>
                            <td>
                                <div class="bordure-area-bot">
                                    <img alt="" src="css/design/bordure-fin-bot.gif" />
                                </div>
                            </td>

                        </tr>
                    </table>
                    <div style="text-align:center;">

                    </div>
                </div>
            </td>
            <td valing="top" border="0" style="font-size: 0px !important;padding-top: 0px !important;vertical-align:top !important;" cellspacing="0" cellpadding="0">
                <img height="753" alt="" src="pictures/horscadre_04.jpg" style="max-width:112px;width:100%">
            </td>
        </tr>
</body>
</html>
