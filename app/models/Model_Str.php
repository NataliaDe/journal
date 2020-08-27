<?php
/**
 * Object model mapping for relational table `ss.regions`
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Str
{

    public function get_main_by_id_pasp($id_pasp)
    {
        return R::getRow('SELECT m.dateduty,m.ch,m.id_card,m.listls as on_list_ch,m.countls as shtat_ch, m.vacant as vacant_ch,m.face as face_ch,m.calc as br_ch, m.duty as cnt_naryd, m.gas, m.fio_duty FROM str.main AS m'
                . ' WHERE m.id_card = ? AND m.is_duty = ? ORDER BY m.dateduty DESC LIMIT ? ', array($id_pasp, 1, 1));
    }

    public function get_dutych()
    {
        return R::getRow('SELECT * FROM str.dutych'
                . '  ORDER BY start_date DESC LIMIT ?', array(1));
    }

    public function get_cars_by_pasp($id_pasp, $dateduty, $ch, $filter = [])
    {


        //$result = R::getAssoc("CALL str.`getAllCarsInPaspForMap`({$id_pasp}, '{$dateduty}', '{$ch}')");

        $sql = "SELECT c.id, c.id AS id_car, c.ch, c.dateduty,
1 AS my,
 t.mark, t.id AS id_teh,
CASE WHEN(c.t_type=1) THEN CONCAT('(Бр)')
WHEN(c.t_type=2) THEN CONCAT('(Рез)')
WHEN(c.t_type=3) THEN CONCAT('(ТО-1)')
WHEN(c.t_type=4) THEN CONCAT('(ТО-2)')
WHEN(c.t_type=5) THEN CONCAT('(Рем)')
ELSE CONCAT('') END AS `status`,
c.t_type as id_type_car,
(CASE
WHEN (((`rec`.`id_divizion` = 8) OR (`rec`.`id_divizion` = 9)) AND (`org`.`id` = 4) AND (`loc`.`id_region` = 3)) THEN CONCAT(`d`.`name`,' ',`rec`.`divizion_num`)
WHEN ((`rec`.`id_divizion` = 8) AND (`rec`.`cou_with_slhs` = 1)) THEN CONCAT(`d`.`name`,'ш')
WHEN (`rec`.`id_divizion` = 4) THEN CONCAT(org.name,' ',loc.name)

 WHEN ( (`rec`.`id_divizion` = 8) OR (`rec`.`id_divizion` = 9) OR (`rec`.`id_divizion` = 10) OR (`org`.`id` = 12)) THEN `d`.`name`
 WHEN ((`org`.`id` = 6) AND (`loc`.`id_region` = 3)) THEN CONCAT(`org`.`name`)
 WHEN ((`org`.`id` = 6) OR (`rec`.`id_divizion` = 7)) THEN CONCAT(`loc`.`name`,' ',`org`.`name`)
 WHEN (`rec`.`divizion_num` = 0) THEN `d`.`name` ELSE CONCAT(`d`.`name`,'-',`rec`.`divizion_num`) END) AS `pasp_name_spec_real`,

  (CASE WHEN ((`rec`.`id_divizion` = 4) OR (`rec`.`id_divizion` = 10)) THEN CONVERT(CONCAT('') USING utf8)

  WHEN ((`rec`.`id_divizion` = 8) OR (`rec`.`id_divizion` = 9)) THEN CONCAT(REPLACE(`loc`.`name`,'ий','ого'),' ',`org`.`name`)
  WHEN ((`org`.`id` = 6) AND (`loc`.`id_region` = 3)) THEN CONCAT('ММ ',`loc`.`name`)
  WHEN ((`org`.`id` = 6) OR (`rec`.`id_divizion` = 7) OR (`org`.`id` = 12)) THEN CONVERT(CONCAT('') USING utf8)
  WHEN ((`org`.`id` = 9) AND (`loc`.`id_region` = 3)) THEN CONVERT(CONCAT('УГЗ г.Минск') USING utf8) WHEN ((`org`.`id` = 9) AND (`loc`.`id_region` = 4)) THEN CONVERT(CONCAT('УГЗ г.Гомель') USING utf8)
  WHEN ((`org`.`id` = 9) AND (`loc`.`id_region` = 6)) THEN CONVERT(CONCAT('УГЗ г.Борисов') USING utf8)
  WHEN (`org`.`id` = 7) THEN CONCAT(`org`.`name`,' №',`locor`.`no`,' ',REPLACE(`loc`.`name`,'ий','ого'),' ',`orgg`.`name`)
  ELSE CONCAT(REPLACE(`loc`.`name`,'ий','ого'),' ',`org`.`name`) END) AS `of_locorg_name_spec_real`,

(CASE WHEN (((`rec`.`id_divizion` = 8) OR (`rec`.`id_divizion` = 9)) AND (`org`.`id` = 4) AND (`loc`.`id_region` = 3)) THEN CONCAT(`d`.`name`,' ',`rec`.`divizion_num`) WHEN ((`rec`.`id_divizion` = 4) OR (`rec`.`id_divizion` = 7) OR (`rec`.`id_divizion` = 8) OR (`rec`.`id_divizion` = 9) OR (`rec`.`id_divizion` = 10)) THEN `d`.`name` WHEN ((`org`.`id` = 12) OR (`org`.`id` = 6)) THEN `org`.`name` WHEN (`rec`.`divizion_num` = 0) THEN `d`.`name` ELSE CONCAT(`d`.`name`,'-',`rec`.`divizion_num`) END) AS `pasp_name_spec`,
  (CASE WHEN ((((`rec`.`id_divizion` = 8) OR (`rec`.`id_divizion` = 9)) AND (`org`.`id` = 8)) OR (`org`.`id` = 9)) THEN CONCAT(`org`.`name`)
   WHEN (((`rec`.`id_divizion` = 8) OR (`rec`.`id_divizion` = 9)) AND (`org`.`id` = 6)) THEN CONCAT(REPLACE(`loc`.`name`,'ий','ого'),' ',`org`.`name`)
   WHEN (((`rec`.`id_divizion` = 8) OR (`rec`.`id_divizion` = 9)) AND (`org`.`id` = 4) AND (`loc`.`id_region` = 3)) THEN CONCAT(`loc`.`name`)
   WHEN ((`org`.`id` = 6) AND (`loc`.`id_region` = 3)) THEN CONCAT('ММ ',`loc`.`name`)
   WHEN ((`org`.`id` = 6) AND (`loc`.`id_region` <> 3)) THEN CONCAT(REPLACE(`loc`.`name`,'ий','ого'),' ','УМЧС')

 WHEN ((rec.id_divizion = 7) AND (`loc`.`id_region` = 3)) THEN CONCAT(`loc`.`name`,'а')
    WHEN ((rec.id_divizion = 7) AND (`loc`.`id_region` <> 3)) THEN CONCAT(REPLACE(`loc`.`name`,'ий','ого'),' ','УМЧС')

   WHEN ((`rec`.`id_divizion` = 4)  OR (`rec`.`id_divizion` = 10) OR (`org`.`id` = 12)) THEN CONVERT(CONCAT('') USING utf8) WHEN (`org`.`id` = 7) THEN CONCAT(`org`.`name`,' №',`locor`.`no`,' ',REPLACE(`loc`.`name`,'ий','ого'),' ',`orgg`.`name`) WHEN (`loc`.`name` = 'Заводской') THEN CONCAT(REPLACE(`loc`.`name`,'ой','ого'),' ',`org`.`name`) WHEN (`loc`.`name` = 'Центральный') THEN CONCAT(REPLACE(`loc`.`name`,'ый','ого'),' ',`org`.`name`) ELSE CONCAT(REPLACE(`loc`.`name`,'ий','ого'),' ',`org`.`name`) END) AS `locorg_name_spec`,


 t.v AS v_ac,
 t.id_view,
 vie.name as view_name,
 vie.description as view_abbr,
 vie.id_vid as id_vid_car,
  COUNT(fc.id_fio) AS man_per_car
FROM str.`car` AS c
LEFT JOIN ss.`technics` AS t ON t.`id`=c.`id_teh`
LEFT JOIN `ss`.`records` `rec` ON rec.id=t.id_record
LEFT JOIN `ss`.`views` `vie` ON t.id_view=vie.id
LEFT JOIN `ss`.`divizions` `d` ON `rec`.`id_divizion` = `d`.`id`
LEFT JOIN `ss`.`locorg` `locor` ON `locor`.`id` = `rec`.`id_loc_org`
LEFT JOIN `ss`.`locals` `loc` ON `loc`.`id` = `locor`.`id_local`
LEFT JOIN `ss`.`organs` `org` ON `locor`.`id_organ` = `org`.`id`
LEFT JOIN `ss`.`organs` `orgg` ON `locor`.`oforg` = `orgg`.`id`
LEFT JOIN str.fiocar AS fc ON fc.id_tehstr=c.id
WHERE c.id IS NOT NULL AND
c.ch=" . $ch . "
 AND t.`id_record`=" . $id_pasp . "
 AND c.`id_teh` IS NOT NULL
 AND c.`id_teh` NOT  IN
 (SELECT  tr.`id_teh`  FROM  str.`tripcar` AS tr
LEFT JOIN ss.`technics` AS te ON te.`id`= tr.`id_teh`
 WHERE
 (( '" . $dateduty . "' BETWEEN tr.date1 AND tr.date2) OR( '" . $dateduty . "'  >= tr.date1 AND tr.date2 IS NULL)) AND tr.`id_teh` IS NOT NULL)

 ";

        // -- c.dateduty=dateduty and


        if (isset($filter['id_name_car']) && !empty($filter['id_name_car'])) {
            $sql = $sql . ' AND t.id_view IN(' . implode(',', $filter['id_name_car']) . ')';
        }



        if (isset($filter['id_type_car']) && !empty($filter['id_type_car'])) {
            $sql = $sql . ' AND c.t_type = ' . $filter['id_type_car'];
        }

        if (isset($filter['id_ob_car']) && !empty($filter['id_ob_car'])) {


            $sql_v = '';

            foreach ($filter['id_ob_car'] as $v) {

                if ($v == 1) {
                    if ($sql_v == '')
                        $sql_v = $sql_v . ' (t.v >= 1000 and t.v <= 4000)';
//                        $sql_v = $sql_v . ' p.v <= 4000';
                    else
                        $sql_v = $sql_v . ' OR (t.v >= 1000 and t.v <= 4000)';
//                        $sql_v = $sql_v . ' OR p.v <= 4000 ';
                }
                elseif ($v == 2) {
                    if ($sql_v == '')
                        $sql_v = $sql_v . ' (t.v > 4000 and t.v <= 7000)';
                    else
                        $sql_v = $sql_v . ' OR (t.v > 4000 and t.v <= 7000)';
                }
                elseif ($v == 3) {

                    if ($sql_v == '')
                        $sql_v = $sql_v . ' t.v >= 8000 ';
                    else
                        $sql_v = $sql_v . ' OR t.v >= 8000 ';
                }
            }
            $sql = $sql . ' AND  ( ' . $sql_v . ') ';
        }

        if (isset($filter['id_vid_car']) && !empty($filter['id_vid_car'])) {
            $sql = $sql . ' and vie.id_vid IN(' . implode(',', $filter['id_vid_car']) . ')';
        }


        $sql = $sql . ' GROUP BY c.id';


        $reserve = "UNION(
SELECT c_tr.id,  c_tr.id AS id_car, c_tr.ch, c_tr.dateduty,
0 AS my,
t_tr.mark,t_tr.id AS id_teh,
CASE WHEN(c_tr.t_type=1) THEN CONCAT('(Бр)')
WHEN(c_tr.t_type=2) THEN CONCAT('(Рез)')
WHEN(c_tr.t_type=3) THEN CONCAT('(ТО-1)')
WHEN(c_tr.t_type=4) THEN CONCAT('(ТО-2)')
WHEN(c_tr.t_type=5) THEN CONCAT('(Рем)')
ELSE CONCAT('') END AS `status`,
c_tr.t_type as id_type_car,
(CASE
WHEN (((`rec_t`.`id_divizion` = 8) OR (`rec_t`.`id_divizion` = 9)) AND (`org_t`.`id` = 4) AND (`loc_t`.`id_region` = 3)) THEN CONCAT(`d_t`.`name`,' ',`rec_t`.`divizion_num`)
WHEN (`rec_t`.`id_divizion` = 4) THEN CONCAT(org_t.name,' ',loc_t.name)
WHEN ((`rec_t`.`id_divizion` = 8) AND (`rec_t`.`cou_with_slhs` = 1)) THEN CONCAT(`d_t`.`name`,'ш')

WHEN ((`rec_t`.`id_divizion` = 8) OR (`rec_t`.`id_divizion` = 9) OR (`rec_t`.`id_divizion` = 10) OR (`org_t`.`id` = 12)) THEN `d_t`.`name`
 WHEN ((`org_t`.`id` = 6) AND (`loc_t`.`id_region` = 3)) THEN CONCAT(`org_t`.`name`)
WHEN ((`org_t`.`id` = 6) OR (`rec_t`.`id_divizion` = 7)) THEN CONCAT(`loc_t`.`name`,' ',`org_t`.`name`)
WHEN (`rec_t`.`divizion_num` = 0) THEN `d_t`.`name` ELSE CONCAT(`d_t`.`name`,'-',`rec_t`.`divizion_num`) END) AS `pasp_name_spec_real`,

  (CASE
  WHEN (`rec_t`.`id_divizion` = 4) THEN CONCAT(org_t.name,' ',loc_t.name)
   WHEN ((`rec_t`.`id_divizion` = 4) OR (`rec_t`.`id_divizion` = 10)) THEN CONVERT(CONCAT('') USING utf8) WHEN ((`rec_t`.`id_divizion` = 8)
   OR (`rec_t`.`id_divizion` = 9)) THEN CONCAT(REPLACE(`loc_t`.`name`,'ий','ого'),' ',`org_t`.`name`)
  WHEN ((`org_t`.`id` = 6) AND (`loc_t`.`id_region` = 3)) THEN CONCAT('ММ ',`loc_t`.`name`)
   WHEN ((`org_t`.`id` = 6) OR (`rec_t`.`id_divizion` = 7)
	OR (`org_t`.`id` = 12)) THEN CONVERT(CONCAT('') USING utf8)
	WHEN ((`org_t`.`id` = 9) AND (`loc_t`.`id_region` = 3)) THEN CONVERT(CONCAT('УГЗ г.Минск') USING utf8)
	 WHEN ((`org_t`.`id` = 9) AND (`loc_t`.`id_region` = 4)) THEN CONVERT(CONCAT('УГЗ г.Гомель') USING utf8) WHEN ((`org_t`.`id` = 9) AND (`loc_t`.`id_region` = 6))
	 THEN CONVERT(CONCAT('УГЗ г.Борисов') USING utf8) WHEN (`org_t`.`id` = 7)
	 THEN CONCAT(`org_t`.`name`,' №',`locor_t`.`no`,' ',REPLACE(`loc_t`.`name`,'ий','ого'),' ',`orgg_t`.`name`)
	 ELSE CONCAT(REPLACE(`loc_t`.`name`,'ий','ого'),' ',`org_t`.`name`) END) AS `of_locorg_name_spec_real`,

(CASE WHEN (((`rec_t`.`id_divizion` = 8) OR (`rec_t`.`id_divizion` = 9)) AND (`org_t`.`id` = 4) AND (`loc_t`.`id_region` = 3)) THEN CONCAT(`d_t`.`name`,' ',`rec_t`.`divizion_num`)
WHEN ((`rec_t`.`id_divizion` = 4) OR (`rec_t`.`id_divizion` = 7) OR (`rec_t`.`id_divizion` = 8) OR (`rec_t`.`id_divizion` = 9) OR (`rec_t`.`id_divizion` = 10)) THEN `d_t`.`name`
WHEN ((`org_t`.`id` = 12) OR (`org_t`.`id` = 6)) THEN `org_t`.`name` WHEN (`rec_t`.`divizion_num` = 0) THEN `d_t`.`name` ELSE CONCAT(`d_t`.`name`,'-',`rec_t`.`divizion_num`) END) AS `pasp_name_spec`,
  (CASE WHEN ((((`rec_t`.`id_divizion` = 8) OR (`rec_t`.`id_divizion` = 9)) AND (`org_t`.`id` = 8)) OR (`org_t`.`id` = 9)) THEN CONCAT(`org_t`.`name`)
  WHEN (((`rec_t`.`id_divizion` = 8) OR (`rec_t`.`id_divizion` = 9)) AND (`org_t`.`id` = 6)) THEN CONCAT(REPLACE(`loc_t`.`name`,'ий','ого'),' ',`org_t`.`name`)
  WHEN (((`rec_t`.`id_divizion` = 8) OR (`rec_t`.`id_divizion` = 9)) AND (`org_t`.`id` = 4) AND (`loc_t`.`id_region` = 3)) THEN CONCAT(`loc_t`.`name`)
   WHEN ((`org_t`.`id` = 6) AND (`loc_t`.`id_region` = 3)) THEN CONCAT('ММ ',`loc_t`.`name`)
   WHEN ((`org_t`.`id` = 6) AND (`loc_t`.`id_region` <> 3)) THEN CONCAT(REPLACE(`loc_t`.`name`,'ий','ого'),' ','УМЧС')

 WHEN ((rec_t.id_divizion = 7) AND (`loc_t`.`id_region` = 3)) THEN CONCAT(`loc_t`.`name`,'а')
    WHEN ((rec_t.id_divizion = 7) AND (`loc_t`.`id_region` <> 3)) THEN CONCAT(REPLACE(`loc_t`.`name`,'ий','ого'),' ','УМЧС')

    WHEN ((`rec_t`.`id_divizion` = 4)  OR (`rec_t`.`id_divizion` = 10) OR (`org_t`.`id` = 12)) THEN CONVERT(CONCAT('') USING utf8)
     WHEN (`org_t`.`id` = 7) THEN CONCAT(`org_t`.`name`,' №',`locor_t`.`no`,' ',REPLACE(`loc_t`.`name`,'ий','ого'),' ',`orgg_t`.`name`)
     WHEN (`loc_t`.`name` = 'Заводской') THEN CONCAT(REPLACE(`loc_t`.`name`,'ой','ого'),' ',`org_t`.`name`) WHEN (`loc_t`.`name` = 'Центральный') THEN CONCAT(REPLACE(`loc_t`.`name`,'ый','ого'),' ',`org_t`.`name`)
     ELSE CONCAT(REPLACE(`loc_t`.`name`,'ий','ого'),' ',`org_t`.`name`) END) AS `locorg_name_spec`,

 t_tr.v AS v_ac,
  t_tr.id_view,
   vie_tr.name as view_name,
    vie_tr.description as view_abbr,
  vie_tr.id_vid as id_vid_car,
	  COUNT(fc_tr.id_fio) AS man_per_car
  FROM  str.`tripcar` AS tr1
  LEFT JOIN str.car AS c_tr ON c_tr.id_teh=tr1.id_teh
  LEFT JOIN ss.`technics` AS t_tr ON t_tr.`id`=c_tr.`id_teh`

  LEFT JOIN `ss`.`records` `rec_t` ON rec_t.id=tr1.to_card
  LEFT JOIN `ss`.`views` `vie_tr` ON t_tr.id_view=vie_tr.id
LEFT JOIN `ss`.`divizions` `d_t` ON `rec_t`.`id_divizion` = `d_t`.`id`
LEFT JOIN `ss`.`locorg` `locor_t` ON `locor_t`.`id` = `rec_t`.`id_loc_org`
LEFT JOIN `ss`.`locals` `loc_t` ON `loc_t`.`id` = `locor_t`.`id_local`
LEFT JOIN `ss`.`organs` `org_t` ON `locor_t`.`id_organ` = `org_t`.`id`
LEFT JOIN `ss`.`organs` `orgg_t` ON `locor_t`.`oforg` = `orgg_t`.`id`
LEFT JOIN str.fiocar AS fc_tr ON fc_tr.id_tehstr=c_tr.id
 WHERE c_tr.id IS NOT NULL AND
  (( '" . $dateduty . "' BETWEEN tr1.date1 AND tr1.date2) OR( '" . $dateduty . "'  >= tr1.date1 AND tr1.date2 IS NULL)) AND tr1.`id_teh` IS NOT NULL
 AND  tr1.`to_card`=" . $id_pasp . "
 AND c_tr.ch = " . $ch;
        //-- and c_tr.dateduty=";




        if (isset($filter['id_name_car']) && !empty($filter['id_name_car'])) {
            $reserve = $reserve . ' AND t_tr.id_view IN(' . implode(',', $filter['id_name_car']) . ')';
        }



        if (isset($filter['id_type_car']) && !empty($filter['id_type_car'])) {
            $reserve = $reserve . ' AND c_tr.t_type = ' . $filter['id_type_car'];
        }

        if (isset($filter['id_ob_car']) && !empty($filter['id_ob_car'])) {


            $sql_v = '';

            foreach ($filter['id_ob_car'] as $v) {

                if ($v == 1) {
                    if ($sql_v == '')
                        $sql_v = $sql_v . ' (t_tr.v >= 1000 and t_tr.v <= 4000)';
//                        $sql_v = $sql_v . ' p.v <= 4000';
                    else
                        $sql_v = $sql_v . ' OR (t_tr.v >= 1000 and t_tr.v <= 4000)';
//                        $sql_v = $sql_v . ' OR p.v <= 4000 ';
                }
                elseif ($v == 2) {
                    if ($sql_v == '')
                        $sql_v = $sql_v . ' (t_tr.v > 4000 and t_tr.v <= 7000)';
                    else
                        $sql_v = $sql_v . ' OR (t_tr.v > 4000 and t_tr.v <= 7000)';
                }
                elseif ($v == 3) {

                    if ($sql_v == '')
                        $sql_v = $sql_v . ' t_tr.v >= 8000 ';
                    else
                        $sql_v = $sql_v . ' OR t_tr.v >= 8000 ';
                }
            }
            $reserve = $reserve . ' AND  ( ' . $sql_v . ') ';
        }

        if (isset($filter['id_vid_car']) && !empty($filter['id_vid_car'])) {
            $reserve = $reserve . ' and vie_tr.id_vid IN(' . implode(',', $filter['id_vid_car']) . ')';
        }


        $reserve = $reserve . ' GROUP BY c_tr.id)';

        $sql = $sql . " " . $reserve;
//        if($id_pasp==260){
//        echo $sql;exit();
//        }
        //echo $sql;exit();
        return R::getAll($sql);
    }
}

?>