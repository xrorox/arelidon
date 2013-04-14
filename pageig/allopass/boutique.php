<?php
	if(!isset($_GET['detail'])){
		
	$checked_class[$_GET['classe']]	= "checked=checked";
	$checked_sex[$_GET['sexe']]	= "checked=checked";
		
		
?>

<div style="display:inline;float:left;margin-left:100px;">
	<label for="classe"> Classe : </label>
	<select id="classe" name="classe">
		<option value="0" <?php echo $checked_class[0]; ?>>Tous</option>
		<option value="1" <?php echo $checked_class[1]; ?>>Guerrier</option>
		<option value="2" <?php echo $checked_class[2]; ?>>Archer</option>
		<option value="3" <?php echo $checked_class[3]; ?>>Mage</option>
		<option value="4" <?php echo $checked_class[4]; ?>>Pr&egrave;tre</option>
	</select>

	<label for="sexe"> Sexe : </label>
	<select id="sexe" name="sexe">
		<option value="0" <?php echo $checked_sex[0]; ?>>Tous</option>
		<option value="1" <?php echo $checked_sex[1]; ?>>Homme</option>
		<option value="2" <?php echo $checked_sex[2]; ?>>Femme</option>
	</select>

	<input type="button" class="button" value="trier" onclick="TriSkin();"/>
</div>

<br/><br/>
<?php
	$sql="SELECT * FROM `skin` WHERE num >= 0 && price > 0 && event_id <= 1";
	
	
	if(!empty($_GET['classe']))
		$sql.=" AND classe=".$_GET['classe']." ";
		
	if(!empty($_GET['sexe']))
		$sql.=" AND gender=".$_GET['sexe']." ";
		
	if(!empty($_GET['numero'])){
		$limit1= 20 * $_GET['numero'] - 20;
		$limit2= 20 * $_GET['numero'];
	}
	else{
		$limit1=0;
		$limit2=20;
	}
	$sql.=" ORDER BY num DESC LIMIT ".$limit1.",".$limit2;
	$skins=loadSqlResultArrayList($sql);
	
	
	$char=new char($_SESSION['idchar']);
	$user_id=$char->getIdaccount();
	
	$sql="SELECT classe,gender FROM `char` WHERE idaccount=$user_id";
	$classes=loadSqlResultArrayList($sql);

	
	
	$test=count($skins);
	
	if($skins=='' or $skins ==0){
		$error="Aucun skin trouv&eacute;";
	}
	else {
		echo '<table border="1" class="backgroundMenuNoRadius" style="display:block;width:580px;border:solid white 1px;margin:auto;">';

		echo '<tr style="height:40px;" border="1"> <td>Nom </td> <td> Classe </td> <td> Genre </td> <td> Skin </td> <td> Prix </td> <td></td></tr>';
$bonne_classe=0;
	foreach($skins as $skin){
		
		foreach($classes as $classe){
			if($classe['classe']== $skin['classe'] and $classe['gender'] == $skin['gender']){
				$bonne_classe++;
			}
	}
		echo '<tr>';
		echo '<td style="width:120px;">'.$skin['name'].'</td>';
		echo '<td style="width:140px;">';
			switch($skin['classe']){
				case 1:
					echo 'Guerrier';
				break;
				case 2:
					echo 'Archer';
				break;
				case 3:
					echo 'Mage';
				break;
				case 4:
					echo 'Pr&egrave;tre';
				break;
			}
 		echo '</td>';
		echo '<td style="width:120px;">';
		switch($skin['gender']){
				case 1:
					echo 'Homme';
				break;
				case 2:
					echo'Femme';
				break;
			}
		echo'</td>';
		echo '<td style="width:120px;"><img id="'.$skin['id'].'" src="pictures/classe/'.$skin['classe'].'/ico/'.$skin['num'].'-1.gif"  /></td>';
		echo '<td style="width:120px;">'.$skin['price'].' points';
		echo'<td style="width:120px;"> <a href="ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=shop&detail=1&id='.$skin['id'].'" >D&eacute;tails</a></td>';
		echo'</td>';
	}

	echo '</table>';
	
	}
}else{
	
	$sql="SELECT * FROM `skin` WHERE id=".$_GET['id'];
	$skin = loadSqlResultArray($sql);
	
	$user_id=$char->getIdaccount();
	$sql="SELECT classe,gender FROM `char` WHERE idaccount = $user_id";
	$classes=loadSqlResultArrayList($sql);
	
	$bonne_classe=0;
	foreach($classes as $classe){
		if(($classe['classe']== $skin['classe']) and ($classe['gender'] == $skin['gender'])){
			$bonne_classe++;
		}
	}
	
	
	$skin_id = $skin['id'];
	
	echo '<div class="backgroundMenuNoRadius" style="width:40%;margin:auto;border:solid 1px white;">';
	echo '<div style="font-size:20px;">'.$skin['name'].'</div>';
	echo '<br />';
	switch($skin['classe']){
		case 1:
			echo '<label for="classe2"> Classe :</label> <span id="classe2">Guerrier</span>';
		break;
		case 2:
			echo '<label for="classe2"> Classe :</label> <span id="classe2">Archer</span>';
		break;
		case 3:
			echo '<label for="classe2"> Classe :</label> <span id="classe2">Mage</span>';
		break;
		case 4:
			echo '<label for="classe2"> Classe :</label> <span id="classe2">Pr&egrave;tre</span>';
		break;
	}
	echo '<br/><br/>';
	switch($skin['gender']){
		case 1:
			echo '<label for="gender"> Sexe :</label> <span id="gender">Homme</span>';
		break;
		case 2:
			echo '<label for="gender"> Sexe :</label> <span id="gender">Femme</span>';
		break;
	}
	echo '<br/><br/>';
	echo '<label for="prix"> Prix :</label> <span id="prix">'.$skin['price'].' points.</span>';
	echo '<br/><br/>';
	
	echo '<img src="pictures/classe/'.$skin['classe'].'/ico/'.$skin['num'].'-1.gif"  />';
	echo '<img src="pictures/classe/'.$skin['classe'].'/ico/'.$skin['num'].'-2.gif"  />';
	
	echo '<img src="pictures/classe/'.$skin['classe'].'/ico/'.$skin['num'].'-3.gif"  />';
	echo '<img src="pictures/classe/'.$skin['classe'].'/ico/'.$skin['num'].'-4.gif"  />';
	echo '</div>';
	if($bonne_classe ==0){
		printAlert('Attention le skin que vous voulez achetez ne correspond pas au genre ou aux classes de vos personnages',false,'red');
	}
	$confirm=true;
}
?>