<?php
/*
 * Created on 25 nov. 2009
 *


 */
 
$char2 = new char($_GET['target_id']);

if(verifDistance2Char($char,$char2,true) && $char->getId() != $char2->getId())
{
	$temp_abs = $char->getAbs();
	$temp_ord = $char->getOrd();
	
	$char->update('abs',$char2->getAbs());
	$char->update('ord',$char2->getOrd());
	
	$char2->update('abs',$temp_abs);
	$char2->update('ord',$temp_ord);
}

?>
