<?php

if(!empty($_GET['refresh']))
{
    if(!empty($_GET['action']))
	$action = $_GET['action'];
    
    if(!empty($_GET['idskill']))
	$idskill = $_GET['idskill'];
    
    if(!empty($_GET['id']))
	$idmonster = $_GET['id'];
}else{
	$action = $_POST['action'];
	$idskill = $_POST['idskill'];
	$idmonster = $_POST['idmonster'];
	$player = $_POST['player'];
}
	if(!isset($_SESSION))
        {
            session_start();
            $server = $_SESSION['server'];
        }
	require_once($server.'utils/fight.php'); 
	require_once($server.'function/fight.function.php'); 
	require_once($server.'class/monster.class.php');



$monster = new monster($idmonster);

$time = time();
if($monster->getLife() > 0 && $monster->getTimestampRespawn() < $time)
{
    ?>
	<hr />
	
	
	
	<div style="height:70px;">
		<div style="margin-top:10px;text-align:center;margin:2px;margin-bottom:5px;margin-top:5px;float:left;border:0px;width:64px;height:64px;">
			<img src="pictures/monster/<?php echo $monster->getIdMstr()?>.gif" />
		</div>
	
		<div style="margin-left:50px;">
		
			<div id="monster_name" style="margin-left:20px;"> <?php echo $monster->getName()?> </div>
			<div id="monster_level" style="margin-left:40px;font-size:10px;"> Niveau <?php echo $monster->getLevel()?> </div>
		
			<div class="barre" style="margin-left:20px;border:solid 1px black;height:5px;width:150px;background-color:black;">
                                <?php
				$pourcentVie = $monster->getPourcentLife();
				$pourcentVie = $pourcentVie * 1.5;
                                ?>
				
				<?php if($monster->getTimestampRespawn() < $time): ?>
					<div class="barre" style="width:<?php echo $pourcentVie?>px;height:5px;background-color:red;"></div>
				<?php else: ?>
					<div style="width:0px;height:5px;background-color:red;"></div>
                                <?php endif; ?>
			</div>
	
			<div class="barre" style="margin-left:20px;border:solid 1px black;height:5px;width:150px;background-color:black;margin-top:2px;">
			<?php
				$pourcentMana = $monster->getPourcentMana();
				$pourcentMana = $pourcentMana * 1.5;
			?>	
				<?php if($monster->getTimestampRespawn() < $time): ?>
					<div class="barre" style="width: <?php echo $pourcentMana ?>px;height:5px;background-color:blue;"></div>
				<?php else: ?>
					<div style="width:0px;height:5px;background-color:blue;"></div>
                                <?php endif; ?>
			</div>
 		</div>
 	</div>
 	
	<hr />

	
	
	<form action="pageig/fight/launchFight.php?pvp=0" method="post">
		<input type="hidden" name="monster_id" value="<?php echo $idmonster; ?>" />
		<input type="submit" value="Combattre" />
	</form>
	
	<?php 
} // FIN SI LE MONSTRE N A PLUS DE VIE ? ON AFFICHE JUSTE LE RESULTAT



?>
