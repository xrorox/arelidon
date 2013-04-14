<?php
/*
 * Created on 9 déc. 2009
 *
 */

 if($step <= 0)
 	$step = $_GET['stepid'];
 	
 if($div == '')
 	$div = $_GET['div'];
 
echo '<div id="'.$div.'">';
 
	$actiontype = $_GET['actiontype'];
	 if($actiontype < 1)
		$actiontype = 1;
	 	
	 	
	if($actiontype <= 1)
		$a1 = 'selected=selected';
	elseif($actiontype == 2)
		$a2 = 'selected=selected';
	elseif($actiontype == 3)
		$a3 = 'selected=selected';	
		
	echo 'Type : <select name="'.$div.'_'.$step.'" onchange="loadStepAction(this.value,'.$step.',\''.$div.'\');">';
		echo '<option value="1" '.$a1.'> Afficher un obstacle</option>';
		echo '<option value="2" '.$a2.'> D&eacute;placer un obstacle </option>';
		echo '<option value="3" '.$a3.'> Supprimer un obstacle</option>';
	echo '</select>';	
		
		
	/*
	 *  Case 1 : Afficher un obstacle
	 *  Case 2 : Deplacer un obstacle
	 *  Case 3 : Cacher un obstacle
	 */	
		 
	switch($actiontype)
	{	
		case '1':
			echo '<div> obstacle : ';
				$array = getAutocomplete('obstacle');
				echo ' <input id="'.$div.'_ob_'.$step.'" type="text" size="25" value="'.$value.'" name="'.$div.'_ob_'.$step.'" onfocus="autoComplete(\''.$div.'_ob_'.$step.'\',\''.$array.'\');autoComplete(\''.$div.'_ob_'.$step.'\',\''.$array.'\');" />' ;
			echo '</div>';
		break;
		
		case '2':
			echo '<div> obstacle : ';
				$array = getAutocomplete('obstacle');
				echo ' <input id="'.$div.'_ob_'.$step.'" type="text" value="'.$value.'" size="25" name="'.$div.'_ob_'.$step.'" onfocus="autoComplete(\''.$div.'_ob_'.$step.'\',\''.$array.'\');autoComplete(\''.$div.'_ob_'.$step.'\',\''.$array.'\');" />' ;
			echo '</div>';
			echo '<div>';
				
			echo '</div>';
		break;
		
		case '3':
			echo '<div> obstacle : ';
				$array = getAutocomplete('obstacle');
				echo ' <input id="'.$div.'_ob_'.$step.'" type="text" size="25" value="'.$value.'" name="'.$div.'_ob_'.$step.'" onfocus="autoComplete(\''.$div.'_ob_'.$step.'\',\''.$array.'\');autoComplete(\''.$div.'_ob_'.$step.'\',\''.$array.'\');" />' ;
			echo '</div>';
		break;
	}

echo '</div>';
?>
