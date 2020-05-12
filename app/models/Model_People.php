<?php

/**
 * Object model mapping for relational table `ss.regions`
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_People {

    public function setIdRig($id_rig) {
        $this->id_rig = $id_rig;
    }

    public function getPOSTData() {
        $x = $_POST;
        $y = array();

        $y['phone'] = (isset($x['phone']) && !empty($x['phone'])) ? $x['phone'] : '';
        $y['fio'] = (isset($x['fio']) && !empty($x['fio'])) ? $x['fio'] : '';
        $y['position'] = (isset($x['position']) && !empty($x['position'])) ? $x['position'] : '';
        $y['address'] = (isset($x['address']) && !empty($x['address'])) ? $x['address'] : '';
        $y['floor'] = (isset($x['floor']) && !empty($x['floor'])) ? $x['floor'] : 0;//этажность/этаж
       // $y['floor_all'] = (isset($x['floor_all']) && !empty($x['floor_all'])) ? $x['floor_all'] : 0;

        return $y;
    }

    //сохранить инф по заявителю по id rig
    public function save($array, $id_rig) {

        $this->setIdRig($id_rig);

        $people = R::findOne('people', 'id_rig = ? ', [$this->id_rig]);
        if (!$people) {
            $people = R::dispense('people');
            $array['id_rig'] = $this->id_rig;
        }
        $people->import($array);


        if (R::store($people))
            return TRUE;
        else
            return FALSE;
    }


    public function selectAllByIdRig($id_rig) {
      $this->setIdRig($id_rig);
        return R::findOne('people', 'id_rig = ? ', [$this->id_rig]);
    }

        public function selectAllInIdRig($id_rig) {
        // в формате mas[id_rig]=>array()
        $str_id_rig = implode(',', $id_rig);
        $result = R::getAll('SELECT * FROM people WHERE id_rig IN (  ' . $str_id_rig . ')');
        foreach ($result as $row) {
            $new_result[$row['id_rig']] = $row;
        }
        return $new_result;
    }



        public function copy_people($array)
    {

        $people = R::dispense('people');
        $people->import($array);
        R::store($people);
    }
}

?>