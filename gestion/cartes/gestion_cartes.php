<?php
 
//-----------------------------------------------------------//
//---------------- Gestionnaire de cartes -------------------//
//-----------------------------------------------------------// 

// Fonctions

function createOnclick($url,$target='tdbodygame',$clean='no')
{
	$url = 'gestion/page.php?category=2&'.$url;
	if($clean == 'yes')
		$onclick = "document.getElementById('ModuleGestionMapContainer').innerHTML = '';";
	else
		$onclick = "";
	
	$onclick .= "HTTPTargetCall('".$url."','$target');";
	return $onclick;
}

function getOnclickRefresh()
{
	$url = 'gestion/page.php?category=2';
	$onclick = "HTTPTargetCall('".$url."','tdbodygame');";
	return $onclick;
}

// Récupération de variables
$idmap = (!empty($_GET['map']))? $_GET['map'] : null;
$map = new map($idmap);

$refreshmap = (!empty($_GET['refreshmap']))? $_GET['refreshmap'] : null; 

$mstr = (!empty($_GET['mstr']))? $_GET['mstr'] : null; 
$telep = (!empty($_GET['telep']))? $_GET['telep'] : null; 

$amstr = (!empty($_GET['amstr']))? $_GET['amstr'] : null; 
$atelep = (!empty($_GET['atelep']))? $_GET['atelep'] : null; 

$do = (!empty($_GET['do']))? $_GET['do'] : null;  

if($_POST['do'] == 'updateTelep')
	$do = 'updateTelep';
	
	

switch($do)
{
	case 'update':
		$mapUp = new map($idmap);
		foreach($_POST as $name=>$value)
		{
			$mapUp->update($name,$value);
		}
		echo 'la carte a bien &eacute;t&eacute; modifi&eacute;e';
		
		$show_option = 1;
	break;
	
	case 'import':
		$map = new map($idmap);
		$map->importInformation($_POST['map_import']);
		$needShowOptions = 1;
	break;	
	
	case 'blockArea':
		$map = new map($idmap);
		$map->blocCases($_POST['abs'],$_POST['abs_max'],$_POST['ord'],$_POST['ord_max']);
		$show_option = 1;
	break;
	
	case 'updateTelep':
		foreach($_POST as $name=>$value)
		{
			if($name != 'do')
				map::updateMap($name,$value,$_GET['idtelep']);
		}
		$show_option  = 1;
	break;

}


if(($block == 0 && $deblock == 0 && $refreshmap == 0 && $map->id >= 1) or $_GET['do'] == 'updateTelep')
{
	$needShowOptions = 1;
}


// Bloquer une case
if ($block == 1) {

	$map->blocCase($abs,$ord);

	$arrayBlockex = explode(',',$_GET['arrayBlockex']);
	foreach($arrayBlockex as $cord)
	{
		$arrayBlock[$cord] = '1';
	}
	
	$case = ($ord - 1) * 25 + $abs;
	$arrayBlock[$case] = '1';

}


// D�bloquer une case
if ($deblock == 1) {
	$sql = "DELETE FROM `map` WHERE `abs` = '".$abs."' && `ord` = '".$ord."' && `map` = '".$map->id."' LIMIT 1";
	loadSqlExecute($sql);
	
	$arrayBlockex = explode(',',$_GET['arrayBlockex']);
	foreach($arrayBlockex as $cord)
	{
		$arrayBlock[$cord] = '1';
	}
	
	$case = ($ord - 1) * 25 + $abs;
	$arrayBlock[$case] = '0';
}

// --------------------------------------- AJOUT MONSTRE -----------------------------------------------------------------------
if ($amstr == 1) {
	$sql="SELECT count(*) FROM combat WHERE `abs` = '".$abs."' && `ord` = '".$ord."' && `map` = '".$map->id."' ";
	$exist = loadSqlResult($sql);

	if ($exist == 0)  { // fin si il n'y a pas deja de monstre
	 $sql="SELECT * FROM `monstre` WHERE `id` = '".$idmstr."' ";	
	 $mstrrr =loadSqlResultArray($sql); 
	$viemstr = $mstrrr['vie'] ;
	 $sql="INSERT INTO `combat` (`id` ,`map` ,`abs` ,`ord` ,`absdep` ,`orddep` ,`vie`)VALUES ('$idmstr', '$map->id', '$abs', '$ord', '$abs', '$ord', '$viemstr')";
	$loadSqlExecute($sql);	

	} // fin si il n'y a pas deja une case existante


} // fin ajouter un teleporteur


// Chargement des tableaux (case bloqu�es ,)
$arrayWP = map::getAllTelep($map->id);
$arrayTemp = array();
$arrayBlock = map::getAllBlock($map->id);
foreach($arrayBlock as $cord=>$val)
{
	$arrayTemp[] = $cord;
}
$arrayBlockex = implode(',',$arrayTemp);	


// -------- AFFICHAGE ---------

if($needShowOptions == 1)
{

	// Options
	echo '<div id="toto">';
		
		echo '<table><tr>';
	// Option changer de carte
		echo '<td style="width:20%">';
			echo '<form>';
				echo 'Changer de carte : <br />';
				echo '<input id="changemap" />';
				echo ' <input class="button" type="submit" onclick="changeMap();" />';
				echo '<input class="button" type="button" onclick="refreshMapEdition(\''.$map->id.'\');" value="rafraichir" />';
			echo '</form>';
			
		echo '</td>';
	// Ajout de monstre et t�l�porteur	
		echo '<td>';
			echo '<ul>';
				echo '<li>';
					$url = "action=add&type=telep&map=".$map->id;
					$target = "add_or_modif";
					$onclick = createOnclick($url,$target,'no');				
					echo '<a href="#" onclick="'.$onclick.'">Ajouter un t&eacute;l&eacute;porteur</a>';
				echo '</li>';
				echo '<li>';
					$url = "action=add&type=insert_interaction&map=".$map->id;
					$target = "add_or_modif";
					$onclick = createOnclick($url,$target,'no');	
					echo '<a href="#" onclick="'.$onclick.'">Ajouter une interaction</a>';
				echo '</li>';
				echo '<li>';
					$url = "action=add&type=monstre&map=".$map->id;
					$target = "add_or_modif";
					$onclick = createOnclick($url,$target,'no');	
					echo ' g&egrave;rer : <select onclick="">';
						echo '<option onclick="changeGestionType(\''.$map->id.'\',1);"> cases bloqu&eacute;es</option>';
						echo '<option onclick="changeGestionType(\''.$map->id.'\',2);"> monstres </option>';
						echo '<option onclick="changeGestionType(\''.$map->id.'\',3);"> ressources </option>';
					echo '</select>';
				echo '</li>';
			echo '</ul>';
		echo '</td>';
	// Div container du formulaire ajout monstre ou t�l�porteur	
		echo '<td>';
			echo '<div id="add_or_modif" style="margin-left:30px;float:right;">';
				
			echo '</div>';
			echo '<div id="monster_to_add" style="display:none;">';
			
			echo '</div>';
			
			echo '<div id="ressource_to_add" style="display:none;">';
			
			echo '</div>';
		echo '</td>';
		
		echo '</tr></table>';
	echo '</div>';

}	


// Debut du cadre carte (Abs, ord , carte) ####################################################
	echo '<div id="mapGestion">';
		echo '<table><tr><td></td>';
		
		// Ici les abscisses
		echo '<td>';
			echo '<table border="0" style="border:0px;" cellspacing="0"><tr>';
				for($i=1;$i<=25;$i++)
				{
					if($i > 12)
						$width = 32;
					else
						$width = 33;
					echo '<td style="width:'.$width.'px;text-align:center;font-weight:700;">'.$i.'</td>';
				}
			echo '</tr></table>';
		echo '</td></tr>';
		
		// ici les ordonn�es
		
		echo '<tr><td>';
			echo '<table>';
				for($i=1;$i<=15;$i++)
				{
					echo '<tr><td style="height:30px;text-align:center;font-weight:700;">'.$i.'</td></tr>';
				}
			echo '</table>';
		echo '</td>';
		echo '<td>';
	
	
	
	// ################### CARTE ################################################################# 	
		
		require_once('view_carte.php');
	
		echo '</td>' .
				'</tr>' .
					'</table>';
		

	echo '</div>';


if($needShowOptions == 1)
{
	

	echo '</td>'; 
	echo '</tr></table>';


	
	
	echo '<div style="height:10px;"></div>';
	if((($_GET['category'] != '2' or $_GET['do'] != '' or $show_option == 1) and $_POST['do'] != 'updateTelep') and $_GET['do'] != 'blockArea')
	{
		$style = "display:none;";
	}
	
	// Modules de gestion de cette carte
	
	
		echo '<div id="ModuleGestionMapContainer">';
		echo '<div style="height:230px;">';
			
			// Affichage du panneau de modification de la carte
			echo '<div style="'.$style.'">';
			
			echo '<div style="width:250px;margin-left:40px;text-align:center;float:left;">';
				echo '<fieldset>';
				echo '<div id="title_other_options" style="font-weight:700;">';
					echo 'Modifier la carte :';
					echo '<hr />';
				echo '</div>';
				echo '<div id="other_options" style="text-align:left;">';
					
					if($map->id > 0)
					{
						//$map->id = $map->getIdByImage($map->image);
						echo '<form method="post" action="panneauAdmin.php?category=2&do=update&norefresh=1&map='.$map->id.'">';
					 
					 	echo 'Continent : <select name="continent">';
						 $arrayMap = map::getAllContinents();
					 	echo '<option value="0"></option>';
					 	foreach($arrayMap as $mapy)
					 	{
					 		echo '<option value="'.$mapy['id'].'" ';
								if($mapy['id'] == $map->getContinent())
								{
									echo 'selected="selected"';
								}
							echo '>'.$mapy['name'].'</option>';
					 	}
					    echo '</select><br />';
						 
						 echo 'abs : <input type="text" name="abs" size="3" value="'.$map->abs.'" /><br />
						 ord : <input type="text" name="ord" size="3" value="'.$map->ord.'" /><br />
						 &nbsp;&nbsp;alt : <input type="text" name="alt" size="3" value="'.$map->alt.'" />
						 <div style="text-align:center;"><input class="button" type="submit" value="Modifier" /></div>
						 
						</form>';	
						
						echo '<hr />';
						echo 'Importer les infos d\'une carte : ';
						echo '<div style="text-align:center;">';
							echo '<form method="post" action="panneauAdmin.php?category=2&do=import&norefresh=1&map='.$map->id.'">';
							echo '<input type="text"  name="map_import" size="2" value="0" /> ';
							echo '<input class="button" type="submit" value="Importer" />';
							echo '</form>';
						echo '</div>';
					}
					
				echo '</div>';
				echo '</fieldset>';
			echo '</div>';
			
	// ############ Affichage de l'option de suppression de la carte #####################################
	
			echo '<div style="width:200px;margin-left:30px;text-align:center;float:left;">';
				echo '<fieldset>';
				echo '<div id="title_other_options" style="font-weight:700;">';
					echo 'Supprimer la carte :';
					echo '<hr />';
				echo '</div>';
				echo '<div id="other_options" style="text-align:center;">';
					echo '<form method="post" action="panneauAdmin.php?category=2&do=delete&norefresh=1&map='.$map->id.'">';
						echo '<input type="hidden" name="idmap" value="'.$map->id.'" />';
						$onclick="return(confirm('Etes-vous s�r de vouloir supprimer cette carte ?'));";
						echo '<input class="button" type="submit" onclick="'.$onclick.'" value="Supprimer">';
					echo '</form>';
				echo '</div>';
				echo '</fieldset>';
			
				echo '<hr />';
				
				echo '<fieldset>';
				echo '<div id="title_other_options" style="font-weight:700;">';
					echo 'Bloquer une zone :';
					echo '<hr />';
				echo '</div>';
				echo '<div id="other_options" style="text-align:center;">';
					echo '<form method="post" action="panneauAdmin.php?category=2&do=blockArea&norefresh=1&map='.$map->id.'">';
						echo '<input type="text"  name="abs" size="2" value="0" /> <input type="text"  name="abs_max" size="2" value="0" /><br /> ';
						echo '<input type="text"  name="ord" size="2" value="0" /> <input type="text"  name="ord_max" size="2" value="0" /><br /> ';
						echo '<input class="button" type="submit" value="Bloquer" />';
					echo '</form>';
				echo '</div>';
				echo '</fieldset>';		
			
			
			echo '</div>';
		


			
	// ######### Affichage des Id des cartes adjacentes #####################""
			
			echo '<div style="width:200px;margin-left:30px;text-align:center;float:left;">';
				echo '<fieldset>';
				echo '<div id="title_other_options" style="font-weight:700;">';
					echo 'Id des cartes adjacentes :';
					echo '<hr />';
				echo '</div>';
				echo '<div id="other_options" style="text-align:center;">';
					
					// Chargement des cartes adjacentes
					$idmap001 = $map->getAdjacente('0','0','1');
					$idmap002 = $map->getAdjacente('0','0','-1');
					$idmap010 = $map->getAdjacente('0','1','0');
					$idmap020 = $map->getAdjacente('0','-1','0');
					$idmap100 = $map->getAdjacente('1','0','0');
					$idmap200 = $map->getAdjacente('-1','0','0');
					
					
					
					// On pourra imaginer un d�placement depuis les fl�ches en bas pour plus tard ^^
					
					
					if($idmap001 >0)
					{
						$url = "map=".$idmap001;
						$onclick001 = createOnclick($url,'tdbodygame','yes');
					}else{
						$onclick001 = "";
					}
					
					if($idmap002 >0)
					{
						$url = "map=".$idmap002;
						$onclick002 = createOnclick($url,'tdbodygame','yes');
					}else{
						$onclick002 = "";
					}
					
					if($idmap010 >0)
					{
						$url = "map=".$idmap010;
						$onclick010 = createOnclick($url,'tdbodygame','yes');
					}else{
						$onclick010 = "";
					}
					
					if($idmap020 >0)
					{
						$url = "map=".$idmap020;
						$onclick020 = createOnclick($url,'tdbodygame','yes');
					}else{
						$onclick020 = "";
					}
					
					if($idmap100 >0)
					{
						$url = "map=".$idmap100;
						$onclick100 = createOnclick($url,'tdbodygame','yes');
					}else{
						$onclick100 = "";
					}
					
					if($idmap200 >0)
					{
						$url = "map=".$idmap200;
						$onclick200 = createOnclick($url,'tdbodygame','yes');
					}else{
						$onclick200 = "";
					}
					
					
				
					
					echo '<table style="width:120px;border:solid 1px;text-align:center;margin-left:20px;" border="0" cellspacing="0">';
						echo '<tr style="height:24px;">';
							echo '<td style="width:24px;"></td><td style="width:24px;"></td><td style="width:24px;">'.$idmap020.'</td><td style="width:24px;"></td><td style="width:24px;">'.$idmap001.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td></td><td></td><td><img src="pictures/direction/h.png" onclick="'.$onclick020.'" /></td><td><img src="pictures/direction/hd.png" onclick="'.$onclick001.'" /></td><td></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>'.$idmap200.'</td><td><img src="pictures/direction/g.png" onclick="'.$onclick200.'" /></td><td>'.$map->id.'</td><td><img src="pictures/direction/d.png" onclick="'.$onclick100.'" /></td><td>'.$idmap100.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td></td><td><img src="pictures/direction/bg.png" onclick="'.$onclick002.'" /></td><td><img src="pictures/direction/b.png" onclick="'.$onclick010.'" /></td><td></td><td></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td style="width:24px;">'.$idmap002.'</td><td style="width:24px;"></td><td style="width:24px;">'.$idmap010.'</td><td style="width:24px;"></td><td style="width:24px;"></td>';
						echo '</tr>';
					echo '</table>';
					
				echo '</div>';
				echo '</fieldset>';
			echo '</div>';
			echo '</div>';
		echo '</div>';	
		
	// ######################################### TELEPORTEUR ##################################################################################	
		
		echo '<div id="TelepManager" style="'.$style.';margin-top:40px;">';
			echo '<fieldset>';
			echo '<u><b>Gestion des t&eacute;l&eacute;porteurs</b></u>';
			$arrayWPEdit = map::getAllTelep($map->id,'1','1','1');
			// Menu Info
			echo '<table style="margin-left:50px;text-align:center;"><tr>';
				echo '<td style="width:50px;"> # </td>';
				echo '<td style="width:50px;"> abs </td>';
				echo '<td style="width:50px;"> ord </td>';
				echo '<td style="width:57px;"> vers map </td>';
				echo '<td style="width:57px;"> vers abs </td>';
				echo '<td style="width:57px;"> vers ord </td>';
				echo '<td style="width:90px;"> Modifier </td>';
				echo '<td style="width:90px;"> Supprimer </td>';
			
			echo '</tr></table>';
			foreach($arrayWPEdit as $row)
			{
				echo '<div id="modif_telep_'.$row['id'].'"><form id="form_modif_telep_'.$row['id'].'"  method="post" action="panneauAdmin.php?category=2&norefresh=1&do=updateTelep&map='.$map->id.'&idtelep='.$row['id'].'">';
					echo '<input type="hidden" name="do" value="updateTelep" />';
					echo '<table style="margin-left:50px;">';
					echo '<tr>';
						echo '<td>';
							echo '<select name="type" id="selectTelep_'.$row['id'].'" onchange="changeTelep(\'selectTelep_'.$row['id'].'\');" style="background:url(pictures/telep/'.$row['type'].'.png) no-repeat; width:50px; height:28px;">';
								for($i=1;$i<=4;$i++)
								{
									echo '<option value="'.$i.'" style="background:url(pictures/telep/'.$i.'.png) no-repeat; width:24px; height:24px;" ';
									if($row['type'] == $i)
											echo 'SELECTED=selected';
									echo '></option>';
								}
							echo '</select>';
						echo '</td>';
						echo '<td style="width:50px;">';
							echo '<input type="text" name="abs" size="3" value="'.$row['abs'].'" />';
						echo '</td>';
						echo '<td style="width:50px;">';
							echo '<input type="text" name="ord" size="3" value="'.$row['ord'].'" />';
						echo '</td>';
						echo '<td style="width:60px;">';
							echo '<input type="text" name="changemap" size="3" value="'.$row['changemap'].'" />';
						echo '</td>';
						echo '<td style="width:60px;">';
							echo '<input type="text" name="abschange" size="3" value="'.$row['abschange'].'" />';
						echo '</td>';
						echo '<td style="width:60px;">';
							echo '<input type="text" name="ordchange" size="3" value="'.$row['ordchange'].'" />';
						echo '</td>';
						echo '<td style="width:80px;">';
							echo '<input class="button" type="submit" value="Modifier" />';
						echo '</td>';
						echo '<td style="width:60px;text-align:center;">';
							echo '<input class="button" type="button" value="Supprimer" onclick="if (confirm(\'Voulez-vous supprimer ce t&eacute;l&eacute;porteur ?\')){HTTPTargetCall(\'gestion/page.php?category=2&action=deleteTelep&map='.$map->id.'&ord='.$row['ord'].'&abs='.$row['abs'].'\',\'toto\');refreshMapEdition(\''.$map->id.'\');};" />';
						echo '</td>';
						
					echo '</tr>';
					echo '</table>';
				echo '</form></div>';
			}
			echo '</fieldset>';
		echo '</div>';
		
		// ######################################### INTERACTIONS ##################################################################################	
		
		echo '<div id="InteractionManager" style="'.$style.';margin-top:40px;">';
			echo '<fieldset>';
			echo '<u><b>Gestion des Interactions</b></u>';
		
			echo '</fieldset>';
		echo '</div>';
		
		
		echo '</div>'; // fermeture de la div contenant les 4 modules principaux
}

?>

