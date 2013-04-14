<div id="fight_phase_container" style="width: 900px;margin:auto; ">

	<div style="display:none;">
		<div id="ready_phase" style="display:none">0</div>
		<div id="fight_id" style="display:none"><?php echo $_GET['fight_id']; ?></div>
		<div id="char_id" style="display:none"><?php echo $char->getId(); ?></div>
		<div id="need_refresh" style="display:none;">0</div>
	</div>
	<div id="is_end" style="display:block;">0</div>
        <?php echo '<div id="end_of_fight" style="display:none;">'. $fight->getIsEnd().'</div>';?>
	<div style="">
		<table border="1" style="height:180px;width:900px;margin:auto;margin-top:10px;margin-bottom:10px;">
			<tr>
				<td style="width:250px;" rowspan="2">
					<table border="1" style="width:100%">
						<tr>
							<td>
								<div id="use_attack_container" style="display:block;"></div>
								<div id="ajax_call_container" style="height:20px;width:100%;border:solid 1px white;background-color:black;"></div>
							</td>
						</tr>
						<tr style="height:155px;">
							<td>
								<div id="info_char_container">
									INFO 
								</div>
							</td>
						</tr>
						<tr style="height:155px;">
							<td>
								INFO 2 
							</td>
						</tr>
					</table>
				</td>
				<td style="width:400px;">
					<div id="chars_container">
						<?php require("subview/charsContainer.php");?>
					</div>
				</td>
				<td style="width:250px;" rowspan="2">
					<table>
						<tr style="height:290px;">
							<td>
								<div id="turn_list_container">
									<?php include("subview/turnList.php");?>
								</div>
							</td>
						</tr>
						<tr style="height:40px;margin-top:10px;">
							<td>
								<table style="width:100%">
									<tr>
										<td style="width:50px;text-align:right;">
											<img src="pictures/utils/timer.png" title="Temps restant" />
										</td>
										<td style="width:50px;text-align:center;">
											<div id="timer">
												<?php require("subview/timer.php");?>
											</div>
										</td>
										<td style="width:150px;text-align:center;" rowspan="2">
											
										</td>
									</tr>
									<tr>
										<td style="width:50px;text-align:right;">
											<img src="pictures/utils/pa.png" title="Points d'action" />
										</td>
										<td style="width:50px;text-align:center;">
											<div id="pa">
												<?php echo $fighter->getPa(); ?>
											</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<div style="width:400px;margin:auto;border:solid 1px black;">
						<?php require("subview/skillList.php");?>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<div style="text-align:center">
		
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        setInterval("refreshFight();",1000);
        
    });
    
    

</script>