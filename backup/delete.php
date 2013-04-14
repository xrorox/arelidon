<?php
////////////////////////////////////////////////
//    Author : frinux
//    Website : http://www.frinux.fr
////////////////////////////////////////////////
//
//      delete files
////////////////////////////////////////////////

require_once($server.'backup/config.php');
require_once($server.'backup/functions.php');

if(isset($_POST)) {
  extract($_POST,EXTR_OVERWRITE);
  unlink($filename);
  echo('<h2>'.$filename.' a bien &eacute;t&eacute; supprim&eacute;</h2>');
  echo'<a href="index.php">&lt;-Retour</a>';
}


?>