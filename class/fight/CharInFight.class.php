<?php

//Class business gérant tou ce qui a trait au combat.
class CharInFight {

    private $char;

    function __construct() {
        $this->loadChar(func_get_arg(0));
    }

    function loadChar($char) {
        $this->char = $char;
    }

    function getChar() {
        return $this->char;
    }

    function setChar() {
        $this->char = $char;
    }

    function getResistancePercentage($typeDamage) {
        switch ($typeDamage) {
            case 0:
                $resistance = $this->char->getNeutral();
                break;

            case 1:
                $resistance = $this->char->getFire();
                break;

            case 2:
                $resistance = $this->char->getSnow();
                break;

            case 3:
                $resistance = $this->char->getWind();
                break;

            case 4:
                $resistance = $this->char->getEarth();
                break;

            case 5:
                $resistance = $this->char->getHoly();
                break;

            case 6:
                $resistance = $this->char->getPoison();
                break;
        }

        if ($resistance > 75)
            $resistance = 75;
        if ($resistance < -250)
            $resistance = -250;

        return $resistance;
    }

    function getMana() {
        return $this->char->getMana();
    }

    function getCaract($caract) {
        return $this->char->getCaract($caract);
    }

    function getLife() {
        return $this->char->getLife();
    }

    function getName() {
        return $this->char->getName();
    }

    function getLevel() {
        return $this->char->getLevel();
    }

    public function getFighterPictureUrl($face) {
        return "pictures/classe/" . $this->char->getClasse() . "/ico/" . $this->char->getGender() . "-" . $face . ".gif";
    }

    public function getSkillAvailableList() {
        /* TODO */
        $skillList = array();
        $skillList[] = new Skill(1);
        $skillList[] = new Skill(2);

        return $skillList;
    }

    function updateLife($damage) {
        $this->char->updateLife($damage);
    }

    function addEffect($effect_id, $number, $attacker_id) {
        $effect = new effect($effect_id);

        $sql = "INSERT `effect_on_char` 
            (effect_id,effect_by,char_id,duree_tour) VALUES(" . $effect_id . "," . $attacker_id . "," . $this->char->getId() . "," . $effect->getDureeTour() . ")
                ON DUPLICATE KEY UPDATE number = number +" . $number;

        loadSqlExecute($sql);
    }

    function getId() {
        return $this->char->getId();
    }

    function updateMore($type, $more) {
        $this->char->updateMore($type, $more);
    }

    function updateExp($exp) {
        $this->char->updateExp($exp);
    }

}

?>
