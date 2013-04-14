<?php
/*
 * Created on 8 nov. 2009
 *
 * Voir , ajouter , supprime un drop
 */
 
 
$monster = new monster($_GET['monster_id'],'type');

$do = $_GET['do'];
switch($do)
{
	case 'add':
		$name = UTF8_decode($_POST['name']);
		$monster->addDrop($name,$_POST['pourcent']);
	break;
	case 'delete':
		$monster->deleteDrop($_GET['item_id']);
	break;
}


echo ' <fieldset style="width:400px;"><legend> Nom : '.$monster->getName().' </legend>';

	echo '<div style="padding-left:15px;"> Liste des drops </div>';
	
	echo '<div style="min-height:50px;margin-top:8px;">';
		echo '<table>';
		$drops_list = $monster->getDrops();
		foreach($drops_list as $drop)
		{
			$item = new item($drop['item']);
			echo '<tr style="height:30px;">';
				echo '<td style="float:left;margin-left:10px;"><img src="pictures/item/'.$item->item.'.gif" /> </td>';
				echo '<td style="float:left;margin-top:3px;margin-left:30px;width:250px;">'.$item->name.'</td>';
				echo '<td style="float:left;margin-top:3px;">'.$drop['pourcent'].' %</td>';
				echo ' <td style="float:right;margin-top:3px;margin-left:5px;">';
					$url = "gestion/page.php?category=7&action=edit&monster_id=".$monster->idmstr."&do=delete&item_id=".$item->item;
					$onclick = "if(confirm('Supprimer ce drop ?')){HTTPTargetCall('$url','monster_drop_container');}";
					echo '<img src="pictures/utils/no.gif" style="vertical-align:text-center;" title="supprimer le drop" onclick="'.$onclick.'" />';
				echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
	echo '</div>';
	
	$array = getAutocomplete('item');
	echo '<form id="add_drop" method="post"> <input id="input_item_drop" autocomplete=off type="text" onfocus="autoComplete(\'input_item_drop\',\''.$array.'\');" name="name" /> ';
	echo '<input type="text" name="pourcent" size="2" value="" /><b>%</b> ';
		$url = "gestion/page.php?category=7&action=edit&monster_id=".$monster->idmstr."&do=add";
		$onclick = "HTTPPostCall('$url','add_drop','monster_drop_container');";
	echo '<input type="button" class="button" value="Ajouter ce drop" onclick="'.$onclick.'" />';
	echo '</form>';
echo '</legend>';
 
 
?>
