<?php
/*
 * Created on 17 janv. 2010
 *
 */
$type = $_GET['type_gestion'];

if($type == '')
	$type = 'cases_bloquees';

if($type == 'cases_bloquees' or $type == '')
{	
	
	if($needShowOptions == 1 or $needShowOptions == '')
	{
		echo '<table width="800" height="470" border="0" align="center" cellpadding="0" cellspacing="0" background="map/'.$map->getImage().'" style="background-repeat:no-repeat;">';
		echo '<tr><td>';
	
	}else{
		$arrayBlockex = $_GET['arrayBlockex'];
	}
	echo '<table width="800" height="470" border="0" align="center" cellpadding="0" cellspacing="0">';
	echo '<tr height="32" width="736" border="0">';
	
	$case = 0;
	while ($case < 375) {
		$case = $case + 1	;
		$ord = $case/25 ;
		$ord = floor($ord) ;
		$abs = $case - ($ord*25) ;
		$ord = $ord + 1 ;
		 
		 if ($abs == 0) {
		 $abs = 25 ;
		 $ord = $ord - 1 ;
		 }	 
		 echo '<td width="32" height="32" border="0" style="text-align:center;">';		
	    		include("cases_bloquees.inc.php") ; 
	     echo '</td>';	
		if ($abs == 25) { 
			echo "</tr>" ;
			if ($ord < 15) { 
				echo '<tr height="32">' ;
			}else {
				echo "</table>" ;
			} 
		} 
	}
	echo '</table>';
	echo '</div>';
}elseif($type == 'cases_monsters')
{
	echo '<div id="map" style="background-image:url(map/'.$map->getImage().');width:800px;height:480px;border:solid 1px;cursor:pointer;">';
	$compte = 1; // compte correspond à la profondeur (du calque)
	
	while ($case < 375) {
		$case = $case + 1	;
		$ord = $case/25 ;
		$ord = floor($ord) ;
		$abs = $case - ($ord*25) ;
		$ord = $ord + 1 ;
		 
		if ($abs == 0) {
			$abs = 25 ;
			$ord = $ord - 1 ;
		}	
		
		include("cases_monstres.inc.php") ;
			
	}
}elseif($type == 'ressources')
{
	echo '<div id="map" style="background-image:url(map/'.$map->getImage().');width:800px;height:480px;border:solid 1px;cursor:pointer;">';
	$compte = 1; // compte correspond à la profondeur (du calque)
	
	while ($case < 375) {
		$case = $case + 1	;
		$ord = $case/25 ;
		$ord = floor($ord) ;
		$abs = $case - ($ord*25) ;
		$ord = $ord + 1 ;
		 
		if ($abs == 0) {
			$abs = 25 ;
			$ord = $ord - 1 ;
		}	
	 	
		include("cases_ressources.inc.php") ;
			
	}
}

?>
