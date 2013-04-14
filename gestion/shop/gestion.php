<?php
/*
 * Created on 19 oct. 2009
 *


 */
  require_once(absolutePathway().'/class/shop.class.php');
 // Récupération des données
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
 	$asc = 'ASC';
 	
  $order = $orderby;

echo '<div id="modifShop">';

if($_GET['update'] == 1)
{
	$monster = new monster($_GET['idmonster']);
	$arrayModif = array('nom','taille','level','exp');
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
	$shop = new shop();
	$shop->addShop($_POST['name']);
}

echo '</div>';

 
echo '<div> Liste des magasins </div>';
echo '<div>';
 echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		$arrayStatut = array('name'=>'nom','number_items'=>'number_items');
		foreach($arrayStatut as $row => $trad)
		{
			$urltri = "gestion/page.php?category=28&orderby=";
			if($orderby == $row && $asc == 'ASC')
			{
				$asca = 'DESC';
			}elseif($orderby == $row && $asc == 'DESC'){
				$asca = 'ASC';
			}
			$urltri = $urltri.$row.'&asc='.$asca;
			if($row != 'classe_req')
				$onclick = "HTTPTargetCall('$urltri','tdbodygame')";
			else
				$onclick = '';
			echo '<td onclick="'.$onclick.'" style="cursor:pointer;">'.$trad.' </td>';
		}
		
		echo '<td> Editer </td>';
	echo '</tr>';
	
	$arrayShop = shop::getAllShop($min,$max,$order,$asc);
	foreach($arrayShop as $shop)
	{		
		$id = $shop['id'];
		echo '<tr>';		
		foreach($arrayStatut as $row=>$trad)
		{
			switch($row)
			{
				default:
					echo '<td>'.$shop[$row].'</td>';
				break;
			}
		}		
	
			$urledit = "gestion/page.php?category=28&action=edit&id=$id";
			echo '<td> <input class="button" type="button" value="Editer" onclick="loadMenu(\''.$urledit.'\')"></td>';
		echo '</tr>';
	}

echo '</table>';
echo '</div>'; 
 
echo '<div id="addShop" style="height:18px;float:left;">';
	$url = "gestion/page.php?category=28&action=add";
	$onclick = 'HTTPTargetCall(\''.$url.'\',\'modifShop\');';
	echo '<a href="#" onclick="'.$onclick.'">Ajouter un magasin </a>';
echo '</div>'; 
 

// Gestion du suivant / précédent
$minLess = $min - 15;
$maxLess = $max - 15;

if($minLess < 0)
	$minLess = 0;
$maxLess = $min - 15;
if($maxLess < 15)
	$maxLess = 15;
	
$minMore = $min + 15;
$maxMore = $max + 15;

$urlback = "gestion/page.php?category=28&min=".$minLess."&max=".$maxLess;
$urlnext = "gestion/page.php?category=28&min=".$minMore."&max=".$maxMore;


echo '<div style="text-align:right;">';

	$onclick = "HTTPTargetCall('$urlback','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Pr&eacute;c&eacute;dent</a>';
	echo ' | ';
	$onclick = "HTTPTargetCall('$urlnext','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Suivant</a>';

echo '</div>'; 
?>
