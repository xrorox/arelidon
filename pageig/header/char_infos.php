<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}	
require_once($server.'require.php');

	$char=unserialize($_SESSION['char']);
?>
<div id="infoContainer" class="center marginTop0 ">
    <div id="charInfoContainer">	
        <div class="marginTop10 height25 marginLeft0">
            <div class="left width50P center marginTop5">
                <?php getPAPict(); ?>
             <?php   echo ' <b>'.$char->getFatigue();?>
            </b></div>	
            <div class="left width50P center marginTop5">
                <?php	getPPPict();
                echo ' <b>'.$char->getPp(); ?>
            </b></div>
        </div>			
        <div class="marginTop0 fontW700">
            <?php	echo ' <b>'.$char->getGold();
                echo ' </b>';
                getGoldPict();?>
        </div>
		
    </div>
    <?php
        $chemin = 'include/options.php';

		
        require_once($server.'include/options.php');	
        ?>	
</div>