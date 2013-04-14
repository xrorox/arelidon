<?php

////////////////////////////////////////////////
//    Author : frinux
//    Website : http://www.frinux.fr
////////////////////////////////////////////////
//
//  Description:
//    This script allows you to backup folders and
//    databases on you server in one click
////////////////////////////////////////////////

require_once($server.'backup/config.php');
require_once($server.'backup/functions.php');
?>

<h1>Liste des sauvegardes</h1>
<h2>Bases de donn&eacute;es</h2>
<table border="1">
<?
$dossier = opendir ($backup_path);
while ($fichier = readdir ($dossier)) 
{
  if ($fichier != '.' && $fichier != '..' && $fichier != '.htaccess')
  {
    $pwd=$backup_path.$fichier;
    $size=Size($pwd);
    echo'<tr><td>';
    echo '<a href="'.$pwd.'">'.$fichier.'</a> ('.$size.' )';
    echo '</td><td>
        <form action="delete.php" method="post">
        <input type="submit" value="Supprimer le fichier" />
        <input type="hidden" name="filename" value="'.$pwd.'" />
        </form>
        ';
    echo'</td></tr>';
  }
}
closedir ($dossier);
?>
</table>

<h2>Fichiers</h2>
<table border="1">
<?
$dossier = opendir ($backupdir_path);
while ($fichier = readdir ($dossier)) 
{
  if ($fichier != '.' && $fichier != '..' && $fichier != '.htaccess')
  {
    $pwd=$backupdir_path.$fichier;
    $size=Size($pwd);
    echo'<tr><td>';
    echo '<a href="'.$pwd.'">'.$fichier.'</a> ('.$size.' )';
    echo '</td><td>
        <form action="delete.php" method="post">
        <input type="submit" value="Supprimer le fichier" />
        <input type="hidden" name="filename" value="'.$pwd.'" />
        </form>
        ';
    echo'</td></tr>';
  }
}
closedir ($dossier);
?>
</table>


<h1>Effectuer une sauvegarde</h1>
S&eacute;lectionnez une base :
<form action="dump.php" method="post">
    <select name="database_name">
    <?php
    for($i=0;$i<$base_number;$i++)
    {
      echo'<option>'.$description[$i+1].'</option>';
    }
    ?>
    </select>
    <input type="submit" value="Sauvegarder" />
</form>

S&eacute;lectionnez un r&eacute;pertoire :
<form action="backupdir.php" method="post">
    <select name="dir_name">
    <?php
    $rep = '../';
    $dir = opendir($rep);
    while ($f = readdir($dir)) {
      if(is_dir($rep.$f) && $f != '.' && $f != '..' && $f != $folder_name) {
        $ListFiles[$i]=$f;
        $i++;
      }
    }
    sort($ListFiles,SORT_STRING);
    $j=0;
    while ( $j < count($ListFiles))
    {
      echo '<option>'.$ListFiles[$j].'</option>';
      $j++;
    } 
    ?>
    </select>
    <input type="submit" value="Sauvegarder" />
</form>
