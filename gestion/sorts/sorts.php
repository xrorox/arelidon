<?php


require_once('../require.php');
require_once(absolutePathway().'class/classe.class.php');
$skill=new skill();
echo '<th> <input type="button" value="ajouter" onclick="HTTPTargetCall(\'gestion/sorts/ajoutersorts.php\',\'ajouter\')"/> </th>';
echo '<div id="modifier">';


echo '<div id="supprimer"> </div>';
echo '<div id="ajouter"> </div>';
echo '<table border="1" class="backgroundBodyNoRadius" cellspacing="0" style="border:solid 1px black;text-align:center;width:100%;">';
echo '<tr class="backgroundMenuNoRadius">';
 	echo '<th> id du sort</th>';
 	echo '<th> Nom</th>';
 	echo '<th> Description</th>';
 	echo '<th> Prix</th>';
 	echo '<th> Niveau requis</th>';
 	echo '<th> Classe requise</th>';
 	echo '<th> Type de sort</th>';
 	echo '<th> dommages</th>';
 	echo '<th> pl_dommages</th>';
 	echo '<th> type dommage</th>';
 	echo '<th> portée minimale</th>';
 	echo '<th> portée maximale</th>';
 	echo '<th> str</th>';
 	echo '<th> pl_str</th>';
 	echo '<th> Con</th>';
 	echo '<th> pl_con</th>';
 	echo '<th> dex</th>';
 	echo '<th> pl_dex</th>';
 	echo '<th> int</th>';
 	echo '<th> pl_inr</th>';
 	echo '<th> sag</th>';
 	echo '<th> pl_sag</th>';
 	echo '<th> res</th>';
 	echo '<th> pl_res</th>';
 	echo '<th> mana</th>';
 	echo '<th> pl_mana</th>';
 	echo '<th> pourcent_effect</th>';
 	echo '<th> pl_effect_pourcent</th>';
 	echo '<th> effect_id</th>';
 	echo '<th> effet_cible</th>';
 	echo '<th> usable_on_himself</th>';
 	echo '<th> usable_on_ally</th>';
 	echo '<th> Modifier </th>';
 	echo '<th> Supprimer </th>';
echo '</tr>';

$arrayofarray = $skill->getSkillInfo();

foreach($arrayofarray as $array){

echo '<tr>';
	echo '<th>'.$array['id'].'</th>';
	echo '<th>'.$array['name'].'</th>';
	echo '<th>'.$array['description'].'</th>';
	echo '<th>'.$array['price'].'</th>';
	echo '<th>'.$array['lvlreq'].'</th>';
	echo '<th>'.classe::GetClasseNameById($array['classe_req']).'</th>';
	echo '<th>'.$array['typesort'].'</th>';
	echo '<th>'.$array['dmg'].'</th>';
	echo '<th>'.$array['pl_dmg'].'</th>';
	echo '<th>'.$array['typedmg'].'</th>';
	echo '<th>'.$array['range_min'].'</th>';
	echo '<th>'.$array['range_max'].'</th>';
	echo '<th>'.$array['str'].'</th>';
	echo '<th>'.$array['pl_str'].'</th>';
	echo '<th>'.$array['con'].'</th>';
	echo '<th>'.$array['pl_con'].'</th>';
	echo '<th>'.$array['dex'].'</th>';
	echo '<th>'.$array['pl_dex'].'</th>';
	echo '<th>'.$array['int'].'</th>';
	echo '<th>'.$array['pl_int'].'</th>';
	echo '<th>'.$array['sag'].'</th>';
	echo '<th>'.$array['pl_sag'].'</th>';
	echo '<th>'.$array['res'].'</th>';
	echo '<th>'.$array['pl_res'].'</th>';
	echo '<th>'.$array['mana'].'</th>';
	echo '<th>'.$array['pl_mana'].'</th>';
	echo '<th>'.$array['pourcent_effect'].'</th>';
	echo '<th>'.$array['pl_effect_pourcent'].'</th>';
	echo '<th>'.$array['effect_id'].'</th>';
	echo '<th>'.$array['effect_cible'].'</th>';
	echo '<th>'.$array['usable_on_himself'].'</th>';
	echo '<th>'.$array['usable_on_ally'].'</th>';
	echo '<th> <input type="button" value="modifier" onclick="HTTPTargetCall(\'gestion/sorts/modifiersorts.php?id='.$array['id'].'\',\'modifier\')"/> </th>';
	echo '<th> <input type="button" value="supprimer" onclick="HTTPTargetCall(\'gestion/sorts/supprimersorts.php?id='.$array['id'].'\',\'supprimer\')"/> </th>';
}

 




?>
