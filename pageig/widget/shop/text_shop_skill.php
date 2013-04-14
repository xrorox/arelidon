<?php
/*
 * Created on 26 oct. 2009
 *


 */

require_once('../../require.php'); 
$action = $_GET['action'];
$pnj_id = $_GET['pnj'];
$pnj = new pnj($pnj_id);
$skill = new skill($_GET['skill_id']);


if($action == 'buy')
{
	if($char->getGold() >= $skill->price)
		$color = "green";
	else
		$color = "red";
	
	echo '<span style="font-weight:500">';
	
	echo 'Je peux te vendre cet article : <br />'.
		 '<div style="margin-left:30px;"><span style="font-weight:700;"><font style="font-family:New Roman;font-size:17px;">'.$skill->getName().'</font></span>';
		echo ' <img src="pictures/skill/'.$skill->getId().'.gif" alt="'.$skill->getName().'" />';
		echo ' (';
			echo  classe::GetClasseNameById($skill->getClasse_req());	
		echo ' niv : '.$skill->getLevelReq().')';
		
	echo '<br /> <br /></div> &nbsp;&nbsp; Pour le prix de <span style="color:'.$color.';font-weight:700">'.$skill->price.'</span> <img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="or" /> l\'unit&eacute;';
	
	echo ' ';
		$onclick = "buySkill('".$skill->getId()."','$pnj->id');";
		echo '<input type="button" onclick="'.$onclick.';refreshInfos();" value="Acheter" />';
	echo '</span>';	
}



?>
