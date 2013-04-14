<?php
/*
 * Created on 6 mars 2010
 */
 require_once($server.'class/faction.class.php');
 require_once($server.'class/recette.class.php');
$recette = new recette($_GET['recette_id']);

echo '<br />';
$recette->canDoRecette($char);
?>
