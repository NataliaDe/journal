<?php
/**
 * Object model mapping for relational table `Loglogin`
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Loglogin
{

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLastUpdate()
    {
        return $this->last_update = date("Y-m-d H:i:s");
    }

    public function setDateInsert()
    {
        return $this->date_insert = date("Y-m-d H:i:s");
    }

    public function save($val, $in)
    {
        //print_r($array);exit();


        if ($in == 1) {// log in
            $w = R::dispense('loglogin');
            $val['date_in'] = $this->setDateInsert();
            $w->import($val);
             R::store($w);
        } else {

            $is_login = R::getCell('SELECT a.id from journal.loglogin as a '
                    . ' WHERE a.user_id =? and a.date_out is null order by a.date_in desc limit 1', array($val['user_id']));


            if (!empty($is_login)) {
                $w = R::load('loglogin', $is_login);
                $w->date_out = $this->setDateInsert();
                 R::store($w);
            }
        }





        // return true;
    }


}

?>