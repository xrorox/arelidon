<?php 
	require_once("../../require.php");
	require_once("../../class/classe.class.php");

	if($_GET['class'] >= 1)
	{
		?>
		<table style="width: 120px;margin:auto;">
			<tr>
				<td style="vertical-align:top;width:120px;">
					<!-- Left menu, selection of class / sexe / faction -->
					<table style="width: 120px;" cellpadding="0" cellspacing="0">
						<tr>
							<td class="top-left">
							</td>
							<td class="top-middle">
							</td>
							<td class="top-right">
							</td>
						</tr>
						<tr>
							<td class="middle-left">
							</td>
							<td class="middle" style="vertical-align:middle;text-align:center;">
								<img src="pictures/classe/ico-<?php echo $_GET['class'];?>.gif" 
								style="float:left;margin-top:0px;margin-left:4px;cursor:pointer;width:20px;height:20px;"></img>
								<div style="float:left;margin-left:2px;text-align:center;">
									<?php 
										echo classe::GetClasseNameById($_GET['class']);
									?>
								</div>
							</td>
							<td class="middle-right">
							</td>
						</tr>
						<tr>
							<td class="bottom-left">
							</td>
							<td class="bottom-middle">
							</td>
							<td class="bottom-right">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>	
		
		<table style="width: 240px;height:120px;margin:auto;margin-top:-8px;">
			<tr>
				<td style="vertical-align:top;width:240px;margin:auto;">
					<!-- Left menu, selection of class / sexe / faction -->
					<table style="width: 240px;" cellpadding="0" cellspacing="0">
						<tr>
							<td class="top-left">
							</td>
							<td class="top-middle">
							</td>
							<td class="top-right">
							</td>
						</tr>
						<tr style="height:80px;">
							<td class="middle-left">
							</td>
							<td class="middle" style="vertical-align:top;padding-top:10px;">
								<?php 
                                                                        $class = new Classe($_GET['class']);
									echo $class->getDescription();
								?>
							</td>
							<td class="middle-right">
							</td>
						</tr>
						<tr>
							<td class="bottom-left">
							</td>
							<td class="bottom-middle">
							</td>
							<td class="bottom-right">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>		
		<?php 
	}
?>