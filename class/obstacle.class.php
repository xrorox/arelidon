<?php

class obstacle {

    private $id;
    private $step_id;
    private $time;

    /**
     * 1 => apr�s lancement
     * 2 => apr�s accomplissement et avant validation
     * 3 => apr�s validation
     */
    private $type;

    /**
     * 1 => afficher
     * 2 => d�placer
     * 3 => supprimer
     */
    private $obstacle_id;

    /**
     *  id de l'obstacle
     */
    // infos
    private $name;
    private $img;
    private $taille;
    private $char_id;
    // Cordonn�es en cas de d�placement
    private $map;
    private $abs;
    private $ord;
    private $hide;
    private $bloc;

    function obstacle($id, $type = 'information') {
        if ($id > 0) {
            switch ($type) {
                case 'information':
                    $this->loadObstacle($id); // table obstacle
                    break;
                case 'on_step':
                    $this->loadObstacleOnStep($id);
                    break;
                case 'on_char':
                    $this->loadObstacleOnChar($id); // table event_char
                    break;
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getHide() {
        return $this->hide;
    }

    function getBloc() {
        return $this->bloc;
    }

    function loadObstacle($id) {
        $sql = "SELECT * FROM obstacle WHERE id = $id";
        $result = loadSqlResultArray($sql);

        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }

    function addObstacleOnStep($step_id, $time, $type, $name, $map = 0, $abs = 0, $ord = 0) {
        $obstacle_id = obstacle::getIdByName($name);
        if ($type = 0)
            $type = 1;

        if ($obstacle_id > 0) {
            $sql = "INSERT INTO quetes_etapes_actions " .
                    "(step_id,time,type,obstacle_id,map,abs,ord) " .
                    "VALUES " .
                    " (" . $step_id . "," . $time . "," . $type . "," . $obstacle_id . ",0,0,0);";
            loadSqlExecute($sql);
        }
    }

    function addObstacleOnChar($char_id, $type, $map, $abs, $ord) {
        // On supprimer l'�tat pr�c�dent de l'obstacle si besoin
        $sql = "DELETE FROM `event_char` WHERE obstacle_id = '" . $this->getId() . "' && char_id = " . $char_id;
        loadSqlExecute($sql);

        $sql = "INSERT INTO `event_char` " .
                "(obstacle_id,char_id,type,map,abs,ord) " .
                "VALUES " .
                "('" . $this->getId() . "'," . $char_id . "," . $type . "," . $map . "," . $abs . "," . $ord . ")";
        loadSqlExecute($sql);
    }

// Fonctions publiques
    public static function addObstacle($_POST, $image, $hide, $bloc) {
        $sql = "INSERT INTO `obstacle` " .
                "(name,img,taille,map,abs,ord,hide,bloc) " .
                "VALUES " .
                "('" . $_POST['name'] . "','" . $image . "'," . $_POST['taille'] . "," . $_POST['map'] . "," . $_POST['abs'] . "," . $_POST['ord'] . "," . $hide . "," . $bloc . ")";
        loadSqlExecute($sql);
    }

    public static function getIdByName($name) {
        $name = htmlentities($name, ENT_QUOTES);
        $sql = "SELECT id FROM `obstacle` WHERE name = '$name'";
        return loadSqlResult($sql);
    }

    public static function getAllObstaclesOnMap($map_id, $char) {
        $sql = "SELECT ob.* " .
                "FROM `obstacle` ob " .
                "WHERE " .
                " hide = 0 AND map = $map_id ";
        $all = loadSqlResultArrayList($sql);

        $sql = "SELECT ob.* " .
                "FROM `obstacle` ob JOIN `event_char` ec ON ob.id = ec.obstacle_id " .
                "WHERE " .
                " ec.type = 1 AND ob.map = $map_id AND char_id = " . $char->getId();
        $add = loadSqlResultArrayList($sql);

        $sql = "SELECT ob.* " .
                "FROM `obstacle` ob JOIN `event_char` ec ON ob.id = ec.obstacle_id " .
                "WHERE " .
                " (ec.type = 3 AND ob.map = $map_id AND char_id = " . $char->getId() . ") OR " .
                " (ec.type = 2 AND ec.map != $map_id AND char_id = " . $char->getId() . ")"; // si on a bouger sur une autre carte l'obstacle'
        $remove = loadSqlResultArrayList($sql);

        $array_restrict = array();
        foreach ($remove as $ra)
            $array_restrict[] = $ra['id'];

        $array_obstacle_result = array();

        foreach ($all as $a) {
            if (!(in_array($a['id'], $array_restrict)))
                $array_obstacle_result[$a['id']] = $a;
        }

        foreach ($add as $a) {
            if (!(in_array($a['id'], $array_restrict)))
                $array_obstacle_result[$a['id']] = $a;
        }

        return $array_obstacle_result;
    }

}

?>