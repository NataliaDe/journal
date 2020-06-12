CREATE DEFINER=`root`@`localhost` PROCEDURE `spec_basic_sort_teh`(
	IN `id_rig` INT


)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT 'сортировка техники по расстоянию к месту ЧС'
BEGIN

/* основная техника только та, у котороый не была возврата */

SELECT * FROM
(SELECT  id_sily AS id,
id_sily, id_rig,id_teh,

mark COLLATE utf8mb4_general_ci AS mark,
CONCAT(pasp_name_spec," ",locorg_name_spec) AS pasp_name_full,

`v_ac` ,
	`min_br` ,
	`vid_teh` ,
	`numbsign`  COLLATE 'utf8mb4_bin' AS numbsign,
	`distance`   COLLATE 'utf8mb4_unicode_ci' AS distance,
	`region_name` COLLATE 'utf8_general_ci' AS region_name,
	`locorg_name`  COLLATE 'utf8_general_ci' AS locorg_name,
	`id_grochs` ,
	`id_region` ,
	`pasp_id` ,
	`pasp_name` COLLATE 'utf8_general_ci' AS pasp_name,
	`pasp_name_spec` COLLATE 'utf8_general_ci' AS pasp_name_spec,
	`locorg_name_spec` COLLATE 'utf8_general_ci' AS locorg_name_spec,
	`time_exit` ,
	`time_arrival`  ,
	`time_follow`  ,
	`time_end`  ,
	`time_return`  ,

	`is_return` ,
	`view_teh`  COLLATE 'utf8_general_ci' AS view_teh,
	`diviz_name`  COLLATE 'utf8_general_ci' AS diviz_name,
	`divizion_num`


FROM jrig_spec AS t
WHERE t.mark IS NOT NULL AND t.`id_rig`=id_rig AND t.`vid_teh`=1 AND t.`is_return`=0
ORDER BY

t.`distance` ASC,

t.region_name ASC,
t.locorg_name ASC,
t.diviz_name DESC,
t.divizion_num ASC,

t.`mark`) osn


UNION
/* основная техника только та, у котороый БЫЛ ВОЗВРАТ !!! */
SELECT * FROM
(

SELECT  id_sily AS id,
id_sily, id_rig,id_teh,

mark COLLATE utf8mb4_general_ci AS mark,
CONCAT(pasp_name_spec," ",locorg_name_spec) AS pasp_name_full,

`v_ac` ,
	`min_br` ,
	`vid_teh` ,
	`numbsign`  COLLATE 'utf8mb4_bin' AS numbsign,
	`distance`   COLLATE 'utf8mb4_unicode_ci' AS distance,
	`region_name` COLLATE 'utf8_general_ci' AS region_name,
	`locorg_name`  COLLATE 'utf8_general_ci' AS locorg_name,
	`id_grochs` ,
	`id_region` ,
	`pasp_id` ,
	`pasp_name` COLLATE 'utf8_general_ci' AS pasp_name,
	`pasp_name_spec` COLLATE 'utf8_general_ci' AS pasp_name_spec,
	`locorg_name_spec` COLLATE 'utf8_general_ci' AS locorg_name_spec,
	`time_exit` ,
	`time_arrival`  ,
	`time_follow`  ,
	`time_end`  ,
	`time_return`  ,

	`is_return` ,
	`view_teh`  COLLATE 'utf8_general_ci' AS view_teh,
	`diviz_name`  COLLATE 'utf8_general_ci' AS diviz_name,
	`divizion_num`

FROM jrig_spec AS t_1
WHERE t_1.mark IS NOT NULL AND t_1.`id_rig`=id_rig AND t_1.`vid_teh`=1 AND t_1.`is_return`=1
ORDER BY

t_1.`distance` ASC,

t_1.region_name ASC,
t_1.locorg_name ASC,
t_1.diviz_name DESC,
t_1.divizion_num ASC,

t_1.`mark`
)
osn_return


UNION

/* спец+вспомогат техника только та, у котороый не была возврата */
SELECT * FROM
(

SELECT  id_sily AS id,
id_sily, id_rig,id_teh,

mark COLLATE utf8mb4_general_ci AS mark,
CONCAT(pasp_name_spec," ",locorg_name_spec) AS pasp_name_full,

`v_ac` ,
	`min_br` ,
	`vid_teh` ,
	`numbsign`  COLLATE 'utf8mb4_bin' AS numbsign,
	`distance`   COLLATE 'utf8mb4_unicode_ci' AS distance,
	`region_name` COLLATE 'utf8_general_ci' AS region_name,
	`locorg_name`  COLLATE 'utf8_general_ci' AS locorg_name,
	`id_grochs` ,
	`id_region` ,
	`pasp_id` ,
	`pasp_name` COLLATE 'utf8_general_ci' AS pasp_name,
	`pasp_name_spec` COLLATE 'utf8_general_ci' AS pasp_name_spec,
	`locorg_name_spec` COLLATE 'utf8_general_ci' AS locorg_name_spec,
	`time_exit` ,
	`time_arrival`  ,
	`time_follow`  ,
	`time_end`  ,
	`time_return`  ,

	`is_return` ,
	`view_teh`  COLLATE 'utf8_general_ci' AS view_teh,
	`diviz_name`  COLLATE 'utf8_general_ci' AS diviz_name,
	`divizion_num`

FROM jrig_spec AS t_2
WHERE t_2.mark IS NOT NULL AND t_2.`id_rig`=id_rig AND (t_2.`vid_teh`=2 OR t_2.`vid_teh`=3)  AND t_2.`is_return`=0
ORDER BY

t_2.`distance` ASC,

t_2.region_name ASC,
t_2.locorg_name ASC,
t_2.diviz_name DESC,
t_2.divizion_num ASC,

t_2.`mark`
) spec


UNION

/* спец+вспомогат. техника только та, у котороый БЫЛ ВОЗВРАТ */
SELECT * FROM
(

SELECT  id_sily AS id,
id_sily, id_rig,id_teh,

mark COLLATE utf8mb4_general_ci AS mark,
CONCAT(pasp_name_spec," ",locorg_name_spec) AS pasp_name_full,

`v_ac` ,
	`min_br` ,
	`vid_teh` ,
	`numbsign`  COLLATE 'utf8mb4_bin' AS numbsign,
	`distance`   COLLATE 'utf8mb4_unicode_ci' AS distance,
	`region_name` COLLATE 'utf8_general_ci' AS region_name,
	`locorg_name`  COLLATE 'utf8_general_ci' AS locorg_name,
	`id_grochs` ,
	`id_region` ,
	`pasp_id` ,
	`pasp_name` COLLATE 'utf8_general_ci' AS pasp_name,
	`pasp_name_spec` COLLATE 'utf8_general_ci' AS pasp_name_spec,
	`locorg_name_spec` COLLATE 'utf8_general_ci' AS locorg_name_spec,
	`time_exit` ,
	`time_arrival`  ,
	`time_follow`  ,
	`time_end`  ,
	`time_return`  ,

	`is_return` ,
	`view_teh`  COLLATE 'utf8_general_ci' AS view_teh,
	`diviz_name`  COLLATE 'utf8_general_ci' AS diviz_name,
	`divizion_num`

FROM jrig_spec AS t_2
WHERE t_2.mark IS NOT NULL AND t_2.`id_rig`=id_rig AND (t_2.`vid_teh`=2 OR t_2.`vid_teh`=3)  AND t_2.`is_return`=1
ORDER BY

t_2.`distance` ASC,

t_2.region_name ASC,
t_2.locorg_name ASC,
t_2.diviz_name DESC,
t_2.divizion_num ASC,

t_2.`mark`
) spec_retutn

;


END