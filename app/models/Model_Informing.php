<?php

/**
 * Object model mapping for relational table `Informing`
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Informing {

//    public function selectAll() {
//           return R::getAll('SELECT * FROM journal.service ORDER BY name ASC');
//
//    }
    public function setIdRig($id_rig) {
        $this->id_rig = $id_rig;
    }

      public function getPOSTData() {
        $x = $_POST['informing'];
        $y = array();
		$error=array();

        foreach ($x as $key => $value) {
            //не учитывать,если адресат не выбран
            if ($x [$key]['id_destination'] == '' && empty($x [$key]['destination_text'])) {//должен быть выбран адресат либо заполнено поле адресат
                unset($x[$key]);
            } else {

                $y[$key]['id'] = intval($x [$key]['id']); // id of informing table - int

                $y[$key]['id_destination'] = intval($x [$key]['id_destination']); // id адресата - int

                $y [$key]['destination_text']=$x [$key]['destination_text'];

				$y[$key]['id_level_created'] = $_SESSION['id_level'];

                /*                 * * проверка на вшивость Время сообщения  ** */
                if (isset($x [$key]['time_msg']) && !empty($x [$key]['time_msg'])) {
                    if ($this->isDateTimeValid($x [$key]['time_msg'], "Y-m-d H:i") == true) {
                        $y[$key]['time_msg'] = $x [$key]['time_msg'].':00';
                    } else {
                        $error['time_msg'] = ' Поле "Время сообщения о ЧС" должно быть датой ';
                    }
                } else {
                    $y[$key]['time_msg'] = NULL;
                }
                /*                 * * END проверка на вшивость Время сообщения  ** */

                /*                 * * проверка на вшивость Время выезда  ** */
                if (isset($x [$key]['time_exit']) && !empty($x [$key]['time_exit'])) {
                    if ($this->isDateTimeValid($x [$key]['time_exit'], "Y-m-d H:i") == true) {
                        $y[$key]['time_exit'] = $x [$key]['time_exit'].':00';
                    } else {
                        $error['time_exit'] = ' Поле "Время выезда" должно быть датой ';
                    }
                } else {
                    $y[$key]['time_exit'] = NULL;
                }
                /*                 * * END проверка на вшивость Время выезда  ** */

                /*                 * * проверка на вшивость Время прибытия  ** */
                if (isset($x [$key]['time_arrival']) && !empty($x [$key]['time_arrival'])) {
                    if ($this->isDateTimeValid($x [$key]['time_arrival'], "Y-m-d H:i") == true) {
                        $y[$key]['time_arrival'] = $x [$key]['time_arrival'].':00';
                    } else {
                        $error['time_arrival'] = ' Поле "Время прибытия" должно быть датой ';
                    }
                } else {
                    $y[$key]['time_arrival'] = NULL;
                }
                /*                 * * END проверка на вшивость Время прибытия  ** */

                //Время сообщения о ЧС не может превышать время выезда
                if(isset($y[$key]['time_msg']) && $y[$key]['time_msg'] != NULL && isset($y[$key]['time_exit']) && $y[$key]['time_exit'] != NULL ){
                                    if ($y[$key]['time_msg'] > $y[$key]['time_exit']) {
                    $error['time_msg_exit'] = ' Время сообщения о ЧС не может превышать время выезда ';
                }
                }

                //Время выезда не может превышать время прибытия
                  if(isset($y[$key]['time_exit']) && $y[$key]['time_exit'] != NULL && isset($y[$key]['time_arrival']) && $y[$key]['time_arrival'] != NULL ){
                        if ($y[$key]['time_exit'] > $y[$key]['time_arrival']) {
                    $error['time_exit_arrival'] = ' Время выезда не может превышать время прибытия ';
                }
                  }

            }
        }
        $y['error'] = $error;

        return $y;
    }

    //проверка на формат дата-время
    public function isDateTimeValid($field, $format) {
        $t_exit = \DateTime::createFromFormat($format, $field);
        if ($t_exit)
            return true;
        else
            return false;
    }

    public function save($array, $id_rig) {
        unset($array['error']); //очистить элемент с ошибками
        $this->setIdRig($id_rig);

        // что сейчас в БД
        $service_from_bd = $this->selectAllByIdRigOnlyMy($id_rig,$_SESSION['id_level']);


        //если не выбрано ни одного адресата на данном выезде
        if (empty($array)) {
            //но в БД были адресаты на данном выезде
            if (isset($service_from_bd) && !empty($service_from_bd)) {
                //очистить
                $this->deleteById($service_from_bd);
            }
        } else {
            //в БД были адресаты на данном выезде
            if (isset($service_from_bd) && !empty($service_from_bd)) {
                //проверка и замена
                //ищем совпадения из формы и из БД id informing - если найдены-update
                foreach ($service_from_bd as $key_bd => $value_bd) {
                    if (!empty($array)) {
                        foreach ($array as $key => $value) {
                            if ($value_bd['id'] == $value['id'] ) {

                                //if($value['my'] == 1){
                                //перезапись данных по id innerservice
                                $this->updateById($value);
                                //}

                                //убираем из массива
                                unset($array[$key]);
                                unset($service_from_bd[$key_bd]);
                                break;
                            }
                        }
                    }
                }

                //если на форме было > адресатов, чем в БД- добавить оставшихся
                if (!empty($array)) {
                    foreach ($array as $key => $value) {
                        // if($value['my'] == 1){
                        //новый адресат
                        $this->updateById($value);
                        // }
                    }
                }

                //удалить из БД оставшихся-лишних, (если на форме выбрано меньше адресатов, чем было в БД)
                if (!empty($service_from_bd)) {
                    // if($value['my'] == 1){
                    //очистить
                    $this->deleteById($service_from_bd);
                   //  }
                }
            } else {//в БД было пусто
                //добавление
                foreach ($array as $value) {
                    // if($value['my'] == 1){
                    //новый адресат
                    $this->updateById($value);
                   //  }
                }
            }
        }
    }

    public function selectAllByIdRig($id_rig) {
        $this->setIdRig($id_rig);
        //return R::getAll('SELECT * FROM journal.informing WHERE id_rig = ?', array($this->id_rig));
         return R::getAll('SELECT * FROM journal.informingrep WHERE id_rig = ?', array($this->id_rig));
    }

        public function selectAllByIdRigOnlyMy($id_rig,$id_level) {
        $this->setIdRig($id_rig);
        //return R::getAll('SELECT * FROM journal.informing WHERE id_rig = ?', array($this->id_rig));
         return R::getAll('SELECT * FROM journal.informingrep WHERE id_rig = ? and id_level_created = ?', array($this->id_rig, $id_level));
    }

        public function selectAllInIdRig($id_rig) {

			$new_result=array();

			if(!empty($id_rig)){
			 $str_id_rig = implode(',', $id_rig);

        $result = R::getAll('SELECT * FROM informingrep WHERE id_rig IN (  ' . $str_id_rig . ')');
        foreach ($result as $row) {
            $new_result[$row['id_rig']] []= $row;
        }
			}

       return $new_result;
    }

    public function updateById($array) {

        $informing = R::findOne('informing', 'id = ? ', [$array['id']]);

        if (!$informing) {//новый адресат
            $informing = R::dispense('informing');
            $array['id_rig'] = $this->id_rig;
        }
        unset($array['id']); //не записывать id innerservice

        $informing->import($array);
        R::store($informing);
    }

    function deleteById($array) {
        foreach ($array as $key => $value) {
            $s = R::load('informing', $value['id']);
            R::trash($s);
        }
    }


    function getNotFullInfo($ids_rig)
    {
        return R::getAll('SELECT id_rig FROM journal.informingrep WHERE id_rig IN ('. implode(',', $ids_rig).') AND '
            . ' (id_destination <> 0 OR destination_text <> "") AND (time_msg is null OR time_exit is null OR time_arrival is null)');
    }

}

?>