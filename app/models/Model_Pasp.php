<?php

/**
 * Object model mapping for relational table `ss.regions` 
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Pasp {

    public $id;




    public function selectAll() {
           return R::getAll('SELECT * FROM journal.pasp ');
       
    }
    
        public function selectPaspName($id_pasp) {
              if(is_array($id_pasp) && !empty($id_pasp)){
                 return R::getAll('SELECT id, pasp_name, locorg_name FROM journal.pasp WHERE id IN ('. implode(',', $id_pasp) .')');
              }
          else
               return array(); 
       
    }



}

?>