<?php
/*
 * Created on 9 juin 2010
 */

 	
 if(($_GET['action'] == 'ma_fiche'))
 {
 	$player = new char($idchar);
 }
 
 if((($_GET['action'] == 'ma_fiche')) AND ($char->getId() == $player->getId())){
$array=$player->getInformationsForFiche();
	$toto=$array['honnor'];
	if ($toto == ''){
		$toto=0;
	}	
	echo '<div style="min-height:200px;">';
		echo '<table style="display:block;">';
			echo '<tr> <td>'.getAvatar($player,"margin-left:60px;").'</div></td></tr>';
			echo '<tr> <td>Nom:  '.$array['name'].'</td></tr>';
			echo '<tr> <td>Faction:  <img src="pictures/faction/'.$array['faction'].'-24.png" alt="erreur" /></td></tr>';
			echo '<tr> <td>Classe:  '.char::getClasseNameById($array['classe']).'</td></tr>';
			echo '<tr> <td>Niveau:  '.$array['level'].'</td></tr>';
			echo '<tr> <td>Guilde:  '.guild::getNameById($array['name']).'</td></tr>';
			echo '<tr> <td>Honneur:  '.$toto.' points</td></tr>';
			
				
			
		echo '</table>';
	echo '</div>';
	echo '<br/>';
	echo '<hr/>';
}

if ($_GET['action'] == 'fiche'){
	$char2=new char($_GET['char_id']);
	$array=$char2->getInformationsForFiche();
	$toto=$array['honnor'];
	if ($toto == ''){
		$toto=0;
	}	
	echo '<div style="min-height:200px;">';
		echo '<table>';
			echo '<tr> <td><span style="padding-left:20px;">'.getAvatar($char2,"margin-left:60px;").'</span></td></tr>';
			echo '<tr> <td>Nom:  '.$array['name'].'</td></tr>';
			echo '<tr> <td>Faction:  <img src="pictures/faction/'.$array['faction'].'-24.PNG" alt="erreur" /></td></tr>';
			echo '<tr> <td>Classe:  '.char::getClasseNameById($array['classe']).'</td></tr>';
			echo '<tr> <td>Niveau:  '.$array['level'].'</td></tr>';
			echo '<tr> <td>Guilde:  '.guild::getNameById($array['name']).'</td></tr>';
			echo '<tr> <td>Honneur:  '.$toto.' points</td></tr>';
			
				
			
		echo '</table>';
	echo '</div>';
	echo '<hr/>';
}
?>
