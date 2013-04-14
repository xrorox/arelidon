<?php
if (isset($_GET['idBugReport'])){
	require_once('../../require.php');
echo '<div id="supr">';
bug_report::deleteBugReport($_GET['idBugReport']);

echo'</div>';
}
?>
