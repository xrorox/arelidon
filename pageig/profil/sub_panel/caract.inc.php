<table style="width: 250px !important;">

<?php

$caractList = getCaractList();
echo '<table>';
foreach($caractList as $caract)
{
	?>
	<tr>
		<td>
			<span id="waiter_carat" style="float:left;"></span>
			<div style="margin-left:20px;text-align:right;">
				<div class="td-info-caract-img-container" style="padding-top: 3px;margin-left:50px;">
					<?php if($caract == 'con')
					{
						echo '<img src="pictures/icones/stats/vit.gif" title="Constitution" />';
					}else{
						echo '<img src="pictures/icones/stats/'.$caract.'.gif" title="'.getCaract($caract).'" />';
					}
					?>
				</div>
			</div>
		</td>
	
	<?php
	
		echo '<td>';
		echo '<div style="width:40px;margin-left:20px;">';
			echo $char->getCaract($caract);
		echo '</div>';
		echo '</td>';	
		// bonus equip
		echo '<td style="width:40px;margin-left:10px;">';
			$acaract = 'a'.$caract;

			$bonus = $char->getaTot($caract);
			
			if($bonus > 0)
				echo ' + ';
			if($bonus < 0)
				echo ' ';
			if($bonus != 0)
				echo $bonus;
				
		echo '</td>';
		// bouton UP caract
		echo '<td style="width:30px;">';
			
			if($caract != 'cha' and $char->getBoostPoint() > 0)
			{
				$url = "page.php?category=profil&mode=profil&action=update&caract=".$caract;
				$onclick = "HTTPTargetCall('".$url."','bodygameig');";
				$onclick .= "refreshBarres()";
				echo '<img src="pictures/utils/bpstat.gif" alt"+" style="border:0px;margin-top:3px;" onclick="'.$onclick.'" />';							
			}
		echo '</td>';
	echo '</tr>';
}
echo '<tr></tr>';
// Affichage des boospoints
echo '<tr><td>';
	echo '<div style="margin-left:30px;text-align:right;">';
		echo 'points : ';
	echo '</div>';
	echo '</td>';
	echo '<td>';
	echo '<div style="margin-left:15px;">';
		echo $char->getBoostPoint();
	echo '</div>';
	echo '</td>';
	// bonus equip
	echo '<td>';
	
	echo '</td>';
	// bouton UP caract
	echo '<td>';
	
	echo '</td>';
echo '</tr>';


echo '</table>';

?>
