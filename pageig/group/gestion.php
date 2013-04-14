<?php
/*
* Created on 10 juin 2010
*/
$char = unserialize($_SESSION['char']);
$group = new group($char);

if(count($_POST) >= 1)
{
$group->setShareExp($_POST['shareExp']);
$group->setShareGold($_POST['shareGold']);
}
?>
<div style="min-height:480px">
    <table class="backgroundBody" style="margin-top:40px;margin-left:200px;width:450px;" >
        <tr class="backgroundMenu">
            <td style="padding-left:40px;"> Gestion du groupe </td>
        </tr>
        <tr>
            <td style="padding-left:20px;padding-top:30px;">

                <form id="form_group_gestion" method="POST">

                    Partage d\'exp : 
                    <select name="shareExp">
                        <?php
                            $checked[$group->getShareExp()] = "SELECTED=SELECTED";

                            echo '<option '.$checked[1].' value="1"> Par niveau </option>';
                            echo '<option '.$checked[2].' value="2"> Egale </option>';
                            echo '<option '.$checked[3].' value="3"> Chacun pour soi </option>';
                        ?>
                    </select>

                    <br /><br /> Partage d\'or: 
                    <select name="shareGold">
                        <?php
                            $checked_gold[$group->getShareGold()] = "SELECTED=SELECTED";

                            echo '<option '.$checked_gold[1].' value="1"> Par niveau </option>';
                            echo '<option '.$checked_gold[2].' value="2"> Egale </option>';
                            echo '<option '.$checked_gold[3].' value="3"> Chacun pour soi </option>';
                        ?>
                    </select>

                    <br /><br />
                    <?php
                        if($char->getId() == $group->getLeader())
                        {
                                echo '<div style="float:right;margin-right:80px;">';
                                        $url = "page.php?category=gestion_group&group_id=".$group->getId();
                                        $onclick = "HTTPPostCall('".$url."','form_group_gestion','map_container');";
                                        echo '<input class="button" type="button" onclick="'.$onclick.'" value="Modifier" />';
                                echo '</div>';
                        }
                    ?>
                </form>

                <br />
                <hr />

                 <u><b>Aider :</b></u> <br />

                <br /> <u>Par niveau :</u> vous gagnerez l\'exp&eacute;rience &agrave; la mort du monstre, cette
                             exp&eacute;rience sera divis&eacute;e selon les niveaux des joueurs du groupe (en pourcentage)

                <br /><br />

                <u> Egale :</u> : vous gagnerez l\'exp&eacute;rience &agrave; la mort du monstre, cette
                             exp&eacute;rience sera divis&eacute;e entre les joueurs du groupe (en part &eacute;gale)

                <br /><br />

                <u> Chacun pour soir :</u> vous gagnerez l\'exp&eacute;rience &agrave; chaque coup port&eacute;
                             au monstre et ne sera pas divis&eacute;

            </td>
        </tr>
    </table>
</div>
