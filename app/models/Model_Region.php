<?php

/**
 * Object model mapping for relational table `ss.regions` 
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Region {

    public $id;
    public $name;

    public function selectAll() {
        return R::getAll('SELECT * FROM regions ORDER BY name ASC');
    }
    
      public function selectNameById($id) {
        return R::getCell('SELECT name FROM regions WHERE id = ?', array($id));
    }
    

}

?>