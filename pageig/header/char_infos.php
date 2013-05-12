<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}	
require_once($server.'require.php');

	$char=unserialize($_SESSION['char']);
?>
<div id="infoContainer" style="text-align: center; margin-top: 0px;" >
    <div id="charInfoContainer">	
        <div style="margin-top: 10px;height: 25px; margin-left: 0px;">
            <div style="float: left; width: 50px; margin-top: 5px;">
                
             <?php   echo ' <b>'.$char->getPa();?>
                <?php getPAPict(); ?>
            </b></div>	
            <div style="float: left; width: 50px; margin-top: 5px;">
                <?php	
                echo ' <b>'.$char->getPp();
                getPPPict(); ?>
            </b></div>
            <div style="float: left; width: 30px;margin-top: 5px;font-weight: 700;">
                <?php	echo ' <b>'.$char->getGold();
                    echo ' </b>';
                    getGoldPict();?>
            </div>
        </div>			
        
		
    </div>
    <?php
        $chemin = 'include/options.php';

		
        require_once($server.'include/options.php');	
        ?>	
</div>