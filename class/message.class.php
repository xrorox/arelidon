<?php

class message {

    private $id;
// Infos joueurs	
    private $from;
    private $to;
// Contenu du message	
    private $title;
    private $message;
    private $time;

    function __construct() {
        $num = func_num_args();

        if (is_integer($num))
            $number = true;
        else
            $number = false;

        if (is_array($num))
            $array = true;
        else
            $array = false;

        if ($number)
            $this->loadMessage(func_get_arg(0));
        elseif ($array)
            $this->loadMessageByArray(func_get_arg(0));
    }

    function getId(){
        return $this->id;
    }
    
    function getTo(){
        return $this->to;
    }
    
    function getFrom() {
        return $this->from;
    }

    function getTime() {
        return $this->time;
    }

    function getTitle() {
        return html_entity_decode($this->title, ENT_QUOTES, "iso-8859-1");
    }

    function getMessage() {
        return html_entity_decode($this->message, ENT_QUOTES, "iso-8859-1");
    }

    function loadMessage($id) {
        $sql = "SELECT * FROM `messagerie` WHERE id = $id";
        $result = loadSqlResultArray($sql);

        $this->loadMessageByArray($result);
    }

    function loadMessageByArray($result) {
        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    function read($char) {
        $sql = "INSERT INTO `messagerie_read` (`char_id`,`message_id`) VALUES ('" . $char->getId() . "',$this->id)";
        loadSqlExecute($sql);
    }

    function isRead($char) {
        $sql = "SELECT message_id FROM messagerie_read WHERE char_id = '" . $char->getId() . "' AND message_id = $this->id";
        $id = loadSqlResult($sql);

        if ($id >= 1)
            return true;
        else
            return false;
    }

    function delete($char) {
        $sql = "INSERT INTO `messagerie_delete` (`char_id`,`message_id`) VALUES ('" . $char->getId() . "',$this->id)";
        loadSqlExecute($sql);
    }

    public static function addNewMessage($from, $to, $title, $message) {
        $time = time();
        $title = htmlentities($title, ENT_QUOTES);
        $message = htmlentities($message, ENT_QUOTES);

        $sql = "INSERT INTO messagerie (`from`,`to`,`title`,`message`,`time`) VALUES ('$from','$to','$title','$message','$time')";
        loadSqlExecute($sql);
    }

    public static function countMessageNoRead($char) {
        // Comptage des messages du jeu (from : 0 , to : 0) qui n'ont pas �t� lu ou supprim� par le joueur
        // S�lection des messages dans la boite qui sont ni dans la poubelle ni dans messages lus

        $sql2 = "SELECT COUNT(id) " .
                "FROM messagerie " .
                "WHERE `to` = '" . $char->getId() . "' " .
                "AND (SELECT COUNT(*) FROM messagerie_read WHERE message_id = messagerie.id AND char_id = '" . $char->getId() . "') = 0 " .
                "AND (SELECT COUNT(*) FROM messagerie_delete WHERE message_id = messagerie.id AND char_id = '" . $char->getId() . "') = 0";
        $result2 = loadSqlResult($sql2);

        return $result2;
    }

    public static function countMessageNoDelete($char) {
        $sql2 = "SELECT COUNT(id) FROM messagerie WHERE `to` = '" . $char->getId() . "' AND (SELECT COUNT(*) FROM messagerie_delete WHERE message_id = messagerie.id AND char_id = '" . $char->getId() . "') = 0";
        $result2 = loadSqlResult($sql2);

        $somme = $result2;
        return $somme;
    }

    public static function getAllMessage($char, $tri = 1, $min = 0, $max = 10) {
        /** Syst�me de tri : 
         * 
         * 1 : tous
         * 2 : uniquement messages des admins
         * 3 : messages d'un joueur de la guilde
         * 4 : messages de mes amis
         */
        switch ($tri) {
            case '1':
                //Tous			
                $sql = "SELECT * FROM messagerie m WHERE (`to` = '" . $char->getId() . "' OR `to` = '0') ";
                break;

            case '2':
                // Alertes
                $sql = "SELECT * FROM messagerie m WHERE m.title LIKE '%[Alerte]%' ";
                break;

            case '3':
                // message d'ar�lidon
                $sql = "SELECT * FROM messagerie m WHERE `to` = '0' ";
                break;

            case '4':
                // message de la guilde
                $sql = "SELECT m.* FROM messagerie m JOIN `char` ON m.from = char.id WHERE char.guild_id = $char->guild_id ";
                break;

            case '5':
                // Ceux des amis
                $sql = "SELECT m.* FROM messagerie m JOIN `friends` ON m.from = friends.friend_id JOIN `char` ON char.id = friends.friend_id WHERE char.guild_id = $char->guild_id ";
                break;
        }
        // Puis on filtre les messages est supprim�
        $array_return = array();

        $sql2 = "SELECT message_id FROM messagerie_delete WHERE char_id = '" . $char->getId() . "'";
        $arrays = loadSqlResultArrayList($sql2);
        $stillRead = array();

        if (count($arrays) > 0)
            foreach ($arrays as $array)
                $stillRead[] = $array['message_id'];

        if (count($stillRead) >= 1)
            $sql .= " AND m.id NOT IN (" . implode(',', $stillRead) . ")";

        $array_message = loadSqlResultArrayList($sql);
        if (count($array_message) > 0)
            foreach ($array_message as $message)
                $array_return[] = $message['id'];

        return $array_return;
    }

    public static function getAllMessageSend($char, $min = 0, $max = 10) {
        $sql = "SELECT id FROM messagerie WHERE `from` = '" . $char->getId() . "'";

        $sql2 = "SELECT message_id FROM messagerie_delete WHERE char_id = '" . $char->getId() . "'";
        $arrays = loadSqlResultArrayList($sql2);

        $stillRead = array();
        $array_return = array();

        if (count($arrays) > 0) {
            foreach ($arrays as $array)
                $stillRead[] = $array['message_id'];
        }

        if (count($stillRead) >= 1)
            $sql .= " AND messagerie.id NOT IN (" . implode(',', $stillRead) . ")";

        $array_message = loadSqlResultArrayList($sql);

        if (count($array_message)) {
            foreach ($array_message as $message)
                $array_return[] = $message['id'];
        }

        return $array_return;
    }

}

?>