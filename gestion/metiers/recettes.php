<?php
require_once('../require.php');
$recette= new recette();
echo '<div id="formulaire">';


// Validation d'une nouvelle recette
if ($_GET['valid_form'] == 1)
{
	if(item::getIdByName($_POST['ObjetGagne']) >= 1 && $_POST['NbrObjetGagne'] >= 1)
	{
		if(count($_POST['Objet']) >= 1)
		{
			$recette->add_recette($_POST['metier_id'],$_POST['lvl_req'],$_POST['ObjetGagne'],$_POST['NbrObjetGagne'],$_POST['NbrObjet'],$_POST['Objet']);
		}else{
			printAlert("Minimum 1 ingrédient");
		}
	}else{
		printAlert("pas d'objet cr&eacute;&eacute;");
	}
}

if ($_GET['valid_form'] == 2)
{
			$recette= new recette($_GET['recette']);
			$recette->modif_recette($_POST['metier_id'],$_POST['lvl_req'],$_POST['ObjetGagne'],$_POST['NbrObjetGagne'],$_POST['NbrObjet'],$_POST['Objet']);

}
if($_GET['action']=='modifier'){
	
	echo '<form id="modif_recettes"	method="post">';
echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
echo '<tr class="backgroundMenuNoRadius">';
		$recette= new recette($_GET['recette']);
		
 	echo '<th> M&eacute;tier '.metier::selectMetierName($recette->getMetierId()).' </th>';
 	echo '<th> Niveau requis <input type="text" id="lvl_req" name="lvl_req" size="3" value="'.$recette->getLvlReq().'"/></th>';
 	echo '<th style="width:250px;">';
 			$array = getAutocomplete('item');
 	 		echo 'Objets n&eacute;cessaires <br />';
 			
 			echo '<hr />';
 	 		$arrayr=$recette->getIngredientArray();
 	 		for($i=1;$i<=5;$i++)
 	 		{
	  			echo '<label for="Objet'.$i.'">  Objet '.$i.' </label><br />';
	 	 		echo '<input type="text" id="NbrObjet['.$i.']" name="NbrObjet['.$i.']" size="3" value="'.$arrayr[$i-1]['nb_objet'].'"/> <input id="Objet'.$i.'" name="Objet['.$i.']" autocomplete=off type="text" value="'.item::getNameById($arrayr[$i-1]['objet']).'"onfocus="autoComplete(\'Objet'.$i.'\',\''.$array.'\');" /><br />';	 			
 	 		}
 	 		
 	 		
 	echo '</th>';
 	echo '<th style="text-vertical-align:top;width:220px;"> Objet gagn&eacute;'; 			
 			echo '<hr />';
 	 		echo '<input type="text" id="NbrObjetGagne" name="NbrObjetGagne" size="3" value="'.$recette->getNbObjetWin().'"/> <input id="ObjetGagne" autocomplete=off type="text" onfocus="autoComplete(\'ObjetGagne\',\''.$array.'\');" name="ObjetGagne" value="'.item::getNameById($recette->getObjetWin()).'"/>';
 	 echo '<th>';
 	 		$url = "gestion/page.php?category=15&action=formulaire&valid_form=2&recette=".$_GET['recette'];
			$onclick = "HTTPPostCall('$url','modif_recettes','formulaire');";
			echo '<input type="button" class="button" value="modifier" onclick="'.$onclick.'" />';
	 echo '</th>';
echo '</tr>';
echo '</table>';
echo '</form>';
	
	
	
}

if($_GET['action']=='ajouter'){	
echo '<form id="add_recettes"	method="post">';
echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
echo '<tr class="backgroundMenuNoRadius">';

 	echo '<th> M&eacute;tier '.metier::selectMetierName().' </th>';
 	echo '<th> Niveau requis <input type="text" id="lvl_req" name="lvl_req" size="3"/></th>';
 	echo '<th style="width:250px;">';
 			$array = getAutocomplete('item');
 	 		echo 'Objets n&eacute;cessaires <br />';
 			
 			echo '<hr />';
 	 		
 	 		for($i=1;$i<=5;$i++)
 	 		{
	  			echo '<label for="Objet'.$i.'">  Objet '.$i.' </label><br />';
	 	 		echo '<input type="text" id="NbrObjet['.$i.']" name="NbrObjet['.$i.']" size="3"/> <input id="Objet'.$i.'" name="Objet['.$i.']" autocomplete=off type="text" onfocus="autoComplete(\'Objet'.$i.'\',\''.$array.'\');" /><br />';	 			
 	 		}
 	 		
 	 		
 	echo '</th>';
 	echo '<th style="text-vertical-align:top;width:220px;"> Objet gagn&eacute;'; 			
 			echo '<hr />';
 	 		echo '<input type="text" id="NbrObjetGagne" name="NbrObjetGagne" size="3" /> <input id="ObjetGagne" autocomplete=off type="text" onfocus="autoComplete(\'ObjetGagne\',\''.$array.'\');" name="ObjetGagne" />';
 	 echo '<th>';
 	 		$url = "gestion/page.php?category=15&action=formulaire&valid_form=1";
			$onclick = "HTTPPostCall('$url','add_recettes','formulaire');";
			echo '<input type="button" class="button" value="Ajouter" onclick="'.$onclick.'" />';
	 echo '</th>';
echo '</tr>';
echo '</table>';
echo '</form>';
	
}


echo '<select onchange="loadMenu(\'gestion/page.php?category=15&metier_filter=\'+this.value);" />';
	$list_metier = metier::getMetierList();
	foreach($list_metier as $metier)
	{
		if($metier['id'] == $_GET['metier_filter'])
			$selected = "SELECTED=SELECTED";
		else
			$selected = "";
		echo '<option value="'.$metier['id'].'" '.$selected.' >'.$metier['name'].'</option>';
	}
echo '</select>';

echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
echo '<tr class="backgroundMenuNoRadius">';
 	echo '<th> Recette id</th>';
 	echo '<th> M&eacute;tier</th>';
 	echo '<th> Niveau requis</th>';
 	echo '<th> Objets n&eacute;cessaires</th>';
 	echo '<th> Objet gagn&eacute;</th>';
 	echo '<th> Modifier </th>';
echo '</tr>';

$arrayofarray = $recette->getAllRecettesByMetiers($_GET['metier_filter']);

foreach($arrayofarray as $array){

	echo '<tr>';
	echo '<td> '.$array['id'].'</td>';
	echo '<td> '.metier::getNameById($array['metier_id']).'</td>';
	echo '<td> '.$array['lvl_req'].'</td>';
	echo '<td>'.$recette->getObjetsNecessaryPictures($array['id'],"").'</td>';
	$item_win = new item($array['objet_win']);
	echo '<td>'. $array['nb_objet_win'].$item_win->getPicture(true).'</td>';
$target = "tdbodygame";
	$onclick="gestion/page.php?category=15&action=modifier&recette=".$array['id'];
	echo '<td><input type="button" value="Modifier" onclick="HTTPTargetCall(\''.$onclick.'\',\''.$target.'\');"/></td>';
echo '</tr>';
} 	
 	
echo '</table>';

echo " <a href='#' onclick=\"HTTPTargetCall('gestion/page.php?category=15&action=ajouter&metier_filter=".$_GET['metier_filter']."','formulaire');\"> Ajouter une recette </a>";


echo "</div>";
?>
