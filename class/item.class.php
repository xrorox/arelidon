<?php

class item {

    private $id;
    private $name;
    private $rarity;
    private $level;
    private $poid;
    private $typeitem;
    private $str;
    private $con;
    private $dex;
    private $int;
    private $sag;
    private $res;
    private $cha;
    private $life;
    private $mana;
    private $price;
    private $special_action;

    /*
     * Special action va d�finir des actions sp�cifiques � effectu� par l'objet
     * 
     *  1 : t�l�porte au foyer de guilde
     */

    function __construct() {
        $num = func_num_args();

        if (intval($num) > 0)
            $number = true;
        else
            $number = false;

        if (is_array($num))
            $array = true;
        else
            $array = false;

        if ($number)
            $this->loadItem(func_get_arg(0));
        elseif ($array)
            $this->loadItemByArray(func_get_arg(0));
        else
            $this->loadItemByName(func_get_arg(0));
    }

    function getId() {
        return $this->id;
    }

    function getStr() {
        return $this->str;
    }

    function getCon() {
        return $this->con;
    }

    function getDex() {
        return $this->dex;
    }

    function getInt() {
        return $this->int;
    }

    public function getTypeItem() {
        return $this->typeitem;
    }

    function getSag() {
        return $this->sag;
    }

    function getRes() {
        return $this->res;
    }

    function getCha() {
        return $this->cha;
    }

    function getLife() {
        return $this->life;
    }

    function getMana() {
        return $this->mana;
    }

    function getName() {
        return $this->name;
    }

    function getNameWithColor() {
        switch ($this->rarity) {
            // rare
            case 1 :
                $name = '<font color="#000066">' . $this->name . '</font>';
                break;

            case 2 :
                $name = '<font color="##FFCC33">' . $this->name . '</font>';
                break;

            default :
                $name = $this->name;
                break;
        }

        return $name;
    }

    function getLevel() {
        return $this->level;
    }

    function getPoid() {
        return $this->poid;
    }

    function getPrice($action = "vente") {
        if ($action == "achat")
            return $this->price;
        else
            return round($this->price / 4);
    }

    function getSpecialAction() {
        return $this->special_action;
    }

    function loadItem($item) {
        $sql = "SELECT * FROM objet WHERE id = '" . $item . "'";
        $result = loadSqlResultArray($sql);

        $this->loadItemByArray($result);
    }

    function loadItemByArray($array) {
        if ($array != '') {
            foreach ($array as $key => $value)
                $this->$key = $value;
        }
    }

    function loadItemByName($item_name) {
        $sql = "SELECT * FROM objet WHERE name = '" . $item_name . "'";
        $result = loadSqlResultArray($sql);

        if ($result != '') {
            foreach ($result as $key => $value)
                $this->$key = $value;
        }
    }

    function getBodyPart() {
        $sql = "SELECT typeitem.body_part_id FROM objet INNER JOIN typeitem 
        ON objet.typeitem = typeitem.id 
        WHERE objet.id = " . $this->getId();

        return loadSqlResult($sql);
    }

    function getBonus() {
        $arrCarac = getCaractList(0, 1);
        $text = '';

        foreach ($arrCarac as $carac) {
            $function = "get" . ucfirst($carac);
            $text .= getCaract($carac) . " : " . $this->$function() . "<br/>";
        }

        return $text;
    }

    function getPictureWithToolTip($onclick = '', $style_img = '', $style_tooltip = '', $spanstyle = 'width:150px;', $return = false, $class = '', $id = 0) {
        $text = $this->getName() . '  ' . $this->getBonus();
        return imgWithTooltip($this->getPicture(), $text, $onclick, $style_img, $style_tooltip, $spanstyle, $return, $class, $this->getId());
    }

    public function getPicture() {
        return "pictures/item/" . $this->getId() . ".gif";
    }

    public static function getPictureById($item_id) {
        return "pictures/item/" . $item_id . ".gif";
    }

    public static function showPicture() {
        return "";
    }

    public static function getAllItemsName() {
        $sql = "SELECT name from `objet`";
        return loadSqlResultArray($sql);
    }

}

?>