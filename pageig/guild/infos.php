<?php
require($server."class/guild.class.php");

echo '<div id="toto">';
$guild = new guild($char->getGuildId()); 
 
 if (isset($_POST['forum'])){
	$guild= new guild($_GET['char']);
	$sql="UPDATE `guild` SET forum='".$_POST['forum']."' WHERE id=".$guild->getId();
	
	loadSqlExecute($sql);
	
}
echo '<div style="margin-top:30px;">'; 
	echo '<div style="float:left;margin-left:20px;width:400px;font-weight:700;">';
		echo '<div style="margin:auto;width:300px;">';
		echo '<fieldset style="width:300px;"><legend style="padding-left:0px;"> Infos g&eacute;n&eacute;rales </legend>';
			echo '<div> Nom : '.$guild->getName().'</div>';	
			echo '<div> Niveau : '.$guild->getLevel().'</div>';		
			echo '<div> Date de cr&eacute;ation : ';
				$str = timestampToDate($guild->getDateCreation(),'/');
				echo $str;
			echo '</div>';
			
		echo '</fieldset>';

		echo '<fieldset style="margin-top:20px;padding-left:10px;width:300px;"><legend style="padding-left:0px;"> Membres </legend>';
			echo '<div> Meneur : '.char::getNameById($guild->getMeneur()).'</div>';
			echo '<div> Lieutenant : ';
				$nb_lord = $guild->countLord();
				echo $nb_lord;
			echo '</div>';
			echo '<div> Soldat : ';
				$nb_soldier = $guild->countPaysan();
				echo $nb_soldier;
			echo '</div>';
		echo '</fieldset>';		
	
		echo '<fieldset style="margin-top:20px;padding-left:10px;width:300px;"><legend style="padding-left:0px;"> Gestion </legend>';
			echo '<div> Tr&eacute;sorie : '.$guild->getGold().' ';
				 getGoldPict();
			echo '</div>';
			echo '<div> Lien du forum : '.$guild->getForum();
			if ($char->isMeneur()){
				echo '<form method="post" id="toto">';
					echo '<input type="text" name="forum"/>';
					$onclick="HTTPPostCall('page.php?page=page&category=guilde&char=".$char->getId()."','toto','bodygameig');";
					echo '<input type="submit" value="Mettre un forum" onclick="'.$onclick.'"/>';
				echo '</form>';
				
			}
			echo '</div>';
		echo '</fieldset>';			
		
		echo '<fieldset style="margin-top:20px;padding-left:10px;width:300px;"><legend style="padding-left:0px;"> Faire un don </legend>';
			echo '<div id="div_confirm_donation" style="display:block;"></div>';
			echo '<form id="donation" method="POST">';
			echo '<div>';
				echo 'Faire don de : <input name="donation" type="text" size="2" /> ';
				getGoldPict();
				$onclick="HTTPPostCall('pageig/guild/donation.php?guild_id=".$guild->getId()."','donation','div_confirm_donation');HTTPTargetCall('page.php?category=guilde','bodygameig');refreshInfos();";
				echo ' <input class="button" onclick="'.$onclick.'" style="margin-left:5px;" type="button" value="Offrir" />';
			echo '</div>';
			echo '</form>';
		echo '</fieldset>';	
		
		echo '</div>';

	
		echo '</div>';
	
	echo '</div>';
	
	
	
	// Menu de droite
	echo '<div id="div_modif_description" style="display:none;"></div>';
	
	echo '<div style="float:left;margin-left:40px;padding-left:10px;text-align:center;width:300px;">';
		echo '<div> Description </div><br />';
		echo '<form id="descriptionGuild" method="POST">';
		echo '<div>';
			
			echo '<textarea name="description" style="width:300px;height:300px;background-color:white;">';
				echo $guild->getDescription();
			echo '</textarea>';
		echo '</div>';
		
		if($char->isMeneur())
		{
			echo '<div id="buttonModifDescription" style="text-align:right;width:300px;">';
				$onclick="HTTPPostCall('pageig/guild/modification.php?guild_id=".$guild->getId()."&modif=description','descriptionGuild','div_modif_description');";
				echo ' <input class="button" onclick="'.$onclick.'" style="margin-left:5px;margin-right:20px;" type="button" value="Modifier" />';
			echo '</div>';			
		}
		echo '</form>';
	echo '</div>';

		if($char->ismeneur()){
				$onclick="if(confirm('Voulez vous dissoudre la guilde ?')){HTTPTargetCall('pageig/guild/delete_guild.php?guild_id=".$guild->getId()."','delete_guild');};";
				echo "<div id='delete_guild'";
				echo ' <input class="button" onclick="'.$onclick.'"  type="button" value="Dissoudre la guilde" />';
				echo "</div>";
		}
		else{
				$onclick="if(confirm('Voulez vous quitter la guilde ?')){HTTPTargetCall('pageig/guild/quit_guild.php?char_id=".$char->getId()."','quit_guild');};";
				echo "<div id='quit_guild'";
				echo ' <input class="button" type="button" value="Quitter la guilde" onclick="'.$onclick.'"/>';
				echo "</div>";
			
		}
		
		
	// Fin menu gauche	
	
	echo '<fieldset style="margin-top:20px;padding-left:10px;width:300px;margin-left:72px;"><legend style="padding-left:0px;font-weight:700;"> Image de guilde </legend>';
	echo '<div>';
			echo $guild->get_guild_picture();
	echo "</div>";
	echo '</fieldset>';
	
	if($char->ismeneur()){
		echo '<fieldset style="margin-top:20px;padding-left:10px;width:300px;margin-left:72px"><legend style="padding-left:0px;font-weight:700;"> Modifier image de guilde :</legend>';
		echo '<div id="ajout_image2" style="font-weight:700;">';
		echo '<form method="post" enctype="multipart/form-data" id="ajout_image" action="ingame.php?page=page&category=guilde&ajout_image=1">';
		echo '<label for="fichier"> Image en 120x120px .gif ou .jpg : </label> <input type="file" id="fichier" name="fichier1" />';
		//$url = "page.php?category=guilde&ajout_image=1";
			//$onclick = "HTTPPostCall('$url','ajout_image','bodygameig');";
		echo  '<input class="button" type="submit" value="ajouter" />';
		echo '</form>';
		//onclick="'.$onclick.'"
		echo '</div>';
		
		echo '</fieldset>';
		if(!empty($_GET['ajout_image'])){
			$guild->delete_guild_pictures($guild->getId());
			$chemin = "pictures/guilde/";
			$fichier = $_FILES['fichier1']["name"];
			$extension = strrchr($fichier, ".") ;
			
			
			$new_name_fichier= $guild->getId().$extension;
			$size= $_FILES['fichier1']["size"];
			
			
			
			if($guild->isGuildPictureValid($extension,$size)){
			
				$toto=move_uploaded_file($_FILES['fichier1']['tmp_name'], $chemin.$new_name_fichier);
			}
		
		}	
	}else{
		echo '<br /><br />';
	}
	
	
	
echo '</div>';

echo '<div style="height:20px;"></div>';

echo '<hr />';
	echo '<div style="padding-left:15px;"><b> Condition pour le prochain niveau </b></div>';
echo '<hr />';	

echo '<div style="margin-top:10px;margin-left:60px;font-weight:700;margin-right:30px;">';
	echo '<div style="float:left;">';
	
	$nb_member = $guild->getMembersNumber();
	$nb_member_max = $guild->getMaxMembers();
	if($nb_member == $nb_member_max)
		$condition['1'] = 'mini-valid_s2';
	else
		$condition['1'] = 'mini-no_2';
	
	$nb_jour = $guild->getNbDays();
	$nb_jour_max = $guild->getNbDaysToLevelUp();
	
	if($nb_jour > $nb_jour_max)
		$nb_jour = $nb_jour_max;
	
	if($nb_jour >= $nb_jour_max)
		$condition['2'] = 'mini-valid_s2';
	else
		$condition['2'] = 'mini-no_2';
		
	$nb_gold = $guild->getGold();
	$nb_gold_max = $guild->getGoldToLevelUp() ;
	
	if($nb_gold > $nb_gold_max)
		$nb_gold = $nb_gold_max;
	
	if($nb_gold >= $nb_gold_max)
		$condition['3'] = 'mini-valid_s2';
	else
		$condition['3'] = 'mini-no_2';
		
	echo '<div style="height:20px;"> Nombre de membres : '.$nb_member.'/'.$nb_member_max.' </div>';
	echo '<div style="height:20px;"> Dur&eacute;e : '.$nb_jour.'/'.$nb_jour_max.' jours</div>';
	echo '<div style="height:20px;"> Tr&eacute;sorerie : '.$nb_gold.'/'.$nb_gold_max.' </div>';
	echo '</div>';
	echo '<div style="float:left;width:50px;height:70px;">&nbsp;</div>';
	echo '<div style="margin-left:30px;">';
		for($i=1;$i<=3;$i++)
		{
			if($condition[$i] == 'mini-valid_s2')
				$alt = 'Condition valid&eacute;e';
			else
				$alt = 'Condition non valid&eacute;e';
			echo '<div style="height:20px;"> <img style="height:16px;width:16px;" src="pictures/utils/'.$condition[$i].'.gif" title="'.$alt.'" title="'.$alt.'" /> </div>';
		}		
	echo '</div>';
echo '</div>';




echo '<div style="height:15px;"></div>';
echo '</div>';
?>
