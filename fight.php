<?php
$debut = microtime();
//ob_start();
include('require.php');
require_once($server . 'class/monster.class.php');
require_once($server . 'class/fight/Fight.class.php');
require_once($server . 'class/fight/Fighter.class.php');

$fight = new Fight($_GET['fight_id']);

$char = unserialize($_SESSION['char']);
$_SESSION['fight_id'] = serialize($fight->getId());
$_SESSION['fight'] = serialize($fight);

$fighter = new Fighter($char->getId(), $fight->getId(), 1);

$fighter_char = $fighter;


if (!$fight->charIsInFight($char))
    pre_dump("ERROR", true);

$char->setFightId($fight->getId());
$_SESSION['char'] = serialize($char);

// If we need finish the ready phase
if (!empty($_GET['all_ready'])) {
    if ($fight->allAreReady() && $fight->isInReadyPhase()) {
        $fight->finishReadyPhase();
    } else {
        // On est encore en ready phase
    }
}

require($server . 'deb.inc.php');

$date = date('Y-m-d', time());

include($server . 'css/allcss.php');

include($server . 'js/alljs.php');
?>

<script type="text/javascript">

<?php
if ($fight->isInReadyPhase()) {
    ?>
        needRefreshInReadyPhase();
        checkIsAllReady();
    <?php
} else {
    ?>
        needRefreshInFightPhase()
        setTimeout("refreshTimer();",1000);	
        setTimeout("checkFightIsEnd();",1000);	
    <?php
}
?>
</script>
</head>

<body style="padding-top: 0px !important">

    <table style="margin:auto;" border="0" style="font-size: 0px;" cellspacing="0" cellpadding="0">
        <tr>
            <td style="font-size: 0px !important;padding-top: 0px !important;vertical-align:top !important;" cellspacing="0" cellpadding="0">
                <img height="753" alt="" src="pictures/horscadre_02.jpg" style="max-width:112px;width:100%">
            </td>
            <td style="font-size: 0px; margin-top: 0px !important; padding-top: 0px !important">
                <div id="subbody" style="margin-top:-10px;">
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
                                <div id="headerig"><?php include($server . '/include/headerif.php'); ?></div>

                                <table id="subbodytable" cellpadding="0" cellspacing="0" style="vertical-align:text-top;border:0px;">
                                    <tr>
                                        <td class="bodygame" style="width:780px;vertical-align:text-top;min-height:400px;border:0px;" >
                                            <div id="tdbodygame">
<?php
if ($fight->isInReadyPhase())
    include("pageig/fight/ready.php");
else if (!$fight->isEnd())
    include("pageig/fight/fight.php");
else
    include("pageig/fight/end_fight.php");
?>	
                                            </div>
                                            <br />
                                            <div style="text-align:center;">
                                            </div>

<!--										<div id="update_position" style="display:<?php //echo $display;  ?>;"></div>-->

                                            <div id="sleep_php" style="display:none;"></div>


                                        </td>
                                    </tr>
                                </table>
<?php // include($server.'/include/footer.php');  ?>		
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
                </div>
            </td>
            <td valing="top" border="0" style="font-size: 0px !important;padding-top: 0px !important;vertical-align:top !important;" cellspacing="0" cellpadding="0">
                <img height="753" alt="" src="pictures/horscadre_04.jpg" style="max-width:112px;width:100%">
            </td>
        </tr>
</body>
</html>