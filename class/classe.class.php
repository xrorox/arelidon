<?php

class classe {

    private $id;
    private $name;
    private $description;

    function __construct() {
        $num = func_num_args();

        switch ($num) {
            case 0 :
                $this->id = -1;
                break;
            case 1 :
                $this->id = func_get_arg(0);
                $this->loadClasse($this->id);
                break;
        }
    }

    function getName() {
        return $this->name;
    }

    function loadClasse($id) {
        $sql = "SELECT * FROM classe WHERE `id` = '" . $id . "'";
        $result = loadSqlResultArray($sql);

        $this->name = $result['name'];
        $this->description = $result['description'];
    }

    public static function getArrayClasseName() {
        return array(
            1 => "guerrier",
            2 => "archer",
            3 => "mage",
            4 => "pr&ecirc;tre",
            5 => "paladin",
            6 => "chaman",
            7 => "&eacute;l&eacute;mentariste",
            8 => "n&eacute;cromancien"
        );
    }

    public function getDescription() {
        
        $desc = $this->description;

        return htmlentities($desc);
    }

    public static function GetClasseNameById($id) {
        if ($id == 0) {
            $echo = " Toutes";
        } else {
            $array = Classe::getArrayClasseName();
            return $array[$id];
        }

        return $echo;
    }

    public static function selectClasse($id_classe = 0) {

        $sql = "SELECT id,name FROM `classe`";
        $arrayofarray = loadSqlResultArrayList($sql);
        if ($id_classe == 0) {
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        $echo = '<option value="0"' . $selected . '> Toutes </option>';

        foreach ($arrayofarray as $array) {

            if ($id_classe == $array['id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }

            $echo.= '<option value="' . $array['id'] . '" ' . $selected . '> ' . $array['name'] . ' </option>';
        }

        return $echo;
    }

    public static function getAll() {

        $sql = "SELECT * FROM `classe`";
        $array = loadSqlResultArrayList($sql);

        return $array;
    }

}

?>