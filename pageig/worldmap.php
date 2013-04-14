<?php
/*
 * Created on 19 f�vr. 2010
 */
 require_once($server.'class/pnj.class.php');
 require_once($server.'class/step.class.php');
// Fonctions
function inCase($abs,$ord,$alt,$char)
{
	 $map = new map();
	 $map->loadMapByCord($abs,$ord,$alt);
	 $urlimg = "map/".$map->getImage();
         ?>
            <td>
		<div class="caseMapWolrd center " style="border: 0px black solid;">
    	<?php	if($map->getId() > 0)
    		{
    			if($char->alreadyExplore($map->getId()))
    			{ ?>
	    			<div class="left black zindex1 marginTop-10 width38 height22">
	    				<img src="<?php echo $urlimg; ?>" alt="pas d\'image" style="width:40px; height: 24px; border: 0px;" class="width40 height24 border0"/>
				</div> 
    			
	    		<?php	if($map->getId() == $char->getMap())
	    			{?>
	    				<div class="left marginTop-22 marginLeft10">
	    					<img src="pictures/utils/map_position.gif" alt="X" />
	    				</div>
	    		<?php	}
                                elseif($map->getMerchandOnMap())
                                {?>
	    				<div class="left marginTop-22 marginLeft10 width16 height16">
	    					<img src="pictures/utils/map_merchant.gif" alt="X"/>
	    				</div>
	    		<?php	}
                                elseif($map->getPnjWithQuestOnMap($char))
	    			{ ?>
	    				<div class="left marginTop-22 marginLeft10">
	    					<img src="pictures/utils/map_quest.gif" alt="X" />
	    				</div>
	    		<?php	}
    			}
    			   			
    			
    			
    		
    		
    		}
                else
                { ?>
    			<div class="width40 height24 marginTop0 black">
    		<?php }
    	?>		
    	</div>
     </td>
<?php
}

function getUrl($abschange,$ordchange,$altchange,$absmin,$absmax,$ordmin,$ordmax,$alt)
{
	if($abschange == '1')
	{
		$absmin = $absmin + 9;
		$absmax = $absmax + 9;		
	}
	if($abschange == '-1')
	{
		$absmin = $absmin - 9;
		$absmax = $absmax - 9;		
	}
	if($ordchange == '1')
	{
		$ordmin = $ordmin + 9;
		$ordmax = $ordmax + 9;		
	}
	if($ordchange == '-1')
	{
		$ordmin = $ordmin - 9;
		$ordmax = $ordmax - 9;		
	}
	if($altchange == '1')
	{
		$alt = $alt + 1;
	}
	if($altchange == '-1')
	{
		$alt = $alt - 1;
	}
	
	$url = 'gestion/page.php?category=3&absmin='.$absmin.'&absmax='.$absmax.'&ordmin='.$ordmin.'&ordmax='.$ordmax.'&alt='.$alt ;
	return $url;
} 
 
 
 
// R�cup�ration des variables

if(!empty($_GET['absmin']))
    $absmin = $_GET['absmin'];

if(!empty($_GET['absmax']))
    $absmax = $_GET['absmax'];

if(!empty($_GET['ordmin']))
    $ordmin = $_GET['ordmin'];

if(!empty($_GET['ordmax']))
    $ordmax = $_GET['ordmax'];

if(!empty($_GET['alt']))
    $alt = $_GET['alt'];


$map = new map($char->getMap());
	
	
$absmin = $map->getAbs() - 4;
$absmax = $map->getAbs() + 4;
$ordmin = $map->getOrd() - 4;
$ordmax = $map->getOrd() + 4;
$alt = $map->getAlt();	

?>	
<div id="menu_world_map" class="height40"></div>
    <div class="left width150 marginLeft10"></div> 
        <div id="world_map_container" class="left marginLeft20 paddingTop20">
        <!--// Affichage de la carte-->
            <div class="border1white borderbot2white borderright2white">
                <table border="0" cellspacing="0">
	<?php	
	for($ord=$ordmin;$ord<=$ordmax;$ord++)
	{
		?><tr><?php
		for($abs=$absmin;$abs<=$absmax;$abs++)
		{
			inCase($abs,$ord,$alt,$char);
			
		} 
		?></tr><?php
	}
	?></table>
	</div>


    </div>
 
    <div class="left marginLeft20">
	<u> L&eacute;gende :</u><br /><br />
	
	<div class="marginLeft20">
	
			<img src="pictures/utils/no.gif" alt="X" />
			 : Votre position <br /> 
			
			<img src="pictures/utils/map_merchant.gif" alt="X" class="width16 height16"/>
			 : Marchands <br /> '
			
			<img src="pictures/utils/map_quest.gif" alt="X" />
			 : Pnj avec Qu&ecirc;te
	
	</div>
	
</div>
<?php // }?>