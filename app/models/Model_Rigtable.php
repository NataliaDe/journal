<?php
/**
 * Object model mapping for relational table `ss.regions`
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Rigtable
{

    public $limit_rigs = 10;
    public $default_time_for_period = '06:00:00'; //смена с 6 утра до 6 утра
    //public $time1 = '05:59:59';
    public $time1 = '06:00:00';
    public $time2 = '06:00:00';

    //  $today =  date("Y-m-d");
    //$yesterday=date("Y-m-d", time()-(60*60*24));

    public function getToday()
    {
        return date("Y-m-d");
    }

    public function getYesterday()
    {
        return date("Y-m-d", time() - (60 * 60 * 24));
    }

    public function getDayBeforeYesterday()
    {
        return date("Y-m-d", time() - (60 * 60 * 24) - (60 * 60 * 24));
    }

    public function getTomorrow()
    {
        return date("Y-m-d", time() + (60 * 60 * 24));
    }

    public function getPeriodDefault()
    {
        $time_now = date("H:i:s");

        if ($time_now <= $this->default_time_for_period) {//до 06 утра
            $this->date1 = $this->getYesterday();
            $this->date2 = $this->getToday();
        } else {//после 06 утра
            $this->date1 = $this->getToday();
            $this->date2 = $this->getTomorrow();
        }
    }

    public function setDateStart($d)
    {
        $this->date_start = $d;
    }

    public function setDateEnd($d)
    {
        $this->date_end = $d;
    }
    /* ---------------------------------- Выборка выездов ------------------------------------ */

    //выезд по id
    public function selectAllByIdRig($id_rig, $is_delete)
    {

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

        $res = R::getAll($sql, $param);

        if (empty($res)) {

            if ($_SESSION['id_level'] == 3) {//ГРОЧС
                $new_res = $this->selectNeighborById($is_delete, $_SESSION['id_locorg'], $id_rig);

                if (!empty($new_res)) {
                    $rig_table = $this->selectAllByIdLocorgNeighbor($id_rig);
                    return $rig_table;
                } else {
                    return $res;
                }
            } elseif ($_SESSION['id_level'] == 2) {//umchs
                $new_res = $this->selectNeighborByIdRegion($is_delete, $_SESSION['id_region'], $id_rig);

                if (!empty($new_res)) {
                    $rig_table = $this->selectAllByIdRegionNeighbor($id_rig);
                    return $rig_table;
                } else {
                    return $res;
                }
            } else {
                return $res;
            }
        } else {
            return $res;
        }
        // return R::getAll($sql, $param);
    }

    //выезд по id
    public function getRigById($id_rig)
    {

        return R::getAll('SELECT * FROM journal.rigtable WHERE id = ?  ', array($id_rig));
    }

    // дата, время, адрес объекта для вызова по id
    public function selectByIdRig($id_rig)
    {

        return R::getAll('SELECT date_msg, time_msg, address, additional_field_address,id_user, id_reasonrig FROM journal.rigtable WHERE id = ? ', array($id_rig));
    }

    public function selectAll($is_delete)
    {
        return R::getAll('SELECT * FROM journal.rigtable WHERE is_delete = ?', array($is_delete));
    }

    //выезды по области
    //sign=1 - включаем в результат ЦП
    public function selectAllByIdRegion($id_region_user, $sub, $is_delete, $filter = null)
    {

        $sql = 'SELECT * FROM journal.rigtable WHERE id_region_user = ? and is_delete = ?  ';
        $param = array($id_region_user, $is_delete);

        if ($sub != 1) {//только УМЧС
            $umchs = ' AND sub = ?  ';
            $param[] = 0; //УМЧС
        }

        if (isset($umchs)) { //добавляем
            $sql = $sql . $umchs;
        }

        if (isset($filter) && isset($filter['reasonrig']) && !empty($filter['reasonrig'])) {
            $sql = $sql . ' AND id_reasonrig IN(' . implode(',', $filter['reasonrig']) . ')';
        }

        return $this->getRigTable($sql, $param);
    }

    //выезды по ГРОЧС
    public function selectAllByIdLocorg($id_locorg, $is_delete, $filter = null)
    {
        //     return R::getAll('SELECT * FROM journal.rigtable WHERE id_locorg= ?  and is_delete = ? limit ? ', array($id_locorg, $is_delete, $this->limit_rigs));

        $sql = 'SELECT * FROM journal.rigtable WHERE id_locorg = ? and is_delete = ?  ';
        $param = array($id_locorg, $is_delete);

        if (isset($filter) && isset($filter['reasonrig']) && !empty($filter['reasonrig'])) {
            $sql = $sql . ' AND id_reasonrig IN(' . implode(',', $filter['reasonrig']) . ')';
        }

        return $this->getRigTable($sql, $param);
    }

    //выезды по органу
    public function selectAllByIdOrgan($id_organ_user, $is_delete, $filter = null)
    {
        //   return R::getAll('SELECT * FROM journal.rigtable WHERE id_organ_user = ?  and is_delete = ? limit ? ', array($id_organ_user, $is_delete,  $this->limit_rigs));

        $sql = 'SELECT * FROM journal.rigtable WHERE id_organ_user = ? and is_delete = ?  ';
        $param = array($id_organ_user, $is_delete);


        if (isset($filter) && isset($filter['reasonrig']) && !empty($filter['reasonrig'])) {
            $sql = $sql . ' AND id_reasonrig IN(' . implode(',', $filter['reasonrig']) . ')';
        }

        return $this->getRigTable($sql, $param);
    }

    //выборка выездов из БД - общая часть для всех уровней
    public function getRigTable($sql, $param)
    {
        //echo $sql;
        //exit();
        if (isset($this->date_start) && isset($this->date_end)) {//с 06 00 до 06 00 по конкретным датам пользователя


            /*  $date_filter = ' AND date_msg between ? and ? and id not in '
              . '  ( SELECT id FROM journal.rigtable WHERE is_delete = 0'
              .' and (date_msg = ? and time_msg< ? ) or  (date_msg = ? and time_msg>= ? )  ) ';// с 06 утра до 06 утра
              $param[] = $this->date_start;
              $param[] = $this->date_end;

              $param[] = $this->date_start;
              $param[] = $this->time1;
              $param[] = $this->date_end;
              $param[] = $this->time2; */


            $date_filter = ' AND full_time_msg >= ? AND full_time_msg < ?'; // с 06 утра до 06 утра
            $param[] = $this->date_start . ' ' . $this->time1;
            $param[] = $this->date_end . ' ' . $this->time2;
        } else {//с 06 00 до 06 00 за текущие сутки
            $this->getPeriodDefault();


            /*    $date_filter = ' AND date_msg between ? and ? and id not in '
              . '  ( SELECT id FROM journal.rigtable WHERE is_delete = 0'
              .' and (date_msg = ? and time_msg< ? ) or  (date_msg = ? and time_msg>= ? )  ) ';// с 06 утра до 06 утра
              $param[] = $this->date1;
              $param[] = $this->date2;

              $param[] = $this->date1;
              $param[] = $this->time1;
              $param[] = $this->date2;
              $param[] = $this->time2; */

            $date_filter = ' AND full_time_msg >= ? AND full_time_msg < ?'; // с 06 утра до 06 утра
            $param[] = $this->date1 . ' ' . $this->time1;
            $param[] = $this->date2 . ' ' . $this->time2;
        }

        if (isset($date_filter)) { //добавляем
            $sql = $sql . $date_filter;
        }
//echo $sql;
        //  print_r($param);
        //  exit();
        return R::getAll($sql, $param);
    }
    /* ---------------------------------- КОНЕЦ Выборка выездов ------------------------------------ */


    /* ---------------------------------- Кол-во выездов ------------------------------------ */

    //кол-во выездов по области
    public function selectCountByIdRegion($id_region_user, $sub, $is_delete)
    {
        if ($sub == 1) {//УМЧС+ЦП
            return R::getCell('select count(id) FROM journal.rigtable WHERE id_region_user = ? and is_delete = ?', array($id_region_user, $is_delete));
        } else {//только УМЧС
            return R::getCell('SELECT count(id) FROM journal.rigtable WHERE id_region_user = ? AND sub = ? and is_delete = ? ', array($id_region_user, 0, $is_delete));
        }
    }

    //кол-во выездов по ГРОЧС
    public function selectCountByIdLocorg($id_locorg, $is_delete)
    {
        return R::getCell('SELECT count(id) FROM journal.rigtable WHERE id_locorg= ?  and is_delete = ? ', array($id_locorg, $is_delete));
    }

    //кол-во выезды по органу
    public function selectCountByIdOrgan($id_organ_user, $is_delete)
    {
        return R::getCell('SELECT count(id) FROM journal.rigtable WHERE id_organ_user = ?  and is_delete = ? ', array($id_organ_user, $is_delete));
    }

    //кол-во выезды по РБ
    public function selectCountByRb($is_delete)
    {
        return R::getCell('SELECT count(id) FROM journal.rigtable WHERE is_delete = ? ', array($is_delete));
    }
    /* ---------------------------------- КОНЕЦ  Кол-во выездов ------------------------------------ */

    //проверка дат для фильтра вызовов
    public function getPOSTData()
    {

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
        elseif ($y['date_start'] != NULL || $y['date_end'] != NULL) {
            $error['date_start_end'] = ' Необходимо выбрать две даты ';
        }


        if (isset($x['reasonrig']) && !empty($x['reasonrig'])) {
            $y['reasonrig'] = $x['reasonrig'];
        }

        if (isset($x['remember_filter_date']) && !empty($x['remember_filter_date'])) {
            $y['remember_filter_date'] = $x['remember_filter_date'];
        }

        $y['error'] = $error;


        return $y;
    }

    //проверка на формат дата-время
    public function isDateTimeValid($field, $format)
    {
        $t_exit = \DateTime::createFromFormat($format, $field);
        if ($t_exit)
            return true;
        else
            return false;
    }
    /* ------------------------------- Отчет 1 ------------------------------------------ */

    public function validateRep1($mode_by_podr = 0)
    {
        $x = $_POST;
        $y = array();

        $y['is_switch_by_podr'] = $mode_by_podr;

        $y['id_region'] = (isset($x['id_region']) && !empty($x['id_region'])) ? intval($x['id_region']) : 0; //куда был выезд
        $y['id_local'] = (isset($x['id_local']) && !empty($x['id_local'])) ? intval($x['id_local']) : 0; //куда был выезд

        $y['is_neighbor'] = (isset($x['is_neighbor']) && !empty($x['is_neighbor'])) ? $x['is_neighbor'] : 0;

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


        if (isset($x['reasonrig']) && !empty($x['reasonrig'])) {
            $y['reasonrig'] = $x['reasonrig'];
        }

        if (isset($x['id_pasp']) && !empty($x['id_pasp'])) {
            $y['id_pasp'] = $x['id_pasp'];
        }

        /*         * * END проверка на вшивость дат ** */

//        print_r($y);
//        exit();
        return $this->getDataForRep1($y);
    }

    public function getDataForRep1($y)
    {
        //$sql = 'SELECT * FROM journal.rigtable WHERE date_msg BETWEEN  ? AND ? AND is_delete = ?  ';
        //$param = array($y['date_start'],$y['date_end'], 0);//все не удаленные выезды

        $this->setDateStart($y['date_start']); //c
        $this->setDateEnd($y['date_end']); //по


        if ($y['is_switch_by_podr'] == 1) {
            $sql = 'SELECT r.* FROM journal.silymchs AS s  LEFT JOIN rigtable AS r ON r.`id`=s.`id_rig` WHERE  r.is_delete = ?  ';
        } else
            $sql = 'SELECT r.* FROM journal.rigtable as r WHERE  r.is_delete = ?  ';

        $param = array(0); //все не удаленные выезды

        /* $date_filter = ' AND r.date_msg between ? and ? and r.id not in '
          . '  ( SELECT id FROM journal.rigtable WHERE is_delete = 0'
          .' and (date_msg = ? and time_msg< ? ) or  (date_msg = ? and time_msg>= ? )  ) ';// с 06 утра до 06 утра
          $param[] = $this->date_start;
          $param[] = $this->date_end;

          $param[] = $this->date_start;
          $param[] = $this->time1;
          $param[] = $this->date_end;
          $param[] = $this->time2; */

        $date_filter = ' AND full_time_msg >= ? AND full_time_msg < ?'; // с 06 утра до 06 утра
        $param[] = $this->date_start . ' ' . $this->time1;
        $param[] = $this->date_end . ' ' . $this->time2;


        if (isset($date_filter)) { //добавляем
            $sql = $sql . $date_filter;
        }

        if (isset($y['reasonrig']) && !empty($y['reasonrig'])) {
            $reasonrig = ' AND r.id_reasonrig IN(' . implode(',', $y['reasonrig']) . ')';
            //$reasonrig = ' AND r.id_reasonrig = ?  ';
            //$param[] = $y['reasonrig'];
        }


        if ($y['is_switch_by_podr'] == 1) {

            if ($y['id_region'] != 0) { //куда был выезд
                $region = ' AND s.id_region = ?  ';
                $param[] = $y['id_region'];
            }

            if ($y['id_local'] != 0) { //куда был выезд
                $local = ' AND s.id_local = ?  ';
                $param[] = $y['id_local'];
            }




            if (isset($y['id_pasp']) && !empty($y['id_pasp'])) {
                $pasp = ' AND s.id_pasp IN(' . implode(',', $y['id_pasp']) . ')';
            }



            if (isset($region)) { //добавляем
                $sql = $sql . $region;
            }

            if (isset($local)) { //добавляем
                $sql = $sql . $local;
            }

            if (isset($reasonrig)) {
                $sql = $sql . $reasonrig;
            }

            if (isset($pasp)) {
                $sql = $sql . $pasp;
            }
            //  echo $sql;            print_r($param);exit();
            return R::getAll($sql, $param);
        }



        if ($y['id_region'] != 0) { //куда был выезд
            $region = ' AND r.id_region = ?  ';
            $param[] = $y['id_region'];
        }

        if ($y['id_local'] != 0) { //куда был выезд
            $local = ' AND r.id_local = ?  ';
            $param[] = $y['id_local'];
        }



        if ($y['id_local'] != 0 && $y['is_neighbor'] == 0 && $y['id_region'] != 3) {//not show neighbor rigs
            $local_neigbor = ' AND r.id_local_user = ?  ';
            $param[] = $y['id_local'];
        } elseif ($y['id_region'] != 0 && $y['is_neighbor'] == 0) {//not show neighbor rigs
            $local_neigbor = ' AND r.id_region_user = ?  ';
            $param[] = $y['id_region'];
        }

        if (isset($region)) { //добавляем
            $sql = $sql . $region;
        }

        if (isset($local)) { //добавляем
            $sql = $sql . $local;
        }

        if (isset($reasonrig)) {
            $sql = $sql . $reasonrig;
        }

        if (isset($local_neigbor)) {
            $sql = $sql . $local_neigbor;
        }

//            echo $sql;
//            var_dump($param);
//            exit();
        return R::getAll($sql, $param);
    }
    /* ------------------------------- Отчет 1 ------------------------------------------ */


    /* json */

    public function selectAllForJson($is_delete, $d1, $d2)
    {
        //     return R::getAll('SELECT * FROM journal.rigtable WHERE id_locorg= ?  and is_delete = ? limit ? ', array($id_locorg, $is_delete, $this->limit_rigs));

        $sql = 'SELECT * FROM journal.rigtable WHERE  is_delete = ?  ';
        $param = array($is_delete);

        $this->setDateStart($d1);
        $this->setDateEnd($d2);

        return $this->getRigTable($sql, $param);
    }

    public function selectIdRigByIdGrochs($is_delete, $id_grochs, $filter = null)
    {

        $sql = 'SELECT * FROM journal.jrig_for_neighbor WHERE grochs_of_teh = ? and is_delete = ? and id_locorg_user <> ?  ';
        $param = array($id_grochs, $is_delete, $id_grochs);

        if (isset($filter) && isset($filter['reasonrig']) && !empty($filter['reasonrig'])) {
            $sql = $sql . ' AND id_reasonrig IN(' . implode(',', $filter['reasonrig']) . ')';
        }

        $result = $this->getRigTable($sql, $param);
        // print_r($result);exit();
        $new_result = array();
        foreach ($result as $row) {
            $new_result [] = $row['id'];
        }

        return $new_result;
    }

    public function selectAllByIdLocorgNeighbor($id_rigs, $filter = null)
    {

        //     return R::getAll('SELECT * FROM journal.rigtable WHERE id_locorg= ?  and is_delete = ? limit ? ', array($id_locorg, $is_delete, $this->limit_rigs));

        if (!empty($id_rigs)) {

            if (is_array($id_rigs))
                $sql = 'SELECT r.*, 1 AS is_neighbor FROM journal.rigtable AS r WHERE r.id IN(' . implode(',', $id_rigs) . ')';
            else
                $sql = 'SELECT r.*, 1 AS is_neighbor FROM journal.rigtable AS r WHERE r.id = ' . $id_rigs;

            if (isset($filter) && isset($filter['reasonrig']) && !empty($filter['reasonrig'])) {
                $sql = $sql . ' AND id_reasonrig IN(' . implode(',', $filter['reasonrig']) . ')';
            }

            return R::getAll($sql);
        } else {
            return array();
        }
    }

    public function selectNeighborById($is_delete, $id_grochs, $id_rig)
    {

        $sql = 'SELECT * FROM journal.jrig_for_neighbor WHERE grochs_of_teh = ? and is_delete = ? and id_locorg_user <> ? and id = ?  ';
        $param = array($id_grochs, $is_delete, $id_grochs, $id_rig);

        return R::getAll($sql, $param);
    }

    public function selectIdRigByIdRegion($is_delete, $id_region, $filter = null)
    {

        $sql = 'SELECT * FROM journal.jrig_for_neighbor WHERE region_of_teh = ? and is_delete = ? and id_region_user <> ?  ';
        $param = array($id_region, $is_delete, $id_region);

        if (isset($filter) && isset($filter['reasonrig']) && !empty($filter['reasonrig'])) {
            $sql = $sql . ' AND id_reasonrig IN(' . implode(',', $filter['reasonrig']) . ')';
        }

        $result = $this->getRigTable($sql, $param);
        // print_r($result);exit();
        $new_result = array();
        foreach ($result as $row) {
            $new_result [] = $row['id'];
        }

        return $new_result;
    }

    public function selectAllByIdRegionNeighbor($id_rigs, $filter = null)
    {

        //     return R::getAll('SELECT * FROM journal.rigtable WHERE id_locorg= ?  and is_delete = ? limit ? ', array($id_locorg, $is_delete, $this->limit_rigs));

        if (!empty($id_rigs)) {

            if (is_array($id_rigs))
                $sql = 'SELECT r.*, 1 AS is_neighbor FROM journal.rigtable AS r WHERE r.id IN(' . implode(',', $id_rigs) . ')';
            else
                $sql = 'SELECT r.*, 1 AS is_neighbor FROM journal.rigtable AS r WHERE r.id = ' . $id_rigs;


            if (isset($filter) && isset($filter['reasonrig']) && !empty($filter['reasonrig'])) {
                $sql = $sql . ' AND id_reasonrig IN(' . implode(',', $filter['reasonrig']) . ')';
            }

            return R::getAll($sql);
        } else {
            return array();
        }
    }

    public function selectNeighborByIdRegion($is_delete, $id_region, $id_rig)
    {

        $sql = 'SELECT * FROM journal.jrig_for_neighbor WHERE region_of_teh = ? and is_delete = ? and id_region_user <> ? and id = ?  ';
        $param = array($id_region, $is_delete, $id_region, $id_rig);

        return R::getAll($sql, $param);
    }

    public function selectAllForCsv($is_delete, $data)
    {
        //     return R::getAll('SELECT * FROM journal.rigtable WHERE id_locorg= ?  and is_delete = ? limit ? ', array($id_locorg, $is_delete, $this->limit_rigs));


        $param = array($is_delete);
        if (isset($data['id_reasonrig'])) {
            $sql = 'SELECT r.*, SUBSTRING(REPLACE(inf_detail,CHAR(13)+CHAR(10)," "), 1, 250) AS inf_detail_1,REPLACE(inf_detail,CHAR(13)+CHAR(10)," ") AS inf_detail_2  FROM journal.rigtable as r WHERE  is_delete = ? AND id_reasonrig IN(' . implode(',', $data['id_reasonrig']) . ') AND latitude <> 0 AND longitude <> 0 AND address is not null and LENGTH(latitude) >8 and LENGTH(longitude) >8 AND inf_detail <> "" ';
            //  $param[] = $data['id_reasonrig'];
        } else {
            $sql = 'SELECT r.*, SUBSTRING(REPLACE(inf_detail,CHAR(13)+CHAR(10)," "), 1, 250) AS inf_detail_1,REPLACE(inf_detail,CHAR(13)+CHAR(10)," ") AS inf_detail_2  FROM journal.rigtable as r WHERE  is_delete = ? AND latitude is not null AND longitude <> 0 AND address is not null and LENGTH(latitude) >8 and LENGTH(longitude) >8 AND inf_detail <> ""';
        }

        $this->setDateStart($data['date_start']);
        $this->setDateEnd($data['date_end']);

        return $this->getRigTableWithLimit($sql, $param, $data['limit']);
    }

    public function getRigTableWithLimit($sql, $param, $limit = 0)
    {
        if (isset($this->date_start) && isset($this->date_end)) {//с 06 00 до 06 00 по конкретным датам пользователя


            /* $date_filter = ' AND date_msg between ? and ? and id not in '
              . '  ( SELECT id FROM journal.rigtable WHERE is_delete = 0'
              .' and (date_msg = ? and time_msg< ? ) or  (date_msg = ? and time_msg>= ? )  ) ';// с 06 утра до 06 утра
              $param[] = $this->date_start;
              $param[] = $this->date_end;

              $param[] = $this->date_start;
              $param[] = $this->time1;
              $param[] = $this->date_end;
              $param[] = $this->time2; */

            $date_filter = ' AND full_time_msg >= ? AND full_time_msg < ?'; // с 06 утра до 06 утра
            $param[] = $this->date_start . ' ' . $this->time1;
            $param[] = $this->date_end . ' ' . $this->time2;
        } else {//с 06 00 до 06 00 за текущие сутки
            $this->getPeriodDefault();


            /*  $date_filter = ' AND date_msg between ? and ? and id not in '
              . '  ( SELECT id FROM journal.rigtable WHERE is_delete = 0'
              .' and (date_msg = ? and time_msg< ? ) or  (date_msg = ? and time_msg>= ? )  ) ';// с 06 утра до 06 утра
              $param[] = $this->date1;
              $param[] = $this->date2;

              $param[] = $this->date1;
              $param[] = $this->time1;
              $param[] = $this->date2;
              $param[] = $this->time2; */

            $date_filter = ' AND full_time_msg >= ? AND full_time_msg < ?'; // с 06 утра до 06 утра
            $param[] = $this->date1 . ' ' . $this->time1;
            $param[] = $this->date2 . ' ' . $this->time2;
        }

        if (isset($date_filter)) { //добавляем
            $sql = $sql . $date_filter;
        }

        if (isset($limit) && $limit != 0)
            $sql = $sql . ' LIMIT ' . $limit;

//            print_r($sql);
//            print_r($param);
//            exit();
        return R::getAll($sql, $param);
    }

    public function setStartEndDates($start_date, $end_date)
    {
        $this->setDateStart($start_date);
        $this->setDateEnd($end_date);
    }

    public function selectAllRigByReason($reason_ids, $is_delete, $id_region = 0, $filter = NULL)
    {

        $sql = 'SELECT * FROM journal.rigtable WHERE  is_delete = ?  AND latitude is not null and longitude is not null AND latitude <> 0 AND longitude <> 0';
//print_r($id_region);
//echo implode(',', $id_region);
        if ($id_region != 0 && !empty($id_region)) {
            if (is_array($id_region))
                $sql = $sql . ' AND id_region IN (' . implode(',', $id_region) . ') ';
            else
                $sql = $sql . ' AND id_region = ' . $id_region;
        } elseif (isset($filter['id_region']) && !empty($filter['id_region'])) {
            $sql = $sql . ' AND id_region IN (' . implode(',', $filter['id_region']) . ') ';
        }



        if (isset($filter['id_local']) && !empty($filter['id_local'])) {
            $sql = $sql . ' AND id_local IN (' . implode(',', $filter['id_local']) . ') ';
        }

        $param = array($is_delete);

        if (is_array($reason_ids) && !empty($reason_ids)) {
            $sort_reasonrig = ' AND id_reasonrig IN(' . implode(',', $reason_ids) . ') ';
        }

        if (isset($sort_reasonrig)) {
            $sql = $sql . $sort_reasonrig;
        }

        return $this->getRigTable($sql, $param);
    }

    public function get_dublicate_pasp_by_coords($filter)
    {

//        $sql = 'SELECT  *
//FROM    pasp mto
//WHERE   EXISTS
//        (
//        SELECT  1
//        FROM    pasp mti
//        WHERE   mti.latitude = mto.latitude
//        AND mti.longitude = mto.longitude
//        LIMIT 1, 1
//        )';


        $sql='select * from journal.pasp as p where p.latitude <> 0 and p.latitude is not null and p.longitude <> 0 and p.longitude is not null'
            . ' AND p.longitude = ? AND p.latitude = ? AND p.id <> ?';


        $param[]=$filter['longitude'];
        $param[]=$filter['latitude'];
        $param[]=$filter['id'];

        if (isset($filter['id_region']) && !empty($filter['id_region'])) {
            $sql = $sql . ' AND id_region IN (' . implode(',', $filter['id_region']) . ') ';
        }

        if (isset($filter['id_local']) && !empty($filter['id_local'])) {
            $sql = $sql . ' AND id_local IN (' . implode(',', $filter['id_local']) . ') ';
        }



        return R::getAll($sql,$param);
    }


        public function selectIdRigByIdGrochsOfTeh($is_delete, $id_grochs_teh,$id_grochs_creator, $filter = null)
    {

        $sql = 'SELECT * FROM journal.jrig_for_neighbor WHERE grochs_of_teh = ? and is_delete = ? and id_locorg_user <> ?  ';
        $param = array($id_grochs_teh, $is_delete, $id_grochs_creator);

        if (isset($filter) && isset($filter['reasonrig']) && !empty($filter['reasonrig'])) {
            $sql = $sql . ' AND id_reasonrig IN(' . implode(',', $filter['reasonrig']) . ')';
        }

        $result = $this->getRigTable($sql, $param);
        // print_r($result);exit();
        $new_result = array();
        foreach ($result as $row) {
            $new_result [] = $row['id'];
        }

        return $new_result;
    }


        public function selectRigsByIds($id_rigs, $filter = null)
    {

        //     return R::getAll('SELECT * FROM journal.rigtable WHERE id_locorg= ?  and is_delete = ? limit ? ', array($id_locorg, $is_delete, $this->limit_rigs));

        if (!empty($id_rigs)) {

            if (is_array($id_rigs))
                $sql = 'SELECT r.* FROM journal.rigtable AS r WHERE r.id IN(' . implode(',', $id_rigs) . ')';
            else
                $sql = 'SELECT r.* FROM journal.rigtable AS r WHERE r.id = ' . $id_rigs;

            if (isset($filter) && isset($filter['reasonrig']) && !empty($filter['reasonrig'])) {
                $sql = $sql . ' AND id_reasonrig IN(' . implode(',', $filter['reasonrig']) . ')';
            }

            return R::getAll($sql);
        } else {
            return array();
        }
    }



        public function select_all_rigs($filter)
    {

        $sql = 'SELECT id,locality_id,date_msg,time_msg,full_time_msg,local_name,region_name,locality_id_vid, address_type_table_4,additional_field_address,object,'
            . ' id_owner_category,category_name,owner_fio,owner_year_birthday,owner_position,owner_job,inf_detail,id_reasonrig,is_sily_mchs,'
            . 'time_loc,time_likv,is_likv_before_arrival,is_not_measures,is_closed, latitude, longitude  FROM journal.rigtable WHERE is_delete = ?  and locality_id is not null';
        $param = array(0);


                if (isset($filter) && isset($filter['id_local']) && !empty($filter['id_local']) ) {
            $sql = $sql . ' AND id_local =' .$filter['id_local'];
        }
        elseif (isset($filter) && isset($filter['id_region']) && !empty($filter['id_region']) && $filter['id_region'] !=0) {
            $sql = $sql . ' AND id_region =' . $filter['id_region'];
        }

            if (isset($filter) && isset($filter['reasonrig']) && !empty($filter['reasonrig']) ) {
            $sql = $sql . ' AND id_reasonrig IN(' . implode(',', $filter['reasonrig']).')';
        }

        return $this->getRigTable($sql, $param);
    }


}

?>