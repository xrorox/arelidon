<?php

echo '<form method="post" action="panneauAdmin.php?category=32&add=1">';
echo '<table class="backgroundBody" style="width:450px;border:solid 1px white;margin-top:25px;" cellspacing="0">';
echo '<tr>';
echo '<td style="text-align:center;"> Abs : </td>';
echo '<td><input type="text" id="abs" name="abs"/> </td>';
echo '</tr>';

echo '<tr>';
echo '<td style="text-align:center;"> Ord : </td>';
echo '<td> <input type="text" id="ord" name="ord"/> </td>';
echo '</tr>';

echo '<tr>';
echo '<td style="text-align:center;"> Map : </td>';
echo '<td> <input type="text" id="map" name="map"/> </td>';
echo '</tr>';

echo '<tr>';
echo '<td style="text-align:center;"> Métier : </td>';

$sql= "SELECT * FROM `metier`";
$ArrayOfArray= loadSqlResultArrayList($sql);
echo '<td>';
echo '<select name="metier_id" id="metier_id>"';

foreach ($ArrayOfArray as $Array){
echo '<option value="'.$Array['id'].'"> '.$Array['name'].'         </option>';

}
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>';
echo '</td>';
echo '<td>';
echo '<input type="submit" value="Ajouter"/>';
echo '</td>';
echo '</tr>';



echo '</form>';



?>
