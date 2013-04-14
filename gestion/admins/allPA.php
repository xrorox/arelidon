<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server . 'require.php');
?>
<div id="refresh_all_pa">
    <form method="post" id="allPA">
        <label for="PA"> Nombre de PA &agrave; donner </label>
        <input type="text" id="PA" name="PA"/>
        <input type="button" onclick="HTTPPostCall('gestion/page.php?category=35','allPA','refresh_all_pa');" value="ajouter"/>
    </form>


    <?php
    if (!empty($_POST['PA'])) {

        if (admin::grantPaToEveryOne($_POST['PA'])) {
            echo 'Ca a fonctionné.';
        } else {
            echo "Une erreur s'est produite";
        }
    }
    ?>
</div>