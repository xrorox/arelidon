<?php
require_once('require.php');

echo '<html style="background-color:#390101;">';

$frame = 'yes';
include('js/alljs.php');

include('css/allcss.php');

$skill_id = $_GET['skill_id'];

if ($_GET['add_skill'] == 1) {
    $place = $_GET['place'] + 1;
    $sql = "SELECT COUNT(*) FROM `skill_shortcut` WHERE num = $place && char_id = '" . $char->getId() . "' && skill_id = $skill_id LIMIT 1";
    $still_link = loadSqlResult($sql);

    // Si le raccourcis n'est pas d�j� pr�sent'
    if ($still_link < 1) {
        // on r�cup�re les infos de l'ancien raccourcis si besoin'
        $sql = "SELECT COUNT(*) FROM `skill_shortcut` WHERE num = $place && char_id = '" . $char->getId() . "' LIMIT 1";
        $old_is_present = loadSqlResult($sql);

        // si un sort �tait a la case o� l'on veut aller , on sauvegarde son id'
        if ($old_is_present >= 1) {
            $sql = "SELECT skill_id FROM `skill_shortcut` WHERE num = $place && char_id = '" . $char->getId() . "' LIMIT 1";
            $old_skill = loadSqlResult($sql);
        } else {
            $old_skill = 0;
        }

        // Si le raccourcis �tait d�j� dans les raccourcis mais pas au bon endroit
        $sql = "SELECT COUNT(*) FROM `skill_shortcut` WHERE char_id = '" . $char->getId() . "' && skill_id = $skill_id LIMIT 1";
        $still_in_links = loadSqlResult($sql);

        if ($still_in_links >= 1) {
            $sql = "SELECT num FROM `skill_shortcut` WHERE char_id = '" . $char->getId() . "' && skill_id = $skill_id LIMIT 1";
            $old_place = loadSqlResult($sql);

            $sql = "UPDATE `skill_shortcut` SET `num` = $place WHERE char_id = '" . $char->getId() . "' && skill_id = $skill_id LIMIT 1";
            loadSqlExecute($sql);

            // si on avait un sort avant , on le met a la place du sort qu'on a d�plac�'
            if ($old_skill >= 1) {
                $sql = "UPDATE `skill_shortcut` SET `num` = $old_place WHERE char_id = '" . $char->getId() . "' && skill_id = $old_skill LIMIT 1";
                loadSqlExecute($sql);
            }
        } else {
            // si un ancien � cette place on le supprimer
            $sql = "DELETE FROM `skill_shortcut` WHERE num = $place && char_id = '" . $char->getId() . "' LIMIT 1";
            loadSqlExecute($sql);

            // Pas encore dans les raccourcis , on l'ajoute donc'
            $sql = "INSERT INTO `skill_shortcut` (`num`,`char_id`,`skill_id`) VALUES ($place,'" . $char->getId() . "',$skill_id)";
            loadSqlExecute($sql);
        }
    }
}

if ($_GET['remove_skill'] == 1) {
    $skill_id = $_GET['skill_id'];
    $sql = "DELETE FROM `skill_shortcut` WHERE char_id = '" . $char->getId() . "' && skill_id = $skill_id LIMIT 1";
    loadSqlExecute($sql);
}
?>
<head>
    <script type="text/javascript" src="js/draganddrop.js"></script>
    <script type="text/javascript" src="js/dragjquery-1.0.js"></script>
    <script type="text/javascript">
        loadDragAndDropAuto();
    </script>


</head>
<body style="width:700px;height:500px;background-color:#390101;margin-left:0px;">

    <div style="width:100%;height:100%;background-color:#390101;margin-left:0px;"> 

<?php
$char = unserialize($_SESSION['char']);
echo '<div id="frame_competence">';

echo '<div style="width:65%;margin:auto;margin-left:20px;float:left;margin-top:30px;">';

echo '<div class="backgroundBody" style="float:left;margin-left:20px;width:90%;">';

echo '<div class="backgroundMenu" style="padding-left:15px;">  Liste de vos Comp&eacute;tences </div>';

echo '<div style="height:65px;" class="content compt_back">';

$skillList = $char->getSkillListGet();

foreach ($skillList as $key => $skill) {
    echo '<div style="float:left;height:32px;margin-left:10px;" class="draggable_content">';
    $url = "pageig/profil/info_skill.php?skill_id=" . $skill['id'];
    $onclick = "HTTPTargetCall('$url','info_skill_container');";

    echo '<img onclick="' . $onclick . '" id="' . $skill['id'] . '" src="pictures/skill/' . $skill['id'] . '.gif" class="ui-draggable" />';
    echo '</div>';
}
echo '</div>';

echo '</div>';

echo '</div>';


// Liste des sorts accessibles en combats
echo '<div style="width:65%;margin:auto;margin-left:20px;float:left;margin-top:10px;">';

echo '<div class="backgroundBody" style="float:left;margin-left:20px;width:90%;">';

echo '<div class="backgroundMenu" style="padding-left:15px;">  Comp&eacute;tences en combat </div>';

echo '<div style="height:35px;">';


$skillList = $char->getSkillList();

foreach ($skillList as $key => $skill) {
    if ($skill['id'] >= 1) {
        echo '<div class="content compt' . $key . '" style="float:left;height:32px;">';
        echo '<div style="float:left;height:32px;margin-left:10px;" class="draggable_content">';
        $url = "pageig/profil/info_skill.php?skill_id=" . $skill['id'];
        $onclick = "HTTPTargetCall('$url','info_skill_container');";

        echo '<img onclick="' . $onclick . '" id="' . $skill['id'] . '" src="pictures/skill/' . $skill['id'] . '.gif" class="ui-draggable" />';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="content compt' . $key . '" style="float:left;height:32px;margin-left:10px;">';

        $url = "pageig/profil/info_skill.php?skill_id=" . $skill['id'];
        $onclick = "HTTPTargetCall('$url','info_skill_container');";

        echo '<img onclick="' . $onclick . '" id="' . $skill['id'] . '" src="pictures/skill/' . $skill['id'] . '.gif" />';
        echo '</div>';
    }
}


echo '</div>';

echo '</div>';

echo '</div>';

// Liste des sorts accessibles en combats
echo '<div style="width:65%;margin:auto;margin-left:20px;float:left;margin-top:20px;">';

echo '<div class="backgroundBody" style="float:left;margin-left:20px;width:90%;">';

echo '<div class="backgroundMenu" style="padding-left:15px;"> Info Comp&eacute;tence </div>';

echo '<div id="info_skill_container" style="min-height:35px;">';

echo '</div>';

echo '</div>';

echo '</div>';


// Module d'aide'
echo '<div style="float:left;margin-left:40px;width:180px;margin-top:-150px;" class="backgroundBody">';
echo '<div class="backgroundMenu" style="padding-left:10px;"><img src="pictures/utils/help16x16.gif" title="Aide" /> Aide </div>';
echo '<div style="padding:10px;text-align:center;">';
echo '<b>Pour &eacute;quiper une comp&eacute;tence, il vous suffit de la glisser dans un des 6 emplacements en bas. Cliquez sur un sort pour voir ses informations ou l\'augmenter</b>';
echo '</div>';
echo '</div>';

echo '</div>';
?>

</body>
</html>