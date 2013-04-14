<?php
$min = (!empty($_GET['min'])) ? $_GET['min'] : 0;
$max = (!empty($_GET['max'])) ? $_GET['max'] : 0;
?>
<div style="text-align:center;">
    <div style="text-align:left;margin-left:260px;border:solid 1px white;width:250px;">

        <div style="margin:20px;">
            <div style="text-align:center;font-weight:700;"> Ajouter une image sur le serveur </div><br />
            <form method="post" enctype="multipart/form-data" action="panneauAdmin.php?category=2&add_image=1&norefresh=1">
                Img : <input type="file" name="fichier" /><br />
                <div style="text-align:center;"><input type="submit" value="ajouter le fichier" /></div>
                <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
            </form>
        </div>
    </div>


    <div style="margin-top:30px;"></div>	
    <?php
    // Ajouter une image
    if (!empty($_GET['add_image'])) {
        $chemin = 'map/';

        if (!file_exists($chemin))
            $dirname = '../map/';

        $fichier = $_FILES['fichier']['name'];

        if (file_exists($chemin . $fichier)) {
            echo 'Attention le fichier existe déjà , vous devez le supprimer avant';
        } else {
            move_uploaded_file($_FILES['fichier']['tmp_name'], $chemin . $fichier);
            echo '=> le fichier a bien été inséré';
        }
    }

    // Supprimer une image
    if (!empty($_GET['delete_image'])) {
        $chemin = "map/";

        $fichier = (!empty($_GET['id_map_del'])) ? $_GET['id_map_del']: null;

        $ouverture = opendir("map");
        //maintenant que le r�pertoire est ouvert, on le lit :
        $lecture = readdir($ouverture);
        if ($fichier != '') {
            if (file_exists($chemin . $fichier) && $fichier != '') {
                if (unlink($chemin . $fichier))
                    unlink($chemin . $fichier);
            }
        }

        closedir($ouverture);
    }
    echo '</div>';

    echo '<hr />';

    echo '<div>';

    // repertoire d'utilisation , si $min ou $max diff�rents de 0 , c'est qu'on est en ajax , donc on change le chemin'

    $dirname = 'map/';

    if (!file_exists($dirname))
        $dirname = '../map/';

    $dir = opendir($dirname);

    $limit = 1;
    while ($file = readdir($dir)) {
        $id = str_replace(".gif", "", $file);
        if ($file != '.' && $file != '..' && !is_dir($dirname . $file)) {
            $arrayPictures[$id] = $file;
        }
    }

    closedir($dir);

    echo '<table style="margin-left:0px;" cellspacing="0">';
    echo '<tr>';





    if ($min == '')
        $min = count($arrayPictures) - 10;

    if ($max == '')
        $max = count($arrayPictures) - 1;

    ksort($arrayPictures);

    echo '<tr>';
    foreach ($arrayPictures as $id => $pict) {
        if ($id >= $min && $id <= $max)
            echo '<td style="text-align:center;">' . $pict . '</td>';
    }

    echo '</tr>';
    echo '<tr>';
    foreach ($arrayPictures as $id => $pict) {
        if ($id >= $min && $id <= $max)
            echo '<td><img src="map/' . $pict . '" alt="?" style="width:78px;height:46px;" /></td>';
    }
    echo '</tr>';
    echo '<tr>';
    foreach ($arrayPictures as $id => $pict) {
        if ($id >= $min && $id <= $max)
            echo '<td style="text-align:center;"><a href="panneauAdmin.php?category=2&delete_image=1&norefresh=1&id_map_del=' . $pict . '&min=' . $min . '&max=' . $max . '"><img src="pictures/utils/delete.gif" style="border:0px;" alt="X" /></a></td>';
    }
?>
    </tr>

    </table>

    <div style="text-align:right;">
<?php
    $minmin = $min - 10;
    if ($minmin < 0)
        $minmin = 0;
    $minmax = $min + 10;

    $maxmin = $max - 10;
    if ($maxmin < 9)
        $maxmin = 9;

    $maxmax = $max + 10;
 ?>

    <a href="panneauAdmin.php?category=2&delete_image=1&norefresh=1&min=<?php echo $minmin ?>&max=<?php echo $maxmin?>"><< Précédent</a> |
    <a href="panneauAdmin.php?category=2&delete_image=1&norefresh=1&min=<?php echo $minmax ?>&max=<?php echo $maxmax?>"> Suivant >></a>

    </div>

    </div>
   
