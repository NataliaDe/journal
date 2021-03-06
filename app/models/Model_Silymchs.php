<?php

/**
 * Object model mapping for relational table `ss.regions`
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Silymchs {

    public $id;
    public $id_rig;

    public function setIdRig($id_rig) {
        $this->id_rig = $id_rig;
    }
        public function setDateInsert() {
        return $this->date_insert = date("Y-m-d H:i:s");
    }

//    public function selectAll() {
//           return R::getAll('SELECT * FROM journal.service ORDER BY name ASC');
//
//    }

    public function getPOSTData() {
        $x = $_POST['silymchs'];
        $y = array();
        foreach ($x as $key => $value) {
            //не учитывать,если не выбрана
            if (empty($x[$key]['id_teh'])) {
                unset($x[$key]);
            } else {

                //для кажд техники указывать область,ГРОЧС,ПАСЧ
                foreach ($x[$key]['id_teh'] as $teh) {
                    $y[intval($teh)]['id_region'] = intval($value['id_region']);
                    $y[intval($teh)]['id_locorg'] = intval($value['id_locorg']);
                    $y[intval($teh)]['id_pasp'] = intval($value['id_pasp']);

                    $id_local=R::getCell('select id_local from ss.locorg where id=?',array($y[intval($teh)]['id_locorg']));
                    $y[intval($teh)]['id_local'] = intval($id_local);
                    $id_organ=R::getCell('select id_organ from ss.locorg where id=?',array($y[intval($teh)]['id_locorg']));
                    $y[intval($teh)]['id_organ'] = intval($id_organ);
                }
            }
        }
        return $y;
    }

    public function save($array, $id_rig) {
        $this->setIdRig($id_rig);

        // что сейчас в БД
        $sily_from_bd = $this->selectAllByIdRig($id_rig,1);
//        print_r($sily_from_bd);
//        exit();

        //если не выбрано ни одной ед на данном выезде
        if (empty($array)) {
            //но в БД были ед на данном выезде
            if (isset($sily_from_bd) && !empty($sily_from_bd)) {
                //очистить
                $this->deleteById($sily_from_bd);
            }
        } else {
            //в БД были службы на данном выезде
            if (isset($sily_from_bd) && !empty($sily_from_bd)) {
                //ищем совпадения из формы и из БД id silymchs- если найдены-ничего не выполнять
                foreach ($sily_from_bd as $key_bd => $value_bd) {
                    if (!empty($array)) {
                        foreach ($array as $key => $value) {
                            if ($value_bd['id_teh'] == $key) {
                                //убираем из массива
                                unset($array[$key]);
                                unset($sily_from_bd[$key_bd]);
                                break;
                            }
                        }
                    }
                }

                //если на форме было > служб, чем в БД- добавить оставшихся
                if (!empty($array)) {
                    //foreach ($array as $key => $value) {
                    //новая служба
                    $this->updateById($array);
                    //}
                }

                //удалить из БД оставшихся-лишних, (если на форме выбрано меньше служб, чем было в БД)
                if (!empty($sily_from_bd)) {
                    //очистить
                    $this->deleteById($sily_from_bd);
                }
            } else {//в БД было пусто
                //добавление
                $this->updateById($array);
            }
        }
    }

    public function selectAllByIdRig($id_rig,$is_delete=0) {
        $this->setIdRig($id_rig);
        if($is_delete != 0){//выбор техники без удаленной
             return R::getAll('SELECT * FROM journal.silymchs WHERE id_rig = ? AND is_delete = ? ', array($this->id_rig,0));
        }
 else {//all
      return R::getAll('SELECT * FROM journal.silymchs WHERE id_rig = ?', array($this->id_rig));
 }

    }

    //техника, которая на выезде. признак - время возвращения пусто
    public function selectAllOnRig() {
        return R::getAll('SELECT * FROM journal.silymchs WHERE  time_arrival IS NULL');
    }

    // [id_pasp]=array(teh1,teh2,...)
    public function selectGroupByPasp($id_rig) {
        $this->setIdRig($id_rig);
 $today=  date("Y-m-d");//выбор техники из строевой на сегодняшн.сутки
        $y = array();

        //выбор всех id ПАСЧ, из которых выезжала техника (без удаленной техники из карточки )
        $id_pasp = R::getAll('SELECT distinct id_pasp FROM journal.silymchs WHERE id_rig = ? AND is_delete = ? ', array($this->id_rig,0));

        //id pasp, где есть удаленная техника
        $id_pasp_with_delete = R::getAll('SELECT distinct id_pasp FROM journal.silymchs WHERE id_rig = ? AND is_delete = ? ', array($this->id_rig,1));

        //для кажд ПАСЧ выбрать всю технику, которая выезжала и техника не удаленя из КУСиС
        foreach ($id_pasp as $value) {
            $teh = R::getAll('SELECT * FROM journal.silymchs WHERE id_rig = ? and id_pasp = ?  ', array($this->id_rig, $value['id_pasp']));

            /* --------- техника ПАСЧ, которая выезжала-------- */
            // [id_pasp]=>array(id_region,id_locorg, teh=>array(id_teh,mark,numbsign))
            foreach ($teh as $row) {
                $y[$value['id_pasp']]['id_region'] = $row['id_region'];
                $y[$value['id_pasp']]['id_locorg'] = $row['id_locorg'];
                $y[$value['id_pasp']]['teh'][] = array('id_teh' => $row['id_teh'], 'numbsign' => $row['numbsign'], 'mark' => $row['mark']);
            }
            /* --------- END техника ПАСЧ, которая выезжала-------- */

            /* ---------вся техника ПАСЧ-------- */
         //   $today = '2018-03-28';

            $all_teh = R::getAssoc("CALL `getListTeh`('{$value['id_pasp']}','{$today}');");
            foreach ($all_teh as $row) {
                $y[$value['id_pasp']]['all_teh'][] = array('id_teh' => $row['id_teh'], 'numbsign' => $row['numbsign'], 'mark' => $row['mark']);
            }
            /* --------- END вся техника ПАСЧ-------- */

            /* --------- техника из др ПАСЧ - пометить как (К)------- */
            $on_reserve = R::getAssoc("CALL `getReserveTeh`('{$value['id_pasp']}','{$today}');");
            $y[$value['id_pasp']]['reserve_teh'] = $on_reserve;
            /* --------- END техника из др ПАСЧ - пометить как (К)------- */

        }


            /* --------- техника  ПАСЧ, которая была удалена из КУСиС------- */
        if (!empty($id_pasp_with_delete)) {
            foreach ($id_pasp_with_delete as $d) {
                $delete_teh = R::getAll('SELECT * FROM journal.silymchs WHERE id_rig = ? and id_pasp = ? AND is_delete = ? ', array($this->id_rig, $d['id_pasp'], 1));
                $y['delete_teh'][$d['id_pasp']] = $delete_teh;
            }
        }

        /* --------- END техника  ПАСЧ, которая была удалена из КУСиС------- */

//        print_r($y);
//        exit();
        return $y;
    }

    public function updateById($array) {
        //техника либо добавляется к уже имеющейся в бд/удаляется лишняя
        foreach ($array as $key => $value) {

            $numbsign = R::getCell('select numbsign from ss.technics where id = ?', array($key));
            $mark = R::getCell('select mark from ss.technics where id = ?', array($key));

            /* 1 - br, 2-reserv,3-repaire,4-TO1, 5-TO2*/
            $status_teh=R::getCell('select CASE WHEN(c.id_type=1) THEN 1 WHEN(c.id_type=2) THEN 2 WHEN(c.is_repair=1) THEN 3'
                . '  WHEN(c.id_to=1) THEN  4 WHEN(c.id_to=2) THEN 5 ELSE 0 END AS status_car from str.car as c where id_teh = ?
                    ORDER BY c.dateduty DESC
                    LIMIT ?', array($key,1));

            //новая ед
            $sily = R::dispense('silymchs');
            $sily->id_rig = $this->id_rig;
            $sily->id_teh = $key;
            $sily->numbsign = $numbsign;
            $sily->mark = $mark;
            $sily->status_teh = $status_teh;
            $sily->id_region = $value['id_region'];
            $sily->id_locorg = $value['id_locorg'];
            $sily->id_pasp = $value['id_pasp'];
            $sily->time_exit = date("Y-m-d H:i:s");
            $sily->date_insert = $this->setDateInsert();
			$sily->id_local = $value['id_local'];
            $sily->id_organ = $value['id_organ'];
            R::store($sily);
        }
    }

    function deleteById($array) {
        foreach ($array as $key => $value) {
            $s = R::load('silymchs', $value['id']);
            R::trash($s);
        }
    }



    function getIdPasp($id_rig, $is_delete = 0) {

        $this->setIdRig($id_rig);
        if ($is_delete != 0) {//выбор техники без удаленной
            return R::getAll('SELECT id_pasp FROM journal.silymchs WHERE id_rig = ? AND is_delete = ? ', array($this->id_rig, 0));
        } else {//all
            return R::getAll('SELECT id_pasp FROM journal.silymchs WHERE id_rig = ?', array($this->id_rig));
        }
    }

	        function getNotFullSily($ids_rig)
    {
        return R::getAll('SELECT id_rig FROM journal.jrig WHERE id_rig IN ('. implode(',', $ids_rig).') AND '
            . ' (id_teh is not null AND  time_exit is not null AND time_return is null)');
    }


	        public function copy_silymchs($array)
    {
        $sily = R::dispense('silymchs');
        $sily->import($array);
        $new_id = R::store($sily);
        return $new_id;
    }


            public function copy_trunk($array)
    {
        $sily = R::dispense('trunkrig');
        $sily->import($array);
        $new_id = R::store($sily);
        return $new_id;
    }

}

?>