<?php

if(isset($_POST['mail']) or isset($_POST['pseudo'])){
	
	 function Genere_Password($size)
 {
 //Initialisation des caractères utilisables
 $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

 for($i=0;$i<$size;$i++)
 {
 $password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
 }

 return $password;
 }


 $mon_mot_de_passe = Genere_Password(6); 
	
	
	
	if(isset($_POST['mail'])){
		$sql="SELECT email FROM `users` WHERE email LIKE '".$_POST['mail']."'";
		$mail=loadSqlResult($sql);
		
	}elseif(isset($_POST['pseudo'])){
		$sql="SELECT email FROM `users` WHERE login LIKE '".$_POST['pseudo']."'";
		$mail=loadSqlResult($sql);
	}
	
	$headers ='From: "Royaume_Arelidon"<royaumea@240plan.ovh.net>'."\n";
     $headers .='Reply-To: noreply@royaume-arelidon.fr'."\n";
     $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
     $headers .='Content-Transfer-Encoding: 8bit';
	 $headers .='X-Priority: 1';
	 
	 $message = 'Voici ton nouveau de passe que tu pourras changer : '.$mon_mot_de_passe ;
	 
	 $title = 'Décrouvrez le royaume d\'Arélidon !!! ';
	 
	 	mail($mail, $title, $message);
 	$sql="UPDATE `users` SET password='".$mon_mot_de_passe."' WHERE email LIKE '".$mail."'";
 
 	loadSqlExecute($sql);
	
	
}
?>

	<fieldset>
		<legend> R&eacute;initialisation du mot de passe </legend>
		<p>
		<form class="visibility" action="index?page=motdepasse" method="post">

		<p>
		
			Indiquez le pseudo ou l adresse e-mail.
		
			<div><label for="pseudo">Nom du compte : </label>
			<input type="text" id="pseudo" name="pseudo"/></div>
			
			<div><label for="mail">Mail : </label>
			<input type="text" id="mail" name="mail"/></div>
			<div>
			<input type="submit" value="R&eacute;initialiser"/>
			</div>
			</p>
		</form>
		
		</p>
	</fieldset>


