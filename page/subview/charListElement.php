<?php
	require_once("class/classe.class.php");

	// If the view can access to the model
	if(isset($charElement))
	{
		if(!$emptyElement)
		{
		?>
			<tr class="black" style="display:block;"cellspacing="0" cellpadding="0" border="0">
				<td>
					<?php
					if($i == 1)
						$selected = "char-element-list-selected";
					else
						$selected = "";
					
					?>
					<div id="char-element-list-<?php echo $i;?>" class="char-element-list">
					
						<table id="char-element-list-table-<?php echo $i;?>" class="char-element-list-table <?php echo $selected; ?>" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td rowspan="2" class="width32" onclick="switchChar(<?php echo $i; ?>);">
									<img src="pictures/classe/<?php echo $charElement['classe'];?>/ico/<?php echo $charElement['gender'];?>-1.gif" style="margin:auto;" />
								</td>
								<td class="char-element-list-label" onclick="switchChar(<?php echo $i; ?>);">
									<?php echo $charElement['name']; ?>
								</td>
								<td class="width18 paddingRight2 paddingTop2">
									<img src="pictures/utils/no.gif" onclick="deleteChar(<?php echo $charElement['id'];?>);" />
								</td>
							</tr>
							<tr>
								<td class="char-element-list-sublabel" onclick="switchChar(<?php echo $i; ?>);">
								 	<?php 
								 		echo Classe::GetClasseNameById($charElement['classe']);
								 	
								 		if(isset($charElement['secondary_classe']) and $charElement['secondary_classe'] > 0)
								 		{
								 			echo Classe::GetClasseNameById($charElement['secondary_classe']);
								 		}
								 	?>
								 	 niv <?php echo $charElement['level'];?> 
								 </td>
								<td onclick="switchChar(<?php echo $i; ?>);"></td>
							</tr>
						</table>
					
					</div>
					
				</td>
			</tr>
		<?php 
		}else{
		?>
			<tr class="black height48" cellspacing="0" cellpadding="0" border="0" >
				<td>
					<div id="char-element-list-empty" class="char-element-list">
					
						<table id="char-element-list-table-empty" class="char-element-list-table" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td rowspan="2" class="width32">
								</td>
								<td class="char-element-list-label" class="paddingLeft30 height45"style="padding-left:30px !important;height:45px;">
									<?php 
									if($locked)
										echo "Bloqué";
									else
										echo "Vide"; ?>
								</td>
								<td class="width18 paddingRight2 paddingTop2">
								</td>
							</tr>
							<tr>
								<td class="char-element-list-sublabel">
								 </td>
								<td></td>
							</tr>
						</table>
					
					</div>
					
				</td>
			</tr>
		<?php 			
		}
		
	}