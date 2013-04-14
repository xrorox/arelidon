<?php
if (!isset($_SESSION)) {
    session_start();
    $server = $_SESSION['server'];
}
require_once($server . 'require.php');
require_once($server . 'class/news.class.php');
?>
<div id="div_news">
    <center><form method="post" id="news">
        <input type="text" id="titre" name="title" value="Titre"/><br />
        <textarea name="content" rows="10" cols="50">Contenu</textarea><br />
        <input type="button" onclick="HTTPPostCall('gestion/page.php?category=36','news','div_news');" value="Ajouter"/>
    </form>
	</center>
    <?php
    if (!empty($_POST['content']) && !empty($_POST['title'])) {
        $error = false;

        try {
            news::addNews($_POST['title'], $_POST['content']);
        } catch (Exception $e) {
            echo $e->getMessage();
            $error = true;
        }

        if ($error == false)
            echo 'Ca a marché!';
    }
    else
    {
        echo "Veuillez renseigner le titre et le contenu de la news.";
    }
    ?>
	<hr />
	
<?php
	require_once('../require.php');
	echo '<div id="maintenance">';

	if (isset($_GET['test']) and $_GET['test']==1){
		$sql="UPDATE `maintenance` SET maintenance =".$_GET['maintenance'];	
		loadSqlExecute($sql);
		destroy_cache('maintenance','maintenance');	
	}		
	//Xstoudi say: il sert à quoi le bouton "toto" x)?
	//	$onclick="HTTPTargetCall('gestion/joueurs/maintenance2.php','maintenance')";
	//	echo '<input type="button" onclick='. $onclick.' value="toto"/>';

	if (admin::isInMaintenance()){
		echo 'Le site est en maintenance';
		$onclick="HTTPTargetCall('gestion/page.php?category=34&test=1&maintenance=0','maintenance');";
		echo '<br/><br/> <input type="button" class="button" onclick="'.$onclick.'" value="Sortir de maintenance"/>';		
	}
	else{
		echo 'Le site n\'est pas en maintenance';
		$onclick="HTTPTargetCall('gestion/page.php?category=34&test=1&maintenance=1','maintenance');";
		echo '<br/><br/> <input type="button" class="button" onclick="'.$onclick.'" value="Mettre en maintenance"/>';		
}
echo '</div>';
?>
</div>

