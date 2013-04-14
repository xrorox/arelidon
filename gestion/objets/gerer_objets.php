<?php
/*
 * Created on 16 sept. 2009
 *
 * Gestion des objets
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
 	
if($_GET['restrict'] != '')
 	$type = $_GET['restrict'];
else
	$type = ''; 
	
$order = $orderby;

echo '<div id="addItem" style="height:18px;">';
	$url = "gestion/page.php?category=11&action=add";
	$onclick = 'HTTPTargetCall(\''.$url.'\',\'modifItem\');';
	echo '<a href="#" onclick="'.$onclick.'">Ajouter un objet </a>';
echo '</div>';

echo '<div id="modifItem">';

if($_GET['update'] == 1)
{
	$item = new item($_GET['iditem']);
	$arrayModif = array('name','level','typeitem','poid','price','rarity','magasin');
	$caracts = getCaractList('1','1');
	
	foreach($caracts as $caract)
	{
		$arrayModif[] = $caract;	
	}
	foreach($arrayModif as $modif)
	{
		if($modif == 'name')
		{
			$name = htmlentities($_POST[$modif],ENT_QUOTES);
			$item->update('name',$name);
		}else
			$item->update($modif,$_POST[$modif]);
	}
}

if($_GET['add'] == 1)
{
	$item = new item();
	$item->addItem($_POST['nom'],$_POST['typeitem'],$_POST['level'],$_POST['poid'],$_POST['price'],$_POST['rarity'],$_POST['exp'],$_POST['str'],$_POST['con'],$_POST['dex'],$_POST['int'],$_POST['sag'],$_POST['res'],$_POST['cha'],$_POST['life'],$_POST['mana'],$_POST['magasin']);
}

echo '</div>';
$target = "tdbodygame";
if($_GET['ajout_image'] == 1){
	echo '<form method="post" id="ajout_image" action="gestion/page.php?category=11&ajout_image=2" enctype="multipart/form-data">';
	echo 'Image en .gif format 24*24, fond transparent';
	echo '<input type="file" name="image" />';
	echo '<input type="submit" value="ajouter image" />';
	echo '</form>';
	
}

if($_GET['ajout_image']==2){
	$nom='../pictures/item/'.$_FILES['image']['name'];
	$resultat = move_uploaded_file($_FILES['image']['tmp_name'],$nom);
if ($resultat) echo "Transfert réussi";

	
}

// Affichage
echo '<div>';
$target = "tdbodygame";
	$onclick="gestion/page.php?category=11&ajout_image=1";
	echo '<input type="button" value="ajouter image" onclick="HTTPTargetCall(\''.$onclick.'\',\''.$target.'\');">';
echo '<form>';
		$url = "gestion/page.php?category=11&restrict=";
		
	echo '<select>';
			$onclick = "HTTPTargetCall('".$url."','".$target."')";
			echo '<option onclick="'.$onclick.'"';
				if($_GET['restrict'] == '')
					echo 'SELECTED="SELECTED"';
			echo '>';
				echo 'Tous';
			echo '</option>';
			
			$arrayItem = getAllItemTypes();
			$arrayUrl = array();
			foreach($arrayItem as $key=>$name)
			{			
				$arrayUrl[$key] = $url.$key;
				$onclick = "HTTPTargetCall('".$arrayUrl[$key]."','".$target."')";
				echo '<option onclick="'.$onclick.'"';
					if($_GET['restrict'] == $key)
						echo 'SELECTED="SELECTED"';
				echo '>';
					echo $name;
				echo '</option>';
			}
		echo '</select>';
		
		echo '<select onchange="modifItem(this.value);">';
			$sql="SELECT id FROM `objet`";
			$array=loadSqlResultArrayList($sql);
			
			foreach($array as $id){
				
				$item=new item($id['id']);
				echo '<option value="'.$id['id'].'">';
				$item->getPicture(false);
				echo '</option>';
			}
		echo'</select>';
echo '</form>';
 echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		
		$arrayStatut = array('id','image','nom','classe','level','poid','price','rarity','magasin');
		$caracts = getCaractList('1','1');
		foreach($caracts as $caract)
		{
			$arrayStatut[] = $caract;
		}
		
		foreach($arrayStatut as $row)
		{
			$urltri = "gestion/page.php?category=11&orderby=";
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
			if($row == 'name')
				$row = 'nom';
			echo '<td onclick="'.$onclick.'" style="cursor:pointer;">'.$row.' </td>';
		}
		
		echo '<td> Modifier </td>';
	echo '</tr>';
	
	$arrayItem = item::getAllItems($min,$max,$order,$type,$asc);
	
	foreach($arrayItem as $item)
	{
		echo '<tr>';		
			echo '<td>'.$item['id'].'</td>';
			echo '<td>';
				echo '<img src="pictures/item/'.$item['id'].'.gif" alt="Absent : '.$item['id'].'.gif" style="width:24px;height:24px;" />';
			echo '</td>';
			echo '<td>'.$item['name'].'</td>';
			$itemTypes = getAllItemTypes();
			// classe
			echo '<td>'.$itemTypes[$item['typeitem']].'</td>';			
			echo '<td>'.$item['level'].'</td>';
			echo '<td>'.$item['poid'].'</td>';
			echo '<td>'.$item['price'].'</td>';
			echo '<td>'.$item['rarity'].'</td>';
			echo '<td>'.$item['magasin'].'</td>';
			$caracts = getCaractList('1','1');
			foreach($caracts as $caract)
			{
				echo '<td>'.$item[$caract].'</td>';
			}
			
			echo '<td> <input class="button" type="button" value="Modifier" onclick="modifItem(\''.$item['id'].'\')"></td>';
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

$urlback = "gestion/page.php?category=11&min=".$minLess."&max=".$maxLess;
$urlnext = "gestion/page.php?category=11&min=".$minMore."&max=".$maxMore;


echo '<div style="text-align:right;">';

	$onclick = "HTTPTargetCall('$urlback','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Pr&eacute;c&eacute;dent</a>';
	echo ' | ';
	$onclick = "HTTPTargetCall('$urlnext','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Suivant</a>';

echo '</div>';
?>
