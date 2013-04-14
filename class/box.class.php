<?php

class box {

    private $id;
    private $abs;
    private $ord;
    private $map;
    private $img;
    private $nbobjet;
    private $objet;
    private $gold;
    // typecle ???
    private $typecle;
    private $cle;
    private $isOpenned;

    function __construct() {
        $this->loadBox(func_get_arg(0));
    }

    function getId() {

        return $this->id;
    }

    function getMap() {
        return $this->map;
    }

    function getAbs() {
        if ($this->abs > 25)
            $this->abs = 25;

        if ($this->abs < 0)
            $this->abs = 0;

        return $this->abs;
    }

    function getOrd() {
        if ($this->ord > 15)
            $this->ord = 15;

        if ($this->ord < 0)
            $this->ord = 0;

        return $this->ord;
    }

    function getImg() {
        return $this->img;
    }

    function getNbObjet() {
        return $this->nbobjet;
    }

    function getObjet() {
        return $this->objet;
    }

    function getGold() {
        return $this->gold;
    }

    function getTypeCle() {
        return $this->typecle;
    }

    function getCle() {
        return $this->cle;
    }

    function loadBox($id) {
        $sql = "SELECT * FROM tresor WHERE id = " . $id;
        $result = loadSqlResultArray($sql);

        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    function addBox($abs, $ord, $map, $img, $nbobjet, $objet, $gold, $typecle = 0, $cle = 0) {
        $sql = "INSERT INTO `tresor` " .
                "(abs,ord,map,img,nbobjet,objet,gold,typecle,cle) VALUES " .
                "('$abs','$ord','$map','$img','$nbobjet','$objet','$gold','$typecle','$cle');";

        loadSqlExecute($sql);
    }

    function duplicate($id_new_map = 0) {
        $sql = "INSERT INTO `tresor` " .
                "(abs,ord,map,img,nbobjet,objet,gold,typecle,cle) VALUES " .
                "('" . $this->getAbs() . "','" . $this->getOrd() . "','$id_new_map','" . $this->getImg() . "','" . $this->getNbObjet() . "','" . $this->getObjet() . "','" . $this->getGold() . "','" . $this->getTypeCle() . "','" . $this->getCle() . "');";

        loadSqlExecute($sql);
    }

    function update($row, $value) {
        $this->$row = $value;
        $sql = "UPDATE tresor SET $row = '$value' WHERE id = " . $this->getId();

        loadSqlExecute($sql);
    }

    function delete() {
        $sql = "DELETE FROM `tresor` WHERE id = " . $this->getId();
        loadSqlExecute($sql);
    }

    function isOpenned($idchar) {
        $sql = "SELECT COUNT(*) as open FROM tresor_open WHERE idchar = " . $idchar . " AND idtresor = " . $this->id;
        $result = loadSqlResultArray($sql);

        if ($result['open'] == 0) {
            $this->isOpenned = 0;
            return false;
        } else {
            $this->isOpenned = 1;
            return true;
        }
    }

    function verifDistance($idchar) {
        $verifchar = new char($idchar);

        if ($verifchar->map == $this->map) {
            $a = $this->abs - $verifchar->abs; // �cart horizontale
            $b = $this->ord - $verifchar->ord; // �cart verticale

            if (abs($a) <= 1 && abs($b) <= 1) {
                $distance = 1;
            } else {
                $distance = 0;
            }
        } else {
            $distance = 0;
        }

        return $distance;
    }

    function showBox($idchar) {
        $url = "include/menuig.php?refresh=1&mode=coffre&action=open&id=" . $this->getId();

        $distance = $this->verifDistance($idchar);
        $isOpenned = $this->isOpenned($idchar);

        if (!$isOpenned) {
            if ($distance == 1) {
                echo '<a href="#" class="ablack" onclick="HTTPTargetCall(\'', $url, '\',\'tdmenuig\');">';
                echo 'Ouvrir le coffre';
                echo '</a>';
            } else {
                echo 'vous &ecirc;tes trop loin pour ouvrir ce coffre';
            }
        } else {
            echo 'Ce coffre a d&eacute;j&agrave; &eacute;t&eacute; ouvert';
        }
    }

    function charGetKey($char_id) {
        $key = new item($this->getCle());

        if ($key->charGetItem($char_id) or $this->getCle() == 0) {
            // On supprimer la clef utilis�e si besoin
            $key->addItemToChar($char_id, -1);
            return true;
        } else {
            return false;
        }
    }

    function open($char_id) {
        $distance = $this->verifDistance($char_id);
        $isOpenned = $this->isOpenned($char_id);

        if (!$isOpenned) {
            if ($distance == 1) {
                // Si pas besoin de clef ou clef poss�d�e
                if ($this->charGetKey($char_id)) {
                    // Ouverture du coffre
                    $item = new item($this->objet);
                    $item->addItemToChar($char_id, $this->nbobjet);
                    $this->saveOpen($char_id);

                    // Affichage de ce que l'on a ramasser'
                    echo '<div> Vous ramassez : <br /></div>';
                    echo '<div style="margin-top:10px;">';

                    if ($this->objet != 0) {
                        echo '<div style="float:left;">';
                        echo '<img src="pictures/item/' . $item->item . '.gif" alt="objet jeu de r�le" />';
                        echo '</div>';

                        echo '<div style="margin-left:5px;float:left;">';
                        echo ' x' . $this->nbobjet . ' ' . $item->name;
                        echo '</div>';
                    }

                    if ($this->gold >= 1) {
                        $char = new char($char_id);
                        $char->updateMore('gold', $this->gold);
                        echo '<div style="margin-left:5px;float:left;">';
                        echo ' ' . $this->gold . ' pi&egrave;ces d\'or ';
                        echo '</div>';
                    }

                    echo '</div>';
                } else {
                    echo 'Vous avez besoin d\'une clef pour ouvrir ce coffre';
                }
            } else {
                echo 'trop loin';
            }
        } else {
            echo 'd&eacute;j� ouvert';
        }
    }

    function saveOpen($char_id) {
        $this->isOpenned = 1;
        $sql = "INSERT INTO tresor_open (`idchar`,`idtresor`) VALUES ($char_id,$this->id)";
        loadSqlExecute($sql);
    }

    static public function getAllBox($min, $max, $order = "id", $asc = "ASC", $select = "*") {
        $sql = "SELECT $select FROM tresor ";
        $sql .= " ORDER BY `" . $order . "` $asc ";
        $sql .= " LIMIT " . $min . "," . $max;

        $return = loadSqlResultArrayList($sql);
        return $return;
    }

}

?>