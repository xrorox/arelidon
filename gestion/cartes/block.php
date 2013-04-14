<?php
/*
 * Created on 29 sept. 2009
 *
 * Blocage et déblocage d'une case
 */
 
 // Bloquer une case

$block = $_GET['block'];
$deblock = $_GET['deblock'];

$map = new map($_GET['map']);

$abs = $_GET['abs'];
$ord = $_GET['ord'];

if ($block == 1) {
	
	$map->blocCase($abs,$ord);
	destroy_cache('case','case_'.$map->id);
	
	$case = ($ord - 1) * 25 + $abs;
	$arrayBlock[$case] = '1';
	
	map::showCaseBlock($case,$arrayBlock[$case],$abs,$ord,$target,$map->id);
}

// Débloquer une case
if ($deblock == 1) {
	$sql = "DELETE FROM `map` WHERE `abs` = '".$abs."' && `ord` = '".$ord."' && `map` = '".$map->id."' LIMIT 1";
	loadSqlExecute($sql);
	destroy_cache('case','case_'.$map->id);
	
	$case = ($ord - 1) * 25 + $abs;
	$arrayBlock[$case] = '0';
	map::showCaseBlock($case,$arrayBlock[$case],$abs,$ord,$target,$map->id);
}



?>
