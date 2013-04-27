<?php

if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'require.php');


$sql ="SELECT count(*) as count FROM `char` WHERE `name` = '".$_GET['name']."'";
$free = loadSqlResultArray($sql); // 1 = no , 0 = yes


if ($free['count'] == 0 && strlen($_GET['name']) <= 16) 
{
	echo getPict(true,'login',1);
}
else 
{
	echo getPict(false,'login',1);
}?>

<input type="hidden" value="<?php echo $free['count'] ?>" id="login_free" />