
<?php require_once('class/classe.class.php');?>

<div id="selected-class" style="display:none;">0</div>

<table style="width:80%;margin:auto;">
	<tr>
		<td colspan="2" style="height:25px;padding-bottom:5px;text-align:center;text-decoration:underline;font-size:12px;"> 
			Classe
		</td>
	</tr>
	
	<?php 
	
	$classList = classe::getAll();
	
	$i = 0;
	
	echo '<tr style="margin-top:5px;padding-top:10px;">';
	foreach($classList as $class)
	{
		$i++;
		if($i == 3)
		{
			echo '</tr>';
			echo '<tr style="margin-top:5px;">';
			$i = 1;
		}
		?>	
		<td style="text-align:center;">
			<div id="class-div-<?php echo $class['id'];?>" class="div-with-cadre" style="margin:auto;width:32px;height:32px;">
				<img src="pictures/classe/ico-<?php echo $class['id'];?>.gif" 
						title="<?php echo $class['name'];?>"
						onclick="selectClass(<?php echo $class['id'];?>);"  
						style="margin-top:4px;margin-left:2px;cursor:pointer;"></img>
			</div>
		</td>
		<?php 
	}
	?>
</table>