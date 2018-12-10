<?php

/**
 * Object model mapping for relational table 'mailsend'
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Mailsend {

    public function setDateInsert() {
        return $this->date_insert = date("Y-m-d H:i:s");
    }

    public function setLastUpdate() {
        return $this->last_update = date("Y-m-d H:i:s");
    }



    public function getAll($id_rig) {
        return R::getAll('SELECT * FROM journal.mailsend WHERE id_rig = ?  ', array($id_rig));
    }

//id_pasp - massive
    public function save($id_rig, $id_pasp) {

$is_ok=array();//индикатор, что все сохранилось в бД
        foreach ($id_pasp as $p) {

            $data_for_save['id_pasp'] = $p;
            $data_for_save['id_rig'] = $id_rig;
            $data_for_save['date_send'] = $this->setLastUpdate();
            $data_for_save['id_user']=$_SESSION['id_user'];

            $is_send = R::findOne('mailsend', 'id_rig = ? and id_pasp = ?', [$id_rig, $p]);

            if ($is_send) {//update
                $send = R::load('mailsend', $is_send['id']);
            } else {//insert
                $send = R::dispense('mailsend');
            }

            $send->import($data_for_save);

            if(R::store($send)){
                $is_ok[]=1;
            }
            else{
               $is_ok[]=0;  
            }
        }
        
        if(in_array(0, $is_ok)){
            return FALSE;
        }
        else
            return TRUE;
    }

}

?>