<?php

class room {

    private $id;
    private $donjon_id;

    /*
     * Condition :
     * 
     * 1 => tuer tous les monstres
     */
    private $condition;
    private $map;

    function room($id) {

        $sql = "SELECT * FROM donjon_room WHERE id = '$id'";
        $result = loadSqlResultArray($sql);

        foreach ($result as $key => $value) {
            $this->$key = $value;
        }

        $sql = "SELECT id FROM mapworld WHERE room_id = '" . $this->id . "' ";
        $this->map = loadSqlResult($sql);
    }

    function getMap() {
        return $this->map;
    }

    function getCondition() {
        return $this->condition;
    }

    function create($group_id) {
        $sql = "SELECT * FROM monster_donjon WHERE room_id = '" . $this->id . "'";
        $result = loadSqlResultArrayList($sql);

        foreach ($result as $r) {
            $monster = new monster($r['idmstr'], 'loadInfoType');
            $monster->addMonsterOnMap($r['abs'], $r['ord'], $this->getMap(), $group_id);
        }
    }

    function allMonsterDie($group_id) {
        $monsters = monster::getAllMonstersOnMap($this->map, 0, $group_id);

        $valid = true;

        foreach ($monsters as $monster) {
            if ($monster['life'] > 0)
                $valid = false;
        }

        return $valid;
    }

    function deleteAll($group_id) {
        $sql = "DELETE FROM monsteronmap mom " .
                "JOIN monster m ON mom.mstr_id = m.id  " .
                "WHERE m.room_id = '" . $this->id . "' AND mom.donjon_group_id = '$group_id'";
        loadSqlExecute($sql);
    }

    public static function allMonsterDieStatic($map, $group_id) {
        $monsters = monster::getAllMonstersOnMap($map, 0, $group_id);

        $valid = true;
        if (count($monsters) > 0) {
            foreach ($monsters as $monster) {
                if ($monster['life'] > 0)
                    $valid = false;
            }
        }
        return $valid;
    }

}

?>