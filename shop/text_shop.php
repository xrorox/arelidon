<?php
/*
 * Created on 26 oct. 2009
 *


 */

require_once('../../require.php'); 
require_once($server.'class/shop.class.php');
require_once($server.'class/pnj.class.php');
require_once($server.'class/char_inv.class.php');

$pnj = new pnj($_GET['pnj']);
$item = new item($_GET['item_id']);
$char = unserialize($_SESSION['char']);


if($_GET['action'] == 'buy')
{
	if($char->getGold() >= $item->getPrice("achat"))
		$color = "green";
	else
		$color = "red";
	
	echo '<span style="font-weight:500">';
	
	echo 'Je peux te vendre cet article : <span style="font-weight:700">'.$item->getName().'</span>';
		echo ' <img src="pictures/item/'.$item->getId().'.gif" alt="'.$item->getName().'" />';
	
	echo '<br /> <br /> &nbsp;&nbsp; Pour le prix de <span style="color:'.$color.';font-weight:700">'.$item->getPrice("achat").'</span> <img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="or" /> l\'unit&eacute;';
	
	echo '<br /><br /><br /> Combien en veux tu ? <input id="qte" type="text" value="1" size="5" /> ';
		$onclick = "buyItem('".$item->getId()."','".$pnj->getId()."');";
		echo '<input type="button" onclick="'.$onclick.';refreshInfos();" value="Acheter" />';
	echo '</span>';	
}

if($_GET['action'] == 'sell')
{
        $char_inv = new char_inv($char->getId());
	$number_sell = $char_inv->getNumberItem($item);
	
	echo '<span style="font-weight:500">';
	
	echo 'Je peux te racheter <b>'.$number_sell.'</b> fois cet article : <span style="font-weight:700">'.$item->getName().'</span>';
		echo ' <img src="pictures/item/'.$item->getId().'.gif" alt="'.$item->getName().'" />';
	
	$price = $item->getPrice() ;
	echo '<br /> <br /> &nbsp;&nbsp; Pour le prix de <span style="font-weight:700">'.$price.'</span> <img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="or" /> l\'unit&eacute;';
	
	echo '<br /><br /><br /> Combien veut tu en vendre ? <input id="qte" type="text" value="'.$number_sell.'" size="5" /> ';
		$onclick = "sellItem('".$item->getId()."','".$pnj->getId()."');";
		echo '<input type="button" onclick="'.$onclick.'refreshInfos();" value="Vendre" />';
	echo '</span>';	
}


?>
