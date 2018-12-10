<?php

/**
 * Object model mapping for relational table `ss.regions` 
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Rig {

    public function setId($id) {
        $this->id = $id;
    }

    public function setLastUpdate() {
        return $this->last_update = date("Y-m-d H:i:s");
    }

    public function setDateInsert() {
        return $this->date_insert = date("Y-m-d H:i:s");
    }

    public function getPOSTDataByRig() {

        $x = $_POST;
        $y = array();
        $error=array();
        
                            /*             * * проверка на вшивость Время сообщения  ** */
            if (isset($x['time_msg']) && !empty($x['time_msg'])) {
                if ($this->isDateTimeValid($x['time_msg'], "Y-m-d H:i:s")) {
                   $y['time_msg'] = $x['time_msg'];
                } else {
                    $y['time_msg'] = date("Y-m-d H:i:s");
                }
            } else {
                $y['time_msg'] = date("Y-m-d H:i:s");
            }
            /*             * * END проверка на вшивость Время сообщения  ** */

        $y['description'] = (isset($x['description']) && !empty($x['description'])) ? $x['description'] : '';
        $y['id_reasonrig'] = (isset($x['id_reasonrig']) && !empty($x['id_reasonrig'])) ? $x['id_reasonrig'] : 0;
        $y['id_street'] = (isset($x['id_street']) && !empty($x['id_street'])) ? $x['id_street'] : 0;
        $y['home_number'] = (isset($x['home_number']) && !empty($x['home_number'])) ? $x['home_number'] : '-';
        $y['housing'] = (isset($x['housing']) && !empty($x['housing'])) ? $x['housing'] : '-';//корпус, кв, подъезд
       // $y['apartment'] = (isset($x['apartment']) && !empty($x['apartment'])) ? $x['apartment'] : '-';
        $y['id_locality'] = (isset($x['id_locality']) && !empty($x['id_locality'])) ? intval($x['id_locality']) : 0;
        $y['id_region'] = (isset($x['id_region']) && !empty($x['id_region'])) ? intval($x['id_region']) : 0;
        $y['id_local'] = (isset($x['id_local']) && !empty($x['id_local'])) ? intval($x['id_local']) : 0;
        $y['id_selsovet'] = (isset($x['id_selsovet']) && !empty($x['id_selsovet'])) ? intval($x['id_selsovet']) : 0;
        $y['is_opposite'] = (isset($x['is_opposite']) && !empty($x['is_opposite'])) ? $x['is_opposite'] : 0;
        $y['object'] = (isset($x['object']) && !empty($x['object'])) ? $x['object'] : '';
        $y['additional_field_address'] = (isset($x['additional_field_address']) && !empty($x['additional_field_address'])) ? $x['additional_field_address'] : '';
        $y['longitude'] = (isset($x['longitude']) && !empty($x['longitude'])) ? $x['longitude'] : 0;
        $y['latitude'] = (isset($x['latitude']) && !empty($x['latitude'])) ? $x['latitude'] : 0;
        $y['id_officebelong'] = (isset($x['id_officebelong']) && !empty($x['id_officebelong'])) ? intval($x['id_officebelong']) : 0;
        $y['inf_detail'] = (isset($x['inf_detail']) && !empty($x['inf_detail'])) ? $x['inf_detail'] : '';
        $y['id_work_view'] = (isset($x['id_work_view']) && !empty($x['id_work_view'])) ? intval($x['id_work_view']): 0;
        $y['id_firereason'] = (isset($x['id_firereason']) && !empty($x['id_firereason'])) ? intval($x['id_firereason']) : 0;
        $y['firereason_descr'] = (isset($x['firereason_descr']) && !empty($x['firereason_descr'])) ? $x['firereason_descr'] : '';
        $y['version_reason'] = (isset($x['version_reason']) && !empty($x['version_reason'])) ? $x['version_reason'] : '';
        $y['inspector'] = (isset($x['inspector']) && !empty($x['inspector'])) ? $x['inspector'] : '';
        $y['id_statusrig'] = (isset($x['id_statusrig']) && !empty($x['id_statusrig'])) ? intval($x['id_statusrig']) : 0;
          $y['is_opg'] = (isset($x['is_opg']) && !empty($x['is_opg'])) ? intval($x['is_opg']) : 0;
          $y['opg_text'] = (isset($y['is_opg']) && $y['is_opg'] == 1 ) ? $x['opg_text'] : NULL;//если не отмечен чекбокс-не записываем в БД описание



        return $y;
    }

    //сохранить инф по вызову
    public function save($array, $id) {

        $this->setId($id);

        $rig = R::load('rig', $this->id);

        if ($this->id == 0) {//insert
            $array['id_locorg'] = $_SESSION['id_locorg'];
            $array['date_insert'] = $this->setDateInsert();
        }
        $array['last_update'] = $this->setLastUpdate();
        $array['id_user']=$_SESSION['id_user'];
        $rig->import($array);

        $new_id = R::store($rig);

        return $new_id;
    }

    public function selectAllById($id) {
        $this->setId($id);
        return R::findOne('rig', 'id = ? ', [$this->id]);
    }

    public function deleteRigById($id) {
        $this->setId($id);
        $rig = R::findOne('rig', 'id = ?', [$this->id]);
        if ($rig) {
            $rig->is_delete = 1;
            R::store($rig);
        }
    }

    //время лок, ликв
    public function selectTimeCharacter($id) {
        $this->setId($id);
        return R::getRow('SELECT time_loc, time_likv, is_close, is_likv_before_arrival FROM journal.rig WHERE id = ?', array($this->id));
    }

    //время лок, ликв
    public function getPOSTTimeCharacter() {
        $x = $_POST;
        $y = array();
        $error=array();
        
        if (isset($x['is_close']) && $x['is_close'] == 1) {//стоит отметка не учитывать даты
            $y['time_loc'] = '0000-00-00 00:00:00';
            $y['time_likv'] = '0000-00-00 00:00:00';
            $y['is_close'] = 1;//закрыть выезд

            if (isset($x['is_likv_before_arrival']) && $x['is_likv_before_arrival'] == 1) {//ликвидация до прибытия
                $y['is_likv_before_arrival'] = 1;
            } else {
                $y['is_likv_before_arrival'] = 0;
            }

            return $y;
        } elseif (isset($x['is_likv_before_arrival']) && $x['is_likv_before_arrival'] == 1) {//ликвидация до прибытия
            $y['time_loc'] = '0000-00-00 00:00:00';
            $y['time_likv'] = '0000-00-00 00:00:00';
            $y['is_likv_before_arrival'] = 1;

            if (isset($x['is_close']) && $x['is_close'] == 1) {//стоит отметка не учитывать даты
                $y['is_close'] = 1;//закрыть выезд
            } else {
                $y['is_close'] = 0;//выезд не закрыт
            }
        } else {
            $y['is_close'] = 0;
            $y['is_likv_before_arrival'] = 0;
        }

        /*             * * проверка на вшивость Время локализации  ** */
            if (isset($x['time_loc']) && !empty($x['time_loc'])) {
                if ($this->isDateTimeValid($x['time_loc'], "Y-m-d H:i:s")) {
                   $y['time_loc'] = $x['time_loc'];
                } else {
                    $error['time_loc'] = ' Поле "Время локализации" должно быть датой ';
                }
            } else {
                $y['time_loc'] = NULL;
            }
            /*             * * END проверка на вшивость Время локализации  ** */
            
                                /*             * * проверка на вшивость Время ликвид  ** */
            if (isset($x['time_likv']) && !empty($x['time_likv'])) {
                if ($this->isDateTimeValid($x['time_likv'], "Y-m-d H:i:s")) {
                   $y['time_likv'] = $x['time_likv'];
                    $y['is_close_by_time_likv'] = 1;//закрыть выезд
                } else {
                    $error['time_likv'] = ' Поле "Время ликвидации" должно быть датой ';
                }
            } else {
                $y['time_likv'] = NULL;
                 $y['is_close_by_time_likv'] = 0;//выезд не закрыт
            }
            /*             * * END проверка на вшивость Время ликвид  ** */
        
        
        //время ликв д б больше вр лакализации
        if( $y['time_loc']!= NULL && $y['time_likv'] != NULL && $y['time_loc'] >$y['time_likv'] ){
             $error['time_loc_likv'] = ' Время ликвидации не может превышать время локализации ';
//            $a=$y['time_loc'] ;
//            $y['time_loc'] =$y['time_likv'] ;
//            $y['time_likv'] =$a;
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
    
//save время лок, ликв
    public function saveTimeCharacter($array, $id) {
         unset($array['error']);//очистить элемент с ошибками
        $this->setId($id);
        $rig = R::load('rig', $this->id);
        $array['last_update'] = $this->setLastUpdate();
        $rig->import($array);
        R::store($rig);
    }
    


}

?>