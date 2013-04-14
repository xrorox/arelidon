<?php

/*
 * Created on 10 mai 2010
 */
require_once('class/connection.class.php');
require_once('require.php');


$headers = 'From: "Royaume_Arelidon"<royaumea@240plan.ovh.net>' . "\n";
$headers .='Reply-To: noreply@royaume-arelidon.fr' . "\n";
$headers .='Content-Type: text/html; charset="UTF-8"' . "\n";
$headers .='Content-Transfer-Encoding: 8bit';
$headers .='X-Priority: 1';
$chaine = md5($login);

$message = "Salutation noble aventurier, \n\n

	Ceci fait maintenant un moment que tu n'as pas foul� les terres d'ar�lidon .\n\n
	
	Sache que depuis que tu nous as laiss�, beaucoup de choses ont chang�es ! De nombreux bugs ont �t� r�solus, la vitesse de serveur a �t� augment�e et de nouveaux monstres sont apparus !!\n\n
	
	
	NON ne sois pas triste d'avoir loup� tout ca petit aventurier, pour te rattraper nous t'offrons :\n\n
	
	1000 Points d'action pour rattraper les autres et aller � la bataille !
	D'ici peu une page de classement des parrains sera affich�.\n\n
	
	Viens poutrer du m�chant sur <a href=\"www.royaume-arelidon.fr\"> Royaume-Ar�lidon </a>.\n
	Le harc�lement n'est pas autoris� ainsi que le spam mail.\n
		 ";

$title = 'Royaume Ar�lidon : Ou est tu aventurier ! Ta place est � la bataille ';


$date7 = time() - 7 * 24 * 3600;

$date = timestampToDate($date7, '/');

$sql = "SELECT email FROM users u WHERE (SELECT COUNT(*) FROM log_connection lg WHERE `date` - 7 > " . $date . " && lg.id = u.id) = 0";
$results2 = loadSqlResultArrayList($sql);

$mail_array = array();

foreach ($results2 as $result) {
    if (!in_array($result['email'], $mail_array))
        $mail_array[] = $result['email'];
}


$i = 0;
foreach ($mail_array as $mail) {
    mail($mail, $title, $message);
    $i++;
}

echo $i . " mails envoy�s";
?>

