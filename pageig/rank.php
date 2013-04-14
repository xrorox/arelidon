<?php
/*
 * Created on 16 févr. 2010
 */
 require_once(absolutePathway().'class/classe.class.php');
echo '<div>';
	echo '<form id="form_switch" method="post">';
	echo '<p>';
		echo '<label for="switch"> Classement : </label>';
		echo '<select name="switch" id="switch">';
			echo '<option value="joueur"> Joueur </option>';
			echo '<option value="metier"> M&eacute;tier </option>';
			echo '<option value="pvp"> PvP </option>';
		echo '</select>';
		$url ='page.php?category=classement';
	$onclick ="HTTPPostCall('$url','form_switch','bodygameig');";		
			
	echo' <input class="button" type="button" value="choisir" onclick="'.$onclick.'"/>';
	echo '</p>';
	echo '</form>';
echo '</div>';

 if (isset($_POST['switch'])){
 	
 	$switch=$_POST['switch'];	
 }
 elseif ($_GET['switch2']== "joueur" or $_GET['switch2']== "metier" or $_GET['switch2']== "pvp"){
 	$switch=$_GET['switch2'];
 }

if($switch == '')
	$switch = 'joueur';

switch($switch){

case 'joueur':
	echo'<div id="classement"> ';
	echo ' <form id="form_rank" method="post">';
		echo'<p>';
			echo'<label for="faction"> Faction : </label> ';
			echo'<Select name="faction" id="faction"> ';
				echo'<option value="default"> Tous </option>';
				echo'<option value="1"> Nudricien </option>';
				echo'<option value="2"> Umodien </option>';
				echo'<option value="3"> Amodiens </option>';
			echo'</select>';
			
			echo'<label for="niveau"> Classe : </label> ';
				echo'<Select name="classe" id="niveau"> ';
					echo'<option value="Classe"> Tous </option>';
					echo'<option value="1"> Guerrier </option>';
					echo'<option value="2"> Archer </option>';
					echo'<option value="3"> Mage </option>';
					echo'<option value="4"> Pr&ecirc;tre </option>';
				echo'</select>';
		
		$url ='page.php?category=classement&switch2=joueur';
		$onclick ="HTTPPostCall('$url','form_rank','bodygameig');";		
				
		echo' <input class="button" type="button" value="chercher" onclick="'.$onclick.'"/>';		
		echo'</p> ';

		
		
	echo'</form> ';



	if(isset($_POST['faction'])) //vérification qu'on reçoit bien 1,2 ou 3
	{
		$faction = $_POST['faction'];
	}else{
		$faction = 0;
	}

	if(isset($_POST['classe'])) //test deuxième variable
	{
		$classe = $_POST['classe'];
	}else{
		$classe = 0;
	}


	$char_array = char::getAllCharRank($faction,$classe);

	echo '<div style="text-align:center;">';
		echo '<table class="backgroundBody" style="width:700px;margin-left:50px;">';
			echo '<tr class="backgroundMenu">';
				echo '<th></th>';
				echo '<th> Nom </th>';
				echo '<th style="width:32px;"> Level </th>';
				echo '<th style="width:32px;"> Faction </th>';
				echo '<th style="width:32px;"> Classe </th>';
				echo '<th style="width:200px;"> Guilde </th>';
			echo '</tr>';
			
			
			
		
			
		$a=1;
		$compteur = 1;
		
		foreach($char_array as $Ligne)
		{
					echo '<tr>';
					
					echo '<td style="width:32px;font-weight:700;">'.$compteur.'</td>';
					
					foreach ($Ligne as $case)
					{
						if ($a==3)
						{
							switch ($case)
							{
								case 1:
								$affiche='<img src="pictures/faction/1-24.png" title="Nudricien" />';
								break;
								
								case 2:
								$affiche='<img src="pictures/faction/2-24.png" title="Umodien" />';
								break;
								
								case 3:
								$affiche='<img src="pictures/faction/3-24.png" title="Amodien" />';
								break;
								
								default:
								$affiche='';
							}
							echo '<td class="case" style="width:32px;"> '.$affiche.'</td>';
						}
						elseif ($a==4)
						{
							$affiche = '<img src="pictures/classe/ico-'.$case.'.gif" title="'.classe::GetClasseNameById($case).'" alt="" style="width:18px;height:18px;" />';
							echo '<td class="case" style="width:32px;"> '. $affiche.'</td>';
						
						}elseif($a==5)
						{
							$guild = new guild($case);
							echo '<td class="case" style="width:32px;"> '.$guild->getNameMaxLength().'</td>';
						}elseif($a==1){
							$url = 'ingame.php?page=profil_player_extend&showed_id='.char::getIdByName($case);
							echo '<td class="case" style="width:32px;"><a href="'.$url.'" style="color:black;">'.html_entity_decode($case,ENT_QUOTES,'UTF-8').'</a></td>';
						}
						else
						{
							echo '<td class="case" style="width:32px;"> '. html_entity_decode($case,ENT_QUOTES,'UTF-8').'</td>';
						}
						$a++;
					}
					$a=1;
					$compteur++;
					echo '</tr>';
					
				}
				
				
		echo "</table>";
	echo '</div>';	
		
	echo '<br />';
break;
case 'metier':
	$sql="SELECT id,name FROM `metier` WHERE 1=1";
	$arrayofarra=loadSqlResultArrayList($sql);
	echo '<form id=metier_id2>';
	echo'<label for="metier_id"> M&eacute;tier : </label> ';
			echo'<Select name="metier_id" id="metier_id"> ';
				echo'<option value="0"> Tous </option>';
				foreach($arrayofarra as $arra){
					echo '<option value="'.$arra['id'].'">'.$arra['name'].' </option>';
					
				}
			echo'</select>';
	$url ='page.php?category=classement&switch2=metier';
		$onclick ="HTTPPostCall('$url','metier_id2','bodygameig');";		
				
		echo' <input class="button" type="button" value="chercher" onclick="'.$onclick.'"/>';
	echo '</form>';
			
			if (isset($_POST['metier_id'])){
				$metier=$_POST['metier_id'];
			}
			else{
				$metier=0;
			}
	if ($metier > 0){
	$sql= "SELECT * FROM `metier_char` WHERE metier_id=".$_POST['metier_id']." ORDER BY exp DESC";
	}
	else{
	$sql= "SELECT * FROM `metier_char` ORDER BY exp DESC";	
	}
	$arrayofarray=loadSqlResultArrayList($sql);

	echo '<table class="backgroundBody" style="width:700px;margin-left:50px;">';
		echo '<tr class="backgroundMenu">';
			echo '<th> Personnage </th>';
			echo '<th> M&eacute;tier </th>';
			echo '<th> Niveau </th>';
			echo '<th> Exp&eacute;rience </th>';
		echo '</tr>';
		foreach ($arrayofarray as $array){
			echo '<tr>';
				echo '<th>'.char::getNameById($array['char_id']).'</th>';
				echo '<th> <img src="pictures/metier/'.strtolower(metier::getNameById($array['metier_id'])).'.gif" title="'.metier::getNameById($array['metier_id']).'" alt="bug" /></th>';		
				echo '<th>'.$array['level'].'</th>';
				echo '<th>'.$array['exp'].'</th>';
			echo '</tr>';
		}	
	echo '</table>';

	break;

	case 'pvp':

	echo'<div id="classement"> ';
	echo ' <form id="form_rank" method="post">';
		echo'<p>';
			echo'<label for="faction"> Faction : </label> ';
			echo'<Select name="faction" id="faction"> ';
				echo'<option value="default"> Tous </option>';
				echo'<option value="1"> Nudricien </option>';
				echo'<option value="2"> Umodien </option>';
				echo'<option value="3"> Amodiens </option>';
			echo'</select>';
			
			echo'<label for="niveau"> Classe : </label> ';
				echo'<Select name="classe" id="niveau"> ';
					echo'<option value="Classe"> Tous </option>';
					echo'<option value="1"> Guerrier </option>';
					echo'<option value="2"> Archer </option>';
					echo'<option value="3"> Mage </option>';
					echo'<option value="4"> Pr&ecirc;tre </option>';
				echo'</select>';
		
		$url ='page.php?category=classement&switch2=pvp';
		$onclick ="HTTPPostCall('$url','form_rank','bodygameig');";		
				
		echo' <input class="button" type="button" value="chercher" onclick="'.$onclick.'"/>';		
		echo'</p> ';

		
		
	echo'</form> ';



	if(isset($_POST['faction'])) //vérification qu'on reçoit bien 1,2 ou 3
	{
		$faction = $_POST['faction'];
	}else{
		$faction = 0;
	}

	if(isset($_POST['classe'])) //test deuxième variable
	{
		$classe = $_POST['classe'];
	}else{
		$classe = 0;
	}


	$char_array = char::getAllCharRankpvp($faction,$classe);

	echo '<div style="text-align:center;">';
		echo '<table class="backgroundBody" style="width:700px;margin-left:50px;">';
			echo '<tr class="backgroundMenu">';
				echo '<th></th>';
				echo '<th> Nom </th>';
				echo '<th style="width:32px;"> Level </th>';
				echo '<th style="width:32px;"> Faction </th>';
				echo '<th style="width:32px;"> Classe </th>';
				echo '<th style="width:200px;"> Guilde </th>';
				echo '<th style="width:100px;"> Kill/Death</th>';
				echo '<th style="width:250px;"> Honneur </th>';
				echo '<th style="width:200px;"> Rang </th>';
			echo '</tr>';
			
			
			
		
			
		$a=1;
		$compteur = 1;
		
		foreach($char_array as $Ligne)
		{
					echo '<tr style="height:28px;">';
					
					echo '<td style="width:32px;font-weight:700;">'.$compteur.'</td>';
					
					$player = new char(char::getIdByName($Ligne['name']));
					
					foreach ($Ligne as $case)
					{
						if ($a==3)
						{
							switch ($case)
							{
								case 1:
								$affiche='<img src="pictures/faction/1-24.png" title="Nudricien" />';
								break;
								
								case 2:
								$affiche='<img src="pictures/faction/2-24.png" title="Umodien" />';
								break;
								
								case 3:
								$affiche='<img src="pictures/faction/3-24.png" title="Amodien" />';
								break;
								
								default:
								$affiche='';
							}
							echo '<td class="case" style="width:32px;"> '.$affiche.'</td>';
						}
						elseif ($a==4)
						{
							$affiche = '<img src="pictures/classe/ico-'.$case.'.gif" title="'.classe::GetClasseNameById($case).'" alt="" style="width:18px;height:18px;" />';
							echo '<td class="case" style="width:32px;"> '. $affiche.'</td>';
						
						}elseif($a==5)
						{
							$guild = new guild($case);
							echo '<td class="case" style="width:32px;"> '.$guild->getNameMaxLength().'</td>';
						}elseif($a==6)
						{
							echo '<td class="case" style="width:32px;"> '. $player->getKills().'/'.$player->getDeaths().'</td>';
						}
						elseif($a==7)
						{
							if($case== ''){$case=0;}
							echo '<td class="case" style="width:32px;"> '.$case.'</td>';
						}
						elseif($a==8)
						{
							if($case== ''){$case=0;}
							echo '<td class="case" style="width:32px;"> '.$player->getRank().'</td>';
						}
						else
						{
							echo '<td class="case" style="width:32px;"> '. htmlentities($case).'</td>';
						}
						$a++;
					}
					$a=1;
					$compteur++;
					echo '</tr>';
					
				}
				
				
		echo "</table>";
	echo '</div>';	
		
	echo '<br />';

break;
}
?>
