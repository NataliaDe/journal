<?php

/**
 * Object model mapping for relational table `listmail` 
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Listmail {




    public function getMail($id_pasp) {
        if(is_array($id_pasp) && !empty($id_pasp)){
             return R::getAll('SELECT * FROM journal.listmail WHERE id_pasp IN ('. implode(',', $id_pasp) .')');
        }
        elseif(!is_array($id_pasp) && !empty($id_pasp)){
            return R::getAll('SELECT * FROM journal.listmail WHERE id_pasp = ?  ', array($id_pasp));
        }
        else{
            return array();  
        }
    }



}

?>