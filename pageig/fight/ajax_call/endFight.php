<?php

require_once('../../../require.php');
require_once('../../../class/fight/Fight.class.php');
require_once('../../../class/fight/Fighter.class.php');

require_once('../../../class/monster.class.php');
require_once('../../../class/skill.class.php');
require_once('../../../class/effect.class.php');

if(isset($_GET['fight_id']) && $_GET['fight_id'] != "undefined")
{
    $fight = new Fight($_GET['fight_id']);
    if($fight->isFightFinished())
    {
        echo $fight->getIsEnd();
        $fight->endTheFight();
        
    }
    
}

