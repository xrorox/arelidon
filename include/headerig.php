<?php

if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}

require_once($server.'require.php');
	
	
$user = unserialize($_SESSION['user']);
$char=unserialize($_SESSION['char']);



$saved_char = $char;
require_once($server.'class/message.class.php');
?>

<div style="height:100px;">&nbsp;

		<div id="info-title-container" style="float:left;width:226px;">
			<div id="infoTitle">
				<div id="avatar" style="float:left;border:solid 2px #131131;margin:5px;height:50px;background-color:black;">
				<?php echo '<img src="'.$char->getUrlPicture('face').'" alt="X" />'; ?>
				</div>		
			<div id="show_barres" style="margin-left:65px;color:grey;margin-top:-7px;padding-right:0px;">
			<?php
				require_once($server.'pageig/header/show_barres.php');
			?>
			</div>
			
			</div>
			
			
			<div id="menuButton">
				
			</div>
		</div>
		
		<div id="navigator" style="">
		<?php 
		// TO FIX : Fucking problem, show_barres massacre l'instance char
		$char = $saved_char;
		?>
			<?php require_once($server.'pageig/header/menu_navigator.php'); ?>
		</div>
		
		<div id="char_infos" style="">
			<?php require_once($server.'pageig/header/char_infos.php'); ?>
		</div>

		
<div class="cote" style="float:left;width:20px;height:100px;"></div>
	
	<div id="tchatcontainerbody" style="height:100px;margin-top:-15px">
		<div id="tchatcontainer">
		<div id="waiter_tchat"></div>
			<?php require_once($server.'tchat/tchatcontainer.php') ?>
		</div>
	</div>
</div>

<div id="topheadig"></div>
