<?php
if (!empty($_GET['add'])):

    $cheminImg = "pictures/obstacle/";

    $image = $_FILES['picture']['name'];
    move_uploaded_file($_FILES['picture']['tmp_name'], $cheminImg . $image);

    if (!$_POST['hide'])
        $hide = 0;
    else
        $hide = 1;

    if (!$_POST['bloc'])
        $bloc = 0;
    else
        $bloc = 1;

    obstacle::addObstacle($_POST, $image, $hide, $bloc);

    echo 'L\'insertion a bien été effectuée';
    ?>



<?php else: ?>

    <div style="text-align:center;margin-top:60px;padding-left:280px;">

        <form action="panneauAdmin.php?category=30&add=1" method="post" style="text-align:left;" enctype="multipart/form-data">
            Nom : 
            <input type="text" name="name" /><br /><br />
            Taille : 
            <?php echo getSelectTailleForm(0); ?>
            <br /><br />
            Image : 
            <input type="file" name="picture" /><br /><br />
            map : 
            <input type="text" name="map" size="3" /><br /><br />
            abs : 
            echo '<input type="text" name="abs" size="3" /><br /><br />
            ord : 
            <input type="text" name="ord" size="3" /><br /><br />	
            cach&eacute; : 
            echo '<input type="checkbox" name="hide" value="1" /><br /><br />
            bloque : 
            <input type="checkbox" name="bloc" value="1" checked=checked /><br /><br />
            <div style="margin-left:60px">
                <input type="submit" class="button" value="ajouter" />
            </div>

        </form>
    </div>

<?php endif; ?>