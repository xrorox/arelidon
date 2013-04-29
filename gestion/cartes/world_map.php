<?php
/*
 * Created on 10 sept. 2009
 *


 */

// Fonction de gestion des cases
function inCase($abs, $ord, $alt) {
    $map = new map();
    $map->loadMapByCord($abs, $ord, $alt);
    $urlimg = "map/" . $map->getImage();
    echo '<td style="border:0px;">';
    echo '<div class="caseMapWolrd" style="text-align:center;width:78px;height:46px;">';
    if ($map->getId() > 0) {
        $url = 'gestion/page.php?category=2&map=' . $map->getId();
        $onclick = "HTTPTargetCall('" . $url . "','tdbodygame')";
        echo '<a href="#" onclick="' . $onclick . '"><img src="' . $urlimg . '" alt="pas d\'image" style="width:80px;height:48px;border:0px;" /></a>';
    } else {
        $url = 'panneauAdmin.php?category=1&norefresh=1&preabs=' . $abs . '&preord=' . $ord . '&prealt=' . $alt;
        echo '<div style="height:10px;"></div><div><a href="' . $url . '">pas de carte</a></div>';
    }

    echo '</div>';
    echo '</td>';
}

function getUrl($abschange, $ordchange, $altchange, $absmin, $absmax, $ordmin, $ordmax, $alt) {
    if ($abschange == '1') {
        $absmin = $absmin + 9;
        $absmax = $absmax + 9;
    }
    if ($abschange == '-1') {
        $absmin = $absmin - 9;
        $absmax = $absmax - 9;
    }
    if ($ordchange == '1') {
        $ordmin = $ordmin + 9;
        $ordmax = $ordmax + 9;
    }
    if ($ordchange == '-1') {
        $ordmin = $ordmin - 9;
        $ordmax = $ordmax - 9;
    }
    if ($altchange == '1') {
        $alt = $alt + 1;
    }
    if ($altchange == '-1') {
        $alt = $alt - 1;
    }

    $url = 'gestion/page.php?category=3&absmin=' . $absmin . '&absmax=' . $absmax . '&ordmin=' . $ordmin . '&ordmax=' . $ordmax . '&alt=' . $alt;
    return $url;
}

// R�cup�ration des variables

$absmin = (!empty($_GET['absmin'])) ? $_GET['absmin'] : 0;
$absmax = (!empty($_GET['absmax'])) ? $_GET['absmax'] : 8;
$ordmin = (!empty($_GET['ordmin'])) ? $_GET['ordmin'] : 0;
$ordmax = (!empty($_GET['ordmax'])) ? $_GET['ordmax'] : 8;
$alt = (!empty($_GET['alt'])) ? $_GET['alt'] : 0;

// Affichage de la carte du monde en 10x10 
?>
<table border="1">

    <tr>
        <!--on affiche l'altitude dans cette case-->
        <td style="width:56px;height:24px;text-align:center;"> 
            <table>
                <tr>
                    <td>
                        <?php
                        $url = getUrl('0', '0', '1', $absmin, $absmax, $ordmin, $ordmax, $alt);
                        $onclick = "HTTPTargetCall('" . $url . "','tdbodygame')";
                        ?>
                        <img src="pictures/direction/hg.png" alt="UP" onclick="<?php echo $onclick ?>" />
                    </td>
                    <td></td></tr>
                <tr>
                    <td>
                        <?php
                        $url = getUrl('0', '0', '-1', $absmin, $absmax, $ordmin, $ordmax, $alt);
                        $onclick = "HTTPTargetCall('" . $url . "','tdbodygame')";
                        ?>
                        <img src="pictures/direction/bg.png" alt="DW" onclick="<?php echo $onclick ?>" />
                    </td>
                    <td>
                        <?php echo $alt; ?>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table>

                <tr>
                    <?php for ($i = $absmin; $i <= $absmax; $i++): ?>

                        <td style="width:80px;text-align:center;">
                            <?php
                            if ($i - $absmin == 4):

                                $url = getUrl('0', '-1', '0', $absmin, $absmax, $ordmin, $ordmax, $alt);
                                $onclick = "HTTPTargetCall('" . $url . "','tdbodygame')";
                                ?>
                                <img src="pictures/direction/h.png" alt="H" onclick="<?php echo $onclick ?>" />
                        <?php endif; ?>
                        </td>
<?php endfor; ?>
                </tr>

                <tr>
<?php for ($i = $absmin; $i <= $absmax; $i++): ?>

                    <td style="width:80px;text-align:center;"><?php echo $i ?></td>
<?php endfor; ?>
                </tr>
            </table>
        </td>
        <td></td>
    </tr>
    <tr>

        <td>
            <!--menu a gauche-->	
            <table>
<?php for ($i = $ordmin; $i <= $ordmax; $i++): ?>

                    <tr><td>

                            <?php
                            if ($i - $ordmin == 4):

                                $url = getUrl('-1', '0', '0', $absmin, $absmax, $ordmin, $ordmax, $alt);
                                $onclick = "HTTPTargetCall('" . $url . "','tdbodygame')";
                                ?>
                                <img src="pictures/direction/g.png" alt="G" onclick="<?php echo $onclick ?>" />
                    <?php endif; ?>
                        </td><td style="height:48px;width:56px;text-align:center;"><?php echo $i ?></td>
                    </tr>
<?php endfor; ?>
            </table>

        </td>
        <td>
            <!--Affichage de la carte-->
            <table border="0" cellspacing="0">

                    <?php for ($ord = $ordmin; $ord <= $ordmax; $ord++): ?>

                    <tr>
                        <?php
                        for ($abs = $absmin; $abs <= $absmax; $abs++):

                            inCase($abs, $ord, $alt);
                        endfor;
                        ?> 
                    </tr>
<?php endfor; ?>
            </table>

        </td>
        <!--Menu droite-->
        <td>
            <table>
                        <?php for ($i = $ordmin; $i <= $ordmax; $i++): ?>
                    <tr><td>
                    <?php
                    if ($i - $ordmin == 4):
                        $url = getUrl('1', '0', '0', $absmin, $absmax, $ordmin, $ordmax, $alt);
                        $onclick = "HTTPTargetCall('" . $url . "','tdbodygame')";
                        ?>
                                <img src="pictures/direction/d.png" alt="D" onclick="<?php echo $onclick ?>" />
    <?php endif; ?>
                    </tr>
<?php endfor; ?>
            </table>
        </td>

    </tr>
    <!--Menu du bas-->
    <tr>
        <td style="width:56px;height:24px;text-align:center;"> </td>
        <td>
            <table>

                <tr>
                    <?php for($i=$absmin;$i<=$absmax;$i++): ?>
                    
                    <td style="width:80px;text-align:center;">

                        <?php if($i - $absmin == 4): 
                        
                        $url = getUrl('0','1','0',$absmin,$absmax,$ordmin,$ordmax,$alt);
                        $onclick = "HTTPTargetCall('".$url."','tdbodygame')"; ?>
                        <img src="pictures/direction/b.png" alt="B" onclick="<?php echo $onclick ?>" />
                        <?php endif; ?>

                    </td>
                    <?php endfor; ?>
                </tr>
            </table>
        </td>
        <td></td>
    </tr>
</table>