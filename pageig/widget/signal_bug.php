<?php
require_once('../../require.php');
		
		$user = new user;
		$user->loadUser($login);
		
		$char = new char;
		$char->loadChar($idchar);

require_once('../../deb.inc.php');

$location_prefix = '../../';
include('../../css/allcss.php'); ?>
<?php include('../../js/alljs.php');

 ?>


</head>
<body style="background-image:url('../../css/design/fond-menu.png');">
 
 
<?php
if($_GET['add'] == 1)
{
	$bug_report = new bug_report();
	$file = $_FILES['file_name'];
	
	if($file['size'] <= 1000000)
	{
		
		$bug_report->setType($_POST['type_bug']);
		$bug_report->setComment($_POST['comment']);
		$last_id_more = $bug_report->getLastId() + 1;
		$file_name = 'report_'.$last_id_more;
		$bug_report->setFile($file_name);
		
		$chemin = 'bug_report/';
		if(file_exists($chemin))
			move_uploaded_file($_FILES['file_name']['tmp_name'], $chemin.$file_name);
		elseif(file_exists('../../'.$chemin))
			move_uploaded_file($_FILES['file_name']['tmp_name'], '../../'.$chemin.$file_name);
		else
			move_uploaded_file($_FILES['file_name']['tmp_name'], '../'.$chemin.$file_name);
		
		$bug_report->save($char);
		
		printConfirm('La demande a bien &eacute;t&eacute; envoy&eacute;e. Merci de votre contribution dans le d&eacute;veloppement du jeu.');
		
	}else{
		printAlert('Vous ne pouvez pas ins&eacute;rer un fichier de plus de 2 Mo.');
	}
	
	
	
}else{
	echo '<div style="text-align:center;font-size:16px;font-weight:700;"> Signaler un bug </div>';
	echo '<hr />';
	
	echo '<form action="signal_bug.php?add=1" method="post" ENCTYPE="multipart/form-data">';
		echo '<div style="font-weight:700;">';
		
			echo ' Type de bug : <br />';
			echo '<div style="padding-left:15px;margin-top:3px;">';
					
				echo '<select name="type_bug">';
					echo '<option value="1"> Bug d affichage </option>';
					echo '<option value="2"> Probl&egrave;me du jeu </option>';
					echo '<option value="3"> Faute d\'ortographe </option>';
					echo '<option value="4"> Autre </option>';
				echo '</select>'; 
					
			echo '</div>';
			
			echo 'Commentaire :';
			echo '<div style="margin-top:5px;margin-left:10px;">';
				echo '<textarea name="comment" style="width:300px;height:150px;">';
					
				
				echo '</textarea>';
			echo '</div>';
			
			echo '<div style="margin-top:3px;">';
				echo 'Joindre un fichier screenshot ou page html (facultatif) <br />';
				echo '<div style="padding-left:15px;">';
					//echo '<INPUT type="hidden" name="MAX_FILE_SIZE"  VALUE="1000000">';
					echo '<input type="file" name="file_name" />';
				echo '</div>';
			echo '</div>';
		
			echo '<div style="text-align:left;padding-left:200px;margin-top:2px;">';
				echo '<input class="button" type="submit"  value="envoyer" />';
			echo '</div>';
		
		echo '</div>';
	echo '</form>';
	
}
?>

</body>
</html>
