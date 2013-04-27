<?php
	
	if(!isset($_SESSION))
        {
            session_start();
            $server = $_SESSION['server'];
        }
	require_once($server.'require.php');

	$char_to_insert = new char();

	$char_to_insert->setName(htmlentities($_GET['char_name'])) ;
	$char_to_insert->setClasse($_GET['classe']) ;
	$char_to_insert->setGender($_GET['sex']) ;
	$char_to_insert->setFaction($_GET['faction']);
	$char_to_insert->setIdaccount($user->getId()) ;
	
	$faction = new faction($_GET['faction']);
	
	$char_to_insert->setMap($faction->getMap());
	$char_to_insert->setAbs($faction->getAbs());
	$char_to_insert->setOrd($faction->getOrd());
	
	$time = time();
	
	$char_to_insert->setTimeConnexion($time);
	$char_to_insert->setTimeUpdate($time);
	
	$id_return = $char_to_insert->save();
	$perso = $id_return;			

		
		
	if($id_return != 0)
		echo 'true';
	else{
		echo 'false';
	}
?>
