<?php

class PDO2 extends PDO {

    private static $_instance;

 
    // End of PDO2::__construct() */

    /* Singleton */
    public static function connect() {

        if (!isset(self::$_instance)) {

            $host = 'localhost';    // Votre identifiant
            $user = 'root';     // Votre identifant 
            $mdp = '';     // Votre mot de passe
            $base = 'royaume-arelidon';     // Nom de botre base   
            $port = '3306';
            self::$_instance = new PDO2('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $base, $user, $mdp);
        }
        return self::$_instance;
    }

    // End of PDO2::getInstance() */

    function loadSqlExecute($sql) {
        $this->exec($sql);
    }

    function loadSqlResult($sql) {
        $result = $this->query($sql);

        $count = is_object($result);
        if ($count)
            return $result->fetch(PDO::FETCH_NUM);
    }

    function loadSqlResultArray($sql) {

        $retval = array();

        $resultats = $this->query($sql);

        $count = is_object($resultats);
        if ($count) {
            $row = $resultats->fetch(PDO::FETCH_ASSOC);

            $resultats->closeCursor();
            return $row;
        }
    }

    function loadSqlResultArrayList($sql) {
        $retval = array();

        $resultats = $this->query($sql);

        $bool = is_object($resultats);
        if ($bool) {
            $count = $resultats->rowCount();
            if ($count >= 1) {
                while ($row = $resultats->fetch(PDO::FETCH_ASSOC)) {
                    $retval[] = $row;
                }

                $resultats->closeCursor();
                return $retval;
            }
        }
    }

}

?>