<?php

class char_equip {

    private $char_id;

    function char_equip($char_id) {
        $this->setCharId($char_id);
    }

    function getCharId() {
        return $this->char_id;
    }

    function setCharId($char_id) {
        $this->char_id = $char_id;
    }

    function getAllEquipement() {
        $sql = "SELECT item_id,place FROM `char_equip` WHERE char_id = " . $this->getCharId() . " ORDER BY place";
        return loadSqlResultArrayList($sql);
    }

    function equip($item) {
        $char_inv = new char_inv($this->getCharId());
        $char_inv->manageItem($item, -1);
        $this->unequip($item->getBodyPart());

        $this->equipItemOnChar($item);
    }

    function unequip($body_part) {
        $char_inv = new char_inv($this->getCharId());
        $items_id = $this->isSomethingToUnequip($body_part);

        if (count($items_id) > 0) {
            foreach ($items_id as $item_id) {
                $item = new item($item_id);
                $this->deleteItemOnChar($item);
                $char_inv->manageItem($item, 1);
            }
        }
    }

    function getToolEquiped() {
        $sql = "SELECT o.typeitem,item_id FROM `char_equip` AS c INNER JOIN
            `objet` AS o ON o.id = c.item_id 
            WHERE char_id =" . $this->getCharId() . " AND place = 1";
        $outil = loadSqlResultArray($sql);

        if ($outil['typeitem'] == 1)
            return $outil['item_id'];
        else
            return 0;
    }

    private function isSomethingToUnequip($body_part) {
        switch ($body_part) {
            case 1:
                $sql = "SELECT item_id FROM `char_equip` WHERE char_id=" . $this->getCharId() . " AND (place= 1 OR place = 3)";
                break;

            case 2:
                $sql = "SELECT item_id FROM `char_equip` WHERE char_id=" . $this->getCharId() . " AND (place= 2 OR place = 3)";
                break;

            case 3:
                $sql = "SELECT item_id FROM `char_equip` WHERE char_id=" . $this->getCharId() . " AND (place= 1 OR place = 2 OR place = 3)";
                break;
            default:
                $sql = "SELECT item_id FROM `char_equip` WHERE char_id=" . $this->getCharId() . " AND place=" . $body_part;
        }
        return loadSqlResultArray($sql);
    }

    private function equipItemOnChar($item) {
        $sql = "INSERT `char_equip` (char_id,place,item_id) VALUES (" . $this->getCharId() . "," . $item->getBodyPart() . "," . $item->getId() . ") ON DUPLICATE KEY UPDATE item_id=" . $item->getId();
        loadSqlExecute($sql);
    }

    private function deleteItemOnChar($item) {
        $sql = "DELETE FROM `char_equip` WHERE char_id =" . $this->getCharId() . " AND item_id=" . $item->getId();
        loadSqlExecute($sql);
    }

}

?>