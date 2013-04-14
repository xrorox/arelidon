<?php
/*
 * Created on 17 sept. 2009
 *
 *  Affichage du tchat selon le canal 
 */
 
if(!empty($_GET['refreshtchat']))
{
    if(!isset($_SESSION))
    {
        session_start();
        $server = $_SESSION['server'];
    }

require_once($server.'require.php');
	require_once('../class/tchat.class.php');

	
	$user = $_SESSION['user'];
	
	$char = unserialize($_SESSION['char']);	
}


if(empty($zoom) && isset($_GET['zoom']))
	$zoom = $_GET['zoom'];
    else {
    $zoom=0;
}
if($zoom == 1)
{
	$max = 18;
	$div = "miniTchatContainerZoom";
	$style="min-height";
}	
else
{
	$max = 10;
	$div = "miniTchatContainer";
	$style="height";
}
	
	if ($char->isMute()){
	echo '<input type="hidden" id="mute" name="mute" value="1"/>';
}	
else{
	echo '<input type="hidden" id="mute" name="mute" value="0"/>';
}
	
$height=70;
$width=200;
 echo '<div id="'.$div.'" class="'.$div.'" style="'.$style.':'.$height.'px;width:'.$width.'px;">';
 
 	$tchat = new tchat();
 	
 	$tchat->loadLastMessages($char,$max,$tchat->getCharParameter($char->getId()));
 	
 	$array_smiley = getSmileyArray();
 	$tchat->printMessagesList($array_smiley);
 	
 echo '</div>';
 

?>
