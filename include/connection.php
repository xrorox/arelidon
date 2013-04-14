<?php
require_once('../utils/database.php');
require_once('../class/user.class.php');

session_start(); //Création de la session
$login          = htmlentities($_POST['loginArea']) ;  
$password       = htmlentities($_POST['passwordArea']);

if (! User::exist($login)) {

	header("Location:../index.php?page=error&error=1");

} else {
    
        //Renvoies un objet user si le compte est capable de se connecter.
        //Sinon renvoies false.
	$user = User::isAbleToLogin($login, $password);
	
	if ($user == false ) {
		header("Location:../index.php?page=error&error=2");
	}else {	
                $_SESSION['user']       = serialize($user);
                $_SESSION['count']      = 1;
                require_once('../require.php');
                
                
                //Variable server renseignée par le require.php
                $_SESSION['server'] = $server;
		header("Location:../index.php?page=selectchar");			
		
	}	
}
?>

