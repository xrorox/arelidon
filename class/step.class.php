<?php

define("NOT_STARTED", 0);
define("STARTED", 1);
define("NEED_VALIDATION", 2);
define("STEP_COMPLETE", 3);

class step {

    private $id;
// infos générales
    private $etape;
    private $idquete;
    private $name;
// Conditions
    private $lvl_req;
    private $quest_req;
    private $objet_req;
// Pnj
    private $pnj;
    private $text_pnj;
    private $pnj_valid;
    private $text_pnj_after;
// Réalisation de la qu�te	
    /**
     * Type : 
     *  1 : tuer un ou plusieurs monstres
     *  2 : parler à un PNJ
     *  3 : ramener un ou plusieurs objets
     *  4 : allez sur une certaines carte
     */
    private $type;
    // $need = array(id_need,nb_need) <= correspond aux objectifs
    private $need;
    private $nb_need;
    private $id_need;
    private $text_pnj_quest;
// Gains
    private $gold_win;
    private $exp_win;
    private $nbobjet_win;
    private $objet_win;
    private $skill_win;
    private $action_win;
    var $quete;

    function __construct() {
        $num = func_num_args();
        switch ($num) {
            case 1 :
                $this->loadStep(func_get_arg(0));
                break;
        }
    }

    function getId() {
        return $this->id;
    }

    function getTextPnj() {
        $str = cleanAccent($this->text_pnj);
        $str = html_entity_decode($str);
        return $str;
    }

    function getPnj() {
        return $this->pnj;
    }

    function getIdQuete() {
        return $this->idquete;
    }

    function getPnjValid() {
        return $this->pnj_valid;
    }

    function getTextPnjAfter() {
        $str = cleanAccent($this->text_pnj_after);
        $str = html_entity_decode($str);
        return $str;
    }

    function getTextPnjQuest() {
        $str = cleanAccent($this->text_pnj_quest);
        $str = html_entity_decode($str);
        return $str;
    }

// $quete est un objet
    function setQuete($quete) {
        $this->quete = $quete;
    }

    function getQuete() {
        return $this->quete;
    }

    function getNeed() {
        $sql = "SELECT id_need,nb_need FROM quetes_etapes_objectives WHERE step_id = $this->id";
        return loadSqlResultArrayList($sql);
    }

    function loadStep($idstep) {
        $sql = "SELECT * FROM quetes_etapes WHERE id = '$idstep'";
        $result = loadSqlResultArray($sql);

        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }

    function update($type, $value) {
        $this->$type = $value;
        $sql = "UPDATE quetes_etapes SET $type = '$value' WHERE id = $this->id";
        loadSqlExecute($sql);
    }

    function updateOnChar($type, $value, $idchar) {
        $this->$type = $value;
        $sql = "UPDATE quetes_char SET $type = '$value' WHERE idchar = $idchar && idquete = $this->idquete && etape = $this->etape";
        loadSqlExecute($sql);
    }

    /** permet de voir si l'utilisateur a d�j� accept� la qu�te / ou si il est d�j� � une autre �tape * */
    function stepStillAccepte($idchar) {
        $sql = "SELECT COUNT(*) as begin FROM quetes_char WHERE idchar = $idchar && idquete = $this->idquete && etape = $this->etape";
        $result = loadSqlResultArray($sql);

        if ($result['begin'] == 0) {
            return false;
        } else {
            return true;
        }
    }

// permet de lancer la qu�te ou de passer � l'�tape suivant
    function accepteQuete($idchar) {
        $sql = "SELECT COUNT(*) as begin FROM quetes_char WHERE idchar = $idchar && idquete = $this->idquete";
        $result = loadSqlResultArray($sql);

        // Si la qu�te n'est pas dans la base , on l'ins�re � l'�tape 1
        if ($result['begin'] == 0) {
            $sql = "INSERT INTO quetes_char (idchar,idquete,etape) VALUES ($idchar,$this->idquete,'1');";
            loadSqlExecute($sql);
        } else {
            $sql = "UPDATE quetes_char SET etape = $this->etape,end = 0,get = 0,valid = 0 WHERE idchar = $idchar && idquete = $this->idquete";
            loadSqlExecute($sql);
        }

        // Actions sur les obstacles time = 1 (CAD apr�s avoir accept�)
        $this->getActionStep(new char($idchar), 1);
    }

    function validQuete($idchar) {
        $sql = "UPDATE quetes_char SET valid = 1 WHERE idchar = $idchar && idquete = $this->idquete && etape = $this->etape";
        loadSqlExecute($sql);
    }

    function validStep($char, $return = false) {

        // On valide ici la quête		
        $str = $this->getTextPnjAfter();

        $this->deleteObjectsNeeded($char);


        $this->giveRewards($char)

        ; // Actions sur les obstacles time = 3 (CAD apr�s validation)
        $this->getActionStep($char, 3);

        // On met a jour la base
        $this->validQuete($char->getId());

        // Affichage du texte

        $gain_text = $this->getGainText($char);
        $str .= '<div class="clean"></div>';
        $str .= '<div id="valid_go_quest" style="text-align:left;margin-top:15px;margin-left:5px;">';
        $str .= 'Vos gains : <br />';
        $str .= '<div style="margin-left:20px;margin-top:10px;">';
        $str .= $gain_text;
        $str .= '<br />';
        // Mont�e de niveau si besoin est


        $str .= '</div>';
        $str .= '</div>';

        if ($return)
            return $str;
        else
            echo $str;
    }

    function getActionStep($char, $time = 3) {
        $sql = "SELECT * FROM quetes_etapes_actions WHERE step_id = '" . $this->getId() . "' && time = '$time' ";
        $array_action = loadSqlResultArray($sql);

        if ($array_action['obstacle_id'] > 0) {
            // On enregistre le changement dans event_char
            $obstacle = new obstacle($array_action['obstacle_id']);
            $obstacle->addObstacleOnChar($char->getId(), $array_action['type'], $array_action['map'], $array_action['abs'], $array_action['ord']);
        }
    }

//Renvoie 0 pour Etape non commencée.
//Renvoie 1 pour Etape commencée.
//Renvoie 2 pour Etape finie mais non validée.
//Renvoie 3 pour Etape finie et validée.

    function getStepState($char) {
        $this->checkObjectives($char);

        $sql = "SELECT end,valid FROM quetes_char WHERE idchar = " . $char->getId() . " && idquete = $this->idquete && etape = $this->etape";
        $result = loadSqlResultArray($sql);

        if ($result == '')
            return NOT_STARTED;

        $started = true;

        $end = false;
        if ($result['end'] == 1)
            $end = true;

        $valid = false;
        if ($result['valid'] == 1)
            $valid = true;

        if ($started && !$end && !$valid)
            return STARTED;
        if ($started && $end && !$valid)
            return NEED_VALIDATION;
        if ($started && $end && $valid)
            return STEP_COMPLETE;
    }

    function checkObjectives($char) {
        $sql = "SELECT count(*) FROM `quetes_char` WHERE idchar=" . $char->getId() . " AND valid = 1 AND idquete=" . $this->idquete . " AND etape=" . $this->etape;
        $count = loadSqlResult($sql);
        if ($this->satisfyObjectives($char) && $count == 0) {
            $sql = "UPDATE `quetes_char` SET end = 1 WHERE idchar=" . $char->getId() . " AND idquete=" . $this->idquete . " AND etape=" . $this->etape;
            loadSqlExecute($sql);
        } elseif ($count == 0) {
            $sql = "UPDATE `quetes_char` SET end = 0 WHERE idchar=" . $char->getId() . " AND idquete=" . $this->idquete . " AND etape=" . $this->etape;
            loadSqlExecute($sql);
        }
    }

    function satisfyObjectives($char) {
        $objectives = $this->getAllObjectives();
        $char_objectives = $this->getAllCharObjectives($char);

        if ($objectives === false)
            return false;

        $valid = true;
        $i = 0;
        foreach ($objectives as $objectif) {
            if (!$this->satisfyThisObjectif($objectif, $char, $char_objectives[$i]))
                $valid = false;
            $i++;
        }
        return $valid;
    }

    function isGoodPnj($pnj) {
        $sql = "SELECT count(*) FROM `quetes_etapes_objectives` WHERE step_id=" . $this->id . " AND id_need=" . $pnj->getId();
        $result = loadSqlResult($sql);
        $valid = true;

        if ($result == 0)
            $valid = false;

        return $valid;
    }

    function validatePnJ($pnj, $char) {
        $sql = "INSERT `quetes_char_objectives` (char_id,step_id,id_need,get) VALUES(" . $char->getId() . "," . $this->id . "," . $pnj->getId() . ",1)";
        loadSqlExecute($sql);
    }

    function satisfyPrerequisites($char) {
        $prerequis = $this->getAllPrerequisites();


        if ($prerequis === false)
            return false;

        $valid = true;
        $i = 0;
        foreach ($prerequis as $prerequi) {
            if (!$this->satisfyThisPrerequis($prerequi, $char))
                $valid = false;
        }
        return $valid;
    }

    function giveRewards($char) {
        $rewards = $this->getAllRewards($char);
        foreach ($rewards as $reward) {
            $this->giveReward($reward, $char);
        }
    }

    private function giveReward($reward, $char) {

        switch ($reward['type']) {
            case 1:
                $char->updateMore('gold', $reward['number_recompense']);
                break;

            case 2:
                $char->updateMore('exp', $reward['number_recompense']);
                break;

            case 3:
                $char_inv = new char_inv($char->getId());
                $char_inv->manageItem($reward['id_recompense'], $reward['number_recompense']);
                break;
        }
    }

    private function getAllRewards($char) {
        $sql = "SELECT id_recompense,number_recompense,type,class_id FROM `quetes_recompenses` WHERE step_id = " . $this->id;
        $result = loadSqlResultArrayList($sql);

        if ($result == '')
            $result = false;

        return $result;
    }

//type 1 = niveau du personnage
//type 2 = Quête accomplie
//type 3 = Objet Requis

    private function satisfyThisPrerequis($prerequi, $char) {
        $valid = false;

        switch ($prerequi['type']) {
            case 1:
                if ($char->getLevel() >= $prerequi['nb_need'])
                    $valid = true;
                break;

            case 2:
                $quete = new Quete($prerequi['id_need']);
                if ($quete->isCompleted($char))
                    $valid = true;
                break;

            case 3:
                $char_inv = new char_inv($char);
                if ($char_inv->hasItem($prerequi['id_need'], $prerequis['nb_need']))
                    $valid == true;
                break;
        }

        return $valid;
    }

    private function satisfyThisObjectif($objectif, $char, $char_objectif) {
        $valid = false;
        if ($objectif['nb_need'] == $char_objectif['get'])
            $valid = true;
        return $valid;
    }

    private function getAllObjectives() {
        $sql = "SELECT id_need,nb_need,type FROM `quetes_etapes_objectives` WHERE step_id = " . $this->id . " ORDER BY id_need";
        $result = loadSqlResultArrayList($sql);

        if ($result == '')
            $result = false;

        return $result;
    }

    private function deleteObjectsNeeded($char) {
        $objectives = $this->getAllObjectives();

        $char_inv = new char_inv($char->getId());

        foreach ($objectives as $objectif) {
            if ($objectif['type'] == 3) {
                $item = new item($objectif['id_need']);
                $char_inv->manageItem($item, $objectif['nb_need'] * -1);
            }
        }
    }

    private function getAllCharObjectives($char) {
        $sql = "SELECT id_need,get FROM `quetes_char_objectives` WHERE char_id=" . $char->getId() . " AND step_id=" . $this->id . " ORDER BY id_need";
        $result = loadSqlResultArrayList($sql);

        if ($result == '')
            $result = false;

        return $result;
    }

    private function getAllPrerequisites() {
        $sql = "SELECT id_need,nb_need,type FROM `quetes_prerequis` WHERE step_id = " . $this->id;
        $result = loadSqlResultArrayList($sql);

        if ($result == '')
            $result = false;

        return $result;
    }

    function getIdNeed($number = 0) {

        if ($number == 1) {
            $sql = "SELECT id_need FROM `quetes_etapes_objectives` WHERE step_id = $this->id ";
            $sql .= "LIMIT 1";
            return loadSqlResult($sql);
        } else {
            $sql = "SELECT nb_need,id_need FROM `quetes_etapes_objectives` WHERE step_id = $this->id ";
            return loadSqlResultArrayList($sql);
        }
    }

    function upGet($char, $id_need, $number = 1, $add = 1, $type = 0) {

        // On regarde si ca d�j� �t� commenc�
        $sql = "SELECT COUNT(*) FROM `quetes_char_objectives` WHERE char_id = " . $char->getId() . " && step_id = $this->id && id_need = $id_need ";
        $count = loadSqlResult($sql);

        if ($count == 1) {
            $sql = "SELECT qeo.nb_need,qco.get " .
                    "FROM `quetes_char_objectives` qco " .
                    "JOIN  `quetes_etapes_objectives` qeo ON qeo.step_id = qco.step_id && qeo.id_need = qco.id_need " .
                    "WHERE qco.char_id = " . $char->getId() . " && qco.step_id = $this->id && qeo.id_need = $id_need ";
            $result = loadSqlResultArray($sql);
        } else {
            $sql = "SELECT nb_need " .
                    "FROM `quetes_etapes_objectives` " .
                    "WHERE step_id = $this->id && id_need = $id_need ";
            $result = loadSqlResultArray($sql);
        }

        if ($add == 1 && $this->type != 3) { // Si ce n'est pas par rapport aux objets
            if ($result['get'] < $result['nb_need']) {
                $get = $result['get'] + $number;
            }
            $this->checkIfAllFinish($char);
        } elseif ($this->type != 3) {
            // v�rification par rapport aux nombre d'objet
            if (($number > $result['nb_need'] && $result['nb_need'] != 0) or ($number == 0 && $type == 2)) {
                $number = $result['nb_need'];
            }

            $get = $result['get'] + $number;
        } else {
            $item = new item($id_need);
            $number = $item->charGetItemNumber($char->getId());
            $get = $number;
        }

        // Mise � jours dans la base
        if ($count == 1) {

            $sql = "UPDATE `quetes_char_objectives` SET get = $get WHERE char_id = " . $char->getId() . " && step_id = $this->id && id_need = $id_need ";
            loadSqlExecute($sql);
        } elseif ($count == 0) {
            $sql = "INSERT INTO `quetes_char_objectives` (char_id,step_id,id_need,get) " .
                    "VALUES (" . $char->getId() . ",$this->id,$id_need,$get)";
            loadSqlExecute($sql);
        }
    }

    function checkIfAllFinish($char) {
        // Mettre � jour les objectifs selon les objets poss�d�s
        $this->updateObjectivesByItem($char);

        $sql = "SELECT id_need,nb_need " .
                "FROM `quetes_etapes_objectives` " .
                "WHERE step_id = $this->id   ";
        $to_do_arrays = loadSqlResultArrayList($sql);

        $sql = "SELECT id_need,get " .
                "FROM `quetes_char_objectives` " .
                "WHERE step_id = $this->id && char_id = " . $char->getId() . "";
        $done_arrays = loadSqlResultArrayList($sql);

        foreach ($done_arrays as $array) {
            $done[$array['id_need']] = $array['get'];
        }

        foreach ($to_do_arrays as $array) {
            $to_do[$array['id_need']] = $array['nb_need'];
        }

        $all_finish = 1;

        // V�rification qu'on a tout fait
        if (count($to_do) >= 1) {
            foreach ($to_do as $id_need => $nb_need) {
                // Si le nombre fait est fait est inf�rieur au nombre � faire
                $done_obj = $done[$id_need];
                if ($done_obj == '')
                    $done_obj = 0;

                if ($nb_need > $done_obj) {
                    $all_finish = 0;
                }
            }
        } else {
            $all_finish = 0;
        }

        // Si tous les objectifs remplis alors qu�te finie
        if ($all_finish == 1) {
            $sql = "UPDATE `quetes_char` SET `end` = 1 WHERE idchar = " . $char->getId() . " && idquete = $this->idquete && etape = $this->etape";
            loadSqlExecute($sql);

            return true;
        } else {
            $sql = "UPDATE `quetes_char` SET `end` = 0 WHERE idchar = " . $char->getId() . " && idquete = $this->idquete && etape = $this->etape";
            loadSqlExecute($sql);
            return false;
        }
    }

    function updateObjectivesByItem($char) {
        $array_item = $this->getIdNeed();
        foreach ($array_item as $array) {
            $item = new item($array['id_need']);
            $number_of_item = $item->charGetItemNumber($char->getId());
            $this->upGet($char, $array['id_need'], $number_of_item, 0);
        }
    }

    function getSumNbNeed($id_need = 0) {
        $sql = "SELECT SUM(nb_need) FROM `quetes_etapes_objectives` WHERE step_id = $this->id ";
        if ($id_need != 0)
            $sql .= " AND id_need = $id_need ";
        return loadSqlResult($sql);
    }

    function getGetNbNeed($char, $id_need = 0) {
        $sql = "SELECT SUM(get) FROM `quetes_char_objectives` WHERE step_id = $this->id && char_id = " . $char->getId() . " ";
        if ($id_need != 0)
            $sql .= " AND id_need = $id_need ";
        $get = loadSqlResult($sql);

        if ($get == '')
            $get = 0;

        return $get;
    }

    function getPourcent($char) {
        $nb_need_tot = $this->getSumNbNeed();
        if ($nb_need_tot == 0)
            $nb_need_tot = 1;

        $nb_need_get = $this->getGetNbNeed($char);
        $pourcent = ($nb_need_get / $nb_need_tot) * 100;
        $pourcent = round($pourcent);

        if ($pourcent > 100)
            $pourcent = 100;

        return $pourcent;
    }

    function isFinishStep($idchar) {
        $sql = "SELECT end FROM quetes_char WHERE idchar = $idchar && idquete = $this->idquete && etape = $this->etape";
        $result = loadSqlResultArray($sql);

        // Si la qu�te n'est pas dans la base , on l'ins�re � l'�tape 1
        if ($result['end'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    function showStepSummary($char) {
        // Chargement des infos utiles pour afficher l'�tape en cours
        $pnj = new pnj($this->pnj);
        $char_get = $this->getUserGetForQuest($char->getId());

        if ($this->nb_need == 0)
            $nbneed = 1;
        else
            $nbneed = $this->nb_need;

        $pourcent = $this->getPourcent($char);

        // Chargement des gains
        $gain_text = $this->getGainText();

        //$finish = $this->isAcceptedStep($char->getId());

        if ($pourcent == 100 && $finish != 0)
            $finish = 2;

        if ($finish == 0) {
            $pourcent = 100;
            $char_get = $this->nb_need;
        }

        $objectif_text = $this->getObjectifText($char_get, $char);

        // sauvegarde des styles

        $styleTitle = "margin-left:42px;font-size:15px;";
        $styleText = "margin-left:58px;font-size:15px;margin-right:20px;";

        echo '<div style="color:black;text-align:left;font-weight:600;">';
        echo '<div class="clean" style="height:20px;"></div>';

        echo '<div style="text-align:center;font-size:20px;font-weight:700;">';
        echo $this->name;
        echo '</div>';

        echo '<div class="clean"></div>';

        echo '<div style="text-align:right;margin-right:25px;">';
        echo 'Accompli &agrave; ' . $pourcent . '%';
        echo '</div>';

        echo '<div class="clean" style="height:20px;"></div>';

        echo '<div style="' . $styleTitle . '">';
        echo '<i>' . $pnj->name . ' :</i> ';
        echo '</div>';

        echo '<div class="clean" style="height:20px;"></div>';

        echo '<div style="' . $styleText . '"><p>';
        echo $this->getTextPnj();
        echo '</p></div>';

        echo '<div class="clean" style="height:20px;"></div>';

        echo '<div style="' . $styleTitle . '">';
        echo '<div> <i>Objectif :</i> </div>';
        echo '<div style="' . $styleText . '"><p>';
        echo $objectif_text;
        echo '</p></div>';
        echo '</div>';

        echo '<div style="' . $styleTitle . '">';
        echo '<div> <i>Gains :</i> </div>';
        echo '<div style="' . $styleText . '"><p>';
        echo $gain_text;
        echo '</p></div>';
        echo '</div>';

        echo '<div class="clean" style="height:20px;"></div>';

        switch ($finish) {
// 0 : si l'�tape est d�j� finie (le joueur est � une autre �tape)
// 1 : si l'�tape est accept�e et pas finie (encore des choses � faire)
// 2 : Si l'�tape a d�j� �t� finie mais besoin de valider

            case '0' :
                echo '<div style="' . $styleText . '">';
                echo 'Vous avez d&eacute;j&agrave; termin&eacute; cette &eacute;tape. <br />';

                // Si il reste des �tapes , indiquer au joueur � qui il doit parler
                break;

            case '1' :
                echo '<div style="text-align:center;">';
                echo 'Qu&ecirc;te en cours';
                break;
            case '2' :
                $name_pnj = pnj::getNameById($this->pnj_valid);
                echo '<div style="' . $styleText . ';text-align:center;margin-right:50px;">';
                echo "Vous devez retourner voir $name_pnj pour valider cette &eacute;tape";
                break;
        }
        echo '</div>';

        echo '</div>';
    }

    function getObjectifText($char_get, $char) {
        // On check si la qu�te est finie
        $this->checkIfAllFinish($char);
        switch ($this->type) {
            case '1':
                $str = "<div style=\"margin-left:-20px;\">Tuer : </div>";

                $arrays = $this->getIdNeed();
                foreach ($arrays as $array) {
                    $monster_name = monster::getNameById($array['id_need']);
                    $nb_get = $this->getGetNbNeed($char, $array['id_need']);
                    if ($nb_get > $array['nb_need'])
                        $nb_get = $array['nb_need'];

                    $str .= " - " . $array['nb_need'] . " $monster_name ($nb_get/" . $array['nb_need'] . ") <br />";
                }

                break;
            case '2':
                $pnj_id = $this->getIdNeed(1);
                $pnj_name = pnj::getNameById($pnj_id);
                $nb_get = $this->getGetNbNeed($char, $pnj_id);
                $str = "Parler &agrave; $pnj_name ($nb_get/1)";
                break;

            case '3':
                $str = "<div style=\"margin-left:-20px;\">Rapporter : </div>";
                $arrays = $this->getIdNeed();

                $finish = $this->isAccepteStep($char->getId());

                foreach ($arrays as $array) {
                    $nb_need = $array['nb_need'];

                    $item = new item($array['id_need']);

                    if ($finish != 0) {
                        $number_of_item = $item->charGetItemNumber($char->getId());
                        if ($number_of_item >= $nb_need) {
                            $number_of_item = $nb_need;
                            $this->updateOnChar('end', '1', $char->getId());
                            $this->updateOnChar('get', $number_of_item, $char->getId());
                        } else {
                            $this->update('end', '0', $char->getId());
                            $this->updateOnChar('get', $number_of_item, $char->getId());
                        }
                    } else {
                        $number_of_item = $nb_need;
                    }

                    $item_name = $item->getName();

                    $str .= " $nb_need $item_name ($number_of_item/$nb_need) <br />";
                }
                break;
        }

        return $str;
    }

    function getUserGetForQuest($idchar) {
        $sql = "SELECT get FROM quetes_char WHERE idchar = $idchar && idquete = $this->idquete && etape = $this->etape";
        return loadSqlResult($sql);
    }

    function getGainText($char) {
        $rewards = $this->getAllRewards($char);
        $sommewin = 0;
        $str = "";

        foreach ($rewards as $reward) {

            switch ($reward['type']) {

                case 1:
                    $str .= $reward['number_recompense'] . " pi&egrave;ces d'or<br/>";
                    break;

                case 2:
                    $str .= $reward['number_recompense'] . " points d'exp<br/>";
                    break;

                case 3:
                    $item = new item($reward['id_recompense']);
                    $str .= $reward['number_recompense'] . " " . $item->getName() . "<br/>";
                    break;
            }
        }
        return $str;
    }

    public static function addStep($arrayInsert = array(), $modif = false, $idquete = 0) {
        $etape = $arrayInsert['etape'];
        if ($modif) {
            $sql = " SELECT COUNT(*) FROM quetes_etapes WHERE idquete = $idquete && etape = $etape";
            $count_step = loadSqlResult($sql);
        }
        if ($modif && $count_step == 1) {
            $sql = "UPDATE quetes_etapes SET ";

            foreach ($arrayInsert as $row => $value)
                if ($row != 'idquete')
                    $sql .= "$row = $value,";

            $sql .= " idquete = $idquete";
            $sql .= " WHERE idquete = $idquete && etape = $etape";
            loadSqlExecute($sql);

            $sql2 = "SELECT id FROM `quetes_etapes` WHERE idquete = $idquete && etape = $etape LIMIT 0,1";
            return loadSqlResult($sql2);
        }
        else {
            if ($idquete != 0)
                $arrayInsert['idquete'] = $idquete;
            foreach ($arrayInsert as $row => $value) {
                $arrayRow[] = $row;
                $arrayValue[] = $value;
            }
            $sql = "INSERT INTO quetes_etapes (" . implode(',', $arrayRow) . ") VALUES (" . implode(',', $arrayValue) . ")";
        }
        loadSqlExecute($sql);

        // Return last id
        $sql2 = "SELECT id FROM `quetes_etapes` ORDER BY id DESC LIMIT 0,1";
        return loadSqlResult($sql2);
    }

    public static function addObjectives($array_obj, $step_id, $type) {
        $sql = "DELETE FROM `quetes_etapes_objectives` WHERE step_id = $step_id";
        loadSqlExecute($sql);
        foreach ($array_obj as $value => $nb_need) {
            if ($nb_need == 0)
                $nb_need = 1;

            switch ($type) {
                case '1' :
                    $id_need = monster::getIdByName($value);
                    break;
                case '2' :
                    $id_need = pnj::getIdByName($value);
                    break;
                case '3' :
                    $id_need = item::getIdByName($value);
                    break;
                case '4' :
                    $id_need = $value;
                    break;
            }
            $sql = "INSERT INTO `quetes_etapes_objectives` " .
                    "(id,step_id,id_need,nb_need) VALUES " .
                    "(NULL,$step_id,$id_need,$nb_need)";
            loadSqlExecute($sql);
        }
    }

    public function hasNotBeenStarted($char) {
        $valid = true;

        //Si c'est la première étape, il ne doit rien avoir de lié à cette quête.
        if ($this->etape == 1) {
            $sql = "SELECT count(*) FROM `quetes_char` WHERE idchar =" . $char->getId() . " AND idquete=" . $this->idquete;
            if (loadSqlResult($sql) != 0)
                $valid = false;
        }

        //On vérifie que les étapes précédentes sont bien finies.
        if ($this->etape > 1) {
            $sql = "SELECT count(*) FROM `quetes_char` WHERE idchar =" . $char->getId() . " AND idquete=" . $this->idquete . " AND (end != 1 OR valid != 1) AND etape < " . $this->etape;
            if (loadSqlResult($sql) != 0)
                $valid = false;
        }
        return $valid;
    }

    public static function getAllStepDoing($char) {
        $sql = "SELECT qe.id FROM quetes_etapes qe " .
                "JOIN quetes_char qc ON qe.idquete = qc.idquete && qe.etape = qc.etape && qc.idchar = " . $char->getId();
        $array_ids = loadSqlResultArrayList($sql);

        foreach ($array_ids as $id) {
            $return[] = $id;
        }

        return $return;
    }

    public static function getAllStepForChar($idchar, $select = "*") {
        $sql = "SELECT $select FROM quetes_etapes q_e JOIN quetes_char q_c ON q_e.idquete = q_c.idquete AND q_e.etape <= q_c.etape WHERE q_c.idchar = $idchar ORDER BY idquete,etape ";
        $stepList = loadSqlResultArrayList($sql);

        return $stepList;
    }

    public static function getAllStepForQuest($idquete) {
        $sql = "SELECT id FROM quetes_etapes WHERE idquete = $idquete ORDER BY etape";
        $all_step = loadSqlResultArrayList($sql);

        return $all_step;
    }

    public static function getNameById($id) {
        $sql = "SELECT name FROM quetes_etapes WHERE id = '$id'";
        return loadSqlResult($sql);
    }

    public static function getAllStepName() {
        $sql = "SELECT name FROM quetes_etapes";
        return loadSqlResultArrayList($sql);
    }

}

?>