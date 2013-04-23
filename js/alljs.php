

<?php 
// S�lection des keyevents selon les param�tres utilisateurs
/*
	$char=$_SESSION['char'];
	$array_regulating = $char->loadRegulating();

	if($array_regulating['1'] == 1 or $array_regulating['1'] == 3 or $array_regulating['1'] == 0 )
	{
		switch($array_regulating['2'])
		{

			case 2 :
				?>
				
				<?php
			break;
			case 3 :
				?>
				<script type="text/javascript" src="js/move/key-event-qwerty-1.5.js"></script>
				<?php
			break;
			default:
				?>
				<script type="text/javascript" src="js/move/key-event-arrow-1.5.js"></script>
				<?php
			break;
			
		}
	}
*/

	?>

<script type="text/javascript" src="js/jquery/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery/jquery-ui-1.8.16.custom.min.js"></script>

<script type="text/javascript" src="js/jquery/fieldexp.js"></script>
<script type="text/javascript" src="js/jquery/jquery.autocomplete.js"></script>
<script type="text/javascript" src="js/jquery/script.js"></script>

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/fonctiondebase-1.1.4.js"></script>


<script type="text/javascript" src="js/form-1.0.js"></script>

<script type="text/javascript" src="js/move-2.4.2.js"></script>
<script type="text/javascript" src="js/move/key-event-azerty-1.5.js"></script>
<script type="text/javascript" src="js/registration-1.0.js"></script>




<script type="text/javascript" src="js/ingame.js"></script>



<?php 
if(isset($frame)){
	if($frame != 'yes')
	{
		echo '<script type="text/javascript">';
			echo 'autoRefresh();';
		echo '</script>';
	}
}
?>

