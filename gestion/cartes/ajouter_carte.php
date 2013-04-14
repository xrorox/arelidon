<?php

 echo '<div id="formulaire">';
	if(!empty($_GET['del_map']) && !empty($_POST['mapid']) && is_int($_POST['mapid'])){
            
                $map = new Map($_POST['mapid']);
                $map->delete();
	
		echo 'map supprimée';
	}
	if(!empty($_GET['add']))
	{
		$chemin = "map/";
		if(!file_exists($chemin))
			$chemin = "../map/";
				
		$fichier = $_FILES['fichier']['name'];
		
		if(file_exists($chemin.$fichier))
		{
			pre_dump_error('ATTENTION : ce fichier existe déjà sur le serveur ');
		}else{
			move_uploaded_file($_FILES['fichier']['tmp_name'], $chemin.$fichier);
		}
		
		$map = new map();
		$map->add($fichier,$_POST['abs'],$_POST['ord'],$_POST['alt'],$_POST['continent']);
		$str = 'Vous avez bien ajouté la carte';
	}
	
	if(!empty($_GET['addCont']))
	{
		$map = new map();
		$map->addContinent($_POST['name'],$_POST['abs'],$_POST['ord'],$_POST['alt']);
		$str = 'Vous venez d\'ajouter le continent : '.$_POST['name'];
	} 
 
?>
<div style="text-align:center;">
	<div style="text-align:left;margin-left:260px;border:solid 1px white;width:250px;">

	<div style="margin:20px;">
	<div style="text-align:center;font-weight:700;"> Ajouter une carte </div><br />
	<form method="post" enctype="multipart/form-data" action="panneauAdmin.php?category=1&add=1&norefresh=1">
	 Img : <input type="file" name="fichier" /><br />
	 
	 Continent : <select name="continent">';
             
             <?php
	 	$arrayMap = map::getAllContinents();
	 	foreach($arrayMap as $mapy)
	 	{
	 		echo '<option value="'.$mapy['id'].'">'.$mapy['name'].'</option>';
	 	}
                
               ?>
	 </select><br />
	 
	 abs : <input type="text" name="abs" size="3" value="<?php echo (!empty($_GET['preabs']))?$_GET['preabs'] : ''?>" /><br />
	 ord : <input type="text" name="ord" size="3" value="<?php echo (!empty($_GET['preord']))?$_GET['preord'] : ''?>" /><br />
	 &nbsp;&nbsp;alt : <input type="text" name="alt" size="3" value="<?php echo (!empty($_GET['prealt']))?$_GET['prealt'] : ''?>" />
	 <div style="text-align:center;"><input type="submit" class="button" value="ajouter cette carte" /></div>
	  <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
	</form>
	</div>

	</div>
<hr />
	<div style="text-align:left;margin-left:260px;border:solid 1px white;width:250px;">
<div style="margin:20px;">
	<div style="text-align:center;font-weight:700;"> Ajouter un continent </div><br />
	
	<form method="post" action="panneauAdmin.php?category=1&addCont=1&norefresh=1">
	 &nbsp;&nbsp;&nbsp;&nbsp;Nom : <input type="text" name="name" size="15" /><br />
	 Ref abs : <input type="text" name="abs" size="3" /><br />
	 Ref ord : <input type="text" name="ord" size="3" /><br />
	 &nbsp;&nbsp;Ref alt : <input type="text" name="alt" size="3" />
	 <div style="text-align:center;"><input type="submit" class="button" value="ajouter ce continent" /></div>
	  <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
	</form>
	</div>

	</div>
</div>
	
<div style="margin-top:30px;"></div>	

</div>

<fieldset>
	<legend> Supprimmer une carte </legend>
		<form id="sup_map">
			<label for="del_map"> numéro de la carte </label>
			<input type="text" id="del_map" name="mapid"/>
			<input type="button" value="supprimer" onclick="HTTPPostCall('gestion/page.php?category=1&del_map=1','sup_map','formulaire');" />
			
			</div>