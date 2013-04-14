<?php
require_once('../../../require.php');
require_once('../../../class/fight/Fight.class.php');
require_once('../../../class/fight/Fighter.class.php');

$char=unserialize($_SESSION['char']);

$fighter = new Fighter($char->getId(),$char->getFightId(),1);

if($fighter->isReady())
	echo "X";
else
	echo "";
	
?>

<div id="is_ready_<?php echo $fighter->getPlace(); ?>" style="display:none;"><?php echo $fighter->isReady(); ?></div>