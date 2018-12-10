<?php
/**
 * Object model mapping for relational table `ss.regions` 
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Reasonrigcolor  {
    
    public function setLastUpdate() {
        return $this->last_update = date("Y-m-d H:i:s");
    }


    public function selectAllByIdUser($id_user) {
           return R::getAll('SELECT * FROM journal.reasonrigcolor  WHERE id_user = ?',array($id_user));
       
    }
    

    public function selectAllDataByIdUser($id_user) {
         return R::getAll('SELECT sc.id, sc.id_reasonrig, sc.color, sc.last_update, s.name FROM journal.reasonrigcolor as sc '
                 . 'left join reasonrig as s ON s.id=sc.id_reasonrig  WHERE sc.id_user = ? and s.is_delete <> ?',array($id_user,1));
    }
    
    public function save_new_record($post) {
        if($this->is_reasonrigcolor($post['id_reasonrig'])){
            $s=R::dispense('reasonrigcolor');
        $s->id_reasonrig=$post['id_reasonrig'];
        $s->id_user=$_SESSION['id_user'];
        $s->color=$post['color'];
        $s->last_update=  $this->setLastUpdate();
        R::store($s);
        }
        
    }
    
   
    public function is_reasonrigcolor($id_reasonrig) {
        $is=R::getCell('select id from reasonrigcolor where id_reasonrig = ? and id_user = ? limit ?',array($id_reasonrig,$_SESSION['id_user'],1));
        if(empty($is)){
            return TRUE;
        }
        else
            return FALSE;
    }
    
        public function edit($post, $id) {
        $st = R::load('reasonrigcolor', $id);
        $post['last_update'] = $this->setLastUpdate();
        $st->import($post);
        R::store($st);
    }
    
    public function deleteById($id) {

        $s = R::load('reasonrigcolor', $id);
        R::trash($s);
    }

}
?>