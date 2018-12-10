<?php

/**
 * Object model mapping for relational table `ss.regions` 
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Selsovet {

    public $id;
    public $name;
    public $id_local;

    public function setIdLocal($id_local){
        $this->id_local=$id_local;
}



    public function selectAll() {
        return R::getAll('SELECT * FROM journal.selsovet ORDER BY name ASC');
    }
    
        public function selectAllByLocal($id_local) {
            $this->setIdLocal($id_local);
        return R::getAll('SELECT * FROM journal.selsovet  where id_local = ? ORDER BY name ASC',array($this->id_local));
    }
    



}

?>