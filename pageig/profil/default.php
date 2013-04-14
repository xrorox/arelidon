<?php
/*
 * Created on 4 sept. 2009
 *


 */

$action = $_GET['action'];
require_once($server.'class/effect.class.php');
require_once($server.'class/guild.class.php');
require_once($server.'widgets/IrelionContainer.class.php');

$char=unserialize($_SESSION['char']);
switch($action)
{
	case 'update':
		$caract = $_GET['caract'];
		$char->updateCaract($caract,'1');
	break;
}

?>

<?php IrelionContainer::echoBefore("profil_container"); ?>
	<table cellspacing="0" cellpadding="0">
		<tr >
			<td style="border-bottom: solid 1px grey;">
				<?php require_once("sub_panel/info_level.inc.php"); ?>
			</td>
			<td style="border-bottom: solid 1px grey;">
				<?php require_once("sub_panel/info_faction.inc.php"); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php require_once("sub_panel/caract.inc.php"); ?>
			</td>
			<td>
				<?php require_once("sub_panel/info_caract.inc.php"); ?>
			</td>
		</tr>
	</table>
<?php IrelionContainer::echoAfter(); ?>



<?php

echo '<div style="margin-left: 310px; font-size: 18px;margin-top:30px;">';

if($user->isAdmin())
{
	echo '<a href="panneauAdmin.php">';
	echo '=> Acc&egrave;der au panneau d\'administration ';
	echo '</a><br />';	
}

echo '</div>';
?>
