<?php
/**
 * Object model 
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Classificator  {
    
    public $id;
    public $name;
    public $bean;

    public function __construct($bean){
        $this->bean=$bean;
}

   public function setId($id) {
        $this->id = $id;
    }
    
        public function setLastUpdate() {
        return $this->last_update = date("Y-m-d H:i:s");
    }
    
    public function selectAll() {
           return R::getAll('SELECT * FROM journal.'.  $this->bean.' WHERE is_delete =?  ORDER BY name ASC',array(0));
       
    }
    
        public function selectListMail() {
           return R::getAll('SELECT * FROM journal.'.  $this->bean.' WHERE is_delete =? ',array(0));
       
    }
    
        public function save($array, $id) {

        $this->setId($id);
        $classif = R::load($this->bean, $this->id);

        $array['last_update'] = $this->setLastUpdate();
        $array['id_user']=$_SESSION['id_user'];
        $classif->import($array);

        if( R::store($classif))
        return TRUE;
        else
            return FALSE;
    }
    
     public function deleteClassifById($id) {
        $this->setId($id);
        $classif = R::findOne($this->bean, 'id = ?', [$this->id]);
        if ($classif) {
            $classif->is_delete = 1;
            R::store($classif);
        }
    }
    

   

}
?>
