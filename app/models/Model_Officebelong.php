<?php
/**
 * Object model mapping for relational table `ss.regions` 
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Officebelong  {
    
    public $id;
    public $name;


    public function selectAll() {
           return R::getAll('SELECT * FROM journal.officebelong ORDER BY name ASC');
       
    }
    

   

}
?>