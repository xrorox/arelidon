<?php
require_once($server.'class/pnj.class.php');
require_once($server.'class/step.class.php');
require_once($server.'class/quete.class.php');
$step = new step($_GET['idstep']);

$quete = new quete($step->getIdQuete());

$step->setQuete($quete);
$step->showStepSummary($char);
 
?>