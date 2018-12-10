<?php
/**
 * Object model mapping for relational table `guest` 
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Index  {
    
    public function getAll($isBean = false) {
        if ($isBean)
           return R::findAll('organs', 'ORDER BY id DESC');
        else
           return R::getAll('SELECT * FROM organs ORDER BY id DESC');
       
    }
   

}
?>