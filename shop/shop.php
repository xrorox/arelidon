<div class="clear"></div>

<div>
<!--	 Contiendra le conteneur de texte-->
    <div style="float:left;width:560px;border-right:1px;margin-left:10px;">	
	<div id="shop_text_container">
            <?php
                require_once($server.'pageig/shop/status.php');
            ?>
		</div>	
	</div>
	
    <!--	 Liste des objets que l'utilisateur pourra vendre-->

    <div  style="float:left;margin-right:5px;margin-top:5px;margin-left:20px;">	
        <label for="restrict"> Trier : </label>
        <select id="restrict" name="restrict" onchange="changeRestrict(this.value,<?php echo $_GET['pnj'] ?> );">
            <option value="" > Tous</option>
        <?php
            foreach($arrSelect as $option)
            {
                if(isset($_GET['restrict']) && $_GET['restrict'] == $option['id'])
                    $select = 'selected="selected"';
                else
                    $select = '';

                echo '<option '.$select.' value="'.$option['id'].'">'.$option['name'].'</option>';
            }
        ?>
        </select>
    </div>

    <div  style="float:left;margin-right:5px;margin-top:25px;">
        <div class="backgroundBody" style="width:200px;">
            <div class="backgroundMenu">
                <div style="margin-left:15px;">Vos objets</div>
            </div>
            <div id="item_container" style="height:170px;">
                <div style="font-weight:500;text-align:center;"> 
                    Votre bourse : <?php echo $char->getGold(); ?>
                    <img src="pictures/utils/or.gif" title="pi&egrave;ce d\'or" alt="or" />
                </div>
                <table>
                <?php	
			$j = 1;
			$limiteByLine = 6; 
                        
			$url_target = "pageig/shop/text_shop.php?action=sell&pnj=".$pnj->getId();
			$div_target = "shop_text";					
                        
                      if(count($char_inventary) > 0)
                      {
			foreach($char_inventary as $item_id)
			{
                            $item = new item($item_id['item_id']);			

                            if( $j == 1)
                                    echo '<tr>';	
                          

                            // Création du onclick si besoin		
                            $url_onclick = $url_target."&item_id=".$item_id['item_id'];
                            $target = $div_target;

                            if($target != "")	
                                    $onclick = "EmptyShopText();HTTPTargetCall('$url_onclick','$target');";
                            else
                                    $onclick = "";

                            $style = "";
                            $spanstyle= "width:150px;";

                            echo '<td>';
                                echo $item->getPictureWithToolTip($onclick,'',$style,$spanstyle,'true');
                            echo '</td>';

                            if($j == $limiteByLine )
                            {
                                    echo '</tr>';
                                    $j = 0;
                            }		
                            $j++;
				
                    }
                  }
                  else
                  {
                      echo "Votre inventaire est vide.";
                  }
             ?>
                </tr>
                </table>
            </div>

        </div>
         <?php
            $link = "ingame.php";
            createButton('Sortir',"",'exit',$link);
          ?>

    </div>
</div>


<!-- Liste des objets en vente-->
<div  style="float:left;margin-right:5px;margin-top:5px;margin-left:20px;">
    <div class="backgroundBody" style="width:380px;">
        <div class="backgroundMenu">
            <div style="margin-left:15px;"> Objets en vente</div>
	</div>
	<div id="item_container" style="height:120px;">
            <table>
		<?php	
			$j = 1;
			$limiteByLine = 12; 
                        
			$url_target = "pageig/shop/text_shop.php?action=buy&pnj=".$pnj->getId();
			$div_target = "shop_text";
                        
                        
		       if(count($item_collection) > 0)
                       {
                            foreach($item_collection as $item_id)
                            {
                                $item = new item($item_id['item_id']);			

                                if( $j == 1)
                                        echo '<tr>';	

                                                                // Création du onclick si besoin		
                                $url_onclick = $url_target."&item_id=".$item_id['item_id'];
                                $target = $div_target;

                                if($target != "")	
                                        $onclick = "EmptyShopText();HTTPTargetCall('$url_onclick','$target');";
                                else
                                        $onclick = "";

                                $style = "";
                                $spanstyle= "width:150px;";

                                echo '<td>';
                                    echo $item->getPictureWithToolTip($onclick,'',$style,$spanstyle,'true');
//                                    
                                echo '</td>';

                                if($j == $limiteByLine)
                                {
                                        echo '</tr>';
                                        $j = 0;
                                }	

                                $j++;

                        }
                  }
                  else
                  {
                      echo "Le magasin ne vend pas de type d'objet.";
                  }
             ?>
            </tr>
           </table>
	</div>
    </div>
</div>
	
<!--// Le Pnj qui vend-->
<div  style="float:left;margin-right:5px;margin-top:5px;margin-left:20px;">
    <div class="backgroundBody" style="width:150px;">
        <div class="backgroundMenu">
            <div style="margin-left:15px;"> Marchand </div>
	</div>
	<div id="face_container" style="height:120px;">
            <div style="text-align:center;margin-top:15px;">
                <img src="pictures/face/<?php echo $pnj->getFace();?>" style="border:solid 2px black;background:grey;" />
            </div>
	</div>
    </div>
</div>
