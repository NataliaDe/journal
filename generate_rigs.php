<?php

/*подключение к БД*/
//require_once dirname(__FILE__) . '/bootstrap.php';
require_once dirname(__FILE__) . '/vendor/autoload.php';
$connection=mysql_connect("localhost","root","xxXX1234");
mysql_query("set names 'utf8'");
mysql_select_db("journal");




/* in data */

$date_start=date('Y-m-d');
$date_end=date('Y-m-d');

//$date_start=date('2018-06-13');
//$date_end=date('2018-06-13');
$time_start='06:00:00';
$time_end='12:00:00';



$post_id_reasonrig=array(14,18,33,34,38,41,70,73,74,76,78);

  /* vid for reasonrig */
        $reasonrig_vid = mysql_query('select * from reasonrig where id IN ('. implode(',', $post_id_reasonrig).')');

        $arr_vid=array();

//        foreach ($reasonrig_vid as $value) {
//            $arr_vid[$value['id']]=$value['vid'];
//        }

         while ($my=mysql_fetch_array($reasonrig_vid))
         {
              $arr_vid[$my['id']]=$my['vid'];
         }

$is_delete=0;
$sql = 'SELECT r.*, SUBSTRING(REPLACE(inf_detail,CHAR(13)+CHAR(10)," "), 1, 250) AS inf_detail_1,'
    . ' REPLACE(inf_detail,CHAR(13)+CHAR(10)," ") AS inf_detail_2  FROM journal.rigtable as r WHERE  is_delete = 0 '
    . ' AND id_reasonrig IN('. implode(',', $post_id_reasonrig).') AND latitude <> 0 AND longitude <> 0 AND'
    . ' address is not null and LENGTH(latitude) >8 and LENGTH(longitude) >8 AND inf_detail <> "" ';

 $date_filter = ' AND date_msg = "'.$date_start.'" '
                . ' and time_msg between "'.$time_start.'" and  "'.$time_end.'" ';


$sql=$sql.$date_filter;

//echo $sql;
$rigs=mysql_query($sql);
$totalitems1 =  mysql_num_rows($rigs);
//$myrow=mysql_fetch_array($result);
//print_r($myrow);

if ($totalitems1 == 0) {
	//echo '1';

	$date_1_day = new DateTime('-1 days');
	$date_start=$date_1_day->format('Y-m-d');
$date_end=$date_start;


$sql = 'SELECT r.*, SUBSTRING(REPLACE(inf_detail,CHAR(13)+CHAR(10)," "), 1, 250) AS inf_detail_1,'
    . ' REPLACE(inf_detail,CHAR(13)+CHAR(10)," ") AS inf_detail_2  FROM journal.rigtable as r WHERE  is_delete = 0 '
    . ' AND id_reasonrig IN('. implode(',', $post_id_reasonrig).') AND latitude <> 0 AND longitude <> 0 AND'
    . ' address is not null and LENGTH(latitude) >8 and LENGTH(longitude) >8 AND inf_detail <> "" ';

 $date_filter = ' AND date_msg = "'.$date_start.'" '
                . ' and time_msg between "'.$time_start.'" and  "'.$time_end.'" ';


$sql=$sql.$date_filter;

//echo $sql;
$rigs=mysql_query($sql);
$totalitems1 =  mysql_num_rows($rigs);
}


if ($totalitems1 > 0) {
	//echo '2';

    /* export to csv */
    $inf = array();
    //foreach ($rigs as $row) {

      while ($row=mysql_fetch_array($rigs))
     {

        $reasonrig_name = trim(stristr($row['reasonrig_name'], ' '));

        $detail_1 = trim(str_replace(array("\r\n", "\r", "\n"), '', strip_tags($row['inf_detail_1'])));
        $detail = substr($detail_1, 0, strrpos($detail_1, '.')) . '.'; //cut before last .

        if ($detail == '.') {
            $detail_2 = trim(str_replace(array("\r\n", "\r", "\n"), '', strip_tags($row['inf_detail_1'])));
            $detail = trim(str_replace(array('"', "'", ";"), ' ', strip_tags($detail_2)));
        } else {
            $detail = trim(str_replace(array('"', "'", ";"), ' ', strip_tags($detail)));
        }


        /* vid */
        $vid = (isset($arr_vid[$row['id_reasonrig']])) ? $arr_vid[$row['id_reasonrig']] : 0;


        $inf[] = array('lat' => $row['latitude'], 'lon' => $row['longitude'], 'date_msg' => date('d.m.Y', strtotime($row['date_msg'])), 'address' => $row['address'], 'inf_detail' => $detail, 'vid' => $vid);
    //}




    //echo $myrow["id"] . '-----' . $myrow['time_msg'];
    //echo '<br>';
    //echo $myrow['time_msg'];
    }
//print_r($inf);
//exit();
    if(isset($inf) && !empty($inf)){
        $csv = new ParseCsv\Csv('data.csv');
       // $csv->encoding( 'UTF-8');
        # When saving,  write the header row:
        $csv->heading = TRUE;
        # Specify which columns to write, and in which order.
        # We won't output the 'Awesome' column this time.
        $csv->titles = ['lat', 'lon', 'date_msg', 'address', 'inf_detail', 'vid'];
          # Data to write:
//        $csv->data = [
//            0 => ['Name' => 'Anne', 'Age' => 45, 'Awesome' => true],
//            1 => ['Name' => 'John', 'Age' => 44, 'Awesome' => false],
//        ];

        $csv->delimiter = ";";
        $csv->data = $inf;

        //$path = $_SERVER['DOCUMENT_ROOT'] . '/out';
        $path = 'out';

        if ($csv->save($path . '/ex_jor_100.csv',true)) {
			//echo '1';
           // $data['is_save'] = array('success','Выезды успешно сохранены в папку 172.26.200.14/www/out/. Имя файла ex_jor.csv. ');
        } else {
		//	echo '2';
           // $data['is_save'] = array('danger','Что-то пошло не так. ');
        }
    }



}




