<?php
/*
 * Created on 15 sept. 2009
 *


 */
  
$type = $_GET['type'];

switch($type)
{
	case 'map':
		
		foreach($_POST as $post)
		{
			echo ' num '.$post;
		}
		
	break;
	
	
}
 
 
 
 
?>
