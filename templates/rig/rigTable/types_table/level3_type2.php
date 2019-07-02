<style>
    .is-neighbor-td{
        border-top: 2px solid  #999 !important;
        border-bottom:  2px solid  #999 !important;

    }

    .sily_mchs_table_small tbody td{
        padding: 0px 6px 0px 6px !important;
    }
        .sily_mchs_table_small  tr{
       background-color: beige !important;
    }

    .teh-cell{
            font-size: 13px !important;
            text-align: left !important;
    }
    .teh-head{
       color:  blue !important;
    }

</style>

    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

    <link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
<link href="https://nightly.datatables.net/fixedheader/css/fixedHeader.dataTables.css?_=f0de745b101295e88f1504c17177ff49.css" rel="stylesheet" type="text/css" />
<script src="https://nightly.datatables.net/fixedheader/js/dataTables.fixedHeader.js?_=f0de745b101295e88f1504c17177ff49"></script>


<div class="noprint" id="conttabl">
    <b> Выберите столбец, чтобы скрыть/отобразить:  </b>
    <b>

        <a class="toggle-vis-rig-table-type2" id="toggle-vis-rig-table-type1-0"  data-column="0" style="background-color: #fdee8d;  color: black">ID</a>&nbsp&nbsp
        <a class="toggle-vis-rig-table-type2" id="toggle-vis-rig-table-type1-13"  data-column="16" style="background-color: #fdee8d;  color: black">Автор создания</a>

    </b>

</div>

<!--таблица выездов для уровня 3 и для уровня 2 (УМЧС) -->
<br>
<?php
//print_r($sily_mchs);
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
<table class="table table-condensed   table-bordered table-custom " id="rigTableType2" style="width: 50%;" >
    <!-- строка 1 -->
    <thead>
        <tr>
            <th style="width:40px;">ID</th>
<!--            <th></th>-->
            <th style="width:57px;">Дата<br>Время</th>
<!--            <th style="width:45px;">Время</th>-->
            <th style="width:80px;">Район</th>
            <th style="width:120px;">Адрес<br>(объект)</th>
<!--            <th style="width:120px;" >Привлекаемые подразделения</th>-->
            <th style="width:224px !important;">Привлекаемая<br>техника</th>

            <th style="width:45px;" class="teh-head">Выезд</th>
            <th style="width:45px;" class="teh-head">Приб.</th>

            <th style="width:40px;">Время лок.</th>
            <th style="width:40px;">Время ликв.</th>

            <th style="width:45px;" class="teh-head">След.</th>
            <th style="width:45px;" class="teh-head">Оконч.<br>работ</th>
            <th style="width:45px;" class="teh-head">Возв.</th>
            <th style="width:45px;" class="teh-head">Расст, км</th>

<!--            <th style="width:77px;">Этажность/этаж</th>-->
            <th style="width:125px;" ></th>
            <th style="width:90px;">Причина вызова</th>
            <th style="width:240px;">Детализированная информация</th>

            <th style="width:30px;">Созда-<br>тель</th>
            <th style="width:20px;">Ред./Уд.</th>


        </tr>

    </thead>
    <tfoot>
        <tr>
            <th></th>
<!--            <th></th>-->
            <th></th>
<!--            <th>Время</th>-->
            <th >Район</th>
            <th>Адрес объекта</th>
<!--            <th></th>-->
            <th></th>
<!--            <th>Этажность/этаж</th>-->
                        <th></th>
            <th></th>
            <th></th>
                        <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Причина выезда</th>
            <th></th>
            <th></th>
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



                if (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) {

                    ?>
                    <tr style="background-color:#ddd; border: 5px solid #da0d0d !important; ">
                        <?php
                    } else {

                        ?>
                    <tr style="background-color: <?= (isset($reasonrig_color[$row['id_reasonrig']])) ? $reasonrig_color[$row['id_reasonrig']] : 'white' ?>;">
                        <?php
                    }

                    ?>


                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
                        <?php
                        if (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) {

                            ?>
                           !&nbsp; <i class="fa fa-share" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Выезд в соседний гарнизон"></i>
                            <?php
                        }

                        ?>&nbsp;
                        <a href="<?= $baseUrl ?>/card_rig/0/<?= $row['id'] ?>" style="color:black" target="_blank" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку вызова">       <?= $row['id'] ?></a></td>


                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><?= date('d.m.Y', strtotime($row['date_msg'])) ?><br><?= $row['time_msg'] ?>

                        <?php
                                if ($row['is_closed'] == 0) {//пожар не закрыт
                                    if (!empty($row['empty_fields'])) {

                                        ?>
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: red" data-toggle="tooltip" data-placement="right"
                                           title="Вызов не закрыт. Не заполнены поля: <?= implode(', ', $row['empty_fields']) ?>"></i>
                                           <?php
                                       } else {

                                           ?>
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Вызов не закрыт"></i>
                                        <?php
                                    }
                                } elseif (!empty($row['empty_fields'])) {

                                    ?>
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: red" data-toggle="tooltip" data-placement="right"
                                       title="Не заполнены поля: <?= implode(', ', $row['empty_fields']) ?>"></i>
                                    <?php
                                }

                        ?>
                    </td>
<!--                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><?= $row['time_msg'] ?></td>-->
                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><?= $row['local_name'] ?></td>
                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
                        <!--                            если адрес пуст-выводим дополнит поле с адресом-->
                        <?php
                        if ($row['address'] != NULL) {
                            echo $row['address'] . '<br>' . $row['additional_field_address'];
                        } else {
                            echo $row['additional_field_address'];
                        }



                        if (!empty($row['object'])) {
                            echo '<br>';
                            echo '(' . $row['object'] . ')';
                        }

                        ?>
                    </td>



                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?> teh-cell" >

                        <?php
                        //            short on technic
                        if (isset($teh_mark[$row['id']]) && !empty($teh_mark[$row['id']])) {

                                    foreach ($teh_mark[$row['id']] as $si) {

                                        //echo $si;
                                        //echo '<br>';
                                       ?>
                        <p><?= $si  ?></p>
                        <?php


                                        // if(isset($i['time_exit']) && !empty($i['time_exit']))
                                    }
                                }

                                ?>


                    </td>


                     <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

                        <?php
                        //            short on technic
                        if (isset($exit_time[$row['id']]) && !empty($exit_time[$row['id']])) {

                                    foreach ($exit_time[$row['id']] as $si) {

                                       // echo $si;
                                        ?>
                         <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время выезда"><?= $si ?></p>

                         <?php
                                       // echo '<br>';
                                        // if(isset($i['time_exit']) && !empty($i['time_exit']))
                                    }
                                }

                                ?>


                    </td>


                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

                        <?php
                        //            short on technic
                        if (isset($arrival_time[$row['id']]) && !empty($arrival_time[$row['id']])) {

                                    foreach ($arrival_time[$row['id']] as $si) {

                                        //echo $si;
                                       // echo '<br>';
                                        // if(isset($i['time_exit']) && !empty($i['time_exit']))
                                        ?>
                        <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время прибытия"><?= $si ?></p>
                        <?php
                                    }
                                }

                                ?>


                    </td>

                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><span aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Локализация"><?= $time_loc ?></span></td>
                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><span aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ликвидация"><?= $time_likv ?></span></td>


                     <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

                        <?php
                        //            short on technic
                        if (isset($follow_time[$row['id']]) && !empty($follow_time[$row['id']])) {

                                    foreach ($follow_time[$row['id']] as $si) {

                                        //echo $si;
                                       // echo '<br>';
                                        // if(isset($i['time_exit']) && !empty($i['time_exit']))
                                     ?>
                         <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время следования"><?= $si ?></p>
                         <?php


                                    }
                                }

                                ?>


                    </td>

                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

                        <?php
                        //            short on technic
                        if (isset($end_time[$row['id']]) && !empty($end_time[$row['id']])) {

                                    foreach ($end_time[$row['id']] as $si) {

                                       // echo $si;
                                        //echo '<br>';
                                        // if(isset($i['time_exit']) && !empty($i['time_exit']))
                                        ?>
<p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время окончания работ"><?= $si ?></p>
                        <?php
                                    }
                                }

                                ?>


                    </td>


                 <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

                        <?php
                        //            short on technic
                        if (isset($return_time[$row['id']]) && !empty($return_time[$row['id']])) {

                                    foreach ($return_time[$row['id']] as $si) {

                                       // echo $si;
                                       // echo '<br>';
                                        // if(isset($i['time_exit']) && !empty($i['time_exit']))
                                        ?>
                     <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время возвращения"><?= $si ?></p>
                     <?php
                                    }
                                }

                                ?>


                    </td>


                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

                        <?php
                        //            short on technic
                        if (isset($distance[$row['id']]) && !empty($distance[$row['id']])) {

                                    foreach ($distance[$row['id']] as $si) {

                                       // echo $si;
                                       // echo '<br>';
                                        // if(isset($i['time_exit']) && !empty($i['time_exit']))
                                        ?>
                        <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Расстояние, км."><?= $si ?></p>
                        <?php
                                    }
                                }

                                ?>


                    </td>









                <!--                    <td>< $row['floor'] ?></td>-->
                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
        <?php
        /* id of rigs, where silymschs/innerservice are not selected */
        if (isset($result_icons['car']) && in_array($row['id'], $result_icons['car'])) {

            ?>
                            <a href="<?= $baseUrl ?>/rig/new/<?= $row['id'] ?>/2" target="_blank" style="color: #c51a05 !important">
                            <?php
                        } else {

                            ?>
                                <a href="<?= $baseUrl ?>/rig/new/<?= $row['id'] ?>/2" target="_blank">
                                <?php
                            }

                            ?>
                                <i class="fa fa-lg fa-car" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Техника"></i></a>


                            <?php
/* id of rigs, where silymschs/innerservice are not selected */
                                if (isset($result_icons['informing']) && in_array($row['id'], $result_icons['informing'])) {

                                    ?>
                                    <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/info" target="_blank" style="color: #c51a05 !important">
                                        <i class="fa fa-lg fa-info-circle" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Информирование. Не заполнено."></i></a>
                                    <?php
                                } elseif (isset($not_full_info) && in_array($row['id'], $not_full_info)) {

                                    ?>
                                    <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/info" target="_blank"  style="color: #f39c12 !important">
                                        <i class="fa fa-lg fa-info-circle" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Информирование. Заполнено частично."></i></a>
                                    <?php
                                } else {

                                    ?>
                                    <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/info" target="_blank">
                                        <i class="fa fa-lg fa-info-circle" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Информирование"></i></a>
                                    <?php
                                }

                                ?>
                                <?php
                                /* id of rigs, where silymschs/innerservice are not selected */
                                if (isset($result_icons['character']) && in_array($row['id'], $result_icons['character'])) {

                                    ?>
                                    <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/character" target="_blank" style="color: #c51a05 !important">
                                        <i class="fa fa-lg fa-clock-o" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Временные характеристики"></i></a>
                                    <?php
                                } elseif (isset($not_full_sily) && in_array($row['id'], $not_full_sily)) {

                                    ?>
                                    <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/character" target="_blank"  style="color: #f39c12 !important">
                                        <i class="fa fa-lg fa-clock-o" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Временные характеристики. Не заполнено время возвращения"></i></a>
                                    <?php
                                } else {

                                    ?>
                                    <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/character" target="_blank">
                                        <i class="fa fa-lg fa-clock-o" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Временные характеристики"></i></a>
                                    <?php
                                }

                                ?>

                                 <a href="<?= $baseUrl ?>/results_battle/<?= $row['id'] ?>" target="_blank">
                                <i class="fa fa-lg fa-male" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Результаты боевой работы"></i></a>

                                  <a href="<?= $baseUrl ?>/trunk/<?= $row['id'] ?>" target="_blank">
                                <i class="fa fa-lg fa-free-code-camp" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Результаты боевой работы"></i></a>



                                    <!--                        путевка-->
                                    <br><br>
                                    <ul class="dropdown" style="float: right;" data-toggle="tooltip" data-placement="left" title="Сформировать путевку" >
                                        <a href="# "  style="color: #222d32;" class="dropdown-toggle navbar-right-customer" data-toggle="dropdown" ><i class="fa  fa-file-text" aria-hidden='true' style="color: #222d32;"></i><b class="caret"></b></a>
                                        <ul class="dropdown-menu" id="waybill-menu">
                                            <?php
                                            // if ($_SESSION['ulevel'] == 1) {

                                            ?>

                                            <!--                          <li class="dropdown-submenu">
                                                                          <a tabindex="-1" href="<?= $baseUrl ?>/waybill/mail/<?= $row['id'] ?>" class="caret-spr_inf" target="_blank"><i class="fa fa-envelope-open-o" aria-hidden="true" style="color:blue"></i>Отправить на почту (pdf)</a>
                                                                    </li>-->

                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="<?= $baseUrl ?>/waybill/html_pdf_print/<?= $row['id'] ?>/0/0" class="caret-spr_inf" target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Печать (pdf)</a>
                                            </li>

                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="<?= $baseUrl ?>/waybill/html_pdf_print/<?= $row['id'] ?>/1/0" class="caret-spr_inf" target="_blank"><i class="fa fa-print" aria-hidden="true"></i>Печать (pdf + меры)</a>
                                            </li>
                                            <?php
                                            // }

                                            ?>

                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="<?= $baseUrl ?>/waybill/html_pdf_print/<?= $row['id'] ?>/0/1" class="caret-spr_inf" ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red;"></i> Скачать (pdf)</a>
                                            </li>

                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="<?= $baseUrl ?>/waybill/html_pdf_print/<?= $row['id'] ?>/1/1" class="caret-spr_inf" ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red;"></i> Скачать (pdf + меры)</a>
                                            </li>

                                            <li class="dropdown-submenu">
                                                <a tabindex="-1" href="<?= $baseUrl ?>/waybill/excel_download/<?= $row['id'] ?>" class="caret-spr_inf" ><i class="fa fa-file-excel-o" aria-hidden="true" style="color:green;"></i>Скачать (excel)</a>
                                            </li>


                                        </ul>
                                    </ul>




                                    </td>
                                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><?= $row['reasonrig_name'] ?></td>
                                    <?php
                                    $mb_str_len = mb_strlen($row['inf_detail'], 'utf-8');
                                    if ($mb_str_len >= 100) {// обрезать текст
                                        $locex = mb_substr($row['inf_detail'], 0, 80, 'utf-8');

                                        ?>

                                        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>"   ><span id="sp<?= $i ?>"><?= $locex ?>     <span onclick="see(<?= $i ?>);" data-toggle="collapse" data-target="#collapse<?= $i ?>" style="cursor: pointer" data-toggle="tooltip" data-placement="left" title="Читать далее"><b>...</b></span></span>
                                            <p id="collapse<?= $i ?>" class="panel-collapse collapse">
            <?= $row['inf_detail'] ?>     <span onclick="see(<?= $i ?>);" data-toggle="collapse" data-target="#collapse<?= $i ?>" data-toggle="tooltip" data-placement="left" title="Свернуть" style="cursor: pointer"><b>...</b></span>
                                            </p>




                                        </td>
                                        <?php
                                    } else {// не обрезать

                                        ?>
                                        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><span id="sp<?= $i ?>"> <?= $row['inf_detail'] ?></span> </td>
                                        <?php
                                    }

                                    ?>

                                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>"><?= $row['auth_locorg'] ?></td>

                                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

                                        <?php
                                        if (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) {

                                            ?>
<!--                                        <a href="< $baseUrl ?>/rig/new/< $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-default  " type="button"><i class="fa fa-eye fa-lg" style="color:blue" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Подробнее"></i></button></a>-->
                                           <a href="<?= $baseUrl ?>/rig/new/<?= $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-warning " type="button"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Редактировать вызов"></i></button></a>
 <?php
                                        } else {

                                            ?>
 <a href="<?= $baseUrl ?>/rig/new/<?= $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-warning " type="button"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Редактировать вызов"></i></button></a>
 <a href="<?= $baseUrl ?>/rig/delete/<?= $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-danger" type="button"><i class="fa fa-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Удалить вызов"></i></button></a>
                                                    <?php
                                                }

                                                ?>

                                    </td>



                                    </tr>
                                    <?php
                                }
                            }

                            ?>



                            </tbody>
                            </table>



<script>

    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example thead tr:eq(1) th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" class="column_search" />' );
    } );

    // DataTable
    var table = $('#example').DataTable({
      orderCellsTop: true,
      fixedHeader: true,
      pageLength: 100
    });

// Apply the search
    $( '#example thead'  ).on( 'keyup', ".column_search",function () {

        table
            .column( $(this).parent().index() )
            .search( this.value )
            .draw();
    } );

} );
    </script>



