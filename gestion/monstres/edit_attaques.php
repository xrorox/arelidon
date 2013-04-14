<?php
/*
 * Created on 13 déc. 2009
 *
 */

$monster = new monster($_GET['monster_id'],'type');

$do = $_GET['do'];
switch($do)
{
	case 'add':
		$name = UTF8_decode($_POST['name']);
		$monster->addSkill($name,$_POST['level'],$_POST['rate']);
	break;
	case 'delete':
		$monster->deleteSkill($_GET['skill_id']);
	break;
}


echo ' <fieldset style="width:400px;"><legend> Nom : '.$monster->getName().' </legend>';

	echo '<div style="padding-left:15px;"> Liste des attaques </div>';
	
	echo '<div style="min-height:50px;margin-top:8px;">';
		echo '<table>';
		$skills_list = $monster->getSkills();
		foreach($skills_list as $skill)
		{
			$skill = new skill($skill['skill_id']);
			echo '<tr style="height:30px;">';
				echo '<td style="float:left;margin-left:10px;"><img src="pictures/skill/'.$skill->getId().'.gif" /> </td>';
				echo '<td style="float:left;margin-top:3px;margin-left:30px;width:250px;">'.$skill->getName().'</td>';
				echo ' <td style="float:right;margin-top:3px;margin-left:5px;">';
					$url = "gestion/page.php?category=31&action=edit&monster_id=".$monster->idmstr."&do=delete&skill_id=".$skill->getId();
					$onclick = "if(confirm('Supprimer ce sort ?')){HTTPTargetCall('$url','monster_skill_container');}";
					echo '<img src="pictures/utils/no.gif" style="vertical-align:text-center;" title="supprimer le drop" onclick="'.$onclick.'" />';
				echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
	echo '</div>';
	
	$array = getAutocomplete('skill');
	echo '<form id="add_drop" method="post"> <input id="input_skill" type="text" onfocus="autoComplete(\'input_skill\',\''.$array.'\');" name="name" autocomplete="off" /> ';
	echo '<input type="text" name="level" size="2" value="niv" /> <input type="text" name="rate" size="2" value="100" /><b>%</b> ';
		$url = "gestion/page.php?category=31&action=edit&monster_id=".$monster->idmstr."&do=add";
		$onclick = "HTTPPostCall('$url','add_drop','monster_skill_container');";
	echo '<input type="button" class="button" value="Ajouter cette attaque" onclick="'.$onclick.'" />';
	echo '</form>';
echo '</legend>';
?>
