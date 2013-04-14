<?php

class user {

    private $id;
    private $login;
    private $email;
    private $validmail;
    private $sponsor;
    private $subdate;
    private $moreChar;
    private $rank;

    function __construct() {
        $num = func_num_args();
        switch ($num) {
            case 1 :
                $this->loadUser(func_get_arg(0));
                break;
        }
    }

    function getId() {
        return $this->id;
    }

    function getLogin() {
        return $this->login;
    }

    function getMoreChar() {
        return $this->moreChar;
    }

    function getSponsor() {
        return $this->sponsor;
    }

    function getRank() {
        return $this->rank;
    }

    function setRank($rank) {
        $this->rank = $rank;
    }

    // Load the user with the ID
    function loadUser($id) {
        $sql = "SELECT * FROM `users` WHERE id = " . $id . " ";
        $result = loadSqlResultArray($sql);

        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
        $sql = "SELECT rank FROM `admin` WHERE iduser=" . $id;
        $result = loadSqlResultArray($sql);

        if (count($result) > 0)
            $this->setRank($result['rank']);
        else
            $this->setRank(0); // non admin.


            
// user::updateTime();
    }

    function getNumberChar() {
        $sql = "SELECT COUNT(id) FROM `char` WHERE idaccount =" . $this->getId();
        return loadSqlResult($sql);
    }

    function canCreateNewChar() {
        $numbers = $this->getNumberChar();

        if ($this->moreChar == 1)
            $max_char = 3;
        else
            $max_char = 2;

        if ($numbers < $max_char)
            return true;
        else
            return false;
    }

    function isAdmin() {

        $sql = "SELECT rank FROM `admin` WHERE `iduser` = '" . $this->getId() . "' ";
        $result = loadSqlResult($sql);

        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    // indique la faction des persos du joueur (permet d'interdire de cr�er un perso dans deux factions)
    function getRestricFaction() {
        $sql = "SELECT faction FROM `char` WHERE idaccount = " . $this->getId() . " LIMIT 1";
        $result = loadSqlResult($sql);

        if ($result == '' or $this->isAdmin())
            $result = 0;

        return $result;
    }

    function getNumberSponsored() {
        $result = get_cache('sponsor', 'sponsor_' . $this->getId());
        if (is_bool($result)) {
            $sql = "SELECT COUNT(*) FROM `users` WHERE sponsor = '" . $this->getId() . "'";
            $result = loadSqlResult($sql);
            create_cache('sponsor', 'sponsor_' . $this->getId(), $result);
        }
        return $result;
    }

    // Return the list of sponsored
    function getSponsoredList() {
        $sql = "SELECT * FROM `users` WHERE sponsor = '" . $this->getId() . "'";
        $result = loadSqlResultArrayList($sql);

        foreach ($result as $res) {
            $sql = "SELECT COUNT(*) 
					FROM `log_connection` lg JOIN `char` c ON lg.id = c.id 
					WHERE c.idaccount = '" . $res['id'] . "'";
            $final_array[$res['login']] = loadSqlResult($sql) * 10;
        }

        return $final_array;
    }

    // Get the number of sponsored for a user 
    public static function getNumberSponsoredById($id) {
        $result = get_cache('sponsor', 'sponsor_' . $id);
        if (is_bool($result)) {
            $sql = "SELECT COUNT(*) FROM `users` WHERE sponsor = '" . $id . "'";
            $result = loadSqlResult($sql);
            create_cache('sponsor', 'sponsor_' . $id, $result);
        }
        return $result;
    }

    // Add a new user in the base
    public static function addUser($login, $password, $email, $sponsor) {

        if ($sponsor != '') {
            $sponsor = user::getIdByLogin($sponsor);
        }

        $sql = "INSERT INTO users (`login`,`password`,`email`,`sponsor`,`subdate`) VALUES ('$login','".md5(md5($password))."','$email','$sponsor',CURRENT_DATE);";
        loadSqlExecute($sql);
        destroy_cache('user', 'user_nbr');
        destroy_cache('sponsor', 'sponsor' . $sponsor);
    }

    public static function getLoginById($id) {
        $sql = "SELECT login FROM `users` WHERE `id` = $id ";
        return loadSqlResult($sql);
    }

    public static function getIdByLogin($login) {
        $sql = "SELECT id FROM `users` WHERE `login` = '" . $login . "' ";
        return loadSqlResult($sql);
    }

    public static function getListPlayersOnline($limite = 300, $account_id = 0) {
        $timelimit = time() - $limite;
        $sql = "SELECT * FROM `char` WHERE time_connexion >= $timelimit ";

        if ($account_id != 0) {
            $sql .= " AND idaccount = $account_id ";
        }
        $sql .= "ORDER BY faction ASC,LEVEL DESC";


        return loadSqlResultArrayList($sql);
    }

    public static function getPlayersOnline($limite = 300) {
        $timelimit = time() - $limite;
        $sql = "SELECT COUNT(id) FROM `char` WHERE time_connexion >= $timelimit";

        return loadSqlResult($sql);
    }

    /** Détermine su l'utilisateur existe.
     * 
     * @param type $login
     * @return boolean
     */
    public static function exist($login) {
        $sql = "SELECT count(*) FROM users WHERE login = '" . $login . "' ";
        $nbuser = loadSqlResult($sql);

        if ($nbuser == 1)
            return true;

        return false;
    }

    /** Détermine si l'utilisateur est capable de se connecter.
     * 
     * @param type $login
     * @param type $password
     * @return \user|boolean
     */
    public static function isAbleToLogin($login, $password) {
        $sql = "SELECT id,password FROM `users` WHERE login = '$login' ";
        $st = loadSqlResultArray($sql);
        $user = new user($st['id']);


        $mdpverif = $st['password'];

        if ($mdpverif == md5(md5($password)))
            return $user;

        return false;
    }

}

?>