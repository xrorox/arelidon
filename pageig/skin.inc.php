<?php

if($_GET['confirm_skin'] == 1)
{
	if($_GET['num'] > 0)
	{
		require_once('../require.php');
		
		$char->update('skin',$_GET['num']);
	}
}else{
	?>
	
	<div id="send_confirm_skin"> </div>
	
	<fieldset>
		<legend> Skins </legend>
		
		<?php 
			$sql = "SELECT * FROM `skin` WHERE classe = '".$char->getClasse()."' && gender = '".$char->getGender()."' ";
			$skins = loadSqlResultArrayList($sql);
		?>
		<form method="post" action="#">
			<table style="border:solid 1px white;" border="1">
				<tr style="border-bottom:solid 1px white;">
					<?php 
						foreach($skins as $skin)
						{
							echo '<td style="width:100px;text-align:center;;">';
								echo '<img style="margin:auto;" src="pictures/classe/'.$char->getClasse().'/ico/'.$skin['num'].'-1.gif" alt="skin" />';
								
							echo '</td>';
						}
					?>
				</tr>
				
				<tr style="border-bottom:solid 1px white;">
					<?php 
						foreach($skins as $skin)
						{
							echo '<td style="text-align:center;">';
								echo $skin['name'];
							echo '</td>';
						}
					?>
				</tr>
				
				<tr>
					<?php 
						foreach($skins as $skin)
						{
							echo '<td style="text-align:center;">';
							
								if($char->getSkin() == $skin['num'])
									$checked = "checked=checked";
								else 
									$checked = "";
								
								if($char->getTheSkin($skin['id'],$skin['num']))
								{
									$url = "pageig/skin.inc.php?confirm_skin=1&num=".$skin['num'];
									$onclick = "HTTPTargetCall('".$url."','send_confirm_skin');";
									echo '<input type="radio" onclick="'.$onclick.'" name="skin" value="'.$skin['num'].'" '.$checked.' />';
								}else{
									// Ajouter l'url pour acheter le skin	
									echo 'non poss&eacute;d&eacute;';
								}
								
							echo '</td>';
						}
					?>
				</tr>
			</table>
		</form>
	</fieldset>
	
	<?php 
}