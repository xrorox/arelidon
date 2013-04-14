<?php

class skill {

// Infos du sort	
    private $id;
    private $name;
    private $description;
    private $classe_req;

    /**
     *  Arg Typesort : 
     * 		1 : sort d'attaque
     * 		2 : soin
     * 		3 : buff
     * 		4 : malédiction
     * 		5 : passif
     */
    private $typesort;
    private $damage;

    /* 0 = neutre
     * 1 = feu
     * 2 = eau/glace
     * 3 = air
     * 4 = terre
     * 5 = sacré
     * 6 = poison
     */
    private $typedmg;
    // Utilisé pour les passifs
    private $str;
    private $con;
    private $dex;
    private $int;
    private $sag;
    private $res;
    private $str_needed;
    private $con_needed;
    private $dex_needed;
    private $int_needed;
    private $sag_needed;
    private $res_needed;
    private $effect_needed;
    // Coût en mana du sort
    private $mana;
    // Coût en PA
    /* TODO */
    private $PA = 3;
    // Chance de lancer un effet
    private $number_effects;
    private $effect_id;
    // Useless ?
    private $effect_cible;
    private $usable_on_himself;
    private $usable_on_ally;
    private $can_rez;

//   ------------------------Fonctions de chargement d'un skill
    function __construct() {

        $num = func_get_arg(0);

        if (intval($num) > 0)
            $number = true;
        else
            $number = false;

        if (is_array($num))
            $array = true;
        else
            $array = false;

        if ($number)
            $this->loadSkill(func_get_arg(0));
        elseif ($array)
            $this->loadSkillByArray(func_get_arg(0));
    }

    function loadSkill($skill_id = 0) {
        $sql = "SELECT SQL_SMALL_RESULT SQL_CACHE * FROM `skill` WHERE `id` = $skill_id";
        $result = loadSqlResultArray($sql);


        $this->loadSkillByArray($result);
    }

    private function loadSkillByArray($array) {
        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
    }

    function loadSkillInfoMonster($id, $levelskill) {
        if ($id != 0)
            $this->loadSkill($id);

        $this->level = $levelskill;
    }

    function getNumberEffects() {
        return $this->number_effects;
    }

    public function getSkillInfo() {

        $sql = "SELECT * FROM `skill`";
        $result = loadSqlResultArrayList($sql);

        return $result;
    }

    public static function getAllSkill($all = 0, $min = 0, $max = 999) {
        $sql = "SELECT * FROM `skill` WHERE skill_monster = 0";
        $array = loadSqlResultArrayList($sql);

        return $array;
    }

    public function getIdByName($name) {
        $name = htmlentities($name);
        $name = addslashes($name);
        $sql = "SELECT id FROM skill WHERE name = '$name'";
        return loadSqlResult($sql);
    }

    function isCharAbleToLearnThisSpell($char) {
        $array = getCaractList(0);

        foreach ($array as $carac) {
            $carac_name = $carac . "_needed";

            if ($char->getCaract($carac) < $this->$carac_name)
                return false;
        }

        return true;
    }

    function canBeLaunchByFighter($fighter) {
        return $this->isCharAbleToLearnThisSpell($fighter->getInstance()->getChar());
    }

//-----------------------------------Fonctions déterminant si on peut lancer un sort ou non --------------------------
//Méthode interface sur laquelle on mettra les tests unitaires.
    public function canBeLaunched($fighter, $fighter_target) {
        return $this->canBeLaunchOnFighter($fighter_target, $fighter);
    }

//Détermine la relation entre les combattants. Et fait appel à la bonne fonction pour checjer les résultats.
//Une fonction gérant les spécifités (soi même, allié, ennemi). Plus simple à maintenir.
    private function canBeLaunchOnFighter($fighter_target, $fighter) {
        //On détermine si on lance sur soit même ou un allié ou un ennemi.
        //Case 1 =soit même
        //Case 2 = un allié.
        //Case 3 = ennemi.
        if ($fighter_target->getPlace() == $fighter->getPlace())
            $case = 1;
        elseif ($fighter_target->getPlace() != $fighter->getPlace() && $fighter_target->getTeam() == $fighter->getTeam())
            $case = 2;
        elseif ($fighter_target->getTeam() != $fighter->getTeam())
            $case = 3;
        else
            return false;


        switch ($case) {
            case 1: //Sort sur moi même
                return $this->canBeLaunchedOnMyself($fighter);
                break;

            case 2: // Sort sur un allié
                return $this->canBeLaunchedOnAlly($fighter_target, $fighter);
                break;

            Case 3: //Sort sur un ennemi.
                return $this->canBeLaunchedOnOpponent($fighter_target, $fighter);
                break;
        }
    }

//Vérifie qu'on peut lancer un sort sur soi même. Et qu'on est vivant.
    private function canBeLaunchedOnMyself($fighter) {
        //Non non, lydéric tu ne te lanceras pas une boule de feu dans la gueule.
        if (!$this->usable_on_himself)
            return false;

        //Lydéric tu n'es pas khartus. Pa contre tu devrais fuir avant que floflo arrive. Y a plus de cerfs morts dans la foret.
        if ($fighter->getLife() <= 0)
            return false;

        return $this->commonChecksForUsingSpell($fighter, $fighter);
    }

//Vérifies qu'on peut lancer ce sort sur un allié. S'il est mort mais que le sort peut pas rez on jette aussi.
    private function canBeLaunchedOnAlly($fighter_target, $fighter) {
        //Non lydéric pas de boule de feu sur flo quand il est dans ton équipe. Tu attends d'avoir perdu !! 
        if (!$this->usable_on_ally)
            return false;

        if ($fighter_target->getLife() <= 0 && !$this->can_rez)
            return false;

        return $this->commonChecksForUsingSpell($fighter_target, $fighter);
    }

//Vérifie que l'ennemi est vivant. Et qu'on jette pas un sort bénéfique.
    private function canBeLaunchedOnOpponent($fighter_target, $fighter) {
        //C'est pas bloodbowl on s'acharne pas sur les cadavres.
        if ($fighter_target->getLife() <= 0)
            return false;


        //Non lydéric les sorts gentils c'est pour ton équipe.
        if ($this->usable_on_ally || $this->usable_on_himself || $this->can_rez)
            return false;

        return $this->commonChecksForUsingSpell($fighter_target, $fighter);
    }

//Vérifications communes à tous les relations entre combattants. On checke mana + pa.
    private function commonChecksForUsingSpell($fighter_target, $fighter) {
        //Check si un effet est nécéssaire.
        if ($this->effect_needed > 0) {
            if (!$fighter_target->isUnderThisEffect($this->effect_needed))
                return false;
        }


        //Pas mana byebye vil coyote.
        if ($fighter->getMana() < $this->mana)
            return false;

        //Pas de PA, bip bip vil coyote.
        if ($fighter->getPA() < $this->PA)
            return false;

        return true;
    }

//----------------------------------Fonctions de calcul des dommages ---------------------------------
    public function getDamage($fighter_launcher, $fighter_target) {
        $resistance = $fighter_target->getResistancePercentage($this->typedmg);
        if ($this->usable_on_ally || $this->usable_on_himself || $this->can_rez)
            $resistance = 0;

        $damage_complete = $this->getPureDamage($fighter_launcher);

        $damage = $damage_complete - ($damage_complete * $resistance) / 100;

        return $damage;
    }

    private function getPureDamage($fighter_launcher) {
        $damage_rates = $this->getDamageRate();

        $pure_damage = $this->damage;

        if (is_array($damage_rates)) {
            foreach ($damage_rates as $damage_rate) {
                $pure_damage += ($fighter_launcher->getCaract($damage_rate['caract']) * $damage_rate['rate']);
            }
        }
        return $pure_damage;
    }

    private function getDamageRate() {
        $sql = "SELECT rate,caract FROM `skills_caracts` WHERE skill_id=" . $this->id;
        return loadSqlResultArrayList($sql);
    }

// ---------------------------Fonctions privées ---------------------------------------------------------

    private function hasEnoughPa($fighter) {
        if ($fighter->getPa() >= 1)
            return true;
        else
            return false;
    }

    private function hasEnoughMana($fighter) {
        if ($fighter->getMana() >= $this->getManaCost())
            return true;
        else
            return false;
    }

// ---------------------------- Fonction statiques -------------------------------------------------------

    public static function getNameById($id) {
        $sql = "SELECT name FROM skill WHERE id = '$id'";
        return loadSqlResult($sql);
    }

    public static function getAllSkillForChar($char) {
        $sql = "SELECT s.* FROM `skills` AS s LEFT JOIN `skillonchar` AS so
        ON so.skill_id = s.id WHERE so.char_id=" . $char->getId();

        return loadSqlResultArrayList($sql);
    }

//Retourne la totalité des skills pour une classe.
    public static function getAllSkillForClasse($class_id) {
        $sql = "SELECT skill.* FROM `skills` AS skill 
            LEFT JOIN `classes_skills` AS c ON skill.id = c.skill_id
            WHERE c.classe_id =" . $class_id;

        return loadSqlResultArrayList($sql);
    }

// ---------------------------------- Getters / Setters -------------------------------------------------
    function getClasse_req() {
        return $this->classe_req;
    }

    function getLevel() {
        return $this->level;
    }

    function getLevelReq() {
        return $this->lvlreq;
    }

    function getEffectId() {
        return $this->effect_id;
    }

    function getEffectCible() {
        return $this->effect_cible;
    }

    function getEffectPourcent() {
        return $this->effect_pourcent;
    }

    function getUsableOnHimself() {
        return $this->usable_on_himself;
    }

    function getUsableOnAlly() {
        return $this->usable_on_ally;
    }

    function getCanRez() {
        return $this->can_rez;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getTypeSort() {
        return $this->typesort;
    }

    function getElement() {
        return $this->typedmg;
    }

    function getTypedmg() {
        return $this->typedmg;
    }

    function getDescription() {
        // On remplace les %caract dans la description par leurs valeurs selon le niveau

        $description = $this->description;

        $array = getCaractList('1', '1', '1');
        foreach ($array as $caract) {
            $search_string = '%' . $caract;
            $iCpt = substr_count($description, $search_string);

            if ($iCpt >= 1) {
                $pl_caract = 'pl_' . $caract;

                $value = $this->$caract;

                $value = round($value);
                if ($value < 0)
                    $value = -1 * $value;

                $description = str_replace($search_string, $value, $description);
            }
        }

        return $description;
    }

    function getManaCost() {
        return $this->mana;
    }

    function getPA() {
        return $this->PA;
    }

}

?>