<?php
/*
 * Created on 6 déc. 2009
 */
 
 // Récupération des variables
 
 $min = $_GET['min'];
 $max = $_GET['max'];
 
 if(!$_GET['min'])
 	$min = 0;
 if(!$_GET['max'])
 	$max = 45;
 
 $mode = $_GET['mode'];
 
 if($_GET['add'] == 1)
 {
 	$action = new action();
 	$action->add($_POST);
 }
 
 
 switch($mode)
 {
 	case 'add':
		echo '<form id="form_action" method="post" action="panneauAdmin.php?category=26&add=1">';
		echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
			echo '<tr class="backgroundMenuNoRadius">';
				$arrayStatut = array('nom','metier','niveau','objet','respawn');
		
				foreach($arrayStatut as $row)
				{
					echo '<td onclick="" style="">'.$row.' </td>';
				}
				
				echo '<td> Ajouter </td>';
			echo '</tr>';
			
			echo '<tr style="height:40px;">';		
				echo '<td><input type="text" name="name" value="" size="35" /></td>';
				echo '<td>';
					echo '<select name="metier_id">';
						$list_metier = metier::getMetierList();
						foreach($list_metier as $metier)
							echo '<option value="'.$metier['id'].'">'.$metier['name'].'</option>';
					echo '</select>';
				echo '</td>';
				echo '<td><input type="text" name="level" value="" size="3" /></td>';
				$array_autocomplete = getAutocomplete('item');
				echo '<td><input onclick="autoComplete(\'objet_id_input\',\''.$array_autocomplete.'\');" id="objet_id_input" type="text" name="objet_id" value="" size="25" /></td>';
				echo '<td><input type="text" name="respawn" value="" size="3" /></td>';
				
				echo '<td> <input class="button" type="submit" value="Ajouter" onclick=""></td>';
			echo '</tr>';
		echo '</table>';
		echo '</form>';	
 	break;
 	default:
 	 	echo '<u>Liste des actions m&eacute;tiers :</u>';
 
		 // outil pour séléctionner un métier
		 
		 $actions = action::getAllActions($_GET['filter'],$min,$max);
		 
		 echo '<div style="margin-left:60px;">';
		 	echo '<table class="backgroundBody" style="width:450px;border:solid 1px white;margin-top:25px;" cellspacing="0">';
				 foreach($actions as $action)
				 {
				 	echo '<tr>';
				 		echo '<td style="text-align:center;">';
				 			echo '<img src="pictures/item/'.$action['objet_id'].'.gif" alt="" />';
				 		echo '</td>';
				 		echo '<td>';
				 			echo $action['name'];
				 		echo '</td>';
				 		echo '<td>';
				 			echo '<input type="button" class="button" value="Supprimer" />';
				 		echo '</td>';
				 	
				 	echo '</tr>';
				 }	
				 echo '<tr style="height:0,5px;background-color:white;"><td></td><td></td><td></td></tr>';
				 echo '<tr>';
			 		echo '<td style="text-align:center;padding-top:5px;">';
			 		echo '</td>';
			 		echo '<td>';
			 		echo '</td>';
			 		echo '<td>';
			 			$onclick = "loadMenu('gestion/page.php?category=26&mode=add');";
			 			echo '<input onclick="'.$onclick.'" style="margin-top:5px;" type="button" class="button" value="Nouvelle" />';
			 		echo '</td>';
				 	
				 echo '</tr>';
		 	echo '</table>';
		 echo '</div>';
 	break;
 }
 

?>
