<?php

if(!isset($_SESSION))
{
    session_start();
    $server = $_SESSION['server'];
}

require_once("Fighter.class.php");
require_once('Attack.class.php');
require_once($server . 'class/group.class.php');

class fight {

    private $id;
    // 1 = ready phase, people can enter. The player need to be ready
    private $ready_phase;
    // tour active, num�ro correspondant � la place_turn du joueur qui doit jouer
    private $turn;
    // Num�ro du tour, pour les effets et CD
    private $turn_id;
    // Temps restant dans le tour, tour de 30 sec ou 60 sec ? � d�cider
    private $turn_timer;
    // 1 = the fight is locked, noone can enter
    private $locked;
    // Time before the end of the turn
    private $time;
    // 0 = fight versus monster, 1 = perso versus perso
    private $pvp;
    // 0 = fight not end, 1 = team 1 won, 2 = team 2 won
    private $is_end;
    // Timestamp of the fight, delete this after 2 hours
    private $timestamp;
    private $fighterList = array();

    public function Fight() {
        if (func_num_args() > 0)
            $this->loadFight(func_get_arg(0));
    }

    public function loadFight($id) {
        $sql = "SELECT  * FROM `fights` WHERE id = " . $id . " ";
        $result = loadSqlResultArray($sql);

        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }

        $this->loadFighterList();
    }

    public function createFight($char, $pvp, $opponent_id) {
        $time = time();

        $sql = "INSERT INTO `fights`
				(ready_phase,turn,turn_id,turn_timer,locked,is_end,time,pvp,timestamp,char_associated) 
				VALUES 
				(1,1,1," . time() . ",0,0,60,$pvp," . $time . "," . $char->getId() . ");";
        loadSqlExecute($sql);

        $sql = "SELECT id FROM `fights` WHERE timestamp = $time && char_associated = " . $char->getId();
        $result = loadSqlResult($sql);
        $this->id = $result;

        $this->addFighters($char, $pvp, $opponent_id);

        return $result;
    }

    private function addFighters($char, $pvp, $opponent_id) {

        if ($char->getGroupId() > 0) {
            $team1 = new group($char->getGroupId());
            $array_chars = $team1->getMembersList();

            foreach ($array_chars as $char_object) {
                //Seul un joueur peut lance un combat donc team 1 = des joueurs.
                // TODO Modifier pour forger une requête insert unique. Priorité : low
                $this->addFighter($char_object, 1);
            }
        } else {
            $this->addFighter($char, 1);
        }
        if ($pvp == 0) {
            $monster = new monster($opponent_id);
            $this->addFighter($monster, 2);
        } else {
            $char_opponent = new char($opponent_id);

            $team2 = new group($char_opponent->getGroupId());
            $array_chars = $team2->getMembersList();

            foreach ($array_chars as $char_object) {
                //Seul un joueur peut lance un combat donc team 1 = des joueurs.
                // TODO Modifier pour forger une requête insert unique. Priorité : low
                $this->addFighter($char_object, 2);
            }
        }
    }

    public function addFighter($fighter, $team) {

        if ($fighter instanceof char) {
            $isChar = 1;
            $fighter->update('in_fight', true);
            $fighter->update('fight_id', $this->id);
        } else {
            $isChar = 0;
            $fighter->update('in_fight', true);
            $fighter->update('fight_id', $this->id);
        }


        $fighter_instance = new Fighter();
        $fighter_instance->createFighterToSave($fighter->getId(), $this->id, $isChar, $team);

        // On calcule sa place
        $fighterInHisTeamList = $this->getFighterList($team);

        if ($team == 1) {
            $i = 101;
        } else {
            $i = 1;
        }

        $place = $i + count($fighterInHisTeamList);
        $fighter_instance->setPlace($place);

        $fighter_instance->save();

        $this->fighterList[] = $fighter_instance;
    }

    public function allAreReady() {
        if (count($this->fighterList) == 0)
            $this->loadFighterList();

        $allReady = true;

        foreach ($this->fighterList as $fighter) {
            if (!$fighter->isReady())
                $allReady = false;
        }

        return $allReady;
    }

    public function isInReadyPhase() {
        if ($this->ready_phase == 1)
            return true;
        else
            return false;
    }

    public function setNeedRefreshForAll() {
        $sql = "UPDATE `fighters` SET needRefresh = 1 WHERE fight_id = " . $this->id;
        loadSqlExecute($sql);
    }

    public function finishReadyPhase() {
        // Update ready phase � 0
        $sql = "UPDATE `fights` SET ready_phase = 0 WHERE id = " . $this->id;
        loadSqlExecute($sql);

        // Calcule de l'initiative et cr�ation des turns
        $sortedList = $this->getFighterListOrderByInit();

        $turn_place = 1;

        foreach ($sortedList as $fighter) {
            $fighter->updateTurnPlace($turn_place);
            $turn_place++;
        }

        // set turn = 1 sur l'objet fight
        $sql = "UPDATE `fights` SET turn = 1, turn_id = 1 WHERE id = " . $this->id;
        loadSqlExecute($sql);

        $this->SetNewTurnTime();
    }

    public function SetNewTurnTime() {
        // On met le turn timer à time + 60 car un tour prend 60 sec
        $turn_timer = time() + 30;

        $sql = "UPDATE `fights` SET turn_timer = '" . $turn_timer . "' WHERE id = " . $this->id;
        loadSqlExecute($sql);
    }

    public function loadFighterList() {
        $sql = "SELECT  * FROM `fighters` WHERE fight_id = " . $this->id . " ";
        $fighterList = loadSqlResultArrayList($sql);

        $fighterReturnList = array();

        if (count($fighterList) > 1) {
            foreach ($fighterList as $fighterArray) {

                $fighterObject = new Fighter($fighterArray);

                $fighterObject->loadInstance();
                $fighterReturnList[] = $fighterObject;
            }
        }

        $this->fighterList = $fighterReturnList;
    }

    public function getFighterList($team) {
        if (count($this->fighterList) == 0)
            $this->loadFighterList();

        $returnList = array();

        if (count($this->fighterList) != 0) {
            foreach ($this->fighterList as $fighter) {
                if ($fighter->getTeam() == $team)
                    $returnList[] = $fighter;
            }
        }
        return $returnList;
    }

    public function getNumberOfFighter() {
        if (count($this->fighterList) == 0)
            $this->loadFighterList();

        return count($this->fighterList);
    }

    public function getFighterListOrderByInit() {
        /* TODO */
        if (count($this->fighterList) == 0)
            $this->loadFighterList();

        return $this->fighterList;
    }

    public function charIsInFight($char) {
        /* TODO */
        return true;
    }

    public function endTurn($fighter) {
        // On met à jours le turn, turn id, turn timer et le nombre de PA du nouveau fighter
        $this->turn = $this->turn + 1;



        if ($this->turn > $this->getNumberOfFighter())
            $this->turn = 1;

        $this->turn_id = $this->turn_id + 1;

        // Turn time
        $this->SetNewTurnTime();

        $sql = "UPDATE `fights` SET 
				turn = " . $this->turn . ", 
				turn_id = " . $this->turn_id . " WHERE id = " . $this->id;
        loadSqlExecute($sql);


        // Action sur le joueur suivant
        $fighter = new Fighter();
        $fighter->loadFighterAtPlace($this->turn, $this->id);


        // On lui remet 6 PA
        $fighter->updatePa(6);

        // On applique les Effets sur le perso (dégats/tour) et on décrémente les effets de 1 tours


        $this->setNeedRefreshForAll();
    }

    function isFightFinished() {
        $team1 = $this->getFighterList(1);
        $team1_dead = true;

        foreach ($team1 as $peon) {
            if ($peon->getLife() > 0)
                $team1_dead = false;
        }

        $team2 = $this->getFighterList(2);
        $team2_dead = true;
        foreach ($team2 as $peon) {
            if ($peon->getLife() > 0)
                $team2_dead = false;
        }
        if ($team1_dead)
            $this->updateIsEnd(2);
        if ($team2_dead)
            $this->updateIsEnd(1);

        if ($team1_dead || $team2_dead)
            return true;
        return false;
    }

    public function endTheFight() {
        $totalExp = 0;
        $totalGold = 0;

        // Sécurité pour pas faire 2 fois les gains
        $this->loadFight($this->id);

        // Calcul de l'exp / or gagné pour les joueurs de la team
        $winnerList = $this->getFighterList($this->is_end);

        // Perte d'exp d'or pour les perdants
        if ($this->is_end == 1)
            $loserList = $this->getFighterList(2);
        else
            $loserList = $this->getFighterList(1);


        foreach ($loserList as $loserFighter) {
            $loser = $loserFighter->getInstance();
            if ($loser instanceof MonsterInFight) {
                $totalExp += $loser->getExp();
                $totalGold += $loser->getGold();
            }
        }

        foreach ($winnerList as $winnerFighter) {
            if ($winnerFighter->isChar()) {
                $winner = $winnerFighter->getInstance();

                // calcul de l'exp gagné selon les niveaux ?
                $expWin = $totalExp / count($winnerList);
                $winner->updateExp($expWin);
                $winnerFighter->updateExpWin($expWin);

                // Calcul de l'or gagné
                $goldWin = $totalGold / count($winnerList);
                $winner->updateMore('gold', $goldWin);
                $winnerFighter->updateGoldWin($goldWin);

                $itemListDrop = array();

                // Gestion des objets gagnés
                foreach ($loserList as $loserFighter) {
                    $loser = $loserFighter->getInstance();
                    if ($loser instanceof Monster) {
                        $drop_array = $loser->getDrops();

                        foreach ($drop_array as $drop) {
                            // Génération d'un nombre aléatoire pour voir si l'objet tombe
                            $rand = mt_rand(0, 1000);

                            $ratio_bonus = 0;
                            $ratio_bonus = ($winner->getTot('cha') / 100);


                            $drop_bonus = $drop['pourcent'] * $ratio_bonus;

                            $drop_base = $drop['pourcent'];

                            if ($winner->isVip())
                                $drop_base = $drop_base + ($drop_base * 0.5);

                            $rand_drop = $drop_base + $drop_bonus;

                            if ($rand_drop > 80)
                                $rand_drop = 80;

                            $chance = $rand / 10;

                            if ($chance < $rand_drop) {
                                $itemListDrop[] = $drop['item'];
                            }
                        }
                    }
                }

                $this->fighterHasDropItem($itemListDrop, $winner->getId());
            }
        }

        foreach ($loserList as $loserFighter) {
            if ($loserFighter->isChar()) {
                $loser = $loserFighter->getInstance();

                // calcul de l'exp perdu
                // Calcul de l'or perdu
            }
        }
    }

    public function fighterHasDropItem($item_list, $char_id) {
        // On voit si on a drop 2 fois le même objet
        $finalItemList = array();
        foreach ($item_list as $item) {
            if ($finalItemList[$item] != "" && $finalItemList[$item] > 0) {
                $finalItemList[$item] = $finalItemList[$item] + 1;
            } else {
                $finalItemList[$item] = 1;
            }
        }

        foreach ($finalItemList as $key => $number) {
            $sql = "INSERT INTO `royaume-arelidon`.`fighters_item_win` (
					`fight_id` ,
					`fighter_id` ,
					`number` ,
					`item_id`
					)
					VALUES (
					'" . $this->id . "', '" . $char_id . "', '" . $number . "', '" . $key . "'
					);";

            loadSqlExecute($sql);
        }
    }

    public function getAllAttacks() {
        $sql = "SELECT * FROM `attacks` WHERE fight_id = '" . $this->id . "' ORDER BY timestamp DESC ";
        $results = loadSqlResultArrayList($sql);

        $attackList = array();

        if (count($results) >= 1) {
            foreach ($results as $result) {
                $attack = new Attack();
                $attack->castArrayInObject($result);

                $attackList[] = $attack;
            }
        }

        return $attackList;
    }

    // ------------------------------- Static function -------------------------------------------------

    public static function setNeedRefreshForAllForFightId($fight_id) {
        $sql = "UPDATE `fighters` SET needRefresh = 1 WHERE fight_id = " . $fight_id;
        loadSqlExecute($sql);
    }

    // ------------------------------- Getters / Setters -----------------------------------------------
    public function getId() {
        return $this->id;
    }

    public function getTurn() {
        return $this->turn;
    }

    public function getTurnId() {
        return $this->turn_id;
    }

    public function getTurnTimer() {
        return $this->turn_timer;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getIsEnd() {
        return $this->is_end;
    }

    public function isEnd() {
        if ($this->is_end >= 1)
            return true;
        else
            return false;
    }

    public function updateIsEnd($isEnd) {
        $sql = "UPDATE `fights` SET is_end = '$isEnd' WHERE id = '" . $this->id . "' ";
        loadSqlExecute($sql);

        $this->is_end = $isEnd;
    }

}