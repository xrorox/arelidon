<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'/require.php');
require_once($server.'/class/hdv.class.php');
if(!isset($_GET['use_case'])){
	$use_case=1;
}
else{
	$use_case=$_GET['use_case'];
}

	switch($use_case){
		case 1: //mode achat
			require_once($server.'/pageig/bank/hdv_achat.php');
		break;
		case 2:
			require_once($server.'/pageig/bank/hdv_vente.php');
		break;
	}

?>