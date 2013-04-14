


<?php
if(isset($_POST['name'])){
	$sql="INSERT `agenda` (name,text,date) VALUES ('".$_POST['name']."','".$_POST['text']."',SYSDATE())";
	loadSqlExecute($sql);
	
	echo'<h3 style="color:red;"> Agenda soumis </h3>';
}

?>
<br/><br/><br/><br/>
<table class="backgroundBody">
	<tr class="backgroundMenu">
		<td> Admin </td>
		<td> Description</td>
		<td> Date </td>
	</tr>
	<?php
	
		$sql="SELECT * FROM `agenda` ORDER BY date LIMIT 0,20 ;";
		$arrayofarray=loadSqlResultArrayList($sql);
		
		foreach($arrayofarray as $array){
			echo '<tr>';
			echo '<td>'.$array['name'].'</td>';
			echo '<td>'.htmlentities($array['text'],ENT_QUOTES).'</td>';
			echo '<td>'.$array['date'].'</td>';
			echo '</tr>';
		}
	
	?>
</table>
<br/><br/><br/><br/>
<fieldset>
	<legend> Formulaire</legend>
<form method="post" action="panneauAdmin.php?category=39">
	<label for="name"> Le nom que vous souhaitez fournir. </label>
	<input type="text" name="name" id="name"/>
	<br/><br/>
	<label for="text"> Description de la t&acirc;che</label>
	<textarea name="text" id="text">
	
	</textarea>
	<br/>
	<br/>
	<input type="submit" value="Soumettre"/>
</form>
</fieldset>