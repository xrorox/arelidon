<?php

class char_inv {

    private $char_id;

    function char_inv($char_id) {
        $this->char_id = $char_id;
    }

    function getCharId() {
        return $this->char_id;
    }

    function getNumberItem($item) {
        $sql = "SELECT number FROM `char_inv` WHERE char_id=" . $this->getCharId() . " AND item_id=" . $item->getId();
        return loadSqlResult($sql);
    }

    function manageItem($item, $number) {
        if ($number > 0)
            $this->addItem($item, $number);
        elseif ($number < 0)
            $this->removeItem($item, $number);
    }

    function getAllItem($restrict = "tous") {
        if ($restrict == "tous")
            $sql = "SELECT item_id,number FROM `char_inv` WHERE char_id=" . $this->getCharId();
        else {
            $sql = "SELECT item_id,number FROM `char_inv` AS c, `objet` AS o
                WHERE c.item_id = o.id AND o.typeitem =" . $restrict;
        }

        return loadSqlResultArrayList($sql);
    }

    function useItem($item, $char) {
        if (($item->getLife() > 0 AND ($char->getLife() < $char->getLifeMax())) OR ($item->getMana() > 0 AND ($char->getMana() < $char->getManaMax()))) {

            if ($item->getLife() > 0)
                $char->updateMore('life', $item->getLife());

            if ($item->getMana() > 0)
                $char->updateMore('mana', $item->getMana());

            $_SESSION['char'] = serialize($char);
            $this->manageItem($item, -1);
        }
    }

    function drop($item, $char) {
        $this->manageItem($item, -1);
        $sql = "INSERT `objetonmap` (item_id,map,abs,ord,timestamp) VALUES (" . $item->getId() . "," . $char->getMap() . "," . $char->getAbs() . "," . $char->getOrd() . "," . time() . ")";
        loadSqlExecute($sql);
    }

    private function addItem($item, $number) {
        $sql = "INSERT `char_inv` (char_id,item_id,number) VALUES (" . $this->getCharId() . "," . $item->getId() . "," . $number . ") ON DUPLICATE KEY UPDATE number = number +" . $number;

        loadSqlExecute($sql);
        return true;
    }

    private function removeItem($item, $number) {

        $base = $this->getNumberItem($item);
        $total = $base + $number; //number est négatif

        if ($total >= 0) {
            if ($total == 0)
                $sql = "DELETE FROM `char_inv` WHERE char_id=" . $this->getCharId() . " AND item_id=" . $item->getId();
            else
                $sql = "UPDATE `char_inv` SET number = number + " . $number . " WHERE char_id=" . $this->getCharId() . " AND item_id=" . $item->getId();

            loadSqlExecute($sql);
            return true;
        }
        else
            return false;
    }

}

?>