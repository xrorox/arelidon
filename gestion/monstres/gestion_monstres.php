<?php
/*
 * Created on 11 sept. 2009
 *


 */
 
 
 // Gestion des monstres
 
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
 	 $orderby = 'level';
 	 
  if($_GET['asc'] != '')
 	$asc = $_GET['asc'];
  else
 	$asc = 'DESC';
 	
$order = $orderby;

echo '<div id="modifMonster">';

if($_GET['update'] == 1)
{
	$monster = new monster($_GET['idmonster']);
	$arrayModif = array('nom','taille','level','exp','range_min','range_max','timerespawn');
	$caracts = getCaractList('0','0');
	
	foreach($caracts as $caract)
	{
		$arrayModif[] = $caract;	
	}
	
	foreach($arrayModif as $modif)
	{
		if($modif == 'nom')
		{
			$_POST[$modif] = htmlentities($_POST[$modif],ENT_QUOTES);
		}	
		$monster->update($modif,$_POST[$modif]);
	}
}

if($_GET['add'] == 1)
{
	$monster = new monster();
	$monster->addMonster($_POST['nom'],$_POST['taille'],$_POST['level'],$_POST['exp'],$_POST['str'],$_POST['con'],$_POST['dex'],$_POST['int'],$_POST['sag'],$_POST['res'],$_POST['range_min'],$_POST['range_max'],$_POST['timerespawn']);
}

echo '</div>';

echo '<div>';
 echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		$arrayStatut = array('1'=>'id','2'=>'image','3'=>'nom','4'=>'level','5'=>'exp','6'=>'range_min','7'=>'range_max','8'=>'timerespawn');
		
		
		foreach($arrayStatut as $row)
		{
			$urltri = "gestion/page.php?category=5&orderby=";
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
			if($row == "timerespawn")
				$row = 'respawn';
			echo '<td onclick="'.$onclick.'" style="cursor:pointer;">'.$row.' </td>';
		}
		
		
		
		$caracts = getCaractList('0','0');
		foreach($caracts as $caract)
		{
			$urltri = "gestion/page.php?category=5&orderby=";
			if($orderby == $caract && $asc == 'ASC')
			{
				$asca = 'DESC';
			}elseif($orderby == $caract && $asc == 'DESC'){
				$asca = 'ASC';
			}
			$urltri = $urltri.$caract.'&asc='.$asca;
			
			$onclick = "HTTPTargetCall('$urltri','tdbodygame')";
				
			$show =$caract;
			
			echo '<td onclick="'.$onclick.'" style="cursor:pointer;">'.$show.'</td>';
		 	}
		
		echo '<td> Modifier </td>';
	echo '</tr>';
	
	$arrayMonster = monster::getAllMonster($min,$max,$order,$asc);
	
	foreach($arrayMonster as $monster)
	{
		echo '<tr>';		
			echo '<td>'.$monster['id'].'</td>';
			echo '<td>';
				echo '<img src="pictures/monster/'.$monster['id'].'.gif" alt="Absent : '.$monster['id'].'.gif" />';
			echo '</td>';
			echo '<td>'.$monster['nom'].'</td>';
			echo '<td>'.$monster['level'].'</td>';
			echo '<td>'.$monster['exp'].'</td>';
			echo '<td>'.$monster['range_min'].'</td>';
			echo '<td>'.$monster['range_max'].'</td>';
			echo '<td>'.$monster['timerespawn'].'</td>';
			
			$caracts = getCaractList('0','0');
			foreach($caracts as $caract)
			{
				echo '<td>'.$monster[$caract].'</td>';
			}
			
			echo '<td> <input type="button" value="Modifier" onclick="modifMonster(\''.$monster['id'].'\')"></td>';
		echo '</tr>';
	}

echo '</table>';

echo '<div id="addMonster" style="height:18px;float:left;">';
	$url = "gestion/page.php?category=5&action=add";
	$onclick = 'HTTPTargetCall(\''.$url.'\',\'modifMonster\');';
	echo '<a href="#" onclick="'.$onclick.'">Ajouter un monstre </a>';
echo '</div>'; 

$minLess = $min - 15;
$maxLess = $max - 15;

if($minLess < 0)
	$minLess = 0;
$maxLess = $min - 15;
if($maxLess < 15)
	$maxLess = 15;
	
$minMore = $min + 15;
$maxMore = $max + 15;

$urlback = "gestion/page.php?category=5&min=".$minLess."&max=".$maxLess;
$urlnext = "gestion/page.php?category=5&min=".$minMore."&max=".$maxMore;


echo '<div style="text-align:right;">';

	$onclick = "HTTPTargetCall('$urlback','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Pr&eacute;c&eacute;dent</a>';
	echo ' | ';
	$onclick = "HTTPTargetCall('$urlnext','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Suivant</a>';

echo '</div>';
?>
