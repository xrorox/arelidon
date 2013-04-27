<?php
/*
 * Created on 10 nov. 2009
 *
 */
require_once(absolutePathway().'utils/utils.php');
require_once(absolutePathway().'utils/fight.php');

if(!empty($_GET['classe_desc']))
    $classe_desc = $_GET['classe_desc'];
else
    $classe_desc = '';
?>

<div>	
<!-- Div qui va afficher les persos -->
    <div class="left marginTop100 marginLeft30 width150">';
 	<?php
 	 	$text = '<div class="center"><b>' .
 	 			'<a href="index.php?page=classes&classe_desc=1" class="nodecoration">' .
 	 			' Guerrier ' .
 	 			'</a></b>' .
 	 			'</div>';
		createBox160($text);
		
		$text = '<div class="center"><b>' .
 	 			'<a href="index.php?page=classes&classe_desc=2" class="nodecoration">' .
 	 			' Archer ' .
 	 			'</a></b>' .
 	 			'</div>';
		createBox160($text);
		
		$text = '<div class="center"><b>' .
 	 			'<a href="index.php?page=classes&classe_desc=3" class="nodecoration">' .
 	 			' Mage ' .
 	 			'</a></b>' .
 	 			'</div>';
		createBox160($text);
		
		$text = '<div class="center"><b>' .
 	 			'<a href="index.php?page=classes&classe_desc=4" class="nodecoration">' .
 	 			' Pr�tre ' .
 	 			'</a></b>' .
 	 			'</div>';
		createBox160($text);
         ?>
	<br /><br />

	
 	 </div>
 	 
 	 
 	  
 	 
<!-- 	  contient les infos et descriptifs-->
 	 <div class="left marginLeft20 marginTop30 border0black">
 	   
 	 
<!-- 	  Affichage dans le parchemin-->

		<div class="center marginTop10">
	
<!--	// Haut du parchemin			-->
		<div class="hautparchemin"></div>';

<!--// Div qui contiendra les infos de l'�tape / qu�te s�l�ctionn�e			-->
			<div id="quete_container" class="quetecontenaire">
				 <div class="heigth20"></div>
				<div id="desc"  class="fontElfique etapequete">
				<?php
				 switch($classe_desc)
			 	 {
			 	 	case 1 :
			 	 		    echo '<div class="center"> Le Guerrier </div><br />';
			 	 			echo "Tel le chevalier en quête perpétuelle, le seigneur de guerre local, le champion du roi, le fantassin d'élite, le mercenaire endurci tous sont des guerriers. Ils peuvent être le défenseur de la veuve et de l'orphelin ou bien de simples mercenaires aux services de ceux qui peuvent s'offrir leurs services.<br /><br />" .
			 	 					" Certains sont parmi les plus nobles héros du pays toujours prêts à risquer mille morts, tandis que d'autres ne faisant que peu de cas de la vie humaine tuent par intérêt ou par pur plaisir.<br /><br />" .
			 	 					" Rompu à la manipulation de quasiment toutes les armes et armures connues, ils ne sont pas connus pour être de grands amateurs de magie mais peuvent s'associer pleinement durant leurs missions avec des alliés profanes. Les missions dangereuses seront mieux appréciées car les dangers inhérents au combat leurs donneront plus d'excitation. ";
			 	 	break;
			 	 	case 2 :
							echo '<div class="center"> L\'archer </div><br />';
							echo "L'art de l'arc est considéré par certains comme un accomplissement spirituel et par d'autres comme un art philosophique. Pour certains c'est un véritable mode de vie et pour d'autres encore cela sera considéré comme une vraie religion. Naturellement beaucoup considérerons que le fait de tuer avec un arc est une compétence importante dans un monde aussi dangereux.<br /><br />
									La voie de l'arc est un art martial, c'est une question de précision et de discipline, tout est question de fusion entre soi même son arc et l'ennemi à abattre bien entendu. Quand on lui demande ce qu'est la vérité à un maître archer, il prend son arc, décoche une flêche et sans dire un mot, laisse sa maîtrise parler pour lui et ainsi vous faire constater sa vérité. 
								  ";
					break;
			 	 	case 3 :
					 	 	echo '<div class="center"> Le Mage </div><br />';
					 	 	echo "Mage spécialisé dans la magie noire et offensive. C'est souvent un érudit ayant appris ses sortilèges dans de vieux livres écrits dans une langue ancestrale, ou ayant fait l'apprentissage auprès d'un autre sorcier.<br /><br />" .
					 	 			" Portant en général une robe et une cape à capuche sombre, il maîtrise l'énergie des éléments et leur donne la forme qu'il souhaite gràce à des formules magiques ainsi qu'un baton qui leur permet de canaliser leur énergie. Intelligent, il possède un grand savoir du monde.";
			 	 	break;
			 	 	case 4 :
					 	 	echo '<div class="center"> Le Prètre </div><br />';
					 	 	echo "L'oeuvre des dieux est en tout choses, aussi bien dans les armées de croyants que dans les temples les plus majestueux. Comme dans le coeur du plus humbles des fidèles.<br /><br /> ".
								 "Les prètres partent à l'aventure pour soutenir la cause de leur dieu, du moins est ce la raison la plus souvent indiqués. Les bons prètres aiderons le commun des mortels dans leur vie en les soulageant, les plus maléfiques accro�trons leurs pouvoirs personnels afin d'être craint.<br /><br />".
								 "Les prètres sont les maitres de la magie divine particulièrement pour les soins ou pour leur pendant maléfiques détruire leur ennemis. Les prètres sont amener à manipuler un peu les armes mais jamais aussi bien qu'un guerrier.";
			 	 	break;
			 	 }  
                                 ?>
			</div>
			</div>
<!--// Bas du parchemin-->
			<div class="basparchemin"></div>
		</div>
 
 	 </div>
 	 
 	 <div class="left marginLeft5 marginTop80">
             <?php
			if($classe_desc > 0)
			{
                            ?>
				<img src="pictures/classe/'.$classe_desc.'/1.gif" /><br /><br /><br />
				<img src="pictures/classe/'.$classe_desc.'/2.gif" /><br />
                                <?php					
			}?>
		</div>
 </div>