<?php
/*
 * Created on 10 sept. 2009
 *


 */
 
echo '<div style="text-align:center;">';
	echo '<div style="text-align:left;margin-left:260px;border:solid 1px white;width:250px;">';

	echo '<div style="margin-20px;">';
	echo '<div style="text-align:center;font-weight:700;"> Ajouter une image sur le serveur </div><br />';
	echo '<form method="post" enctype="multipart/form-data" action="panneauAdmin.php?category=4&add=1&norefresh=1">';
	echo ' Img : <input type="file" name="fichier" /><br />';
	echo '<label for="type"> Type d\'image : </label';
	echo'<select name="type" id="type">';
		echo '<option value="0"> monstres</option>';
		echo '<option value="1"> items</option>';
		echo '<option value="2"> pnj_face</option>';
		echo '<option value="3"> pnj</option>';
	echo '</select>';
	 echo ' <div style="text-align:center;"><input type="submit" value="ajouter le fichier" /></div>';
	echo '</form>';
	echo '</div>';
	echo '<hr />';
	echo '<div>';
	echo '<u><b>Informations :</b></u> <br />';
		echo '<br />';
		echo 'Le nom des images doit être sous la forme [id].gif  (pour le monstre numéro 145 , mettre dans nom 145.gif)';
	echo '</div>';
	echo '</div>';
	
	
echo '<div style="margin-top:30px;"></div>';	
	
	if($_GET['add'] == 1)
	{	
		switch($_GET['type']){
			case 0:
				$chemin = "pictures/monster/";
			break;
			case 1:
				$chemin ="pictures/item";
			break;
			case 2:
				$chemin ="pictures/face";
			break;
			case 3:
				$chemin ="pictures/pnj";
			break;
		}
		
		$fichier = strtolower($_FILES['fichier']['name']);
		if(file_exists($chemin.$fichier))
		{
			pre_dump_error('Ce fichier existait d&eacute;j&agrave; sur le serveur, il a donc &eacute;t&eacute; remplac&eacute;. ');
			move_uploaded_file($_FILES['fichier']['tmp_name'], $chemin.$fichier);
		}else{
			echo '=> le fichier a bien été inséré';
			move_uploaded_file($_FILES['fichier']['tmp_name'], $chemin.$fichier);
		}
		
	}

echo '</div>';
?>
