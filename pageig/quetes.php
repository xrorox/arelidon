<?php
// Fonction d'affichage d'une nouvelle qu�te dans la liste
require_once($server.'class/step.class.php');
require_once($server.'class/quete.class.php');
function showNewQuest($tempQuest,$idquete,$etape,$char)
{
	$quete = new quete($idquete);
	$numberofstep = $quete->getNumberOfStep();
	
	// Si le joueur est � la derni�re �tape , il aura valid � 1
	$sql = "SELECT * FROM quetes_char WHERE idchar = '".$char->getId()."' && idquete = $idquete && etape = $numberofstep";
	$result = loadSqlResultArray($sql);
	
	// On ferme la div pr�c�dente sauf si c'est la premi�re qu�te
	if($tempQuest != '0')
		echo '</div></div>';
	
	$style="margin-left:10px;font-weight:700;font-size:16px;cursor:pointer;";

	// Si etape 999 (qu�te finis ?) ET n'a pas valid�e la derni�re �tape
	// Avoir ce syst�me de valide permet de r�ouvrir une qu�te :)
	if($etape != 999 && $result['valid'] != 1)
	{
		$style .= "";
		$class = "notFinish";
	}	
	else
	{
		$style .= "color:red;display:none;";
		$class = "Finish";
	}

	echo '<div name="'.$class.'" style="'.$style.'">';
		echo '<img src="pictures/utils/arrow.gif" alt="v" onclick="show(\'step_to_'.$quete->getId().'\');" />  ';
			echo $quete->getName(). ' ';
			echo '('.$quete->getCurrentStep($char->getId()).'/'.$quete->getNumberOfStep().')';
		echo '<div id="step_to_'.$quete->getId().'" style="display:none;font-weight:500;">';
	$tempQuest = $quete->getId();
	return $tempQuest;
}


echo '<table style="width:100%;height:100%;margin:0px;" cellspacing="0">';
	echo '<tr>';
// Menu permettant de choisir la qu�te ou l'�tape � affich�e
	echo '<td style="width:350px;">';
		echo '<div id="menuOptionQuestList">';
				echo '<div style="margin-left:5px;">';
					// Checkbox qu�te en cours , par d�faut
					echo '<input id="notFinish" type="checkbox" checked="checked" onclick="switchShowTypeQuest(\'notFinish\');" /> Qu&ecirc;tes en cours  ';
				
					// checkbox qu�te termin�es , par d�faut d�coch�e
					echo '<input id="Finish" type="checkbox" onclick="switchShowTypeQuest(\'Finish\');" /> Qu&ecirc;tes termin&eacute;es ';
				echo '</div>';
		echo '**************************************************';
		echo '</div>';

// Affichage des qu�tes de l'utilisateur'		
		echo '<div  style="min-height:600px;">';

// Chargement de toutes les �tapes en cours ou termin�es . Trier par id qu�te
		$step_list = 	step::getAllStepForChar($char->getId(),'q_e.id as id,q_e.etape as etape,q_e.idquete as idquete,q_e.name as text');

		// Variable temporaire qui va d�termin�e lorsque l'on change d'�tape
		$tempQuest = 0;
		if(count($step_list)>= 1)
		{
			foreach($step_list as $step)
			{
				// Nouvelles qu�te
				if($tempQuest != $step['idquete'])
					$tempQuest = showNewQuest($tempQuest,$step['idquete'],$step['etape'],$char);	
				
				$onclick="HTTPTargetCall('page.php?category=quetes&action=show_step&idstep=".$step['id']."','quete_container');";
				echo '<div style="margin-left:25px;cursor:pointer;color:grey;" onclick="'.$onclick.'"> - ';
					echo $step['text'];
				echo '</div>';
			}
			echo '</div></div>';
		}else{
			echo ' -> Vous n\'avez d&eacute;marr&eacute; encore aucune qu&ecirc;te';
		}
		
			
		echo '</div>';
	echo '</td>';


//---------- s�parateur --------------
	echo '<td class="coteig">';
	
	echo '</td>'; 


// Affichage dans le parchemin
	echo '<td style="text-align:center;vertical-align:text-top;">';
		echo '<div style="text-align:center;margin-top:10px;">';
// Haut du parchemin			
			echo '<div style="height:50px;background-image:url(pictures/parcheminhaut.gif);width:400px;text-align:center;margin-left:15px;"></div>';

// Div qui contiendra les infos de l'�tape / qu�te s�l�ctionn�e			
			echo '<div id="quete_container" style="min-height:450px;background-image:url(pictures/parcheminmilieu.gif);width:400px;text-align:center;margin-left:15px;">';

			echo '</div>';
// Bas du parchemin
			echo '<div style="height:75px;background-image:url(pictures/parcheminbas.gif);width:400px;text-align:center;margin-left:15px;"></div>';
		echo '</div>';
	echo '</td>';
	
	
	
	echo '</tr>';
echo '</table>';
echo '</div>';
?>
