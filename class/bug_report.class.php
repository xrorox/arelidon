<?php

class bug_report {

    private $id;

    /**
     * Type :
     * 
     * 1=> Affichage
     * 2=> Problème du jeu
     * 3=> Faute d'orthographes
     * 4=> Autre
     */
    private $type;
    private $comment;
    private $file;
    private $timestamp;

    function __construct() {
        $num = func_num_args();
        switch ($num) {
            case 1 :
                $this->loadBugReport(func_get_arg(0));
                break;
        }
    }

    function loadBugReport() {
        
    }

    function setType($type) {
        $this->type = $type;
    }

    function getType() {
        return $this->type;
    }

    function setComment($comment) {
        $this->comment = $comment;
    }

    function getComment() {
        return $this->comment;
    }

    function setFile($file) {
        $this->file = $file;
    }

    function getFile() {
        return $this->file;
    }

    function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    function getTimestamp() {
        return $this->timestamp;
    }

    function save($char) {
        $time = time();
        $navigator = $_SERVER["HTTP_USER_AGENT"];
        $comment = htmlentities($this->comment, ENT_QUOTES);
        $sql = "INSERT INTO `bug_report` (`char_id`,`type_bug`,`comment`,`file`,`navigator`,`timestamp`) VALUES ('" . $char->getId() . "',$this->type,'$comment','$this->file','$navigator',$time);";
        loadSqlExecute($sql);
    }

    function getLastId() {
        $sql = "SELECT id FROM `bug_report` ORDER BY id DESC LIMIT 1";
        return loadSqlResult($sql);
    }

    public static function getAllBugReport($select = '*', $min = 0, $max = 15) {
        $sql = "SELECT $select FROM `bug_report` LIMIT $min,$max";
        return loadSqlResultArrayList($sql);
    }

    public static function deleteBugReport($idBugReport) {

        $sql = "DELETE FROM `bug_report` WHERE `id`=" . $idBugReport;
        loadSqlExecute($sql);
    }

}

?>