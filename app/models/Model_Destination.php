<?php

/**
 * Object model mapping for relational table `Informing`
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Destination {

    public $last_update;

    public function setLastUpdate() {
        return $this->last_update = date("Y-m-d H:i:s");
    }


    //выбираем в зависимости от авторизованного польз-у кажд пользователя(по уровням) свой классификатор
        public function selectAll() {

        $id_level = $_SESSION['id_level'];
        $id_locorg = $_SESSION['id_locorg'];
        $id_organ = $_SESSION['id_organ'];
        $id_region = $_SESSION['id_region'];

        $cp = array(8, 9, 12); //ROSN, UGZ, AVIA

        $sql = 'SELECT * FROM journal.destination WHERE is_delete =? AND id_level = ?';

        $param = array(0, $id_level);

        if ($id_level == 2) {

            if (in_array($id_organ, $cp)) {//ROSN, UGZ, AVIA
                $is_where = ' AND id_organ = ?  ';
                $param[] = $id_organ;
            } else {// УМЧС по области кроме РОСН, УГЗ, Авиация
                $is_where = ' AND id_region = ? AND id_organ NOT IN (' . implode(',', $cp) . ')';
                $param[] = $id_region;
            }
        } elseif ($id_level == 3) {//3
            $is_where = ' AND id_locorg = ?  ';
            $param[] = $id_locorg;
        }

        if (!empty($is_where)) {
            $sql = $sql . $is_where;
        }

        return R::getAll($sql, $param);
    }

    public function save($array) {


        $dest = R::findOne('destination', 'id = ? ', [$array['id']]);

        if (!$dest) {//новое лицо
            $dest = R::dispense('destination');
            $array['id_level']=$_SESSION['id_level'];
            $array['id_region']=$_SESSION['id_region'];
            $array['id_locorg']=$_SESSION['id_locorg'];
            $array['id_organ']=$_SESSION['id_organ'];
        }
        unset($array['id']); //не записывать id

         $array['id_user']=$_SESSION['id_user'];
         $array['last_update']=  $this->setLastUpdate();

        $dest->import($array);
        if(R::store($dest))
            return TRUE;
        else {
            return FALSE;
        }
    }

}

?>