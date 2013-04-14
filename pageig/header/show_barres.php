<?php

if(!empty($_GET['refresh']))
{
    if(!isset($_SESSION))
    {
        session_start();
        $server = $_SESSION['server'];
    }
require_once($server.'require.php');
}

 $char=unserialize($_SESSION['char']);
$pourcent = char::calculPourcentExp($char->getExp(),$char->getLevel()); 
showBarre('exp',$pourcent);

$min = $char->getLife();
$max = $char->getLifeMax();
$pourcent = round (($min / $max) * 100);
showBarre('life',$pourcent,$min,$max);

$min = $char->getMana();
$max = $char->getManaMax();
$pourcent = round (($min / $max) * 100);
showBarre('mana',$pourcent,$min,$max);
?>