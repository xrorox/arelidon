<?php

define("MYSELF", 0);

class banque {

    function banque() {
        
    }

    function getGold($char, $type) {
        if ($type == 0)
            $sql = "SELECT gold FROM `bank_gold` WHERE char_id=" . $char->getId() . " AND guild=" . MYSELF;
        else {
            $sql = "SELECT gold FROM `bank_gold` WHERE char_id=" . $char->getId() . " AND guild=" . $char->getGuildId();
        }
        $result = loadSqlResult($sql);
        if ($result == '')
            $result = 0;

        return $result;
    }

    function getWeight($char, $type) {
        if ($type == 0)
            return $this->getWeightChar($char);
        elseif ($type == 1)
            return $this->getWeightGuild($char);
    }

    function manageGold($char, $type, $number) {
        if ($number > 0 and $char->getGold() >= $number)
            $this->addGoldToBank($char, $type, $number);
        elseif ($number < 0 and $char->getGold() >= $number)
            return $this->takeGoldFromBank($char, $type, $number);
        else
            return false;

        return true;
    }

    function manageItem($char, $type, $item, $number) {
        if ($number > 0)
            return $this->addItemToBank($char, $type, $item, $number);
        elseif ($number < 0)
            return $this->removeItemFromBank($char, $type, $item, $number);
        else
            return false;
    }

    function getAllItems($char, $type) {
        if ($type == 0)
            return $this->getAllItemsChar($char);
        elseif ($type == 1)
            return $this->getAllItemsGuild($char);
    }

    private function addGoldToBank($char, $type, $number) {
        if ($type == 0)
            $this->addGoldToCharBank($char, $number);
        elseif ($type == 1)
            $this->addGoldToGuildBank($char, $number);
    }

    private function addGoldToCharBank($char, $number) {
        $char->updateMore("gold", $number * -1);
        $this->addGoldToCharBankSQL($char, $number);
    }

    private function addGoldToCharBankSQL($char, $number) {
        $sql = "INSERT `bank_gold` (char_id,gold,guild) VALUES (" . $char->getId() . "," . $number . "," . MYSELF . ") ON DUPLICATE KEY UPDATE gold= gold + " . $number;
        loadSqlExecute($sql);
    }

    private function addGoldToGuildBank($char, $number) {
        $guild = new guild($char->getGuildId());
        $guild->donation($char, $number);

        $this->addGoldToGuildBankSQL($char, $number);
    }

    private function addGoldToGuildBankSQL($char, $number) {
        $sql = "INSERT `bank_gold` (char_id,gold,guild) VALUES (" . $char->getId() . "," . $number . "," . $char->getGuildId() . ") ON DUPLICATE KEY UPDATE gold= gold + " . $number;
        loadSqlExecute($sql);
    }

    private function takeGoldFromBank($char, $type, $number) {

        if ($type == 0)
            return $this->takeGoldFromBankChar($char, $number);
        else
            return false;
    }

    private function takeGoldFromBankChar($char, $number) {
        if ($this->haveEnoughMoney($char, $number))
            $this->takeGoldFromBankCharSQL($char, $number);
        else
            return false;

        return true;
    }

    private function haveEnoughMoney($char, $number) {
        pre_dump('toto');
        $sql = "SELECT gold FROM `bank_gold` WHERE char_id=" . $char->getId() . " AND guild=" . MYSELF . "  ";
        $gold = loadSqlResult($sql);

        if ($gold >= $number * -1)
            return true;
        else
            return false;
    }

    private function takeGoldFromBankCharSQL($char, $number) {
        pre_dump('toto');
        $char->updateMore("gold", $number * -1);
        $sql = "UPDATE `bank_gold` SET gold= gold +  " . $number . " WHERE char_id=" . $char->getId() . " AND guild=" . MYSELF;
        loadSqlExecute($sql);
    }

    private function addItemToBank($char, $type, $item, $number) {
        $char_inv = new char_inv($char->getId());
        $inv_number = $char_inv->getNumberItem($item);

        $char_inv->manageItem($item, -1);
        if ($inv_number >= $number) {
            if ($type == 0)
                $this->addItemToCharBankSQL($char, $item, $number);
            elseif ($type == 1)
                $this->addItemToGuildBankSQL($char, $item, $number);

            return true;
        }
        else
            return false;
    }

    private function addItemToCharBankSql($char, $item, $number) {
        $sql = "INSERT `bank_item` (char_id,item_id,number,guild) VALUES (" . $char->getId() . "," . $item->getId() . "," . $number . "," . MYSELF . ") ON DUPLICATE KEY UPDATE number= number + " . $number;
        loadSqlExecute($sql);
    }

    private function addItemToGuildBankSql($char, $item, $number) {
        $sql = "INSERT `bank_item` (char_id,item_id,number,guild) VALUES (" . $char->getId() . "," . $item->getId() . "," . $number . "," . $char->getGuildId() . ") ON DUPLICATE KEY UPDATE number= number + " . $number;
        loadSqlExecute($sql);
    }

    private function removeItemFromBank($char, $type, $item, $number) {
        if ($type == 0)
            return $this->removeItemFromBankChar($char, $item, $number);
        elseif ($type == 1)
            return $this->removeItemFromBankGuild($char, $item, $number);
        else
            return false;
    }

    private function removeItemFromBankChar($char, $item, $number) {
        $sql = "SELECT number FROM `bank_item` WHERE char_id=" . $char->getId() . " AND item_id=" . $item->getId() . " AND guild=" . MYSELF;
        $bank_number = loadSqlResult($sql);

        if ($bank_number >= $number) {
            $this->removeItemFromBankCharSql($char, $item, $number);
        }
        else
            return false;
    }

    private function removeItemFromBankCharSql($char, $item, $number) {
        $sql = "UPDATE `bank_item` SET number= number +  " . $number . " WHERE char_id=" . $char->getId() . " AND item_id=" . $item->getId() . " AND guild=" . MYSELF;
        loadSqlExecute($sql);

        $char_inv = new char_inv($char->getId());
        $char_inv->manageItem($item, $number * -1);
    }

    private function removeItemFromBankGuild($char, $item, $number) {
        $sql = "SELECT number FROM `bank_item` WHERE char_id=" . $char->getId() . " AND item_id=" . $item->getId() . " AND guild=" . $char->getGuildId();
        $bank_number = loadSqlResult($sql);

        if ($bank_number >= $number) {
            $this->removeItemFromBankGuildSql($char, $item, $number);
        }
        else
            return false;
    }

    private function removeItemFromBankGuildSql($char, $item, $number) {
        $sql = "UPDATE `bank_item` SET number= number +  " . $number . " WHERE char_id=" . $char->getId() . " AND item_id=" . $item->getId() . " AND guild=" . $char->getGuildId();
        loadSqlExecute($sql);

        $char_inv = new char_inv($char->getId());
        $char_inv->manageItem($item, $number * -1);
    }

    private function getAllItemsChar($char) {
        $sql = "SELECT item_id,number FROM `bank_item` WHERE char_id=" . $char->getId() . " AND guild=" . MYSELF;
        return loadSqlResultArrayList($sql);
    }

    private function getAllItemsGuild($char) {
        $sql = "SELECT item_id,number FROM `bank_item` WHERE guild=" . $char->getGuildId();
        return loadSqlResultArrayList($sql);
    }

    private function getWeightChar($char) {
        $sql = "SELECT SUM(o.poid*b.number) FROM `bank_item` AS b LEFT JOIN `objet` AS o ON b.item_id = o.id WHERE guild=" . MYSELF . ' AND char_id=' . $char->getId();
        return loadSqlResult($sql);
    }

    private function getWeightGuild($char) {
        $sql = "SELECT SUM(o.poid*b.number) FROM `bank_item` AS b LEFT JOIN `objet` AS o ON b.item_id = o.id WHERE guild=" . $char->getGuildId() . ' AND char_id=' . $char->getId();
        return loadSqlResult($sql);
    }

}

?>