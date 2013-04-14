<?php

$target = "mapGestion";

if($arrayWP[$case]['changemap'] == 0){
	
	$action_id = action::getRessourceOnCase($map->id,$abs,$ord);
	
	
	// On signale si un monstre est la pour pas géner le placement de la ressource
	$id_mstr = map::getMonsterOnCase($map->id,$abs,$ord);
	if($id_mstr > 0)
	{
		$return_array = getMarginWitdhHeightByTaille(0,$abs,$ord);
		$persoMarginLeft = $return_array['marginLeft'];
		$persoMarginTop = $return_array['marginTop'];
		$width=$return_array['width'];
		$height=$return_array['height'];
		echo '<div onclick="" ' .
				'style="position:absolute;float:left;margin-left:'.$persoMarginLeft.'px;margin-top:'.$persoMarginTop.'px;background-image:url(pictures/utils/delete.png);height:'.$height.'px;width:'.$width.'px;background-repeat:no repeat;cursor:pointer;z-index:'.$compte.';">' .
				'' .
				'</div>';
	}
	
	$action = new action($action_id);
	$ressource_id = $action->getObjetId();
	
	if($ressource_id >= 1)
	{
		$item = new item($ressource_id);
		$return_array = getMarginWitdhHeightByTaille(0,$abs,$ord);
		$persoMarginLeft = $return_array['marginLeft'];
		$persoMarginTop = $return_array['marginTop'];
		$width=$return_array['width'];
		$height=$return_array['height'];
		echo '<div onclick="delRessourceOnMap(\''.$map->id.'\',\''.$abs.'\',\''.$ord.'\');" ' .
				'style="position:absolute;float:left;margin-left:'.$persoMarginLeft.'px;margin-top:'.$persoMarginTop.'px;background-image:url(pictures/item/'.$item->getItem().'.gif);height:'.$height.'px;width:'.$width.'px;background-repeat:no repeat;cursor:pointer;z-index:'.$compte.';"></div>';	
	}else{
		$return_array = getMarginWitdhHeightByTaille(1,$abs,$ord);
		$persoMarginLeft = $return_array['marginLeft'];
		$persoMarginTop = $return_array['marginTop'];
		$width=$return_array['width'];
		$height=$return_array['height'];
		echo '<div onclick="addRessourceOnMap(\''.$map->id.'\',\''.$abs.'\',\''.$ord.'\');" ' .
				'style="position:absolute;' .
				'float:left;' .
				'margin-left:'.$persoMarginLeft.'px;' .
				'margin-top:'.$persoMarginTop.'px;' .
				'height:'.$height.'px;' .
				'width:'.$width.'px;' .
				'background-repeat:no repeat;cursor:pointer;z-index:'.$compte.';"></div>';
	}

}else{ // fin si changemap = 0 
		
	$url = "map=".$arrayWP[$case]['changemap']."&type_gestion=ressources";
	$onclick = 'changeMapWithTelep(\''.$url.'\');';
	
	$type = $arrayWP[$case]['type'];
	if($type == 0)
		$type = 1;

	$return_array = getMarginWitdhHeightByTaille(0,$abs,$ord);
	$persoMarginLeft = $return_array['marginLeft'];
	$persoMarginTop = $return_array['marginTop'];
	$width=$return_array['width'];
	$height=$return_array['height'];

	echo '<div onclick="'.$onclick.'" ' .
			'style="position:absolute;float:left;' .
			'margin-left:'.$persoMarginLeft.'px;' .
			'margin-top:'.$persoMarginTop.'px;' .
			'background-image:url(pictures/telep/'.$type.'.png);' .
			'height:'.$height.'px;' .
			'width:'.$width.'px;' .
			'background-repeat:no repeat;' .
			'cursor:pointer;' .
			'z-index:'.$compte.';">' .
		'</div>';
} 

// On incrémente compte qui correspond à la profondeur (du calque)
$compte++;

 ?>


