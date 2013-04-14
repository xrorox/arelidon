<?php
    require_once("require.php");
    require_once("class/fight/fight.class.php");

?>

<div id="fight_phase_container" style="width: 900px;margin:auto;">

	<?php 
		$fight = new Fight($_GET['fight_id']);
		
		
		/* TODO
		 * 
		 *  Sur le r�sultat du fight on peut mettre la dur�e du combat et le nombre de tour
		 *  
		 *  */
		
		$color1 = "#c8bd9f";
		$color2 = "#b6ab8d";
		$color3 = "#8b8669";
		$color4 = "#52472b";
	?>
	
	<div style="height:40px">
		<div style="float:left;">
		
		</div>
	</div>
	
	<div style="padding-top:20px;padding-bottom:5px">
		Les Gagnants : 
	</div>
	<table style="width:700px;color:<?php echo $color4; ?>;font-weight:bold;">
		<tr style="background-color:<?php echo $color2; ?>;border:solid 0.5px <?php echo $color3; ?>;">
			<td style="padding-left:15px;width:200px;"> Nom </td>
			<td style="text-align:center;"> Niv </td>
			<td style="text-align:center;"> Exp gagné </td>
			<td style="text-align:center;"> Or gagné </td>
			<td style="padding-left:5px"> Objets gagnés </td>
		</tr>
		<?php 
			$i = 1;
			foreach($fight->getFighterList($fight->getIsEnd()) as $fighter)
			{
				if($i == 1)
				{
					$style = "background-color:".$color1.";";
					$i = 2;
				}else{
					$style = "background-color:".$color2.";";
					$i = 1;
				}
				
				?>
				<tr style="<?php echo $style; ?>">
					<td style="padding-left:15px">
						<?php echo $fighter->getName(); ?>
					</td>
					<td style="text-align:center;">
						<?php echo $fighter->getLevel(); ?>
					</td>
					<td style="text-align:center;">
						<?php echo $fighter->getExpWin(); ?>
					</td>
					<td style="text-align:center;">
						<?php echo $fighter->getGoldWin(); ?>
					</td>
					<td style="padding-left:10px">
						<?php 
							$dropList = $fighter->getDropList();
							
							if(count($dropList) > 0)
							{
								foreach($dropList as $drop)
								{
									$item = new Item($drop['item_id']);	
									
									echo " ".$drop['number']."x ";
									echo $item->getPictureWithToolTip();
									echo " ";
									
								}
							}
						?>
					</td>
				</tr>
				<?php 
			}
		?>
	</table>
	
	<div style="padding-top:20px;padding-bottom:5px">
		Les perdants :
	</div> 
	
	<table style="width:700px" border="1">
		<tr style="background-color:<?php echo $color1; ?>">
			<td> Nom </td>
			<td> Niv </td>
			<td> Exp gagné </td>
			<td> Or gagné </td>
			<td> Objets gagnés </td>
		</tr>
                <?php
                    if($fight->getIsEnd() == 1) $id_losers =2;
                    else $id_losers = 1;
                    
                    foreach($fight->getFighterList($id_losers) as $fighter)
                    {
                        if($i == 1)
				{
					$style = "background-color:".$color1.";";
					$i = 2;
				}else{
					$style = "background-color:".$color2.";";
					$i = 1;
				}
				
				?>
				<tr style="<?php echo $style; ?>">
					<td style="padding-left:15px">
						<?php echo $fighter->getName(); ?>
					</td>
					<td style="text-align:center;">
						<?php echo $fighter->getLevel(); ?>
					</td>
					<td style="text-align:center;">
						<?php echo $fighter->getExpWin(); ?>
					</td>
					<td style="text-align:center;">
						<?php echo $fighter->getGoldWin(); ?>
					</td>
					<td style="padding-left:10px">
						<?php 
							$dropList = $fighter->getDropList();
							
							if(count($dropList) > 0)
							{
								foreach($dropList as $drop)
								{
									$item = new Item($drop['item_id']);	
									
									echo " ".$drop['number']."x ";
									echo $item->getPictureWithToolTip();
									echo " ";
									
								}
							}
						?>
					</td>
				</tr>
				<?php
                    }
                
                
                
                
                
                ?>
	</table>
	
</div>