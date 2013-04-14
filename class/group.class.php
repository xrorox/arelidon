<?php

class group {

    private $id;
    private $leader;
    private $membersList;

    /*
     * Partage : 
     * 1 : par niveau (d�faut)
     * 2 : �gale
     * 3 : chacun pour soi
     */
    private $shareGold;
    private $shareExp;

    function __construct() {

        $num = func_get_arg(0);
        if (is_integer($num))
            $number = true;
        else
            $number = false;

        if (is_object($num))
            $object = true;
        else
            $object = false;

        if ($number)
            $this->loadGroup(func_get_arg(0));
        elseif ($object)
            $this->loadGroupByChar(func_get_arg(0));
    }

    function getId() {
        return $this->id;
    }

    function getLeader() {
        return $this->leader;
    }

    function loadMembersList() {
        $sql = "SELECT * FROM char WHERE group_id = '" . $this->id . "'";
        $result = loadSqlResultArrayList($sql);
        $i = 0;

        if (count($result) > 0) {
            foreach ($result as $char_array) {
                $char = new char($char_array);
                $array[$i] = $char;
                $i++;
            }
            $this->membersList = $array;
        }
    }

    function getMembersList() {
        return $this->membersList;
    }

    function setShareExp($shareExp) {
        $this->shareExp = $shareExp;
        $this->update('share_exp', $shareExp);
    }

    function getShareExp() {
        return $this->shareExp;
    }

    function setShareGold($shareGold) {
        $this->shareGold = $shareGold;
        $this->update('share_gold', $shareGold);
    }

    function getShareGold() {
        return $this->shareGold;
    }

    function getShareText($share) {
        switch ($share) {
            case 1:
                $str = 'par niveau';
                break;
            case 2:
                $str = '&eacute;gale';
                break;
            case 3:
                $str = 'chacun pour soi';
                break;
        }

        return $str;
    }

    function loadGroupByChar($char) {
        if ($char->getGroupId() > 0) {
            $sql = "SELECT * FROM `group` WHERE id = " . $char->getGroupId();
            $result = loadSqlResultArray($sql);

            if (count($result) > 0 and $result != '') {
                foreach ($result as $key => $value) {
                    $this->$key = $value;
                }
            }

            $this->loadMembersList();
        }
    }

    function loadGroup($group_id) {
        if ($group_id > 0) {
            $sql = "SELECT * FROM `group` WHERE id = " . $group_id;
            $result = loadSqlResultArray($sql);

            if (count($result) > 0 and $result != '') {
                foreach ($result as $key => $value) {
                    $this->$key = $value;
                }
            }

            $this->loadMembersList();
        }
    }

    function update($row, $value) {
        $sql = "UPDATE `group` SET $row = '$value' WHERE id = '" . $this->id . "' ";
        loadSqlExecute($sql);
    }

    function getNumberInGroup() {
        return count($this->getMembersList());
    }

    function testLevel($leader) {

        $level1 = char::getLevelbyId($leader);
        $level2 = $char->getLevel();

        if ($level1 <= 40 and $level2 <= 40) {

            if (($level1 <= ($level2 + 10)) and ($level1 >= ($level2 - 10))) {
                return true;
            }
        } elseif ($level1 > 40 and $level2 > 40) {

            if (($level1 <= ($level2 + 20)) and ($level1 >= ($level2 - 20))) {
                return true;
            }
        } elseif ($level1 > 60 and $level2 > 60) {

            if (($level1 <= ($level2 + 30)) and ($level1 >= ($level2 - 30))) {
                return true;
            }
        } else {
            return false;
        }
    }

    function sendInvitation() {
        // V�rifie si le joueur a d�j� un groupe
        if ((!$this->getAGroup($char->getId())) and $this->testLevel($this->getLeader())) {

            $sql = "INSERT INTO `group_invitation` (`char_id`,`group_id`,`timestamp`)" .
                    " VALUES ('" . $char->getId() . "','" . $this->id . "','" . time() . "')";
            loadSqlExecute($sql);

            return true;
        }else
            return false;
    }

    function acceptInvitation($char_id) {
        // V�rifie si le joueur a d�j� un groupe
        if (!$this->getAGroup($char_id)) {
            $sql = "INSERT INTO `group_char` (char_id,group_id) " .
                    "VALUES ('$char_id','" . $this->id . "')";
            loadSqlExecute($sql);

            $this->deleteInvitation($char_id);
        }
    }

    function refuseInvitation($char_id) {
        $this->deleteInvitation($char_id);
    }

    function deleteInvitation($char_id) {
        $sql = "DELETE FROM `group_invitation` WHERE char_id = '$char_id' AND group_id = '" . $this->id . "'";
        loadSqlExecute($sql);
    }

    function leave($char_id) {
        $sql = "DELETE FROM `group_char` WHERE `char_id` = '" . $char_id . "' AND group_id = '" . $this->id . "' ";
        loadSqlExecute($sql);
    }

    function disloc() {
        foreach ($this->membersList as $member)
            $this->leave($member['char_id']);

        $this->deleteGroup();
    }

    function deleteGroup() {
        $sql = "DELETE FROM `group` WHERE id = '" . $this->id . "'";
        loadSqlExecute($sql);
    }

// fonction d'affichage

    function showMember($char_id, $char_asker) {
        $char = new char($char_id);
        echo '<table style="" border="0" class="backgroundBody">';

        echo '<tr>';
        echo '<td colspan="3" style="min-width:110px;" class="backgroundMenu">';
        echo '<img title="' . faction::getFactionText($char->getFaction()) . ' de niveau ' . $char->getLevel() . '" src="pictures/faction/' . $char->getFaction() . '-24.png" style="width:18px;height:18px;"> ';
        echo '<img src="pictures/classe/ico-' . $char->getClasse() . '.gif" title="' . classe::GetClasseNameById($char->getClasse()) . '" alt="" style="width:18px;height:18px;" />';
        echo $char->getNameWithColor(8) . '';
        echo '</td>';
        echo '</tr>';


        echo '<tr style="border-bottom:solid 1px black;">';

        // Liste des options
        echo '<td style="width:24px;">';

        $style = "width:17px;height:17px;margin-top:-2px;";

        if ($char_id != $this->leader) {
            if ($char_asker->getId() == $this->leader) {
                // Possibilit� d'expulser le joueur
                echo '<img src="pictures/icones/deconnection.gif" style="' . $style . '" title="expulser" />';
            }else
                echo '<img src="pictures/icones/cantdeconnection.gif" style="' . $style . '" />';
        }else
            echo '<img src="pictures/icones/classement.gif" style="' . $style . '" />';

        echo '<br />';

        $onclick = "cleanMenu();HTTPTargetCall('include/menuig.php?mode=player&char_id=" . $char->getId() . "&action=fiche','tdmenuig');";
        echo '<img src="' . $char->getUrlPicture('mini') . '" alt="Profil" title="Votre fiche" onclick="' . $onclick . '" style="width:17px;height:17px;" />';

        echo '<br />';

        $onclick = "cleanMenu();HTTPTargetCall('page.php?category=messagerie','bodygameig');HTTPTargetCall('page.php?category=messagerie&action=new&to_prevalue=" . $char->getName() . "','box_container');";
        echo '<img onclick="' . $onclick . '" src="pictures/icones/envoyermessage.gif" style="' . $style . '" />';

        echo '</td>';



        // Visage
        echo '<td>';
        $onclick = "loadObject('player','1','" . $char->getId() . "')";
        echo '<img onclick="' . $onclick . '" src="' . $char->getUrlPicture('face') . '" />';
        echo '</td>';



        // barre de vie et mana vertical
        echo '<td style="width:25px;">';
        echo '<div style="float:left;width:8px;margin-left:2px;background-color:black;height:50px;border:solid 1px black;">';
        $min = $char->getLife();
        $max = $char->getLifeMax();
        $pourcent = round(($min / $max) * 50);
        $margintop = 50 - $pourcent;
        echo '<div style="height:' . $pourcent . 'px;margin-top:' . $margintop . 'px;margin-bottom:0px;background-color:red"></div>';
        echo '</div>';
        echo '<div style="float:left;width:8px;margin-left:2px;background-color:black;height:50px;border:solid 1px black;">';
        $min = $char->getMana();
        $max = $char->getManaMax();
        $pourcent = round(($min / $max) * 50);
        $margintop = 50 - $pourcent;
        echo '<div style="height:' . $pourcent . 'px;margin-top:' . $margintop . 'px;margin-bottom:0px;background-color:blue"></div>';
        echo '</div>';
        echo '</td>';

        echo '</tr>';

        echo '<tr>';
        echo '<td colspan="3" style="background-color:black;height:1px;"></td>';
        echo '</tr>';

        // Liste des effets
        echo '<tr>';
        echo '<td colspan="3" style="height:35px;">';
        echo '<div style="margin:auto;">';
        $alleffect = effect::getAllEffectOnChar($char);
        $i = 0;
        if (count($alleffect) > 0) {
            foreach ($alleffect as $effect) {
                $effect = new effect('char_id', $effect['effect_id'], $char->getId());

                $duree_restante = $effect->getDureeRestante($char->getId(), 'char_id');

                $urlimg = 'pictures/effect/' . $effect->getId() . '.gif';
                $txt = "<div>" .
                        "	<u>" . $effect->getName() .
                        "</u></div><hr /><div>" .
                        "" . $effect->getDescription() .
                        "</div><hr />" .
                        "<div> dur&eacute;e restante : " . $duree_restante .
                        "</div>";
                imgWithTooltip($urlimg, $txt, '', 'width:', 'width:200px;', 'width:250px;');

                $i++;
                if ($i == 3) {
                    echo '<br />';
                    $i = 0;
                }
            }
        }
        echo '</div>';

        echo '</td>';
        echo '</tr>';
        echo '</table>';
    }

    function allMemberInSameMap($map_id = 0) {
        $valid = true;
        foreach ($this->membersList as $member) {
            if ($member['map'] != $map_id)
                $valid = false;
        }

        return $valid;
    }

    function setDonjonId($donjon_id) {
        $sql = "INSERT INTO `donjon_group` (donjon_id,group_id) " .
                "VALUES ('" . $donjon_id . "','" . $this->id . "')";
        loadSqlExecute($sql);
    }

    function getDonjonId() {
        $sql = "SELECT donjon_id FROM `donjon_group` WHERE group_id = '" . $this->id . "' ";
        return loadSqlResult($sql);
    }

// Fonction static 
    public static function createGroup($char_id) {
        $sql = "INSERT INTO `group` (`leader`) VALUES ($char_id)";
        loadSqlExecute($sql);

        $sql = "SELECT id FROM `group` WHERE leader = '$char_id'";
        $group_id = loadSqlResult($sql);

        group::addInGroup($char_id, $group_id);
    }

    public static function addInGroup($char_id, $group_id) {
        $sql = "INSERT INTO `group_char` (`char_id`,`group_id`) VALUES ('$char_id','$group_id')";
        loadSqlExecute($sql);
    }

    public static function getAGroup($char_id) {
        $sql = "SELECT COUNT(*) FROM `group_char` WHERE char_id = '$char_id'";
        $count = loadSqlResult($sql);

        if ($count >= 1)
            return true;
        else
            return false;
    }

    public static function getGroup($char_id) {
        $sql = "SELECT group_id FROM `group_char` WHERE char_id = '$char_id'";
        $result = loadSqlResult($sql);

        if ($result == "")
            $result = 0;

        return $result;
    }

    public static function hasInvitation($char_id) {
        $sql = "SELECT * FROM `group_invitation` WHERE char_id = '$char_id' LIMIT 1";
        return loadSqlResultArray($sql);
    }

}

?>