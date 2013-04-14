<?php
require_once(absolutePathway().'class/action.class.php');
$sql = "SELECT action_id FROM `metier_ressource` WHERE id = ".$_GET['id'];
$action_id = loadSqlResult($sql);

$action = new action($action_id);

$item = new item($action->getObjetId());

$recolte = $_GET['recolte'];


if($recolte != 1)
{
	echo '<div class="boutonItem" style="margin-top:5px;height:30px;width:90%;border:solid 1px black;color:black;">';
		echo '<img src="pictures/item/'.$item->item.'.gif" alt="Objet" title="'.$item->name.'" style="margin-left:5px;margin-right:5px;" /> ';
		echo $item->name;
		echo '<div style="float:right;margin-right:5px;margin-top:2px;">';
			$url = "include/menuig.php?refresh=1&mode=action&recolte=1&id=".$_GET['id'];
			$onclick = "HTTPTargetCall('$url','menuig');refreshInfos();";
			echo '<img src="pictures/utils/pp.png" alt="R&eacute;colter" title="'.$action->getName().'" style="cursor:pointer;" onclick="'.$onclick.';refreshMap();" />';
		echo '</div>';
	echo '</div>';	
}else{
	// Vérification si on a assez de PP
	
	if($char->getPP() >= 1)
	{
		if($action->getToolEquiped($char))
		{
			$item = new item($action->getObjetId());
			if($action->verifDistance($_GET['id'],$char)){
				$action->doRecolte($_GET['id'],$char);
				
				$sql="SELECT level FROM `metier_char` WHERE metier_id=".$action->getMetierId()." && char_id=".$char->getId();
				$pp=loadSqlResult($sql);
				$pp=$pp * -0.2;
				$pp= floor($pp);
				
				$char->updateMore('pp',$pp);
				echo 'Vous venez de r&eacute;colter : '.$item->getName();
			}
			else{
				echo 'Vous &ecirc;tes trop loin !!';
			}
		}else{
			$txt = 'Vous n\'avez pas &eacute;quip&eacute; l\'outil pour ramasser cet objet';
			echo $txt;
		}
		
	}else{
		echo 'Vous n\'avez plus assez de point profession';
	}
}

	
		
	

?>
