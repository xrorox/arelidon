<?php

if(isset($_GET['part']))
	$part = $_GET['part'];
else
	$part = 1;

switch($part)
{
	case 2 :
		$picture_url = "pictures/preview/preview2.png";
		$txt = "Toutes les actions que tu feras auront une incidence sur la vie de ton personnage.<br /><br /> Tu pourras monter ses caract&eacute;ristiques comme tu le souhaites, ou encore exercer les m&eacute;tiers que tu souhaites.";
	break;
	
	case 3 :
		$picture_url = "pictures/preview/preview3.png";
		$txt = "De multiples qu&ecirc;tes sont pr&eacute;sentes dans ce grand royaume.<br /><br /> Vous devrez tuer des monstres, ramener des objets, parler aux paysans, d&eacute;couvrir des grottes cach&eacute;es,fouiller un chateau, donnez &agrave; manger au peuple et encore plein d'autres choses.";
	break;
	
	case 4 :
		$picture_url = "pictures/preview/preview4.png";
		$txt = "Le royaume est tr&egrave;s riche en ressource et poss&egrave;de de nombreux objets.<br /><br /> Partez &agrave; la conqu&ecirc;te de l'&eacute;quipement supr&egrave;me afin de terasser vos ennemis. <br /><br /> Certains objets se fabrique, d'autres se trouvent en tuant des monstres.";
	break;
	
	case 5 :
		$picture_url = "pictures/preview/preview5.png";
		$txt = "Les combats sont &agrave; la fois tr&egrave;s simple et tr&egrave;s sophistiqu&eacute;s.<br /><br /> L'interface permet une compr&eacute;hension rapide mais la multitude de sorts permet de nombreuses combinaisons.";
	break;
	
	default:
		$picture_url = "pictures/preview/preview1.png";
		$txt = "Tu t'appr&ecirc;tes &agrave; entrer sur les terres du Royaume d'ar&eacute;lidon. Un monde rempli de magie et de myst&egrave;res. Son cot&eacute; mystique est aussi attirant qu'effrayant.<br /><br />Que tu sois guerrier, archer, mage ou encore pr&ecirc;tre, choisis le prince que tu soutiendras et rejoins la bataille. ";
	break;
}
 
 
?> 
<div style="">
	<div style="text-align:center;">
            <?php
		for($i=1;$i<=5;$i++)
		{
			$onclick="hide('bodypreview');HTTPTargetCall('include/bodypreview.php?part=".$i."','bodypreview');show('bodypreview');";
			?> <a onclick="<?php echo $onclick ?> " style="cursor:pointer;"><?php echo $i ?></a>
                        <?php 
                            if($i<5) echo ' | ';
                        
		}
                ?>
	</div><br />
	<img src="<?php echo $picture_url?>" alt="Royaume d arelidon un monde de magie" title="Royaume d arelidon un monde de magie" class="img-body-preview" />
</div>
