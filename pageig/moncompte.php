<?php

if (isset($_POST['password'])){
	
	$password = $_POST['password'];
		$length = strlen($password);
		if($length >= 5)
		{
			$sql="UPDATE `users`  SET password='".$_POST['password']."' WHERE id=".$user->getId();
			loadSqlExecute($sql);
		}
	
	echo '<h3 style="color:green;"> Changement valid&eacute;</h3>';
}
?>



<div style="text-align:center;">
	<fieldset>
		<legend>Changer mon mot de passe :</legend>
		<form method="post" action="ingame.php?page=moncompte">
		<label for="password">Mot de passe : </label>
		<input type="text" name="password" id="password"/>
		
		<input type="submit" value="Changer mon mot de passe"/>
		</form>
	</fieldset>
</div>