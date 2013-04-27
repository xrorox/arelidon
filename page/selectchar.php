<?php
$site = $_SERVER['HTTP_HOST']; // test pour savoir si on est en ligne ou en local
if (($site == "127.0.0.1" || $site == "localhost")) {
    $server = $_SERVER["DOCUMENT_ROOT"] . '/arelidon/';
} else {
    $server = "/dns/com/olympe-network/arelidon/";
}
require_once($server . 'class/admin.class.php');
require_once($server . 'class/guild.class.php');
require_once($server . 'require.php');
$user = unserialize($_SESSION['user']);

if (admin::isInMaintenance() and (!$user->isAdmin())) {

    echo 'Le serveur est en maintenance merci de reessayer plus tard';
} else {

    function getShowHideUnclickClasse($i) {
        $onclick = "";

        for ($j = 1; $j <= 4; $j++) {
            if ($j == $i)
                $onclick .= "show('gender_" . $i . "');";
            else
                $onclick .= "hide('gender_" . $j . "');";
        }

        return $onclick;
    }

    if (!empty($_GET['validation'])) {
        // maximum 2 personnages

        if ($user->canCreateNewChar() or $user->isAdmin())
            require_once('char/createchar.php');
        else {
            $str = 'Vous ne pouvez pas cr&eacute;er un nouveau personnage.';
            $error_creation = 1;
        }
    }

    if (isset($_GET['delete'])) {
        $char = new char($_GET['char_id']);
        if ($char->getIdAccount() == $user->getId())
            $char->DeleteChar();
    }
    ?>

    <br />
    <div class="title center"> 
    <?php if (empty($_GET['register'])) { ?>
            Choix du personnage 
    <?php } else { ?>
            Création d'un personnage 
    <?php } ?>
    </div>
    <hr />
    <br />

    <div id="select_char_container"> 
        <?php
        if (empty($_GET['register'])) {

            $charList = Char::getCharList($user);
            $count = count($charList);
            ?>
            <table id="container_char_show" >
                <tr>

                    <td >
                        <input id="max_char" type="hidden" value="<?php echo count($charList); ?>"/>
            <?php
            $i = 1;
            foreach ($charList as $char) {
                if ($i == 1)
                    $style = "display:block;";
                else
                    $style = "display:none;";
                ?>
                            <div id="char_show_<?php echo $i; ?>" style="<?php echo $style; ?>;margin-right:50px;margin-left:50px;">
                                <div style="text-align:center;width:170px;height:200px;vertical-align:bottom !important;">
                                    <img src="pictures/classe/<?php echo $char['classe']; ?>/<?php echo $char['gender']; ?>.gif" style="margin:auto;" /><br />
                                </div>	
                                <div class="label-with-submenu">
                                    <b>
                            <?php
                            echo $char['name'];
                            echo '<br />';
                            //pre_dump($char);
                            ?>
                                    </b>	
                                </div>
                                <div>
            <?php
            echo '<div style="margin:auto;text-align:center;">';
            echo '<form action="page/transition.php" method="POST"><p>';
            echo '<input type="hidden" name="first" value="1" />';
            echo '<input type="hidden" name="idchar" value="' . $char['id'] . '" />';
            echo '<input style="width:80px;height:30px;font-size:16px;font-weight:700;" class="button" type="submit" value="Jouer" />';
            echo '</p></form>';
            echo '</div>';
            ?>
                                </div>
                            </div>
                                    <?php
                                    $i++;
                                }
                                ?>
                    </td>
                    <td>
        <!--						<img onclick="switchCharRight()" src="pictures/arrow_right.png" style="border: 0px" />-->

                        <table id="char_list_container" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td style="font-size:0px;height:13px;">
                                    <img width="228" height="13" alt="" src="pictures/fondnoirnews_29.jpg">
                                    <div style="background-color:black;margin-bottom:-25px;width: 100%;height:50px;">

                                    </div>
                                </td>
                            </tr>

                            <tr style="background-color:black;">
                                <td style="height:30px;text-align:center;font-size:14px;border-bottom:1px;vertical-align:top">
                                    Vos Personnages
                                </td>
                            </tr>

        <?php
        if ($count > 0):
            $i = 1;
            foreach ($charList as $charElement) {
                $emptyElement = false;
                include("subview/charListElement.php");
                $i++;
            }

            while ($i <= 5) {
                if ($i <= 3 || $user->isAdmin()) {
                    // Empty slot
                    $emptyElement = true;
                    $locked = false;
                    include("subview/charListElement.php");
                } else {
                    // Locked slot	
                    $emptyElement = true;
                    $locked = true;
                    include("subview/charListElement.php");
                }

                $i++;
            }
        else:
            ?>
                                <tr style="background-color:black;">
                                    <td style="height:30px;text-align:center;font-size:14px;border-bottom:1px;vertical-align:top">
                                        Aucun Personnage  
                                    </td>
                                </tr>

                            <?php endif; ?>

                            <tr style="background-color:black;">
                                <td style="height:30px;text-align:center;font-size:14px;border-bottom:1px;vertical-align:top">
                                    <input onclick="window.location.href = 'index.php?page=selectchar&register=1'" class="button" type="button" value="Nouveau personnage" />
                                </td>
                            </tr>

                            <tr>
                                <td style="font-size:0px;height:7px;">
                                    <div style="background-color:black;margin-top:-25px;width: 100%;height:50px;">

                                    </div>
                                    <img width="228" height="7" alt="" src="pictures/fondnoirnews_37.jpg">
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        <?php
    }else {
        require_once("new_char_form/register.php");
    }
    ?>
    </div>
<?php }
?>