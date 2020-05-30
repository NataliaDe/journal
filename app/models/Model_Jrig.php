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

            public function selectAllInIdRig($id_rig) {

				$new_result=array();

				if(!empty($id_rig)){
					    $str_id_rig = implode(',', $id_rig);
        $result = R::getAll('SELECT * FROM jrig WHERE id_rig IN (  ' . $str_id_rig . ')');
        foreach ($result as $row) {
            $new_result[$row['id_rig']] []= $row;
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
              //  $y[$key]['distance'] = 0;

			  $y[$key]['distance'] = (isset($row['distance']) && !empty($row['distance'])) ? $row['distance'] : 0;

$y[$key]['is_return'] = 1;

                // проверка на вшивость Время выезда
                if (isset($row['time_exit']) && !empty($row['time_exit'])) {
                    if ($this->isDateTimeValid($row['time_exit'], "Y-m-d H:i") == true) {
                        $y[$key]['time_exit'] = $row['time_exit'].':00';
                    } else {
                        $error['time_exit'] = ' Поле "Время выезда" должно быть датой. Формат без секунд! ';
                    }
                } else {
                    $y[$key]['time_exit'] = NULL;
                }


                //проверка на вшивость Время возвращения
                if (isset($row['time_return']) && !empty($row['time_return'])) {
                    if ($this->isDateTimeValid($row['time_return'], "Y-m-d H:i") == true) {
                        $y[$key]['time_return'] = $row['time_return'].':00';
                    } else {
                        $error['time_return'] = ' Поле "Время возвращения" должно быть датой. Формат без секунд! ';
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
                if ($this->isDateTimeValid($row['time_exit'], "Y-m-d H:i")) {
                    $y[$key]['time_exit'] = $row['time_exit'].':00';
                } else {
                    $error['time_exit'] = ' Поле "Время выезда" должно быть датой ';
                }
            } else {
                $y[$key]['time_exit'] = NULL;
            }
            /*             * * END проверка на вшивость Время выезда  ** */

            /*             * * проверка на вшивость Время прибытия  ** */
            if (isset($row['time_arrival']) && !empty($row['time_arrival'])) {
                if ($this->isDateTimeValid($row['time_arrival'], "Y-m-d H:i") == true) {
                    $y[$key]['time_arrival'] = $row['time_arrival'].':00';
                } else {
                    $error['time_arrival'] = ' Поле "Время прибытия" должно быть датой. Формат без секунд! ';
                }
            } else {
                $y[$key]['time_arrival'] = NULL;
            }
            /*             * *  END проверка на вшивость Время прибытия  ** */

            /*             * **** время выезда< время прибытия ******* */
            if ( !empty($y[$key]['time_arrival']) && $y[$key]['time_arrival'] < $y[$key]['time_exit'] ) {
                $error['time_exit_arrival'] = ' Время выезда не может превышать время прибытия ';
            }
            /*             * **** END время выезда< время прибытия ******* */

               /*             * ****  время следования ******* */
             /*   if (isset($row['time_follow']) && !empty($row['time_follow'])) {
                if ($this->isDateTimeValid($row['time_follow'], "H:i") == true) {
                    $y[$key]['time_follow'] = $row['time_follow'].':00';
                } else {
                     $y[$key]['time_follow'] = NULL;
                    $error['time_follow'] = ' Поле "Время следования" должно иметь формат времени. Формат без секунд! ';
                }
            } else {
                $y[$key]['time_follow'] = NULL;
            }*/


			if (isset($y[$key]['time_exit']) && !empty($y[$key]['time_exit']) && isset($y[$key]['time_arrival']) && !empty($y[$key]['time_arrival'])) {

                    $datetime1 = new \DateTime($y[$key]['time_exit']);
                    $datetime2 = new \DateTime($y[$key]['time_arrival']);
                    $interval = $datetime1->diff($datetime2);
//$elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
                    $elapsed = $interval->format('%H:%I:%S');
                    $y[$key]['time_follow'] = $elapsed;
                } else {
                    $y[$key]['time_follow'] = '00:00:00';
                }



   /*             * **** END время следования ******* */

            /*             * * проверка на вшивость Время окончания работ ** */
            if (isset($row['time_end']) && !empty($row['time_end'])) {
                if ($this->isDateTimeValid($row['time_end'], "Y-m-d H:i") == true) {
                    $y[$key]['time_end'] = $row['time_end'].':00';
                } else {
                    $error['time_end'] = ' Поле "Время окончания работ" должно быть датой. Формат без секунд! ';
                }
            } else {
                $y[$key]['time_end'] = NULL;
            }
            /*             * * END проверка на вшивость Время окончания работ ** */


            /*             * * проверка на вшивость Время возвращения ** */
            if (isset($row['time_return']) && !empty($row['time_return'])) {
                if ($this->isDateTimeValid($row['time_return'], "Y-m-d H:i") == true) {
                    $y[$key]['time_return'] = $row['time_return'].':00';
                } else {
                    $error['time_return'] = ' Поле "Время возвращения" должно быть датой. Формат без секунд! ';
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


	    public function get_jrig_by_rigs($ids_rig)
    {
        $jrig = R::getAll("SELECT
  `s`.`id`             AS `id_sily`,
  `s`.`id_rig`         AS `id_rig`,
  `s`.`id_teh`         AS `id_teh`,

  (CASE WHEN ISNULL(`t`.`mark`) THEN `s`.`mark` ELSE CONVERT(`t`.`mark` USING utf8mb4) END) AS `mark`,
  (CASE WHEN ISNULL(`t`.`numbsign`) THEN `s`.`numbsign` ELSE CONVERT(`t`.`numbsign` USING utf8mb4) END) AS `numbsign`,
  `reg`.`name`         AS `region_name`,


  (CASE WHEN (`org`.`id` = 7) THEN CONCAT(`org`.`name`,' №',`locor`.`no`) ELSE CONCAT('') END) AS `paso_object_num`,

  (CASE WHEN (`rec`.`divizion_num` = 0) THEN `d`.`name` ELSE CONCAT(`d`.`name`,' № ',`rec`.`divizion_num`) END) AS `pasp_name`,

  ( CASE WHEN (`org`.`id` = 6 OR `org`.`id` = 8 OR `rec`.`id_divizion` = 7 OR org.`id`=4) THEN CONCAT('')
 WHEN(org.`id`=9 OR org.`id`=12 OR (rec.`id_divizion`=8 AND org.`id`=8)) THEN CONCAT(org.`name`)

  WHEN (`org`.`id` = 7) THEN CONCAT(`org`.`name`,' №',`locor`.`no`,' ',REPLACE(`loc`.`name`,'ий','ого'),' ',`orgg`.`name`)

  ELSE CONCAT(REPLACE(`loc`.`name`,'ий','ого'),' ',`org`.`name`) END) AS `locorg_name`,

  `s`.`time_exit`      AS `time_exit`,
  `s`.`time_arrival`   AS `time_arrival`,
  `s`.`time_follow`    AS `time_follow`,
  `s`.`time_end`       AS `time_end`,
  `s`.`time_return`    AS `time_return`,
  `s`.`distance`       AS `distance`,
  `s`.`is_return`      AS `is_return`
FROM (((((((((`journal`.`silymchs` `s`
           LEFT JOIN `ss`.`technics` `t`
             ON ((`t`.`id` = `s`.`id_teh`)))
          LEFT JOIN `ss`.`regions` `reg`
            ON ((`reg`.`id` = `s`.`id_region`)))
         LEFT JOIN `ss`.`locorg` `locor`
           ON ((`locor`.`id` = `s`.`id_locorg`)))
        LEFT JOIN `ss`.`locals` `loc`
          ON ((`loc`.`id` = `locor`.`id_local`)))
       LEFT JOIN `ss`.`organs` `org`
         ON ((`locor`.`id_organ` = `org`.`id`)))
      LEFT JOIN `ss`.`organs` `orgg`
        ON ((`locor`.`oforg` = `orgg`.`id`)))
     LEFT JOIN `ss`.`records` `rec`
       ON ((`rec`.`id` = `t`.`id_record`)))
    LEFT JOIN `ss`.`divizions` `d`
      ON ((`d`.`id` = `rec`.`id_divizion`)))

     ) WHERE id_rig IN (  ". implode(',', $ids_rig).')');


        return $jrig;
    }

       public function is_neighbor_rig($id_rig)
    {

        return R::getAll('SELECT r.id
FROM silymchs AS s
LEFT JOIN rig AS r ON r.id=s.id_rig
LEFT JOIN user AS u ON u.id=r.id_user
LEFT JOIN ss.locorg AS locor ON locor.id=u.id_locorg
WHERE r.id IS NOT NULL AND s.id_local IS NOT NULL AND locor.id_local IS NOT NULL AND r.is_delete=?
AND r.id=? AND s.id_local <> locor.id_local ', array(0,$id_rig));
    }

}
