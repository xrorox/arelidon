<?php

require_once('../../../require.php');
require_once('../../../class/fight/Fight.class.php');
require_once('../../../class/fight/Fighter.class.php');

$fight_id = unserialize($_SESSION['fight_id']);

$fighter = new Fighter($_GET['fighter_id'],$fight_id,1);
$fighter->setReady();

Fight::setNeedRefreshForAllForFightId($fight_id);

echo "X";
?>

<div id="is_ready_<?php echo $fighter->getPlace(); ?>" style="display:none;"><?php echo $fighter->isReady(); ?></div>