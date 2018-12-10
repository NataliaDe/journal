<?php
/**
 * Object model mapping for relational table `ss.regions` 
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Local  {
    
    public $id;
    public $name;
    public $id_region;


    public function setIdRegion($id_region) {
        $this->id_region=$id_region;
    }
    public function selectAll() {
           return R::getAll('SELECT * FROM locals WHERE id !=123 ORDER BY sort, name ASC');
       
    }
    
        public function selectAllByRegion($id_region) {
            $this->setIdRegion($id_region);
           return R::getAll('SELECT * FROM locals WHERE id_region = ? and id !=123 ORDER BY sort, name ASC',array($this->id_region));
       
    }

          public function selectNameById($id) {
        return R::getCell('SELECT name FROM locals WHERE id = ?', array($id));
    }
   

}
?>