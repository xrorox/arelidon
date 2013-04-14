<?php

if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}

require_once($server . 'class/fight/CharInFight.class.php');
require_once($server . 'class/fight/MonsterInFight.class.php');
require_once($server . 'class/monster.class.php');

class Fighter {

    private $fighter_id;
    private $fight_id;
    private $fight_instance = null;
    // 1 = char, 0 = monstre
    private $is_char = 1;
    // 1 si le joueur a cliqué sur prêt
    private $is_ready = 0;
    // 1 si besoin de raffraichir
    private $needRefresh = 0;
    // Team 1 ou 2
    private $team = 1;
    // Pa restant pour le tour
    private $pa = 6;
    private $exp_win = 0;
    private $gold_win = 0;
    // Place in the fight
    private $place;
    // Position in the turn (who play after who)
    private $turn_place;
    // Instance of char or monster associated to the fighter_id
    private $instance;

    public function Fighter() {
        if (func_num_args() == 3)
            $this->loadFighter(func_get_arg(0), func_get_arg(1), func_get_arg(2));
        elseif (func_num_args() == 2) {
            pre_dump("We have to know if it's a char or a monster");
        } elseif (func_num_args() == 1)
            $this->loadFighterByArray(func_get_arg(0));
    }

    // Return the where condition to select the fighter
    public function getWhereString() {
        return "fighter_id = " . $this->fighter_id . " AND fight_id = " . $this->fight_id . " && is_char = " . $this->is_char;
    }

    public function loadFighter($fighter_id, $fight_id, $is_char) {
        $this->fighter_id = $fighter_id;
        $this->fight_id = $fight_id;
        $this->is_char = $is_char;

        $sql = "SELECT  * FROM `fighters` 
				WHERE " . $this->getWhereString();
        $result = loadSqlResultArray($sql);

        $this->loadFighterByArray($result);


        $this->loadInstance();
    }

    public function loadFighterAtPlace($turn_place, $fight_id) {
        $this->turn_place = $turn_place;
        $this->fight_id = $fight_id;

        $sql = "SELECT  * FROM `fighters` 
				WHERE turn_place = " . $this->turn_place . " AND fight_id = " . $this->fight_id;
        $result = loadSqlResultArray($sql);

        $this->loadFighterByArray($result);
    }

    private function loadFighterByArray($array) {
        if (count($array) > 1) {
            foreach ($array as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function loadFightInstance() {
        if ($this->fight_id > 0)
            $this->fight_instance = new Fight($this->fight_id);
    }

    public function createFighterToSave($fighter_id, $fight_id, $isChar, $team) {
        $this->fighter_id = $fighter_id;
        $this->fight_id = $fight_id;
        $this->is_char = $isChar;
        $this->team = $team;

        if ($isChar == 0)
            $this->is_ready = 1;
    }

    public function save() {
        $sql = "INSERT INTO `fighters`
				(fighter_id,fight_id,is_char,team,pa,is_ready,place) 
				VALUES 
				(" . $this->fighter_id . "," . $this->fight_id . "," . $this->is_char . "," . $this->team . ",6," . $this->is_ready . "," . $this->place . ");";
        loadSqlExecute($sql);
    }

    public function usePa($pa) {
        $newPa = $this->pa - $pa;
        if ($newPa < 0)
            $newPa = 0;

        $this->updatePa($newPa);
    }

    public function updatePa($pa) {
        $this->pa = $pa;
        $sql = "UPDATE `fighters` SET pa = " . $this->pa . " 
		WHERE " . $this->getWhereString();

        loadSqlExecute($sql);
    }

    public function wasRefresh() {
        if ($this->needRefresh != 0) {
            $this->needRefresh = 0;
            $sql = "UPDATE `fighters` SET needRefresh = " . $this->needRefresh . " 
			WHERE " . $this->getWhereString();
            loadSqlExecute($sql);
        }
    }

    public function setReady() {
        if ($this->is_ready != 1) {
            $this->is_ready = 1;
            $sql = "UPDATE `fighters` SET is_ready = " . $this->is_ready . " 
			WHERE " . $this->getWhereString();
            loadSqlExecute($sql);
        }
    }

    function getReady() {
        return $this->is_ready;
    }

    public function loadInstance() {
        if ($this->is_char == 0) {
            $this->instance = new MonsterInFight(new Monster($this->fighter_id));
        } else {
            $this->instance = new charInFight(new char($this->fighter_id));
        }
    }

    public function updateTurnPlace($turnPlace) {
        $sql = "UPDATE `fighters` SET turn_place = " . $turnPlace . " 
				WHERE " . $this->getWhereString();
    }

    public function isHisTurn() {
        if ($this->fight_instance == null)
            $this->loadFightInstance();

        if ($this->fight_instance == null) {
            pre_dump("alert null dans isHisTurn");
            return false;
        }

//		pre_dump($this->turn_place."/".$this->fight_instance->getTurn());

        if ($this->turn_place == $this->fight_instance->getTurn()) {
            return true;
        } else {
            return false;
        }
    }

    public function useSkillOnFighter($skill, $fighter) {
        
    }

    public function updateExpWin($expWin) {
        $this->exp_win = $expWin;
        $sql = "UPDATE `fighters` SET exp_win = " . $this->exp_win . " 
		WHERE " . $this->getWhereString();

        loadSqlExecute($sql);
    }

    public function updateGoldWin($goldWin) {
        $this->gold_win = $goldWin;
        $sql = "UPDATE `fighters` SET gold_win = " . $this->gold_win . " 
		WHERE " . $this->getWhereString();

        loadSqlExecute($sql);
    }

    public function getDropList() {
        $sql = "SELECT * FROM `fighters_item_win` 
				WHERE `fight_id` = '" . $this->fight_id . "' AND `fighter_id` = '" . $this->fighter_id . "'";

        return loadSqlResultArrayList($sql);
    }

    // -------------------------- Getters / Setters -----------------------------------------------
    public function getFighterId() {
        return $this->fighter_id;
    }

    public function isReady() {
        if ($this->is_ready == 1)
            return true;
        else
            return false;
    }

    public function isChar() {
        if ($this->is_char == 1)
            return true;
        else
            return false;
    }

    public function getPA() {
        return $this->pa;
    }

    public function needRefresh() {
        if ($this->needRefresh == 1)
            return true;
        else
            return false;
    }

    public function getTeam() {
        return $this->team;
    }

    public function getPlace() {
        return $this->place;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

    public function getTurnPlace() {
        return $this->turn_place;
    }

    public function getInstance() {
        if ($this->instance == null)
            $this->loadInstance();
        return $this->instance;
    }

    public function getFightInstance() {
        return $this->fight_instance;
    }

    public function setFightInstance($fightInstance) {
        $this->fight_instance = $fightInstance;
    }

    public function getExpWin() {
        return $this->exp_win;
    }

    public function getGoldWin() {
        return $this->gold_win;
    }

    public function getMana() {
        return $this->instance->getMana();
    }

    public function getResistancePercentage($typedmg) {
        return $this->instance->getResistancePercentage($typedmg);
    }

    public function getCaract($caract) {
        return $this->instance->getCaract($caract);
    }

    public function getLife() {
        return $this->instance->getLife();
    }

    public function getSkillAvailableList() {
        return $this->instance->getSkillAvailableList();
    }

    public function updateLife($life) {
        return $this->instance->updateLife($life);
    }

    function getName() {
        return $this->instance->getName();
    }

    function addEffect($id_effect, $number, $attacker_id) {
        $this->instance->addEffect($id_effect, $number, $attacker_id);
    }

    function getLevel() {
        return $this->instance->getLevel();
    }

}