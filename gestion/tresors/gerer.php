<?php
/*
 * Created on 5 mars 2010
 */
 
if($_GET['min'] != '')
 	$min = $_GET['min'];
else
 	$min = 0;
 	
if($_GET['max'] != '')
 	$max = $_GET['max'];
else
 	$max = 20;
 
 if($_GET['orderby'] != '')
 	$orderby = $_GET['orderby'];
else
 	$orderby = 'id';
 	 
if($_GET['asc'] != '')
	$asc = $_GET['asc'];
else
 	$asc = 'DESC';
	
$order = $orderby;


echo '<div id="addTresor" style="height:18px;">';
	$url = "gestion/page.php?category=13&action=add";
	$onclick = 'HTTPTargetCall(\''.$url.'\',\'modifTresor\');';
	echo '<a href="#" onclick="'.$onclick.'">Ajouter un coffre </a>';
echo '</div>';

echo '<div id="modifTresor">';

if($_GET['update'] == 1)
{
	$box = new box($_GET['tresor_id']);
	
	$arrayModif = array('abs','ord','map','nbobjet','objet','gold','typecle','cle');
	$caracts = getCaractList('1','1');
	
	foreach($arrayModif as $modif)
	{
		if($modif == 'objet')
		{
			$value = item::getIdByName($_POST[$modif]);
		}else{
			$value = $_POST[$modif];
		}
		$box->update($modif,$value);
	}
}

if($_GET['add'] == 1)
{
	$box = new box();
	$box->addBox($_POST['abs'],$_POST['ord'],$_POST['map'],$_POST['img'],$_POST['nbobjet'],item::getIdByName($_POST['objet']),$_POST['gold'],$_POST['typecle'],item::getIdByName($_POST['cle']));
}

echo '</div>';



// Affichage
echo '<div>';


 echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		
		$arrayStatut = array('id','map:abs/ord','continent','img','nbobjet','objet','gold','typecle','cle');
		
		foreach($arrayStatut as $row)
		{
			$urltri = "gestion/page.php?category=13&orderby=";
			if($orderby == $row && $asc == 'ASC')
			{
				$asca = 'DESC';
			}elseif($orderby == $row && $asc == 'DESC'){
				$asca = 'ASC';
			}
			$urltri = $urltri.$row.'&asc='.$asca;
			
			if($row != 'image')
				$onclick = "HTTPTargetCall('$urltri','tdbodygame')";
			else
				$onclick = '';
		
		
			echo '<td onclick="'.$onclick.'" style="cursor:pointer;">'.$row.' </td>';
		}
		
		echo '<td> Modifier </td>';
		echo '<td> Dupliquer </td>';
		echo '<td> Suprimer </td>';
	echo '</tr>';
	
	$arrayBox = box::getAllBox($min,$max,$order,$asc);
	
	foreach($arrayBox as $box)
	{
		echo '<tr>';		
			echo '<td>'.$box['id'].'</td>';
			echo '<td>';
				echo $box['map'].':'.$box['abs'].'/'.$box['ord'];
			echo '</td>';
			echo '<td>';
				echo map::getLocalisation($box['map']);
			echo '</td>';
			echo '<td>';
				echo '<img src="pictures/coffre/'.$box['img'].'_close.gif" alt="Absent : '.$box['img'].'.gif" />';
			echo '</td>';
			
			echo '<td>'.$box['nbobjet'].'</td>';			
			echo '<td><img src="pictures/item/'.$box['objet'].'.gif" alt="" /></td>';
			
			echo '<td>'.$box['gold'].'</td>';		
			
			echo '<td>'.$box['typecle'].'</td>';
			
			if($box['cle'] >= 1)
				echo '<td><img src="pictures/item/'.$box['cle'].'.gif" alt="pas de clef" /></td>';
			else
				echo '<td> pas de clef </td>';
			
			echo '<td> <img src="pictures/icones/edit.gif" title="Editer" onclick="modifTresor(\''.$box['id'].'\');" /></td>';
			echo '<td> <img src="pictures/icones/duplicate.gif" title="Editer" onclick="if(confirm(\'Duppliquer ce coffre ?\')){duplicTresor(\''.$box['id'].'\');}" /></td>';
			echo '<td> <img src="pictures/icones/supp.gif" title="Supprimer" onclick="if(confirm(\'Supprimer ce coffre ?\')){deleteTresor(\''.$box['id'].'\');}" /></td>';
		echo '</tr>';
	}

echo '</table>';

$minLess = $min - 15;
$maxLess = $max - 15;

if($minLess < 0)
	$minLess = 0;
$maxLess = $min - 15;
if($maxLess < 15)
	$maxLess = 15;
	
$minMore = $min + 15;
$maxMore = $max + 15;

$urlback = "gestion/page.php?category=13&min=".$minLess."&max=".$maxLess;
$urlnext = "gestion/page.php?category=13&min=".$minMore."&max=".$maxMore;


echo '<div style="text-align:right;">';

	$onclick = "HTTPTargetCall('$urlback','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Pr&eacute;c&eacute;dent</a>';
	echo ' | ';
	$onclick = "HTTPTargetCall('$urlnext','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Suivant</a>';

echo '</div>';
?>
 
