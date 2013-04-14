<?php
require_once('../../require.php');
 
if(isset($_GET['char_id'])){
	$guild=new guild();	
	$guild->deleteMember(new char($_GET['char_id']),2);

	printConfirm('Vous avez bien quitt&eacute; la guilde');	
}

?>
