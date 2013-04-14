<?php
/*
 * Created on 15 avr. 2010
 */
 
 require_once('../../require.php');
 
 $guild = new guild($_GET['guild_id']);
 $guild->update('description',$_POST['description']);
 
?>
