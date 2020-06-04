<?php
if (isset($search_rig_by_id)) {

    foreach ($rig as $value) {
        $id = $value['id'];
    }

    ?>
    <center><b>
            Результаты поиска по выезду с ID = <?= $id ?>
        </b></center>
    <?php
} else {

    $cnt_rig = (isset($rig) && !empty($rig)) ? ('(' . count($rig) . ')') : '';

    if (isset($_POST['date_start']) && !empty($_POST['date_start']) && isset($_POST['date_end']) && !empty($_POST['date_end'])) {

        $start_date = date('d.m.Y', strtotime($_POST['date_start']));
        $end_date = date('d.m.Y', strtotime($_POST['date_end']));
    } elseif (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_start']) && !empty($_SESSION['remember_filter_date_start'])) {
        $start_date = date('d.m.Y', strtotime($_SESSION['remember_filter_date_start']));
        $end_date = date('d.m.Y', strtotime($_SESSION['remember_filter_date_end']));
    } else {

        if (date("H:i:s") <= '06:00:00') {//до 06 утра
            $start_date = date("d.m.Y", time() - (60 * 60 * 24));
            $end_date = date("d.m.Y");
        } else {
            $start_date = date("d.m.Y");
            $end_date = date("d.m.Y", time() + (60 * 60 * 24));
        }
    }

    ?>
    <center><b>
            Выезды <?= $cnt_rig ?> с 06:00 <u><?= $start_date ?></u> до 06:00 <u><?= $end_date ?></u>



            <?php
            if ((isset($settings_user['is_excel_rigtable']) && $settings_user['is_excel_rigtable']['name_sign'] == 'yes') ||
                (isset($settings_user['is_word_rigtable']) && $settings_user['is_word_rigtable']['name_sign'] == 'yes')) {


                if (isset($_POST['date_start']) && $_POST['date_start'] != '0000-00-00 00:00:00' && $_POST['date_start'] != NULL) {

                    $from_filter = $_POST['date_start'];
                } elseif (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_start']) && !empty($_SESSION['remember_filter_date_start'])) {

                    $from_filter = $_SESSION['remember_filter_date_start'];
                } else {

                    $from_filter = $default_start_date;
                }

                ?>


                <?php
                if (isset($_POST['date_end']) && $_POST['date_end'] != '0000-00-00 00:00:00' && $_POST['date_end'] != NULL) {

                    $to_filter = $_POST['date_end'];
                } elseif (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_end']) && !empty($_SESSION['remember_filter_date_end'])) {

                    $to_filter = $_SESSION['remember_filter_date_end'];
                } else {
                    $to_filter = $default_end_date;
                }


                $reason = 0;
                if ((isset($_POST['reasonrig']) && !empty($_POST['reasonrig']))) {
                    $reason = implode(',', $_POST['reasonrig']);
                } elseif (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 &&
                    isset($_SESSION['remember_filter_reasonrig']) && !empty($_SESSION['remember_filter_reasonrig'])) {
                    $reason = implode(',', $_SESSION['remember_filter_reasonrig']);
                }



                $export_rigtable = $baseUrl . '/export_rigtable/' . $from_filter . '/' . $to_filter . '/' . $reason;

                $export_word = $baseUrl . '/export_word/' . $from_filter . '/' . $to_filter . '/' . $reason;


                if ($_SESSION['id_level'] == 1) {
                    $export_word = $export_word . '/' . $id_page;
                    $export_rigtable = $export_rigtable . '/' . $id_page;
                }
            }

            if ((isset($settings_user['is_excel_rigtable']) && $settings_user['is_excel_rigtable']['name_sign'] == 'yes')) {

                ?>
                <a href="<?= $export_rigtable ?>"><i class="fa fa-file-excel-o" aria-hidden="true" style="color:green; cursor: pointer" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Экспорт в Excel"></i></a>
                <?php
            }


            if ((isset($settings_user['is_word_rigtable']) && $settings_user['is_word_rigtable']['name_sign'] == 'yes')) {

                ?>
                <a href="<?= $export_word ?>"><i class="fa fa-file-word-o" aria-hidden="true" style="color:blue; cursor: pointer" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Экспорт в Word"></i></a>
                    <?php
                }

                ?>

        </b></center>
    <?php
}

?>