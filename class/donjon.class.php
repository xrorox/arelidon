<?php

class donjon {

    private $id;
    private $name;
    private $rooms;
    private $abs_begin;
    private $ord_begin;

    function donjon($id) {
        $sql = "SELECT * FROM donjon WHERE id = '$id'";
        $result = loadSqlResultArray($sql);

        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }

        $sql = "SELECT * FROM donjon_room WHERE donjon_id = '$id'";
        $result_room = loadSqlResultArrayList($sql);

        foreach ($result_room as $res) {
            $this->rooms[] = $res['id'];
        }
    }

    function getId() {
        return $this->id;
    }

    function getRooms() {
        return $this->rooms;
    }

    function getRoomBegin() {
        return $this->rooms[0];
    }

    function getMapBegin() {
        $sql = "SELECT * FROM `mapworld` WHERE room_id = '" . $this->getRoomBegin() . "' ";
        $result = loadSqlResultArray($sql);

        return $result['id'];
    }

    function getAbsBegin() {
        return $this->abs_begin;
    }

    function getOrdBegin() {
        return $this->ord_begin;
    }

    function createDonjon($group_id) {
        // Pour toutes les salles, on cr�e les monstres,coffres, etc ...
        foreach ($this->rooms as $room_id) {
            $room = new room($room_id);
            $room->create($group_id);
        }
    }

    function isFinish($group_id) {
        $valid = true;

        foreach ($this->rooms as $room_id) {
            $room = new room($room_id);
            // Si il reste un monstre
            if (!$room->allMonsterDie($group_id))
                $valid = false;
        }

        return $valid;
    }

    function clean($group_id) {
        $sql = "DELETE FROM monsteronmap WHERE donjon_group_id = $group_id";
        loadSqlExecute($sql);

        $sql = "DELETE FROM donjon_group WHERE donjon_id = '" . $this->id . "' AND group_id = $group_id";
        loadSqlExecute($sql);
    }

}

?>