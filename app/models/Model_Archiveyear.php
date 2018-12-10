<?php

/**
 * Object model mapping for relational table `Archivedate` 
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Archiveyear {
    
    public $last_update;

    public function setLastUpdate() {
        return $this->last_update = date("Y-m-d H:i:s");
    }
    
    
        public function selectAll() {
            
        $sql = 'SELECT * FROM journal.archiveyear';
        return R::getAll($sql);
        
    }
    
            public function selectById($id) {

        $sql = 'SELECT year FROM journal.archiveyear WHERE id ='.$id;
        return R::getCell($sql);
    }
    
    

}

?>