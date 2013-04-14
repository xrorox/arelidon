
<?php

$chance = mt_rand(1, 2);

if ($chance == 1) {

    $selection = mt_rand(1, 7);

    if ($selection == 1) {
        $choix = mt_rand(1, 30);
        if ($choix <= 5)
            $url = "http://www.jeu-gratuit.net";
    }

    if ($selection == 2) {
        //$url = "http://www.lesroyaumes.com/?ref=2465?=2096" ;
        $choix = mt_rand(1, 3);
        switch ($choix) {
            case 1:
                $url = "http://www.clic4clic.com/ban.php?from=244&for=86&link=http://www.ngswing.com";
                break;
            case 2:
                $url = "http://www.clic4clic.com/ban.php?from=244&for=41&link=http://www.egyptis.com";
                break;
            case 3:
                $url = "http://www.clic4clic.com/ban.php?from=244&for=161&link=http://www.tingowar.com";
                break;
        }
    }

    if ($selection == 3) {
        $url = "http://www.jouez-gratis.com/index.php?id_site=174";
        //$url = "http://www.1-sponsor.com/redirection_v2.php?id_membre_editeur=8124&id_membre_annonceur=2217&id_site_annonceur=5019&id_site_editeur=6171" ;
    }

    if ($selection == 4) {
        $url = "http://www.jeux-en-ligne-gratuits.net";
        //$url = "http://www.surftraffic.net/service/out_ban.php?id_advert=MjAyNnw2OTU2fDF8aHR0cDovL2FqbW1vLmNvdXJzZXMuZnJlZS5mcg==" ;
    }


    if ($selection == 5) {
        $choix = mt_rand(1, 20);
        if ($choix == 6)
            $url = "http://www.jeu-gratuit.net/tracking/clic.php?idb=473&ide=197";
    }

    if ($selection == 6) {
        $choix = mt_rand(1, 4);
        switch ($choix) {
            case 1:
                $url = "http://www.clicjeux.net/clic.php?z=1&id_banniere=1195&emplacement=1197";
                break;

            case 2:
                $url = "http://www.clicjeux.net/clic.php?z=1&id_banniere=1066&emplacement=1197";
                break;

            case 3:
                $url = "http://www.clicjeux.net/clic.php?z=1&id_banniere=489&emplacement=1197";
                break;

            case 4:
                $url = "http://www.clicjeux.net/clic.php?z=1&id_banniere=489&emplacement=503";
                break;
        }
        //$url = "http://www.echange-de-banniere.net/click.php?hostid=967&targetid=1148" ;
    }
    if ($selection == 7) { // 1 page sur 7x150 = 1050 donne un clic
        //$url = "http://www.hebdotop.com";
        /*
          $rand = mt_rand(1,100) ;
          if ($rand <= 30) {

          $array = array(
          'http://exchange.pbem.fr/clic.php?id=53&b=92'=>10,
          'http://exchange.pbem.fr/clic.php?id=53&b=94'=>6,
          'http://exchange.pbem.fr/clic.php?id=53&b=67'=>4,
          'http://exchange.pbem.fr/clic.php?id=53&b=104'=>1,
          'http://exchange.pbem.fr/clic.php?id=53&b=10'=>1,
          'http://exchange.pbem.fr/clic.php?id=53&b=100'=>2,
          'http://exchange.pbem.fr/clic.php?id=53&b=30'=>6
          );

          $total = 30;

          $rand_choice = rand(1,30);
          $current = 0;

          foreach($array as $url_link=>$chance)
          {
          if($rand_choice <= $chance + $current)
          {
          $url = $url_link;
          break;
          }else{
          $current += $chance;
          }
          }
          }
         */
    }
} else {
    $url = "";
}



/*
  <!--
  <table width="5" border="0">
  <tr>
  <td>

  <iframe style="display:none" width="1" height="1" src="<?php echo $url ; ?>">
  </iframe>&nbsp;</td>
  </tr>
  </table>
  -->
 */
?>