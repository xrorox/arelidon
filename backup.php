<?php

$host = '10.0.205.117';
$user = 'root';
$pass = 'yoyo59';
$db = 'royaume-arelidon';

$date = date("d-m-Y"); // On d�finit le variable $date (ici, son format)

$backup = "dump_" . $date . ".sql.gz";
// Utilise les fonctions syst�me : MySQLdump & GZIP pour g�n�rer un backup gzip�
$command = "mysqldump -h$host -u$user -p$pass $db | gzip> $backup";
system($command);
// D�marre la proc�dure de t�l�chargement
$taille = filesize($backup);
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: application/gzip");
header("Content-Disposition: attachment; filename=$backup;");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . $taille);
@readfile($backup);
// Supprime le fichier temporaire du serveur
unlink($backup);
?>

