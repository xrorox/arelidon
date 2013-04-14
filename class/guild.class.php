<?php

class guild {

    private $id;
// Membre
    private $meneur;
    private $lord_list;
    private $paysan_list;
    private $member_list;
// Infos sur la guilde

    private $name;
    // Prix d'entr�e
    private $price;
    private $description;
    private $level;
    private $number_member;
    private $gold;
    private $forum;
    private $date_creation;
    private $arrayActivities;

    function __construct() {
        $this->loadGuild(func_get_arg(0));
    }

    function getForum() {
        return $this->forum;
    }

    function setForum($forum) {
        $this->forum = $forum;
    }

    function getLevel() {
        return $this->level;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getNameMaxLength() {
        $this->name = html_entity_decode($this->name, ENT_QUOTES, "UTF-8");

        if (strlen($this->name) > 22) {
            $name = substr($this->name, 0, 22);
            $name = $name . ".";
        } else {
            $name = $this->name;
        }

        return $name;
    }

    function getDescription() {
        $str = cleanAccent($this->description);
        $str = html_entity_decode($str);
        return $str;
    }

    function getDateCreation() {
        return $this->date_creation;
    }

    function getGold() {
        return $this->gold;
    }

    function getMeneur() {

        return $this->meneur;
    }

    function loadGuild($id) {
        $sql = "SELECT SQL_CACHE * FROM guild WHERE id = $id";
        $result = loadSqlResultArray($sql);

        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }

        $this->checkLevelUp();
    }

    function add($meneur, $name) {
        $name = htmlentities($name, ENT_QUOTES, 'UTF-8');
        $sql = "INSERT INTO guild (`name`,`meneur`,`level`,`price`,`gold`,`date_creation`) VALUES ('$name','$meneur','1','100','250','" . time() . "')";
        loadSqlExecute($sql);

        $sql = "SELECT id FROM guild WHERE name = '$name' && meneur = '$meneur'";
        $result = loadSqlResult($sql);

        $this->loadGuild($result);
        $this->addUserToGuild(new char($meneur));
    }

    function addUserToGuild($char) {
        $char->update('guild_id', $this->id);
    }

    function update($row, $value) {
        if ($row == "description")
            $value = htmlentities($value, ENT_QUOTES);

        $sql = "UPDATE guild SET " . $row . " = '" . $value . "' WHERE id = " . $this->getId();
        loadSqlExecute($sql);
    }

    function isFree($name) {
        $name = htmlentities($name, ENT_QUOTES);
        $sql = "SELECT COUNT(id) FROM guild WHERE name = '$name'";
        $count = loadSqlResult($sql);

        if ($count >= 1)
            return true;
        else
            return false;
    }

    function getMembersNumber() {
        $sql = "SELECT COUNT(id) FROM `char` WHERE `guild_id` = " . $this->getId();
        return loadSqlResult($sql);
    }

    function getMaxMembers() {
        return $this->getLevel() * 3 + 3;
    }

    function getGoldToLevelUp() {
        return (($this->getLevel() * $this->getLevel()) - 1) * 2000 + 3000;
    }

    function noFull() {
        $count = $this->getMembersNumber();
        if ($count >= $this->getMaxMembers())
            return false;
        else
            return true;
    }

    function getMemberList($rank = 0) {
        $sql = "SELECT id FROM `char` WHERE guild_id = " . $this->getId();
        if ($rank > 0)
            $sql .= " AND guild_rank = '$rank'";
        $result = loadSqlResultArrayList($sql);

        $member_list = array();

        if (count($result) > 0) {
            foreach ($result as $member)
                $member_list[] = $member['id'];
        }

        return $member_list;
    }

    function getLordList() {
        return $this->getMemberList(1);
    }

    function countLord() {
        $sql = "SELECT COUNT(*) FROM `char` WHERE guild_id = '" . $this->getId() . "' AND guild_rank = '1' ";
        return loadSqlResult($sql);
    }

    function getPaysanList() {
        return $this->getMemberList(2);
    }

    function countPaysan() {
        $sql = "SELECT COUNT(*) FROM `char` WHERE guild_id = '" . $this->getId() . "' AND guild_rank = '2' ";
        return loadSqlResult($sql);
    }

// Gestion des membres

    function addMember($char) {
        $char->update('guild_id', $this->getId());
        $char->update('guild_rank', 2);
        $this->addActivity($char->getId(), 1, 0);
    }

    /*
     * $banorquit = 2 si le joueur est partie et 3 s'il a �t� banni
     * 
     */

    public function deleteMember($char, $banOrQuit = 0) {
        $char->update('guild_id', 0);
        $char->update('guild_rank', 0);
        $this->addActivity($char->getId(), $banOrQuit, 0);
    }

    function checkLevelUp() {
        if ($this->getMembersNumber() >= $this->getMaxMembers())
            if ($this->getNbDays() >= $this->getNbDaysToLevelUp())
                if ($this->getGold() >= $this->getGoldToLevelUp())
                    $this->levelUp();
    }

// Mont�e de niveau de la guilde
    function levelUp() {
        $new_level = $this->level + 1;
        $this->level = $new_level;

        $this->update('level', $new_level);

        $this->addActivity(0, 7, 0);
    }

// gestion des candidatures

    function getCandidatures() {
        $sql = "SELECT * FROM `guild_candidature` WHERE guild_id = " . $this->getId();
        return loadSqlResultArrayList($sql);
    }

    function createCandidature($char, $message) {
        $message = htmlentities($message, ENT_QUOTES);
        $sql = "INSERT INTO guild_candidature (`guild_id`,`char_id`,`message`,`timestamp`) VALUES ('" . $this->getId() . "','" . $char->getId() . "','$message','" . time() . "')";
        loadSqlExecute($sql);
    }

    function deleteCandidature($char) {
        $sql = "DELETE FROM `guild_candidature` WHERE char_id = " . $char->getId() . " AND guild_id =" . $this->getId();
        loadSqlExecute($sql);
    }

    function accepteCandidature($char) {
        $this->addMember($char);
        // On supprime toutes les candidatures (s�curit� �viter qu'un autre meneur accepte une autre candidature')
        $sql = "DELETE FROM `guild_candidature` WHERE char_id = " . $char->getId();
        loadSqlExecute($sql);
    }

// Gestion de la messagerie
    function getLastMessage() {
        $nb_message = 20;
        $sql = "SELECT * FROM `guild_wall` WHERE guild_id = " . $this->getId() . " ORDER BY timestamp DESC LIMIT 0 , $nb_message ";
        return loadSqlResultArrayList($sql);
    }

    function addMessage($char, $message) {
        $message = htmlentities($message, ENT_QUOTES);
        $time = time();
        $sql = "INSERT INTO `guild_wall` (`char_id`,`guild_id`,`message`,`timestamp`) VALUES ('" . $char->getId() . "','" . $this->getId() . "','$message','$time');";
        loadSqlExecute($sql);
    }

    function deleteMessage($message_id) {
        $sql = "DELETE FROM `guild_wall` WHERE id = $message_id";
        loadSqlExecute($sql);
    }

    /**
     * 
     * 1 => un joueur entre dans la guilde 
     * 2 => un joueur quitte la guilde 
     * 3 => un joueur a �t� ban de la guilde 
     * 4 => un joueur a eu une promotion 
     * 5 => un joueur a �t� retrograd�
     * 6 => un joueur a donn� de l'or � la guilde
     * 7 => la guilde est mont�e d'un niveau
     */
    function addActivity($char_id, $activity, $value) {
        $time = time();
        $sql = "INSERT INTO guild_activity (timestamp,guild_id,char_id,activity,value) VALUES ";
        $sql .= "($time," . $this->getId() . ",$char_id,$activity,'$value')";

        loadSqlExecute($sql);
    }

    function donation($char, $donation) {
        if ($donation > 0 && $char->getGold() >= $donation) {
            $new_gold = $this->getGold() + $donation;
            $this->update('gold', $new_gold);

            $char->updateMore('gold', $donation * -1);
            $this->addActivity($char->getId(), 6, $donation);
        } else {
            echo 'Probleme';
        }
    }

    public function setTimeStamp() {
        $sql = "UPDATE `guild` SET date_creation=" . Time() . " WHERE id=" . $this->getId();
        LoadSqlExecute($sql);
    }

    public function getNbDays() {
        $sql = "SELECT date_creation FROM `guild` WHERE id=" . $this->getId();
        $date_creation = loadSqlResult($sql);

        $Nbjours = Time() - $date_creation['date_creation'];
        $Nbjours = round($Nbjours / (3600 * 24));
        return $Nbjours;
    }

    public function getNbDaysToLevelUp() {
        $days = $this->getLevel() * 15 + ($this->getLevel() * 5);
        return $days;
    }

    public function getActivities() {
        $sql = "SELECT * FROM `guild_activity` WHERE guild_id=" . $this->getId() . " ORDER BY timestamp DESC";
        $result = loadSqlResultArrayList($sql);
        return $result;
    }

    public function selectActivities($activity, $char_id, $timestamp, $value) {

        $format = "d/m/Y";
        $date = date($format, $timestamp);
        switch ($activity) {
            case 1:
                $echo = $date . '  Le joueur ' . char::getNameById($char_id) . ' est entr&eacute; dans la guilde.';
                break;
            case 2:
                $echo = $date . '  Le joueur ' . char::getNameById($char_id) . ' a quitt&eacute; la guilde.';
                break;
            case 3:
                $echo = $date . '  Le joueur ' . char::getNameById($char_id) . ' a &eacute;t&eacute; banni de la guilde.';
                break;
            case 4:
                $echo = $date . '  Le joueur ' . char::getNameById($char_id) . ' a &eacute;t&eacute; promu.';
                break;
            case 5:
                $echo = $date . '  Le joueur ' . char::getNameById($char_id) . ' a &eacute;t&eacute; r&eacute;trograd&eacute;.';
                break;
            case 6:
                $echo = $date . '  Le joueur ' . char::getNameById($char_id) . ' a donn&eacute; ' . $value . ' <img src="pictures/icones/dondor.gif" title="pi&egrave;ces d\'or" alt="pi&egrave;ces d\'or" style="widht:18px;height:18px;" /> &agrave; la guilde';
                break;
            case 7:
                $echo = $date . '  La guilde est mont&eacute;e d\'un niveau !';
                break;
            default :
                $echo = '';
                break;
        }

        return $echo;
    }

    public function destroyGuildAndAll($guild_id) {

        $this->delete_guild($guild_id);
        $this->delete_guild_activities($guild_id);
        $this->delete_guild_donation($guild_id);
        $this->delete_all_member_guild($guild_id);
        $echo = "La guilde a bien &eacute;t&eacute; supprim�e !!!";

        return $echo;
    }

    public function delete_guild($guild_id) {
        $sql = "DELETE FROM `guild` WHERE id=" . $guild_id;
        loadSqlExecute($sql);
    }

    public function delete_guild_activities($guild_id) {
        $sql = "DELETE FROM `guild_activity` WHERE guild_id=" . $guild_id;
        loadSqlExecute($sql);
    }

    public function delete_guild_donation($guild_id) {
        $sql = "DELETE FROM `guild_donation` WHERE guild_id=" . $guild_id;
        loadSqlExecute($sql);
    }

    public function delete_all_member_guild($guild_id) {
        $sql = "UPDATE `char` SET guild_id = 0 WHERE guild_id=" . $guild_id;
        loadSqlExecute($sql);
    }

    public function get_guild_picture() {
        $echo = '<img style="margin:auto;" src="pictures/guilde/' . char::testExtension($this->getId()) . '" alt="pas d\'image pour cette guilde" style="width:120px;height:120px;margin:auto;"  />';

        return $echo;
    }

    public function isExtAuthorized($ext) {
        $AUTH_EXT = array(".png", ".gif", ".bmp", ".jpg", ".jpeg");
        if (in_array($ext, $AUTH_EXT)) {
            return true;
        } else {
            return false;
        }
    }

    public function isSizeValid($size) {

        if ($size <= 100000) {

            return true;
        } else {
            return false;
        }
    }

    public function isGuildPictureValid($ext, $size) {
        if ($this->isExtAuthorized($ext)) {
            if ($this->isSizeValid($size)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function delete_guild_pictures($guild_id) {
        if (file_exists("pictures/guilde/" . $guild_id . ".png")) {
            unlink("pictures/guilde/" . $guild_id . ".png");
        } elseif (file_exists("pictures/guilde/" . $guild_id . ".gif")) {
            unlink("pictures/guilde/" . $guild_id . ".gif");
        } elseif (file_exists("pictures/guilde/" . $guild_id . ".bmp")) {
            unlink("pictures/guilde/" . $guild_id . ".bmp");
        } elseif (file_exists("pictures/guilde/" . $guild_id . ".jpg")) {
            unlink("pictures/guilde/" . $guild_id . ".jpg");
        } elseif (file_exists("pictures/guilde/" . $guild_id . ".jpeg")) {
            unlink("pictures/guilde/" . $guild_id . ".jpeg");
        }
    }

// Fonctions Statiques

    public static function getAllGuild($faction) {
        $sql = "SELECT guild.id,guild.name FROM guild JOIN `char` ON guild.meneur = char.id WHERE char.faction = $faction";
        $result = loadSqlResultArrayList($sql);
        return $result;
    }

    public static function getMeneurIdStatic($guild_id) {
        $sql = "SELECT SQL_CACHE meneur FROM `guild` WHERE id=" . $guild_id;
        return loadSqlResult($sql);
    }

    public static function getNameById($id) {
        $sql = "SELECT name FROM guild WHERE id = $id";
        $return = loadSqlResult($sql);
        if ($return == '') {
            $return = "Pas de guilde";
        }
        return $return;
    }

}

?>