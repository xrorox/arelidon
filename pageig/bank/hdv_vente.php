<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'/require.php');

if(isset($_POST['id'])){
	$hdv=new hdv();
	$test=$hdv->putOnSale($char->getId(),$_POST['id'],$_POST['quantite'],$_POST['price']);
	
	if($test){
		echo '<h3 style="color:green"> Operation valid&eacute;e</h3>';
	}else{
		echo '</h3 style="color:red"> Vous ne disposez plus de l\'objet en quantit&eacute; n&eacute;cessaire.';
	}
}
?>

<h3 style="margin-left:350px;"> Vente </h3>
<div>
	<div id="vente" class="hdv" style="display:block;height:300px;width:800px;">
		
			<br/>
			<br/>
			<div class="backgroundBody" style="display:inline;float:left;width:380px;height:200px;">
		<form method="post" action="ingame.php?page=page&category=hdv&use_case=2&pnj=<?php echo $_GET['pnj'] ?>">
			<label for="nom"> nom : </label>
			<span id="nom"><?php 
			
			if (isset($_GET['item_choice'])){
				$item=new item($_GET['item_choice']);
				echo $item->name;
				$item->getPicture(false);
				echo'<input type="hidden" value="'.$_GET['item_choice'].'"name="id"/>';
			}
			
			?></span>
				<br/>
				<br/>
			<label for="quantite">Quantit&eacute;</label>
			<?php  if(isset($_GET['item_choice'])){
				echo '<select id="quantite" name="quantite">';
					echo'<option value="1"> Un</option>';
					echo'<option value="10"> Dix</option>';
					echo'<option value="100"> Cent</option>';
				echo'</select>';
			}else{
				echo '<select id="quantite" disabled="DISABLED" name="quantite">';
					echo'<option value="0"> z&eacute;ro</option>';
				echo'</select>';
			} ?>
			<br/>
			<br/>
			<label for="prix"> prix :</label>
			<input type="text" name="price" id="price"/>
			<br/><br/>
			<input type="submit" value="Vendre"/>
		</form>
		</div>
		<div id="choix_objet" style="display:inline;float:right;width:380px;height:200px;" class="backgroundBody" >
			<div>
				<form method="post" action="ingame.php?page=page&category=hdv&use_case=2&pnj=<?php echo $_GET['pnj']?>">
				<label for="type"> type :</label>
				<select id="type" name="type">
					<option value="20">Tous</option>
					<option value="1">&eacute;p&eacute;es</option>
					<option value="2">baguettes</option>
					<option value="3">boucliers</option>
					<option value="4">armurees</option>
					<option value="5">casques</option>
					<option value="6">ceintures</option>
					<option value="7">bottes</option>
					<option value="8">outils</option>
					<option value="9">arcs</option>
					<option value="10">batons</option>
					<option value="11">anneaux</option>
					<option value="12">gants</option>
					<option value="13">colliers</option>
					<option value="15">haches</option>
					<option value="999">potions</option>
					<option value="0">ressources</option>
				</select>
					<input type="submit" value="filtrer" class="button"/>
				</form>
			</div>
		
		
		<table >
			<?php 
				$hdv=new hdv();
				if(isset($_POST['type'])){
					$restrict=$_POST['type'];
				}
				else{
					$restrict=20;
				}
				$arrayofarray=$hdv->getAllItemInBag($char->getId(),$restrict);
				
				$i= 0;
						
				foreach($arrayofarray as $array){
						
						if ($i ==0){
							echo '<tr>';
						}
					
						echo '<th>';
						echo $array['nbr']. ' :';
						$item= new item($array['item']);
						$onclick="HTTPTargetCall('page.php?category=hdv&use_case=2&item_choice=".$array['item']."&pnj=".$_GET['pnj']."','bodygameig');";
						$item->getPicture(false,$onclick);
						
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
			?>
		</table>
	</div>
	<br/>
	<br/>
	<input type="button" value="Passer en mode achat" onclick="HTTPTargetCall('page.php?category=hdv&use_case=1&pnj=<?php echo $_GET['pnj']?>','bodygameig');" style="margin-top:20px;margin-left:350px;"/>
</div>
<br/><br/>
<div style="display:block;">
	<div style="display:inline;float:left;">
	<fieldset>
		<legend> Comment vendre.</legend>
		
		* Cliquez sur l'image de l'objet que vous voulez vendre. <br/>
		* Ensuite s&eacute;lectionnez la quantit&eacute; et le prix. <br/>
		* Puis confirmez la vente.<br/>
		
	</fieldset>
	</div>
	<?php
		$pnj= new pnj($_GET['pnj']);
		echo '<div style="display:inline;float:right;">';
		echo '<img src="pictures/face/'.$pnj->getFace().'" style="border:solid 2px black;background:grey;width: 96px; height: 96px;" />';
		echo '</div>';
	?>
</div>