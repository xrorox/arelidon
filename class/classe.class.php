<?php

class classe {

    private $id;
    private $name;

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

    public static function getDescription($classe) {
        switch ($classe) {
            case 1:
                $desc = "Le guerrier bla bla bla trop fort corps � corps il roxx � fond. Il peut aussi d�coup� ta maman";
                break;
            case 2:
                $desc = "Il tire des fl�ches � distance c'est une grosse tafiolle d'elfe faut le br�ler";
                break;
            case 3:
                $desc = "Super boule de feu toussa toussa, cool il va pouvoir bruler l'elfe";
                break;
            case 4:
                $desc = "Il lance des soins, c'est ce gros d�bile qui a soign� l'elfe la derni�re fois";
                break;
            case 5:
                $desc = "Paladin tank et lance des soins il est trop cheat";
                break;
            case 6:
                $desc = "Chaman lance des buffs et tape fort";
                break;
            case 7:
                $desc = "Elementariste lance des supers sorts d'AoE";
                break;
            case 8:
                $desc = "Peut r�suciter les morts et lance des mal�dictions";
                break;
        }

        return htmlentities($desc);
    }

    public static function GetClasseNameById($id) {
        if ($id == 0) {
            $echo = " Toutes";
        } else {
            //		$sql="SELECT name FROM `classe` WHERE id=".$id;
            //		$echo=loadSqlResult($sql);
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