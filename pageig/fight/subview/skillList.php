<?php

if(!empty($_GET['refresh']))
{
	require('../../../require.php');
	require('../../../class/skill.class.php');

	$char=unserialize($_SESSION['char']);

	$fighter = new Fighter($char->getId(),$char->getFightId(),1);
	$fight = new Fight($char->getFightId(),1);
}else{
	require('class/skill.class.php');
}

$skillList = $fighter->getSkillAvailableList();
?>

<table cellpadding="0" cellspacing="0">
	<tr>
		<?php foreach($skillList as $skill)
		{
			// il faut griser et non pas ne pas afficher
			if($skill->canBeLaunchByFighter($fighter))
			{
                            if($skill->getUsableOnHimself() == 1) $team = $fight->getFighterList($fighter->getTeam());
                            else
                            {
                                if($fighter->getTeam() == 1)$team = $fight->getFighterList(2);
                                else $team = $fight->getFighterList (1);
                            }
				?>
				<td style="background-image: url('pictures/skill/font.gif');height:32px;width:32px;background-repeat:no-repeat;">
					<img src="pictures/skill/<?php echo $skill->getId(); ?>.gif"
					 style="height:32px;width:32px;cursor:pointer;" 
					 title="<?php echo $skill->getName();?>"
					 onclick="clickOnSkill(<?php echo $skill->getId();?>,
					 						<?php echo $fighter->getPlace();?>,
					 						<?php echo $fighter->getTeam();?>,
					 						<?php echo $skill->getUsableOnAlly();?>,
					 						<?php echo $skill->getUsableOnHimself();?>,
					 						<?php echo $skill->getCanRez();?>,
					 						0,<?php echo count($team)?>
					 						);" />
				</td>
				<?php 
				$i++;
				
				if($i == 11 || $i == 22 || $i == 33)
				{
					echo '<tr></tr>';
                                        die();
				}	
			}
		}?>	
	</tr>
</table>