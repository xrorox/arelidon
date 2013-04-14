<?php

class quete {

    private $id;
    private $name;
    private $classe_1;
    private $classe_2;
    private $classe_3;
    private $classe_4;

// Utilisation de la classe pour les infos de l'utilsateur

    function __construct() {
        $num = func_num_args();
        switch ($num) {
            case 1 :
                $this->loadQuete(func_get_arg(0));
                break;
            case 2 :
                //  premier arg : idquete 
                // deuxième arg : objet -> char
                $this->loadQueteChar(func_get_arg(0), func_get_arg(1));
                break;
        }
    }

    function loadQuete($id) {
        $sql = "SELECT * FROM quetes WHERE id = '$id'";
        $result = loadSqlResultArray($sql);

        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function loadQueteChar($idquete, $char) {
        $sql = "SELECT * FROM quetes WHERE id = '$id'";
        $result = loadSqlResultArray($sql);

        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }

    function getNumberOfStep() {
        $sql = "SELECT COUNT(*) as number FROM quetes_etapes WHERE idquete = $this->id";
        $result = loadSqlResultArray($sql);

        return $result['number'];
    }

    function getCurrentStep($idchar) {
        $sql = "SELECT etape FROM quetes_char WHERE idquete = $this->id && idchar = $idchar ";
        $result = loadSqlResultArray($sql);

        return $result['etape'];
    }

    function duplicateQuest() {
        $idquete = $this->id;

// Premi�re �tape on duplique la qu�te
        $name = "duplicata_" . time();
        $sql = "INSERT INTO quetes SELECT '','$name',classe_1,classe_2,classe_3,classe_4 FROM quetes WHERE id = $idquete ;";
        loadSqlExecute($sql);

        $sql = "SELECT ID FROM quetes ORDER BY id DESC LIMIT 0,1";
        $new_id_quete = loadSqlResult($sql);

        $sql = "SELECT * FROM quetes_etapes WHERE idquete = $idquete ;";
        $result_array = loadSqlResultArrayList($sql);


        if ($new_id_quete > 0) {
            foreach ($result_array as $result) {
                $old_id = $result['id'];

                $result['id'] = '';
                $result['idquete'] = $new_id_quete;
                $sql = "INSERT INTO quetes_etapes (";

                foreach ($result as $row => $value)
                    $sql .= $row . ',';

// On enl�ve la derni�re virgule		
                $sql = substr($sql, 0, -1);

                $sql .= ") VALUES (";
                foreach ($result as $row => $value) {
                    $value = html_entity_decode($value, ENT_QUOTES);
                    $value = htmlentities($value, ENT_QUOTES);
                    $value = "'" . $value . "'";
                    $sql .= $value . ',';
                }
                $sql = substr($sql, 0, -1);
                $sql .= ");";

                loadSqlExecute($sql);
                echo ' <br />-> Etape ajout&eacute;e';


                $sql = "SELECT ID FROM quetes_etapes ORDER BY id DESC LIMIT 0,1";
                $new_id_step = loadSqlResult($sql);

                $this->duplicateQuestObjectives($old_id, $new_id_step);
            }

            echo '<br /><br > La duplication de la qu&ecirc;te a bien &eacute;t&eacute; effectu&eacute;e';
        } else {
            echo 'Une erreur s\'est produite lors de la duplication';
        }
    }

    function duplicateQuestObjectives($step_id, $new_step_id) {
        $sql = "SELECT * FROM  `quetes_etapes_objectives` WHERE step_id = " . $step_id . " ";
        $result_array = loadSqlResultArrayList($sql);

        foreach ($result_array as $array) {
            $sql = "INSERT INTO `quetes_etapes_objectives` (id,step_id,id_need,nb_need) VALUES ";
            $sql .= "('','" . $new_step_id . "','" . $array['id_need'] . "','" . $array['nb_need'] . "')";
            loadSqlExecute($sql);
        }
    }

    /**
     * 
     * Fonctions publiques
     * 
     */
    public static function addQuete($name, $classe_1 = 0, $classe_2 = 0, $classe_3 = 0, $classe_4 = 0, $modif = false, $idquete) {
        if ($classe_1 == '')
            $classe_1 = 0;
        if ($classe_2 == '')
            $classe_2 = 0;
        if ($classe_3 == '')
            $classe_3 = 0;
        if ($classe_4 == '')
            $classe_4 = 0;


        if ($modif) {
            $sql = "UPDATE quetes SET name = $name,classe_1 = $classe_1,classe_2 = $classe_2,classe_3 = $classe_3,classe_4 = $classe_4 WHERE id = $idquete";
        } else {
            if ($name != '') {
                $sql = "INSERT INTO quetes (name,classe_1,classe_2,classe_3,classe_4) VALUES ($name,$classe_1,$classe_2,$classe_3,$classe_4)";
            }
        }
        loadSqlExecute($sql);
    }

    public static function getIdByName($name) {
        $name = htmlentities($name, ENT_QUOTES);
        $sql = "SELECT id FROM quetes WHERE name = '$name'";
        return loadSqlResult($sql);
    }

    public static function getAllQuest($min, $max, $order, $asc) {
        $sql = "SELECT qe.*,q.*,(SELECT COUNT(*) FROM quetes_etapes WHERE idquete = q.id) as nb_etapes,(SELECT SUM(exp_win) FROM quetes_etapes WHERE idquete = q.id) as sum_exp,(SELECT SUM(gold_win) FROM quetes_etapes WHERE idquete = q.id) as sum_gold FROM quetes q JOIN quetes_etapes qe ON qe.idquete = q.id AND qe.etape = 1 GROUP BY q.id ";

        switch ($order) {
            case 'name':
                $sql .= " ORDER BY q.name $asc ";
                break;
            case 'lvl_req':
                $sql .= " ORDER BY qe.lvl_req $asc ";
                break;
            case 'nb_etape':
                $sql .= " ORDER BY nb_etape $asc ";
                break;
            case 'name':
                $sql .= " ORDER BY qe.name $asc ";
                break;
            case 'pnj':
                $sql .= " ORDER BY qe.pnj $asc ";
                break;
            case 'sum_exp':
                $sql .= " ORDER BY sum_exp $asc ";
                break;
            case 'sum_gold':
                $sql .= " ORDER BY sum_gold $asc ";
                break;
            default:
                $sql .= " ORDER BY qe.lvl_req ASC ";
                break;
        }

        $sql .= "LIMIT " . $min . "," . $max;
        $return = loadSqlResultArrayList($sql);

        return $return;
    }

    public static function deleteQuest($quest_id = 0) {
        $sql = "SELECT * FROM quetes_etapes WHERE idquete = $quest_id ;";
        $step_array = loadSqlResultArrayList($sql);

        foreach ($step_array as $step) {


            $sql = "SELECT * FROM  `quetes_etapes_objectives` WHERE step_id = " . $step['id'] . " ";
            $objectives_array = loadSqlResultArrayList($sql);

            foreach ($objectives_array as $objectif) {
                $sql = "DELETE FROM quetes_etapes_objectives WHERE id = " . $objectif['id'];
                loadSqlExecute($sql);
            }

            $sql = "DELETE FROM quetes_etapes WHERE id = " . $step['id'];
            loadSqlExecute($sql);
        }

        $sql = "DELETE FROM quetes WHERE id = $quest_id ";
        loadSqlExecute($sql);

        echo 'La qu&ecirc;te a bien &eacute;t&eacute; supprim&eacute;e';
    }

}

?>