
<div style="text-align:center;">	
	<h1> Parrainage </h1>
</div>

<hr />

<div>
	<div style="margin-left:30px;"><u>Lien de parrainage :</u> </div> <br />
	
		<div style="margin-left:50px;">http://www.royaume-arelidon.fr?page=inscription&sponsor=<?php echo $char->getUser()->getLogin() ?></div>
</div>

<hr />
	<div style="margin-left:30px;"><h2> Informations </h2></div>
	
	<div style="margin-left:50px;">
		<p>
			- Vous gagnez 10 Points d'actions à chaque personnage que votre filleul connecte.<br />
			- Les Points d'actions ne sont pas gagnés si le filleul possède la même adresse IP que le parrain <br />
			- Il n'y a pas de limite de filleul, plus vous en avez, plus vous avez de PA <br />
		
		</p>
	</div>
	
	<div style="margin-left:50px;">
		<div style="margin-left:10px;"> Nombre de filleuls : <?php echo $char->getUser()->getNumberSponsored(); ?> filleuls</div>
		
		<?php $array_sponsored = $char->getUser()->getSponsoredList(); 
			echo '<br />';
			echo '<table style="margin:auto;width:300px;text-align:center;" border="1">';
				
				echo '<th colspan="2"> vos gains aujourd\'hui </th>';
			
				echo '<tr>';
					echo '<td>';
						echo 'Pseudo : ';
					echo '</td>';
					
					echo '<td>';
						echo 'Gain en PA : ';
					echo '</td>';
				echo '</tr>';
				
			if(count($array_sponsored) == 0)
				$array_sponsored = array('aucun'=>'0');	
				
			foreach($array_sponsored as $login2=>$val)
			{
				echo '<tr>';
					echo '<td>'.$login2.'</td>';
					
					echo '<td>'.$val.'</td>';
				
				echo '</tr>';
			}
			echo '</table>';
		
		
		?>
		
	
	</div>