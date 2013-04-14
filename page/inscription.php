<?php
 if(isset($_GET['mode']))
    $mode = $_GET['mode'];
 else
     $mode='';
 
 if(isset($_GET['sponsor']))
    $sponsor = $_GET['sponsor'];
 else
     $sponsor='';
?>

<div class="left">
    <div class="fontElfique grey font32">
        <div class="font18 center marginTop40"> Inscription </div>
	 
	 <?php  if($mode != 'confirm'):  // Formulaire ?>
  
            <div class="font18 marginTop20">
	 	<form method="post" action="index.php?page=inscription&amp;mode=confirm">
                    <p>
	 		<label class="subscribe">
                            Pseudo
                            <?php
                                $txt = "Votre pseudo doit être compris entre 5 et 16 caractères.";
                                $url = "pictures/utils/help12x12.gif";
                                imgWithTooltip($url,$txt,'','','font-size:14px;','width:160px;');	
                                echo ' : ';
                            ?>
	 		</label>
	 		
                        <input type="text" name="login" size="24" maxlength="16" onchange="check_login(this.value);" /> 
	 		<span id="check-login" class="spancheck"> &nbsp; </span>
	 	     </p>

                      <p>
                        <label class="subscribe">
                            Email 
                            <?php
	 			$txt = "Votre email doit être valide sinon votre compte ne pourra pas être validé.";
	 			$url = "pictures/utils/help12x12.gif";
				imgWithTooltip($url,$txt,'','','font-size:14px;','width:160px;');	
	 	             	echo ' : ';
                            ?>
	 		</label>
                        <input type="text" name="email" size="24" maxlength="55" onchange="check_email(this.value);" />
	 		<span id="check-email" class="spancheck">
	 			&nbsp;
	 		</span>
                    </p>
	 		
                    <p>
	 		<label class="subscribe">
                            Mot de passe 
                            <?php
	 			$txt = "Votre mot de passe doit contenir au minimum 5 caractères.";
	 			$url = "pictures/utils/help12x12.gif";
				imgWithTooltip($url,$txt,'','','font-size:14px;','width:160px;');	
	 			echo ' : ';
                            ?>
                        </label>
                        <input type="text" name="password" size="24" maxlength="16" onchange="check_password(this.value);" />
	 		<span id="check-password" class="spancheck">&nbsp</span>
                    </p>

	 	    <p>
                        <label class="subscribe">
	 			Parrain 
                           <?php
	 			$txt = "Inscrivez ici le pseudo du compte de votre parrain. (facultatif)";
	 			$url = "pictures/utils/help12x12.gif";
				imgWithTooltip($url,$txt,'','','font-size:14px;','width:160px;');	
	 			echo ' : ';
                           ?>
                        </label>
                      <?php  echo '<input type="text" value="'.$sponsor.'" name="sponsor" size="24" maxlength="16" onchange="check_sponsor(this.value);" onblur="check_sponsor(this.value);" />'; ?>
	 			
	 		<span id="check-sponsor" class="spancheck">
	 			
	 				<span id="form_valid_4" style="display:none;">1</span>
	 				
	 			</span>

                    </p>
	 		
                    <p class="paddingTop10 paddingLeft20 paddingRight20">
                        <input type="checkbox" name="condition" /> 
                        En m'inscrivant, je m'engage à m'amuser sur le jeu, à ne pas gâcher la vie des autres joueurs. Je m'engage aussi à être motivé à tuer des dragons, sauver des princesses ou encore cirer les bottes du roi.
                    </p>
	 		
                    <div class="center">
	 		<input class="button" onclick="if(check_form()){submit();}" class="font18" type="button" value="Confirmer" />
                    </div>
	 		
	 	</form>
	 </div>
	
<?php	else:
		// Page de confirmation

		?><div class="font18 marginTop20"> <?php

			$login = $_POST['login'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			$sponsor = $_POST['sponsor'];
	
			
			 $headers ='From: "Royaume_Arelidon"<phenixu@90plan.ovh.net>'."\n";
		     $headers .='Reply-To: noreply@royaume-arelidon.fr'."\n";
		     $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
		     $headers .='Content-Transfer-Encoding: 8bit';
			 $headers .='X-Priority: 1';
			 $chaine = md5($login);
		
		     $message = 'Pour valider votre email il suffit de cliquer sur le lien suivant : ';
		     $message.= '' .
		     			'' ;
			 $message.= 'http://www.royaume-arelidon.fr/index.php?page=confirminscription&validmail=1&login='.$login.'&code='.$chaine ;
			 $title = 'Le Royaume d\'Arélidon : confirmation de votre addresse mail';

		     if(mail($email, $title, $message) or $_GET['localhost'] == 1)
		     {
		         echo 'Vous allez maintenant recevoir un mail contenant un lien permettant de valider votre inscription.';
		    	 // ON ajoute l'inscription dans la base
		    	user::addUser($login,$password,$email,$sponsor);
		    
		     } else {
		     	 echo 'Attention le mail n\'a pas pu être envoyé l\'inscription a donc échouée.';
		     }	
		echo '</div>';
	endif
?>	
	</div>
</div>
