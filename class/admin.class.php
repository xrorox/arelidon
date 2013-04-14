<?php

class admin {

    private $rank;

    function __construct() {
        $num = func_num_args();
        switch ($num) {
            case 1 :
                $this->setRank(func_get_arg(0));
                break;
        }
    }

    function getRank() {
        return $this->rank;
    }

    function setRank($rank) {
        return $this->rank = $rank;
    }

    function getAllMenu($rank) {
        $arrayMenu = array();

        $sql = "SELECT * FROM `admin_dashboard` ORDER BY category,name";
        $result = loadSqlResultArrayList($sql);


        foreach ($result as $row) {
            if ($rank >= $row['rankmin']) {
                $info = array();
                $info['category'] = $row['category'];
                $info['name'] = $row['name'];
                $arrayMenu[$row['ref']] = $info;
            }
        }
        return $arrayMenu;
    }

    static public function isInMaintenance() {

        $sql = "SELECT maintenance FROM `maintenance`";
        $result = loadSqlResult($sql);

        if ($result == 0) {
            return false;
        } elseif ($result == 1) {
            return true;
        }
    }

    public static function grantPaToEveryOne($number = 0) {
        try {


            $sql = "SELECT id,pa FROM `char`";
            $arrayofarray = loadSqlResultArrayList($sql);

            foreach ($arrayofarray as $array) {
                $pa = $array['pa'] + $_POST['PA'];

                $sql = "UPDATE `char` SET  pa = $pa WHERE id= " . $array['id'];

                loadSqlExecute($sql);
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function setMaintenance($maint = 0) {
        $sql = "UPDATE `maintenance` SET maintenance =" . $maint;

        loadSqlExecute($sql);
        destroy_cache('maintenance', 'maintenance');
    }

}

?>