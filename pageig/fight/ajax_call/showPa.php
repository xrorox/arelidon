<?php
require_once('../../../require.php');

require_once("../../../class/fight/Fighter.class.php");
require_once("../../../class/fight/Fight.class.php");

$char=unserialize($_SESSION['char']);

$fight_id = $_GET['fight_id'];
$fighter = new Fighter($char->getId(),$fight_id,1);

echo $fighter->getPa();