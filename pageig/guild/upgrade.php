<?php
require_once("../../require.php");
$rank =$_GET['rank'] - 1;
$sql="UPDATE `char` SET guild_rank=".$rank." WHERE id=".$_GET['id'];
loadSqlExecute($sql);

$char =new char($_GET['id']);
$guild= new guild($char->getGuildId());
$guild->addActivity($_GET['id'],4,0);
?>
