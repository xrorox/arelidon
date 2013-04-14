<?php

class shop {

    /**
     * Documentation :
     * 
     *  Un shop est une collection d'objet : 
     * 
     *  la collection : objet / prix d'achat (prix de vente = prix d'achat / 4)
     * 
     * 
     */
    private $id;
    private $itemIdCollection;

    function __construct() {
        $num = func_num_args();

        switch ($num) {
            case 2:
                $this->loadShop(func_get_arg(0), func_get_arg(1));
                break;
        }
    }

    function loadShop($id, $restrict) {
        $this->id = $id;

        if ($restrict == "tous")
            $sql = "SELECT item_id FROM `shop_items` WHERE shop_id=" . $id;
        else {
            $sql = "SELECT item_id FROM `shop_items` AS s, `objet` AS o
                WHERE s.item_id = o.id AND
                s.shop_id=" . $id . " AND o.typeitem =" . $restrict;
        }

        $this->itemIdCollection = loadSqlResultArrayList($sql);
    }

    function getItemIdCollection() {
        return $this->itemIdCollection;
    }

    public function managePurchase($item, $char, $number = 1) {
        $price = $item->getPrice() * $number;
        $status = 0;

        if ($number <= 0)
            $status = "NUMBER_NOT_VALID";

        if ($price <= 0)
            $status = "PRICE_NOT_VALID";

        if ($price > $char->getGold())
            $status = "NOT_ENOUGH_GOLD";

        if (empty($status)) {
            $this->buy($item, $char, $number);
            $status = "PURCHASE_SUCCEED";
        }

        return $status;
    }

    public function manageSell($item, $char, $number = -1) {
        $price = $item->getPrice() * $number;
        $status = 0;



        if ($price >= 0)
            $status = "PRICE_NOT_VALID";

        if ($number <= 0)
            $status = "NUMBER_NOT_VALID";

        $char_inv = new char_inv($char->getId());
        $qte = $char_inv->getNumberItem($item);

        if ($qte < $number)
            $status = "TRY_TO_SELL_TOO_MUCH";

        if (empty($status)) {
            $this->sell($item, $char, $number);
            $status = "SELL_SUCCEED";
        }

        return $status;
    }

    private function buy($item, $char, $number = 1) {
        $char->updateMore('gold', $item->getPrice("achat") * -1 * $number);
        $char_inv = new char_inv($char->getId());


        $char_inv->manageItem($item, $number);
    }

    private function sell($item, $char, $number = -1) {
        $char->updateMore('gold', $item->getPrice() * $number);
        $char_inv = new char_inv($char->getId());

        $char_inv->manageItem($item, $number);
    }

}

?>