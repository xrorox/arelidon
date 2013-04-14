<?php
if(!empty($_GET['action'])){
	require_once('require.php');
	
}
 require_once($server.'class/shop.class.php');
 require_once($server.'class/pnj.class.php');
 require_once($server.'class/char_inv.class.php');
 $connexion = PDO2::connect();
 $pnj = new pnj($_GET['pnj']);


if(!isset($_GET['restrict']))
    $_GET['restrict'] = "tous";


$shop = new shop($pnj->getFonctionId(),$_GET['restrict']);

$sql = "SELECT id,name FROM `typeitem`";
$arrSelect = $connexion->loadSqlResultArrayList($sql);
$char = unserialize($_SESSION['char']);

$char_inv =new char_inv($char->getId());
$char_inventary = $char_inv->getAllItem($_GET['restrict']);
$item_collection = $shop->getItemIdCollection();

if(!empty($_GET['action_shop']))
{
    $item = new item($_GET['item_id']);
    switch($_GET['action_shop'])
    {
        case "buy":
            $status = $shop->managePurchase($item, $char, $_GET['qte']);
            
        break;
    
        case "sell":
            $status = $shop->manageSell($item, $char, $_GET['qte']);
        break;
    }
    $_SESSION['char'] = serialize($char);
}
else
{
    $status = "DEFAULT";
}

require_once($server.'pageig/shop/shop.php');
?>
