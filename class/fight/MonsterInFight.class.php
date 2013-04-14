<?php

//Class Businnes pour gérer les combats ne possède rien par elle même.
class MonsterInFight {

    private $monster;

    function __construct() {
        $this->loadMonster(func_get_arg(0));
    }

    function loadMonster($monster) {
        $this->monster = $monster;
    }

    function getMonster() {
        return $this->monster;
    }

    function setMonster($monster) {
        $this->monster = $monster;
    }

    function getResistancePercentage($typeDamage) {
        switch ($typeDamage) {
            case 0:
                $resistance = $this->monster->getNeutral();
                break;

            case 1:
                $resistance = $this->monster->getFire();
                break;

            case 2:
                $resistance = $this->monster->getSnow();
                break;

            case 3:
                $resistance = $this->monster->getWind();
                break;

            case 4:
                $resistance = $this->monster->getEarth();
                break;

            case 5:
                $resistance = $this->monster->getHoly();
                break;

            case 6:
                $resistance = $this->monster->getPoison();
                break;
        }

        if ($resistance > 99)
            $resistance = 99;
        if ($resistance < -250)
            $resistance = -250;
        return $resistance;
    }

    function getMana() {
        return $this->monster->getMana();
    }

    function getCaract($caract) {
        return $this->monster->getCaract($caract);
    }

    function getLife() {
        return $this->monster->getLife();
    }

    function getName() {
        return $this->monster->getName();
    }

    function getLevel() {
        return $this->monster->getLevel();
    }

    public function getFighterPictureUrl() {
        return "pictures/monster/" . $this->monster->getIdMstr() . ".gif";
    }

    public function getSkillAvailableList() {
        return array();
    }

    function updateLife($damage) {
        $this->monster->updateLife($damage);
    }

    function addEffect($effect_id, $number, $attacker_id) {
        $effect = new effect($effect_id);

        $sql = "INSERT `effect_on_char` 
            (effect_id,effect_by,monster_id,duree_tour) VALUES(" . $effect_id . "," . $attacker_id . "," . $this->monsterS->getId() . "," . $effect->getDureeTour() . ")
                ON DUPLICATE KEY UPDATE number = number +" . $number;

        loadSqlExecute($sql);
    }

    function getExp() {
        return $this->monster->getExp();
    }

    function getGold() {
        return $this->monster->getGold();
    }

}

?>
