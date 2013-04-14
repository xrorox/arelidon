<?php
/*
 * Created on 10 sept. 2009
 *
 */

 
$type = $_GET['type'];

switch($type)
{
	case 'monstre':
		echo '<div id="maj">';
		echo '</div>';
		echo '<form id="form_monster" method="post">';
		
			echo 'Monstre : <select name="idmstr" />';
			$arrayMonster = monster::getAllMonsters();
			foreach($arrayMonster as $monster)
			{
				echo '<option value="'.$monster['id'].'">'.$monster['nom'].'</option>';
			}
			echo '</select><br />';
			echo 'abs : <input type="text" name="abs" size="3" />' .
				 'ord : <input type="text" name="ord" size="3" /><br />' .
				   		'<div style="text-align:center;"><input type="button" value="Ajouter" onclick="addMonster(\''.$_GET['map'].'\');'.$onclick2.'" /></div>';
		echo '</form>';
					
		
	break;
	
	case 'insert_monster':
		$monster = new monster($_POST['idmstr'],'idmstr');
 		$monster->addMonsterOnMap($_POST['abs'],$_POST['ord'],$_GET['idmap']);
 		echo 'Ajout effectué';
	break;
	
	case 'choose_monster':
		echo '<div style="text-align:left;"> Choisir un monstre : ';
			echo '<select id="monster_to_select" name="monster_to_select">';
				$arrayMonster = monster::getAllMonsters();
				foreach($arrayMonster as $monster)
				{
					echo '<option value="'.$monster['id'].'">'.$monster['nom'].'</option>';
				}
			echo '</select>';
			echo '<input class="button" type="submit" value="selectionner" onclick="selectMonsterToAdd()" />';
		echo '</div>';	
	break;
	
	case 'valid_add_monster':
		$monster = new monster($_GET['idmstr'],'');
		$monster->addMonsterOnMap($_GET['abs'],$_GET['ord'],$_GET['idmap']);
	break;
	
	case 'valid_del_monster':
		monster::deleteMonsterOnMap($_GET['abs'],$_GET['ord'],$_GET['idmap']);
	break;
	
	/******************************************************************************************
	 *  Ressources
	 */
	 
	// Innutilisé ??
	case 'ressource':
		echo '<div id="maj">';
		echo '</div>';
		echo '<form id="form_ressource" method="post">';
		
			echo 'Ressource : <select name="idmstr" />';
			$arrayRessource = action::getAllRessources();
			foreach($arrayRessource as $ressource)
			{
				$item = new item($ressource['objet_id']);
				echo '<option value="'.$ressource['id'].'">'.$item->getName().'</option>';
			}
			echo '</select><br />';
			echo 'abs : <input type="text" name="abs" size="3" />' .
				 'ord : <input type="text" name="ord" size="3" /><br />' .
				   		'<div style="text-align:center;"> <input type="button" value="Ajouter" onclick="addMonster(\''.$_GET['map'].'\');'.$onclick2.'" /></div>';
		echo '</form>';
					
		
	break;
	
	case 'choose_ressource':
		
		echo '<div style="text-align:left;"> Choisir une ressource : ';
			$arrayRessource = action::getAllRessources();
			echo '<select id="ressource_to_select" name="ressource_to_select">';
				foreach($arrayRessource as $ressource)
				{
					$item = new item($ressource['objet_id']);
					echo '<option value="'.$ressource['id'].'">'.$item->getName().'</option>';
				}
			echo '</select>';
			echo ' <input class="button" type="submit" value="selectionner" onclick="selectRessourceToAdd()" />';
		echo '</div>';	
	break;
	
	case 'valid_add_ressource':
		$action = new action($_GET['action_id']);
 		$action->addRessource($_GET['idmap'],$_GET['abs'],$_GET['ord']);
	break;
	
	case 'valid_del_ressource':
		action::deleteRessourceOnMap($_GET['abs'],$_GET['ord'],$_GET['idmap']);
	break;
	

	
	/******************************************************************************************
	 *  Téleporteur
	 */	
	
	case 'telep':
		echo '<div id="maj">';
		echo '</div>';
		echo '<form id="form_telep" method="post">';
		echo '<table style="width:380px;border:solid 1px white;">';
			
			echo '<tr>';
				echo '<td></td> <td style="width:70px;text-align:center;"> Carte </td> <td style="text-align:center;"> Abscisse </td> <td style=";text-align:center;"> Ordonn&eacute;e</td><td style=";text-align:center;"> Image</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td> Depuis </td> <td style="text-align:center;"><input type="text" size="4" name="idmap" value="'.$_GET['map'].'" /></td> ';
				echo '<td style="text-align:center;"><input type="text" size="3" name="abs" /></td>';
				echo '<td style="text-align:center;"><input type="text" size="3" name="ord" /></td>';
				echo '<td style="text-align:center;"><input type="radio" name="img" value="1" /><input type="radio" name="img" value="2" /><input type="radio" name="img" value="3" /><input type="radio" name="img" value="4" /></td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td> Vers </td> <td style="text-align:center;"><input type="text" size="4" name="idmap2" /></td> ';
				echo '<td style="text-align:center;"><input type="text" size="3" name="abs2" /></td>';
				echo '<td style="text-align:center;"><input type="text" size="3" name="ord2" /></td>';
				echo '<td style="text-align:center;"><img src="pictures/telep/1.png" alt="^" /><img src="pictures/telep/2.png" alt="->" /><img src="pictures/telep/3.png" alt="<-" /><img src="pictures/telep/4.png" alt="v" /></td>';
			echo '</tr>';
			echo '<tr>';
				$url = 'gestion/page.php?category=2';
				$onclick = "HTTPTargetCall('".$url."','tdbodygame');";
				echo '<td></td> <td></td> <td><input class="button" type="button" value="Ajouter" onclick="addTelep(\''.$_GET['map'].'\');'.$onclick2.'" /></td> <td></td><td></td>';
			echo '</tr>';
			
		echo '</table>';
		echo '</form>';

	break;
		 
	case 'insert_telep':
	// ------------------------------------------ AJOUT TELEPORTEUR ---------------------------------------------------------------
		$map = $_POST['idmap'];
		$abs = $_POST['abs'];
		$ord = $_POST['ord'];
		$idmap = $_POST['idmap2'];
		$absa = $_POST['abs2'];
		$orda = $_POST['ord2'];
		$type = $_POST['img'];
		
		$sql = "SELECT count(*) FROM map WHERE `abs` = '".$abs."' && `ord` = '".$ord."' && `map` = '".$map."' ";
		$exist = loadSqlResult($sql) ;
		
		// si exist
		if ($exist >= 1) {
		 	$sql = "UPDATE `map` SET `changemap` = '".$idmap."' WHERE `abs` = '".$abs."' && `ord` = '".$ord."' && `map` = '".$map."' ";
		 	loadSqlExecute($sql);
		 	$sql="UPDATE `map` SET `abschange` = '".$absa."' WHERE `abs` = '".$abs."' && `ord` = '".$ord."' && `map` = '".$map."' ";
		 	loadSqlExecute($sql);
		 	$sql="UPDATE `map` SET `ordchange` = '".$orda."' WHERE `abs` = '".$abs."' && `ord` = '".$ord."' && `map` = '".$map."' ";
			loadSqlExecute($sql);
			$sql="UPDATE `map` SET `type` = '".$type."' WHERE `abs` = '".$abs."' && `ord` = '".$ord."' && `map` = '".$map."' ";	
			loadSqlExecute($sql);
			
		} else { // fin si il y a deja une case existante
			
			if($map > 0 && $abs > 0 && $ord > 0 && $idmap > 0 && $absa > 0 && $orda > 0)
			{
				$sql = "INSERT INTO `map` (`map` ,`abs` ,`ord` ,`bloc` ,`changemap` ,`abschange` ,`ordchange` ,`type` )
				VALUES ('$map', '$abs', '$ord', '0', '$idmap', '$absa', '$orda', '$type')";	
				loadSqlExecute($sql);
				
				
				// Séléction de la flèche opposée
				switch($type)
				{
					case 1 :
						$type2 = 3;
					break;
					case 2 :
						$type2 = 4;
					break;
					case 3 :
						$type2 = 1;
					break;
					case 4 :
						$type2 = 2;
					break;
				}
				
				// insertion d'un téléporteur retour 
				$sql = "INSERT INTO `map` (`map` ,`abs` ,`ord` ,`bloc` ,`changemap` ,`abschange` ,`ordchange` ,`type` )
				VALUES ('$idmap', '$absa', '$orda', '0', '$map', '$abs', '$ord', '$type2')";	
				loadSqlExecute($sql);
				destroy_cache('telep','telep_'.$idmap);
				destroy_cache('telep','telep_'.$map);	
			}
		}
	break;
	
	
	/******************************************************************************************
	 *  Interactions
	 */	
	 
	case 'insert_interaction':
	// ------------------------------------------ AJOUT TELEPORTEUR ---------------------------------------------------------------
		echo '<div id="maj" style="display:block;">';
		echo '</div>';
		echo '<form id="form_interaction" method="post">';
		
			echo '<input type="text" name="name" value="nom" size="12" /> ' ;
			echo '<input type="text" name="name_for_quest" value="nom quete" size="12" /> ' ;
			echo '<select name="type"> ' ;
				echo '<option value="0"> Vide </option>';
				echo '<option value="1"> Gain </option>';
				echo '<option value="2"> Piège </option>';
			echo '</select>';
			
			
			echo '<input type="text" name="map" value="'.$_GET['map'].'" size="4" /> ' ;
			echo '<input type="text" name="abs" value="abs" size="3" /> ' ;
			echo '<input type="text" name="ord" value="ord" size="3" /> ' ;
			echo '<input type="text" name="gold" value="gold" size="3" /> ' ;
			
			
			
			echo '<input type="text" name="nb_item" value="nb" size="3" /> ' ;
			
			$array = getAutocomplete('item');
			echo '<input id="item_interaction" type="text" name="item" value="item" size="12" onclick="autoComplete(\'item_interaction\',\''.$array.'\')" /> ' ;
			
			echo '<input type="text" name="dmg" value="dmg" size="3" /> ' ;
			echo '<br />';
			echo '<input type="text" name="commentaire" value="Commentaire RP" size="30" /> ' ;
			
			echo '<div style="text-align:center;">' .
				 '<input type="button" value="Ajouter" onclick="addInteraction(\''.$_GET['map'].'\');'.$onclick2.'" /></div>';
		echo '</form>';
		
	break;
	
	case 'valid_insert_interaction':
	// ------------------------------------------ AJOUT TELEPORTEUR ---------------------------------------------------------------
		if($_POST['name'] != 'nom')
		{
			unset($_POST['undefined']);
	
			$interaction = new interaction();
			$interaction->add($_POST);			
		}


		
		
		
	break;
	
	default:
	break;
} 
 
?>
