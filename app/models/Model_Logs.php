<?php
/**
 * Object model mapping for relational table `Loglogin`
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Logs
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

    public function save($val)
    {

        $w = R::dispense('logs');
        $val['date_action'] = $this->setDateInsert();
        $w->import($val);
        R::store($w);

        // return true;
    }
}

?>