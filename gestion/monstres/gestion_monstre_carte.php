<?php
/*
 * Created on 12 sept. 2009
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

echo '<div id="addMonster" style="height:18px;">';
	$url = "gestion/page.php?category=5&action=add";
	$onclick = 'HTTPTargetCall(\''.$url.'\',\'modifMonster\');';
	echo '<a href="#" onclick="'.$onclick.'">Ajouter un monstre </a>';
echo '</div>';

echo '<div id="modifMonster" style="height:80px;">';

if($_GET['update'] == 1)
{
	$monster = new monster($_GET['idmonster']);
	$arrayModif = array('nom','level','exp');
	$caracts = getCaractList('0','0');
	
	foreach($caracts as $caract)
	{
		$arrayModif[] = $caract;	
	}
	
	foreach($arrayModif as $modif)
	{
		$monster->update($modif,$_POST[$modif]);
	}
}

if($_GET['add'] == 1)
{
	$monster = new monster();
	$monster->addMonster($_POST['nom'],$_POST['taille'],$_POST['level'],$_POST['exp'],$_POST['str'],$_POST['con'],$_POST['dex'],$_POST['int'],$_POST['sag'],$_POST['res']);
}

echo '</div>';

echo '<div>';
 echo '<table border="1" class="backgroundBody" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenu">';
		$arrayStatut = array('1'=>'id','2'=>'image','3'=>'nom','4'=>'level','5'=>'exp');
		
		
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
				
			$show = getCaract($caract);
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
			
			$caracts = getCaractList('0','0');
			foreach($caracts as $caract)
			{
				echo '<td>'.$monster[$caract].'</td>';
			}
			
			echo '<td> <input type="button" value="Modifier" onclick="modifMonster(\''.$monster['id'].'\')"></td>';
		echo '</tr>';
	}

echo '</table>';
echo '</div>';
?>
