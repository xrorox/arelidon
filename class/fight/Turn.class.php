<?php

class Turn {

    private $fight_id;
    private $fighter_id;
    private $place;

    public function Turn() {
        if (func_num_args() > 0)
            loadTurn(func_get_arg(0));
    }

    public function loadTurn() {
        $sql = "SELECT  * FROM `turn` WHERE id = " . $id . " ";
        $result = loadSqlResultArray($sql);

        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
    }

}