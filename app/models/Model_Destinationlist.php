<?php

/**
 * Object model mapping for relational view `Destinationlist` 
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Destinationlist {

    public $id_destination;
    public $position_name;
    public $rank_name;
    public $fio;



    
    public function selectAll() {
                $id_level = $_SESSION['id_level'];
        $id_locorg = $_SESSION['id_locorg'];
        $id_organ = $_SESSION['id_organ'];
        $id_region = $_SESSION['id_region'];

        $cp = array(8, 9, 12); //ROSN, UGZ, AVIA

        $sql = 'SELECT * FROM journal.destinationlist WHERE id_level = ?';

        $param = array($id_level);

        if ($id_level == 2) {

            if (in_array($id_organ, $cp)) {//ROSN, UGZ, AVIA
                $is_where = ' AND id_organ = ?  ';
                $param[] = $id_organ;
            } else {// УМЧС по области кроме РОСН, УГЗ, Авиация
                $is_where = ' AND id_region = ? AND id_organ NOT IN (' . implode(',', $cp) . ')';
                $param[] = $id_region;
            }
        } elseif ($id_level == 3) {//3
            $is_where = ' AND id_locorg = ?  ';
            $param[] = $id_locorg;
        }

        if (!empty($is_where)) {
            $sql = $sql . $is_where;
        }

        return R::getAll($sql, $param);
         return R::getAll('SELECT * FROM journal.destinationlist');
    }
   


        public function select_destinations() {
         return R::getAll('SELECT * FROM journal.destinationlist');
    }   
    
    
    
}