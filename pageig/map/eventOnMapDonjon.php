<?php

/** Commentaire sur la gestion des calques sur le jeu 
 * 
 * Z-index : importance des filtres 
 * 
 * 1 : personnage
 * 
 * 2 : pnj
 * 
 * 3 : autres joueurs (pour qu'il se place devant le monstre)
 * 
 * 4 : monstres
 * 
 * 5 : obstacles et objets
 * 
 * 
 */
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
        
        
require_once($server.'require.php');

require_once($server.'class/monster.class.php');
require_once($server.'class/interaction.class.php');
require_once($server.'class/box.class.php');
require_once($server.'class/metier.class.php');
require_once($server.'class/pnj.class.php');
require_once($server.'class/room.class.php');
require_once($server.'class/group.class.php');


  

$char=unserialize($_SESSION['char']);
$connexion=PDO2::connect();
  	$char->saveMove();

$group = new group(group::getGroup($char->getId()));
$group_id = $group->getId();			
	// Chargement des t�l�porteurs
	if(room::allMonsterDieStatic($char->getMap(),$group_id)){
		$true=true;
	}
	else{
		$true=false;
	}
?><div style="float:left;margin-top:0px;margin-left:0px;z-index:1;width:0px;">

	<table cellspacing="0" cellpadding="0" style="border:0px;z-index:1;">
	<?php

	// Donn�es du personnage
//	$casechar = ($char->getOrd() - 1) * 25 + $char->getAbs(); 

        
	$map = new Map();
        $arrayCase= $map->getArrayCase($char,$group_id,$true);
        
        
				
//#######################################################################################################

// Affichage des cases bloqu�es sur la carte
	$compte=1;
	$case = 0;
        $ord = $abs = 1;
        
       
while($ord < 16)
{
    echo '<tr class="size_case_map">';
	while ($abs < 26) 
        {
            
		$case = $case + 1	;

		
		$marginTop = ($ord - 1) * 32 - 16 ;
		$marginLeft = ($abs - 1) * 32;
		
		if($marginTop == 432)
		{
			$marginTop = 430;	
		}

		    $time = 18;
		
		 
		 
		?><td class="size_case_map" valign="top">
			<div class="size_case_map">
			<?php	
                        
                if(isset($arrayCase[$ord][$abs]))
                {
                    
			
			                        
                    switch($arrayCase[$ord][$abs]['type'])
                    {
			
                        case 1:
                            
                            echo "<div id=\"free",$case,"\" class=\"case_map\">",1," </div>";
                            
                        break;
                    
                    
                        case 2:
                            
                            // 	Affichage des pnj
                            echo "<div id=\"free",$case,"\" class=\"case_map\">",1," </div>";
                            
                            if($arrayCase[$ord][$abs]['taille'] == 2)
                            {
                                
                                 $width='32';
                                 $height='48';
                            }elseif($arrayCase[$ord][$abs]['taille'] == 1)
                            {
                              
                               $width='32';
                               $height='32';
                            }elseif($arrayCase[$ord][$abs]['taille'] == 4)
                            {
                                
                                $width='64';
                                $height='64';
                             }



                             $a = $arrayCase[$ord][$abs]['abs'] - $char->getAbs(); // �cart horizontale

                             // gestion de la taille du joueur
                             if($arrayCase[$ord][$abs]['ord'] > $char->getOrd())
                                   $char_ord = $char->getOrd() + 1;
                             else
                                  $char_ord = $char->getOrd();

                             $b = $arrayCase[$ord][$abs]['ord'] - $char_ord; // �cart verticale
                             $distance = abs($a) + abs($b);

                             // Valeur absolue du r�sultat
                             if(abs($a) <= 1 && abs($b) <= 1)
                             {
                               $distance = 1;
                             }


                             echo '<div id="pnj_',$arrayCase[$ord][$abs]['id'],'" class="pnj_map" onclick="loadObject(\'pnj\',\'',$distance,'\',\'',$arrayCase[$ord][$abs]['id'],'\');" style="height:',$height,'px;width:',$width,'px;">';
                                  echo '<img src="pictures/pnj/',$arrayCase[$ord][$abs]['image'],'" alt="Xxx" title="',$arrayCase[$ord][$abs]['name'],'" />';
                             echo '</div>';

                             
                                               
                        break;
                        
                        case 3:
				
                            echo "<div id=\"free",$case,"\" class=\"case_map\">",1," </div>";
                            
				$a = $abs - $char->getAbs(); // �cart horizontale
				$b = $ord - $char->getOrd(); // �cart verticale
				$distance = abs($a) + abs($b);
				// Valeur absolue du r�sultat
				if(abs($a) <= 1 && abs($b) <= 1)
				{
					$distance = 1;
				}
					
					
				
				if($arrayCase[$ord][$abs]['opened'] == $char->getId())
				{
					$picture = "pictures/coffre/".$arrayCase[$ord][$abs]['image']."_open.gif";
				}else{
					$picture = "pictures/coffre/".$arrayCase[$ord][$abs]['image']."_close.gif";	
				}
				echo '<div class="POM"><img  src="',$picture,'" alt="Tr�sors" onclick="loadObject(\'coffre\',\'',$distance,'\',\'',$case,'\');" /></div>';
				        
                         break;
                         
                         case 4:
                             
                             echo "<div id=\"free",$case,"\" class=\"case_map\">",1," </div>";
                             $return_array = getMarginWitdhHeightByTaille($arrayCase[$ord][$abs]['taille'],$abs,$ord);
		
                             
                             $width=$return_array['width'];
                             $height=$return_array['height'];

                             $distance = calculDistance($char->getAbs(),$char->getOrd(),$abs,$ord,$arrayCase[$ord][$abs]['taille']);
                             echo '<div id="monster_',$arrayCase[$ord][$abs]['id'],'" class="monster_map" onclick="loadObject(\'monster\',\'',$distance,'\',\'',$arrayCase[$ord][$abs]['id'],'\');" style="background-image:url(pictures/monster/',$arrayCase[$ord][$abs]['idmstr'],'.gif);height:',$height,'px;width:',$width,'px;"></div>';
 
                         break;
                     
                     
                         case 5:
                             
                             echo "<div id=\"free",$case,"\" class=\"case_map\">",1," </div>";

                             $a = $abs - $char->getAbs(); // �cart horizontale
                             $b = $ord - $char->getOrd(); // �cart verticale
                             $distance = abs($a) + abs($b);
                             // Valeur absolue du r�sultat
                             if(abs($a) <= 1 && abs($b) <= 1)
                             {
                                 $distance = 1;
                             }

                             $onclick =  "loadObject('action','$distance','".$ressource['id']."');";
                             echo '<div class="ressource_map" id="ressource_',$arrayCase[$ord][$abs]['item_id'],'" onclick="',$onclick,'" style="background-image:url(pictures/item/',$arrayCase[$ord][$abs]['item_id'],'.gif);">';

                             echo '</div>';                            
                             
                         break;
                         
                         
                         case 6:
                             
                             echo "<div id=\"free",$case,"\" class=\"case_map\">",1," </div>";
                             $return_array = getMarginWitdhHeightByTaille($arrayCase[$ord][$abs]['taille'],$abs,$ord);

                                $width=$return_array['width'];
                                $height=$return_array['height'];	

                                $a = $abs - $char->getAbs(); // �cart horizontale
                                $b = $ord - $char->getOrd(); // �cart verticale
                                $distance = abs($a) + abs($b);
                                // Valeur absolue du r�sultat
                                if(abs($a) <= 1 && abs($b) <= 1)
                                {
                                        $distance = 1;
                                }

                                echo '<div id="obstacle_',$arrayCase[$ord][$abs]['id'],'" onclick="" class="obstacle_map" style="background-image:url(pictures/obstacle/',$arrayCase[$ord][$abs]['image'],');height:',$height,'px;width:',$width,'px;">';

                                echo '</div>';
        
                         break;
                         
                         case 7:
                             
                             echo "<div id=\"free",$case,"\" class=\"case_map\">",1," </div>";	

                                $a = $arrayCase[$ord][$abs]['abs'] - $char->getAbs(); // �cart horizontale
                                $b = $arrayCase[$ord][$abs]['ord'] - $char->getOrd(); // �cart verticale
                                $distance = abs($a) + abs($b);
                                // Valeur absolue du r�sultat
                                if(abs($a) <= 1 && abs($b) <= 1)
                                {
                                        $distance = 1;
                                }

                                
                                $onclick =  "loadObject('player','$distance','".$arrayCase[$ord][$abs]['id']."');";
                                echo  '<div id="player_',$arrayCase[$ord][$abs]['id'],'" ' ,
                                                'onclick="',$onclick,'" ' ,
                                                'style="background-image:url(',$arrayCase[$ord][$abs]['image'],');' ,
                                                '"></div>';
 
                         break;
                         
                         case 8:
 
                             echo "<div id=\"free",$case,"\" class=\"case_map\">",1," </div>";

                                $a = $abs - $char->getAbs(); // �cart horizontale
                                $b = $abs - $char->getOrd(); // �cart verticale
                                $distance = abs($a) + abs($b);
                                // Valeur absolue du r�sultat
                                if(abs($a) <= 1 && abs($b) <= 1)
                                {
                                        $distance = 1;
                                }

                                $onclick =  "loadObject('box_letter','$distance','".$arrayCase[$ord][$abs]['id']."');";

                                echo '<div id="box_letter_',$arrayCase[$ord][$abs]['id'],'" ' ,
                                                'onclick="',$onclick,'" ' ,
                                                'class="box_letter_map" ' ,
                                                '>';

                                echo '<img src="pictures/utils/box_letter.gif" alt="" />';

                                echo '</div>';  
                         break;
                         
                         
                         case 9:
                             
                                echo "<div id=\"free",$case,"\" class=\"case_map\"></div>";
                             
                                echo '<img class="POM" src="pictures/telep/',$arrayCase[$ord][$abs]['type_telep'],'.png" alt="T�l�porteur" class="telep_map" />';
                                echo '<div id="telep',$case,'" style="display:none;">',$arrayCase[$ord][$abs]['changemap'],'</div>';
                                echo '<div id="telep',$case,'_abs" style="display:none;">',$arrayCase[$ord][$abs]['abschange'],'</div>';
                                echo '<div id="telep',$case,'_ord" style="display:none;">',$arrayCase[$ord][$abs]['ordchange'],'</div>';
                         break;
                     
                     
                         case 10:
                             
                                 echo "<div id=\"free",$case,"\" class=\"case_map\"></div>";
           

                                $a = $abs - $item_id['abs']; // �cart horizontale
                                $b = $ord - $item_id['ord']; // �cart verticale

                                // Valeur absolue du r�sultat
                                $distance = abs($a) + abs($b);

                                $onclick =  "loadObject('player','$distance','".$char->getId()."');";
                                echo '<div onclick="',$onclick,'" class="item_map" alt="A">';
                                        echo '<img src="pictures/item/',$arrayCase[$ord][$abs]['item_id'],'.gif" alt="objet" title="',$arrayCase[$ord][$abs]['name'],'" />';
                                echo '</div>';
                             
                         break;
                     
                         case 11:

                                $a = $abs - $char->getAbs(); // �cart horizontale
                                $b = $ord - $char->getOrd(); // �cart verticale
                                $distance = abs($a) + abs($b);
                                // Valeur absolue du r�sultat
                                if(abs($a) <= 1 && abs($b) <= 1)
                                {
                                        $distance = 1;
                                }

                                $onclick =  "loadObject('atelier','$distance','".$arrayCase[$ord][$abs]['id']."');";

                                echo '<div id="atelier_',$arrayCase[$ord][$abs]['id'],'" ' ,
                                                'onclick="',$onclick,'" ' ,
                                                'class="atelier_map" ' ,
                                                '>';

                                echo '<img src="pictures/utils/pp.png" alt="" />';

                                echo '</div>';
                             
                         break;
                         
                         case 12:
 
                            $a = $abs - $char->getAbs(); // �cart horizontale
                            $b = $ord - $char->getOrd(); // �cart verticale
                            $distance = abs($a) + abs($b);
                                        
                            // Valeur absolue du r�sultat
                            if(abs($a) <= 1 && abs($b) <= 1)
                            {
                                $distance = 1;
                            }

                            $onclick =  "loadObject('interaction','$distance','".$arrayCase[$ord][$abs]['id']."');";

                            echo '<div id="interaction_',$arrayCase[$ord][$abs]['id'],'" ' ,
                                    'onclick="',$onclick,'" ' ,
                                    'class="interaction_map" ' ,
                                    '>';

                            echo '</div>';

                            $compte++;
    
                         break;
                         
                         case 13:
                             
                                $face =$char->getFace();

                                if($char->getLife() > 0)
                                        $image = $char->getClasse().'-0-'.$face.'.gif';
                                else
                                        $image = 'die-'.$char->getClasse();


                                if(!isset($distance))
                                    $distance=0;

                                echo '<div id="perso_container_div" class="perso">';
                                $onclick =  "loadObject('player','$distance','".$char->getId()."');";
                                echo '<div id="perso" onclick="'.$onclick.'" style="background-image:url('.$char->getUrlPicture('ico',$face).');height:48px;width:32px;z-index:128;">';
                                echo '</div>';

                                echo '<input id="perso_id" type="hidden" value="'.$char->getId().'"/>';
                                echo '<input id="perso_classe" type="hidden" value="'.$char->getClasse().'"/>';
                                echo '<input id="perso_gender" type="hidden" value="'.$char->getGender().'"/>';
                                echo '<input id="perso_skin" type="hidden" value="'.$char->getSkin().'"/>';
                                echo '<input id="perso_map" type="hidden" value="'.$char->getMap().'"/>';
                                echo '<input id="perso_abs" type="hidden" value="'.$char->getAbs().'"/>';
                                echo '<input id="perso_ord" type="hidden" value="'.$char->getOrd().'"/>';
                                echo '</div>';
                         break;
                    }
                }
                else
                {
                    echo "<div id=\"free",$case,"\" class=\"case_map\"></div>";
                    
                }
				
		
			?></div>
		
		 
   </td><?php
   $abs ++;
    }
    $abs = 1;
echo '</tr>' ;
$ord++;
}	 
	
	echo'</table>';
echo'</div>';

#########################################################################################################
	
// Information sur le personnage � recharger
if($char->getLife() <= 0 && $char->getTimeDie() == 0)
{
	$time_respawn = $_SERVER['REQUEST_TIME'] + 30;
	$char->update('time_die',$time_respawn);
}


echo '<div id="life_perso" style="display:none;">';
	echo $char->getLife();
echo '</div>';	
	
echo '<div id="die_perso" style="display:none;">';
	$time = $_SERVER['REQUEST_TIME'];
	
	$time_go_cimetery = $char->getTimeDie() - $time;
	if($time_go_cimetery < 0)
		$time_go_cimetery = 0;
		
	echo $time_go_cimetery;
echo '</div>';

echo '<div id="time" style="display:none;">',$time,'</div>';
?>