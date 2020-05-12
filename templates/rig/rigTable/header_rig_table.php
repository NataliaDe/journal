<?php
if(isset($search_rig_by_id)){

    foreach ($rig as $value) {
        $id=$value['id'];
    }

   ?>
  <center><b>
           Результаты поиска по выезду с ID = <?= $id?>
        </b></center>
<?php

}
else{

     $cnt_rig = (isset($rig) && !empty($rig)) ? ('(' . count($rig) . ')') : '';

    if (isset($_POST['date_start']) && !empty($_POST['date_start']) && isset($_POST['date_end']) && !empty($_POST['date_end'])) {

        $start_date = date('d.m.Y', strtotime($_POST['date_start']));
        $end_date = date('d.m.Y', strtotime($_POST['date_end']));


    } elseif (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_start']) && !empty($_SESSION['remember_filter_date_start'])) {
        $start_date = date('d.m.Y', strtotime($_SESSION['remember_filter_date_start']));
        $end_date = date('d.m.Y', strtotime($_SESSION['remember_filter_date_end']));


    } else {

        if (date("H:i:s") <= '06:00:00') {//до 06 утра
            $start_date = date("m.d.Y", time() - (60 * 60 * 24));
            $end_date = date("d.m.Y");


        } else {
            $start_date = date("d.m.Y");
            $end_date = date("d.m.Y", time() + (60 * 60 * 24));
        }
    }



?>
 <center><b>
         Выезды <?= $cnt_rig ?> с 06:00 <u><?= $start_date ?></u> до 06:00 <u><?= $end_date ?></u>
        </b></center>
<?php



}
?>