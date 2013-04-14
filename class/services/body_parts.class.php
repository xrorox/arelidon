<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of body_parts
 *
 * @author romain
 */
class body_parts {

    static function getAllBodyParts() {
        $sql = "SELECT * FROM body_parts WHERE id != 3 ORDER BY id";
        return loadSqlResultArrayList($sql);
    }

    static function getEquipShowStyle($type, $otherthanposition = true) {
        switch ($type) {
            case 'main gauche':
                $marginLeft = '27';
                $marginTop = '80';
                break;
            case 'main droite':
                $marginLeft = '92';
                $marginTop = '80';
                break;
            case 'deux mains':
                $marginLeft = '27';
                $marginTop = '80';
                break;
            case 't&ecirc;te':
                $marginLeft = '57';
                $marginTop = '2';
                break;
            case 'armure':
                $marginLeft = '60';
                $marginTop = '45';
                break;
            case 'ceinture':
                $marginLeft = '60';
                $marginTop = '95';
                break;
            case 'bottes':
                $marginLeft = '60';
                $marginTop = '195';
                break;
            // gants
            case 'gants':
                $marginLeft = '20';
                $marginTop = '117';
                break;
            case 'anneaux':
                $marginLeft = '99';
                $marginTop = '117';
                break;
            case 'collier':
                $marginLeft = '92';
                $marginTop = '2';
                break;
        }
        if ($otherthanposition)
            $style = "border:solid 1 px red;margin-left:" . $marginLeft . "px;margin-top:" . $marginTop . "px;background-color:white;border:solid 1px black;position:absolute;";
        else
            $style = "margin-left:" . $marginLeft . "px;margin-top:" . $marginTop . "px;position:absolute;";
        return $style;
    }

}

?>
