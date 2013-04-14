<table width="530" border="0" cellspacing="0" cellpadding="0" style="font-size:0px;">
	<tr>
	  <td colspan="3" background="pictures/grandtitre_12.jpg" height="24">
	  <div align="center"><span class="Style2">Bienvenue sur</span><span class="Style1"> <span class="Style3"> Irelion </span></span></div></td>
	  </tr>
	<tr>
	  <td colspan="3" height="8"></td>
	  </tr>
	<tr>
	  <td colspan="3" style="font-size:0px;"><img src="pictures/grandfondnoir_17.jpg" width="535" height="8" alt=""></td>
	  </tr>
	<tr>
	  <td height="6" colspan="3" background="pictures/grandfondnoir_19.jpg"><div align="justify">
	<p class="Style4"><span class="Style2">MMORPG M&eacute;di&eacute;val / dark-fantasy par navigateur :</span><br>
	  <br>
	  	Irelion est un jeu jouable par navigateur, qui utilse les bases du RPG (caract�ristiques, monstres, guilde, sorts, artisanat), mais qui vous offre
	  	en plus une jouabilit� unique avec son syst�me de groupe de combat, des combats dynamiques � la Final Fantasy, une histoire origninale.
	  	
	  	
	  </p>
	</div></td>
	  </tr>
	<tr>
	  <td colspan="3" style="font-size:0px;"><img src="pictures/grandfondnoir_21.jpg" width="535" height="7" alt=""></td>
	  </tr>
	<tr>
	  <td colspan="3" height="8"></td>
	  </tr>
	<tr>
	  <td background="pictures/petittitre_23.jpg" width="297" height="24"><div align="center" class="Style1"> Apercu </span></div></td>
	  <td rowspan="3" width="5"></td>
	  <td background="pictures/petittitre_25.jpg" width="228" height="24"><div align="center" class="Style1">Les <span class="Style3">News</span> </div></td>
	</tr>
	<tr>
	  <td height="8"></td>
	  <td height="8"></td>
	</tr>
	<tr>
			  
			  <!-- Debut du background (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->
			  
	  <td valign="top"><table width="297" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	      <td style="font-size:0px;"><img src="pictures/fondcadrebg_28.jpg" width="297" height="9" alt=""></td>
	    </tr>
	    <tr>
	      <td background="pictures/fondnoirbg_34.jpg" width="297" height="14">
	            <br>
	            <div id="bodypreview" style="text-align:center">
	            	<?php require_once($server.'/include/bodypreview.php'); ?>
	            </div>
	        </td>
	    </tr>
	    <tr>
	      <td style="font-size:0px;"><img src="pictures/fondnoirbg_36.jpg" width="297" height="10" alt=""></td>
	    </tr>
	  </table></td>
				
				 <!-- Fin du background (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->
				 
	  <td valign="top"><table width="228" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	      <td style="font-size:0px;"><img src="pictures/fondnoirnews_29.jpg" width="228" height="13" alt=""></td>
	    </tr>
	    <tr>
				  
				   <!-- Debut des news (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->
				   
	      <td background="pictures/fondnoirnews_32.jpg" width="228" height="12"><table width="228" height="187" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
	    <td><marquee direction="up" width="228" height="256" scrollamount="1" scrolldelay="10" onMouseOver="this.stop()" onMouseOut="this.start()">
	      <?php 
	      require_once($server.'/class/news.class.php');
			$array_news = news::getAllNews();
			foreach($array_news as $news)
			{
				$news = new news($news['id']);
				?>
				<p align="justify" style="margin-bottom:0px !important;padding-bottom:0px !important">
				
				<span class="Style7">[</span><span class="Style6"><?php echo $news->getDate2(); ?></span><span class="Style7">]</span> 
				<span class="Style2"><?php echo $news->getTitle(); ?></span>
				
				<br>
	        	<span class="Style7"><?php echo html_entity_decode($news->getContent()); ?></span>
				
				<!--  
				<div style="text-align:right">
	        		<a href="#" class="menu2">Voir la suite...</a>
	        	</div>
	        	-->
	        	</p>
				<?php
			}
		  ?>    
	      </marquee></td>
	      </tr></table></td>
					
					<!-- Fin des news (Erardorkwar2.psd - DESIGN par Antyoz 31-07-2008 -->
					
	    </tr>
	    <tr>
	      <td style="font-size:0px;"><img src="pictures/fondnoirnews_37.jpg" width="228" height="7" alt=""></td>
	    </tr>
	  </table></td>
	</tr>
</table>