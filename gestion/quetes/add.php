<?php
/*
 * Created on 23 sept. 2009
 *
 */

if($_GET['modif_quete_id'] > 0)
	$quete = new quete($_GET['modif_quete_id']);

if($quete->id > 0)
	$modif = true;
else
	$modif = false;


if($_GET['valider'] != 1)
{
	
	$step = 0;

//***** Menu d'options *****
	echo '<form action="panneauAdmin.php?category=25&valider=1&norefresh=1" method="post">';
	if($modif)
	{
		echo '<input type="hidden" name="idquete" value="'.$quete->id.'" />';
		echo '<input type="hidden" name="modif" value="1" />';		
	}

	echo '<div style="float:left;width:180px;margin-top:70px;margin-left:10px;border:solid 1 px white;" class="backgroundBody">';
		echo '<div class="backgroundMenu" style="text-align:center;vertical-align:middle;height:23px;border:solid 1 px white;">';
		echo '<img src="pictures/iconesbonus/gear.png" alt="" style="float:left;margin-left:2px;" />Boite &agrave; outils';
		echo '</div>';
		echo '<div style="text-align:center;">';
			echo '<div><u> Modifier tous les : </u></div>';
			echo '<div style="margin-top:5px;">';
			echo '<a style=""> PNJ associ&eacute;s </a><br />';
			 	$array = getAutocomplete('pnj');
				echo '<input id="rowDefaultPnjName" type="text" size="25" onfocus="autoComplete(\'rowDefaultPnjName\',\''.$array.'\');autoComplete(\'rowDefaultPnjName\',\''.$array.'\');" /><br />';
				echo '<input type="button" value="Modifier" onclick="putAllPnjRow();" />';
				
			echo '<hr />';
// Modifier tous les niveaux requis		
			echo '<a style=""> niveaux requis </a><br />';
				echo '<input id="rowDefaultLvlReqName" type="text" size="25" /><br />';
				echo '<input type="button" value="Modifier" onclick="putAllLvlReqRow();" />';
			echo '</div>';	

			if($modif)
			{
				echo '<hr />';
// Dupliquer la quête		
				echo '<div>';
				echo '<a style=""> Dupliquer la qu&ecirc;te </a><br />';
					echo '<input type="button" value="Dupliquer" onclick="if(confirm(\'&ecirc;tes vous sur ?\')){duplicateQuest('.$quete->id.')};" />';
				echo '</div>';		
			}			

		
		echo '</div>';
	
	echo '</div>';
	
	echo '<div style="text-align:center;font-size:20px;font-weight:700;"> Cr&eacute;ation d\'une qu&ecirc;te </div>';
	echo '<div style="height:15px;"></div>';
	
	
	
// ***** Début du formulaire Quête *****
		
	echo '<div class="backgroundBody" style="text-align:center;margin-left:200px;border:solid 1px white;width:370px;">';
		echo '<div class="backgroundMenu" style="border:solid 1px white;width:370px;text-align:left;" onclick="show(\'infoGen\')">';
			echo '<div style="float:left;margin:3px;"><img src="pictures/iconesbonus/about.png" alt="" /></div>';
			echo '<a class="unclickable" style="margin-left:10px;">Informations g&eacute;n&eacute;rales</a>';
		echo '</div>';
		echo '<div id="infoGen" style="text-align:left;margin-left:10px;text-align:right;margin-right:40px;margin-top:7px;">';	
				echo 'Nom : <input type="text" name="quete_name" size="40" value="'.$quete->name.'" />';
			echo '<div style="text-align:left;margin-left:40px;"><a style="text-align:left:-20px;margin-top:5px;margin-bottom:5px;"><u>Classes :</u></a><br />';
				$classe_check = array();
				for($i=1;$i<=4;$i++)
				{
					$classei = "classe_$i";
					if($quete->$classei == 1 or $quete->id == 0)
						$classe_check[$i] = "checked";
					else
						$classe_check[$i] = "no";
				}

				echo ' <input type="checkbox" "'.$classe_check['1'].'" name="classe_1" value="1" /> Guerrier <br />';	
				echo ' <input type="checkbox" "'.$classe_check['2'].'" name="classe_2" value="1" /> Archer <br />';
				echo ' <input type="checkbox" "'.$classe_check['3'].'" name="classe_3" value="1" /> Mage <br />';
				echo ' <input type="checkbox" "'.$classe_check['4'].'" name="classe_4" value="1" /> Pr&ecirc;tre <br />';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	echo '<input type="hidden" name="change_step_1" value="1" />';
	
	if($modif)
		echo '<div style="text-align:center;"> <input type="submit" class="button" value="modifier la qu&ecirc;te" /> </div>';
	else
		echo '<div style="text-align:center;"> <input type="submit" class="button" value="ins&eacute;rer la qu&ecirc;te" /> </div>';
	
// ***** Affichage des étapes
	if($modif)
	{
/** Ici si on est en modification on affiche les quête déjà insérées	
 */
		$all_step = step::getAllStepForQuest($quete->id);
		foreach($all_step as $step_id)
		{
			echo '<div id="" style="margin-top:15px;margin-left:200px;">';
				$step_modif_id = $step_id;
				include('addstep.php');
			echo '</div>';			
		}
		
	}

		echo '<div id="addStep_'.$step.'" style="margin-top:15px;margin-left:200px;">';
			$url = "gestion/page.php?category=25&action=add&step=".$step;
			$onclick = "HTTPTargetCall('$url','addStep_".$step."')";
			echo '<a href="#" onclick="'.$onclick.'"> Ajouter une &eacute;tape </a></td>';
		echo '</div>'; 
	
	echo '</form>';
	
	echo '<div style="height:15px;"></div>';




	
}else{
//########################################################################################################################################
/** 
 *  On ajoute la quête + ses étapes
 * 
 */
	$step = 0;
	$arrayInfoQuest = array();
	if($_POST['modif'] == 1)
		$modif = true;
	else 
		$modif = false;
	
	foreach($_POST as $row=>$value)
	{
		
		// Changement d'étape
		if(strpos($row, 'change_step') === 0)
		{
			
			// Si value > 1 , on doit enregister l'étape
			if($value > 1)
			{
				if($modif)
				{	
					
					// Enregistrement des objectifs
					$array_id_need = $arrayStep['id_need'];
					$array_nb_need = $arrayStep['nb_need'];
					$arrayStep['id_need'] = '0';
					$arrayStep['nb_need'] = '0';
					$step_id2 = step::addStep($arrayStep,$modif,$_POST['idquete']);
					$sql="SELECT id FROM `quetes_etapes` WHERE etape=".$arrayStep['etape']." AND idquete=". $_POST['idquete'];
					
					$step_id=loadSqlResult($sql);
					
					
					$indice = 0;
					
					foreach($array_id_need as $value)
					{
						$array_final[$value] = $array_nb_need[$indice];
						$indice++;
					}

					$champ = 'type';
					$type = str_replace("'","",$arrayStep[$champ]);	
				
					step::addObjectives($array_final,$step_id,$type);				
				$array_final=null;
				
				}
				else
				{
					
					$arrayStep['idquete'] = "'".quete::getIdByName($_POST['quete_name'])."'";					
					
					if(quete::getIdByName($_POST['quete_name']) > 0)
					{
						
						// Enregistrement des objectifs
						$array_id_need = $arrayStep['id_need'];
						$array_nb_need = $arrayStep['nb_need'];
						$indice = 0;

						foreach($array_id_need as $value)
						{
							$array_final[$array_nb_need[$indice]] = $value;
							$indice++;
						}
						
						$arrayStep['id_need'] = 0;
						$arrayStep['nb_need'] = 0;
						$step_id = step::addStep($arrayStep);
						
						$champ = 'type';
						$type = str_replace("'","",$arrayStep[$champ]);	
						
						// Maintenant qu'on a le step id on enregistre
						step::addObjectives($array_final,$step_id,$type);	
						
						// Insertion des actions
						$current = 'action_before';
						$current_array = array();
						
						$i = 1;
						
						foreach($arrayActions as $action_name=>$value)
						{
							if(ereg($current,$action_name))
							{
								$new_name = str_replace($current,'',$action_name);
								switch($new_name)
								{
									case '':
										$new_name = 'id';
									break;
									case '_ob':
										$new_name = 'name';
									break;
								}
								$current_array[$new_name] = $value;
								
								
							}else{
								
								// On enregistre et on passe a la suivant
								$obstacle = new obstacle(0);
								$obstacle->addObstacleOnStep($step_id,$i,$current_array['type'],$current_array['name'],$current_array['map'],$current_array['abs'],$current_array['ord']);
								$i++;
								
								$current = $action_name;
								$current_array = array();
								
								$new_name = getNewNameObstacle($current,$action_name);
								$current_array[$new_name] = $value;
							}
						}
						
					}else{
						echo ' Erreur : Id de quête est vide';
					}	
							
					// On enregistre le dernier
					$obstacle = new obstacle(0);
					$obstacle->addObstacleOnStep($step_id,$i,$current_array['type'],$current_array['name'],$current_array['map'],$current_array['abs'],$current_array['ord']);
				}
					
			}
			// Sinon on insère les infos de quête
			else
			{
				if($_POST['quete_name'] != "")
				{
					quete::addQuete($arrayInfoQuest['quete_name'],$arrayInfoQuest['classe_1'],$arrayInfoQuest['classe_2'],$arrayInfoQuest['classe_3'],$arrayInfoQuest['classe_4'],$modif,$_POST['idquete']);					
				}	
				else	
				{
					$error = 'Une erreur est survenu , vous avez surement oublier le nom de la qu&ecirc;te. <br />' .
							' <a href="panneauadmin.php"> Retour au panneau d administration </a>';
					pre_dump_error($error,true);
				}
			}
			
			if($value == 0)
			{
				$value = str_replace('change_step_','',$row);
			}
			
			$arrayStep = array();
			$arrayStep['etape'] = $value;
			$step = $value;		

		 }
			

	// Si step == 0 , on insère la quête (infos : name , classe dispo , etc ...)		
		if($step == '0')
		{
			if($row == 'quete_name')
				$value = htmlentities($value,ENT_QUOTES);
			if(empty($value))
				$value = 0;
			
			$arrayInfoQuest[$row] = "'".$value."'";
		}
		else
		{
			// Ici crée $array step et on le remplit	
			
			// Cas ou l'on crée la quête, on prend en compte l'id de l'étape
			switch($row)
			{
				case 'text_'.$step :
					$valueRow = htmlentities($value,ENT_QUOTES);
				break;
				case 'text_pnj_'.$step :
					$valueRow = htmlentities($value,ENT_QUOTES);
				break;
				case 'text_pnj_after_'.$step :
					$valueRow = htmlentities($value,ENT_QUOTES);
				break;
				case 'text_pnj_quest_'.$step :
					$valueRow = htmlentities($value,ENT_QUOTES);
				break;
				case 'objet_req_'.$step :
					$valueRow = item::getIdByName($value);
				break;
				case 'pnj_'.$step :
					$valueRow = pnj::getIdByName($value);
				break;
				case 'pnj_valid_'.$step :
					$valueRow = pnj::getIdByName($value);
				break;
				case 'id_need_'.$step :	
					$valueRow = $value;
				break;
				case 'objet_win_'.$step :
					$valueRow = item::getIdByName($value);
				break;
				case 'skill_win_'.$step :
					$valueRow = skill::getIdByName($value);
				break;
				default:
					$valueRow = $value;
				break;
			}				
			
				
			if($valueRow == '')
				$valueRow = 0;
			
			$row = str_replace("_".$step, "", $row);
			
			
			if($row != 'change_step' && $row != 'idquete')
			{
				if (eregi('action',$row))
				{
					// Ici on met les actions pour enregistrer dans la base
					$arrayActions[$row] = $valueRow;
				}else{
					if(eregi('id_need',$row) or eregi('nb_need',$row))
						$arrayStep[$row] = $valueRow;
					else
						$arrayStep[$row] = "'".$valueRow."'";
				}
				
			}
				
		}
		
	}

if($modif)
	echo "la qu&ecirc;te a bien &eacute;t&eacute; modifi&eacute;e";
else
	echo "la qu&ecirc;te a bien &eacute;t&eacute; cr&eacute;e";	
	
}

// ######## Fonction pour le fichier ######################################

function getNewNameObstacle($current,$action_name)
{
	$new_name = str_replace($current,'',$action_name);
	switch($new_name)
	{
		case '':
			$new_name = 'type';
		break;
		case '_ob':
			$new_name = 'name';
		break;
	}	
	return $new_name;
}



?>
