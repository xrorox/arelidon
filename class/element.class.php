<?php

class element {
    /*
     *  0 = neutre
     *  1 = feu
     *  2 = eau
     *  3 = air
     *  4 = terre
     */

    private $id;
    private $name;

    // --- CONSTRUCTOR ---
    function __construct() {
        $num = func_num_args();

        switch ($num) {
            case 1 :
                $this->id = func_get_arg(0);
                break;
        }
    }

    function getName() {
        switch ($this->id) {
            case 0 :
                return "neutre";
                break;
            case 1 :
                return "feu";
                break;
            case 2 :
                return "eau";
                break;
            case 3 :
                return "air";
                break;
            case 4 :
                return "terre";
                break;
        }
    }

}