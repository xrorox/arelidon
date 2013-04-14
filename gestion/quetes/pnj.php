<?php
/*
 * Created on 30 sept. 2009
 *
 * Gestion des PNJG
 */
 
 
 if($_GET['min'] != '')
 	$min = $_GET['min'];
 else
 	$min = 0;
 	
 if($_GET['max'] != '')
 	$max = $_GET['max'];
 else
 	$max = 50;
 
  if($_GET['orderby'] != '')
 	 $orderby = $_GET['orderby'];
  else
 	 $orderby = 'map';
 	 
  if($_GET['asc'] != '')
 	$asc = $_GET['asc'];
  else
 	$asc = 'ASC';
 	
  $order = $orderby;

echo '<div id="addpnj" style="height:18px;">';
	$url = "gestion/page.php?category=16&action=add";
	$onclick = 'HTTPTargetCall(\''.$url.'\',\'modifpnj\');';
	echo '<a href="#" onclick="'.$onclick.'">Ajouter un pnj </a>';
echo '</div>';

echo '<div id="modifpnj">';
if($_GET['delete']==1){
	
	$sql="DELETE FROM `pnj` WHERE id=".$_GET['pnj'];
	loadSqlExecute($sql);
	destroy_cache('pnj_id','pnj_'.$_GET['idpnj']);
}
if($_GET['update'] == 1)
{
	$pnj = new pnj($_GET['idpnj']);
	$arrayModif = array('name','title','taille','map','abs','ord','image','face','textpnj','fonction','fonction_id');
	
	destroy_cache('pnj_id','pnj_'.$_GET['idpnj']);
	foreach($arrayModif as $modif)
	{
		if($modif == 'title' or $modif == 'name' or $modif == 'textpnj')
			$value = htmlentities($_POST[$modif],ENT_QUOTES);
		else
			$value = $_POST[$modif];
		if($modif == 'textpnj')
			$modif = 'text';
		
		if($modif == 'fonction_id')
		{
			$value = shop::getIdByName($_POST[$modif]);
			if($value == 0)
			{
				$value = shop_skill::getIdByName($_POST[$modif]); 
			}
		}	
		
		
		if(!empty($value))
			$pnj->update($modif,$value);
	}
}

if($_GET['duplic'] == 1)
{
	$pnj = new pnj($_GET['idpnj']);
	$pnj->duplic();
	exit();
}

if($_GET['add'] == 1)
{
	$pnj = new pnj();
	
	$cheminImg = "pictures/pnj/";
	$cheminFace = "pictures/face/";
	
	$image = $_FILES['image']['name'];
	$face = $_FILES['face']['name'];
	move_uploaded_file($_FILES['image']['tmp_name'], $cheminImg.$image);
	move_uploaded_file($_FILES['face']['tmp_name'], $cheminFace.$face);
	
	$fonction_id = shop::getIdByName($value);
	if($fonction_id == 0)
	{
		$fonction_id = shop_skill::getIdByName($value); 
	}
	
	// Le HTMLentities se fait dans la fonction addPnj
	$pnj->addPnj($_POST['name'],$image,$face,$_POST['taille'],$_POST['map'],$_POST['abs'],$_POST['ord'],$_POST['textpnj'],$_POST['title'],$_POST['fonction'],$fonction_id);
	destroy_cache('arraypnj','arraypnj_'.$_POST['map']);
}

echo '</div>';

echo '<div>';
 echo '<table border="1" class="backgroundBody" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenu">';
		$arrayStatut = array('id','image','faceset','name','taille','map','abs','ord');
		
		
		foreach($arrayStatut as $row)
		{
			$urltri = "gestion/page.php?category=16&orderby=";
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
		echo '<td> Supprimer </tf>';
	echo '</tr>';
	
	$arrayPnj = pnj::getPnjList($min,$max,$order,$asc);
	
	foreach($arrayPnj as $pnj)
	{
		echo '<tr>';		
			echo '<td>'.$pnj['id'].'</td>';
			echo '<td>';
				echo '<img src="pictures/pnj/'.$pnj['image'].'" alt="Absent : '.$pnj['image'].'" />';
			echo '</td>';
			echo '<td>';
				echo '<img src="pictures/face/'.$pnj['face'].'" alt="Absent : '.$pnj['face'].'" style="width:50px;height:50px;" />';
			echo '</td>';
			echo '<td>'.$pnj['name'].'</td>';
			echo '<td>'.$pnj['taille'].'</td>';
			echo '<td>'.$pnj['map'].'</td>';
			echo '<td>'.$pnj['abs'].'</td>';
			echo '<td>'.$pnj['ord'].'</td>';
			echo '<td> <input type="button" value="Modifier" onclick="modifPnj(\''.$pnj['id'].'\')"></td>';
			echo '<td> <input type="button" value="Dupliquer" onclick="duplicPnj(\''.$pnj['id'].'\')"></td>';
			echo '<td> <input type="button" value="Supprimer" onclick="if(confirm(\'Voulez vous vraiment supprimer ce pnj ?\')){HTTPTargetCall(\'gestion/page.php?category=16&delete=1&pnj='.$pnj['id'].'\',\'modifpnj\');};"></td>';
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

$urlback = "gestion/page.php?category=16&min=".$minLess."&max=".$maxLess;
$urlnext = "gestion/page.php?category=16&min=".$minMore."&max=".$maxMore;


echo '<div style="text-align:right;">';

	$onclick = "HTTPTargetCall('$urlback','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Précédent</a>';
	echo ' | ';
	$onclick = "HTTPTargetCall('$urlnext','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Suivant</a>';

echo '</div>';
