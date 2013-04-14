<?php

require_once('../../../require.php');
require_once('../../../class/fight/Fight.class.php');
require_once('../../../class/fight/Fighter.class.php');

require_once('../../../class/monster.class.php');
require_once('../../../class/skill.class.php');
require_once('../../../class/effect.class.php');


$char=unserialize($_SESSION['char']);

$fight = new Fight($_GET['fight_id']);
$fighter = new Fighter($char->getId(),$char->getFightId(),1);


// Si le tour a pas encore été mis à jours
if($fight->getTimestamp() <= time())
{
	$fight->endTurn($fighter);
}