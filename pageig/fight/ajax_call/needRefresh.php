<?php
include('../../../require.php');
require_once($server.'class/fight/Fighter.class.php');

$char=unserialize($_SESSION['char']);
$fight_id=unserialize($_SESSION['fight_id']);

$fighter = new Fighter($char->getId(),$fight_id,1);
