<?php

/*
 * Created on 18 ao�t 2009
 *
 * Class permettant de g�rer les monstres , actions et autres infos sur la carte
 */

class map {

    private $id;
    private $name;
    private $image;
    private $continent;
    private $abs;
    private $ord;
    private $alt;
    private $refmap;
    private $refabs;
    private $reford;
    private $arena;
    private $room_id;
    // Bol�en qui d�finit si c'est un foyer de guilde
    private $guild_home;

    function __construct() {
        $num = func_num_args();
        switch ($num) {
            case 1 :
                $this->loadMap(func_get_arg(0));
                break;
        }
    }

    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function setAbs($abs) {
        $this->abs = $abs;
    }

    function getAbs() {
        return $this->abs;
    }

    function setOrd($ord) {
        $this->ord = $ord;
    }

    function getOrd() {
        return $this->ord;
    }

    function setAlt($alt) {
        $this->alt = $alt;
    }

    function getAlt() {
        return $this->alt;
    }

    function getImage() {
        return $this->image;
    }

    function getContinent() {
        return $this->continent;
    }

    function isArena() {
        if ($this->arena == 1)
            return true;
        else
            return false;
    }

    function getRoomId() {
        return $this->room_id;
    }

    function isDonjon() {
        if ($this->room_id >= 1)
            return true;
        else
            return false;
    }

    function isGuildHome() {
        return ($this->guild_home == 1);
    }

    function loadMap($id) {
        $sql = "SELECT * FROM mapworld WHERE id = '" . $id . "'";
        $result = loadSqlResultArray($sql);

        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }

    function loadMapByCord($abs, $ord, $alt) {
        $sql = "SELECT * FROM mapworld WHERE abs = '" . $abs . "' && ord = '" . $ord . "' && alt = '" . $alt . "' ";
        $result = loadSqlResultArray($sql);

        if (count($result) > 0 && $result != "") {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    function add($image, $abs, $ord, $alt, $continent) {
        $sql = "INSERT INTO mapworld (`image` ,`abs` ,`ord`,`alt`,`continent`) VALUES ('" . $image . "','" . $abs . "','" . $ord . "','" . $alt . "','" . $continent . "')";
        loadSqlExecute($sql);
        return 0;
    }

    function addContinent($name, $refabs, $reford, $refalt) {
        $sql = "INSERT INTO continent (`name` ,`refabs` ,`reford`,`refalt`) VALUES ('" . $name . "','" . $refabs . "','" . $reford . "','" . $refalt . "')";
        loadSqlExecute($sql);
        return 0;
    }

    function update($row, $value) {
        $sql = "UPDATE mapworld SET $row = $value WHERE id = $this->id";
        loadSqlExecute($sql);
        return 0;
    }

    function getArrayCase($char, $group_id = 0, $true = true) {
        return $this->prepareArrayCase($char, $group_id, $true);
    }

    function updateMonstersToRespawn() {
        $monsters = $this->getMonstersToUpdate();



        if (is_array($monsters) and count($monsters) > 0) {
            foreach ($monsters as $line) {
                $monster_to_respawn = new monster($line['id']);
                $monster_to_respawn->updateRespawn();
            }
        }
    }

    private function getMonstersToUpdate() {

        $sql = "SELECT id FROM `monsteronmap` WHERE life = 0 AND timestamprespawn <=" . $_SERVER['REQUEST_TIME'] . " AND map = " . $this->getId();

        return loadSqlResultArrayList($sql);
    }

    private function prepareArrayCase($char, $group_id, $true) {
        // On r�cup�re toutes les donn�es aussi.
        //Comme ca elles seront dispo pour le traitement
        //Et tous les array automatiquements d�truits � la fin de la fonction.

        $monsterList = monster::getAllMonstersOnMap($char->getMap(), $_SERVER['REQUEST_TIME'], $group_id); //monstres
        //obstacles
        $obstacles = self::getAllObstaclesOnMap($char->getMap(), $char);

        //ressources
        $sql = "SELECT SQL_SMALL_RESULT SQL_NO_CACHE m.id,m.abs,m.ord,m.action_id,ma.objet_id FROM `metier_ressource` AS m, `metier_action` AS ma WHERE map = " . $char->getMap() . " && ma.id== m.action_id && time <= " . $_SERVER['REQUEST_TIME']; //ressources
        $ressources = loadSqlResultArrayList($sql);

        $players_online = char::getPlayersOnlineOnMap($char, 0); //joueurs en ligne

        $sql = "SELECT SQL_SMALL_RESULT SQL_NO_CACHE om.item_id,om.abs, om.ord, o.name FROM `objetonmap` AS om, `objet` AS o WHERE om.item_id = o.id AND map = " . $char->getMap(); //objets sur la carte
        $array_item = loadSqlResultArrayList($sql);

        $interaction_array = interaction::getAllActionsOnMap($char->getMap());

        $atelier_array = get_cache('atelier', 'atelier_', $char->getMap());
        if (is_bool($atelier_array)) {
            $atelier_array = metier::getAtelierOnMap($char->getMap());
            create_cache('atelier', 'atelier_', $char->getMap(), $atelier_array);
        }

        $tresors = get_cache('coffre', 'coffre_' . $char->getMap());
        $test1 = is_Bool($tresors);
        if ($test1 === true) {
            destroy_cache('coffre', 'coffre_', $char->getMap());
            $sql = "SELECT t.id,t.abs,t.img AS image,t.ord, (SELECT count(*) FROM `tresor_open` AS tr WHERE tr.idchar=" . $char->getId() . " AND tr.idtresor  ) AS opened FROM `tresor`  AS t WHERE map = '" . $char->getMap() . "' "; //tresors
            $tresors = loadSqlResultArrayList($sql);
            create_cache('coffre', 'coffre_', $char->getMap(), $tresors);
        }


        //pnj
        $arrayPnj = get_cache('arraypnj', 'arraypnj_' . $char->getMap());
        $test2 = is_Bool($arrayPnj);
        if ($test2 === true) {
            destroy_cache('arraypnj', 'arraypnj_', $char->getMap());
            $arrayPnj = pnj::getAllPnjOnMap($char->getMap());
            create_cache('arraypnj', 'arraypnj_', $char->getMap(), $arrayPnj);
        }



        $arrayMapCase = get_cache('case', 'case_' . $char->getMap());
        $test = is_Bool($arrayMapCase);
        if ($test === true) {
            destroy_cache('case', 'case_', $char->getMap());
            $sql = "SELECT abs,ord FROM `map` WHERE map = '" . $char->getMap() . "' && bloc = '1'";
            $arrayMapCase = loadSqlResultArrayList($sql);
            create_cache('case', 'case_', $char->getMap(), $arrayMapCase);
        }

        $boxletter = get_cache('box', 'box_', $char->getMap()); //bo�te postale
        if (is_bool($boxletter)) {
            destroy_cache('box', 'box_', $char->getMap());
            $sql = "SELECT id,abs,ord FROM `trade_box` WHERE map = '" . $char->getMap() . "' ";
            $boxletter = loadSqlResultArrayList($sql);
            create_cache('box', 'box_', $char->getMap(), $boxletter);
        }

        if ($true)
            $arrayWP = get_cache('telep', 'telep_', $char->getMap());
        else
            $arrayWP = array();


        if (is_bool($arrayWP)) {
            $arrayWP = map::getAllTelep($char->getMap());
            create_cache('telep', 'telep_', $char->getMap(), $arrayWP);
        }




        return $this->manageArrayCompletion($monsterList, $obstacles, $ressources, $players_online, $tresors, $arrayPnj, $arrayMapCase, $boxletter, $arrayWP, $array_item, $atelier_array, $interaction_array);
    }

    private function manageArrayCompletion($monsterList, $obstacles, $ressources, $players_online, $tresors, $arrayPnj, $arrayMapCase, $boxletter, $arrayWP, $array_item, $atelier_array, $interaction_array) {
        $arrayCase = Array(); // initialisation de l'array, pour des raisons �videntes


        if (count($monsterList) > 0) //si il y a des monstres sur la carte.
            $arrayCase = $this->addMonstersInArray($monsterList, $arrayCase);

        //Ajout des obstacles
        if (count($obstacles) > 0)
            $arrayCase = $this->addObstaclesInArray($obstacles, $arrayCase);

        //Ajout des ressources
        if (count($ressources) > 0)
            $arrayCase = $this->addRessourcesInArray($ressources, $arrayCase);

        //Ajout des autres joueurs
        if (count($players_online) > 0)
            $arrayCase = $this->addPlayersInArray($players_online, $arrayCase);

        //ajout pnj
        if (count($arrayPnj) > 0) {
            $arrayCase = $this->addPnjArray($arrayPnj, $arrayCase);
        }

        //ajout cases bloqu�es
        if (count($arrayMapCase) > 0) {
            $arrayCase = $this->addBlockCases($arrayMapCase, $arrayCase);
        }

        if (count($tresors) > 0) {
            $arrayCase = $this->addTresorsArray($tresors, $arrayCase);
        }

        if (count($boxletter) > 0) {
            $arrayCase = $this->addBoxletterArray($boxletter, $arrayCase);
        }

        if (count($arrayWP) > 0) {
            $arrayCase = $this->addTelepArray($arrayWP, $arrayCase);
        }

        if (count($array_item) > 0) {
            $arrayCase = $this->addItemArray($array_item, $arrayCase);
        }

        if (count($atelier_array) > 0) {
            $arrayCase = $this->addAtelierArray($atelier_array, $arrayCase);
        }

        if (count($interaction_array) > 0) {
            $arrayCase = $this->addInteractionArray($interaction_array, $arrayCase);
        }

        return $arrayCase;
    }

    private function addInteractionArray($interaction_array, $arrayCase) {
        foreach ($interaction_array as $interaction) {
            $interaction_information = Array("type" => 12, "id" => $interaction['id']);
            $arrayCase[$interaction['ord']][$interaction['abs']] = $interaction_information;
        }

        return $arrayCase;
    }

    private function addAtelierArray($atelier_array, $arrayCase) {
        foreach ($atelier_array as $atelier) {
            $atelier_information = Array("type" => 11, "id" => $atelier['id']);
            $arrayCase[$atelier['ord']][$atelier['abs']] = $atelier_information;
        }

        return $arrayCase;
    }

    private function addItemArray($array_item, $arrayCase) {
        foreach ($array_item as $item) {
            $itemArray = Array("type" => 10, "item_id" => $telep['item_id'], "name" => $telep['name']);
            $arrayCase[$item['ord']][$item['abs']] = $itemArray;
        }

        return $arrayCase;
    }

    private function addTelepArray($arrayWP, $arrayCase) {

        foreach ($arrayWP as $telep) {
            $telepArray = Array("type" => 9, "type_telep" => $telep['type'], "abschange" => $telep['abschange'], "ordchange" => $telep['ordchange'], "changemap" => $telep['changemap']);
            $arrayCase[$telep['ord']][$telep['abs']] = $telepArray;
        }

        return $arrayCase;
    }

    private function addBoxletterArray($boxletter, $arrayCase) {
        foreach ($boxletter as $result) {
            $boxletterarray = Array("type" => 8, "id" => $result['id'], "abs" => $result['abs'], "ord" => $result['ord']);
            $arrayCase[$result['ord']][$result['abs']] = $boxletterarray; //TODO
        }
        return $arrayCase;
    }

    private function addTresorsArray($tresors, $arrayCase) {
        foreach ($tresors as $result) {
            $arrayBox = Array("type" => 3, "id" => $result['id'], "image" => $result['image'], "opened" => $result['opened']);
            $arrayCase[$result['ord']][$result['abs']] = $arrayBox;
        }
        return $arrayCase;
    }

    private function addBlockCases($arrayMapCase, $arrayCase) {
        $caseBlock = array('type' => '1'); //case bloqu�e
        foreach ($arrayMapCase as $result) {
            $arrayCase[$result['ord']][$result['abs']] = $caseBlock;
        }
        return $arrayCase;
    }

    private function addPnjArray($pnjList, $arrayCase) {
        $caseBlock = array('type' => '1'); //case bloqu�e
        foreach ($pnjList as $pnj) {
            // taille 1
            $arrayCase[$pnj['ord']][$pnj['abs']] = array('type' => 2, 'id' => $pnj['id'], 'abs' => $pnj['abs'], 'ord' => $pnj['ord'], 'taille' => $pnj['taille'], 'image' => $pnj['image'], 'name' => $pnj['name']);

            switch ($pnj['taille']) {
                case 2:
                    $arrayCase[$pnj['ord'] + 1][$pnj['abs']] = $caseBlock;
                    break;

                // taille 3 (horizontale)
                case 3:
                    $arrayCase[$pnj['ord'] - 1][$pnj['abs'] + 1] = $caseBlock;

                    break;
                // taille 4 (carr�)
                case 4:
                    $arrayCase[$pnj['ord'] - 1][$pnj['abs'] + 1] = $caseBlock;
                    $arrayCase[$pnj['ord']][$pnj['abs'] + 1] = $caseBlock;
                    $arrayCase[$pnj['ord']][$pnj['abs']] = $caseBlock;
                    break;
            }
        }

        return $arrayCase;
    }

    private function addPlayersInArray($players_online, $arrayCase) {
        $caseBlock = array('type' => '1'); //case bloqu�e
        if (count($players_online) > 0) {
            foreach ($players_online as $player) {
                $arrayCase[$player['ord'] - 1][$player['abs']] = $caseBlock;
                $player_object = new char($player['id']);
                $playerArray = Array("type" => 7, "id" => $player['id'], "abs" => $player['abs'], "ord" => $player['ord'], "image" => $player_object->getUrlPicture('ico', $player['face']));
                $arrayCase[$player['ord']][$player['abs']] = $playerArray;
            }
        }
        return $arrayCase;
    }

    private function addObstaclesInArray($obstacles, $arrayCase) {
        $caseBlock = array('type' => '1'); //case bloqu�e
        if (count($obstacles) > 0) {
            foreach ($obstacles as $obstacle) {

                $obstacleArray = Array("type" => 6, "id" => $obstacle['id'], "abs" => $obstacle['abs'], "ord" => $obstacle['ord'], "taille" => $obstacle['taille'], "image" => $obstacle['img']);
                $arrayCase[$obstacle['ord']][$obstacle['abs']] = $obstacleArray;

                switch ($obstacle['taille']) {
                    // taille 2
                    case 2:
                        $arrayCase[$obstacle['ord'] - 1][$obstacle['abs']] = $caseBlock;
                        break;

                    // taille 3 (horizontale)
                    case 3:
                        $arrayCase[$obstacle['ord']][$obstacle['abs'] + 1] = $caseBlock;
                        break;


                    // taille 4 (carr�)
                    case 4:
                        $arrayCase[$obstacle['ord']][$obstacle['abs'] + 1] = $caseBlock;
                        $arrayCase[$obstacle['ord'] - 1][$obstacle['abs'] + 1] = $caseBlock;
                        $arrayCase[$obstacle['ord'] - 1][$obstacle['abs']] = $caseBlock;
                        break;
                }
            }
        }
        return $arrayCase;
    }

    private function addRessourcesInArray($ressources, $arrayCase) {
        $caseBlock = array('type' => '1'); //case bloqu�e
        foreach ($ressources as $ressource) {
            $ressourceArray = Array("type" => 5, "id" => $ressource['id'], "abs" => $ressource['abs'], "ord" => $ressource['ord'], "item_id" => $ressource['item_id']);
            $arrayCase[$ressource['ord']][$ressource['abs']] = $caseBlock;

            //TODO : informations compl�mentaires
        }
        return $arrayCase;
    }

    private function addMonstersInArray($monsterList, $arrayCase) {
        $caseBlock = array('type' => '1'); //case bloqu�e
        foreach ($monsterList as $monster) {
            $monster_array = array("type" => 4, "id" => $monster['id'], "abs" => $monster['abs'], "ord" => $monster['ord'], "idmstr" => $monster['idmstr'], "taille" => $monster['taille']);
            $arrayCase[$monster['ord']][$monster['abs']] = $monster_array;

            switch ($monster['taille']) {
                // pour les monstres tailles humaines
                case 2:
                    $arrayCase[$monster['ord'] + 1][$monster['abs']] = $caseBlock;
                    break;

                // pour les monstres tailles serpent ^^
                case 3:
                    $arrayCase[$monster['ord']][$monster['abs'] + 1] = $caseBlock;
                    break;

                // Pour les gros monstres ^^
                case 4:
                    $arrayCase[$monster['ord'] + 1][$monster['abs']] = $caseBlock;
                    $arrayCase[$monster['ord']][$monster['abs'] + 1] = $caseBlock;
                    $arrayCase[$monster['ord'] + 1][$monster['abs'] + 1] = $caseBlock;
                    break;
            }
        }
        return $arrayCase;
    }

    public static function updateMap($row, $value, $id) {
        $sql = "UPDATE map SET $row = $value WHERE id = $id";
        loadSqlExecute($sql);
        return 0;
    }

    function getIdByImage($image) {
        $sql = "SELECT id FROM mapworld WHERE image = '" . $image . "'";
        $result = loadSqlResult($sql);
        $this->id = $result;
        return $result;
    }

    function getAdjacente($lat, $long = '0', $alt = '0') {
        $absShow = $this->abs + $lat;
        $ordShow = $this->ord + $long;
        $altShow = $this->alt + $alt;

        $sql = "SELECT id FROM mapworld WHERE `abs` = '" . $absShow . "' && `ord` = '" . $ordShow . "' && `alt` = '" . $altShow . "' LIMIT 0,1 ";
        $result = loadSqlResult($sql);
        if ($result != 0) {
            return $result;
        } else {
            return 0;
        }
    }

    function getMapRespawn() {
        $sql = "SELECT SQL_CACHE refabs,reford,refmap FROM `continent` WHERE id = (SELECT continent FROM `mapworld` WHERE id = " . $this->getId() . "); ";
        $array = loadSqlResultArray($sql);
        return $array;
    }

    function hasExplore($char_id) {
        $sql = "INSERT INTO `map_exploration` (`char_id`,`map_id`)" .
                " VALUES (" . $char_id . "," . $this->id . ")";
        loadSqlExecute($sql);

        $path = DOC_PATH . 'tiiiii';
        touch($path);

        if (($f = fopen($path, "w"))) {
            fwrite($f, $sql);
        }
    }

    function getMerchandOnMap() {
        $sql = "SELECT COUNT(id) FROM pnj WHERE map = " . $this->id . " && (fonction = 1 or fonction = 2)";

        if (loadSqlResult($sql) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function getPnjWithQuestOnMap($char) {
        $sql = "SELECT * FROM pnj WHERE map = " . $this->id . " && (SELECT COUNT(id) FROM `quetes_etapes` WHERE pnj = pnj.id or pnj_valid = pnj.id or (fonction = 2 && id_need = pnj.id) ) >= 1";
        $array_pnjs = loadSqlResultArrayList($sql);
        var_dump($sql);

        foreach ($array_pnjs as $pnj_array) {
            $pnj = new pnj($pnj_array['id']);
            $arrayInfoQuest = $pnj->hasAQuest($char);
            if (is_array($arrayInfoQuest)) {
                return true;
            }
        }
        // Si aucun n'a renvoy� true , on renvoi false
        return false;
    }

    function importInformation($map_id_import) {
        pre_dump('import');

        if ($map_id_import == 0)
            return false;

        // Copie des cases bloqu�es , mais pas les t�l�porteurs
        $sql = "SELECT * FROM `map` WHERE map = " . $map_id_import . " && bloc = 1 && changemap = 0";
        $result = loadSqlResultArrayList($sql);

        foreach ($result as $case) {
            $sql = "INSERT INTO `map` (map,abs,ord,bloc) VALUES (" . $this->id . "," . $case['abs'] . "," . $case['ord'] . ",1)";
            loadSqlExecute($sql);
        }

        // Copie des monstres sur la carte
        $sql = "SELECT * FROM `monsteronmap` WHERE map = " . $map_id_import;
        $monsters = loadSqlResultArrayList($sql);

        foreach ($monsters as $monster) {
            $monster_object = new monster($monster['idmstr'], 'infotype');
            $monster_object->addMonsterOnMap($monster['abs'], $monster['ord'], $this->id);
        }

        // copie des coffres
        $sql = "SELECT * FROM `tresor` WHERE map = " . $map_id_import;
        $boxs = loadSqlResultArrayList($sql);

        foreach ($boxs as $box) {
            $box_object = new box($box['id']);
            $box_object->duplicate($map_id_import);
        }
    }

    function blocCase($abs, $ord) {
        $sql = "INSERT INTO `map` (`map` ,`abs` ,`ord` ,`bloc` ,`changemap` ,`abschange` ,`ordchange` ) VALUES ('" . $this->id . "', '$abs', '$ord', '1', '', '', '') ON DUPLICATE KEY UPDATE bloc=1";
        loadSqlExecute($sql);
    }

    function blocCases($abs, $abs_max, $ord, $ord_max) {
        if ($abs_max < $abs) {
            $save = $abs;
            $abs = $abs_max;
            $abs_max = $save;
        }

        if ($ord_max < $ord) {
            $save = $ord;
            $ord = $ord_max;
            $ord_max = $save;
        }

        for ($i = $abs; $i <= $abs_max; $i++) {
            for ($j = $ord; $j <= $ord_max; $j++) {
                $this->blocCase($i, $j);
            }
        }
    }
    
    function delete()
    {
        $sql="SELECT image FROM `mapworld` WHERE id=".$this->getId();
        $image=loadSqlResult($sql);

        @unlink("map/".$image);

        $sql="DELETE FROM `mapworld` WHERE id=".$this->getId()." LIMIT 1";
        loadSqlExecute($sql);

        $sql="DELETE FROM `map` WHERE map=".$this->getId();
        loadSqlExecute;($sql);
          
    }

// Public function
    public static function getImageById($map_id) {
        $sql = "SELECT SQL_CACHE image FROM `mapworld` WHERE id=$map_id";
        $result = loadSqlResult($sql);
        return $result;
    }

    public static function getAllContinents() {
        $sql = "SELECT * FROM continent ";
        $result = loadSqlResultArrayList($sql);

        return $result;
    }

// Charge toutes les cases bloqu�es	
    public static function getAllBlock($idmap) {
        $arrayCase = array();
        $sql = "SELECT abs,ord FROM `map` WHERE map = '" . $idmap . "' && bloc = '1'";
        $do = loadSqlResultArrayList($sql);

        foreach ($do as $result) {
            $number = ($result['ord'] - 1) * 25 + $result['abs'];
            $arrayCase[$number] = '1';
        }

        return $arrayCase;
    }

    public static function getAllTelep($idmap, $abs = 0, $ord = 0) {
        $sql = "SELECT abs,ord,changemap,type,abschange,ordchange FROM `map` WHERE map = " . $idmap . " && changemap >= 1";
        $result = loadSqlResultArrayList($sql);

        return $result;
    }

    public static function showCaseBlock($case, $block, $abs, $ord, $target, $idmap) {
        $url = 'gestion/page.php?category=2&action=block&';
        $onclick = "";

        if ($block == 1) {
            $url .= "deblock=1&abs=" . $abs . "&ord=" . $ord . "&map=" . $idmap;
            $onclick = "HTTPTargetCall('" . $url . "','map_$case',false,true);";
            echo '<div id="map_' . $case . '">';
            echo '<img src="pictures/utils/no.gif"  alt="" onclick="' . $onclick . '" />';
            echo '</div>';
        } else {

            $url .= "block=1&abs=" . $abs . "&ord=" . $ord . "&map=" . $idmap;
            $onclick = "HTTPTargetCall('" . $url . "','map_$case',false,true);";
            echo '<div id="map_' . $case . '">';
            echo '<img src="pictures/utils/yes.gif" onclick="' . $onclick . '" alt="" onclick="' . $onclick . '" />';
        } // fin si libre

        echo '</div>';
    }

    public static function getMonsterOnCase($idmap, $abs, $ord) {
        $sql = "SELECT idmstr FROM `monsteronmap` WHERE map = $idmap && abs_base = $abs && ord_base = $ord LIMIT 1";
        return loadSqlResult($sql);
    }

    public static function deleteTelep($map, $abs, $ord) {
        $sql = "DELETE FROM `map` WHERE map=$map AND abs=$abs AND ord=$ord LIMIT 1";
        loadSqlExecute($sql);
    }

    public static function caseFree($map, $abs, $ord) {
        $sql = "SELECT bloc FROM `map` WHERE map = $map && abs = $abs && ord = $ord LIMIT 0,1";
        $bloc = loadSqlResult($sql);

        $sql = "SELECT id FROM `pnj` WHERE map = $map && abs = $abs && ord = $ord LIMIT 0,1";
        $pnj = loadSqlResult($sql);

        if ($bloc == 1 or $pnj >= 1)
            return false;
        else
            return true;
    }

    public static function getItemOnCase($char) {
        $timestamp_limit = time() - 300;

        $sql = "DELETE FROM `objetonmap` WHERE timestamp <= $timestamp_limit ";
        loadSqlExecute($sql);

        $sql = "SELECT item_id FROM `objetonmap` WHERE map = " . $char->getMap() . " && abs = " . $char->getAbs() . " && ord = " . $char->getOrd() . "";
        $items = loadSqlResultArrayList($sql);

        if (count($items) > 0) {
            foreach ($items as $result) {
                $array_result[] = $result['item_id'];
            }
            return $array_result;
        }
    }

// Chargement des objets sur la carte

    public static function getAllObstaclesOnMap($map_id, $char) {
        $sql = "SELECT SQL_CACHE ob.* " .
                "FROM `obstacle` ob " .
                "WHERE " .
                " hide = 0 AND map = $map_id ";
        $all = loadSqlResultArrayList($sql);

        // On enl�ve ceux supprim�s ou d�plac�s sur une autre carte
        $sql = "SELECT SQL_CACHE ob.* " .
                "FROM `obstacle` ob JOIN `event_char` ec ON ob.id = ec.obstacle_id " .
                "WHERE " .
                " (ec.type = 3 AND ob.map = $map_id AND char_id = " . $char->getId() . ") " .
                "OR (ec.type = 2 AND ec.map != $map_id AND char_id = " . $char->getId() . ")"; // si on a bouger sur une autre carte l'obstacle'
        $remove = loadSqlResultArrayList($sql);

        $array_restrict = array();
        if (count($remove) > 0)
            foreach ($remove as $ra)
                $array_restrict[] = $ra['id'];

        $array_obstacle_result = array();
        if (count($all) > 0) {
            foreach ($all as $a) {
                if (!(in_array($a['id'], $array_restrict)))
                    $array_obstacle_result[$a['id']] = $a;
            }
        }

        return $array_obstacle_result;
    }

    public static function isBlock($map, $abs, $ord) {
        $sql = "SELECT bloc FROM `map` WHERE map =  '" . $map . "' && abs = '" . $abs . "' && ord = '" . $ord . "'";
        $result = loadSqlResult($sql);

        if ($result['bloc'] == 1)
            return true;
        else
            return false;
    }

    public static function getLocalisation($map_id) {
        $sql = "SELECT cont.name FROM `mapworld` JOIN `continent` cont ON mapworld.continent = cont.id WHERE mapworld.id = $map_id";
        return loadSqlResult($sql);
    }

    public static function getPriceOfTeleportation($telep_id) {
        $sql = "SELECT gold_need FROM `teleporter` WHERE id=$telep_id";
        $result = loadSqlResult($sql);

        return $result;
    }

    public static function getRoomIdStatic($id) {
        $sql = "SELECT room_id FROM `mapworld` WHERE id=" . $id;
        $result = loadSqlResult($sql);

        return $result;
    }

    public static function isFreeStatic($abs, $ord, $map) {
        if (($abs > 0 && $abs <= 25) && ($ord > 0 && $ord <= 15)) {
            $sql = "SELECT bloc FROM map WHERE abs = '" . $abs . "' && ord = '" . $ord . "' && map = " . $map;
            if (loadSqlResult($sql)) {
                if (loadSqlResult($sql) == 1)
                    return false;
                else
                    return true;
            }else {
                return true;
            }
        } else {
            return false;
        }
    }

}

?>
