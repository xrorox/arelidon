<?php 

if($_GET['refresh'] == 1)
{
	require_once('../../../require.php');
	require_once('../../../class/fight/Fight.class.php');
	require_once('../../../class/fight/Fighter.class.php');
	
	$fight = new Fight($_GET['fight_id']);
	$fighter = new Fighter($char->getId(),$_GET['fight_id'],1);
	
}

	if($fighter->isHisTurn())
	{
?>
	<input type="button" 
	 onclick="finishTurn();" 
	 value="Fin du tour" />
<?php 
	}else{
?>
	<input type="button" 
	 onclick="" 
	 value="Fin du tour"
	 disabled="disabled" />
<?php }?>