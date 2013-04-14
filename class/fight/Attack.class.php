<?php

require_once("AttackResult.class.php");

class Attack {

    private $id;
    private $fight_id;
    private $skill_id;
    private $launcher;
    private $turn_number;
    private $timestamp;

    public function Attack() {
        if (func_num_args() > 0)
            loadAttack(func_get_arg(0));
    }

    public function loadAttack($id) {
        $sql = "SELECT  * FROM `attacks` WHERE id = " . $id . " ";
        $result = loadSqlResultArray($sql);

        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function createAttack($fight_id, $fighter_launcher, $skill, $fighter_target, $turn_id) {

        $this->id = $this->saveAttack($fight_id, $skill->getName(), $fighter_launcher->getName(), $turn_id);

        $damage = $skill->getDamage($fighter_launcher, $fighter_target);
        $fighter_target->updateLife($damage);
        $fighter_target->getLife();
        $fighter_launcher->usePa($skill->getPA());


        if ($skill->getEffectId() > 0)
            $fighter_target->addEffect($skill->getEffectId(), $skill->getNumberEffects());

        $attackResult = new AttackResult();
        $attackResult->saveAttackResult($this->id, $fighter_target->getName(), $damage, $skill->getElement());

        /* TODO */
        // Tester si c'est un sort AoE
    }

    public function saveAttack($fight_id, $skill_name, $launcher, $turn_number) {
        $time = time();

        $sql = "INSERT INTO `attacks` 
				(fight_id,skill_name,launcher,turn_number,timestamp) 
				VALUES 
				($fight_id,'$skill_name','$launcher',$turn_number,$time);";
        loadSqlExecute($sql);

        $sql = "SELECT id FROM `attacks` WHERE fight_id = $fight_id && skill_name = '$skill_name' && launcher = '$launcher' && turn_number = $turn_number && timestamp = $time ";
        $result = loadSqlResultArray($sql);

        return $result['id'];
    }

    public function getAttackResults() {
        $sql = "SELECT * FROM `attackresults` WHERE attack_id = '" . $this->id . "'";
        $arrayList = loadSqlResultArrayList($sql);

        $resultList = array();
        if (count($arrayList) >= 1) {
            foreach ($arrayList as $attackResultArray) {
                $attackResult = new AttackResult();
                $attackResult->castArrayInObject($attackResultArray);
                $resultList[] = $attackResult;
            }
        }

        return $resultList;
    }

    public function castArrayInObject($array) {
        // On transforme un tableau avec les infos de attackResult en un objet AttackResult
        $this->fight_id = $array['fight_id'];
        $this->id = $array['id'];
        $this->launcher = $array['launcher'];
        $this->skill_name = $array['skill_name'];
        $this->timestamp = $array['timestamp'];
        $this->turn_number = $array['turn_number'];
    }

    public function toString() {
        return "<b><i>" . $this->launcher . "</i></b> lance <b><i>" . $this->skill_name . "</i></b>";
    }

}