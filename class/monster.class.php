<?php

class monster {

    private $id;
    private $idmstr;
    private $abs;
    private $ord;
    private $map;
    private $abs_base;
    private $ord_base;
    private $nom;
    private $level;
    private $taille;
    private $exp;
    private $range_min;
    private $range_max;
    private $life;
    private $mana;
    private $str;
    private $con;
    private $dex;
    private $int;
    private $sag;
    private $res;
    private $typeattack;
    private $levelattack;
    private $timestamprespawn;
    private $timerespawn;
    private $timestamp_regen;
    private $area_respawn;
    private $donjon_group_id;
    private $res_fire;
    private $res_snow;
    private $res_wind;
    private $res_earth;
    private $res_poison;
    private $res_holy;

    function __construct() {
        $num = func_num_args();
        switch ($num) {
            case 1 :
                $this->loadMonsterInfo(func_get_arg(0));
                break;
            case 2 :
                $this->loadMonsterInfoType(func_get_arg(0));
                break;
        }
    }

    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function getIdMstr() {
        return $this->idmstr;
    }

    function setAbs($abs) {
        $this->abs = $abs;
    }

    function getAbs() {
        if ($this->abs > 25)
            $this->abs = 25;

        if ($this->abs <= 0)
            $this->abs = 1;

        return $this->abs;
    }

    function setOrd($ord) {
        $this->ord = $ord;
    }

    function getOrd() {
        if ($this->ord > 15) {
            $this->ord = 15;
            $this->update('ord', 15);
        }

        if ($this->ord <= 0) {
            $this->ord = 1;
            $this->update('ord', 1);
        }

        return $this->ord;
    }

    function getNeutral() {
        return $this->res;
    }

    function getFire() {
        return $this->res_fire;
    }

    function getSnow() {
        return $this->res_snow;
    }

    function getWind() {
        return $this->res_wind;
    }

    function getEarth() {
        return $this->res_earth;
    }

    function getHoly() {
        return $this->res_holy;
    }

    function getPoison() {
        return $this->res_poison;
    }

    function getLevel() {
        return $this->level;
    }

    function getTaille() {
        return $this->taille;
    }

    function getExp() {
        return $this->exp;
    }

    /* TODO */

    function getGold() {
        return 100;
    }

    function setName($name) {
        $this->nom = $name;
    }

    function getName() {
        if ($this->nom == "" || $this->nom == null)
            $this->loadMonsterInfoType($this->idmstr);
        return $this->nom;
    }

    function setRangeMin($range_min) {
        $this->range_min = $range_min;
    }

    function getRangeMin() {
        return $this->range_min;
    }

    function setRangeMax($range_max) {
        $this->range_max = $range_max;
    }

    function getRangeMax() {
        return $this->range_max;
    }

    function getCaract($caract) {
        return $this->$caract;
    }

    function setLife($life) {
        if ($life <= $this->getLifeMax())
            $this->life = $life;
        else
            $this->life = $this->getLifeMax();
    }

    function getLife() {
        if ($this->life > $this->getLifeMax())
            $this->life = $this->getLifeMax();

        return $this->life;
    }

    function setMana($mana) {
        if ($mana <= $this->getManaMax())
            $this->mana = $mana;
        else
            $this->mana = $this->getManaMax();
    }

    function updateMana($more) {
        $mana = $this->mana - $more;
        $this->updateOnMap('mana', $mana);
    }

    function getMana() {
        return $this->mana;
    }

    function getMap() {
        return $this->map;
    }

    function loadMonsterInfo($id) {
        $sql = "SELECT * FROM `monsteronmap`WHERE `id` = '" . $id . "'";
        $result = loadSqlResultArray($sql);



        foreach ($result as $key => $value) {
            $this->$key = $value;
        }

        //$this->verifUpdate();

        $this->loadMonsterInfoType($this->idmstr);
    }

    function loadMonsterInfoType($idmstr) {

        $sql = "SELECT con,dex,exp,`int`,level,levelattack,nom,range_max,range_min,res,
            res_earth,res_fire,res_holy,res_snow,res_wind,sag,str,taille,timerespawn,typeattack FROM `monster`WHERE `id` = '" . $idmstr . "' ";
        $result = loadSqlResultArray($sql);


        if (is_array($result) AND count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }

        $this->area_respawn = 1;
    }

    function addMonster($nom, $taille, $level, $exp, $str, $con, $dex, $int, $sag, $res, $range_min = 1, $range_max = 1, $timerespawn = 10) {
        $sql = "INSERT INTO `monster` (`id` ,`nom`,`taille`,`level` ,`exp` ,`str` ,`con` ,`dex` ,`int` ,`sag` ,`res` ,`cha` ,`typeattack` ,`levelattack` ,`timerespawn`,`range_min`,`range_max`)VALUES (NULL , '$nom', '$taille', '$level', '$exp', '$str', '$con', '$dex', '$int', '$sag', '$res', '0', '1', '1','$range_min','$range_max', '$timerespawn')";
        loadSqlExecute($sql);
    }

    function addMonsterOnMap($abs, $ord, $map, $donjon_group_id = 0) {
        $life = $this->getLifeMax();
        $mana = $this->getManaMax();
        $idmster = $this->idmstr;

        $name = htmlentities($name, ENT_QUOTES);

        $sql = "INSERT INTO monsteronmap (idmstr,abs,ord,abs_base,ord_base,map,life,mana,donjon_group_id) values ('$idmster','$abs','$ord','$abs','$ord','$map','$life','$mana','$donjon_group_id');";
        loadSqlExecute($sql);
    }

    function update($type, $value) {
        $this->$type = $value;
        $sql = "UPDATE monsteronmap SET `" . $type . "` = '" . $value . "' WHERE id = '" . $this->id . "'";
        loadSqlExecute($sql);
    }

    function getPourcentLife() {
        $lifemax = $this->getLifeMax();
        $life = ($this->life / $lifemax) * 100;

        $life = round($life);

        if ($life < 0)
            $life = 0;
        if ($life > 100)
            $life = 100;

        return $life;
    }

    function getPourcentMana() {
        $manamax = $this->getManaMax();

        $mana = ($this->mana / $manamax) * 100;

        $mana = round($mana);

        if ($mana < 0)
            $mana = 0;
        if ($mana > 100)
            $mana = 100;

        return $mana;
    }

    function getLifeMax() {
        $lifemax = $this->con * 5 + $this->level * 2;
        return $lifemax;
    }

    function getManaMax() {
        $manamax = $this->int * 3 + $this->level;
        return $manamax;
    }

    function updateMonster($stat, $value) {
        $this->$stat = $value;
        $sql = "UPDATE monsteronmap SET " . $stat . " = '" . $value . "' WHERE id = '" . $this->idmonster . "'";
        loadSqlExecute($sql);
    }

    function updateOnMap($stat, $value) {
        $this->$stat = $value;
        $sql = "UPDATE monsteronmap SET " . $stat . " = '" . $value . "' WHERE id = '" . $this->id . "'";
        loadSqlExecute($sql);
    }

    function updateLife($damage) {
        $newlife = $this->life - $damage;

        if ($newlife <= 0) {

            $newlife = 0;
        }

        if ($newlife > $this->getLifeMax()) {
            $newlife = $this->getLifeMax();
        }
        $this->update('life', $newlife);
        pre_dump($this->life);

        /*
          // Explication : 80% de l'exp est attribu� � la vie , 20% restant � la mort du monstre
          $expPerHp = ($this->exp * 0.7) / ($this->con * 5) ;
          $expWin = $expPerHp * $dommage;
          if($this->life == 0)
          {
          $expWin = $expWin + round($this->exp * 0.33);
          }
          return $expWin;

         */
    }

    function updateRespawn() {
        $life = $this->getLifeMax();
        $mana = $this->getManaMax();

        if ($this->donjon_group_id >= 1) {
            $newrespawn = time() + ($this->timerespawn * 1000000);
            return false;
        }
        else
            $newrespawn = time() + $this->timerespawn;



        // gestion du respawn pas à la même case
        $free = 0;
        $max = 1;
        while ($free != 1 && $max <= 5) {
            $rand_abs = mt_rand(-1, 1);
            $rand_ord = mt_rand(-1, 1);

            $new_abs = $this->abs_base + $rand_abs;
            $new_ord = $this->ord_base + $rand_ord;

            if ($new_abs > 25)
                $new_abs = 25;

            if ($new_abs < 0)
                $new_abs = 0;


            if ($new_ord > 15)
                $new_ord = 15;

            if ($new_ord < 0)
                $new_ord = 0;


            if (map::caseFree($this->map, $new_abs, $new_ord))
                $free = 1;

            $max++;
            if ($max == 5) {
                $new_abs = $this->abs_base;
                $new_ord = $this->ord_base;
            }
        }

        $this->timestamprespawn = $newrespawn;
        $this->life = $life;
        $this->mana = $mana;
        $this->abs = $new_abs;
        $this->ord = $new_ord;
        $sql = "UPDATE `monsteronmap` SET timestamprespawn=" . $newrespawn . ", life=" . $newrespawn . ", mana=" . $mana . ", abs=" . $new_abs . ", ord=" . $new_ord . " WHERE id=" . $this->id;
        loadSqlExecute($sql);
    }

    function getTot($type) {
        return $this->$type + $this->getBonusByEffect($type);
    }

    function getaTot($type) {
        return $this->getBonusByEffect($type);
    }

    function getBonusByEffect($type) {
        $time = time();
        $sql = "SELECT e.$type " .
                "FROM `effect` e JOIN `effect_on_char` eoc " .
                "ON e.id = eoc.effect_id " .
                "WHERE eoc.mstr_id = $this->id AND (eoc.duree_time >= $time OR eoc.duree_tour >= 1)";

        $result_array = loadSqlResultArrayList($sql);

        foreach ($result_array as $value) {
            if (is_array($value)) {
                foreach ($value as $value_2) {
                    $result = $result + $value_2;
                }
            } else {
                $result = $result + $value;
            }
        }

        return $result;
    }

    function getTimestampRespawn() {
        return $this->timestamprespawn;
    }

// Gestions des drops

    function getDrops() {
        $sql = "SELECT * FROM `drop` WHERE monster = $this->idmstr";
        return loadSqlResultArrayList($sql);
    }

    function addDrop($name, $pourcent) {
        if ($pourcent < 1)
            $pourcent = 1;
        if ($pourcent > 100)
            $pourcent = 100;
        $item_id = item::getIdByName($name);
        $sql = "INSERT INTO `drop` (`monster`,`item`,`pourcent`) VALUES ($this->idmstr,$item_id,$pourcent)";
        loadSqlExecute($sql);
    }

    function deleteDrop($item_id) {
        $sql = "DELETE FROM `drop` WHERE monster = $this->idmstr && item = $item_id";
        loadSqlExecute($sql);
    }

    function getSkills() {
        $sql = "SELECT * FROM `monster_attack` WHERE monster_id = $this->idmstr";
        return loadSqlResultArrayList($sql);
    }

    function addSkill($name, $level, $rate = 100) {
        $skill_id = skill::getIdByName($name);
        $sql = "INSERT INTO `monster_attack` (`monster_id`,`skill_id`,`level`,`rate`) VALUES ($this->idmstr,$skill_id,$level,$rate)";
        loadSqlExecute($sql);
    }

    function deleteSkill($skill_id) {
        $sql = "DELETE FROM `monster_attack` WHERE monster_id = $this->idmstr && skill_id = $skill_id";
        loadSqlExecute($sql);
    }

// Fonction permettant de g�rer regen HP/MANA
    function verifUpdate() {
        $time = $_SERVER['REQUEST_TIME'];

        if ($this->timestamp_regen == 0)
            $this->updateOnMap('timestamp_regen', $time);

        // Donn�es de la derni�re mise � jour
        $retour = getdate($this->timestamp_regen);

        $ancienne_heure = $retour["hours"];
        $ancien_jour = $retour["mday"];
        $m = $retour["mon"];
        $a = $retour["year"];

        // Donn�es de l'heure actuelle
        $retour2 = getdate($time);
        $nouvelle_heure = $retour2["hours"];
        $nouveau_jour = $retour2["mday"];

        // on met � jours si sa fait plus d'une heure
        if ($nouvelle_heure != $ancienne_heure or ($nouvelle_heure == $ancienne_heure && $ancien_jour != $nouveau_jour)) {
            // calcul de l'�cart d'heure
            $ecart = $nouvelle_heure - $ancienne_heure;
            if ($ecart < 0)
                $ecart = $ecart + 24;

            // Ecart de jour entre la derni�re update et aujourd'hui
            if ($ancien_jour != $nouveau_jour) {
                $timestamp_date_test = mktime(0, 0, 0, $m, $ancien_jour, $a);

                // on calcule le nombre de secondes d'�cart entre les deux dates
                $ecart_secondes = $time - $timestamp_date_test;
                // puis on tranforme en jours (arrondi inf�rieur)
                $ecart_jours = floor($ecart_secondes / (60 * 60 * 24));
            }

            $ecart = $ecart + ($ecart_jours * 24);


            // Reg�n�ration de la vie
            $vieregen = floor($ecart * (($this->getLifeMax() * 20) / 100));


            // regen de vie � revoir probl�me sur araign�e
            $this->setLife($this->getLife() + $vieregen);
            //$this->updateOnMap('life',$this->getLife());
            // Reg�n�ration de la vie
            $manaregen = floor($ecart * (($this->getManaMax() * 30) / 100));

            $this->setMana($this->getMana() + $manaregen);
            $this->updateOnMap('mana', $this->getMana());


            $this->update('timestamp_regen', $_SERVER['REQUEST_TIME']);
        }
    }

    function isTaunt() {
        $sql = "SELECT * FROM `effect_on_char` eoc JOIN effect e ON eoc.effect_id = e.id " .
                "WHERE `mstr_id` = " . $this->getId() . " " .
                "AND e.taunt > 0 ";

        $result = loadSqlResultArrayList($sql);

        if (count($result) >= 1)
            return true;
        else
            return false;
    }

    function isSilence() {
        $sql = "SELECT * FROM `effect_on_char` eoc JOIN effect e ON eoc.effect_id = e.id " .
                "WHERE `mstr_id` = " . $this->getId() . " " .
                "AND e.silence > 0 ";

        $result = loadSqlResultArrayList($sql);

        if (count($result) >= 1)
            return true;
        else
            return false;
    }

// Retourne l'instance du joueur qui a taunt le monstre
    function tauntBy() {
        $sql = "SELECT effect_by FROM `effect_on_char` eoc JOIN effect e ON eoc.effect_id = e.id " .
                "WHERE `mstr_id` = " . $this->getId() . " " .
                "AND e.taunt > 0 LIMIT 1 ";

        $result = loadSqlResult($sql);
        return $result;
    }

    function getSkillArrray() {
        $sql = "SELECT skill_id,level,rate FROM `monster_attack` WHERE monster_id = " . $this->idmstr;
        $array = loadSqlResultArrayList($sql);

        $skill_level = round($this->getLevel() / 4);
        if ($skill_level < 1)
            $skill_level = 1;
        else if ($skill_level > 5)
            $skill_level = 5;

        if ($this->getRangeMax() >= 2) {
            $sub_array = array('skill_id' => '25', 'level' => $skill_level, 'rate' => '100');
        } else {
            $sub_array = array('skill_id' => '1', 'level' => $skill_level, 'rate' => '100');
        }

        $array[] = $sub_array;


        return $array;
    }

    function isEffectBy($effect_id = 0) {
        $sql = "SELECT COUNT(*) FROM effect_on_char " .
                "WHERE effect_id = $effect_id AND mstr_id = " . $this->id;
        if (loadSqlResult($sql) == 1)
            return true;
        else
            return false;
    }

// Fonctions publiques

    static public function deleteMonsterOnMap($abs, $ord, $idmap) {
        $sql = "DELETE FROM `monsteronmap` WHERE map = $idmap && abs_base = $abs && ord_base = $ord";
        loadSqlExecute($sql);
    }

    static public function getAllMonster($min, $max, $order, $asc) {
        $sql = "SELECT * FROM monster ";

        if ($order != '')
            $sql .= " ORDER BY `" . $order . "` $asc ";

        $sql .= "LIMIT " . $min . "," . $max;
        $return = loadSqlResultArrayList($sql);

        return $return;
    }

    public static function getIdByName($name) {
        $name = htmlentities($name, ENT_QUOTES);
        $sql = "SELECT id FROM monster WHERE nom = '$name' LIMIT 0, 1";

        return loadSqlResult($sql);
    }

    public static function getNameById($id) {
        $sql = "SELECT nom FROM monster WHERE id = '$id' LIMIT 0, 1";
        return loadSqlResult($sql);
    }

    public static function getAllMonsterObject() {
        $sql = "SELECT id FROM monster";
        $array_result = loadSqlResultArrayList($sql);

        foreach ($array_result as $result) {
            $array_monster[] = new monster($result['id'], 'type');
        }
        return $array_monster;
    }

    public static function getAllMonsters($select = "*") {
        $sql = "SELECT $select FROM monster";
        $result = loadSqlResultArrayList($sql);
        return $result;
    }

    public static function getAllMonstersOnMap($idmap, $timerespawn = 0, $group_id = 0, $type = 0) {
        $sql = "SELECT SQL_SMALL_RESULT SQL_NO_CACHE monsteronmap.id,
        monsteronmap.abs,monsteronmap.ord,monsteronmap.idmstr,monster.taille 
        FROM monsteronmap JOIN monster ON monsteronmap.idmstr = monster.id WHERE map = '$idmap' && life > '0' ";

        if ($timerespawn > 0)
            $sql .= " AND timestamprespawn <= '$timerespawn'";

        if ($group_id > 0)
            $sql .= " AND donjon_group_id = '$group_id'";

        $sql .= " ORDER BY ord ASC ";


        $result = loadSqlResultArrayList($sql);

        return $result;
    }

}

?>