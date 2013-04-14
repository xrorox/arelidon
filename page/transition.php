<?php

session_start(); //Cr�ation de la session

$index = 1;
require_once('../require.php');

$char = new char($_POST["idchar"]);
$char->disconnectSecondaryCharacter($_POST['idchar']);
$_SESSION['char'] = serialize($char);

$sql = "SELECT COUNT(*) FROM log_connection WHERE date = SYSDATE() AND id = " . $_POST["idchar"] . " ";
$result = loadSqlResult($sql);

if ($result == 0) {
    $sql = "INSERT INTO log_connection (id,date,IP) VALUES (" . $_POST["idchar"] . ",SYSDATE(),'" . $_SERVER["REMOTE_ADDR"] . "')";
    loadSqlExecute($sql);

    $user = unserialize($_SESSION['user']);
    $time = $_SERVER['REQUEST_TIME'];
    $retour = getdate($char->getTimeUpdate());
    $ancienne_heure = $retour["hours"];
    $ancien_jour = $retour["mday"];
    $m = $retour["mon"];
    $a = $retour["year"];

    // Donn�es de l'heure actuelle
    $retour2 = getdate($time);
    $nouvelle_heure = $retour2["hours"];
    $nouveau_jour = $retour2["mday"];

    if ($user->getSponsor() > 0 and $ancien_jour != $nouveau_jour) {
        $sql = "SELECT id FROM `char` WHERE idaccount = '" . $user->getSponsor() . "' LIMIT 1";
        $new_char_id = loadSqlResult($sql);


        $new_char = new char($new_char_id);
        $new_char->updateMore('pa', 10);
    }
}

header("Location:../ingame.php?page=game");
?>
