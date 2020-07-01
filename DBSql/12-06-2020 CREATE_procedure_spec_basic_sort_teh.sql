-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.28-76.1 - Percona Server (GPL), Release 76.1, Revision 5759e76
-- Операционная система:         debian-linux-gnu
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных journal
CREATE DATABASE IF NOT EXISTS `journal` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `journal`;

-- Дамп структуры для процедура journal.spec_basic_sort_teh
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `spec_basic_sort_teh`(
	IN `id_rig` INT



)
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

FROM jrig_spec AS t_3
WHERE t_3.mark IS NOT NULL AND t_3.`id_rig`=id_rig AND (t_3.`vid_teh`=2 OR t_3.`vid_teh`=3)  AND t_3.`is_return`=1
ORDER BY

t_3.`distance` ASC,

t_3.region_name ASC,
t_3.locorg_name ASC,
t_3.diviz_name DESC,
t_3.divizion_num ASC,

t_3.`mark`
) spec_retutn

;


END//
DELIMITER ;

-- Дамп структуры для процедура journal.spec_basic_sort_trunks
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `spec_basic_sort_trunks`(
	IN `id_rig` INT







)
    COMMENT 'выбор стволов с сортировкой расстояния до ЧС по возрастанию'
BEGIN
SELECT * FROM
/* основная техника только та, у котороый не была возврата */
(
SELECT

`mark`  COLLATE 'utf8mb4_bin' AS mark,
	`pasp_name_spec`  COLLATE 'utf8_general_ci' AS pasp_name_spec,
	`locorg_name_spec` COLLATE 'utf8_general_ci' AS locorg_name_spec,
	`v_ac` ,
	`min_br` ,
	`time_arrival` ,
	`distance` COLLATE 'utf8mb4_unicode_ci' AS distance,
	`is_return` ,
	`s_bef`  COLLATE 'utf8_general_ci' AS s_bef,
	`time_pod`   COLLATE 'utf8mb4_unicode_520_ci' AS time_pod,
	`cnt`  ,
	`trunk_name`  COLLATE 'utf8_general_ci' AS trunk_name,
	`water`  COLLATE 'utf8mb4_unicode_520_ci' AS water,
	`time_loc`  ,
	`s_loc`  COLLATE 'utf8_general_ci' AS s_loc,
	`time_likv` ,
	`id_rig` ,
	`id_teh`,
	`vid_teh` ,
	`region_name` COLLATE 'utf8_general_ci' AS region_name,
	`divizion_num` ,
	`diviz_name`  COLLATE 'utf8_general_ci' AS diviz_name,
	`locorg_name`  COLLATE 'utf8_general_ci' AS locorg_name

FROM spec_trunks_tbl as t
WHERE t.id_rig=id_rig AND t.mark IS NOT NULL AND t.vid_teh=1 AND t.is_return=0

ORDER BY
 t.`distance` ASC,

t.region_name ASC,
t.locorg_name ASC,
t.diviz_name DESC,
t.divizion_num ASC,

t.`mark`
 ) osn

 UNION

 /* основная техника только та, у котороый БЫЛ ВОЗВРАТ !!! */
 SELECT * FROM
(
SELECT
`mark`  COLLATE 'utf8mb4_bin' AS mark,
	`pasp_name_spec`  COLLATE 'utf8_general_ci' AS pasp_name_spec,
	`locorg_name_spec` COLLATE 'utf8_general_ci' AS locorg_name_spec,
	`v_ac` ,
	`min_br` ,
	`time_arrival` ,
	`distance` COLLATE 'utf8mb4_unicode_ci' AS distance,
	`is_return` ,
	`s_bef`  COLLATE 'utf8_general_ci' AS s_bef,
	`time_pod`   COLLATE 'utf8mb4_unicode_520_ci' AS time_pod,
	`cnt`  ,
	`trunk_name`  COLLATE 'utf8_general_ci' AS trunk_name,
	`water`  COLLATE 'utf8mb4_unicode_520_ci' AS water,
	`time_loc`  ,
	`s_loc`  COLLATE 'utf8_general_ci' AS s_loc,
	`time_likv` ,
	`id_rig` ,
	`id_teh`,
	`vid_teh` ,
	`region_name` COLLATE 'utf8_general_ci' AS region_name,
	`divizion_num` ,
	`diviz_name`  COLLATE 'utf8_general_ci' AS diviz_name,
	`locorg_name`  COLLATE 'utf8_general_ci' AS locorg_name
FROM spec_trunks_tbl  as t_1

WHERE t_1.id_rig=id_rig AND t_1.mark IS NOT NULL AND t_1.vid_teh=1 AND t_1.is_return=1


ORDER BY
 t_1.`distance` ASC,


t_1.region_name ASC,
t_1.locorg_name ASC,
t_1.diviz_name DESC,
t_1.divizion_num ASC,

 t_1.`mark`
 ) osn_retutn



 UNION

 /* спец+вспомогат техника только та, у котороый не была возврата */
 SELECT * FROM
(
SELECT
`mark`  COLLATE 'utf8mb4_bin' AS mark,
	`pasp_name_spec`  COLLATE 'utf8_general_ci' AS pasp_name_spec,
	`locorg_name_spec` COLLATE 'utf8_general_ci' AS locorg_name_spec,
	`v_ac` ,
	`min_br` ,
	`time_arrival` ,
	`distance` COLLATE 'utf8mb4_unicode_ci' AS distance,
	`is_return` ,
	`s_bef`  COLLATE 'utf8_general_ci' AS s_bef,
	`time_pod`   COLLATE 'utf8mb4_unicode_520_ci' AS time_pod,
	`cnt`  ,
	`trunk_name`  COLLATE 'utf8_general_ci' AS trunk_name,
	`water`  COLLATE 'utf8mb4_unicode_520_ci' AS water,
	`time_loc`  ,
	`s_loc`  COLLATE 'utf8_general_ci' AS s_loc,
	`time_likv` ,
	`id_rig` ,
	`id_teh`,
	`vid_teh` ,
	`region_name` COLLATE 'utf8_general_ci' AS region_name,
	`divizion_num` ,
	`diviz_name`  COLLATE 'utf8_general_ci' AS diviz_name,
	`locorg_name`  COLLATE 'utf8_general_ci' AS locorg_name
FROM spec_trunks_tbl as t_2

WHERE t_2.id_rig=id_rig AND t_2.mark IS NOT NULL AND (t_2.vid_teh=2 OR t_2.vid_teh=3) AND t_2.is_return=0


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
SELECT
`mark`  COLLATE 'utf8mb4_bin' AS mark,
	`pasp_name_spec`  COLLATE 'utf8_general_ci' AS pasp_name_spec,
	`locorg_name_spec` COLLATE 'utf8_general_ci' AS locorg_name_spec,
	`v_ac` ,
	`min_br` ,
	`time_arrival` ,
	`distance` COLLATE 'utf8mb4_unicode_ci' AS distance,
	`is_return` ,
	`s_bef`  COLLATE 'utf8_general_ci' AS s_bef,
	`time_pod`   COLLATE 'utf8mb4_unicode_520_ci' AS time_pod,
	`cnt`  ,
	`trunk_name`  COLLATE 'utf8_general_ci' AS trunk_name,
	`water`  COLLATE 'utf8mb4_unicode_520_ci' AS water,
	`time_loc`  ,
	`s_loc`  COLLATE 'utf8_general_ci' AS s_loc,
	`time_likv` ,
	`id_rig` ,
	`id_teh`,
	`vid_teh` ,
	`region_name` COLLATE 'utf8_general_ci' AS region_name,
	`divizion_num` ,
	`diviz_name`  COLLATE 'utf8_general_ci' AS diviz_name,
	`locorg_name`  COLLATE 'utf8_general_ci' AS locorg_name
FROM spec_trunks_tbl as t_3

WHERE t_3.id_rig=id_rig AND t_3.mark IS NOT NULL AND (t_3.vid_teh=2 OR t_3.vid_teh=3) AND t_3.is_return=1


ORDER BY
 t_3.`distance` ASC,


t_3.region_name ASC,
t_3.locorg_name ASC,
t_3.diviz_name DESC,
t_3.divizion_num ASC,

 t_3.`mark`
 ) spec_return



 ;
END//
DELIMITER ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
