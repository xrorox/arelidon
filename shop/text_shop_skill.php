<?php
/*
 * Created on 26 oct. 2009
 *


 */

require_once('../../require.php'); 
require_once($server.'class/shop_skill.class.php');
$action = $_GET['action'];
$pnj_id = $_GET['pnj'];
$pnj = new pnj($pnj_id);
$skill = new skill($_GET['skill_id']);


if($action == 'buy')
{
	if($char->gold >= $skill->price)
		$color = "green";
	else
		$color = "red";
	
	echo '<span style="font-weight:500">';
	
	echo 'Je peux te vendre cet article : <span style="font-weight:700">'.$skill->name.'</span>';
		echo ' <img src="pictures/skill/'.$skill->getId().'.gif" alt="'.$skill->name.'" />';
	
	echo '<br /> <br /> &nbsp;&nbsp; Pour le prix de <span style="color:'.$color.';font-weight:700">'.$skill->price.'</span> <img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="or" /> l\'unit&eacute;';
	
	echo '<br /><br /><br /> Combien en veux tu ? <input id="qte" type="text" value="1" size="5" /> ';
		$onclick = "buySkill('".$skill->getId()."','$pnj->id');";
		echo '<input type="button" onclick="'.$onclick.';refreshInfos();" value="Acheter" />';
	echo '</span>';	
}



?>
