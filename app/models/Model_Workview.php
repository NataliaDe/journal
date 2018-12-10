<?php
/**
 * Object model mapping for relational table `ss.regions` 
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Workview  {
    
    public $id;
    public $name;


    public function selectAll() {
           return R::getAll('SELECT * FROM journal.workview ORDER BY name ASC');
       
    }
    
        public function selectByReasonrig($id_reasonrig) {
           return R::getAll('SELECT * FROM journal.workview where id_reasonrig = ? ORDER BY name ASC',array($id_reasonrig));
       
    }
    

    
 public function  selectIdReasonrig($id) {
           return R::getCell('SELECT id_reasonrig FROM journal.workview where id = ? ',array($id));
       
    }
   

}
?>