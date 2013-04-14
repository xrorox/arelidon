<?php

class effect {

    private $id;
    private $effect_on_char_id;
    private $target; // target = char_id ou mstr_id
    private $target_id;
    private $name;
    private $description;
    private $neg; // permet de d�finir si l'effet est n�gatif ou positif
    private $skill_level;
    private $duree_tour;
    private $duree_time;
    private $pl_duree_tour;
    private $pl_duree_time;
    private $dmg;
    private $pl_dmg;
    private $duree_tour_stay;
    private $duree_time_stay;
    private $no_atq;
    private $esq;
    private $brise_armure;
    private $pl_no_atq;
    private $pl_esq;
    private $pl_brise_armure;
    private $silence;
    private $taunt;
    private $effect_by;
    private $str;
    private $dex;
    private $con;
    private $int;
    private $sag;
    private $res;
    private $cha;
    private $life;
    private $mana;
    private $pl_str;
    private $pl_dex;
    private $pl_con;
    private $pl_int;
    private $pl_sag;
    private $pl_res;
    private $pl_cha;
    private $pl_life;
    private $pl_mana;

    function __construct() {
        $num = func_num_args();
        switch ($num) {
            case 2 :
                $arg1 = func_get_arg(0);
                $arg2 = func_get_arg(1);
                $this->loadEffect($arg1, $arg2);
                break;

            case 3 :
                $arg1 = func_get_arg(0);
                $arg2 = func_get_arg(1);
                $arg3 = func_get_arg(2);
                $this->loadEffectOnChar($arg1, $arg2, $arg3);
                break;
        }
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getPlLevel() {
        return $this->skill_level;
    }

    function getDescription() {
        // On remplace les %caract dans la description par leurs valeurs selon le niveau	
        $description = $this->description;

        $array = getCaractList('1', '1', '1');
        foreach ($array as $caract) {
            $search_string = '%' . $caract;
            $iCpt = substr_count($description, $search_string);

            if ($iCpt >= 1) {
                $pl_caract = 'pl_' . $caract;
                $value = $this->$caract + ($this->$pl_caract * $this->getPlLevel());

                $value = round($value);
                if ($value < 0)
                    $value = -1 * $value;

                $description = str_replace($search_string, $value, $description);
            }
        }

        return $description;
    }

    function isNegatif() {
        if ($this->neg == 1)
            return true;
        else
            return false;
    }

    function getDureeTour() {
        return floor($this->duree_tour + ($this->pl_duree_tour * $this->getPlLevel()));
    }

    function getDureeTime() {
        return floor($this->duree_time + ($this->pl_duree_time * $this->getPlLevel()));
    }

    function get($type) {
        return $this->type;
    }

    function getTot($type) {
        $pltype = "pl_" . $type;
        return $this->$type + ($this->$pltype * $this->getPlLevel());
    }

    function getDmg() {
        return $this->dmg + round($this->pl_dmg * ($this->skill_level - 1));
    }

    function getTaunt() {
        return $this->taunt;
    }

    function effect_by() {
        return $this->effect_by;
    }

    function loadEffect($id, $skill_level = 0) {
        $sql = "SELECT SQL_SMALL_RESULT SQL_CACHE * FROM `effect` WHERE id = '$id' LIMIT 1";
        $result = loadSqlResultArray($sql);
        pre_dump($id);
        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    function loadEffectOnChar($target, $id, $target_id) {
        $sql = "SELECT SQL_SMALL_RESULT SQL_NO_CACHE * FROM `effect_on_char` WHERE effect_id = $id AND $target = '" . $target_id . "'";
        $result = loadSqlResultArray($sql);

        $this->loadEffect($result['effect_id'], $result['skill_level']);

        $this->effect_on_char_id = $id;
        $this->target_id = $target_id;
        $this->target = $target;

        $this->duree_tour_stay = $result['duree_tour'];
        $this->duree_time_stay = $result['duree_time'];

        $this->effect_by = $result['effect_by'];
    }

    function getPict() {
        $urlimg = 'pictures/effect/' . $this->getId() . '.gif';
        $str = "<div>" .
                "	<u>" . $this->getName() .
                "</u></div><hr /><div>" .
                "" . $this->getDescription() .
                "</div><hr />" .
                "<div> dur&eacute;e restante : " . $this->getDuree() .
                "</div>";
        $str = imgWithTooltip($urlimg, $str, '', '', 'width:200px;', 'width:250px;', true);

        return $str;
    }

    function update($row, $value) {
        $sql = "UPDATE `effect` SET $row = '$value' WHERE id = " . $this->id;
        loadSqlExecute($sql);
    }

    function updateOnChar($row, $value) {
        $sql = "UPDATE `effect_on_char` SET $row = '$value' " .
                "WHERE effect_id = " . $this->effect_on_char_id . " &&  " . $this->target . " = " . $this->target_id;
        loadSqlExecute($sql);
    }

    function getDuree() {
        $this->duree_tour = round($this->duree_tour);
        if ($this->duree_tour >= 1) {
            $duree_tour = $this->duree_tour + ($this->pl_duree_tour * $this->getPlLevel());

            // il faut enlev� le d�compte du tour ou il va �tre lanc�
            $duree_tour = $duree_tour - 1;

            if ($duree_tour > 1)
                $txt = $duree_tour . ' attaques';
            else
                $txt = $duree_tour . ' attaque';
        }elseif ($this->duree_time > 1) {
            $time_last = $this->duree_time + ($this->pl_duree_time * $this->getPlLevel());
            $txt = timestampToHour($time_last, 'h', 'm', 's');
        } else {
            $txt = 'erreur';
        }

        return $txt;
    }

    function getDureeRestante() {

        $time = time();
        if ($this->duree_tour_stay >= 1) {
            $this->duree_tour_stay = round($this->duree_tour_stay);
            if ($this->duree_tour_stay > 1)
                $txt = $this->duree_tour_stay . ' attaques';
            else
                $txt = $this->duree_tour_stay . ' attaque';
        }elseif ($this->duree_time_stay > $time) {
            $time_last = $this->duree_time_stay - $time;
            $txt = timestampToHour($time_last, 'h', 'm', 's');
        } else {
            $txt = 'erreur';
        }
        return $txt;
    }

    function addEffect($object, $type = 'char_id', $skill_level = 1, $effect_by = 0) {
        $this->skill_level = $skill_level;

        if ($this->duree_time > 0)
            $time_more = time() + ($this->getDureeTime());
        else
            $time_more = 0;

        if ($this->duree_tour > 0)
            $nb_tour = $this->getDureeTour();
        else
            $nb_tour = 0;
        $sql = "SELECT COUNT(*) FROM `effect_on_char` " .
                "WHERE effect_id = $this->id AND $type = " . $object->getId() . "";
        $count = loadSqlResult($sql);

        if ($count >= 1) {
            $sql = "UPDATE `effect_on_char` " .
                    "SET duree_tour = $nb_tour,duree_time = $time_more,skill_level = $skill_level,effect_by = $effect_by " .
                    "WHERE effect_id = $this->id AND $type = " . $object->getId();
            loadSqlExecute($sql);
        } else {
            $sql = "INSERT INTO `effect_on_char` " .
                    "(effect_id,$type,duree_tour,duree_time,skill_level,effect_by) " .
                    "VALUES " .
                    "($this->id," . $object->getId() . ",$nb_tour,$time_more,$skill_level,$effect_by)";
            loadSqlExecute($sql);
        }
    }

    function reduceTourOnChar() {
        $new_tour = $this->duree_tour_stay - 1;

        if ($new_tour == 0)
            $this->deleteEffectOnChar();
        else
            $this->updateOnChar('duree_tour', $new_tour);
    }

    function deleteEffectOnChar() {
        $sql = "DELETE FROM `effect_on_char` " .
                "WHERE effect_id = " . $this->effect_on_char_id . " &&  " . $this->target . " = " . $this->target_id;
        loadSqlExecute($sql);
    }

    static public function deleteAllEffect($id, $type = 'char_id') {
        $sql = "DELETE FROM `effect_on_char` WHERE $type = " . $id;
        loadSqlExecute($sql);
    }

    static public function getAllEffectOnChar($object, $type = 'char_id') {
        $time = time();
        $sql = "DELETE FROM `effect_on_char` WHERE (duree_tour = 0 && duree_time < $time)";
        loadSqlExecute($sql);

        $sql = "SELECT * FROM `effect_on_char` WHERE $type = " . $object->getId();
        return loadSqlResultArrayList($sql);
    }

    static public function getAllDamageEffectOnChar($object, $type = 'char_id', $condition_sup = "") {
        $sql = "SELECT * FROM `effect_on_char` eoc JOIN effect e ON eoc.effect_id = e.id " .
                "WHERE $type = " . $object->getId() . " " .
                "AND e.dmg > 0 ";
        return loadSqlResultArrayList($sql);
    }

    static public function getAllEffectWithTurnDurationOnChar($char_id = 0) {
        $sql = "SELECT * FROM `effect_on_char` WHERE char_id = " . $char_id . " && duree_tour > 0";
        return loadSqlResultArrayList($sql);
    }

    static public function getAllEffectWithTurnDurationOnMonster($mstr_id = 0) {
        $sql = "SELECT * FROM `effect_on_char` WHERE mstr_id = " . $mstr_id . " && duree_tour > 0";
        return loadSqlResultArrayList($sql);
    }

}

?>