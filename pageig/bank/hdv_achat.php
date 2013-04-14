<?php
if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}
require_once($server.'/require.php');

if(isset($_GET['achat'])){
	if($_GET['number'] > 0 and $_GET['item'] > 0 and $_GET['price'] > 0){
		$hdv=new hdv();
		$hdv->buy($_GET['price'],$_GET['number'],$_GET['item'],$char->getId());
		echo '<h3 style="color:green;">Achat valid&eacute;</h3>';
	}else{
		echo '<h3 style="color:red;"> Il n\'y a pas d\'offre pour cet objet et cette quantit�.</h3>';
	}
	
}
?>

<fieldset>
	<div id="recherche"> 
	<form method="post" action="ingame.php?page=page&category=hdv&use_case=1&pnj=<?php  echo $_GET['pnj']; ?>">
		<label for="type"> Type : </label>
		<select id="type" name="type">
			<option value="20">Tous</option>
			<option value="1">&eacute;p&eacute;es</option>
			<option value="2">baguettes</option>
			<option value="3">boucliers</option>
			<option value="4">armures</option>
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
		
		<label for="niv_min"> niv :</label>
		<input type="text" value="1" name="niv_min" id="niv_min"/>
		
		<label for="niv_max"> &agrave; </label>
		<input type="text" value="<?php echo  $char->level?>" id="niv_max" name="niv_max"/>
		
		<input type="submit" value="Chercher" class="button"/>
	</form>
	</div>
	<br/>
	<br/>
	<table border="1" class="backgroundBody" cellspacing="0" style="border:solid 1px black;text-align:center;width:800px;">
		<tr class="backgroundMenu">
			<th> Nom </th>
			<th> x 1 </th>
			<th> x 10 </th>
			<th> x 100 </th>
		</tr>
		
		<?php 
		$hdv= new hdv();
		if(isset($_POST['type'])){
			$restrict=$_POST['type'];
		}
		else{
			$restrict=20;
		}
		
		if(isset($_POST['niv_min'])){
			$min=$_POST['niv_min'];
		}
		else{
			$min=1;
		}
		
		if(isset($_POST['niv_max'])){
			$max=$_POST['niv_max'];
		}
		else{
			$max=$char->level;
		}
		$array_results= $hdv->selectItems($min,$max,$restrict);

		foreach($array_results as $ligne){
			echo '<tr>';
			$item=new item($ligne['item']);
			echo '<td>'.$item->getName().$item->getPicture(true);'</td>';
			echo '<td>'.$ligne['un'].'<img src="pictures/icones/dondor.gif" onclick="if(confirm(\'Voulez vous achetez cet objet ?\')){HTTPTargetCall(\'page.php?category=hdv&use_case=1&achat=1&item='.$ligne['item'].'&number=1&price='.$ligne['un'].'&pnj='.$_GET['pnj'].'\',\'bodygameig\');}"/></td>';
			echo '<td>'.$ligne['dix'].'<img src="pictures/icones/dondor.gif" onclick="if(confirm(\'Voulez vous achetez ces objets ?\')){HTTPTargetCall(\'page.php?category=hdv&use_case=1&achat=1&item='.$ligne['item'].'&number=10&price='.$ligne['dix'].'&pnj='.$_GET['pnj'].'\',\'bodygameig\')};"/></td>';
			echo '<td>'.$ligne['cent'].'<img src="pictures/icones/dondor.gif" onclick="if(confirm(\'Voulez vous achetez ces objets ?\')){HTTPTargetCall(\'page.php?category=hdv&use_case=1&achat=1&item='.$ligne['item'].'&number=100&price='.$ligne['cent'].'&pnj='.$_GET['pnj'].'\',\'bodygameig\');}"/></td>';
			echo '</tr>';
		}

		?>
			
	</table>
	<br/><br/>
		<input type="button" value="Passer en mode vente" onclick="HTTPTargetCall('page.php?category=hdv&use_case=2&pnj=<?php echo $_GET['pnj']?>','bodygameig');" style="margin-left:300px;"/>

</fieldset>

<div style="display:block;">
	<div style="display:inline;float:left;">
	<fieldset>
		<legend> Comment acheter.</legend>
		
		*Cliquez sur les pi&egrave;ces pour acheter les produits. <br/>
		*Seule la meilleure offre pour chaque cat&eacute;gorie est affich&eacute;e.<br/>
	</fieldset>
	</div>
	<?php
		$pnj= new pnj($_GET['pnj']);
		echo '<div style="display:inline;float:right;">';
		echo '<img src="pictures/face/'.$pnj->getFace().'" style="border:solid 2px black;background:grey;width: 96px; height: 96px;" />';
		echo '</div>';
	?>
</div>