<?php
if(!empty($_GET['refresh']))
{
	require_once('../../../require.php');
	
	require_once('../../../class/fight/Fight.class.php');
	require_once('../../../class/fight/Fighter.class.php');
	require_once('../../../class/fight/Attack.class.php');
	require_once('../../../class/fight/AttackResult.class.php');

	$char=unserialize($_SESSION['char']);

	$fight_id = $_GET['fight_id'];
	
	$fighter = new Fighter($char->getId(),$fight_id,1);
	$fight = new Fight($fight_id);
}

$attackList = $fight->getAllAttacks();
?>

<div style="height:90px;width:100%;overflow-y:scroll;">

<table style="width:100%;">
	<?php
	foreach($attackList as $attack)
	{
		echo "<tr><td style='width:100%;padding-left:5px;text-align:left;'> >> ".$attack->toString()."</td></tr>";
		
		$attackResultList = $attack->getAttackResults();
		foreach($attackResultList as $attackResult)
		{
			echo "<tr><td style='padding-left:35px;width:100%;text-align:left;'>";
				echo $attackResult->toString();
			echo "</td></tr>";
		}
	}
	?>
</table>

</div>