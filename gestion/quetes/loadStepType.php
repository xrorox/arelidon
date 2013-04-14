<?php
/*
 * Created on 24 sept. 2009
 *
 */


if($stepid < 1)
	 $stepid = $_GET['stepid'];
	 
if($steptype < 1)
	 $steptype = $_GET['steptype'];
	
	
/*
 *  Case 1 : tuer un ou plusieurs monstres
 *  Case 2 : parler à un PNJ
 *  Case 3 : ramener un ou plusieurs objets
 *  Case 4 : allez sur une certaines carte
 */	
	 
switch($steptype)
{	
	case '1':
			$array = getAutocomplete('monster');
			if($modif)
			{
				$indice = 0;
				$need_array = $step_object->getNeed();
				
				foreach($need_array as $need_value)
				{
					$monster = new monster($need_value['id_need'],'infoType');
					$value = $monster->getName();
					echo '<div> nombre : ';
					echo '<input type="text" size="3" name="nb_need_'.$stepid.'[]" value="'.$need_value['nb_need'].'" />';
			
					echo ' <input id="id_need_'.$stepid.'_'.$indice.'" name="id_need_'.$stepid.'[]" type="text" size="25" value="'.$value.'" onfocus="autoComplete(\'id_need_'.$stepid.'_'.$indice.'\',\''.$array.'\');" />' ;
					echo '</div>';
					$indice++;
				}
				
				for($indice=$indice;$indice<5;$indice++)
				{
					echo '<div> nombre : ';
					echo '<input type="text" size="3" name="nb_need_'.$stepid.'[]" value="" />';
			
					echo ' <input id="id_need_'.$stepid.'_'.$indice.'" name="id_need_'.$stepid.'[]" type="text" size="25" value="" onfocus="autoComplete(\'id_need_'.$stepid.'_'.$indice.'\',\''.$array.'\');" />' ;
					echo '</div>';
				}
				
			}else{
				for($indice=0;$indice<5;$indice++)
				{
					echo '<div> nombre : ';
					echo '<input type="text" size="3" name="nb_need_'.$stepid.'[]" value="" />';
			
					echo ' <input id="id_need_'.$stepid.'_'.$indice.'" name="id_need_'.$stepid.'[]" type="text" size="25" value="" onfocus="autoComplete(\'id_need_'.$stepid.'_'.$indice.'\',\''.$array.'\');" />' ;
					echo '</div>';
				}
			}			

		
	break;
	
	case '2':
		echo '<div> PNJ : ';
			if($modif)
			{
				$need_array = $step_object->getNeed();
				
				foreach($need_array as $value)
				{
					$pnj = new pnj($value['id_need']);
					$value = $pnj->name;
					$value_text = $step_object->text_pnj_quest;
				}
				
			}else{
				$value_text = "Texte lorsque le joueur parlera au pnj";
			}
			$array = getAutocomplete('pnj');
			echo ' <input id="id_need_'.$stepid.'" type="text" value="'.$value.'" size="25" name="id_need_'.$stepid.'[]" onfocus="autoComplete(\'id_need_'.$stepid.'\',\''.$array.'\');autoComplete(\'id_need_'.$stepid.'\',\''.$array.'\');" />' ;
			echo '<TEXTAREA id="text_pnj_quest_'.$stepid.'" name="text_pnj_quest_'.$stepid.'" size="40" rows="3">'.$value_text.'</TEXTAREA>';
		echo '</div>';
	break;
	
	case '3':
			$array = getAutocomplete('item');
			if($modif)
			{
				$indice = 0;
				$need_array = $step_object->getNeed();
				foreach($need_array as $need_value)
				{
					$item = new item($need_value['id_need']);
					$value = $item->name;
					echo '<div> nombre : ';
					echo '<input type="text" size="3" name="nb_need_'.$stepid.'[]" value="'.$need_value['nb_need'].'" />';
			
					echo ' <input id="id_need_'.$stepid.'_'.$indice.'" name="id_need_'.$stepid.'[]" type="text" size="25" value="'.$value.'" onfocus="autoComplete(\'id_need_'.$stepid.'_'.$indice.'\',\''.$array.'\');" />' ;
					echo '</div>';
					$indice++;
				}
				
				for($indice=$indice;$indice<5;$indice++)
				{
					echo '<div> nombre : ';
					echo '<input type="text" size="3" name="nb_need_'.$stepid.'[]" value="" />';
			
					echo ' <input id="id_need_'.$stepid.'_'.$indice.'" name="id_need_'.$stepid.'[]" type="text" size="25" value="" onfocus="autoComplete(\'id_need_'.$stepid.'_'.$indice.'\',\''.$array.'\');" />' ;
					echo '</div>';
				}
				
			}else{
				for($indice=0;$indice<5;$indice++)
				{
					echo '<div> nombre : ';
					echo '<input type="text" size="3" name="nb_need_'.$stepid.'[]" value="" />';
			
					echo ' <input id="id_need_'.$stepid.'_'.$indice.'" name="id_need_'.$stepid.'[]" type="text" size="25" value="" onfocus="autoComplete(\'id_need_'.$stepid.'_'.$indice.'\',\''.$array.'\');" />' ;
					echo '</div>';
				}
			}	
	break;
}
?>
