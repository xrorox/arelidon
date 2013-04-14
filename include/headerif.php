<?php

if(isset($_GET['refresh']) && $_GET['refresh'] == 1)
{
    $site=$_SERVER['HTTP_HOST']; // test pour savoir si on est en ligne ou en local
	if(($site == "127.0.0.1" || $site == "localhost"))
	{
		$server=$_SERVER["DOCUMENT_ROOT"].'/arelidon/';
	}
        else{
		$server="/dns/com/olympe-network/arelidon/";
	}
require_once($server.'require.php');
	
	
$user = unserialize($_SESSION['user']);
$char=unserialize($_SESSION['char']);

}

$saved_char = $char;
require_once($server.'class/message.class.php');
?>

<div style="height:100px;">;

		<div id="info-title-container" style="float:left;width:506px;text-align:center;vertical-align:middle;padding-top:5px;">
		
			<?php if($fight->isInReadyPhase()): ?>	
			<div style="text-align:center"> Publicit� </div>
			<div style="height:468px;height:60px;text-align:center;">
<!--				<img src="../pictures/banniere/468x60.gif" title="ban" alt="pub" style="width:468px;height:60px" />-->
			</div>
			<?php else:?>
				<div id="tchat_fight_container">
					<?php require('pageig/fight/subview/infoFight.php');?>
				</div>
			<?php endif;?>
			
		</div>

		
		<div class="cote" style="float:left;width:20px;height:100px;"></div>
		
		<div id="tchatcontainerbody" style="height:100px;margin-top:-15px">
			<div id="tchatcontainer">
			<div id="waiter_tchat"></div>
				<?php require_once($server.'tchat/tchatcontainer.php'); ?>
			</div>
		</div>
	</div>

<div id="topheadig2"></div>