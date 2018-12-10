<?php
/**
 * Object model mapping for relational table `ss.regions` 
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Statusrigcolor  {
    
    public function setLastUpdate() {
        return $this->last_update = date("Y-m-d H:i:s");
    }


    public function selectAllByIdUser($id_user) {
           return R::getAll('SELECT * FROM journal.statusrigcolor  WHERE id_user = ?',array($id_user));
       
    }
    

    public function selectAllDataByIdUser($id_user) {
         return R::getAll('SELECT sc.id, sc.id_statusrig, sc.color, sc.last_update, s.name FROM journal.statusrigcolor as sc '
                 . 'left join statusrig as s ON s.id=sc.id_statusrig  WHERE sc.id_user = ? and s.is_delete <> ?',array($id_user,1));
    }
    
    public function save_new_record($post) {
        if($this->is_statusrigcolor($post['id_statusrig'])){
            $s=R::dispense('statusrigcolor');
        $s->id_statusrig=$post['id_statusrig'];
        $s->id_user=$_SESSION['id_user'];
        $s->color=$post['color'];
        $s->last_update=  $this->setLastUpdate();
        R::store($s);
        }
        
    }
    
   
    public function is_statusrigcolor($id_statusrig) {
        $is=R::getCell('select id from statusrigcolor where id_statusrig = ? and id_user = ? limit ?',array($id_statusrig,$_SESSION['id_user'],1));
        if(empty($is)){
            return TRUE;
        }
        else
            return FALSE;
    }
    
        public function edit($post, $id) {
        $st = R::load('statusrigcolor', $id);
        $post['last_update'] = $this->setLastUpdate();
        $st->import($post);
        R::store($st);
    }
    
    public function deleteById($id) {

        $s = R::load('statusrigcolor', $id);
        R::trash($s);
    }

}
?>