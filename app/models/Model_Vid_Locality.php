<?php

/**
 * Object model mapping for relational table `ss.regions` 
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Vid_Locality {

    public $id;
    public $name;


  

    public function selectAll() {
        return R::getAll('SELECT * FROM journal.vidlocality ');
    }

  

}

?>