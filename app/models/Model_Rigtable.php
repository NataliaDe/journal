<?php

/**
 * Object model mapping for relational table `ss.regions`
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Rigtable {

    public $limit_rigs = 10;

    public $default_time_for_period = '06:00:00'; //смена с 6 утра до 6 утра
    //public $time1 = '05:59:59';
    public $time1 = '06:00:00';
    public $time2 = '06:00:00';

    //  $today =  date("Y-m-d");
     //$yesterday=date("Y-m-d", time()-(60*60*24));

     public function getToday() {
        return date("Y-m-d");
    }

    public function getYesterday() {
        return date("Y-m-d", time() - (60 * 60 * 24));
    }

    public function getDayBeforeYesterday() {
        return date("Y-m-d", time() - (60 * 60 * 24) - (60 * 60 * 24));
    }

    public function getTomorrow() {
        return date("Y-m-d", time() + (60 * 60 * 24));
    }

    public function getPeriodDefault() {
        $time_now = date("H:i:s");

        if ($time_now <= $this->default_time_for_period) {//до 06 утра
            $this->date1 = $this->getYesterday();
            $this->date2 = $this->getToday();
        } else {//после 06 утра
            $this->date1 = $this->getToday();
            $this->date2 = $this->getTomorrow();
        }
    }

    public function setDateStart($d) {
        $this->date_start = $d;
    }

    public function setDateEnd($d) {
        $this->date_end = $d;
    }


    /* ---------------------------------- Выборка выездов ------------------------------------ */

        //выезд по id
    public function selectAllByIdRig($id_rig, $is_delete) {

        $sql = 'SELECT * FROM journal.rigtable WHERE id = ? and is_delete = ?  ';
        $param = array($id_rig, $is_delete);

        if ($_SESSION['id_level'] == 3) {//ГРОЧС
            //выезд должен принадлежать тому ГРОЧС, который его создала
            $is_where = ' AND id_locorg = ?  ';
            $param[] = $_SESSION['id_locorg'];
        } elseif ($_SESSION['id_level'] == 2) {//oblast
            if ($_SESSION['sub'] == 2) {// UGZ, ROSN, AVIA
                //выезд должен принадлежать тому organ, который его создала
                $is_where = ' AND id_organ_user = ?  ';
                $param[] = $_SESSION['id_organ'];
            } else {
                //выезд должен принадлежать той области, которая его создала
                $is_where = ' AND id_region_user = ?  ';
                $param[] = $_SESSION['id_region'];
            }
        }

        if (!empty($is_where)) {
            $sql = $sql . $is_where;
        }

        return R::getAll($sql, $param);
    }


       //выезд по id
    public function getRigById($id_rig) {

        return R::getAll('SELECT * FROM journal.rigtable WHERE id = ?  ',array($id_rig));
    }

    // дата, время, адрес объекта для вызова по id
    public function selectByIdRig($id_rig) {

            return R::getAll('SELECT date_msg, time_msg, address, additional_field_address FROM journal.rigtable WHERE id = ? ',array($id_rig));

    }

    public function selectAll($is_delete) {
        return R::getAll('SELECT * FROM journal.rigtable WHERE is_delete = ?', array($is_delete));
    }

    //выезды по области
    //sign=1 - включаем в результат ЦП
    public function selectAllByIdRegion($id_region_user, $sub, $is_delete) {

        $sql = 'SELECT * FROM journal.rigtable WHERE id_region_user = ? and is_delete = ?  ';
        $param = array($id_region_user, $is_delete);

        if ($sub != 1) {//только УМЧС
            $umchs = ' AND sub = ?  ';
            $param[] = 0;//УМЧС
        }

        if (isset($umchs)) { //добавляем
            $sql = $sql . $umchs;
        }

        return $this->getRigTable($sql, $param);
    }

    //выезды по ГРОЧС
    public function selectAllByIdLocorg($id_locorg, $is_delete) {
        //     return R::getAll('SELECT * FROM journal.rigtable WHERE id_locorg= ?  and is_delete = ? limit ? ', array($id_locorg, $is_delete, $this->limit_rigs));

        $sql = 'SELECT * FROM journal.rigtable WHERE id_locorg = ? and is_delete = ?  ';
        $param = array($id_locorg, $is_delete);

        return $this->getRigTable($sql, $param);
    }

    //выезды по органу
    public function selectAllByIdOrgan($id_organ_user, $is_delete) {
        //   return R::getAll('SELECT * FROM journal.rigtable WHERE id_organ_user = ?  and is_delete = ? limit ? ', array($id_organ_user, $is_delete,  $this->limit_rigs));

        $sql = 'SELECT * FROM journal.rigtable WHERE id_organ_user = ? and is_delete = ?  ';
        $param = array($id_organ_user, $is_delete);

        return $this->getRigTable($sql, $param);
    }

    //выборка выездов из БД - общая часть для всех уровней
    public function getRigTable($sql, $param) {
        if (isset($this->date_start) && isset($this->date_end)) {//с 06 00 до 06 00 по конкретным датам пользователя


                 $date_filter = ' AND date_msg between ? and ? and id not in '
                . '  ( SELECT id FROM journal.rigtable WHERE is_delete = 0'
.' and (date_msg = ? and time_msg< ? ) or  (date_msg = ? and time_msg>= ? )  ) ';// с 06 утра до 06 утра
        $param[] = $this->date_start;
        $param[] = $this->date_end;

        $param[] = $this->date_start;
        $param[] = $this->time1;
        $param[] = $this->date_end;
        $param[] = $this->time2;

        } else {//с 06 00 до 06 00 за текущие сутки

            $this->getPeriodDefault();


                 $date_filter = ' AND date_msg between ? and ? and id not in '
                . '  ( SELECT id FROM journal.rigtable WHERE is_delete = 0'
.' and (date_msg = ? and time_msg< ? ) or  (date_msg = ? and time_msg>= ? )  ) ';// с 06 утра до 06 утра
        $param[] = $this->date1;
        $param[] = $this->date2;

        $param[] = $this->date1;
        $param[] = $this->time1;
        $param[] = $this->date2;
        $param[] = $this->time2;

        }

        if (isset($date_filter)) { //добавляем
            $sql = $sql . $date_filter;
        }

//            print_r($a);
//            exit();
        return R::getAll($sql, $param);
    }

    /* ---------------------------------- КОНЕЦ Выборка выездов ------------------------------------ */


    /* ---------------------------------- Кол-во выездов ------------------------------------ */

    //кол-во выездов по области
    public function selectCountByIdRegion($id_region_user, $sub, $is_delete) {
        if ($sub == 1) {//УМЧС+ЦП
            return R::getCell('select count(id) FROM journal.rigtable WHERE id_region_user = ? and is_delete = ?', array($id_region_user, $is_delete));
        } else {//только УМЧС
            return R::getCell('SELECT count(id) FROM journal.rigtable WHERE id_region_user = ? AND sub = ? and is_delete = ? ', array($id_region_user, 0, $is_delete));
        }
    }

    //кол-во выездов по ГРОЧС
    public function selectCountByIdLocorg($id_locorg, $is_delete) {
        return R::getCell('SELECT count(id) FROM journal.rigtable WHERE id_locorg= ?  and is_delete = ? ', array($id_locorg, $is_delete));
    }

    //кол-во выезды по органу
    public function selectCountByIdOrgan($id_organ_user, $is_delete) {
        return R::getCell('SELECT count(id) FROM journal.rigtable WHERE id_organ_user = ?  and is_delete = ? ', array($id_organ_user, $is_delete));
    }

    //кол-во выезды по РБ
    public function selectCountByRb($is_delete) {
        return R::getCell('SELECT count(id) FROM journal.rigtable WHERE is_delete = ? ', array($is_delete));
    }

    /* ---------------------------------- КОНЕЦ  Кол-во выездов ------------------------------------ */


    //проверка дат для фильтра вызовов
    public function getPOSTData() {

        $x = $_POST;
        $y = array();
        $error = array();

        /*         * * проверка на вшивость дата1 ** */
        if (isset($x['date_start']) && !empty($x['date_start'])) {
            if ($this->isDateTimeValid($x['date_start'], "Y-m-d")) {
                $y['date_start'] = $x['date_start'];
            } else {
                $error['date_start'] = ' Неверный формат даты ';
                $y['date_start'] = NULL;
            }
        } else {
           // $error['date_start'] = ' Неверный формат даты ';
            $y['date_start'] = NULL;
        }
        /*         * * END проверка на вшивость  дата1   ** */


        /*         * * проверка на вшивость дата2 ** */
        if (isset($x['date_end']) && !empty($x['date_end'])) {
            if ($this->isDateTimeValid($x['date_end'], "Y-m-d")) {
                $y['date_end'] = $x['date_end'];
            } else {
                $error['date_end'] = ' Неверный формат даты ';
                $y['date_end'] = NULL;
            }
        } else {
           // $error['date_end'] = ' Неверный формат даты ';
            $y['date_end'] = NULL;
        }
        /*         * * END проверка на вшивость  дата2   ** */


        //дата2  д.б. >= дата1
        if ($y['date_start'] != NULL && $y['date_end'] != NULL && $y['date_start'] > $y['date_end']) {
            $error['date_start_end'] = ' Начальная дата диапазона не может превышать конечную дату диапазона ';
        }


        if ($y['date_start'] != NULL && $y['date_end'] != NULL) {
            $this->setDateStart($y['date_start']);
            $this->setDateEnd($y['date_end']);
        }
        //должны быть выбраны 2 даты
               elseif($y['date_start'] != NULL || $y['date_end'] != NULL) {
            $error['date_start_end'] = ' Необходимо выбрать две даты ';
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


        /*------------------------------- Отчет 1 ------------------------------------------*/
    public function validateRep1() {
        $x = $_POST;
        $y = array();

        $y['id_region'] = (isset($x['id_region']) && !empty($x['id_region'])) ? intval($x['id_region']) : 0; //куда был выезд
        $y['id_local'] = (isset($x['id_local']) && !empty($x['id_local'])) ? intval($x['id_local']) : 0;//куда был выезд


        /*         * * проверка на вшивость дат - по умолч сег дата ставится ** */
        if (isset($x['date_start']) && !empty($x['date_start'])) {
            if ($this->isDateTimeValid($x['date_start'], "Y-m-d")) {
                $y['date_start'] = $x['date_start'];
            } else {
                $y['date_start'] = date("Y-m-d");
            }
        } else {
            $y['date_start'] = date("Y-m-d");
        }

        if (isset($x['date_end']) && !empty($x['date_end'])) {
            if ($this->isDateTimeValid($x['date_end'], "Y-m-d")) {
                $y['date_end'] = $x['date_end'];
            } else {
                $y['date_end'] = date("Y-m-d");
            }
        } else {
            $y['date_end'] = date("Y-m-d");
        }
        /*         * * END проверка на вшивость дат ** */

//        print_r($y);
//        exit();
        return  $this->getDataForRep1($y);

    }

    public function getDataForRep1($y) {
          //$sql = 'SELECT * FROM journal.rigtable WHERE date_msg BETWEEN  ? AND ? AND is_delete = ?  ';
        //$param = array($y['date_start'],$y['date_end'], 0);//все не удаленные выезды

        $this->setDateStart($y['date_start']); //c
        $this->setDateEnd($y['date_end']); //по


        $sql = 'SELECT * FROM journal.rigtable WHERE  is_delete = ?  ';
        $param = array(0);//все не удаленные выезды

        $date_filter = ' AND date_msg between ? and ? and id not in '
                . '  ( SELECT id FROM journal.rigtable WHERE is_delete = 0'
.' and (date_msg = ? and time_msg< ? ) or  (date_msg = ? and time_msg>= ? )  ) ';// с 06 утра до 06 утра
        $param[] = $this->date_start;
        $param[] = $this->date_end;

        $param[] = $this->date_start;
        $param[] = $this->time1;
        $param[] = $this->date_end;
        $param[] = $this->time2;


        if (isset($date_filter)) { //добавляем
            $sql = $sql . $date_filter;
        }


        if ($y['id_region'] != 0) { //куда был выезд
            $region = ' AND id_region = ?  ';
            $param[] = $y['id_region'];
        }

              if ($y['id_local'] != 0) { //куда был выезд
            $local = ' AND id_local = ?  ';
            $param[] = $y['id_local'];
        }

        if (isset($region)) { //добавляем
            $sql = $sql . $region;
        }

        if (isset($local)) { //добавляем
            $sql = $sql . $local;
        }

//            echo $sql;
//            var_dump($param);
//            exit();
        return R::getAll($sql, $param);

    }
            /*------------------------------- Отчет 1 ------------------------------------------*/


    /* json */
    public function selectAllForJson($is_delete,$d1,$d2) {
        //     return R::getAll('SELECT * FROM journal.rigtable WHERE id_locorg= ?  and is_delete = ? limit ? ', array($id_locorg, $is_delete, $this->limit_rigs));

        $sql = 'SELECT * FROM journal.rigtable WHERE  is_delete = ?  ';
        $param = array( $is_delete);

          $this->setDateStart($d1);
            $this->setDateEnd($d2);

        return $this->getRigTable($sql, $param);
    }

}

?>