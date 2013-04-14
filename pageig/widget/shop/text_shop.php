<?php
/*
 * Created on 26 oct. 2009
 *


 */

require_once('../../require.php'); 
$action = $_GET['action'];
$pnj_id = $_GET['pnj'];
$pnj = new pnj($pnj_id);
$item = new item($_GET['item_id']);


if($action == 'buy')
{
	if($char->getGold() >= $item->price)
		$color = "green";
	else
		$color = "red";
	
	echo '<span style="font-weight:500">';
	
	echo 'Je peux te vendre cet article : ' .
			'<div style="margin-left:30px;"><span style="font-weight:700">'.$item->name.'</span>';
		echo ' <img src="pictures/item/'.$item->item.'.gif" alt="'.$item->name.'" />';
		echo '( niveau : '.$item->getLevel().')';
	echo '</div><br /> <br /> &nbsp;&nbsp; Pour le prix de <span style="color:'.$color.';font-weight:700">'.$item->getPrice("achat").'</span> <img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="or" /> l\'unit&eacute;';
	
	echo '<br /><br /><br /> Combien en veux tu ? <input id="qte" type="text" value="1" size="5" /> ';
		$onclick = "buyItem('$item->item','$pnj->id');";
		echo '<input type="button" onclick="'.$onclick.';refreshInfos();" value="Acheter" />';
	echo '</span>';	
}

if($action == 'sell')
{
	$number_sell = $item->charGetItemNumber($char->getId());
	
	echo '<span style="font-weight:500">';
	
	echo 'Je peux te racheter <b>'.$number_sell.'</b> fois cet article : <br />' .
			'<div style="margin-left:30px;"><span style="font-weight:700">'.$item->name.'</span>';
		echo ' <img src="pictures/item/'.$item->item.'.gif" alt="'.$item->name.'" />';
		echo '( niveau : '.$item->getLevel().')';
	
	echo '</div><br /> <br /> &nbsp;&nbsp; Pour le prix de <span style="color:'.$color.';font-weight:700">'.$item->getPrice("vente").'</span> <img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="or" /> l\'unit&eacute;';
	
	echo '<br /><br /><br /> Combien veut tu en vendre ? <input id="qte" type="text" value="'.$number_sell.'" size="5" /> ';
		$onclick = "sellItem('$item->item','$pnj->id');";
		echo '<input type="button" onclick="'.$onclick.'refreshInfos();" value="Vendre" />';
	echo '</span>';	
}


?>
