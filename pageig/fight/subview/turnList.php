<?php

if(!empty($_GET['refresh']))
{
	require('../../../require.php');
	require_once('../../../class/fight/Fight.class.php');
	require_once('../../../class/monster.class.php');

	$char=unserialize($_SESSION['char']);

	$fight_id = $_GET['fight_id'];
	
	$fight = new Fight($fight_id);
	$fighter = new Fighter($char->getId(),$fight_id,1);
}
?>
<table>
	<?php 
	foreach($fight->getFighterListOrderByInit() as $fighter_inst)
	{
		?>
		<tr>
			<td>
				<?php if($fighter_inst->isHisTurn())
				{?>
					 > 
				<?php 
				}
				?>
			</td>
			<td>
				<?php echo $fighter_inst->getInstance()->getName(); ?>
			</td>
		</tr>
		<?php 
	}
	?>
</table>