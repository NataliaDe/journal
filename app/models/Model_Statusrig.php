<?php
/**
 * Object model mapping for relational table `ss.regions` 
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Statusrig  {
    
    public $id;
    public $name;


    public function selectAll() {
           return R::getAll('SELECT * FROM journal.statusrig  ORDER BY id ASC');
       
    }
    

   

}
?>