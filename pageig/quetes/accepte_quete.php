<?php
 require_once($server.'class/step.class.php');
 require_once($server.'class/pnj.class.php');


$step = new step($_GET['idstep']);
$step->accepteQuete($char->getId());

$pnj = new pnj($_GET['pnj_id']);

echo 'qu&ecirc;te accept&eacute;e'; 

	$idstep = $pnj->hasAQuest($char);
	if( $idstep !== false)
	{
            $q = new Step($idquete);
            
            if($q->getStepState($char))
            {
                    $onclick = "loadObject('pnj','1','".$pnj->getId()."');";
                    echo '<div style="text-align:center;margin-top:5px"><input class="button" type="button" value="Suite" onclick="'.$onclick.'" /></div>';
            }
	}
 
?>
