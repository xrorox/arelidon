<?php

/*
 *  Doc :
 *  
 *  Fonctionnement : ce cron est appelé à minuit dans le but de donné les PA et PP au jour.
 *  
 *  Si le cron est executé avec succès, un log est enregistré dans log_cron_pa avec la date et success à 1
 * 
 * 
 */

    /** Serveur arélidon */
	$host = '10.0.205.117';
	$user = 'root';
	$mdp = 'yoyo59';
	$base = 'royaume-arelidon';		
	
	
	$link = mysql_connect($host,$user,$mdp);
	mysql_select_db($base);

/*
 * 
 *  Donne les PP journalier au joueurs
 * 
 */

$sql = "UPDATE `char` SET pp = pp + 75";
mysql_query($sql);

//pre_dump($sql);
//loadSqlExecute("SELECT * FROM `char`");


$time = time();
//$sql = "UPDATE `char` SET pa = 800 WHERE pa > 800 AND vip < '".$time."' ";
//mysql_query($sql);
//
////pre_dump($sql);
//
//$sql = "UPDATE `char` SET pa = 1200 WHERE pa > 1200 AND vip < '".$time."' ";
//mysql_query($sql);

//pre_dump($sql);



$sql = "INSERT INTO `log_cron_pa` (`date`,`success`) VALUES (NOW(),1)";
mysql_query($sql);

$sql = "UPDATE maintenance SET date_server = NOW()";
mysql_query($sql);

mysql_close();

?>