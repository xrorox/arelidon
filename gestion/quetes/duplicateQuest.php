<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'require.php');


$quete = new quete($_GET['idquete']);
$quete->duplicateQuest();
?>
