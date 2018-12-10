<?php
/**
 * Object model mapping for relational table `ss.regions`
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Reasonrig  {

    public $id;
    public $name;


    public function selectAll($is_delete) {
        if($is_delete == 0)//no deleted
           return R::getAll('SELECT * FROM journal.reasonrig WHERE is_delete = ? ORDER BY name ASC',array($is_delete));
        else//all reasons
         return R::getAll('SELECT * FROM journal.reasonrig  ORDER BY name ASC');

    }





}
?>