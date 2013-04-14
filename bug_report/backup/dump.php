<?php
////////////////////////////////////////////////
//    Author : frinux
//    Website : http://www.frinux.fr
////////////////////////////////////////////////
//
//      backup database
////////////////////////////////////////////////

require_once($server.'backup/config.php');
require_once($server.'backup/functions.php');
$auto = 1 ;

if($auto == 1) {
   $database_name=$_POST['database'];
  //choix de la base :
  
  
  if ($auto == 1) {
  		$host='10.0.205.117';
		$user='root';
		$pwd='yoyo59';
		$base='royaume-arelidon';
  } else {
	   for($i=0;$i<$base_number;$i++)
	  {
			$host[1]='10.0.205.117';
			$user[1]='root';
			$pwd[1]='yoyo59';
			$base[1]='royaume-arelidon';
	
	  }
  }
 
  
  if ($host==''){$err=1;}

  $filename=$backup_path.$current_date.'_'.$base.'.sql.gz';
  
  if($err!=1){
    $host=escapeshellarg($host);
    $user=escapeshellarg($user);
    $pwd=escapeshellarg($pwd);
    $base=escapeshellarg($base);
    
    system("mysqldump --host=$host --user=$user --password=$pwd $base | gzip > $filename");
    echo'<h2>La base '.$base.' a bien &eacute;t&eacute; sauvegard&eacute;e</h2>';
  }
  else {echo'Erreur !';}
  echo'<a href="index.php">&lt;-Retour</a>';
}

?>