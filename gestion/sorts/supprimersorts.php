<?php
require_once('require.php');

if(isset($_GET['id'])){
	
$sql="DELETE FROM `skill` WHERE id=".$id;
loadSqlExecute($sql);
	
	
}
?>
