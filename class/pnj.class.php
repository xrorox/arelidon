<?php

class pnj {

    private $id;
    private $name;
    private $taille;
    private $image;
    private $face;
    private $map;
    private $abs;
    private $ord;
    private $text;
    private $title;
// Fonction du PNJ 
    /**
      1 : magasinier
      2 : maitre de guilde
      3 : Magasin de sort
      4 : banquier
      5 : maitre d'ar�ne
      6 : garde du donjon
     */
    private $fonction;
    private $fonction_id;

    function __construct() {
        $num = func_num_args();
        switch ($num) {
            case 1 :
                $this->loadPnj(func_get_arg(0));
                break;
        }
    }

    function getId() {
        return $this->id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getName() {
        return $this->name;
    }

    function setTaille($taille) {
        $this->taille = $taille;
    }

    function getTaille() {
        return $this->taille;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function getImage() {
        return $this->image;
    }

    function setFace($face) {
        $this->face = $face;
    }

    function getFace() {
        return $this->face;
    }

    function setMap($map) {
        $this->map = $map;
    }

    function getMap() {
        return $this->map;
    }

    function setAbs($abs) {
        $this->abs = $abs;
    }

    function getAbs() {
        return $this->abs;
    }

    function setOrd($ord) {
        $this->ord = $ord;
    }

    function getOrd() {
        return $this->ord;
    }

    function setText($text) {
        $this->text = $text;
    }

    function getText() {
        return $this->text;
    }

    function getTextDecode() {
        $str = cleanAccent($this->text);
        $str = html_entity_decode($str, ENT_QUOTES);
        return $str;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function getTitle() {
        return $this->title;
    }

    function setFonction($fonction) {
        $this->fonction = $fonction;
    }

    function getFonction() {
        return $this->fonction;
    }

    function setFonctionId($fonction_id) {
        $this->fonction_id = $fonction_id;
    }

    function getFonctionId() {
        return $this->fonction_id;
    }

    function loadPnj($id) {
        $result = get_cache('pnj_id', 'pnj_' . $id);
        if (is_bool($result)) {
            $sql = "SELECT * FROM `pnj` WHERE `id` = '" . $id . "' ";
            $result = loadSqlResultArray($sql);
            create_cache('pnj_id', 'pnj_' . $id, $result);
        }

        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }

    function addPnj($name, $image, $face, $taille, $map, $abs, $ord, $textpnj, $title, $fonction = 0, $id_fonction = 0) {
        $name = htmlentities($name, ENT_QUOTES);
        $textpnj = htmlentities($textpnj, ENT_QUOTES);
        $title = htmlentities($title, ENT_QUOTES);
        $sql = "INSERT INTO pnj (name,image,face,taille,map,abs,ord,text,title,fonction,fonction_id) values ('$name','$image','$face','$taille','$map','$abs','$ord','$textpnj','$title','$fonction','$id_fonction')";
        loadSqlExecute($sql);
    }

    function update($type, $value) {
        $this->$type = $value;
        $sql = "UPDATE pnj SET " . $type . " = '" . $value . "' WHERE id = '" . $this->id . "'";
        loadSqlExecute($sql);
    }

    function duplic() {
        $new_name = $this->getName() . '2';

        $txt_pnj = html_entity_decode($this->getText(), ENT_QUOTES);
        $this->addPnj($new_name, $this->getImage(), $this->getFace(), $this->getTaille(), 0, $this->getAbs(), $this->getOrd(), $txt_pnj, $this->getTitle(), $this->getFonction(), $this->getFonctionId());
    }

    function getAllPnj($select = "*", $condition = "", $filter = array()) {
        $sql = "SELECT " . $select . " FROM pnj";

        if ($condition != "")
            $sql .= "WHERE " . $condition;

        if (count($filter) >= 1)
            $sql .= " AND id NOT IN (" . implode(',', $filter) . ")";

        $result = loadSqlResultArrayList($sql);
        return $result;
    }

    function hasAQuest($char, $return = false) {

        $sql = "SELECT e.id FROM `quetes_etapes` AS e
    LEFT JOIN `quetes_etapes_objectives` AS o 
    ON e.id = o.step_id
     WHERE e.pnj = '$this->id' or e.pnj_valid = '$this->id' or (o.type = 2 && o.id_need = '$this->id') ORDER BY etape ";
        $result = loadSqlResult($sql);

        if (count($result) > 0)
            return $result;
        else
            return false;
    }

    function getTeleporterInfos() {
        if ($this->fonction == 5) {
            $sql = "SELECT * FROM  `teleporter` WHERE id = '" . $this->fonction_id . "' ";
            return loadSqlResultArray($sql);
        } else {
            return array();
        }
    }

    function canTeleport($char, $array_teleport) {
        if ($array_teleport['id'] == 0)
            $array_teleport = $this->getTeleporterInfos();

        // Test si la faction du joueur peut utiliser ce t�l�porteur
        if ($array_teleport['faction_need'] == 0 or ($array_teleport['faction_need'] == $char->getFaction())) {
            if ($array_teleport['level_need'] == 0 or ($array_teleport['level_need'] <= $char->getLevel())) {
                if ($array_teleport['gold_need'] == 0 or ($array_teleport['gold_need'] <= $char->getGold())) {
                    $txt = "ok";
                } else {
                    $txt = "<br /> Tu n'as pas assez d'or.";
                }
            } else {
                $txt = "<br /> Tu n'as pas le niveau.";
            }
        } else {
            $txt = "<br /> Pas la bonne faction.";
        }

        return $txt;
    }

    public static function getAllPnjOnMap($idmap) {
        $sql = "SELECT * FROM pnj";
        $sql .= " WHERE map = '$idmap'";

        $result = loadSqlResultArrayList($sql);
        return $result;
    }

    public static function getPnjList($min, $max, $order, $asc) {
        $sql = "SELECT * FROM pnj ";

        if ($order != '')
            $sql .= " ORDER BY `" . $order . "` $asc ";

        $sql .= "LIMIT " . $min . "," . $max;
        $return = loadSqlResultArrayList($sql);

        return $return;
    }

    public static function getIdByName($name) {
        $name = htmlentities($name, ENT_QUOTES);
        $sql = "SELECT id FROM pnj WHERE name = '$name'";
        return loadSqlResult($sql);
    }

    public static function getNameById($id) {
        $sql = "SELECT name FROM pnj WHERE id = '$id'";
        return loadSqlResult($sql);
    }

    public static function getFonctionName($num, $count = 0) {
        $array = array('0' => 'pnj simple', '1' => 'magasinier', '2' => 'ma&icirc;tre de guilde', '3' => 'Instructeur', '4' => 'banquier', '5' => 't�l�porteur', '6' => 'garde donjon', '7' => 'hotel de vente');
        if ($count == 0)
            return $array[$num];
        else
            return count($array);
    }

    public static function getIndiceByFonction($fonction) {
        $fonction = htmlentities($fonction, ENT_QUOTES);
        switch ($fonction) {
            case 'pnj simple':
                return 0;
                break;
            case 'magasinier':
                return 1;
                break;
            case 'ma&icirc;tre de guilde':
                return 2;
                break;
            case 'instructeur':
                return 3;
                break;
            case 'banquier':
                return 4;
                break;
            case 'teleporter':
                return 5;
                break;
            case 'garde donjon':
                return 6;
                break;
        }
    }

    public static function getSelectFonction($default = 0) {
        $count = pnj::getFonctionName('0', '1');

        echo '<select name="fonction">';
        for ($i = 0; $i <= $count - 1; $i++) {
            echo '<option value="' . $i . '" ';
            if ($i == $default)
                echo 'SELECTED=SELECTED';
            echo '>' . pnj::getFonctionName($i) . '</option>';
        }
        echo '</select>';
    }

}

?>