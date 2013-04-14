<?php
/*
 * Created on 7 févr. 2010
 */
 
 require_once('../utils/stats.php');
 



switch($infos)
{
	default:
	
		echo '<table style="width:100%;text-align:center;">';
		
			echo '<tr>';
				echo '<td>';
					echo 'Date';
				echo '</td>';
				
				echo '<td>';
					echo 'Nombre d inscrit';
				echo '</td>';
				
				echo '<td>';
					echo '% qui ont cr&eacute;&eacute; un joueur';
				echo '</td>';
				
				echo '<td>';
					echo '% qui ont jou&eacute;';
				echo '</td>';
			echo '</tr>';
		
		
		$array = getAllRegister();
		
		
		if(count($array) >= 1)
		{
			foreach($array as $ar)
			{
				$ids_array[] = $ar['id'];
			}
			
			$ids = implode(',',$ids_array);
			
				
		}else{
			$ids = '0';
		}
		
		
		
		$who_created_char = getPourcentCreate($ids,count($array));
		$who_played_with_char = getPourcentPlay($ids,count($array));
			
			echo '<tr>';
				echo '<td>';
					echo 'Aujourd\'hui';
				echo '</td>';
				
				echo '<td>';
					echo count($array);
				echo '</td>';
				
				echo '<td>';
					echo $who_created_char.' %';
				echo '</td>';
				
				echo '<td>';
					echo $who_played_with_char.' %';
				echo '</td>';
			
			
			echo '</tr>';
			
			
			
		// Hier	
			
		$array = getAllRegister('CURRENT_DATE()-1');
		
		
		if(count($array) >= 1)
		{
			foreach($array as $ar)
			{
				$ids_array[] = $ar['id'];
			}
			
			$ids = implode(',',$ids_array);
			
				
		}else{
			$ids = '0';
		}
		
		
		
		$who_created_char = getPourcentCreate($ids,count($array));
		$who_played_with_char = getPourcentPlay($ids,count($array));
			
			echo '<tr>';
				echo '<td>';
					echo 'hier';
				echo '</td>';
				
				echo '<td>';
					echo count($array);
				echo '</td>';
				
				echo '<td>';
					echo round($who_created_char).' %';
				echo '</td>';
				
				echo '<td>';
					echo round($who_played_with_char).' %';
				echo '</td>';
			
			
			echo '</tr>';	
			
		
		// J-2
			
		$array = getAllRegister('CURRENT_DATE()-2');
		
		
		if(count($array) >= 1)
		{
			foreach($array as $ar)
			{
				$ids_array[] = $ar['id'];
			}
			
			$ids = implode(',',$ids_array);
			
				
		}else{
			$ids = '0';
		}
		
		
		
		$who_created_char = getPourcentCreate($ids,count($array));
		$who_played_with_char = getPourcentPlay($ids,count($array));
			
			echo '<tr>';
				echo '<td>';
					echo '2 jours';
				echo '</td>';
				
				echo '<td>';
					echo count($array);
				echo '</td>';
				
				echo '<td>';
					echo $who_created_char.' %';
				echo '</td>';
				
				echo '<td>';
					echo $who_played_with_char.' %';
				echo '</td>';
			
			
			echo '</tr>';
			
			
			
		// J-3
			
		$array = getAllRegister('CURRENT_DATE()-3');
		
		
		if(count($array) >= 1)
		{
			foreach($array as $ar)
			{
				$ids_array[] = $ar['id'];
			}
			
			$ids = implode(',',$ids_array);
			
				
		}else{
			$ids = '0';
		}
		
		
		
		$who_created_char = getPourcentCreate($ids,count($array));
		$who_played_with_char = getPourcentPlay($ids,count($array));
			
			echo '<tr>';
				echo '<td>';
					echo '3 jours';
				echo '</td>';
				
				echo '<td>';
					echo count($array);
				echo '</td>';
				
				echo '<td>';
					echo $who_created_char.' %';
				echo '</td>';
				
				echo '<td>';
					echo $who_played_with_char.' %';
				echo '</td>';
			
			
			echo '</tr>';	
		
		
		// J-4
			
		$array = getAllRegister('CURRENT_DATE()-4');
		
		
		if(count($array) >= 1)
		{
			foreach($array as $ar)
			{
				$ids_array[] = $ar['id'];
			}
			
			$ids = implode(',',$ids_array);
			
				
		}else{
			$ids = '0';
		}
		
		
		
		$who_created_char = getPourcentCreate($ids,count($array));
		$who_played_with_char = getPourcentPlay($ids,count($array));
			
			echo '<tr>';
				echo '<td>';
					echo '4 jours';
				echo '</td>';
				
				echo '<td>';
					echo count($array);
				echo '</td>';
				
				echo '<td>';
					echo $who_created_char.' %';
				echo '</td>';
				
				echo '<td>';
					echo $who_played_with_char.' %';
				echo '</td>';
			
			
			echo '</tr>';
		
		// J-5
			
		$array = getAllRegister('CURRENT_DATE()-5');
		
		
		if(count($array) >= 1)
		{
			foreach($array as $ar)
			{
				$ids_array[] = $ar['id'];
			}
			
			$ids = implode(',',$ids_array);
			
				
		}else{
			$ids = '0';
		}
		
		
		
		$who_created_char = getPourcentCreate($ids,count($array));
		$who_played_with_char = getPourcentPlay($ids,count($array));
			
			echo '<tr>';
				echo '<td>';
					echo '5 jours';
				echo '</td>';
				
				echo '<td>';
					echo count($array);
				echo '</td>';
				
				echo '<td>';
					echo $who_created_char.' %';
				echo '</td>';
				
				echo '<td>';
					echo $who_played_with_char.' %';
				echo '</td>';
			
			
			echo '</tr>';
			
		echo '</table>';
		
		echo '<hr />';
		
		echo 'Nombre de connect&eacute;s : <br />';
		
		echo '<br />';
		echo '<table style="margin-left:40px;" border="1">';
		
		echo '<tr>';
			for($i=0;$i<8;$i++)
			{
				echo '<td style="width:80px;text-align:center;">';
				
				if($i == 0)
					echo 'aujourd\'hui';
				elseif($i == 1)
					echo 'hier';
				else
					echo $i.' jours';
					
				echo '</td>';
				
			}
		echo '</tr>';
		
		echo '<tr>';
			for($i=0;$i<8;$i++)
			{
				echo '<td style="width:80px;text-align:center;">';
				
				$jour =  date("d")-$i;
				$mois =  date("m");
				$annee = date("Y");
				$date = $annee."-".$mois."-".$jour;
				
				$sql = "SELECT COUNT(*) FROM log_connection WHERE date = '$date' ";
				$result = loadSqlResult($sql);
				
				echo $result;
					
				echo '</td>';
				
			}
		echo '</tr>';
		
		echo '</table>';
		
		echo '<div style="text-align:center;">';
			echo 'Nombre de joueurs actif (estimation) : ';
			
			$date=time() - (86400*7);
			
			$sql = "SELECT COUNT(DISTINCT(idaccount)) FROM `char` WHERE (SELECT COUNT(*) FROM `log_connection` WHERE time_connexion >= $date) >= 1 &&  exp > 0";
			$result = loadSqlResult($sql);
			echo $result;
		echo '</div>';
		
		echo '<hr />';
		echo '<div style="margin-left:40px;">';
			echo 'Joueurs actif par faction (estimation) : ';
			
			
			$sql = "SELECT COUNT(*) FROM `char` WHERE faction = 1 &&  level > 1";
			$nudricens = loadSqlResult($sql);
			
			$sql = "SELECT COUNT(*) FROM `char` WHERE faction = 2 &&  level > 1";
			$umodiens = loadSqlResult($sql);
			
			$sql = "SELECT COUNT(*) FROM `char` WHERE faction = 3 &&  level > 1";
			$amodiens = loadSqlResult($sql);
			
			$tot = $nudricens + $umodiens + $amodiens;

			echo '<div style="margin-left:70px;"><br />';
				echo 'Nudriciens : '.$nudricens.' ('.round($nudricens / $tot * 100).'%) <br />';
				echo 'Umodiens : '.$umodiens.' ('.round($umodiens / $tot * 100).'%) <br />';
				echo 'Amodiens : '.$amodiens.' ('.round($amodiens / $tot * 100).'%) <br />';
			echo '</div>';
			
			echo '<br />Joueurs total par faction (estimation) : ';
			
			
			$sql = "SELECT COUNT(*) FROM `char` WHERE faction = 1";
			$nudricens = loadSqlResult($sql);
			
			$sql = "SELECT COUNT(*) FROM `char` WHERE faction = 2";
			$umodiens = loadSqlResult($sql);
			
			$sql = "SELECT COUNT(*) FROM `char` WHERE faction = 3";
			$amodiens = loadSqlResult($sql);
			
			$tot = $nudricens + $umodiens + $amodiens;

			echo '<div style="margin-left:70px;"><br />';
				echo 'Nudriciens : '.$nudricens.' ('.round($nudricens / $tot * 100).'%) <br />';
				echo 'Umodiens : '.$umodiens.' ('.round($umodiens / $tot * 100).'%) <br />';
				echo 'Amodiens : '.$amodiens.' ('.round($amodiens / $tot * 100).'%) <br />';
			echo '</div>';

		echo '</div>';
		
	
	break;
	
	case 'info_actif':
	
	break;
	
	case 'info_players_by_level':
	
	break;
}
?>
