<?php

require_once('../../require.php');
require_once('../../class/fight/Fight.class.php');
require_once('../../class/monster.class.php');

$char=unserialize($_SESSION['char']);

// si le monstre est pas en combat on lance le combat

$fight = new Fight();

$fight_id = $fight->createFight($char,$_GET['pvp'],$_POST['monster_id']);

header("Location:../../fight.php?fight_id=".$fight_id);