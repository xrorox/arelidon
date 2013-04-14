<?php
/*
 * Created on 10 sept. 2009
 *


 */
 
echo '<div style="text-align:center;">';
	echo '<div style="text-align:left;margin-left:260px;border:solid 1px white;width:250px;">';

	echo '<div style="margin-20px;">';
	echo '<div style="text-align:center;font-weight:700;"> Ajouter une image sur le serveur </div><br />';
	echo '<form method="post" enctype="multipart/form-data" action="panneauAdmin.php?category=24&add=1&norefresh=1">
	 Img : <input type="file" name="fichier" /><br />
	  <div style="text-align:center;"><input type="submit" value="ajouter le fichier" /></div>
	  <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
	</form>';
	echo '</div>';
	echo '<hr />';
	echo '<div>';
	echo '<u><b>Informations :</b></u> <br />';
		echo '<br />';
		echo 'Le nom des images doit être sous la forme [id].gif  (pour l\'objet numéro 145 , mettre dans nom 145.gif)';
	echo '</div>';
	echo '</div>';
	
	
echo '<div style="margin-top:30px;"></div>';	
	
	if($_GET['add'] == 1)
	{
		$chemin = "pictures/item/";
			$fichier = $_FILES['fichier']['name'];
		
		if(file_exists($chemin.$fichier))
		{
			pre_dump_error('ATTENTION : ce fichier existe déjà sur le serveur ');
		}else{
			echo '=> le fichier a bien été inséré';
			move_uploaded_file($_FILES['fichier']['tmp_name'], $chemin.$fichier);
		}
		
	}

echo '</div>';
?>
