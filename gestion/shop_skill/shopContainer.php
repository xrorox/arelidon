<?php
/*
 * Created on 20 oct. 2009
 *


 */
 require_once($server.'class/shop_skill.class.php');
if($shop->id == 0)
	$shop = new shop_skill($_GET['id']); 

if($_GET['add'] == 1)
{
	$error = $shop->addItem($_GET['item_id']);
	if($error == 'error')
		echo 'Cet objet a d&eacute;j&agrave; &eacute;t&eacute; ins&eacute;r&eacute;';	
}

if($_GET['del'] == 1)
	$shop->removeItem($_GET['item_id']);


$shop->loadItemCollection(); 

$url = "gestion/page.php?category=29&action=shopContainer&reload=1&del=1";

$str .= '<table style="width:100%">';
	foreach($shop->getItemCollection() as $skill_id)
	{
		
		$skill = new skill($skill_id);

		$str .= '<tr>';
// Image de l'objet			
			$str .= '<td>';
				$str .= '<img src="pictures/skill/'.$skill->getId().'.gif" alt="image '.$skill->getId().'.gif absente !" />';
			$str .= '</td>';
			
			$str .= '<td>';
				$str .= $skill->name;
			$str .= '</td>';
// Prix de l'objet
			$str .= '<td style="width:50px;">';	
				$str .= $skill->price;
				$str .= '<img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="pi&egrave;ce d\'or" />';
			$str .= '</td>';
// Bouton supprimer
			$str .= '<td style="width:50px;">';
				
				$url_onclick = $url."&item_id=".$skill->getId();
				$url_onclick .= "&id=".$shop->id;
				$target = "shop_container";
				$onclick = "HTTPTargetCall('$url_onclick','$target');";
				$str .= '<img src="pictures/utils/delete.gif" alt="" onclick="'.$onclick.'" />';
			$str .= '</td>';	
		$str .= '</tr>';
	}
$str .= '</table>';

if($_GET['reload'] == 1)
	echo $str;
else
	$content .= $str;

?>
