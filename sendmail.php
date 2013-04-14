<?php

/*
 * Created on 10 mai 2010
 */

require_once($server . 'class/connection.class.php');
require_once($server . 'utils/database.php');
require_once($server . 'utils/math.php');
require_once($server . 'utils/utils.php');
require_once($server . 'utils/fight.php');





$headers = 'From: "Royaume_Arelidon"<royaumea@240plan.ovh.net>' . "\n";
$headers .='Reply-To: noreply@royaume-arelidon.fr' . "\n";
$headers .='Content-Type: text/html; charset="iso-8859-1"' . "\n";
$headers .='Content-Transfer-Encoding: 8bit';
$headers .='X-Priority: 1';
$chaine = md5($login);

$message = 'D�crouvrez le royaume d\'Ar�lidon,' . "\n\n" .
        'Vous qui avait jou� � Phenixu , voici venu la nouvelle version d�velopper par Blaster et son �quipe.  ' . "\n\n" .
        '' .
        'Soyez d�s maintenant dans les premiers en recr�ant un personnage et en vous lancant dans l\'aventure' . "\n\n" .
        'Bon jeu � tous !';

$title = 'D�crouvrez le royaume d\'Ar�lidon !!! ';

$sql = "SELECT email FROM home ";
$results = loadSqlResultArrayList($sql);

foreach ($results as $result) {
    mail($result['email'], $title, $message);
}
?>
