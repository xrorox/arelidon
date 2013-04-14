<h3> Magasin </h3>

<table class="backgroundBody" style="width:800px;">
	<tr class="backgroundMenu">
		<td> Nom </td>
		<td> Prix </td>
		<td>level</td>
		<td>Classe</td>
		<td>Acheter</td>
	</tr>
	<?php
	require_once($server.'class/shoppoint.class.php');
		$shop=new shop_point();
		$arrayofarray=$shop->GetItemCollection();
		
		foreach($arrayofarray as $array){
			$item=new item($array['id']);
			echo '<tr>';
				echo '<td>'.$item->getPicture(true).'</td>';
				echo '<td>'.$array['price'].' points</td>';
				echo '<td>'.$array['level'].'</td>';
				echo '<td>'.classe::GetClasseNameById($array['classe']).'</td>';
				$onclick="HTTPTargetCall('ingame.php?page=allopass&sub_page=usePoints&sub_sub_page=magasin&confirm=1&item=".$array['id']."','subbody');";
				echo '<td> <input type="button" class="button" value="confirmer" onclick="'.$onclick.'" /> </td>';
			echo'</tr>';
			
		}
	
	?>
</table>