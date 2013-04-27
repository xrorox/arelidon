<?php

function pre_dump($var, $is_die=false) {
	echo '<div style="border:2px red solid;margin: 5px 5px 5px 5px;"><pre>';
	print_r($var);
	echo '</pre></div>';
	if($is_die){
		die();
	}
}

function pre_dump_error($var, $is_die=false) {
	echo '<div style="border:2px red solid;margin: 5px 5px 5px 5px;"><pre>';
	print_r($var);
	echo '</pre></div>';
	if($is_die){
		die();
	}
}

function cleanString($str)
{
	$str = htmlentities($str, ENT_QUOTES,'UTF-8');
	
	return $str;
}

function getCaractList($perso=1,$item=0,$effect=0)
{
	$array = array('1'=>'str','2'=>'con','3'=>'dex','4'=>'int','5'=>'sag','6'=>'res');
	
	if($perso == 1)
		$array[] = 'cha';
	
	if($item == 1)
	{
		$array[] = 'life';
		$array[] = 'mana';
	}
	
	if($effect == 1)
		$array[] = 'dmg';

	return $array;
}

function getCaract($abrev)
{
	switch($abrev)
	{
		case 'str':
			$caract = 'Force';
		break;	
		case 'dex':
			$caract = 'Dext&eacute;rit&eacute;';
		break;	
		case 'con':
			$caract = 'Constitution';
		break;	
		case 'int':
			$caract = 'Intelligence';
		break;	
		case 'sag':
			$caract = 'Sagesse';
		break;	
		case 'res':
			$caract = 'R&eacute;sistance';
		break;
		case 'cha':
			$caract = 'Chance';
		break;	
		case 'life':
			$caract = 'Vie';
		break;
		case 'mana':
			$caract = 'Mana';
		break;		
	}
	
	return $caract;
}


function UcFirstAndToLower($str)
{
     return ucfirst(strtolower(trim($str)));
}


function imgWithTooltip($imgurl,$txt,$onclick='',$style_img='',$style_tooltip='',$spanstyle='',$return=false,$class = '', $id=0)
{
	
	$str = '<a href="#" style="'.$style_tooltip.'" class="tooltip '.$class.'" onclick="'.$onclick.'">' .
			'<img src="'.$imgurl.'" style="border:0px;'.$style_img.'" alt="'.$txt.'" />' .
					'<em style="'.$spanstyle.'">' .
							'<span style="font-size:1px;">.</span> '.$txt.' ' .
                                                        '<input type="hidden" value="'.$id.'"/>'.
					'</em>' .
		  '</a>';
	
	if($return)
		return $str;
	else
		echo $str;
}

function getBodyPartList()
{
	$array = array('1'=>'hand','2'=>'hand2','3'=>'body','4'=>'body2','5'=>'head','6'=>'foot','7'=>'hand3','8'=>'finger','9'=>'neck');
	return $array;
}

function getEquipName($type)
{
	switch($type)
	{
		case 'hand':
			$type_name = 'main droite';
		break;
		case 'hand2':
			$type_name = 'main gauche';
		break;
		case 'head':
			$type_name = 't&ecirc;te';
		break;
		case 'body':
			$type_name = 'armure';
		break;
		case 'body2':
			$type_name = 'ceinture';
		break;
		case 'foot':
			$type_name = 'pieds';
		break;
		// gants
		case 'hand3':
			$type_name = 'gants';
		break;
		case 'finger':
			$type_name = 'doigt';
		break;
		case 'neck':
			$type_name = 'cou';
		break;
	}	
	
	return $type_name;
}



function getAllItemTypes()
{
	$arrayItems = array();
	
	$arrayItem = array('0'=>'ressource','999'=>'potion','998'=>'objet qu&ecirc;te');
	$sql = "SELECT * FROM classeobjet ";
	$result = loadSqlResultArrayList($sql);
	
	foreach($result as $row)
	{
		$arrayItem[$row['id']] = $row['nom'];
	}
	
	return $arrayItem;
}
/*TODO*/ 
 function timestampToHour($heure, $sep,$sep2='',$sep3='')
  {
  	
	   $texte = "";
	   
	   $retour = getdate($heure);
	   $h = $retour["hours"];
	   $m = $retour["minutes"];
	   $s = $retour["seconds"];
	   
	   $z = "0";
	   
	   $h2 = ($h < 10)?$z.$h:$h;
		
	   $m2 = ($m < 10)?$z.$m:$m;
	
	   $s2 = ($s < 10)?$z.$s:$s;
	   
	   
	   
	   if($h2 > 0)
	   	$texte .= $h2.$sep;
	   
	   if($m2 > 0)
	   	$texte .= $m2;
	   
	   if($sep2 != '' && $m2 > 0)
	   		$texte .= $sep2;
	   if($sep3 != '' && $s2 >= 1)
	   		$texte .= $s2.$sep3;
	   
	   if($texte == '' && $s2 > 0)
	   		$texte .= $s2.' secondes'; 
	   
	   return $texte; 
  }
/*TODO*/
function timestampToDate($date, $sep)
{
	$retour = getdate($date);
	$j = $retour["mday"];
	$m = $retour["mon"];
	$a = $retour["year"];
	
	$z = "0";
	
	$j2 = ($j < 10)?$z.$j:$j;
	
	$m2 = ($m < 10)?$z.$m:$m;
	
	$texte = $j2.$sep.$m2.$sep.$a;
	return $texte;
}
/*TODO */
function convertSecondToHour($time)
{
	
	$day = floor($time / 86400);
	$time = $time - ($day * 86400);
	$hour = floor($time / 3600);
	$time = $time -($hour * 3600);
	$min = floor($time / 60);
	
	$text = "";
	
	if($day > 0)
		$text .= $day." jours ";
	if($hour > 0)
		$text .= $hour." heures ";
	if($min > 0)
		$text .= $min." minutes ";
		
	return $text;
	
	
}

function getAutocomplete($type,$filter=array())
{
	switch($type)
	{
		case 'item':
			$arrayItem = item::getAllItemsName();
			$array = implode('|',$arrayItem);
		break;
		case 'pnj':
			$pnjList = pnj::getAllPnj('name');
			$arrayPNJ = array();			
			foreach($pnjList as $pnj)
			{
				$arrayPNJ[] = $pnj['name'];
			}
			$array = implode('|',$arrayPNJ);
		break;
		case 'monster':
			$monsterList = monster::getAllMonsters('nom');
			$arrayMonster = array();			
			foreach($monsterList as $monster)
			{
				$arrayMonster[] = $monster['nom'];
			}
			$array = implode('|',$arrayMonster);
		break;
		case 'step':
			$monsterList = step::getAllStepName();
			$arrayMonster = array();			
			foreach($monsterList as $monster)
			{
				$arrayMonster[] = $monster['name'];
			}
			$array = implode('|',$arrayMonster);
		break;
		case 'shop':
			$shopList = shop::getAllShopName();
			$arrayShop = array();			
			foreach($shopList as $shop)
			{
				$arrayShop[] = $shop['name'];
			}
			
			$shopSkillList = shop_skill::getAllShopName();
			
			foreach($shopSkillList as $shop)
			{
				$arrayShop[] = $shop['name'];
			}
			
			$array = implode('|',$arrayShop);
		break;
		case 'fonction_pnj':
			$shopList = shop::getAllShopName();
			$arrayShop = array();			
			foreach($shopList as $shop)
			{
				$arrayShop[] = $shop['name'];
			}
			
			$shopSkillList = shop_skill::getAllShopName();
			
			foreach($shopSkillList as $shop)
			{
				$arrayShop[] = $shop['name'];
			}
			
			$array = implode('|',$arrayShop);
		break;
		case 'chars':
			$charList = char::getAllCharName($filter);
			$arrayChar = array();	
                        if(count($charList) > 0)
                        {
                            foreach($charList as $char)
                            {
                                    $arrayChar[] = $char['name'];
                            }
                        }
			$array = implode('|',$arrayChar);
		break;
		case 'user':
			$userList = char::getAllCharName($filter);
			$arrayUser = array();			
			foreach($userList as $shop)
			{
				$arrayUser[] = $shop['name'];
			}
			$array = implode('|',$arrayUser);
		break;
		case 'skill':
			$skillList = skill::getAllSkill($filter);
			$arrayShop = array();			
			foreach($skillList as $skill)
			{
				$arraySkill[] = addslashes($skill['name']);
			}
			$array = implode('|',$arraySkill);
		break;
		case 'obstacle':
			$sql = "SELECT name FROM `obstacle`";
			$obstacles = loadSqlResultArrayList($sql);	

			foreach($obstacles as $obstacle)
			{
				$arrayObstacle[] = addslashes($obstacle['name']);
			}
			
			$array = implode('|',$arrayObstacle);
		break;
		case 'skin':
			$sql = "SELECT name FROM `skin`";
			$skins = loadSqlResultArrayList($sql);	

			foreach($skins as $skin)
			{
				$arraySkin[] = addslashes($skin['name']);
			}
			
			$array = implode('|',$arraySkin);
		break;
	}
	
	return $array;
	
}

function createHTMLBox($title="",$action="",$icon="",$content="",$width="75%")
{
	$box = new HTMLBoxContainer();
	$box->setTitle($title);
	$box->setAction($action);
	$box->setIcon($icon);

	$box->setContent($content);

	$box->setWidth($width);
	$box->show();
}

function createBox160($content,$return=false)
{
	$str = '<div style="background-image:url(\'pictures/utils/box_top.png\');height:7px;width:160px;">';
	
	$str .= '</div>';
	$str .= '<div style="background-image:url(\'pictures/utils/box_middle.png\');width:160px;">';
		$str .= $content;
	$str .= '</div>';
	$str .= '<div style="background-image:url(\'pictures/utils/box_bottom.png\');height:7px;width:160px;">';
	
	$str .= '</div>';	
	
	if($return)
		return $str;
	else
		echo $str;
}


function createButton($title,$onclick="",$div="",$link="",$padding="7",$return=false,$addstyle="",$style="text-align:none;")
{
	if(empty($div))
		$div = mt_rand(1,1205958738);
	
	$str = '<div id="'.$div.'" style="text-align:center;margin-top:0px;'.$addstyle.'">';	
	if($link != "")
		$str .= '<a href="'.$link.'" style="text-decoration:none;">';
	$str .= '<input class="button" style="'.$style.'" type="button" onclick="'.$onclick.'" value="'.$title.'" /></a>';			
	$str .= '</div>';	
	
	if($return)
		return $str;
	else
		echo $str;
}

function createTexte($texte,$style=array(),$style_add=array(),$return=false)
{
	if(count($style) == 0)
		$style=array('margin-left'=>'20px','width'=>'75%','height'=>'100%','padding'=>'10px','margin-top'=>'10px');		
	
	$style_string = "";
	foreach($style as $row=>$value)
		$style_string .= $row.':'.$value.';';
	if(count($style_add)>= 1)
		foreach($style_add as $row=>$value)
			$style_string .= $row.':'.$value.';';	

	$str = '<div class="text_bulle" style="'.$style_string.'">';
		$str .= $texte;
	$str .= '</div>';
	
	if($return)
		return $str;
	else
		echo $str;
}

function getGoldPict($return=false)
{
	$str = '<img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="pi�ce d\'or" />';
	if($return)
		return $str;
	else
		echo $str;
}

function getPAPict($return=false)
{
	$str = '<img src="pictures/utils/pa.png" title="Point d\'action" alt="PA" />';
	if($return)
		return $str;
	else
		echo $str;	
}

function getPPPict($return=false)
{
	$str = '<img src="pictures/utils/pp.png" title="Point de profession" alt="PP" style="width:16px;height:16px;" />';
	if($return)
		return $str;
	else
		echo $str;	
}

function printAlert($str,$return=false,$color='black',$style="")
{
	if(!empty($str))
	{
		$string = '<div style="'.$style.'">';
		$string .= '<img src="pictures/utils/alert.gif" alt="<!>" /> ';
		$string .= '<b><span style="color:'.$color.'">'.$str.'</span></b>';
		$string .= '</div>';
		if($return)
			return $string;
		else
			echo $string;		
	}
}

function printConfirm($str,$return=false,$color="black")
{
	if(!empty($str))
	{	
		$string = '<div style="margin-top:3px;">';
		$string .= '<div style="float:left;">';
		if(file_exists('pictures/utils/valid.png'))
			$string .= '<img src="pictures/utils/valid.png" alt="<!>" /> ';
		else
			$string .= '<img src="../../pictures/utils/valid.png" alt="<!>" /> ';
		$string .= '</div>';
		
		$string .= '<div style="float:left;width:85%;margin-left:8px;color:'.$color.'">';
		$string .= '<b>'.$str.'</b>';
		$string .= '</div>';
	
		$string .= '</div>';
		if($return)
			return $string;
		else
			echo $string;
	}
}

function getDateText($time,$type,$withHour='no',$return=false)
{
	switch($type)
	{
		case 'inteligent':
			if((time() - $time) < 86400)
			{
				$str .= "Aujourd'hui ";
			}elseif((time() - $time) < 172800)
			{
				$str .= "Hier ";
			}else{
				$nbday = floor((time() - $time) / 86400);
				$str .= "Il y a $nbday jours";
			}
		break;
		case 'classic':
			$str = "Le ".timestampToDate($time,'/');
			$str .= " &agrave; ";
			$str .= timestampToHour($time,'h');
		break;
	}
	
	
	
	if($return)
		return $str;
	else
		echo $str;
}

/*TODO */
function getTextFromSecondes($time)
{
	$str = "";
	// Calcul des jours
	$day = $time / 86400;
	$day = floor($day);
	
	if($day >= 1)
	{
			if($day == 1)
			$str .= "1 jour";
		else
		{
			$day = floor($day);
			$str .= "$day jours";
		}	
		$time = $time - ($day * 86400);
	}

	// Calcul des heures
	$hours = $time / 3600 ;

	if($hours >= 1)
	{
		if($str != "")
			$str .= " et ";
		if($hours >= 1)
			if($hours == 1)
				$str .= "1 heure";
			else
			{
				$hours = floor($hours);
				$str .= "$hours heures";
			}	
		$time = $time - ($hours * 3600);
	}	
	
	if($day < 1)
	{
		if($str != "")
			$str .= " et ";
		// Si moins longtemp que heure , alors on affiche les minutes
		$minutes = $time / 60 ;
		if($minutes >= 1)
		{
			if($minutes >= 1)
			{
				$minutes = floor($minutes);
				$str .= "$minutes minutes";
			}		
		}	
	
	}
	return $str;
}

function getFicheUser($char,$style="",$style2="",$return=false)
{
	$classe = $char->getFactionName();
	
	$str = '<div style="'.$style.'">';
		$style2 .= "width:160px;height:155px;";
		if($char->isConnect())
		{
			$style2 .= 'background-color:green;';
		}	
		else
		{
			$style2 .= 'background-color:grey;';
		}	
		$str .= '<div style="'.$style2.'">';
			$str .= '<div style="font-weight:700;font-size:18px;">';
				$str .= $char->getName();
			$str .= '</div>';
			
			$str .= '<div>';
				$str .= '<div style="float:left;border:solid 1px grey;background-color:black;margin-left:5px;">';
					$str .= getAvatar($char,'',true);
				$str .= '</div>';
				
				$str .= '<div style="float:left;margin-left:5px;text-align:center;width:40px;font-weight:700;">';
					$str .= 'Niv '.$char->getLevel();
					$str .= '<br /><br />';
					$str .= '<img src="'.$char->getUrlPicture('ico',1).'" title="'.$classe.'" alt="'.$classe.'"  />';
				$str .= '</div>';
				
			$str .= '</div>';
			
		$str .= '</div>';	
	$str .= '</div>';
	
	if($return)
		return $str;
	else
		echo $str;
}

function getAvatar($char,$style='',$return=false)
{
	// pour le moment pas d'avatar g�r�s , on renvoit l'avatar de la classe
	$url = $char->getUrlPicture('avatar',0,true);
	
	$str = '<img src="'.$url.'" style="'.$style.'" alt="'.$char->getFactionName().'" />';
	if($return)
		return $str;
	else
		echo $str;
}

function getLinkSendMessage($char,$popup=false,$return=false)
{
	$url = "page.php?category=messagerie&action=new&to_prevalue=".$char->getName();
	if(!$popup)
		$onclick = "HTTPTargetCall('$url','box_container');";
	else
		$onclick = "openPopup('$url','Fiche du personnage ".$char->getName()."','width=390,height=40')";
	$str = '<img onclick="'.$onclick.'" src="pictures/utils/noread.gif" title="envoyer un message &agrave; ce joueur" alt="Envoyer un message" />';
	if($return)
		return $str;
	else
		echo $str;
}

function getRankGuild($rank,$return=false)
{
	switch($rank)
	{
		case '0':
			$str = "Meneur";
		break;
		case '1':
			$str = "Seigneur";
		break;
		case '2':
			$str = "Soldat";
		break;
	}
	
	if($return)
		return $str;
	else
		echo $str;
}

function getSkillListMenu($char,$stylea,$target,$player=false)
{
	
	
	
	// Actions possibles 
 
	 echo '<div style="font-size:16px;text-decoration:underline;"> Action : </div>';
	 
	 echo '<div id="actions" style="margin-top:15px;margin-left:0px;height:30px;">';
	 
	 // Gestion des sorts

	$skillList = $char->getSkillList();
	foreach($skillList as $skill)
	{
		
		if($skill['id'] >= 1)
		{
			echo '<div style="width:32px;height:32px;text-align:center;float:left;margin-left:6px;">';
				echo '<form id="skill_form_'.$skill['id'].'" action="ingame.php?page=game&refresh=2" method="post">';
				
				echo '<input type="hidden" name="action" value="skill" />';
				echo '<input type="hidden" name="idskill" value="'.$skill['id'].'" />';
				echo '<input type="hidden" name="idmonster" value="'.$target->getId().'" />';
				
				if($player)
				{
					echo '<input type="hidden" name="player" value="1" />';
					echo '<input type="hidden" name="mode" value="player" />';
				}
				else
				{
					echo '<input type="hidden" name="mode" value="monster" />';
					echo '<input type="hidden" name="player" value="0" />';
				}
					
				$distance = verifDistance2Char($char,$target,false);
				
				$url = "include/menuig.php?refresh=2&distance=".$distance."&id=".$target->getId()."&pvp=1";
				$post = "skill_form_".$skill['id'];
				$target2 = "menuig";
				$onclick = "HTTPPostCall('$url','$post','$target2');refreshMap();refreshBarres();refreshInfos();";
				
				$skill_objet = new skill($skill['id']);
				
				// Si on est silence (et sort mana) ou sort passif on ne peut pas le lancer
				if($skill_objet->getManaCost() > 1 && $char->isSilence() or $skill_objet->getTypeSort() == 5)
				{
					$onclick="";
					$styleSup="opacity:0.5;";
				}else{
					$styleSup="";
				}
				
				
				echo '<a href="#" style="'.$stylea.'" class="tooltip">';
					echo '<img onclick="'.$onclick.'" src="pictures/skill/'.$skill['id'].'.gif" style="width:30px;height:30px;border:0px;'.$styleSup.'" /> ';
				echo '<em style="margin-top:5px;min-width:100px;"><span></span> '.$skill['name'].' </em></a>';
			
				echo '</form>';
			echo '</div>';
		}else{
			echo '<div style="width:32px;height:32px;text-align:center;float:left;margin-left:6px;">';
				echo '<a href="#" style="'.$stylea.'" class="tooltip">';
					echo '<img src="pictures/skill/'.$skill['id'].'.gif" style="width:30px;height:30px;border:0px;" /> ';
				echo '<em style="margin-top:5px;min-width:100px;"><span></span> Pas de sort </em></a>';
			echo '</div>';
		}
	}
	echo '</div>';
} 

function verifDistance2Char($char,$char2,$bool=false)
{
	if($char->getMap() == $char2->getMap())
	{
		
		$a = $char2->getAbs() - $char->getAbs(); // �cart horizontale
		$b = $char2->getOrd() - $char->getOrd(); // �cart verticale
		
		$absb = abs($b);	
		if($char->getOrd() < $char2->getOrd())
			$absb--;
		
		if(abs($a) <= 1 && $absb <= 1)
		{
			$distance = 1;
		}else{
			$distance = abs($a) + $absb;	
		}	
	}else{
		$distance = 100;			
	}

	if(!$bool)
		return $distance;
	else
		if($distance <= 1)
			return true;
		else
			return false;
}	

function showBarre($type,$pourcent,$min=0,$max=0,$showpourcent=true)
{
	switch($type)
	{
		case 'exp':
			$name = 'Exp';
			$color = 'green';
		break;
		case 'life':
			$name = 'Vie';
			$color = 'red';
		break;
		case 'mana':
			$name = 'Mana';
			$color = 'blue';
		break;
	}
	$pourcentShow = $pourcent * 1.5;
	
	
	echo '<span style="margin-top:-7px;">';
	
	if($showpourcent)
	{
		if($type != 'exp')
			echo '<span style="margin-left:20px;font-weight:700;font-size:10px;"> '.$name.' : '.$min.'/'.$max.' </span>';
		else
			echo '<span style="margin-left:20px;font-weight:700;font-size:10px;"> '.$name.' : '.$pourcent.'% </span>';
				
	}

		echo '<div class="barre" style="margin-left:0px;border:solid 1px black;height:4px;width:150px;background-color:black;">';	
		echo '<div class="barre" style="width:'.$pourcentShow.'px;height:5px;background-color:'.$color.';"></div>';
		echo '</div>';
	echo '</span>';
	
} 

function selectRandRate()
{
	$randRand = mt_rand(1,100);
	if($randRand < 40)
	{
		$rand = 5;
	}elseif($randRand < 70)
	{
		$rand = 10;
	}elseif($randRand < 85)
	{
		$rand = 15;
	}elseif($randRand < 95)
	{
		$rand = 20;
	}else{
		$rand = 25;
	}
	$rand = mt_rand(1,$rand);
	$neg = mt_rand(1,2);
	if($neg == 2)
	{
		$rand = $rand * -1;
	}
	$rand = $rand / 100;
	return $rand;
	
}

function verifDistance($idchar,$idmonster,$idskill,$return_distance=false)
{
	$verifchar = new char($idchar);
	$verifmonster = new monster($idmonster);
	$skill = new skill($idskill);

	if($verifchar->map == $verifmonster->map)
	{
		$distance = calculDistance($verifchar->abs,$verifchar->ord,$verifmonster->abs,$verifmonster->ord,$verifmonster->taille);
		if($distance <= $skill->getRangeMax() or $skill->getTypeSort() == 3)
		{
			if($distance >= $skill->getRangeMin() or $skill->getTypeSort() == 3)
				$txt = 0;
			else
				$txt = 'Le monstre est trop pr&egrave;s';
		}else{
			$txt = 'Le monstre est trop loin';
		}
	}else{
		$txt = 'Le monstre est sur une autre carte';
	}

	if($return_distance)
		return $distance;
	else
		return $txt;
}



function getSelectTailleForm($preselect)
{
	$str = '<select name="taille" id="taille" onchange="changeTelep(\'taille\');" style="background:url(pictures/taille/1.gif) no-repeat; width:50px; height:38px;">';
		for($i=1;$i<=4;$i++)
		{
			switch($i)
			{
				case '1':
					$width='32';
					$height='32';
				break;
				
				case '2':
					$width='32';
					$height='64';
				break;
				
				case '3':
					$width='64';
					$height='32';
				break;
				
				case '4':
					$width='64';
					$height='64';
				break;
			}
			$str .= '<option value="'.$i.'" style="background:url(pictures/taille/'.$i.'.gif) no-repeat; width:'.$width.'px; height:'.$height.'px;" ';
			if($preselect == $i)
					$str .= 'SELECTED=selected';
			$str .= '></option>';
		}
	$str .= '</select>';
	
	return $str;	
}

function getMarginWitdhHeightByTaille($taille,$abs,$ord)
{
	switch($taille)
	{
		case '0':
			// Pour des images en 24x24
			$marginLeft = ($abs - 1) * 32 + 4;
			$marginTop = ($ord  - 1) * 32 + 4;
			$width='24';
			$height='24';
		break;
		case '1':
			$marginLeft = ($abs - 1) * 32;
			$marginTop = ($ord  - 1) * 32;
			$width='32';
			$height='32';
		break;
		
		case '2':
			$marginLeft = ($abs - 1) * 32;
			$marginTop = ($ord  - 2) * 32;
			$width='32';
			$height='64';
		break;
		
		case '3':
			$marginLeft = ($abs - 1) * 32;
			$marginTop = ($ord  - 1) * 32;
			$width='64';
			$height='32';
		break;
		
		case '4':
			$marginLeft = ($abs - 1) * 32;
			$marginTop = ($ord  - 2) * 32;
			$width='64';
			$height='64';
		break;
	}
	
	return array('marginLeft'=>$marginLeft,'marginTop'=>$marginTop,'width'=>$width,'height'=>$height);
}


function cleanAccent($string)
{
	$array_convert = array('&ccedil;','&eacute;','&egrave;','&agrave;','&acirc;','&icirc;','&ecirc;','&ocirc;');
	foreach($array_convert as $caract)
	{
		$array[$caract] = htmlentities($caract);
	}	
	foreach($array as $caract=>$caract_decode)
	{
		$string = str_replace($caract,$caract_decode,$string);
	}
	return $string;
}

function getGoldForLevel($level)
{
	if($level <= 10)
		$gold = 2500;
	elseif($level <= 20)
		$gold = 5000;
	elseif($level <= 30)
		$gold = 10000;
	elseif($level <= 40)
		$gold = 20000;
	else
		$gold = 50000;
	
	return $gold;		
}

function getSmileyArray()
{
	$array = array(
		':)'=>'smile',
		':('=>'triste',
		':|'=>'deg',
		'(6)'=>'demon',
		':@'=>'furax',
		'(A)'=>'ange',
		':$'=>'timide',
		':#'=>'beurk',
		'aaah'=>'aaah',
		':aie'=>'aie',
		':hihi'=>'hihi',
		':p'=>'langue',
		':bye'=>'bye',
		':love'=>'love',
		':erf'=>'erf',
		':siffle'=>'siffle',
		';)'=>'clin',
		':lol'=>'rire',
		':D'=>'heureux',
		'oO'=>'blink'
	);
	
	foreach($array as $key=>$word)
	{
		$array_finish[$key] = '<img src="pictures/smiley/'.$word.'.gif" alt="'.$key.'" style="height:18px;width:18px;" />';
	}
	
	return $array_finish;
}

function getNumberOfRegister()
{
		$result = get_cache('user','user_nbr');
		if (is_bool($result))
		{
			$sql = "SELECT COUNT(*) FROM `users` ";
			$result=loadSqlResult($sql);
		create_cache('user','user_nbr', $result);
		}	
		return $result;	
	}
        
       function calculDistance($abs,$ord,$abs2,$ord2,$taille)
            {	
		$a = $abs2 - $abs; // �cart horizontale	
		$b = $ord2 - $ord; // �cart verticale
			
		$absa =  abs($a);	
		$absb = abs($b);
			
		// Valeur absolue du r�sultat	
		$distance = $absa + $absb;
				
		switch($taille)	
		{	
			case '1':	
				$distance = $distance;	
			break;					
			case '2':	
				if ($ord2 > $ord){	
					$ord3 = $ord2 -1;	
				}	
				else{	
					$ord3 = $ord2;		
				}
	
				$a = $abs2 - $abs; // �cart horizontale	
				$b = $ord3 - $ord; // �cart verticale
		
				// Valeur absolue du r�sultat	
				$distance2 = abs($a) + abs($b);
	
				if($distance2 < $distance && $distance2 != 0)	
					$distance = $distance2;
	
			break;	
			case '3':
	
			if ($abs2 > $abs){	
				$abs3 = $abs2 - 1;	
			}	
			else{	
				$abs3=$abs2;	
			}
	
				$a = $abs3 - $abs; // �cart horizontale	
				$b = $ord2 - $ord; // �cart verticale
			
				// Valeur absolue du r�sultat	
				$distance2 = abs($a) + abs($b);
	
				if($distance2 < $distance && $distance2 != 0)	
					$distance = $distance2;	
			break;					
			case '4':						
				$abs3=$abs2 +1;	
				$ord3=$ord2;
						
				$a=$abs3 -$abs;	
				$b=$ord3-$ord;
						
				$distance2 = abs($a) + abs($b);
	
				if($distance2 < $distance && $distance2 != 0){	
					$distance = $distance2;
	
				if(abs($a) == 1 && abs($b) == 1)	
					$distance = 1;
	
				}	
	
				$abs3=$abs2;	
				$ord3=$ord2 -1;
						
				$a=$abs3 -$abs;	
				$b=$ord3-$ord;
		
				$distance2 = abs($a) + abs($b);
	
				if($distance2 < $distance && $distance2 != 0){
					$distance = $distance2;	
	
				if(abs($a) == 1 && abs($b) == 1)
					$distance = 1;
	
				}	
	
				$abs3=$abs2 +1;	
				$ord3=$ord2 -1;
	
				$a=$abs3 -$abs;	
				$b=$ord3-$ord;
	
				$distance2 = abs($a) + abs($b);
	
				if($distance2 < $distance && $distance2 != 0){
					$distance = $distance2;	
	
				if(abs($a) == 1 && abs($b) == 1)
					$distance = 1;
				}	
			break;	
		}
		
		$a = $abs2 - $abs; 
	
		$b = $ord2 - $ord; 
		
		// Cas ou l'on est en diagonal => permission d'attaquer	
		if(abs($a) == 1 && abs($b) == 1)	
			$distance = 1;
	
		return $distance;
	}
        
function getPict($valid,$title,$num)
{
	if($valid)
	{
		$txt = '<img src="pictures/utils/mini-valid.gif" alt="Valide" title="'.$title.'" />';	
		$txt .= '<span id="form_valid_'.$num.'" style="display:none;">1</span>';
		return $txt;
	}else{
		$txt = '<img src="pictures/utils/mini-no.gif" alt="Pas valide" title="'.$title.'" />';	
		$txt .= '<span id="form_valid_'.$num.'" style="display:none;">0</span>';
		return $txt;
	}
}
?>
