<?php

/**
 * Object model mapping for relational table `ss.regions`
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Innerservice {

    public $id;
    public $id_rig;

    public function setIdRig($id_rig) {
        $this->id_rig = $id_rig;
    }

//    public function selectAll() {
//           return R::getAll('SELECT * FROM journal.service ORDER BY name ASC');
//
//    }

    public function getPOSTData() {
        $x = $_POST['service'];
        $y=array();
		$error=array();

        foreach ($x as $key => $value) {
            //не учитывать,если служба не выбрана
            if ($x [$key]['id_service'] == '') {
                unset($x[$key]);
            }
            else{

                $y[$key]['id'] = intval($x [$key]['id']);

                 $y[$key]['id_service'] = intval($x [$key]['id_service']); // id of service- int
                 $y[$key]['distance'] = intval($x [$key]['distance']);
                 $y[$key]['note'] = intval($x [$key]['note']);

                                /*                 * * проверка на вшивость Время сообщения  ** */
                if (isset($x [$key]['time_msg']) && !empty($x [$key]['time_msg'])) {
                    if ($this->isDateTimeValid($x [$key]['time_msg'], "Y-m-d H:i") == true) {
                        $y[$key]['time_msg'] = $x [$key]['time_msg'].':00';
                    } else {
                        $error['time_msg'] = ' Поле "Время сообщения" должно быть датой. Формат без секунд! ';
                    }
                } else {
                    $y[$key]['time_msg'] = NULL;
                }
                /*                 * * END проверка на вшивость Время сообщения  ** */

                                /*                 * * проверка на вшивость Время прибытия  ** */
                if (isset($x [$key]['time_arrival']) && !empty($x [$key]['time_arrival'])) {
                    if ($this->isDateTimeValid($x [$key]['time_arrival'], "Y-m-d H:i") == true) {
                        $y[$key]['time_arrival'] = $x [$key]['time_arrival'].':00';
                    } else {
                        $error['time_arrival'] = ' Поле "Время прибытия" должно быть датой. Формат без секунд! ';
                    }
                } else {
                    $y[$key]['time_arrival'] = NULL;
                }
                /*                 * * END проверка на вшивость Время прибытия  ** */

                     //Время сообщения не может превышать время прибытия
                  if(isset($y[$key]['time_msg']) && $y[$key]['time_msg'] != NULL && isset($y[$key]['time_arrival']) && $y[$key]['time_arrival'] != NULL ){
                        if ($y[$key]['time_msg'] > $y[$key]['time_arrival']) {
                    $error['time_exit_arrival'] = ' Время сообщения не может превышать время прибытия ';
                }
                  }
            }
        }
           $y['error'] = $error;

        return $y;
    }

        //проверка на формат дата-время
    public function isDateTimeValid($field,$format) {
                $t_exit = \DateTime::createFromFormat($format, $field);
                if($t_exit)
                    return true;
                else
                    return false;

    }

    public function save($array, $id_rig) {

        $this->setIdRig($id_rig);

        // что сейчас в БД
        $service_from_bd = $this->selectAllByIdRig($id_rig);

        //если не выбрано ни одной службы на данном выезде
        if (empty($array)) {
            //но в БД были службы на данном выезде
            if (isset($service_from_bd) && !empty($service_from_bd)) {
                //очистить
                $this->deleteById($service_from_bd);
            }
        } else {
            //в БД были службы на данном выезде
            if (isset($service_from_bd) && !empty($service_from_bd)) {
                //проверка и замена
                //ищем совпадения из формы и из БД id innerservice - если найдены-update
                foreach ($service_from_bd as $key_bd => $value_bd) {
                    if (!empty($array)) {
                        foreach ($array as $key => $value) {
                            if ($value_bd['id'] == $value['id']) {
                                //перезапись данных по id innerservice
                                $this->updateById($value);

                                //убираем из массива
                                unset($array[$key]);
                                unset($service_from_bd[$key_bd]);
                                break;
                            }
                        }
                    }
                }


                //если на форме было > служб, чем в БД- добавить оставшихся
                if (!empty($array)) {
                    foreach ($array as $key => $value) {
                        if(!empty($value)){
                        //новая служба
                        $this->updateById($value);

                        }

                    }
                }

                //удалить из БД оставшихся-лишних, (если на форме выбрано меньше служб, чем было в БД)
                if (!empty($service_from_bd)) {
                    //очистить
                   $this->deleteById($service_from_bd);
                }
            } else {//в БД было пусто
                //добавление
                foreach ($array as $value) {
                      if(!empty($value)){
                                              //новая служба
                    $this->updateById($value);
                      }

                }
            }
        }
                //exit();
    }

    public function selectAllByIdRig($id_rig) {
        $this->setIdRig($id_rig);
    return R::getAll('SELECT * FROM journal.innerservice WHERE id_rig = ?', array($this->id_rig));

    }

    public function updateById($array) {

        $innerservice = R::findOne('innerservice', 'id = ? ', [$array['id']]);

        if (!$innerservice) {//новая служба
            $innerservice = R::dispense('innerservice');
            $array['id_rig'] = $this->id_rig;
        }
        unset($array['id']); //не записывать id innerservice

        $innerservice->import($array);
        R::store($innerservice);
    }

    function deleteById($array) {
        foreach ($array as $key => $value) {
            $s = R::load('innerservice', $value['id']);
            R::trash($s);
        }
    }


    public function selectAllInIdRig($id_rig) {

        $str_id_rig = implode(',', $id_rig);
        $new_result = array();
        $result = R::getAll('SELECT i.id,i.id_rig, i.time_msg, i.time_arrival, i.distance, i.note, s.name as service_name FROM innerservice as i left join service as s ON s.id=i.id_service WHERE i.id_rig IN (  ' . $str_id_rig . ')');


        if (!empty($result)) {
            foreach ($result as $row) {
                $new_result[$row['id_rig']] [] = $row;
            }
        }
        return $new_result;
    }



    public function selectAllForCard($id_rig) {

        $result = R::getAll('SELECT i.id,i.id_rig, i.time_msg, i.time_arrival, i.distance, i.note, s.name as service_name FROM innerservice as i left join service as s ON s.id=i.id_service WHERE i.id_rig =  ' . $id_rig );

        return $result;
    }

}

?>