<?php
if(empty($_GET['action_shop']))
    $_GET['action_shop'] = "default";

switch($status)
{
        case "NUMBER_NOT_VALID":
            $txt = "Il est impossible d'acheter ou de vendre un nombre d'objets égal à 0 ou négatif.";
        break;
    
        case "PRICE_NOT_VALID":
            $txt = "Une erreur a généré un prix nul ou négatif. Veuillez soummettre un rapport de bug indiquant l'objet et la quantité.";
        break;
    
        case "NOT_ENOUGH_GOLD":
            $txt = "Vous n'avez pas assez d'or pour acheter : ".$_GET['qte'] . "  " . $item->getPicture();
        break;
    
        case "PURCHASE_SUCCEED":
            $txt = "Achat réussi de : ".$_GET['qte'] . "  <img src='" . $item->getPicture()."'/>";
        break;
    
        case "SELL_SUCCEED":
            $txt = "Vente réussie de : ".$_GET['qte'] . "  <img src='" . $item->getPicture()."'/>";
        break;
       
        case "TRY_TO_SELL_TOO_MUCH":
            $txt = "Vous n'avez pas : ".$_GET['qte'] . "  <img src='" . $item->getPicture()."'/>";
        break;
    
        default:
                $txt = ' Bienvenue dans le magasin , pour acheter un objet , il vous suffit de cliquez dessus.';
        break;
}

$style_add = array('margin-top'=>'20px','height'=>'170px','align'=>'center','width'=>'85%','font-weight'=>'500');
$style_empty = array();
$texte = '<div id="shop_text">'.$txt.'</div>';
createTexte($texte,$style_empty,$style_add);
?>