<?php

$target = "mapGestion";
if($arrayWP[$case]['changemap'] == 0){
	
	$id_mstr = map::getMonsterOnCase($map->id,$abs,$ord);
	
	if($id_mstr >= 1)
	{
		$monster = new monster($id_mstr,'');
		$return_array = getMarginWitdhHeightByTaille($monster->getTaille(),$abs,$ord);
		$persoMarginLeft = $return_array['marginLeft'];
		$persoMarginTop = $return_array['marginTop'];
		$width=$return_array['width'];
		$height=$return_array['height'];
		echo '<div onclick="delMonsterOnMap(\''.$map->id.'\',\''.$abs.'\',\''.$ord.'\');" style="position:absolute;float:left;margin-left:'.$persoMarginLeft.'px;margin-top:'.$persoMarginTop.'px;background-image:url(pictures/monster/'.$monster->getIdMstr().'.gif);height:'.$height.'px;width:'.$width.'px;background-repeat:no repeat;cursor:pointer;z-index:'.$compte.';"></div>';	
	}else{
		$return_array = getMarginWitdhHeightByTaille(1,$abs,$ord);
		$persoMarginLeft = $return_array['marginLeft'];
		$persoMarginTop = $return_array['marginTop'];
		$width=$return_array['width'];
		$height=$return_array['height'];
		echo '<div onclick="addMonsterOnMap(\''.$map->id.'\',\''.$abs.'\',\''.$ord.'\');" ' .
				'style="position:absolute;' .
				'float:left;' .
				'margin-left:'.$persoMarginLeft.'px;' .
				'margin-top:'.$persoMarginTop.'px;' .
				'height:'.$height.'px;' .
				'width:'.$width.'px;' .
				'background-repeat:no repeat;cursor:pointer;z-index:'.$compte.';"></div>';
	}

}else{ // fin si changemap = 0 
		
	$url = "map=".$arrayWP[$case]['changemap']."&type_gestion=cases_monsters";
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

