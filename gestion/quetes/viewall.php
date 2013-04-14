<?php
/*
 * Created on 15 oct. 2009
 *
 */
 

/** Module de recherche sur les quêtes , à réaliser plus tard
 * 
 * Possibilité de rechercher par : 
 * 		- nom 
 *      - niveau requis
 *      - nombre d'étape ?
 */
/*
echo '<fieldset>';
	echo '<legend> Recherche </legend>';

echo '</fieldset>';
*/


// Récupération des données
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
 	 $orderby = 'lvl_req';
 	 
  if($_GET['asc'] != '')
 	$asc = $_GET['asc'];
  else
 	$asc = 'DESC';
 	
  $order = $orderby;


/**
 * Module contenant la liste des quêtes
 *     - possibilité de tri : nombre d'étape,niveau req,quete req ? , classe req ? exp donnée , or données
 * 
 *     PS : classe req :   G = guerrier , A = archer , M = mage , P = prêtre , T = tous 
 */

echo '<div id="del_quest_div"></div>';

echo '<div> Liste des qu&ecirc;tes </div>';
echo '<div>';
 echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">';
	echo '<tr class="backgroundMenuNoRadius">';
		$arrayStatut = array('name'=>'nom','classe_req'=>'classes','lvl_req'=>'lvl req','nb_etapes'=>'nombre &eacute;tape','pnj'=>'PNJ d&eacute;part','sum_exp'=>'Exp totale','sum_gold'=>'Or total');
		
		
		foreach($arrayStatut as $row => $trad)
		{
			$urltri = "gestion/page.php?category=17&orderby=";
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
		
		echo '<td> Edit </td>';
		echo '<td> Sup </td>';
	echo '</tr>';
	
	$arrayQuest = quete::getAllQuest($min,$max,$order,$asc);
	foreach($arrayQuest as $quest)
	{
		
		echo '<tr>';		
		foreach($arrayStatut as $row=>$trad)
		{
			switch($row)
			{
				case 'classe_req':
					$str = "";
					if($quest['classe_1'] == 1)
					{
						$str .= "G";
					}
					if($quest['classe_2'] == 1)
					{
						$str .= "A";
					}
					if($quest['classe_3'] == 1)
					{
						$str .= "M";
					}
					if($quest['classe_4'] == 1)
					{
						$str .= "P";
					}
					
					if($str == 'GAMP')
						$str = 'Toutes';
					
					echo '<td>'.$str.'</td>';				
				break;
				case 'pnj':
					$pnjname = pnj::getNameById($quest['pnj']);
					echo '<td>'.$pnjname.'</td>';
				break;
				default:
					echo '<td>'.$quest[$row].'</td>';
				break;
			}
		}		
			$id = $quest['id'];			
			$urledit = "gestion/page.php?category=25&modif_quete_id=$id";
			echo '<td><img src="pictures/icones/edit.gif" title="Editer" onclick="loadMenu(\''.$urledit.'\')" /></td>';
			$urldel = "gestion/page.php?category=25&action=delete&quest_id=$id";
			echo '<td><img src="pictures/icones/supp.gif" title="Supprimer" onclick="if(confirm(\'Confirmer ?\')){loadMenu(\''.$urldel.'\');}" /></td>';
		echo '</tr>';
	}

echo '</table>';
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

$urlback = "gestion/page.php?category=17&min=".$minLess."&max=".$maxLess;
$urlnext = "gestion/page.php?category=17&min=".$minMore."&max=".$maxMore;


echo '<div style="text-align:right;">';

	$onclick = "HTTPTargetCall('$urlback','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Pr&eacute;c&eacute;dent</a>';
	echo ' | ';
	$onclick = "HTTPTargetCall('$urlnext','tdbodygame')";
	echo '<a href="#" onclick="'.$onclick.'">Suivant</a>';

echo '</div>';
?>
