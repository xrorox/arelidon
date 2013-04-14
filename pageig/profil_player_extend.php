
<?php 
require_once($server.'class/classe.class.php');

require_once($server.'class/faction.class.php');
$char = new char($_GET['showed_id']);
$guild = new guild($char->getGuildId());
$faction = faction::getFactionText($char->getFaction());
?>

<table border="1" style="width:600px;margin:auto;" class="backgroundBody">
	
	
	<tr colspan="6" style="backgroundMenu">
		
		
		<td colspan="6" rowspan="1" style="width:450px;padding-left:40px;" class="backgroundMenuNoRadius">
			+ Infos
		</td>
		
	
	</tr>
	
	<tr>
		<td colspan="2" rowspan="1" style="width:150px;">
			<div style="">
				<?php getAvatar($char,"margin-left:30px;border:solid 1px grey;background-color:black;") ?>
			</div>
		</td>
		<td colspan="4" rowspan="1" style="height:200px;width:350px;">
			<div>
				<div style="margin-left:30px;">
					Pseudo : <?php echo $char->getName(); ?><br /><br />
					Faction : <?php echo '<img src="pictures/faction/'.$char->getFaction().'-24.png" alt="erreur" /> '.$faction; ?><br /><br />
					Classe : <?php echo char::getClasseNameById($char->getClasse()); ?> <br /><br />
					Niveau : <?php echo $char->getLevel(); ?> <br /><br />
					Honneur : <?php echo $char->getHonnor(); ?><br /><br />
				</div>
		
			<hr />
				<div style="margin-left:30px;">
					Clan : <?php echo $guild->getName(); ?> <br /><br />
					Niveau du clan : <?php echo $guild->getLevel(); ?> <br /><br />
				</div>
			
			
			</div>
		</td>
	
	</tr>
	
	<tr>
	
		<td colspan="6" rowspan="1" style="height:20px;padding-left:40px;" class="backgroundMenuNoRadius">
			+ Equipements
		</td>
	</tr>
	
	<tr>
	
		<td colspan="6" rowspan="1" style="height:20px;margin:auto;padding-left:180px;">
			<?php
				echo '<div style="float:left;margin-left:30px;width:140px;height:230px;border:solid 1px grey;background-image:url(\'pictures/utils/ombre.gif\');background-color:white;">';

						// Equipement

						$arrayEquip = getBodyPartList();

						//$arrayEquip = array('1'=>'hand');

						// Equip correspond a l'emplacement (main,tete,etc ...)

						foreach($arrayEquip as $equip)

						{

							$style = getEquipShowStyle($equip,false);	

							$place_name = getEquipName($equip);			

							$spanstyle= "width:150px;";

							$iditem = item::getEquipement($char->getId(),$equip);

							if($iditem != 0)

							{

								$item = new item($iditem);

								$url = "pictures/item/".$item->item.".gif";

								$text = $item->getBonus();

								echo '<div style="'.$style.';width:32px;height:32px;background-image:url(pictures/utils/cadre32x32.png);padding-top:2px;">';

									echo '<div style="height:2px;"></div>';

									imgWithTooltip($url,$text,'','','margin-left:5px;',$spanstyle);

								echo '</div>';

							}else{

								echo '<div style="'.$style.';width:32px;height:32px;">';

									echo '<img src="pictures/utils/cadre32x32.png" alt="" title="'.$place_name.'" />';

								echo '</div>';

							}

				

						}

							

				echo '</div>';
			
			?>
		</td>
	</tr>


</table>