<?php
/*
 * Created on 30 mai 2010
 */
 
 
if($_GET['valid'] == 1)
{
	$char_id = char::getIdByName($_POST['name']);
	$char_object = new char($char_id);
	
	$item_id = item::getIdByName($_POST['item']);
	$item = new item($item_id);
	
	$item->addItemToChar($char_object->getId(),$_POST['nb']);
	
	printConfirm($_POST['nb']." ".$_POST['item']." ajout&eacute; &agrave; ".$_POST['name'],false,"white");
	
}

echo '<br /><br />';

echo '<form id="form_add_object" method="POST">';

	echo 'Nom du joueur : ';
		$array = getAutocomplete('chars');
		echo '<input id="input_char" type="text" name="name" value="'.$_POST['name'].'" autocomplete=off onfocus="autoComplete(\'input_char\',\''.$array.'\');" /> <br />';
		
	echo '<input type="text" name="nb" size="5" value="nb" />';
	
	$array = getAutocomplete('item');
	echo '<input id="input_item" autocomplete=off type="text" onfocus="autoComplete(\'input_item\',\''.$array.'\');" name="item" /> ';

	$onclick = "HTTPPostCall('gestion/page.php?category=33&valid=1','form_add_object','tdbodygame');";
	echo '<input type="button" class="button" onclick="'.$onclick.'" value="Ajouter" />';
echo '</form>';
 
?>
