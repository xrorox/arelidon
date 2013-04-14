<?php

class skin {

    private $id;
    private $name;
    private $num;
    private $classe;
    private $gender;
    private $price;
    private $event_id;

    function skin($skin_id) {
        $sql = "SELECT * FROM `skin` WHERE id = $skin_id";
        $result = loadSqlResultArray($sql);

        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getNum() {
        return $this->num;
    }

    function getClasse() {
        return $this->classe;
    }

    function getGender() {
        return $this->gender;
    }

    function getPrice() {
        return $this->price;
    }

    function getEventId() {
        return $this->event_id;
    }

    function addToUser($user_id) {
        $sql = "SELECT id FROM `char` WHERE idaccount=$user_id AND gender=" . $this->getGender() . " AND classe=" . $this->getClasse();
        $ids = loadSqlResultArrayList($sql);

        if (count($ids) >= 1) {
            foreach ($ids as $key => $arr) {
                $sql = "UPDATE `char` SET skin = " . $this->num . " WHERE id=" . $arr['id'];
                loadSqlExecute($sql);
            }
        }

        $sql = "INSERT INTO `skin_on_user` (skin_id,user_id) VALUES (" . $this->id . ",$user_id)";
        loadSqlExecute($sql);
    }

}