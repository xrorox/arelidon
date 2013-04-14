<?php
////////////////////////////////////////////////
//    Author : frinux
//    Website : http://www.frinux.fr
////////////////////////////////////////////////
//
//      backup folders
////////////////////////////////////////////////

require_once($server.'backup/config.php');
require_once($server.'backup/functions.php');


if (isset($_POST)) {
  $dir_name=$_POST['dir_name'];
  
  if ($confirm!='yes') {
  $dir='../'.$dir_name.'/';
  echo $dir;
  echo 'Attention, le dossier '.$dir_name.' a une taille de '.DirSize($dir,1).'. Le sauvegarder peut prendre du temps. Etes-vous sur de vouloir le sauvegarder ?'
  ?>
  
  <form action="backupdir.php" method="post">
    <input type="hidden" name="confirm" value="yes" />
    <input type="hidden" name="dir_name" value="<?php echo $dir_name; ?>" />
    <input type="submit" value="Oui" />
  </form>
  
  <?php
  
  }
  
  else { //form sent
    $filename=$backupdir_path.$dir_name.'_'.$current_date.'.tar';
    $dir='../'.$dir_name;
    
    $filename=escapeshellarg($filename);
    system("tar -czvvf $filename $dir");
    
      echo '<h2>Dossier sauvegard&eacute;</h2>';
  }

  echo'<a href="index.php">&lt;-Retour</a>';

}

?>