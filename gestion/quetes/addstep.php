<?php
/*
 * Created on 23 sept. 2009
 *
 */
 
if($modif) 
{
	$step = $step + 1;
	$step_object = new step($step_modif_id['id']);	
	$pnj = pnj::getNameById($step_object->pnj);
	$pnj_valid = pnj::getNameById($step_object->pnj_valid);
} 
else 
	$step = $_GET['step'] +1; 

echo '<div id="divStep_'.$step.'_container" class="backgroundBody" style="text-align:center;margin-left:0px;border:solid 1px white;width:370px;">';
	
	echo '<div class="backgroundMenu" style="text-align:left;border-bottom:solid 1px white;color:black;" onclick="show(\'divStep_'.$step.'\')">';
				echo '<div style="float:left;margin:1px;"><img src="pictures/iconesbonus/star_yellow.png" alt="" /></div>';
		echo '<a class="unclickable" style="margin-left:10px;">Etape '.$step.'</a>';
	echo '</div>';
	
	echo '<div id="divStep_'.$step.'" style="text-align:left;margin-left:10px;text-align:right;margin-right:30px;margin-top:7px;">';	
			echo 'Nom de l\'&eacute;tape : <input type="text" name="name_'.$step.'" size="40" value="'.$step_object->name.'" /><br />';
			echo '<hr />';
			
			// Conditions
			echo '<div style="margin-left:20px;font-weight:700;text-decoration:underline;text-align:left;" onclick="show(\'condition_'.$step.'\')" class="unclickable"> Condition </div>';
			
			echo '<div id="condition_'.$step.'" style="display:none;margin-right:60px;">';
				echo '<input type="hidden" id="step_id_'.$step.'" value="'.$step.'" />';
				echo '<br />Niveau minimum : ';
					echo '<input id="lvlreq_'.$step.'" type="text" name="lvl_req_'.$step.'" value="'.$step_object->lvl_req.'" />';
				echo '<br />Avoir achever qu&ecirc;te : ';	
					$array = getAutocomplete('step');
					$quete_name = step::getNameById($step_object->quest_req);
					echo '<input id="acheverQuete_'.$step.'" type="text" name="quest_req_'.$step.'" value="'.$quete_name.'" onfocus="autoComplete(\'acheverQuete_'.$step.'\',\''.$array.'\');autoComplete(\'acheverQuete_'.$step.'\',\''.$array.'\');" />';	
				echo '<br />Avoir un objet : ';	
					$array = getAutocomplete('item');
					$objet_name = item::getNameById($step_object->objet_req);
					echo '<input id="needObjet_'.$step.'" type="text" name="objet_req_'.$step.'" value="'.$objet_name.'" onfocus="autoComplete(\'needObjet_'.$step.'\',\''.$array.'\');autoComplete(\'acheverQuete_'.$step.'\',\''.$array.'\');" /> ';
			echo '</div><hr />';
			
			// Action après lancement
			echo '<div style="margin-left:20px;font-weight:700;text-decoration:underline;text-align:left;" onclick="show(\'action_before_'.$step.'\')" class="unclickable"> Action apr&egrave;s lancement </div>';
			
			echo '<div id="action_before_'.$step.'" style="display:none;text-align:left;margin-left:20px;">';
				$div = "action_before";
				include('loadStepAction.php');
			echo '</div>';
			
			echo '<hr />';
			
			
			// PNJ de départ
			$array = getAutocomplete('pnj'); 
			$array_pnj = $array;
			echo 'd&eacute;bute au PNJ : <input id="pnj_'.$step.'" tag="pnjStep" type="text" value="'.$pnj.'" name="pnj_'.$step.'" size="35" onfocus="autoComplete(\'pnj_'.$step.'\',\''.$array.'\');autoComplete(\'pnj_'.$step.'\',\''.$array.'\');" /><br />';
			if($modif)
				$txt = $step_object->text_pnj;
			else
				$txt = 'texte PNJ avant avoir finis l\'&eacute;tape';
			echo '<TEXTAREA id="text_pnj_'.$step.'" name="text_pnj_'.$step.'" size="40" rows="3" onclick="cleanTextPnj(this.id)">'.$txt.'</TEXTAREA><br />';
			
			echo '<hr />';
			
			// But de la quete (ce qu'il y a a faire')
			$stepid = $step;
			if($modif){
				$steptype = $step_object->type;
				$type_step_selected = array();
				$type_step_selected[$steptype] = 'selected="selected"';
			
			
			}else{
				$steptype = '1';
				$type_step_selected = array();
				$type_step_selected['1'] = 'selected="selected"';
			}
			
			echo 'Type : <select name="type_'.$step.'" onchange="loadStepType(this.value,'.$step.');">';
			echo '<option value="1" '.$type_step_selected['1'].' > Tuer un ou plusieurs monstres</option>';
			echo '<option value="2" '.$type_step_selected['2'].'> Parler &agrave; un PNJ </option>';
			echo '<option value="3" '.$type_step_selected['3'].'> Ramener un ou plusieurs objets</option>';
			echo '<option value="4" '.$type_step_selected['4'].'> Se rendre sur une carte </option>';
			echo '</select>';			
			
			echo '<div id="loadStepType_'.$step.'">';
			
			include('loadStepType.php');
			
			echo '</div>';
			
			echo '<hr />';
			
			// Action après avoir finis l'étape (avant validation)'
			echo '<div style="margin-left:20px;font-weight:700;text-decoration:underline;text-align:left;" onclick="show(\'action_after_'.$step.'\')" class="unclickable"> Action avant validation </div>';
			
			echo '<div id="action_after_'.$step.'" style="display:none;text-align:left;margin-left:20px;">';
				$div = "action_after";
				include('loadStepAction.php');
			echo '</div>';			
			
			echo '<hr />';
			
			// Valider au pnj
			echo 'valider au PNJ : <input id="pnj_valid_'.$step.'" value="'.$pnj_valid.'" tag="pnjStepValid" type="text" name="pnj_valid_'.$step.'" size="35" onfocus="autoComplete(\'pnj_valid_'.$step.'\',\''.$array_pnj.'\');autoComplete(\'pnj_valid_'.$step.'\',\''.$array_pnj.'\');" /><br />';
			if($modif)
				$txt = $step_object->text_pnj_after;
			else
				$txt = 'texte PNJ apr&egrave;s avoir finis l\'&eacute;tape';
			echo '<TEXTAREA id="text_pnj_after_'.$step.'" name="text_pnj_after_'.$step.'" size="40" rows="3" onclick="cleanTextPnjAfter(this.id)">'.$txt.'</TEXTAREA><br />';
			
			echo '<hr />';
			
			// Action après validation)'
			echo '<div style="margin-left:20px;font-weight:700;text-decoration:underline;text-align:left;" onclick="show(\'action_finish_'.$step.'\')" class="unclickable"> Action apr&egrave;s validation </div>';
			
			echo '<div id="action_finish_'.$step.'" style="display:none;text-align:left;margin-left:20px;">';
				$div = "action_finish";
				include('loadStepAction.php');
			echo '</div>';
			
			echo '<hr />';
			
			echo '<div id="gain" style="text-align:left;margin-left:0px;">';
			
			echo '<div style="margin-left:20px;font-weight:700;text-decoration:underline;" onclick="show(\'window_gain_'.$step.'\')" class="unclickable">Gain </div>';
				echo '<div id="window_gain_'.$step.'" style="margin-top:5px;display:none;">';
					// Gain or et exp
					echo '<input type="text" name="gold_win_'.$step.'" size="3" value="'.$step_object->gold_win.'" /> Pi&egrave;ce d\'or<br />';
					echo '<input type="text" name="exp_win_'.$step.'" size="3" value="'.$step_object->exp_win.'" /> Point d\'exp<br />';
					
					// Gain objet
					$array = getAutocomplete('item');
					$objet_name = item::getNameById($step_object->objet_win);
					echo '<input type="text" name="nbobjet_win_'.$step.'" size="3" value="'.$step_object->nbobjet_win.'"  /> <input type="text" id="ob_'.$step.'" name="objet_win_'.$step.'" value="'.$objet_name.'" size="25" onfocus="autoComplete(\'ob_'.$step.'\',\''.$array.'\');autoComplete(\'ob_'.$step.'\',\''.$array.'\');" /><br />';
					
					// Gain sort
					$array = getAutocomplete('skill');
					$skill_name = skill::getNameById($step_object->skill_win);
					echo 'Sort : <input type="text" id="skill_'.$step.'" name="skill_win_'.$step.'" value="'.$skill_name.'" size="25" onfocus="autoComplete(\'skill_'.$step.'\',\''.$array.'\');autoComplete(\'skill_'.$step.'\',\''.$array.'\');" /><br />';					
				echo '</div><br />';
			echo '</div>';
		
			
	$nextstep = $step + 1;
	echo '<input type="hidden" name="change_step_'.$nextstep.'" value="'.$nextstep.'" />';			
	echo '</div>';
echo '</div>';

if(!$modif)
{
	echo '<div id="addStep_'.$step.'" style="margin-top:15px;margin-left:0px;">';
		$url = "gestion/page.php?category=25&action=add&step=".$step;
		$onclick = "HTTPTargetCall('$url','addStep_".$step."')";
		echo '<a href="#" onclick="'.$onclick.'"> Ajouter une &eacute;tape </a>';
	echo '</div>';  	
} 


?>
