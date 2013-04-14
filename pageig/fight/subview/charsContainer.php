<?php
if(!empty($_GET['refresh']))
{
	require('../../../require.php');
	require_once('../../../class/char.class.php');
	
	require_once("../../../class/fight/Fighter.class.php");
	require_once("../../../class/fight/Fight.class.php");
	require_once("../../../class/fight/Attack.class.php");
	require_once("../../../class/fight/AttackResult.class.php");
	
	require_once("../../../class/monster.class.php");
	require_once("../../../class/skill.class.php");
	require_once("../../../class/effect.class.php");
}
	$char=unserialize($_SESSION['char']);
	$fighter = new Fighter($char->getId(),$char->getFightId(),1);
	$fight = new Fight($char->getFightId(),1);

?>
<div id="click_on_skill" style="display:none;">0</div>
<div id="skill_id" style="display:none;">0</div>

<table border="1" style="height:180px;width:400px;margin:auto;margin-top:10px;margin-bottom:10px;">
	<?php 
	$ready_phase = 0; 
	?>
	<tr style="height:80px;">
		<!-- Affichage des monstres / team 2	-->
		<?php 
			
			$fighterList = $fight->getFighterList(2);
			
			foreach($fighterList as $fighter)
			{
				require("fighter_container.php");
			}
		?>
	</tr>	
	<tr style="height:80px;">
		<!-- Affichage des invocs teams 2	-->
	</tr>	
	<tr style="height:80px;">
		<!-- Affichage des invoc team 1	-->
	</tr>	
	<tr style="height:80px;">
		<!-- Affichage des joueurs	-->
		<?php 
			$fighterList = $fight->getFighterList(1);
			
			foreach($fighterList as $fighter)
			{
				require("fighter_container.php");
			}
		?>
	</tr>			
</table>