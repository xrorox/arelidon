<?php

class atelier {

    private $id;
    private $metier_id;
    private $map;
    private $abs;
    private $ord;

    function atelier($atelier_id) {
        $this->loadAtelier($atelier_id);
    }

    function getId() {
        return $this->id;
    }

    function getMetierId() {
        return $this->metier_id;
    }

    function getMap() {
        return $this->map;
    }

    function getAbs() {
        return $this->abs;
    }

    function getOrd() {
        return $this->ord;
    }

    function loadAtelier($atelier_id) {
        $sql = "SELECT * FROM metier_atelier WHERE id = '$atelier_id'";
        $result = loadSqlResultArray($sql);

        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    function getToolEquiped($char) {
        $equipement = item::getEquipement($char->getId(), 'hand');
        $metier = new metier($this->getMetierId());

        if ($metier->isOutils($equipement))
            return true;
        else
            return false;
    }

}

?>