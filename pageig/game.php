<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'require.php');



if(!empty($_GET['majposition']))
{
	include($server.'pageig/move/move.php');
	$site=$_SERVER['HTTP_HOST']; // test pour savoir si on est en ligne ou en local
	
}

if(!empty($_GET['switch_place']))
{
	include($server.'pageig/map/switch_place.php');
}

		
	
	require_once($server.'require.php');

$char=unserialize($_SESSION['char']);


echo '<span id="bodywaiter"></span>';
echo '<div id="bodygameig">';
	echo '<div id="map_container">';
	echo '<div id="map" style="background-image:url(map/'.map::getImageById($char->getMap()).');width:800px;height:480px;cursor:pointer;">';
		echo '<input type="hidden" class="starwars" name="map" value="'.$char->getMap().'" id="map"/>';
		echo '<div style="display:none;">';
			// pr�chargement des images
			for($i=1;$i<5;$i++)
				echo '<img src="'.$char->getUrlPicture('ico',$i).'" alt="'.$char->getFactionName().'" />';
		echo '</div>';
		echo '<div style="display:none;"><input type="text" id="onmap" value="1" /></div>';
		echo '<div id="maj_map_char" style="display:none;"></div>';
		
		// div contenant toutes les infos
		
			if($char->isInDonjon())
			{
				echo '<div id="inDonjon" style="display:none;">1</div>';
				echo '<div id="map_container_event">';
				require_once($server.'pageig/map/eventOnMapDonjon.php');
			}else
			{
				echo '<div id="inDonjon" style="display:none;">0</div>';
				echo '<div id="map_container_event">';
				require_once($server.'pageig/map/eventOnMap.php');
			}
		echo '</div>';

		
		
		// Chargement des fl�ches permettant de se d�placer
		
                
		// Si d�placement � souris ou les deux ou si 0 (c\'est � dire par d�faut)
		$array_regulating = $char->loadRegulating();
		if($array_regulating['1'] == 2 or $array_regulating['1'] == 3 or $array_regulating['1'] == 0 or $array_regulating['1'] == 1) 
		{	
			$casechar = $char->getOrd() * 25 + $char->getAbs();
		
			$array_fleche = array('bas'=>'25','gauche'=>'-1','haut'=>'-25','droite'=>'1','basdroite'=>'26','basgauche'=>'24','hautdroit'=>'-24','hautgauche'=>'-26');
		
			$width='32';
			$height='32';	
		
			// Compteur d�finie le mouvement selon la fonction javascript move(typemove)
			$compteur = 1;
			
			foreach($array_fleche as $fleche=>$case_addition)
			{
				
				$ratio_ord = 1;
				$ratio_abs = 1;
				// Ratio de l'ordonn�e (pour g�rer la taille du personnage)
				switch($compteur)
				{
					// bas
					case 1 :
						
						$array_cord['abs'] = $char->getAbs() + 0;
						$array_cord['ord'] = $char->getOrd() + 1;
					break;
					case 2 :
						
						$array_cord['abs'] = $char->getAbs() - 1;
						$array_cord['ord'] = $char->getOrd() + 0;
					break;
					case 3 :
						
						$array_cord['abs'] = $char->getAbs() + 0;
						$array_cord['ord'] = $char->getOrd() - 1;
					break;
					case 4 :
						
						$array_cord['abs'] = $char->getAbs() + 1;
						$array_cord['ord'] = $char->getOrd() + 0;
					break;
					
					case 5 :
						
						$array_cord['abs'] = $char->getAbs() + 1;
						$array_cord['ord'] = $char->getOrd() + 1;
					break;
					
					case 6 :
					
						$array_cord['abs'] = $char->getAbs() - 1;
						$array_cord['ord'] = $char->getOrd() + 1;
					break;
					
					case 7 :
						
						$array_cord['abs'] = $char->getAbs() + 1;
						$array_cord['ord'] = $char->getOrd() - 1;
					break;
					
					case 8 :
						$array_cord['abs'] = $char->getAbs() - 1;
						$array_cord['ord'] = $char->getOrd() - 1;
					break;
				}
				
				$case_calcul = $casechar + $case_addition;
				$case = $case_calcul - 25;
				
				
				
				
                                
				if(!isset($arrayCase[$array_cord['ord']][$array_cord['abs']]))
				{
					$display = "block";
				}else{
					$display = "none";
				}
                                $array_cord['abs'] += -1;
				$array_cord['ord'] += -1;
				
				// choix de l'affichage selon le param�tre (fl�che ou carr� gris)
				
				if($array_regulating['3'] == 1)
				{
					$url_picture = 'pictures/fleche/'.$compteur.'.gif';
					
					$persoMarginLeft = ($array_cord['abs'] - $ratio_abs) * 32;
					$persoMarginTop = ($array_cord['ord'] - $ratio_ord) * 32;
					
				}else{
					$url_picture = 'pictures/utils/case_dep.png';
					
					
					$persoMarginLeft = ($array_cord['abs']) * 32;
					$persoMarginTop = ($array_cord['ord'] ) * 32;	
					
					if($array_cord['abs'] < 0 or $array_cord['abs'] > 25)
						$display = "none";
								
				}
				
				
				
				
				$onclick="move(".$compteur.");";
					echo '<div id="fleche_'.$compteur.'" ' .
							'onclick="'.$onclick.'" ' .
							'style="' .
								'position:absolute;' .
								'float:left;' .
								'margin-left:'.$persoMarginLeft.'px;' .
								'margin-top:'.$persoMarginTop.'px;' .
								'background-image:url('.$url_picture.');' .
								'height:'.$height.'px;' .
								'width:'.$width.'px;' .
								'cursor:pointer;' .
								'display:'.$display.';' .
								'z-index:1;"
							>';
					echo '</div>';	
				$compte++;
				$compteur++;
			
			}		
		}
		
		
		
		// Affichage du personnage	
		$persoMarginTop = ($char->getOrd() - 1) * 32 - 16;
		$persoMarginLeft = ($char->getAbs() - 1) * 32;
                if(isset($_GET['face']))
                    $face = $_GET['face'];
                else
                    $face=0;
                    
		if($face == 0)
			$face = 1;
		
		if($char->getLife() > 0)
			$image = $char->getClasse().'-0-'.$face.'.gif';
		else
			$image = 'die-'.$char->getClasse();
		
                
                if(!isset($distance))
                    $distance=0;
                
		echo '<div id="perso_container_div">';
		$onclick =  "loadObject('player','$distance','".$char->getId()."');";
		echo '<div id="perso" onclick="'.$onclick.'" style="position:absolute;float:left;margin-left:'.$persoMarginLeft.'px;margin-top:'.$persoMarginTop.'px;background-image:url('.$char->getUrlPicture('ico',$face).');height:48px;width:32px;z-index:128;">';
		echo '</div>';
		
		echo '<div id="perso_id" style="display:none;">'.$char->getId().'</div>';
		echo '<div id="perso_classe" style="display:none;">'.$char->getClasse().'</div>';
		echo '<div id="perso_gender" style="display:none;">'.$char->getGender().'</div>';
		echo '<div id="perso_skin" style="display:none;">'.$char->getSkin().'</div>';
		echo '<div id="map_id" style="display:none;">'.$char->getMap().'</div>';
                echo '<div id="fatigue" style="display:none;">'.$char->getFatigue().'</div>';
		echo '</div>';
		
	echo '</div>';
	echo '</div>';
	
	echo '<hr style="margin-top:0px;" />';
	
	echo '<div id="group" style="margin-top:-8px;">';
		
		
			require_once($server.'pageig/group/show.php');
		
	echo '</div>';
	
	?>
	<div style="text-align:left;margin-top:15px;margin-left:20px;font-size:28px;text-align:center;">  
		
		<a href="ingame.php?page=help"> Aide du jeu </a>
		| 
		<a href="ingame.php?page=allopass"> Allopass </a>
		|
		<a href="http://royaume-arelidon.forumactif.net/index.htm" target="blank">Forum</a>
		|
		<a href="ingame.php?page=sponsor"> Parrainage </a>
		|
		<a href="ingame.php?page=moncompte"> Mon Compte </a>
		
	</div>
 </div>

