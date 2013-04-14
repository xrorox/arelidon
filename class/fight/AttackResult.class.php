<?php

class AttackResult {

    private $attack_id;
    private $target_name;
    private $damage;
    private $element;

    /*
     *  0 = normal
     *  1 = cc
     *  2 = esquive
     *  3 = bloqu�
     */
    private $special;

    /*
     *  0 = pas d'effet
     *  > 0 on a inflig� un effet
     */
    private $effect_id;

    public function AttackResult() {
//		if(func_num_args() > 0)
//			loadAttack(func_get_arg(0));
    }

//	public function loadAttack($id)
//	{
//		$sql = "SELECT  * FROM `attackresults` WHERE id = ".$id." ";		
//		$result = loadSqlResultArray($sql);
//
//		if(count($result) > 0)
//		{
//			foreach($result as $key=>$value)
//	    	{
//	    		$this->$key=$value;
//	    	}
//		}
//	}

    public function saveAttackResult($attack_id, $target_name, $damage, $element, $special = 0, $effect_id = 0) {
        $sql = "INSERT INTO `attackresults` 
				(attack_id,target_name,damage,element,special,effect_id) 
				VALUES 
				('$attack_id','$target_name','$damage','$element','$special','$effect_id');";
        loadSqlExecute($sql);
    }

    public function castArrayInObject($array) {
        // On transforme un tableau avec les infos de attackResult en un objet AttackResult
        $this->attack_id = $array['attack_id'];
        $this->target_name = $array['target_name'];
        $this->damage = $array['damage'];
        $this->element = $array['element'];
        $this->special = $array['special'];
        $this->effect_id = $array['effect_id'];
    }

    public function toString() {
        $string = "<b><i>" . $this->target_name . "</i></b>";

        if ($this->damage > 0) {
            $string .= " subit " . $this->getDamageString() . " dommages ";
        } else if ($this->damage == 0)
            $string .= " ne subit rien ";
        else
            $string .= " est soign� de " . $this->getDamageString() . " dommages ";

        switch ($this->special) {
            case 1:
                $string .= "(coup critique)";
                break;
            case 2:
                $string .= "(esquive)";
                break;
            case 3:
                $string .= "(bloqu�e)";
                break;
        }

        /* TODO */
        // Si on doit ajouter un effet
        if ($this->effect_id > 0) {
            
        }

        return $string;
    }

    public function getDamageString() {
        if ($this->damage > 0) {
            $str = '<span style="color:' . $this->getElementColor() . '">' . ($this->damage) . '</span>';
        } else {
            $str = '<span style="color:pink;">' . ((-1) * $this->damage) . '</span>';
        }

        return $str;
    }

    public function getElementColor() {
        switch ($this->element) {
            case 0:
                $str = "white";
                break;
            case 1:
                $str = "red";
                break;
            case 2:
                $str = "blue";
                break;
            case 3:
                $str = "#E0EFF9";
                break;
            case 4:
                $str = "marron";
                break;
            case 5:
                $str = "#FFFF98";
                break;
            case 6:
                $str = "green";
                break;
        }

        return $str;
    }

}