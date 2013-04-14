<?php
/*
 * Created on 10 sept. 2009
 *


 */
 
// Fonction de gestion des cases
function inCase($abs,$ord,$alt)
{
	 $map = new map();
	 $map->loadMapByCord($abs,$ord,$alt);
	 $urlimg = "map/".$map->image;
	 echo '<td style="border:0px;">';
		echo '<div class="caseMapWolrd" style="text-align:center;width:78px;height:46px;">';
    		if($map->id > 0)
    		{
    			$url = 'gestion/page.php?category=2&map='.$map->id ;
    			$onclick = "HTTPTargetCall('".$url."','tdbodygame')";
    			echo '<a href="#" onclick="'.$onclick.'"><img src="'.$urlimg.'" alt="pas d\'image" style="width:80px;height:48px;border:0px;" /></a>';
    		}else{
    			$url = 'panneauAdmin.php?category=1&norefresh=1&preabs='.$abs.'&preord='.$ord.'&prealt='.$alt ;
    			echo '<div style="height:10px;"></div><div><a href="'.$url.'">pas de carte</a></div>';
    		}
    			
    	echo '</div>';
     echo '</td>';
}

function getUrl($abschange,$ordchange,$altchange,$absmin,$absmax,$ordmin,$ordmax,$alt)
{
	if($abschange == '1')
	{
		$absmin = $absmin + 9;
		$absmax = $absmax + 9;		
	}
	if($abschange == '-1')
	{
		$absmin = $absmin - 9;
		$absmax = $absmax - 9;		
	}
	if($ordchange == '1')
	{
		$ordmin = $ordmin + 9;
		$ordmax = $ordmax + 9;		
	}
	if($ordchange == '-1')
	{
		$ordmin = $ordmin - 9;
		$ordmax = $ordmax - 9;		
	}
	if($altchange == '1')
	{
		$alt = $alt + 1;
	}
	if($altchange == '-1')
	{
		$alt = $alt - 1;
	}
	
	$url = 'gestion/page.php?category=3&absmin='.$absmin.'&absmax='.$absmax.'&ordmin='.$ordmin.'&ordmax='.$ordmax.'&alt='.$alt ;
	return $url;
}

// Récupération des variables
 
$absmin = $_GET['absmin'];
$absmax = $_GET['absmax'];
$ordmin = $_GET['ordmin'];
$ordmax = $_GET['ordmax'];
$alt = $_GET['alt'];

if($absmin == '')
	$absmin = 0;
	
if($absmax == '')
	$absmax = 8;
	
if($ordmin == '')
	$ordmin = 0;
	
if($ordmax == '')
	$ordmax = 8;

if($alt == '')
	$alt = 0; 
 
 
// Affichage de la carte du monde en 10x10 

echo '<table border="1">';

echo '<tr>';
	// on affiche l'altitude dans cette case
	echo '<td style="width:56px;height:24px;text-align:center;"> ';
		echo '<table>';
			echo '<tr>';
				echo '<td>';
					$url = getUrl('0','0','1',$absmin,$absmax,$ordmin,$ordmax,$alt);
	    			$onclick = "HTTPTargetCall('".$url."','tdbodygame')";
					echo '<img src="pictures/direction/hg.png" alt="UP" onclick="'.$onclick.'" />';
				echo '</td>';
			echo '<td></td></tr>';
			echo '<tr>';
				echo '<td>';
					$url = getUrl('0','0','-1',$absmin,$absmax,$ordmin,$ordmax,$alt);
	    			$onclick = "HTTPTargetCall('".$url."','tdbodygame')";
					echo '<img src="pictures/direction/bg.png" alt="DW" onclick="'.$onclick.'" />';
				echo '</td>';
				echo '<td>';
					echo $alt;
				echo '</td>';
			echo '</tr>';
		echo '</table>';
	echo '</td>';
	echo '<td>';
		echo '<table>';
		
		echo '<tr>';
		for($i=$absmin;$i<=$absmax;$i++)
		{
			echo '<td style="width:80px;text-align:center;">';
				if($i - $absmin == 4)
				{
					$url = getUrl('0','-1','0',$absmin,$absmax,$ordmin,$ordmax,$alt);
    				$onclick = "HTTPTargetCall('".$url."','tdbodygame')";
					echo '<img src="pictures/direction/h.png" alt="H" onclick="'.$onclick.'" />';
				}
			echo '</td>';
		}
		echo '</tr>';
		
		echo '<tr>';
		for($i=$absmin;$i<=$absmax;$i++)
		{
			echo '<td style="width:80px;text-align:center;">'.$i.'</td>';
		}
		echo '</tr>';
		echo '</table>';
	echo '</td>';
	echo '<td></td>';
echo '</tr>';
echo '<tr>';

echo '<td>';
// menu a gauche	
	echo '<table>';
		for($i=$ordmin;$i<=$ordmax;$i++)
		{
			echo '<tr><td>';
			if($i - $ordmin == 4)
				{
					$url = getUrl('-1','0','0',$absmin,$absmax,$ordmin,$ordmax,$alt);
    				$onclick = "HTTPTargetCall('".$url."','tdbodygame')";
					echo '<img src="pictures/direction/g.png" alt="G" onclick="'.$onclick.'" />';
				}
			echo '</td><td style="height:48px;width:56px;text-align:center;">'.$i.'</td>';
			echo '</tr>';
		}
	echo '</table>';

echo '</td>';
echo '<td>';
// Affichage de la carte
	echo '<table border="0" cellspacing="0">';
		
	for($ord=$ordmin;$ord<=$ordmax;$ord++)
	{
		echo '<tr>';
		for($abs=$absmin;$abs<=$absmax;$abs++)
		{
			inCase($abs,$ord,$alt);
		} 
		echo '</tr>';
	}
	echo '</table>';

echo '</td>';
// Menu droite
echo '<td>';
	echo '<table>';
		for($i=$ordmin;$i<=$ordmax;$i++)
		{
			echo '<tr><td>';
			if($i - $ordmin == 4)
				{
					$url = getUrl('1','0','0',$absmin,$absmax,$ordmin,$ordmax,$alt);
    				$onclick = "HTTPTargetCall('".$url."','tdbodygame')";
					echo '<img src="pictures/direction/d.png" alt="D" onclick="'.$onclick.'" />';
				}
			echo '</tr>';
		}
	echo '</table>';
echo '</td>';

echo '</tr>';
// Menu du bas
echo '<tr>';
	echo '<td style="width:56px;height:24px;text-align:center;"> </td>';
	echo '<td>';
		echo '<table>';
		
		echo '<tr>';
		for($i=$absmin;$i<=$absmax;$i++)
		{
			echo '<td style="width:80px;text-align:center;">';
// flèche de bas				
				if($i - $absmin == 4)
				{
					$url = getUrl('0','1','0',$absmin,$absmax,$ordmin,$ordmax,$alt);
    				$onclick = "HTTPTargetCall('".$url."','tdbodygame')";
					echo '<img src="pictures/direction/b.png" alt="B" onclick="'.$onclick.'" />';
				}
					
			echo '</td>';
		}
		echo '</tr>';
		echo '</table>';
	echo '</td>';
	echo '<td></td>';
echo '</tr>';
echo '</table>'; 
?>
