<?php

class interaction {

    private $id;
    private $name;
    private $name_for_quest;
    private $map;
    private $abs;
    private $ord;

    /*
     *  Type : 
     * 
     *  0 : => vide 
     *  1 : => gain
     *  2 : => pi�ge
     */
    private $type;
    private $gold;
    private $nb_item;
    private $item;
    private $dmg;
    private $commentaire;

    function interaction($id = 0) {
        if ($id != 0)
            $this->loadInteraction($id);
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getNameForQuest() {
        return $this->name_for_quest;
    }

    function getMap() {
        return $this->map;
    }

    function getAbs() {
        return $this->abs;
    }

    function getOrd() {
        return $this->ord;
    }

    function getType() {
        return $this->type;
    }

    function getGold() {
        return $this->gold;
    }

    function getNbItem() {
        return $this->nb_item;
    }

    function getItem() {
        return $this->item;
    }

    function getDmg() {
        return $this->dmg;
    }

    function getCommentaire() {
        return $this->commentaire;
    }

    function loadInteraction($id) {
        $sql = "SELECT * FROM `interaction` WHERE id = $id";
        $result = loadSqlResultArray($sql);

        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    function add($array) {
        $array_row = array();
        $array_value = array();

        $sql = "SELECT count(*) FROM interaction WHERE `abs` = '" . $array['abs'] . "' && `ord` = '" . $array['ord'] . "' && `map` = '" . $array['map'] . "' ";
        $exist = loadSqlResult($sql);

        // si une interaction est d�j� pr�sente � cette case la
        if ($exist >= 1) {
            
        } else {

            $sql = "INSERT INTO `interaction` ";
            foreach ($array as $row => $value) {
                $array_row[] = $row;
                switch ($row) {
                    case 'name':
                        $array_value[] = "'" . htmlentities($value, ENT_QUOTES, 'UTF-8') . "'";
                        break;
                    case 'name_for_quest':
                        $array_value[] = "'" . htmlentities($value, ENT_QUOTES, 'UTF-8') . "'";
                        break;
                    case 'commentaire':
                        $array_value[] = "'" . htmlentities($value, ENT_QUOTES, 'UTF-8') . "'";
                        break;
                    case 'item':
                        if ($value != 'item')
                            $array_value[] = "'" . item::getIdByName($value) . "'";
                        else
                            $array_value[] = 0;
                        break;
                    default:
                        $array_value[] = "'" . $value . "'";
                        break;
                }
            }
            $sql .= '(' . implode(',', $array_row) . ') VALUES (' . implode(',', $array_value) . ')';
            loadSqlExecute($sql);
        }
    }

    function delete() {
        $sql = "DELETE FROM `interaction` WHERE id = $this->id";
        loadSqlExecute($sql);
    }

    function markAsDone($char_id) {
        $sql = "INSERT INTO `interaction_on_char` (action_id,char_id) VALUES ($this->id,$char_id)";
        loadSqlExecute($sql);
    }

    function stillDo($char_id) {
        $sql = "SELECT COUNT(*) FROM `interaction_on_char` WHERE action_id = " . $this->id . " AND char_id = $char_id";
        $count = loadSqlResult($sql);

        if ($count >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllActionsOnMap($map_id, $char_id = 0, $type = 0) {
        $sql = "SELECT SQL_SMALL_RESULT SQL_CACHE * FROM `interaction` i WHERE map = '$map_id' ";

        // Si un char_id est indiqu� on enl�ve toutes les actions d�j� faite par le joueur
        if ($char_id != 0) {
            $sql .= "AND (SELECT COUNT(*) FROM `interaction_on_char` ioc WHERE i.id = ioc.action_id AND ioc.char_id = $char_id) = 0 ";
        }

        return loadSqlResultArrayList($sql, $type);
    }

}

?>