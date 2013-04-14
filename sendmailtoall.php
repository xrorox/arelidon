<?php

/*
 * Created on 10 mai 2010
 */
require_once('require.php');

require_once($server . 'class/connection.class.php');
require_once($server . 'utils/database.php');
require_once($server . 'utils/math.php');
require_once($server . 'utils/utils.php');
require_once($server . 'utils/fight.php');





$headers = 'From: "Royaume_Arelidon"<royaume-arelidon@240plan.ovh.net>' . "\n";
$headers .='Reply-To: noreply@royaume-arelidon.fr' . "\n";
$headers .='Content-type: text/html; charset= iso-8859-1\n';
$headers .='Content-Transfer-Encoding: 8bit';
$headers .='X-Priority: 1';

$delimiteur = "-----=" . md5(uniqid(rand()));

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/related; boundary=\"$delimiteur\"\r\n";
$headers .= "\r\n";


/* TITRE */

$title = 'Royaume Ar�lidon : Lancement de la version final ';




$sql = "SELECT * FROM home ";
$results = loadSqlResultArrayList($sql);

$sql = "SELECT * FROM users ";
$results2 = loadSqlResultArrayList($sql);

foreach ($results as $result) {
    $mail_array[$result['email']] = $result;
}

foreach ($results2 as $result) {
    if (!in_array($result['email'], $mail_array))
        $mail_array[$result['email']] = $result;
}

$i = 0;
foreach ($mail_array as $mail) {
    /* CORPS */
    $message = 'La beta est maintenant termin�e, tentez votre chance pour �tre dans les premiers du serveur !!! ' . "\n\n" .
            '' .
            'La course est donc partie, nous t\'attendons avec impatience sur le jeu, saches que beaucoup de choses
	 		 ont chang�es depuis ton d�part, beaucoup de nouveaut�s sont arriv�es et d\'autres sont encore � venir 
	 		 comme l\'h�tel de vente, les QG de guilde ou encore le nouveau syst�me de PVP plus loyal.' . "\n\n";


    if (!empty($mail['login']) && !empty($mail['password'])) {
        $message .= 'Pour te connecter je te rappelle tes identifiants : ' . "\n\n";
        $message .= '- Pseudo : ' . $mail['login'] . "\n\n";
        $message .= '- Mot de passe : ' . $mail['password'] . "\n\n";
    }

    $message .= 'Venez vite sur http://www.royaume-arelidon.fr';

    //if($mail['email'] == 'blaster59@hotmail.fr' || $mail['email'] == 'xstoudi@hotmail.com')
    //if($mail['email'] == 'blaster59@hotmail.fr')
    if (true) {
        mail($mail['email'], $title, $message);
        //echo 'mail a : '.$mail['email'].' <br />';
    }

    $i++;
}

echo '<br />' . $i . " mails envoy�s";
?>

