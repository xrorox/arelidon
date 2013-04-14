<?php
/*
 * Created on 1 févr. 2010
 *
 */
 
 $interaction = new interaction($_GET['id']);


 if($_GET['valid_interaction'] != 1)
 {
 	// Première fois qu'on clique
		if($interaction->stillDo($char->getId()))
		{
			$text = " Vide ";
			$onclick = "";		
		}else{
			$text = $interaction->getNameForQuest();
			$url = "include/menuig.php?refresh=1&mode=interaction&distance=1&valid_interaction=1&id=".$interaction->getId();
			$onclick = "HTTPTargetCall('$url','menuig');refreshBarres();refreshInfos();";	
		}

		
		echo '<div class="boutonItem" onclick="'.$onclick.'"' .
				'style="' .
					'margin-top:5px;' .
					'height:30px;' .
					'width:98%;' .
					'border:solid 1px black;' .
					'color:black;' .
					'font-size:13px;' .
					'cursor:pointer;' .
					'padding-top:10px;' .
					'text-align:center;' .
					'">';
			
			echo $text;
		echo '</div>';
 
 }else{
 	// Confirmation de l\'interaction
	echo '<div style="margin:10px;">';
		echo $interaction->getCommentaire();
		switch($interaction->getType())
		{
			case 0 :
			
			break;
			case 1 :
				echo ' <br /><br /> Vous recevez ';
				
				$i = 0;
				if($interaction->getGold() > 0)
				{
					$i = 1;
					echo $interaction->getGold();
					echo ' pi&egrave;ces d\'or';
					$char->updateMore('gold',$interaction->getGold());
				}
				
				if($interaction->getItem() > 0)
				{
					if($i == 1)
						echo ' et ';
					$item = new item($interaction->getItem());
					$item->addItemToChar($char->getId(),$interaction->getNbItem());
					echo $item->getName();
					
				}
				
			break;
			case 2 :
				echo ' <br /> Vous recevez '.$interaction->getDmg().' dommages';
				$char->updateLife($interaction->getDmg());
			break;
		}
		
		// mettre à jour dans interaction char
		$interaction->markAsDone($char->getID());
		
	echo '</div>';
 }


?>
