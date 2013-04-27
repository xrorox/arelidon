<?php

class char {

    private $id;
    private $name;
    private $level = 1;
    private $exp = 0;
    private $aexp = 300;
    private $idaccount;
    private $user;
    private $vip;
    private $points;
    private $classe;
    private $gender;
    private $skin;
    private $fatigue;
// Info clan

    private $guild_id = 0;
    private $guild_rank = 0;

    /**

     *  faction

     *  1 => Nudricien

     *  2 => Umodien

     *  3 => amodien

     */
    private $faction;
    private $honnor;
    private $kills;
    private $deaths;
// Cordonn�es    

    private $map = 1;
    private $abs = 3;
    private $ord = 6;
// Caractéristique     
    private $life = 12;
    private $mana = 7;
    private $str;
    private $con;
    private $dex;
    private $int;
    private $sag;
    private $res;
    private $cha;
    private $astr;
    private $acon;
    private $adex;
    private $aint;
    private $asag;
    private $ares;
    private $acha;
    private $res_fire;
    private $res_snow;
    private $res_wind;
    private $res_earth;
    private $res_poison;
    private $res_holy;
    private $maxlife = 12;
    private $maxmana = 7;
    private $group_id;
// Info du jeu

    private $pa = 240;
    private $pp = 100;
    private $gold;
    private $boostpoint;
    private $skillpoint;
    private $mute;
    // Gestion du temps de connexion et update

    private $time_connexion;
    private $time_update;
    private $time_die;
    private $regulating;
    // Pour lier au combat
    private $fight_id;

    public function setFightId($fight_id) {
        $this->fight_id = $fight_id;
    }

    public function getFightId() {
        return $this->fight_id;
    }

    function __construct() {

        if(func_num_args() > 0)
        {
            $num = func_get_arg(0);
            
            $number = false;
            $array = false;

            if (intval($num) > 0)
            {
                $number = true;
            }
            elseif (is_array($num)) {
                $array = true;
            }

            if ($number)
                $this->loadChar(func_get_arg(0));
            elseif ($array)
                $this->loadCharByArray(func_get_arg(0));
            else
                $this->loadCharByName(func_get_arg(0));
        }
    }

    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function getGuildRank() {
        return $this->guild_rank;
    }

    function getGroupId() {
        return $this->group_id;
    }

    function setGroupId($group_id) {
        $this->group_id = $group_id;
    }

    function setGuildRank($rank) {
        $this->guild_rank = $rank;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getName() {
        return $this->name;
    }

    function setFace($face) {
        return $this->face;
    }

    function getNameWithColor($limit = 12) {
        $this->name = html_entity_decode($this->name, ENT_QUOTES, "UTF-8");

        $name = substr($this->name, 0, $limit);

        if (strlen($this->name) > $limit)
            $name .= ".";

        if ($this->getUser()->isAdmin())
            $name = '<font style="color:#CC3300;">' . $name . '</font>';
        return $name;
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

    function getCaract($caract) {
        return $this->$caract;
    }

    function getCaractList($perso = 1, $item = 0, $effect = 0) {
        $array = array('1' => 'str', '2' => 'con', '3' => 'dex', '4' => 'int', '5' => 'sag', '6' => 'res');

        if ($perso == 1)
            $array[] = 'cha';

        if ($item == 1) {
            $array[] = 'life';
            $array[] = 'mana';
        }

        if ($effect == 1)
            $array[] = 'dmg';

        return $array;
    }

    function setClasse($classe) {
        $this->classe = $classe;
    }

    function getClasse() {
        return $this->classe;
    }

    function setGender($gender) {
        if ($gender > 2)
            $gender = 2;

        $this->gender = $gender;
    }

    function getGender() {
        if ($this->gender == 0)
            $this->gender = 1;
        return $this->gender;
    }

    function setSkin($skin) {
        $this->skin = $skin;
    }

    function getFatigue() {
        return $this->fatigue;
    }

    function addFatigue($fatigue) {
        $this->fatigue += $fatigue;

        if ($this->fatigue < 0)
            $this->fatigue = 0;
        if ($this->fatigue > 500)
            $this->fatigue = 500;
    }

    function getSkin() {
        if ($this->skin != 0)
            return $this->skin;
        else
            return $this->gender;
    }

    function getTheSkin($skin_id, $num = 0) {
        if ($num <= 2) {
            return true;
        } else {
            $sql = "SELECT COUNT(*) FROM `skin_on_user` WHERE
				user_id = '" . $this->getIdaccount() . "' && skin_id = '$skin_id' ";
            $result = loadSqlResult($sql);

            if ($result == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    function setLevel($level) {
        $this->level = $level;
    }

    function getLevel() {
        return $this->level;
    }

    function setFaction($faction) {
        $this->faction = $faction;
    }

    function getFaction() {
        return $this->faction;
    }

    function setHonnor($honnor) {
        $this->update('honnor', $honnor);
    }

    function getHonnor() {
        return $this->honnor;
    }

    function getKills() {
        return $this->kills;
    }

    function getDeaths() {
        return $this->deaths;
    }

    function getRank() {
        $honnor = $this->honnor;

        // Rang positif

        if ($honnor < 1000 and $honnor >= 0)
            $str = 'Initi&eacute;';

        elseif ($honnor < 3000 and $honnor >= 0)
            $str = 'Mercenaire';

        elseif ($honnor < 10000 and $honnor >= 0)
            $str = 'Gladiateur';

        elseif ($honnor < 25000 and $honnor >= 0)
            $str = 'Chevalier';

        elseif ($honnor >= 25000 and $honnor >= 0)
            $str = 'Champion';

        if ($str == '') {
            if ($honnor > -1000 and $honnor < 0)
                $str = 'Bandit';
            elseif ($honnor > -3000)
                $str = 'Tueur';
            elseif ($honnor > -10000)
                $str = 'Assassin';
            elseif ($honnor > -25000)
                $str = 'Seigneur noir';
            elseif ($honnor <= -25000)
                $str = 'La peste m&ecirc;me';
        }
        return $str;
    }

    function setIdaccount($idaccount) {
        $this->idaccount = $idaccount;
    }

    function getIdaccount() {
        return $this->idaccount;
    }

    function setUser($user) {
        if ($user instanceof user)
            $this->user = $user;
    }

    function getUser() {
        if ($this->user instanceof user) {
            $user = $this->user;
        } else {
            $user = new user(user::getLoginById($this->getIdaccount()));
            $this->setUser($user);
        }
        return $user;
    }

    function getVip() {
        return $this->vip;
    }

    function isVip() {
        if ($this->vip >= $_SERVER['REQUEST_TIME'])
            return true;
        else
            return false;
    }

    function getPoints() {
        return $this->points;
    }

// Evite que du � un lag r�seau ou � un double clique de l'utilisateur que l'objet se fasse 2 fois
// La table points_buy permet aussi d'effectuer des stats sur les achats

    function canUsePoint() {
        $time_limit = $_SERVER['REQUEST_TIME'] - 3;
        $sql = "SELECT COUNT(*) FROM `points_buy` WHERE char_id = " . $this->getId() . " && timestamp > " . $time_limit;
        $count = loadSqlResult($sql);

        if ($count >= 1)
            return false;
        else
            return true;
    }

    function setMap($map) {
        $this->map = $map;
    }

    function getMap() {

        if ($this->map == 0) {
            $faction = new faction($this->getFaction());
            $map_init = $faction->getMap();
            $sql = "UPDATE `char_move` SET map=" . $map_init . " WHERE char_id=" . $this->getId();
            loadSqlExecute($sql);
            $this->map = $map_init;
        }
        return $this->map;
    }

    function getMapInstance() {
        $map = new Map($this->getMap());
        return $map;
    }

    function setAbs($abs) {
        if ($abs < 1)
            $abs = 1;

        if ($abs > 25)
            $abs = 25;

        $this->abs = $abs;
    }

    function getAbs() {

        return $this->abs;
    }

    function setOrd($ord) {
        if ($this->ord > 15)
            $ord = 15;
        elseif ($ord < 1)
            $ord = 1;

        $this->ord = $ord;
    }

    function getOrd() {
        return $this->ord;
    }

    function setLife($life) {
        $this->life = $life;
    }

    function getLife() {
        if ($this->life > $this->getLifeMax())
            $this->life = $this->getLifeMax();
        elseif ($this->life < 0)
            $this->life = 0;

        return $this->life;
    }

    function setMana($mana) {
        $this->mana = $mana;
    }

    function getMana() {
        if ($this->mana > $this->getManaMax())
            $this->mana = $this->getManaMax();

        return $this->mana;
    }

    function setGuildId($guild_id) {
        $this->guild_id = $guild_id;
    }

    function getGuildId() {
        return $this->guild_id;
    }

    function setTimeConnexion($time_connexion) {
        $this->time_connexion = $time_connexion;
    }

    function getTimeConnexion() {
        return $this->time_connexion;
    }

    function setTimeUpdate($time_update) {
        $this->time_update = $time_update;
    }

    function getTimeUpdate() {
        return $this->time_time_update;
    }

    function setTimeDie($time_die) {
        $this->time_die = $time_die;
    }

    function getFace() {
        return $this->face;
    }

    function getTimeDie() {
        return $this->time_die;
    }

    function getPA() {
        return $this->pa;
    }

    function getPP() {
        return $this->pp;
    }

    function getGold() {
        if ($this->gold < 0) {
            $this->gold = 0;
            $this->update('gold', 0);
        }

        return $this->gold;
    }

    function setGold($gold) {
        $this->gold = $gold;
    }

    function getBoostPoint() {
        return $this->boostpoint;
    }

    function getSkillPoint() {
        return $this->skillpoint;
    }

    function getRegulating() {
        return $this->regulating;
    }

    function getExp() {
        return $this->exp;
    }

    function isEffectBy($effect_id = 0) {
        $sql = "SELECT COUNT(*) FROM effect_on_char WHERE effect_id = $effect_id AND char_id = " . $this->getId();

        if (loadSqlResult($sql) == 1)
            return true;
        else
            return false;
    }

    function GetMute() {
        return $this->mute;
    }

// Debut des fonctions

    function loadChar($id) {
        if ($id > 0) {
            $sql = "SELECT  * FROM `char` WHERE id = " . $id . " ";
            $result = loadSqlResultArray($sql);
        } else {
            $result = array();
        }

        $this->loadCharByArray($result);
    }

    function loadCharByName($name) {
        if ($name != '') {
            $sql = "SELECT  * FROM `char` WHERE name = " . $name . " ";
            $result = loadSqlResultArray($sql);
        } else {
            $result = array();
        }

        $this->loadCharByArray($result);
    }

    function loadCharByArray($result) {


        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
        // si sa fait plus de 2 minutes qu'on a pas mis a jour , et qu'on instancie l'utilisateur courant
        //TODO : DEplacer ca  � la connexion.
//	if(($_SERVER['REQUEST_TIME'] - $this->getTimeConnexion()) > 300 && $_SESSION["idchar"] == $this->getId())
//		$this->update('time_connexion',$_SERVER['REQUEST_TIME']);
        /*
          if($_SESSION["idchar"] == $this->getId())
          $this->verifUpdate();
         */
        // V�rification que le joueur n'est pas bloqu�

        if (map::isBlock($this->getMap(), $this->getAbs(), $this->getOrd())) {
            $sql = "SELECT abs,ord FROM `map` WHERE map =  '" . $this->getMap() . "' AND bloc = 0 AND changemap > 0 LIMIT 0, 1";
            $result = loadSqlResultArray($sql);

            $this->setAbs($result['abs']);
            $this->setOrd($result['ord']);
        }
    }

    function DeleteChar() {

        $this->update('idaccount', 0);
        $this->update('guild_id', 0);

        $SQL = "INSERT INTO char_recup (char_id, account_id) VALUES (" . $this->id . ", " . $this->idaccount . ");";
        loadSqlExecute($SQL);
    }

    function isMute() {
        return $this->GetMute();
    }

    function disconnectSecondaryCharacter() {

        $char = unserialize($_SESSION['char']);
        $newTime = $_SERVER['REQUEST_TIME'] - 300;
        $SQL = "UPDATE `char` SET `time_connexion`=$newTime WHERE `idaccount`=" . $this->getIdAccount() . " AND id !=" . $this->getId();
        loadSqlExecute($SQL);

        $char = unserialize($_SESSION['char']);
        if ($char != null) {
            $newTime = $_SERVER['REQUEST_TIME'] - 300;
            $SQL = "UPDATE `char` SET `time_connexion`=$newTime WHERE `idaccount`=" . $char->getIdAccount() . " AND id !=" . $char->getId;
            loadSqlExecute($SQL);
        }
    }

    function update($type, $value, $char_id = 0) {
        $this->$type = $value;
        $sql = "UPDATE `char` SET `" . $type . "` = '" . $value . "' WHERE `id` = '" . $this->getId() . "' LIMIT 1 ";
        loadSqlExecute($sql);
        $_SESSION['char'] = serialize($this);
    }

    function updateMore($type, $more, $for = 0) {
        if ($type == 'life') {
            $damage = $more * (-1);
            $this->updateLife($damage);
        } elseif ($type == 'mana') {
            $use = $more * (-1);
            $this->updateMana($use);
        } elseif ($type == 'points') {
            $sql = "SELECT points FROM `char` WHERE id = " . $this->id;
            $points = loadSqlResult($sql);

            $this->points = $this->points + $more;

            $sql = "UPDATE `char` SET `points` = '" . $this->points . "' WHERE `id` = '" . $this->getId() . "' LIMIT 1 ";
            loadSqlExecute($sql);

            $sql = "INSERT INTO points_buy (char_id,timestamp,`for`) VALUES (" . $this->getId() . "," . $_SERVER['REQUEST_TIME'] . ",'$for')";
            loadSqlExecute($sql);
        } else {
            $this->$type = $this->$type + $more;

            switch ($type) {
                case 'pa':

                    if (($this->pa > 800 and !$this->isVip()) or ($this->isVip() and $this->pa > 1200)) {
                        if ($this->isVip()) {
                            $this->pa = 1200;
                        } else {
                            $this->pa = 800;
                        }
                    }


                    break;
                case 'pp':

                    if ($this->pp > 400)
                        $this->pp = 400;

                    break;
                case 'gold':

                    if ($this->$type < 0)
                        $this->$type - $more;
                    break;
            }

            $sql = "UPDATE `char` SET `" . $type . "` = '" . $this->$type . "' WHERE `id` = '" . $this->getId() . "' LIMIT 1 ";
            loadSqlExecute($sql);
        }
        $_SESSION['char'] = serialize($this);
    }

    function updateCaract($caract, $num) {
        if ($this->boostpoint >= 1) {
            $this->updateMore($caract, $num);
            $this->updateMore('boostpoint', -1);
        }
        $_SESSION['char'] = serialize($this);
    }

    function save() {
        if ($this->classe == 0 || $this->gender == 0 || $this->faction == 0 || $this->name == "") {
            return 0;
        }

        $sql = "INSERT INTO `char` (`name`,`idaccount`,`classe`,`gender`,`faction`,`time_connexion`,`time_update`,map,abs,ord,face) " .
                "VALUES ('$this->name','$this->idaccount','$this->classe','$this->gender','$this->faction','$this->time_connexion','$this->time_update'," . $this->getMap() . "," . $this->getAbs() . "," . $this->getOrd() . ",1);";
        loadSqlExecute($sql);

        $sql = "SELECT id FROM `char` WHERE name = '$this->name' LIMIT 1";
        $char_id = loadSqlResult($sql);

        $sql = "INSERT INTO `skillonchar` (`skill_id`,`char_id`,`level`) VALUES ('1','$char_id','1');";
        loadSqlExecute($sql);

        $sql = "INSERT INTO `skill_shortcut` (`num`,`char_id`,`skill_id`) VALUES ('1','$char_id','1');";
        loadSqlExecute($sql);

        return $char_id;
    }

// Return :  1 => valid , 2=> still learned , 3 => no possible
    function learnSkill($idskill) {
        $skill = new skill($idskill);

        $sql = "SELECT count(*) FROM `skillonchar` WHERE skill_id = $idskill && char_id = " . $this->getId();
        $count = loadSqlResult($sql);

        if ($count == 0) {
            if ($skill->getClasse_req() == $this->classe or $skill->getClasse_req() == 0) {
                $sql = "INSERT INTO `skillonchar` (`skill_id`,`char_id`,`level`) VALUES ('$idskill','" . $this->getId() . "','1');";
                loadSqlExecute($sql);

                return 1;
            }
        } else {
            return 2;
        }
    }

    function get($type) {
        $sql = "SELECT " . $type . " FROM char WHERE `id` = '" . $this->getId . "' LIMIT 0, 1 ";
        $result = loadSqlResultArray($sql);

        return $result[$type];
    }

    function getTot($type) {
        $atype = 'a' . $type;
        $total = $this->$type + $this->getaTot($type);
        return $total;
    }

    function getaTot($type) {
        $atype = 'a' . $type;
        return $this->$atype; //+ $this->getBonusByEffect($type) + $this->getBonusBySkill($type);
    }

    function getSkillList() {
        $skillList = array();

        $sql = "SELECT ss.num,ss.skill_id,skillonchar.level,skill.name " .
                "FROM skill_shortcut ss " .
                "JOIN skill ON ss.skill_id = skill.id " .
                "JOIN skillonchar ON skillonchar.skill_id = skill.id " .
                "WHERE ss.char_id = " . $this->getId() . " " .
                "ORDER BY num ASC";

        $result = loadSqlResultArrayList($sql);

        if (count($result) > 0) {
            foreach ($result as $skill) {
                $arrayInfo = array('id' => $skill['skill_id'], 'level' => $skill['level'], 'name' => $skill['name']);
                $num = $skill['num'] - 1;
                $skillList[$num] = $arrayInfo;
            }

            for ($i = 0; $i <= 5; $i++) {
                if (!is_array($skillList[$i])) {
                    $arrayInfo = array('id' => 0, 'level' => 1, 'name' => '');
                    $skillList[] = $arrayInfo;
                }
            }
            // On trie selon les indices (pour laisser les espaces)
            ksort($skillList);
        }
        return $skillList;
    }

    function getSkillListGet() {
        $skillList = array();

        $sql = "SELECT skill_id,level " .
                "FROM skillonchar " .
                "WHERE char_id = " . $this->getId() . " " .
                "ORDER BY skill_id ASC";

        $result = loadSqlResultArrayList($sql);

        foreach ($result as $skill) {
            $arrayInfo = array('id' => $skill['skill_id'], 'level' => $skill['level']);
            $skillList[] = $arrayInfo;
        }
        return $skillList;
    }

    function getBonusByEffect($type) {

        $time = $_SERVER['REQUEST_TIME'];
        $sql = "SELECT eoc.effect_id,eoc.skill_level " .
                "FROM `effect` e JOIN `effect_on_char` eoc " .
                "ON e.id = eoc.effect_id " .
                "WHERE eoc.char_id = $this->id AND (eoc.duree_time >= $time OR eoc.duree_tour >= 1)";

        $result = loadSqlResultArray($sql);
        pre_dump($result);
        if (count($result) > 0) {
            $effect = new effect($result['effect_id'], $result['skill_level']);
            return $effect->getTot($type);
        }
        return 0;
    }

    function getBonusBySkill($type) {
        $time = $_SERVER['REQUEST_TIME'];

        $sql = "SELECT SUM(s.`" . $type . "` + soc.level * s.`pl_" . $type . "`) FROM skill s 

			JOIN skillonchar soc ON s.id = soc.skill_id

			JOIN skill_shortcut ss ON s.id = ss.skill_id

			WHERE soc.char_id = 1 AND ss.char_id = '" . $this->id . "' AND s.typesort = 5";

        return loadSqlResult($sql);
    }

    function updateExp($exp) {
        pre_dump($exp);
        $newexp = $this->exp + $exp;
        $this->update('exp', $newexp);


        while ($this->exp >= $this->aexp) {
            $this->levelup();
        }
    }

    function calculExpNextLevel() {
        $nextLvl = $this->getLevel() + 1;
        $sql = "SELECT nextlevel FROM `level`WHERE `level` = '" . $nextLvl . "' ";
        $result = loadSqlResultArray($sql);

        return $result['nextlevel'];
    }

    function calculExpLevel() {
        $Lvl = $this->getLevel();
        $sql = "SELECT ecart,nextlevel FROM `level` WHERE `level` = '" . $Lvl . "' LIMIT 0, 1";
        $result = loadSqlResult($sql);

        return $result;
    }

    public function loseXP() {

        $aexp = $this->calculExpLevel();
        $exp_char = $this->exp;

        $expToDelete = ($aexp['ecart'] * 0.05);
        $new_exp = $exp_char - $expToDelete;

        if ($new_exp < ($aexp['nextlevel'] - $aexp['ecart'])) {
            $new_exp = $aexp['nextlevel'] - $aexp['ecart'];
        }

        $this->update('exp', $new_exp);
    }

    function levelup() {

        $newExp = $this->calculExpNextLevel();
        $this->aexp = $newExp;
        $newlevel = $this->level = + 1;
        $newBP = $this->boostpoint = + 5;
        $newSP = $this->skillpoint = + 1;
        $this->setLife($this->getLifeMax());
        $this->setMana($this->getManaMax());

        $sql = "UPDATE `char` SET aexp=" . $newExp . ",level=" . $newlevel . ",boostpoint=" . $newBP .
                ",skillpoint=" . $newSP . ", life=" . $this->getLifeMax() . ",mana=" . $this->getManaMax() . " WHERE id=" . $this->getId();
        $_SESSION['char'] = serialize($this);
    }

    function increase($type) {
        if ($this->boostpoint >= 1) {
            $this->$type = $this->$type + 1;
            setStat($type, $this->$type);
            $this->boostpoint = $this->boostpoint - 1;
            setStat('boostpoint', $this->boostpoint);
        }
    }

    function getLifeMax() {
        $lifeMax = ($this->con + $this->acon) * 5 + $this->level * 2;
        if ($this->life > $lifeMax) {
            $this->update('life', $lifeMax);
        }

        if ($lifeMax <= 0) {
            $lifeMax = 1;
        }
        return $lifeMax;
    }

    function getManaMax() {
        $manaMax = ($this->sag + $this->asag) * 3 + $this->level * 1;
        if ($this->mana > $manaMax)
            $this->update('mana', $manaMax);

        if ($manaMax <= 0) {
            $manaMax = 1;
        }

        return $manaMax;
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

        /*
          $this->loseGoldByDeath($pvp_id);
          if($newlife == 0)
          effect::deleteAllEffect($this->id,'char_id');
         */
    }

    function updateMana($manause) {
        $newmana = $this->mana - $manause;

        if ($newmana > $this->getManaMax()) {
            $newmana = $this->getManaMax();
        }
        $this->update('mana', $newmana);
    }

    function deleteAllEffectOnChar() {
        $toto = 0;
    }

    function isConnect() {
        if (($_SERVER['REQUEST_TIME'] - $this->time_connexion) <= 300)
            return true;
        else
            return false;
    }

    function getUrlPicture($type = "pict", $face = 0, $return = false) {
        if ($this->getLife() <= 0 && $type == "ico") {
            $url = "pictures/classe/die.gif";
        } else {

            if ($this->skin == 0 || $type != "ico") {
                $url = "pictures/classe/" . $this->getClasse() . "/" . $type . "/" . $this->getGender();
            } else {
                $url = "pictures/classe/" . $this->getClasse() . "/" . $type . "/" . $this->getSkin();
            }

            if ($face > 0)
                $url .= "-" . $face;

            if ($type != 'pict')
                $url .= ".gif";
            else
                $url .= ".png";
        }
        return $url;
    }

// Retourne vrai si le joueur a d�j� explor� cette carte

    function alreadyExplore($map_id) {
        $sql = "SELECT COUNT(*) FROM `map_exploration` WHERE char_id = " . $this->id . " && map_id = $map_id";
        $result = loadSqlResult($sql);

        if ($result >= 1) {
            return true;
        } else {
            return false;
        }
    }

// Fonction permettant de savoir si le joueur est sur l'ile d'initiation ou non
    function isInInitiate() {
        $map = new map($this->map);
        if ($map->getContinent() <= 3)
            return true;
        else
            return false;
    }

    function isInArena() {
        $map = new map($this->map);
        if ($map->isArena())
            return true;
        else
            return false;
    }

    function isInDonjon() {
        $map = new map($this->map);

        if ($map->isDonjon())
            return true;
        else
            return false;
    }

    function updateBoost() {
        // initialisation 
        $array = getCaractList('1', '0');
        foreach ($array as $caract) {
            $acaract = 'a' . $caract;
            $this->$acaract = 0;
        }
        // Ajout des bonus objets
        $arrayBody = getBodyPartList();
        foreach ($arrayBody as $bodyPart) {
            $iditem = item::getEquipement($this->getId(), $bodyPart);
            $item = new item($iditem);

            $array = getCaractList('1', '0');
            foreach ($array as $caract) {
                $acaract = 'a' . $caract;
                $this->$acaract = $this->$acaract + $item->$caract;
            }
        }
        //save 
        $array = getCaractList('1', '0');
        foreach ($array as $caract) {
            $acaract = 'a' . $caract;
            $this->update($acaract, $this->$acaract);
        }
    }

    function getFactionName() {
        $toto = array(1 => "Nudricien", 2 => "Umodien", 3 => "amodien");
        return $toto[$this->faction];
    }

    function isMeneur() {
        if ($this->getId() == guild::getMeneurIdStatic($this->getGuildId()))
            return true;
        else
            return false;
    }

    function isLord() {

        $guild = new guild($this->getGuildId());
        $array = $guild->getLordList();

        foreach ($array as $id) {

            if ($this->getId() == $id) {
                return true;
            }
        }
        return false;
    }

    function getLocalisation() {
        return map::getLocalisation($this->getMap());
    }

    function verifUpdate() {
        $time = $_SERVER['REQUEST_TIME'];
        $ecart = $time - $this->time_update;
        $ecart = $ecart / 3600;
        // Donn�es de la derni�re mise � jour

        $retour = getdate($this->time_update);
        $ancienne_heure = $retour["hours"];
        $ancien_jour = $retour["mday"];
        $m = $retour["mon"];
        $a = $retour["year"];

        // Donn�es de l'heure actuelle
        $retour2 = getdate($time);
        $nouvelle_heure = $retour2["hours"];
        $nouveau_jour = $retour2["mday"];

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


            if ($ecart < 0) {
                $ecart = $ecart * (-1);
            }
            if ($this->life > 0) {
                // Reg�n�ration de la vie
                $vieregen = round($ecart * (($this->getLifeMax() * 20) / 100));

                $this->updateMore('life', $vieregen);
            }

            // Reg�n�ration de la vie
            $manaregen = round($ecart * (($this->getManaMax() * 30) / 100));
            $this->updateMore('mana', $manaregen);

            /* Plus de regen de PA 
              $pa_regen = round(6 * $ecart);
              $this->updateMore('pa',$pa_regen);

              $pp_regen = round(3 * $ecart);
              $this->updateMore('pp',$pp_regen);
             */
            $this->update('time_update', $time);
        }
    }

// Gestionnaire des r�glages
//  Infos sur les r�glages voir regulating.php

    function loadRegulating() {
        if ($this->id > 0) {
            $sql = "SELECT regulating,value FROM regulating WHERE char_id = " . $this->id . " ";
            $result = loadSqlResultArrayList($sql);

            if (count($result) >= 1) {
                foreach ($result as $array) {
                    $array_return[$array['regulating']] = $array['value'];
                }
                $this->regulating = $array_return;
                return $array_return;
            }
        }
    }

    function updateRegulating($regulating, $value) {
        $sql = "INSERT `regulating` (`char_id`,`regulating`,`value`) " .
                "VALUES " .
                "($this->id,$regulating,$value) " .
                "ON DUPLICATE KEY UPDATE value = $value";

        loadSqlExecute($sql);
    }

    function timeBeforeCanBuyPA() {
        $sql = "SELECT timestamp FROM log_morePA WHERE char_id = " . $this->getId();
        $timestamp_buy = loadSqlResult($sql);

        return ($_SERVER['REQUEST_TIME'] - $timestamp_buy);
    }

    public function getGoldGivenToGuilde() {
        $donation = '';
        //TODO avec nouvelle banque
//	$sql = "SELECT gold FROM `bank_gold` WHERE guild=".$this->getGuildId()." AND char_id=".$this->getId()." ;";
//	$Array=loadSqlResultArrayList($sql);
//
//	foreach ($Array as $don){
//		$donation = $donation + $don['donation'];	
//	}

        if ($donation == '') {
            $donation = 0;
        }
        return $donation;
    }

    public function ArrowUpArrowDown() {

        $onclick = "HTTPTargetCall('pageig/guild/upgrade.php?id=" . $this->GetId() . "&rank=" . $this->getGuildRank() . "','upgrade');";
        $onclick2 = "HTTPTargetCall('pageig/guild/downgrade.php?id=" . $this->GetId() . "&rank=" . $this->getGuildRank() . "','downgrade');";

        $up = '<div id="upgrade" <img src="pictures/iconesbonus/arrow_up_green.png" onclick=' . $onclick . ' alt="Ca marche pas!!!"/></div>';
        $down = '<div id="downgrade"><img src="pictures/iconesbonus/arrow_down_green.png" onclick=' . $onclick2 . ' alt="Ca marche pas"/></div>';

        switch ($this->getGuildRank()) {

            case 0:
                break;
            case 1:
                return $down;
                break;
            case 2:
                return $up;
                break;
        }
    }

    public function loseGoldByDeath($id_pvp = 0) {

        $gold = $this->getGold();
        $gold_to_lose = $gold / 2;

        // On enl�ve au joueur la moiti� de son or
        $this->updateMore('gold', $gold_to_lose * -1);
        if ($id_pvp != 0) {

            // on donne au joueur qui la tu� en pvp l'or perdu par le joueur
            $char2 = new char($id_pvp);
            $char2->updateMore('gold', $gold_to_lose);
        }
    }

    public static function testExtension($guild_id) {

        if (file_exists("pictures/guilde/" . $guild_id . ".png")) {
            return $guild_id . ".png";
        } elseif (file_exists("pictures/guilde/" . $guild_id . ".gif")) {
            return $guild_id . ".gif";
        } elseif (file_exists("pictures/guilde/" . $guild_id . ".bmp")) {
            return $guild_id . ".bmp";
        } elseif (file_exists("pictures/guilde/" . $guild_id . ".jpg")) {
            return $guild_id . ".jpg";
        } elseif (file_exists("pictures/guilde/" . $guild_id . ".jpeg")) {
            return $guild_id . ".jpeg";
        }
    }

    function getInformationsForFiche() {
        $sql = "SELECT name,classe,guild_id,faction,level,honnor FROM `char` WHERE id=" . $this->getId() . " LIMIT 0, 1";
        $return = loadSqlResultArray($sql);
        return $return;
    }

    function isInPvp() {
        $time_limit = time() - 45;
        $sql = "SELECT COUNT(*) FROM `attacks` WHERE timestamp >= $time_limit";

        if (loadSqlResult($sql) >= 1) {
            return true;
        }else
            return false;
    }

    function isSilence() {
        $sql = "SELECT * FROM `effect_on_char` eoc JOIN effect e ON eoc.effect_id = e.id " .
                "WHERE `char_id` = " . $this->getId() . " " .
                "AND e.silence > 0 ";

        $result = loadSqlResultArrayList($sql);

        if (count($result) >= 1)
            return true;
        else
            return false;
    }

    function saveMove() {
        $sql = "UPDATE `char` SET abs=" . $this->getAbs() . ",ord=" . $this->getOrd() . ",face=" . $this->getFace() . ",map=" . $this->getMap() . ", time_connexion = " . $_SERVER['REQUEST_TIME'] . " WHERE id=" . $this->getId();
        loadSqlExecute($sql);
    }

// Fonction static
    public static function getLevelbyId($id) {
        $sql = "SELECT level FROM `char` WHERE `id` = '" . $id . "' LIMIT 0, 1";
        $result = loadSqlResult($sql);
        return $result;
    }

    public static function getNameById($id) {
        $sql = "SELECT name FROM `char` WHERE `id` = '" . $id . "' LIMIT 0, 1";
        $result = loadSqlResult($sql);

        return $result;
    }

    public static function getIdByName($name) {
        $name2 = htmlentities($name, ENT_QUOTES, "UTF-8");
        $sql = "SELECT id FROM `char` WHERE `name` = '" . $name2 . "' LIMIT 0, 1";
        $result = loadSqlResult($sql);
        return $result;
    }

    public static function getAllCharName($restrict = array()) {
        $sql = "SELECT name FROM `char` ";
        if (count($restrict) >= 1)
            $sql .= "WHERE id NOT IN (" . implode(',', $restrict) . ")";
        return loadSqlResultArrayList($sql);
    }

    public static function getAllCharRank($faction = 0, $classe = 0) {
        $sql = "SELECT name,level,faction,classe,guild_id FROM `char` ";
        $count = 0;

        if ($faction != 0) {
            $sql .= "WHERE faction = $faction ";
            $count = 1;
        }

        if ($classe != 0) {
            if ($count == 1) {
                $sql .= "AND classe = $classe ";
            } else {
                $sql .= "WHERE classe = $classe ";
                $count = 1;
            }
        }

        if ($count == 1)
            $sql .= "AND (SELECT COUNT(*) FROM admin WHERE iduser = idaccount) = 0 && idaccount != 0";
        else
            $sql .= "WHERE (SELECT COUNT(*) FROM admin WHERE iduser = idaccount) = 0 && idaccount != 0 ";
        $sql .= " ORDER BY exp DESC LIMIT 30";

        return loadSqlResultArrayList($sql);
    }

    public static function getAllCharRankpvp($faction = 0, $classe = 0) {
        $sql = "SELECT name,level,faction,classe,guild_id,kills,honnor,honnor h2 FROM `char` ";

        $count = 0;
        if ($faction != 0) {
            $sql .= "WHERE faction = $faction ";
            $count = 1;
        }

        if ($classe != 0) {
            if ($count == 1) {
                $sql .= "AND classe = $classe ";
            } else {
                $sql .= "WHERE classe = $classe ";
            }
        }

        $sql .= " ORDER BY kills DESC,deaths ASC,honnor DESC LIMIT 30";
        return loadSqlResultArrayList($sql);
    }

    public static function exist($name) {
        $char = unserialize($_SESSION['char']);
        $id = $char->getId();
        if ($id >= 1)
            return true;
        else
            return false;
    }

    public static function getPlayersOnlineOnMap($char, $group_id = 0) {
        $time_max = $_SERVER['REQUEST_TIME'] - 300;

        $sql = "SELECT id,name,classe,level,abs,ord,face,life FROM `char`  		 
			WHERE map = " . $char->getMap() . " && time_connexion >= $time_max && id != '" . $char->getId() . "' AND in_fight != true";
        $result = loadSqlResultArrayList($sql);

        if ($group_id > 0 and count($result) > 0) {
            $final_result = array();

            foreach ($result as $r) {
                if ($r['group_id'] == $group_id)
                    $final_result[] = $r;
            }

            $result = $final_result;
        }
        return $result;
    }

    public static function loadShortcut($shortcut, $char_id) {

        $item_id = char::getShortcutItemID($shortcut, $char_id);
        $style = "margin-top:2px;";
        return item::showPicture($item_id, $style);
    }

    public static function getShortcutItemID($shortcut, $char_id) {
        $sql = "SELECT shortcut$shortcut FROM `shortcuts` WHERE char_id=$char_id LIMIT 0, 1";
        $result = loadSqlResult($sql);
        return $result;
    }

    static function getClasseNameById($id) {
        $sql = "SELECT name FROM `classe` WHERE id=" . $id;
        $result = loadSqlResult($sql);
        return $result;
    }

    static public function updateBase($type, $value, $char_id = 0) {
        $sql = "UPDATE `char` SET `" . $type . "` = '" . $value . "' WHERE `id` = '" . $char_id . "' LIMIT 1 ";
        loadSqlExecute($sql);
    }

    static public function updateMoreBase($type, $value, $char_id = 0) {
        $sql = "UPDATE `char` SET `" . $type . "` = `" . $type . "` + '" . $value . "' WHERE `id` = '" . $char_id . "' LIMIT 1 ";
        loadSqlExecute($sql);
    }

    public static function calculPourcentExp($exp, $level) {
        if ($level > 1) {
            $levelmoins = $level - 1;
            $sql = "SELECT nextlevel FROM `level` WHERE `level` = '" . $levelmoins . "' ";
            $result = loadSqlResultArray($sql);
            $exp = $exp - $result['nextlevel'];

            $sql = "SELECT ecart FROM `level` WHERE `level` = '" . $level . "' ";
            $result2 = loadSqlResultArray($sql);
            $aexp = $result2['ecart'];
        } else {
            $aexp = 300;
        }
        $pourcent = round(($exp / $aexp) * 100);
        return $pourcent;
    }
    
    public static function getCharList($user)
    {
        $sql = "SELECT * FROM `char` WHERE idaccount = '".$user->getId()."' ";
        return loadSqlResultArrayList($sql);
    }

}

?>
