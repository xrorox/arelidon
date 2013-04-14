<?php
////////////////////////////////////////////////
//
//      configuration file
//      please edit values
////////////////////////////////////////////////
//      declare here all databases
//        host = server
//        user = username
//        pwd = password
//        base = database name
//        description = one word to describe it
////////////////////////////////////////////////
$host[1]='10.0.205.117';
$user[1]='root';
$pwd[1]='yoyo59';
$base[1]='royaume-arelidon';
$description[1]='base arelidon';
////////////////////////////////////////////////
$host[2]='';
$user[2]='';
$pwd[2]='';
$base[2]='';
$description[2]='';
////////////////////////////////////////////////
$host[3]='';
$user[3]='';
$pwd[3]='';
$base[3]='';
$description[3]='';
////////////////////////////////////////////////
//      relative path to the folder containing the databases backups
$backup_path='./sql/';
////////////////////////////////////////////////
//      relative path to the folder containing the archives backups
$backupdir_path='./files/';
////////////////////////////////////////////////
//      Format of the date
$current_date=date('Y-m-d_H-i-s');
////////////////////////////////////////////////
//      Name of the folder containing this script
$folder_name='backup';
////////////////////////////////////////////////
//      END OF CONFIGURATION FILE
////////////////////////////////////////////////
$base_number=count($base);
?>