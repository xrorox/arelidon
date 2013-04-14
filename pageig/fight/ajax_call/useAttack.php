<?php
require_once('../../../require.php');

require_once("../../../class/fight/Fighter.class.php");
require_once("../../../class/fight/Fight.class.php");
require_once("../../../class/fight/Attack.class.php");
require_once("../../../class/fight/AttackResult.class.php");

require_once("../../../class/monster.class.php");
require_once("../../../class/skill.class.php");
require_once("../../../class/effect.class.php");
$char=unserialize($_SESSION['char']);

$fight_id = $_GET['fight_id'];
$fighter = new Fighter($char->getId(),$fight_id,1);
$fighter_target = new Fighter($_GET['target_id'],$fight_id,$_GET['is_char']);
$skill = new Skill($_GET['skill_id']);


if($skill->canBeLaunched($fighter,$fighter_target))
{
	$fight = new Fight($fight_id);
	
	$attack = new Attack();
	$attack->createAttack($fight_id,$fighter,$skill,$fighter_target,$fight->getTurnId());
	
	$fight->setNeedRefreshForAll();
}

echo "<script type=\"text/javascript\"> $(document).ready(function(){
        
       refreshChar(); 
   });</script>";