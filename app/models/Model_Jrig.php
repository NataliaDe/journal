<?php

/**
 * Object model mapping for relational view `journal.jrig`
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Jrig {

    public $id_rig;

    public function setIdRig($id_rig) {
        $this->id_rig = $id_rig;
    }

        public function setLastUpdate() {
        return $this->last_update = date("Y-m-d H:i:s");
    }

    public function setDateInsert() {
        return $this->date_insert = date("Y-m-d H:i:s");
    }

//    public function selectAll() {
//           return R::getAll('SELECT * FROM journal.service ORDER BY name ASC');
//
//    }

        public function selectAllByIdRig($id_rig) {
        $this->setIdRig($id_rig);
        return R::getAll('SELECT * FROM journal.jrig WHERE id_rig = ?', array($this->id_rig));
    }

            public function selectAllInIdRig($id_rig)
    {

        $new_result = array();

        if (!empty($id_rig)) {
            $str_id_rig = implode(',', $id_rig);
            $result = R::getAll('SELECT * FROM jrig WHERE id_rig IN (  ' . $str_id_rig . ')');
            foreach ($result as $row) {
                $new_result[$row['id_rig']] [] = $row;
            }
        }


        return $new_result;
    }
    /*  involved units, short   */
                public function selectInvolvedUnits($id_rig) {

				$new_result=array();

				if(!empty($id_rig)){
					    $str_id_rig = implode(',', $id_rig);
        $result = R::getAll('SELECT id_rig, mark,locorg_name, pasp_name FROM jrig WHERE id_rig IN (  ' . $str_id_rig . ')');
        foreach ($result as $row) {
            $new_result[$row['id_rig']] []= $row;
        }
				}


        return $new_result;
    }

    // журнал выезда id_sily=>array(time_exit=0,time_arrival=...)
    function getPOSTData() {

                $y = array();
        $error = array();

        if (isset($_POST['sily']) && !empty($_POST['sily'])) {
            $x = $_POST['sily'];
        } else {
            $x = array();
            return $y;
        }



        foreach ($x as $key => $row) {

            /* ------- Отбой техники -------- */

if(isset($row['is_return']) && $row['is_return']==1 ){//отбой техники

    //игнорируем время приб, время следования, время окончания работ, расстояние
                $y[$key]['time_arrival'] = NULL;
                $y[$key]['time_end'] = NULL;
                $y[$key]['time_follow'] = NULL;
                $y[$key]['distance'] = 0;

$y[$key]['is_return'] = 1;

                // проверка на вшивость Время выезда
                if (isset($row['time_exit']) && !empty($row['time_exit'])) {
                    if ($this->isDateTimeValid($row['time_exit'], "Y-m-d H:i:s")) {
                        $y[$key]['time_exit'] = $row['time_exit'];
                    } else {
                        $error['time_exit'] = ' Поле "Время выезда" должно быть датой ';
                    }
                } else {
                    $y[$key]['time_exit'] = NULL;
                }


                //проверка на вшивость Время возвращения
                if (isset($row['time_return']) && !empty($row['time_return'])) {
                    if ($this->isDateTimeValid($row['time_return'], "Y-m-d H:i:s")) {
                        $y[$key]['time_return'] = $row['time_return'];
                    } else {
                        $error['time_return'] = ' Поле "Время возвращения" должно быть датой ';
                    }
                } else {
                    $y[$key]['time_return'] = NULL;
                }
            }
            /* ------- END Отбой техники -------- */

            else{

$y[$key]['is_return'] = 0;

 /*             * * проверка на вшивость Время выезда  ** */
            if (isset($row['time_exit']) && !empty($row['time_exit'])) {
                if ($this->isDateTimeValid($row['time_exit'], "Y-m-d H:i:s")) {
                    $y[$key]['time_exit'] = $row['time_exit'];
                } else {
                    $error['time_exit'] = ' Поле "Время выезда" должно быть датой ';
                }
            } else {
                $y[$key]['time_exit'] = NULL;
            }
            /*             * * END проверка на вшивость Время выезда  ** */

            /*             * * проверка на вшивость Время прибытия  ** */
            if (isset($row['time_arrival']) && !empty($row['time_arrival'])) {
                if ($this->isDateTimeValid($row['time_arrival'], "Y-m-d H:i:s")) {
                    $y[$key]['time_arrival'] = $row['time_arrival'];
                } else {
                    $error['time_arrival'] = ' Поле "Время прибытия" должно быть датой ';
                }
            } else {
                $y[$key]['time_arrival'] = NULL;
            }
            /*             * *  END проверка на вшивость Время прибытия  ** */

            /*             * **** время выезда< время прибытия ******* */
            if ($y[$key]['time_arrival'] < $y[$key]['time_exit'] && !empty($y[$key]['time_arrival'])) {
                $error['time_exit_arrival'] = ' Время выезда не может превышать время прибытия ';
            }
            /*             * **** END время выезда< время прибытия ******* */

               /*             * ****  время следования ******* */
                if (isset($row['time_follow']) && !empty($row['time_follow'])) {
                if ($this->isDateTimeValid($row['time_follow'], "H:i:s")) {
                    $y[$key]['time_follow'] = $row['time_follow'];
                } else {
                     $y[$key]['time_follow'] = NULL;
                    $error['time_follow'] = ' Поле "Время следования" должно иметь формат времени ';
                }
            } else {
                $y[$key]['time_follow'] = NULL;
            }
   /*             * **** END время следования ******* */

            /*             * * проверка на вшивость Время окончания работ ** */
            if (isset($row['time_end']) && !empty($row['time_end'])) {
                if ($this->isDateTimeValid($row['time_end'], "Y-m-d H:i:s")) {
                    $y[$key]['time_end'] = $row['time_end'];
                } else {
                    $error['time_end'] = ' Поле "Время окончания работ" должно быть датой ';
                }
            } else {
                $y[$key]['time_end'] = NULL;
            }
            /*             * * END проверка на вшивость Время окончания работ ** */


            /*             * * проверка на вшивость Время возвращения ** */
            if (isset($row['time_return']) && !empty($row['time_return'])) {
                if ($this->isDateTimeValid($row['time_return'], "Y-m-d H:i:s")) {
                    $y[$key]['time_return'] = $row['time_return'];
                } else {
                    $error['time_return'] = ' Поле "Время возвращения" должно быть датой ';
                }
            } else {
                $y[$key]['time_return'] = NULL;
            }
            /*             * * END проверка на вшивость Время возвращения ** */

                 $y[$key]['distance'] = (isset($row['distance']) && !empty($row['distance'])) ? $row['distance'] : 0;


            }

        }
        $y['error'] = $error;
//        print_r($y);
//        exit();
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

       //сохранить инф
    public function save($array) {
        unset($array['error']);//очистить элемент с ошибками
//        print_r($array);
//        exit();

        foreach ($array as $key => $row) {
            $sily = R::load('silymchs', $key);
            $row['last_update'] = $this->setLastUpdate();
            $sily->import($row);
            R::store($sily);
        }
    }





}
