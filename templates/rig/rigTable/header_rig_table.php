<?php
if(isset($search_rig_by_id)){
   ?>
  <center><b>
           Результаты поиска
        </b></center>
<?php

}
else{
    if (isset($_POST['date_start']) && !empty($_POST['date_start']) && isset($_POST['date_end']) && !empty($_POST['date_end'])) {

    ?>
    <center><b>
            Выезды <?= (isset($rig) && !empty($rig)) ? ('('.count($rig).')') : '' ?> с 06:00 <?= date('d.m.Y', strtotime($_POST['date_start'])) ?> до 06:00 <?= date('d.m.Y', strtotime($_POST['date_end'])) ?>
        </b></center>
    <?php
} else {

    ?>
    <center><b>
            <?php
            if (date("H:i:s") <= '06:00:00') {//до 06 утра

                ?>
            Выезды <?= (isset($rig) && !empty($rig)) ? ('('.count($rig).')') : '' ?> с 06:00 <?= date("m.d.Y", time() - (60 * 60 * 24)) ?>  до 06:00 <?= date("d.m.Y") ?>
                <?php
            } else {

                ?>
                Выезды <?= (isset($rig) && !empty($rig)) ? ('('.count($rig).')') : '' ?> с 06:00 <?= date("d.m.Y") ?>  до 06:00 <?= date("d.m.Y", time() + (60 * 60 * 24)) ?>
                <?php
            }

            ?>

        </b></center>
    <?php
}
}
?>