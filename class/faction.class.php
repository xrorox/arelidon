<?php

class faction {

    private $num;
    private $map;
    private $abs;
    private $ord;

    function faction($num) {

        switch ($num) {
            case '1':
                $this->map = 1;
                $this->abs = 3;
                $this->ord = 7;
                break;

            case '2':
                $this->map = 179;
                $this->abs = 20;
                $this->ord = 12;
                break;

            case '3':
                $this->map = 222;
                $this->abs = 5;
                $this->ord = 7;
                break;
        }
    }

    function getMap() {
        return $this->map;
    }

    function getAbs() {
        return $this->abs;
    }

    function getOrd() {
        return $this->ord;
    }

    public static function getFactionText($num) {
        switch ($num) {
            case 1:
                return 'Nudricien';
                break;

            case 2:
                return 'Umodien';
                break;

            case 3:
                return 'Amodien';
                break;
        }
    }

    public static function getDescription($num) {
        switch ($num) {
            case 1:
                $desc = "Les nudriciens sont valeureux et solidaires. Ils ont toujours �t� vou�s � la communaut� et � l'artisanat.
				Ils ont bati un des clans les plus organis�.";
                break;

            case 2:
                $desc = "Les umodiens sont d'anciens chasseurs, ils ont gard�s beaucoup de leurs ancestrales techniques ce qui
				leur permet de chasser plus efficacement.";
                break;

            case 3:
                $desc = "Les amodiens ont toujours pr�f�r� l'esprit � la force physique et misent beaucoup sur leur charisme. Ils 
				sont r�put�s pour leur commerce florissant.";
                break;
        }

        return htmlentities($desc);
    }

    public static function getBonus($num) {
        switch ($num) {
            case 1:
                $desc = "+25% d'exp artisanat  +25% poids portable";
                break;

            case 2:
                $desc = "+10% drop et or sur les monstres";
                break;

            case 3:
                $desc = '-20% sur le prix des marchands';
                break;
        }

        return htmlentities($desc);
    }

}

?>