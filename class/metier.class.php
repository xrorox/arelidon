<?php

class metier {

    private $id;
    private $name;
    private $type;
    private $need_atelier;
    private $has_recolte;
    private $has_recette;
    private $recette_collection = array();
    private $outil_for_level = array();
    private $outil;
    // Association � un joueur
    // possibilit� de charger une instance de char sur un m�tier
    private $char_id;
    private $level;
    private $exp;
    private $aexp;

    function metier($id = 0) {
        if ($id != 0)
            $this->loadMetier($id);
    }

    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getType() {
        return $this->type;
    }

    function setCharId($char_id) {
        $this->char_id = $char_id;
    }

    function getCharId() {
        return $this->char_id;
    }

    function setLevel($level) {
        if ($level <= 0)
            $this->level = 1;
        else
            $this->level = $level;
    }

    function getLevel() {
        return $this->level;
    }

    function setExp($exp) {
        $this->exp = $exp;
    }

    function getExp() {
        return $this->exp;
    }

    function setAexp($aexp) {
        if ($aexp <= 0)
            $this->axep = 300;
        else
            $this->aexp = $aexp;
    }

    function getAexp() {
        if ($this->aexp == 0)
            $this->aexp = 300;
        return $this->aexp;
    }

    function hasRecolte() {
        if ($this->has_recolte == 1)
            return true;
        else
            return false;
    }

    function hasRecette() {
        if ($this->has_recette == 1)
            return true;
        else
            return false;
    }

    function loadMetier($id) {
        $sql = "SELECT * FROM `metier` WHERE id = $id";
        $result = loadSqlResultArray($sql);

        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    function loadMetierByOutil($outil_id) {
        if ($outil_id > 0) {
            $sql = "SELECT metier_id FROM `metier_outil` WHERE outil_id = $outil_id ";
            $metier_id = loadSqlResult($sql);

            $this->loadMetier($metier_id);
        }
    }

    function update($row, $value) {
        $sql = "UPDATE metier SET $row = '$value' WHERE metier_id = " . $this->getId();
        loadSqlExecute($sql);
    }

    function updateMetierOnChar($row, $value) {
        $sql = "UPDATE `metier_char` SET $row = '$value' WHERE metier_id = '" . $this->getId() . "' && char_id = '" . $this->getCharId() . "' ";
        loadSqlExecute($sql);
    }

    function updateExpMetier($char_id, $number = 10) {
        $this->loadMetierJoinChar($this->getId(), $char_id);
        $this->getLevelMetierOfChar($char_id);

        $new_exp = $this->getExp() + $number;
        if ($new_exp >= $this->getAExp()) {
            $this->levelUpMetier();
        }

        $this->updateMetierOnChar('exp', $new_exp);
    }

    function levelUpMetier() {
        $nextLvl = $this->getLevel() + 1;
        $sql = "SELECT *FROM `level`WHERE `level` = '" . $nextLvl . "' ";
        $result = loadSqlResultArray($sql);

        $new_aexp = $result['nextlevel'];
        $this->updateMetierOnChar('aexp', $new_aexp);
        $this->updateMetierOnChar('level', $nextLvl);
    }

    function loadMetierJoinChar($id, $char_id) {
        $this->loadMetier($id);

        $sql = "SELECT * FROM `metier_char` WHERE char_id = " . $char_id . " && metier_id = " . $this->id;
        $result = loadSqlResultArray($sql);

        $this->setCharId($char_id);

        $this->setLevel($result['level']);
        $this->setExp($result['exp']);
        $this->setAexp($result['aexp']);
    }

    function getOutilNeed($char) {
        // Pour l'instant 1 outil / m�tier
        $sql = "SELECT ob.id " .
                "FROM metier_outil mo " .
                "JOIN objet ob ON mo.outil_id = ob.id " .
                "WHERE mo.metier_id = " . $this->getId();
        return loadSqlResult($sql);
    }

    public function isOutils($equipement) {
        $sql = "SELECT metier_id FROM `metier_outil` WHERE outil_id=" . $equipement;
        $result = loadSqlResult($sql);

        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getOutils() {
        $level = $this->getLevel();
        $sql = "SELECT ob.id,ob.name " .
                "FROM metier_outil mo " .
                "JOIN objet ob ON mo.outil_id = ob.id " .
                "WHERE mo.metier_id = " . $this->getId() . " AND mo.level <= " . $level;

        return loadSqlResultArrayList($sql);
    }

    function getRessourcesRecotable() {
        $level = $this->getLevel();
        $sql = "SELECT ob.id,ob.name " .
                "FROM metier_action ma " .
                "JOIN objet ob ON ma.objet_id = ob.id " .
                "WHERE ma.metier_id = " . $this->getId() . " AND ma.level <= " . $level;

        return loadSqlResultArrayList($sql);
    }

    function getRecettes() {
        $level = $this->getLevel();
    }

    function getLevelMetierOfChar($char_id) {
        $sql = "SELECT COUNT(*) FROM `metier_char` WHERE char_id = $char_id && metier_id = " . $this->getId();
        $count = loadSqlResult($sql);

        if ($count == 1) {
            $sql = "SELECT level FROM `metier_char` WHERE char_id = $char_id && metier_id = " . $this->getId();
            return loadSqlResult($sql);
        } else {
            $this->initMetier($char_id);
            return 1;
        }
    }

    function initMetier($char_id) {
        $sql = "INSERT INTO `metier_char` (`metier_id` ,`char_id` ,`level` ,`exp` ,`aexp`)VALUES ('" . $this->getId() . "', '" . $char_id . "', '1', '0', '300');";
        loadSqlExecute($sql);
    }

    public static function getMetierList($select = 'id,name,type') {
        $sql = "SELECT $select FROM `metier`";
        $result_array = loadSqlResultArrayList($sql);

        return $result_array;
    }

    public static function getInfoMetierForChar($char_id) {
        $return_array = array();

        $arrays = metier::getMetierList();
        foreach ($arrays as $array) {
            $sql = "SELECT * FROM `metier_char` WHERE metier_id = " . $array['id'] . " && char_id = $char_id";
            $result = loadSqlResultArray($sql);

            if (!$result) {
                $level = 1;
                $exp = 0;
                $aexp = 300;
            } else {
                $level = $result['level'];
                $exp = $result['exp'];
                $aexp = $result['aexp'];
            }

            $go_array = array('id' => $array['id'],
                'name' => $array['name'],
                'type' => $array['type'],
                'level' => $level,
                'exp' => $exp,
                'aexp' => $aexp
            );
            $return_array[] = $go_array;
        }

        return $return_array;
    }

    public static function getAtelierOnMap($map_id) {
        $sql = "SELECT * FROM metier_atelier WHERE map = $map_id";
        return loadSqlResultArrayList($sql);
    }

    public static function getNameById($id) {

        $sql = "SELECT name FROM `metier` WHERE id=" . $id;
        return loadSqlResult($sql);
    }

    public static function selectMetierName($name = 0) {
        $sql = "SELECT id,name FROM `metier` ;";
        $arrayofarray = loadSqlResultArrayList($sql);

        $echo = "<select id='metier_id' name='metier_id'> ";

        foreach ($arrayofarray as $array) {
            if ($name == $array['id']) {
                $echo .= "<option selected='selected' value='" . $array['id'] . "'> " . $array['name'] . " </option>";
            } else {
                $echo .= "<option value='" . $array['id'] . "'> " . $array['name'] . " </option>";
            }
        }
        $echo .= " </select>";
        return $echo;
    }

    public static function getMetierIdByOutil($outil_id) {
        if ($outil_id > 0) {
            $sql = "SELECT metier_id FROM `metier_outil` WHERE outil_id = $outil_id ";
            return loadSqlResult($sql);
        }
    }

}

?>