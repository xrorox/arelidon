<?php

require_once($server.'require.php');
require_once($server.'class/banque.class.php');
require_once($server.'class/char_inv.class.php');

$char_id=unserialize($_SESSION["char"]);
$bank= new banque($char->getId());

if(empty($_GET['action'])) $_GET['action'] = '';

switch ($_GET['action']){
	
	case 'add_item_bank':
	
	$item=new Item($_GET['item']);
	$bank->manageItem($char,0,$item,1);

	break;
	case 'delete_item_bank':
	   $item=new Item($_GET['item']);
	   $bank->manageItem($char,0,$item,-1);
	break;
	case 'add_gold':
		if($_POST['ajout'] > 0)$bank->manageGold($char,0,$_POST['ajout']);
	break;
	case 'delete_gold':
		if($_POST['delete'] > 0)$bank->manageGold($char,0,$_POST['delete'] * -1);
	break;
}

?>

<div style="text-align:center;">


	<table style="margin:auto;">
	<tr>
	<th>
	<div  style="float:left;margin-right:5px;margin-top:25px;">
		
		<div class="backgroundBody" style="width:250px;min-height:280px;">
		 <div class="backgroundMenu"> <span style="margin-left:15px;">Vos objets</span> </div> 			
		 <div style="font-weight:500;text-align:center;"> Votre bourse : <?php echo $char->getGold()?> <img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="or" /></div>
			<?php
			$char_inv= new char_inv($char->getId());	
			$arrayofarray= $char_inv->getAllItem();
			
			echo '<table>';
				$i= 0;
						
				foreach($arrayofarray as $array){
						
						if ($i ==0){
							echo '<tr>';
						}
					
						echo '<th>';
						echo $array['number']. ' :';
						$onclick="HTTPTargetCall('page.php?category=bank&action=add_item_bank&item=".$array['item_id']."','bodygameig');";
                                                $item = new item($array['item_id']);
						$url_picture=$item->getPicture($array['item_id']);
						
						echo "<img src='".$url_picture."' onclick=".$onclick." />";
						echo '</th>';
						
						if ($i == 6){
							echo '</tr>';
						}
						$i++;
									
						if ($i == 6){
							$i=0;						
						}
					//}
				}
				?>
			</table style="border-collapse=collapse;">
		</div>
	</div>
	</th>
	
	<th>
	<div  style="float:left;margin-right:5px;margin-top:25px;margin-left:20px;">
		<div class="backgroundBody" style="width:250px;min-height:280px;">
		 <div class="backgroundMenu"> <span style="margin-left:15px;">Banque (Poids : <?php echo $bank->getWeight($char,0).'/50' ?>)</span> </div> 		
		 <div style="font-weight:500;text-align:center;"> Votre or en banque : <?php echo $bank->getGold($char,0) ?> <img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="or" /></div>		
			<?php
			$arrayofarray= $bank->getAllItems($char,0);
			
			echo '<table>';
				$i= 0;
                            if(count($arrayofarray) > 0)
                            {
				foreach($arrayofarray as $array){
						
					
					
					
					$url_picture = 'pictures/item/'.$array['item_id'].'.gif';
					$onclick="HTTPTargetCall('page.php?category=bank&action=delete_item_bank&item=".$array['item_id']."','bodygameig');";
					
					for ($a=1; $a <= $array['number'];$a++){
						if ($i ==0){
						echo '<tr>';
					}
					echo '<th>';
					echo "<img src='".$url_picture."' onclick=".$onclick." />";
					echo '</th>';
					
					if ($i == 6){
						echo '</tr>';
					}
					$i++;
									
					if ($i == 6){
						$i=0;						
					}
					}
				}
                            }
				?>
			</table>
		</div>
	</div>
	</th>
	
	<th>
	
	</th></tr>
	
	<tr><th>
	<div>
		<div style="float:left;text-align:center;padding-left:10px;margin-left:45px;">
			<form id="ajout_bank" method="post">
				<label for="ajout">
				Stocker de l\'or : <br />
				</label>
				
				<input type="text" id="ajout" name="ajout" size="5"  /> 
				<?php
				$onclick="HTTPPostCall('page.php?category=bank&action=add_gold','ajout_bank','bodygameig');";
				echo '<input type="button" style="height:20px;" class="button" onclick='.$onclick.' value="ajouter" />';
				?>
			</form>
		</div>
		</th><th>
		<div style="float:left;text-align:center;margin-left:20px;padding-left:10px;margin-left:45px;">
			<form id="delete_bank" method="post" >
				<label for="delete">
				Retirer de l\'or : <br />
				</label>
				
				<input type="text" id="delete" name="delete" size="5" /> 
				<?php
				$onclick="HTTPPostCall('page.php?category=bank&action=delete_gold','delete_bank','bodygameig');";
				echo '<input type="button" "class="button" onclick='.$onclick.' value="reprendre" />';
				?>
			</form>
		
		</div>
	</div>	
	</th></tr></table>
	
	<br /><br />
	
	<div style="float:left;">
	<?php
		$link = "ingame.php";
		createButton('Sortir',"",'exit',$link,"7",false,"",$style="text-align:none;margin:auto;margin-left:350px;");
	?>
	</div>
	
</div>