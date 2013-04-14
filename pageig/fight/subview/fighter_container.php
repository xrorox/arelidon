<td>
	<div id="id_of_fighter_<?php echo $fighter->getPlace(); ?>" style="display:none;"><?php echo $fighter->getFighterId(); ?></div>
	
	
	<?php if($fighter->isChar())
	{
	?>
		<div id="is_char_<?php echo $fighter->getPlace(); ?>" style="display:none;">1</div>
		<div id="place_of_char_fighter_<?php echo $fighter->getPlace(); ?>" style="display:none;"><?php echo $fighter->getPlace(); ?></div>
	<?php 	
	}else{
	?>
		<div id="is_char_<?php echo $fighter->getPlace(); ?>"  style="display:none;">0</div>
	<?php 
	}
	?>
	<div id="place_of_fighter_<?php echo $fighter->getPlace(); ?>" style="display:none;"><?php echo $fighter->getPlace(); ?></div>
	<div id="can_be_target_<?php echo $fighter->getPlace(); ?>" style="display:none;">0</div>
	
	
	<table border="0" cellpadding="0" cellspacing="0" style="margin:auto;">
		<tr style="height:14px;">
			<td>
				<div id="cursor_<?php echo $fighter->getPlace(); ?>" class="cursor_container" style="text-align:center;vertical-align:middle;height:20px;">
					<?php if($ready_phase == 1)
					{
						if($fighter->isReady())
						{
							echo "X";
						}
						?>
						<div id="is_ready_<?php echo $fighter->getPlace(); ?>" style="display:none;"><?php echo $fighter->isReady(); ?></div>
						<?php 
					}else{
						
					}
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td id="anim_<?php echo $fighter->getPlace(); ?>" style="height:66px;width:66px;">
				<div id="pict_<?php echo $fighter->getPlace(); ?>" 
					 style="margin:auto;text-align:center;height:64px;width:64px;cursor:pointer;" 
					 onmouseover="mouseOverOnChar(<?php echo $fighter->getPlace(); ?>);"
					 onmouseout="mouseOutOnChar(<?php echo $fighter->getPlace(); ?>);"
					 onclick="clickOnTargetWithSkill(<?php echo $fighter->getFighterId(); ?>,<?php echo $fighter->getPlace(); ?>);"
					 >
				<?php if($fighter->getTeam() == 1)
							$face = 3;
					  else
					  		$face = 1;
				if($fighter->getLife() > 0)
				{
				?>
					<div id="is_dead_<?php echo $fighter->getPlace(); ?>" style="display:none;">0</div>
					<img style="margin:auto !important;cursor:pointer;" 
						 src="<?php echo $fighter->getInstance()->getFighterPictureUrl($face); ?>" />
				<?php 
				}else{
				?>
					<div id="is_dead_<?php echo $fighter->getPlace(); ?>" style="display:none;">1</div>
					<img style="margin:auto !important;cursor:pointer;" 
					     src="pictures/classe/die.gif" />
				<?php 
				}
				?>
				</div>
			</td>
		</tr>
		<tr>
			<td style="height:2px;">
				<div id="aoe_<?php echo $fighter->getPlace(); ?>">
					
				</div>
			</td>
		</tr>
	</table>	
</td>