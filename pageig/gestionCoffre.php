<?php
/*
 * Created on 28 août 2009
 *
 * Gestion des coffres
 */
 
require_once($server.'class/box.class.php');
require_once($server.'class/char_inv.class.php');
 echo '<div style="margin-top:10px;text-align:center;margin-bottom:5px;">';
 	echo '<img src="pictures/coffre.gif" style="width:160px;height:130px;" />';
 echo '</div>';
 echo '<hr />';
 // Actions possibles 
 
 echo '<div style="font-size:16px;text-decoration:underline;"> Actions possibles : </div>';
 
 echo '<div id="actions" style="margin-top:15px;margin-left:20px;">';
 
 // switch permettant la gestion des actions sur le coffre
 
 $action = (!empty($_GET['action']))? $_GET['action']: null;

 switch($action)
 {
 	case 'open':
		// vérification si le coffre est vide 		
		$box = new box($_GET['id']);
		$box->open($char->getId());
		
 	break;
 	
 	default :		
 		$box = new box($_GET['id']);
 		
 		$box->showBox($char->getId());

		
 		
 	break;
 }
 
 echo '</div>';
 
 
 // condition
 
 
 
?>
