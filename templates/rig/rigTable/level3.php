<div class="noprint" id="conttabl">
    <b> Выберите столбец, чтобы скрыть/отобразить:  </b>
    <b>

        <a class="toggle-vis-rig-table" id="toggle-vis-rig-table-7" data-column="7" style="background-color: #fdee8d;  color: black">Привлекаемая техника</a> -
      <a class="toggle-vis-rig-table" id="toggle-vis-rig-table-13"  data-column="13" style="background-color: #fdee8d;  color: black">Автор создания</a>

    </b>

</div>

<!--таблица выездов для уровня 3 и для уровня 2 (УМЧС) -->
<br>
<?php
if (isset($_POST['date_start']) && !empty($_POST['date_start']) && isset($_POST['date_end']) && !empty($_POST['date_end'])) {

    ?>
    <center><b>
            Выезды с 06:00 <?= $_POST['date_start'] ?> до 06:00 <?= $_POST['date_end'] ?>
        </b></center>
    <?php
} else {

    ?>
    <center><b>
            <?php
            if (date("H:i:s") <= '06:00:00') {//до 06 утра

                ?>
                Выезды с 06:00 <?= date("Y-m-d", time() - (60 * 60 * 24)) ?>  до 06:00 <?= date("Y-m-d") ?>
                <?php
            } else {

                ?>
                Выезды с 06:00 <?= date("Y-m-d") ?>  до 06:00 <?= date("Y-m-d", time() + (60 * 60 * 24)) ?>
                <?php
            }

            ?>

        </b></center>
    <?php
}
//print_r($result_icons);
?>
<table class="table table-condensed   table-bordered table-custom" id="rigTable" >
    <!-- строка 1 -->
    <thead>
        <tr>
            <th>ID</th>
            <th></th>
            <th style="width:57px;">Дата</th>
            <th style="width:45px;">Время</th>
            <th >Район</th>
            <th style="width:195px;">Адрес<br>(объект)</th>
            <th style="width:120px;" >Привлекаемые подразделения</th>
            <th style="width:30px;">Привлекаемая<br>техника</th>
<!--            <th style="width:77px;">Этажность/этаж</th>-->
            <th style="width:215px;" ></th>
            <th style="width:90px;">Причина вызова</th>
            <th style="width:160px;">Детализированная информация</th>
            <th style="width:40px;">Время лок.</th>
            <th style="width:40px;">Время ликв.</th>
<th style="width:30px;">Создатель</th>
            <th style="width:20px;">Ред./Уд.</th>


        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th>Дата</th>
            <th>Время</th>
            <th >Район</th>
            <th>Адрес объекта</th>
            <th></th>
            <th></th>
<!--            <th>Этажность/этаж</th>-->
            <th></th>
            <th>Причина выезда</th>
            <th></th>
            <th>Причина пожара</th>
            <th></th>
            <th></th>
            <th></th>

        </tr>
    </tfoot>
    <tbody>
        <?php
        $i = 0;
        if (isset($rig) && !empty($rig)) {
            foreach ($rig as $row) {
                $i++;

                if ($row['time_loc'] != NULL) {
                    $t_loc = new DateTime($row['time_loc']);
                    $time_loc = $t_loc->Format('H:i');
                } else {
                    $time_loc = '00:00';
                }

                if ($row['time_likv'] != NULL) {
                    $t_likv = new DateTime($row['time_likv']);
                    $time_likv = $t_likv->Format('H:i');
                } else {
                    $time_likv = '00:00';
                }

                ?>
                <tr style="background-color: <?= (isset($reasonrig_color[$row['id_reasonrig']])) ? $reasonrig_color[$row['id_reasonrig']] : 'white' ?>;">

                    <td><?= $row['id'] ?></td>

                    <td><?php
        if ($row['is_closed'] == 0) {//пожар не закрыт

                    ?>
                            <i class="fa fa-exclamation-triangle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Вызов не закрыт"></i>
                            <?php
                        }

                        ?></td>
                    <td><?= $row['date_msg'] ?></td>
                    <td><?= $row['time_msg'] ?></td>
                    <td ><?= $row['local_name'] ?></td>
                    <td>
                        <!--                            если адрес пуст-выводим дополнит поле с адресом-->
                        <?php
                       if ($row['address'] != NULL ){
                            echo $row['address'].'<br>'.$row['additional_field_address'];
                        }
                        else{
                             echo $row['additional_field_address'];
                        }



                        if (!empty($row['object'])) {
                            echo '<br>';
                            echo '(' . $row['object'] . ')';
                        }

                        ?>
                    </td>

                    <td>


                        <?php
                        //            short on technic
                        if (isset($sily_mchs[$row['id']]) && !empty($sily_mchs[$row['id']])) {

                            ?>
                            <ul class="dropdown" style="float: left; padding-left: 0px" data-toggle="tooltip" data-placement="left" title="Привлекаемая техника" >
                                <a href="# "  style="color: #222d32;" class="dropdown-toggle " data-toggle="dropdown" ><i class="fa fa-eye" aria-hidden='true' style="color: #222d32;"></i><b class="caret"></b></a>
                                <ul class="dropdown-menu" id="teh-menu">
                                    <?php
                                    foreach ($sily_mchs[$row['id']] as $si) {
                                        //  $teh = '<b>'.$si['mark'] . '</b> (' . $si['numbsign'] . '), ' . $si['pasp_name'] . ', ' . $si['locorg_name'];
                                        $teh = '<b>' . $si['mark'] . '</b> ' . $si['pasp_name'] . ', ' . $si['locorg_name'];

                                        ?>


                                        <li class="dropdown-submenu">
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>   <?= $teh ?>
                                        </li>

                                        <?php
                                    }

                                    ?>


                                </ul>
                            </ul>
            <?php
        }

        ?>



                        <?php
                        /* GROCHS, who went */
                        if (isset($sily_mchs[$row['id']]) && !empty($sily_mchs[$row['id']])) {

                            $a = array();
                            foreach ($sily_mchs[$row['id']] as $si) {
                                $a[] = $si['locorg_name'];
                            }
                            $result = array_unique($a);

                            foreach ($result as $si) {

                                echo $si . '<br>';
                            }
                        }

                        ?>

                    </td>

                    <td></td>

        <!--                    <td>< $row['floor'] ?></td>-->
                    <td>
                        <?php
                         /* id of rigs, where silymschs/innerservice are not selected */
                        if(isset($result_icons['car']) && in_array($row['id'], $result_icons['car'])){
                            ?>
                        <a href="<?= $baseUrl ?>/rig/new/<?= $row['id'] ?>/2" target="_blank" style="color: #c51a05 !important">
                        <?php
                        }
                        else{
                            ?>
                            <a href="<?= $baseUrl ?>/rig/new/<?= $row['id'] ?>/2" target="_blank">
                            <?php
                        }
                        ?>
                        <i class="fa fa-lg fa-car" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Техника"></i></a>


                        <?php
                          /* id of rigs, where silymschs/innerservice are not selected */
                        if(isset($result_icons['informing']) && in_array($row['id'], $result_icons['informing'])){
                            ?>
                       <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/info" target="_blank" style="color: #c51a05 !important">
                        <?php
                        }
                        else{
                            ?>
                            <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/info" target="_blank">
                            <?php
                        }
                        ?>
                        <i class="fa fa-lg fa-info-circle" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Информирование"></i></a>


                                                <?php
                          /* id of rigs, where silymschs/innerservice are not selected */
                        if(isset($result_icons['character']) && in_array($row['id'], $result_icons['character'])){
                            ?>
                    <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/character" target="_blank" style="color: #c51a05 !important">
                        <?php
                        }
                        else{
                            ?>
                           <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/character" target="_blank">
                            <?php
                        }
                        ?>
                        <i class="fa fa-lg fa-clock-o" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Временные характеристики"></i></a>






                        <!--                        путевка-->
                        <ul class="dropdown" style="float: right;" data-toggle="tooltip" data-placement="left" title="Сформировать путевку" >
                            <a href="# "  style="color: #222d32;" class="dropdown-toggle navbar-right-customer" data-toggle="dropdown" ><i class="fa fa-lg fa-file-text" aria-hidden='true' style="color: #222d32;"></i><b class="caret"></b></a>
                            <ul class="dropdown-menu" id="waybill-menu">
        <?php
        // if ($_SESSION['ulevel'] == 1) {

        ?>

                                <!--                          <li class="dropdown-submenu">
                                                              <a tabindex="-1" href="<?= $baseUrl ?>/waybill/mail/<?= $row['id'] ?>" class="caret-spr_inf" target="_blank"><i class="fa fa-envelope-open-o" aria-hidden="true" style="color:blue"></i>Отправить на почту (pdf)</a>
                                                        </li>-->

                                <li class="dropdown-submenu">
                                    <a tabindex="-1" href="<?= $baseUrl ?>/waybill/pdf_print/<?= $row['id'] ?>" class="caret-spr_inf" target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Печать (pdf)</a>
                                </li>
        <?php
        // }

        ?>

                                <li class="dropdown-submenu">
                                    <a tabindex="-1" href="<?= $baseUrl ?>/waybill/pdf_download/<?= $row['id'] ?>" class="caret-spr_inf" ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red;"></i> Скачать (pdf)</a>
                                </li>

                                <li class="dropdown-submenu">
                                    <a tabindex="-1" href="<?= $baseUrl ?>/waybill/excel_download/<?= $row['id'] ?>" class="caret-spr_inf" ><i class="fa fa-file-excel-o" aria-hidden="true" style="color:green;"></i>Скачать (excel)</a>
                                </li>


                            </ul>
                        </ul>




                    </td>
                    <td><?= $row['reasonrig_name'] ?></td>
        <?php
        $mb_str_len = mb_strlen($row['inf_detail'], 'utf-8');
        if ($mb_str_len >= 100) {// обрезать текст
            $locex = mb_substr($row['inf_detail'], 0, 80, 'utf-8');

            ?>

                        <td  ><span id="sp<?= $i ?>"><?= $locex ?>     <span onclick="see(<?= $i ?>);" data-toggle="collapse" data-target="#collapse<?= $i ?>" style="cursor: pointer" data-toggle="tooltip" data-placement="left" title="Читать далее"><b>...</b></span></span>
                            <p id="collapse<?= $i ?>" class="panel-collapse collapse">
                        <?= $row['inf_detail'] ?>     <span onclick="see(<?= $i ?>);" data-toggle="collapse" data-target="#collapse<?= $i ?>" data-toggle="tooltip" data-placement="left" title="Свернуть" style="cursor: pointer"><b>...</b></span>
                            </p>




                        </td>
                        <?php
                    } else {// не обрезать

                        ?>
                        <td><span id="sp<?= $i ?>"> <?= $row['inf_detail'] ?></span> </td>
            <?php
        }

        ?>
                    <td><?= $time_loc ?></td>
                    <td><?= $time_likv ?></td>
 <td><?= $row['auth_locorg'] ?></td>

                    <td> <a href="<?= $baseUrl ?>/rig/new/<?= $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-warning " type="button"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Редактировать вызов"></i></button></a>

                        <a href="<?= $baseUrl ?>/rig/delete/<?= $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-danger" type="button"><i class="fa fa-trash" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Удалить вызов"></i></button></a>
                    </td>



                </tr>
        <?php
    }
}

?>



    </tbody>
</table>