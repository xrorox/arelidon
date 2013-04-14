<?php

class trade_letter {

    private $id;
    private $buyer;
    private $seller;
    private $nb_item;
    private $item;
    private $price;

    function __construct() {
        $num = func_num_args();
        switch ($num) {
            case 1 :
                $this->load(func_get_arg(0));
                break;
        }
    }

    function getId() {
        return $this->id;
    }

    function getBuyer() {
        return $this->buyer;
    }

    function getSeller() {
        return $this->seller;
    }

    function getNbItem() {
        return $this->nb_item;
    }

    function getItem() {
        return $this->item;
    }

    function getPrice() {
        return $this->price;
    }

    function load($id) {
        $this->id = $id;

        $sql = "SELECT * FROM `trade_letter` WHERE id = $id";
        $result = loadSqlResultArray($sql);

        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }

    function add($buyer, $seller, $nb_item, $item, $price) {
        if ($price < 0)
            $price = 0;

        $sql = "INSERT INTO `trade_letter` (buyer,seller,nb_item,item,price)" .
                " VALUES ($buyer,$seller,$nb_item,$item,$price)";
        loadSqlExecute($sql);
    }

    function udapte($row, $value) {
        $sql = "UPDATE `trade_letter` SET $row = '$value' WHERE id = " . $this->id;
        loadSqlExecute($sql);
    }

    function accepte() {
        $buyer = new char($this->buyer);
        $seller = new char($this->seller);
        $item = new item($this->item);

        // Transfert de fond
        $price_neg = $this->price * -1;

        if ($buyer->getId() != $seller->getId()) {
            $buyer->updateMore('gold', $price_neg);
            $seller->updateMore('gold', $this->price);
        }


        $item->addItemToChar($buyer->getId(), $this->nb_item);

        // Suppression du colis
        $this->delete();
    }

    function refuse() {
        if ($this->buyer != $this->seller) {
            $buyer = new char($this->buyer);
            $seller = new char($this->seller);
            $item = new item($this->item);

            // On renvoi les objets � l'acheteur
            $this->udapte('buyer', $seller->getId());


            // Envoyer un message au destinataire pour lui pr�venir qu'un colis est arriv�
            message::addNewMessage(0, $seller->getId(), "[Alerte] votre colis a �t� refus�", "Vous pouvez d�s maintenant retirer votre colis � un bureau de la Pigeon Post");
        } else {
            $this->delete();
        }
    }

    function delete() {
        $sql = "DELETE FROM trade_letter WHERE id = " . $this->id;
        loadSqlExecute($sql);
    }

    public static function getAllColis($char_id) {
        $sql = "SELECT * FROM trade_letter WHERE buyer = $char_id";
        return loadSqlResultArrayList($sql);
    }

    public static function getTarification($weight) {
        $weight2 = round($weight * 15);
        return $weight2;
    }

}

?>