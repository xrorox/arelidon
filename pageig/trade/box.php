<?php
/*
 * Created on 25 mai 2010
 */
 require_once($server.'class/trade_letter.class.php');
 echo '<div style="margin-top:20px;"></div>';
 switch($_GET['action'])
 {
	case 'send':
	
		echo '<table class="backgroundBodyNoRadius" style="margin:auto;width:500px;">';
		
			echo '<tr class="backgroundMenuNoRadius">';
				echo '<td><b> Formulaire d\'envoi d\'un colis </td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>';
				echo '<form id="send_colis" method="POST">';
				
					echo '<div style="margin-left:40px;">';
						echo '<br /><b>';
						echo 'Destinataire : ';
							$array = getAutocomplete('chars',array($char->getId()));
							echo '<input id="to_input" type="text" value="" name="dest" size="37" onfocus="autoComplete(\'to_input\',\''.$array.'\')" /> ';
						
						echo '<br /> <br /> ';
						
						echo 'Colis : ';
							echo '<input id="nb" type="text" name="nb" value="0" size="5" /> ';
							$array = getAutocomplete('item');
							echo '<input id="item_to_post" type="text" name="item_to_post" value="item" size="35" onclick="autoComplete(\'item_to_post\',\''.$array.'\');autoComplete(\'item_to_post\',\''.$array.'\');" /> ' ;
							
						echo '<br /> <br /> ';
						
						echo 'Prix de vente : ';
						
							echo '<input type="text" name="price" value="0" size="3" /> pi&egrave;ces d\'or.';
						
						echo '<br /> <br /> ';
						
						echo '<div id="weight" style="text-align:center;">';
							echo 'poids : 0 - prix : 0 ';
						echo '</div>';
						
						echo '<input type="button" class="button" onclick="weight();" value="peser" style="margin-left:300px;" /> ';
						$onclick = "HTTPPostCall('page.php?category=trade&action=confirm_send','send_colis','bodygameig');";	
						echo '<input type="button" class="button" onclick="'.$onclick.'" value="envoyer" style="" />';
						
					echo '</b></div>';
				
				echo '</form>';
				echo '</td>';
			echo '</tr>';
		echo '</table>';
		
	
	break;
	
	case 'weight':
		// Fonction permettant de peser l'objet
		$item = new item($_GET['ob']);
		
		$poids = $item->getPoid() * $_GET['nb'];
		$prix = trade_letter::getTarification($poids);
		
		echo 'poids : '.$poids.' - prix : '.$prix.' ';
		
	break;
	
	case 'confirm_send':
		
		echo '<div style="margin-top:30px;margin-left:70px;">';
		
		
		if(!empty($_POST['dest']) && $dest_id != $char->getId())
		{
			$dest = new char($_POST['dest']);
			
				if($_POST['nb'] > 0)
				{
					if(!empty($_POST['item_to_post']))
					{
						$item = new item($_POST['item_to_post']);
						
						if($item->charGetItem($char->getId(),$_POST['nb']))
						{
							$poids = $item->getPoid() * $_POST['nb'];
							$prix = trade_letter::getTarification($poids);	
							
							if($char->getGold() >= $prix)
							{
								$tl = new trade_letter();
								$tl->add($dest->getId(),$char->getId(),$_POST['nb'],$item_id,$_POST['price']);
								
								// Retir� l'argent et les objets
								$gold = $prix * -1;
								$char->updateMore('gold',$gold);
								
								$char->dropItem($item_id,$_POST['nb']);
								
								// Envoyer un message au destinataire pour lui pr�venir qu'un colis est arriv�
								message::addNewMessage(0,$dest->getId(),"[Alerte] un nouveau colis est arriv�","Vous pouvez d�s maintenant retirer votre colis � un bureau de la Pigeon Post");
								
								printConfirm('Le colis a bien &eacute;t&eacute; envoy&eacute;.') ;
							}else{
								printAlert('Pas assez d\'or') ;
							}							
						}else{
							printAlert('Vous n\'avez pas assez d\'objet pour en envoyer autant.');						
						}
					}else{
						printAlert('Objet incorrect',false,"white");
					}
				}else{
					printAlert('Nombre incorrect',false,"white");
				}
		}else{
			printAlert('Destinataire incorrect',false,"white");
		}
		
		echo '</div>';

	break;
	
	case 'recieve':
		echo '<div id="confirm_colis" style="height:30px;">';
			printColisList($char);
		echo '</div>';
	break;
	
	case 'accept':
		$colis = new trade_letter($_GET['colis_id']);
		
		if($colis->getPrice() <= $char->getGold())
		{
			$colis->accepte();
			echo '<div style="height:30px;margin-left:40px;">';
				printConfirm("Le colis a &eacute;t&eacute; accept&eacute;");
			echo '</div>';		
		}else{
			printAlert("Vous n'avez pas assez d'or pour accepter ce colis");
		}
		
		printColisList($char);

	break;
	
	case 'refuse':
		$colis = new trade_letter($_GET['colis_id']);
		$colis->refuse();
		
		echo '<div style="height:30px;margin-left:40px;">';
			printConfirm("Le colis a &eacute;t&eacute; refus&eacute;");
		echo '</div>';
		
		printColisList($char);
	break;
	
 }
 
 
 function printColisList($char)
 {
		echo '<table class="backgroundBodyNoRadius" style="margin:auto;width:600px;">';
			echo '<tr class="backgroundMenuNoRadius">';
				echo '<td colspan="7"><b> Vos colis en attente </td>';
			echo '</tr>';
			echo '<tr style="text-align:center;">';
				echo '<td>';
					echo 'Vendeur';
				echo '</td>';
				echo '<td>';
					echo 'Nombre';
				echo '</td>';
				echo '<td>';
					echo 'Objet';
				echo '</td>';
				echo '<td>';
						echo 'Prix';
				echo '</td>';
				echo '<td>';
					echo 'Accepter';
				echo '</td>';
				echo '<td>';
					echo 'Refuser';
				echo '</td>';
			echo '</tr>';
			echo '<tr style="height:1px;border-bottom:solid 1px white;">';
				echo '<td colspan="7" style="height:1px;border-bottom:solid 1px white;"></td>';
			echo '</tr>';

			$array_colis = trade_letter::getAllColis($char->getId());
			if(count($array_colis) > 0)
                        {
                            foreach($array_colis as $colis_info)
                            {
                                    $colis = new trade_letter($colis_info['id']);

                                    echo '<tr style="text-align:center;">';
                                            echo '<td>';
                                                    echo char::getNameById($colis->getSeller());
                                            echo '</td>';
                                            echo '<td>';
                                                    echo $colis->getNbItem();
                                            echo '</td>';
                                            echo '<td>';
                                                    echo '<img src="pictures/item/'.$colis->getItem().'.gif" alt="" /> ';
                                                    echo item::getNameById($colis->getItem());
                                            echo '</td>';
                                            echo '<td>';
                                                    echo $colis->getPrice();
                                            echo '</td>';
                                            echo '<td>';
                                                    $onclick = "HTTPTargetCall('page.php?category=trade&action=accept&colis_id=".$colis->getId()."','confirm_colis')";
                                                    echo '<a href="#" onclick="'.$onclick.'">Accepter</a>';
                                            echo '</td>';
                                            echo '<td>';
                                                    $onclick = "HTTPTargetCall('page.php?category=trade&action=refuse&colis_id=".$colis->getId()."','confirm_colis')";
                                                    echo '<a href="#" onclick="'.$onclick.'">Refuser</a>';
                                            echo '</td>';
                                    echo '</tr>';				
                            }
                        }
		echo '</table>';	
 }
?>