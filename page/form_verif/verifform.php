<?php
$verif = $_GET['verif'];

if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'require.php');

$picture_valide = '<img src="pictures/utils/mini-valid.gif" alt="Valide" title="le pseudo est valide" />';
$picture_not_valid = '<img src="pictures/utils/mini-no.gif" alt="Pas valide" title="le pseudo n\'est valide" />';

function getPict($valid,$title,$num)
{
	if($valid)
	{
		$txt = '<img src="pictures/utils/mini-valid.gif" alt="Valide" title="'.$title.'" />';	
		$txt .= '<span id="form_valid_'.$num.'" style="display:none;">1</span>';
		return $txt;
	}else{
		$txt = '<img src="pictures/utils/mini-no.gif" alt="Pas valide" title="'.$title.'" />';	
		$txt .= '<span id="form_valid_'.$num.'" style="display:none;">0</span>';
		return $txt;
	}
}

switch ($verif){
	
	case login :
		$login = $_GET['login'];
		
		$sql ="SELECT count(*) FROM users WHERE `login` = '$login' ";
		$free = loadSqlResultArray($sql); // 1 = no , 0 = yes	
		
		$length = strlen($login);
		$test=strpos($login,"'");
		
		if ($free[0] == 0 and $login != '' and $length >= 5 and $lenght <= 16 and $test=='') {
			echo getPict(true,'Le pseudo indiqu&eacute; est valide',1);
		} else {
			echo getPict(false,'Le pseudo indiqu&eacute; n\'est pas valide',1);
		}
		

	break;
	
	case mail:
		$mail = $_GET['mail'];
		$str = '@';
		if(substr_count($mail,$str) != 0){
 			$gotarobase = 1 ;
 		}
		
		$sql ="SELECT count(*) FROM users WHERE `email` = '$mail' ";
		$free = loadSqlResultArray($sql); // 1 = no , 0 = yes	
		
		if ($free[0] == 0 and $mail != '' and $gotarobase == 1) {
			echo getPict(true,'L\'addresse mail indiqu&eacute; est valide',2);
		} else {
			echo getPict(false,'L\'addresse mail indiqu&eacute; n\'est pas valide',2);
		}

	break;

	case password :
		$password = $_GET['password'];
		$length = strlen($password);
		if($length >= 5){
			echo getPict(true,'Le mot de passe indiqu&eacute; est valide',3);
		} else {
			echo getPict(false,'Le mot de passe indiqu&eacute; n\'est pas valide',3);
		}
	break;
	
	case sponsor :
		$SPONSOR = $_GET['sponsor'];
		
		$sql = "SELECT count(*) FROM users WHERE `login` = '$SPONSOR' ";
		$free = loadSqlResultArray($sql); // 1 = no , 0 = yes	
		
		if ($free[0] != 0 or $SPONSOR == '') {
			echo getPict(true,'',4);
		} else {
			echo getPict(false,'Le parrain indiqu&eacute; n\'est pas valide',4);
		}

	break;	
	
}





?>