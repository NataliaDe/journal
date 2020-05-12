<style>
    .is-neighbor-td{
        border-top: 2px solid  #999 !important;
        border-bottom:  2px solid  #999 !important;

    }


    .teh-cell{
        font-size: 12px !important;
        text-align: left !important;
        padding-left: 2px !important;
        padding-right: 2px !important;

    }
    .teh-head{
        color:  blue !important;
    }

    .time-cell{
        /*        text-align: left !important;*/
    }



    #selrigFormType42,#selrigFormType413,#selrigFormType415,#selrigFormType416,#inptrigFormType414{
        width: 91px;
    }
    #inptrigFormType40,#inptrigFormType45,#inptrigFormType46,#inptrigFormType47,#inptrigFormType48,
    #inptrigFormType49,#inptrigFormType410,#inptrigFormType411,#inptrigFormType412{
        width: 50px;
    }
    #inptrigFormType41{
        width: 77px;
    }
    #inptrigFormType43{
        width: 120px;
    }
    #inptrigFormType44{
        width: 340px;
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

        <a class="toggle-vis-rig-table-type4" id="toggle-vis-rig-table-type1-0"  data-column="0" style="background-color: #fdee8d;  color: black">ID</a>&nbsp&nbsp
        <a class="toggle-vis-rig-table-type4" id="toggle-vis-rig-table-type1-13"  data-column="16" style="background-color: #fdee8d;  color: black">Автор создания</a>

    </b>

</div>

<!--таблица выездов для уровня 3 и для уровня 2 (УМЧС) -->
<br>
<?php
include dirname(dirname(__FILE__)) . '/header_rig_table.php';
//print_r($rig_cars);exit();

?>
<table class="table table-condensed   table-bordered table-custom " id="rigTableType4" style=" font-size: 12px" >
    <!-- строка 1 -->
    <thead>
        <tr>
            <th style="width:40px;">ID</th>

            <th style="width:57px;">Дата</th>
            <th style="width:80px;">Район</th>
            <th style="width:120px;">Адрес<br>(объект)</th>
            <th style="width:224px !important;">Привлекаемая СиС МЧС, других ведомств.<br>
                Информирование должностных лиц, аварийных служб</th>

            <th style="width:80px;">Время<br>инф.<br>должн. лиц,<br>авар.<br>служб</th>
            <th style="width:80px;">Время сообщ. о ЧС</th>
            <th style="width:45px;" class="teh-head">Выезд</th>
            <th style="width:45px;" class="teh-head">Приб. к месту ЧС</th>
            <th style="width:40px;">Время лок.</th>
            <th style="width:40px;">Время ликв.</th>
            <th style="width:45px;" class="teh-head">Возв.</th>
            <th style="width:45px;" class="teh-head">Расст. до места ЧС, км</th>

            <th style="width:90px;">Причина вызова</th>
            <th style="width:240px;">Детализ.<br>информация</th>
            <th style="width:90px;">Вид<br>работ</th>

            <th style="width:30px;">Созда-<br>тель</th>
            <th style="width:20px;">Ред./Уд.</th>


        </tr>

    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th >Район</th>
            <th>Адрес объекта</th>
            <th></th>
            <th></th>
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


        </tr>
    </tfoot>
    <tbody>
        <?php
        $i = 0;
        if (isset($rig) && !empty($rig)) {
            foreach ($rig as $row) {
                $i++;

                if ($row['time_loc'] != NULL && $row['time_loc'] != '0000-00-00 00:00:00') {
                    $t_loc = new DateTime($row['time_loc']);
                    $time_loc = $t_loc->Format('H:i');
                } else {
                    $time_loc = '';
                }

                if ($row['time_likv'] != NULL && $row['time_likv'] != '0000-00-00 00:00:00') {
                    $t_likv = new DateTime($row['time_likv']);
                    $time_likv = $t_likv->Format('H:i');
                } elseif ($row['is_likv_before_arrival'] == 1) {
                    $time_likv = 'ликв.до прибытия';
                } elseif ($row['is_closed'] == 1) {
                    $time_likv = 'не учитывать даты';
                } else {
                    $time_likv = '';
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
                        <a href="<?= $baseUrl ?>/card_rig/0/<?= $row['id'] ?>" style="color:black" target="_blank" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку вызова">       <?= $row['id'] ?></a>
                    </td>


                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" id="<?= $row['id'] ?>" >
                        <?= date('d.m.Y', strtotime($row['date_msg'])) ?>


                        <?php
                        if ($row['is_copy'] == 1) {

                            ?>
                            <i class="fa fa-copyright" style="font-weight:600; color: red" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Вызов создан по шаблону: ID = <?= $row['copy_rig_id'] ?>"></i>
                            <br>
                            <?php
                        }

                        ?>

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

                        <!--                        is update rig now-->
            <center>
                <div  id="is_update_rig_now_<?= $row['id'] ?>">


                    <?php
                    if (isset($row['is_update_now']) && $row['is_update_now'] != '') {

                        include dirname(dirname(__FILE__)) . '/div_is_update_rig_now.php';
                    }

                    ?>
                </div>
            </center>
            <!--              END          is update rig now-->


        </td>

        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
            <?= $row['local_name'] ?>

        </td>

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
            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {

                foreach ($rig_cars[$row['id']] as $val) {

                    ?>
                    <p><?= $val['mark'] ?><?= ' ' . $val['pasp_name'] ?><?= ' ' . $val['locorg_name'] ?></p>
                    <?php
                }
            }


            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                foreach ($rig_innerservice[$row['id']] as $val) {

                    ?>
                    <p><?= $val['service_name'] ?></p>
                    <?php
                }
            }

            if (isset($rig_informing[$row['id']]) && !empty($rig_informing[$row['id']])) {
                $loop = 0;
                foreach ($rig_informing[$row['id']] as $val) {

                    $loop++;

                    $length_name = mb_strlen($val['fio'], 'utf-8');

                    if ($length_name > 50) {

                        $part_name = mb_substr($val['fio'], 0, 50, 'utf-8');

                        ?>
                        <span id="span_inf<?= $loop ?>">
                            <p><?= $part_name ?>
                                <span onclick="see_informing(<?= $loop ?>);" data-toggle="collapse" data-target="#collapse_inf<?= $loop ?>" style="cursor: pointer" data-toggle="tooltip" data-placement="left" title="<?= $val['fio'] ?>">
                                    <b>...</b>
                                </span>
                            </p>
                        </span>
                        <p id="collapse_inf<?= $loop ?>" class="panel-collapse collapse">
                            <?= $val['fio'] ?>     <span onclick="see_informing(<?= $loop ?>);" data-toggle="collapse" data-target="#collapse_inf<?= $loop ?>" data-toggle="tooltip" data-placement="left" title="Свернуть" style="cursor: pointer"><b>...</b></span>
                        </p>
                        <?php
                    } else {

                        ?>
                        <p><?= $val['fio'] ?></p>
                        <?php
                    }

                    ?>

                    <?php
                }
            }

            ?>
        </td>


        <td class=" time-cell <?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

            <?php
            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                foreach ($rig_cars[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время информирования">
                        -

                    </p>
                    <?php
                }
            }


            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                foreach ($rig_innerservice[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время информирования"><?= ($val['time_msg'] != null) ? date('H:i', strtotime($val['time_msg'])) : '' ?></p>
                    <?php
                }
            }

            if (isset($rig_informing[$row['id']]) && !empty($rig_informing[$row['id']])) {
                foreach ($rig_informing[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время информирования"><?= ($val['time_msg'] != null) ? date('H:i', strtotime($val['time_msg'])) : '' ?></p>
                    <?php
                }
            }

            ?>


        </td>


        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
            <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время сообщения о ЧС"><?= date('H:i', strtotime($row['time_msg'])) ?></p>
        </td>


        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

            <?php
            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                foreach ($rig_cars[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время выезда"><?= ($val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '' ?></p>
                    <?php
                }
            }


            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                foreach ($rig_innerservice[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время выезда">-</p>
                    <?php
                }
            }

            if (isset($rig_informing[$row['id']]) && !empty($rig_informing[$row['id']])) {
                foreach ($rig_informing[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время выезда"><?= ($val['time_exit'] != null) ? date('H:i', strtotime($val['time_exit'])) : '' ?></p>
                    <?php
                }
            }

            ?>


        </td>



        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

            <?php
            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                foreach ($rig_cars[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время прибытия">
                        <?= ($val['is_return'] == 1) ? 'возврат' : (($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '') ?>
                    </p>
                    <?php
                }
            }


            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                foreach ($rig_innerservice[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время прибытия"><?= ($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '' ?></p>
                    <?php
                }
            }

            if (isset($rig_informing[$row['id']]) && !empty($rig_informing[$row['id']])) {
                foreach ($rig_informing[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время прибытия"><?= ($val['time_arrival'] != null) ? date('H:i', strtotime($val['time_arrival'])) : '' ?></p>
                    <?php
                }
            }

            ?>


        </td>




        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
            <span aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Локализация">
                <?= $time_loc ?>
            </span>
        </td>
        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
            <span aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ликвидация">
                <?= $time_likv ?>
            </span>
        </td>




        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

            <?php
            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                foreach ($rig_cars[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время возвращения"><?= ($val['time_return'] != null) ? date('H:i', strtotime($val['time_return'])) : '' ?></p>
                    <?php
                }
            }


            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                foreach ($rig_innerservice[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время возвращения">-</p>
                    <?php
                }
            }

            if (isset($rig_informing[$row['id']]) && !empty($rig_informing[$row['id']])) {
                foreach ($rig_informing[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Время возвращения">-</p>
                    <?php
                }
            }

            ?>


        </td>



        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

            <?php
            if (isset($rig_cars[$row['id']]) && !empty($rig_cars[$row['id']])) {
                foreach ($rig_cars[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Расстояние, км."><?= $val['distance'] ?></p>
                    <?php
                }
            }


            if (isset($rig_innerservice[$row['id']]) && !empty($rig_innerservice[$row['id']])) {
                foreach ($rig_innerservice[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Расстояние, км."><?= $val['distance'] ?></p>
                    <?php
                }
            }

            if (isset($rig_informing[$row['id']]) && !empty($rig_informing[$row['id']])) {
                foreach ($rig_informing[$row['id']] as $val) {

                    ?>
                    <p aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Расстояние, км.">-</p>
                    <?php
                }
            }

            ?>


        </td>







        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
            <?= $row['reasonrig_name'] ?>
        </td>


        <?php
        $mb_str_len = mb_strlen($row['inf_detail'], 'utf-8');
        if ($mb_str_len >= 100) {// обрезать текст
            $locex = mb_substr($row['inf_detail'], 0, 80, 'utf-8');

            ?>

            <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>"   >
                <span id="sp<?= $i ?>">
                    <?= $locex ?>
                    <span onclick="see(<?= $i ?>);" data-toggle="collapse" data-target="#collapse<?= $i ?>" style="cursor: pointer" data-toggle="tooltip" data-placement="left" title="Читать далее">
                        <b>...</b>
                    </span>
                </span>
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

        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>">
            <?= $row['view_work'] ?>
        </td>

        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>">
            <?= $row['auth_locorg'] ?>
        </td>

        <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

            <?php
            if (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) {

                ?>
                                                                                    <!--                                        <a href="< $baseUrl ?>/rig/new/< $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-default  " type="button"><i class="fa fa-eye fa-lg" style="color:blue" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Подробнее"></i></button></a>-->
                <a href="<?= $baseUrl ?>/rig/new/<?= $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-warning " type="button"><i class="fa <?= ($_SESSION['can_edit'] == 0) ? 'fa-eye' : 'fa-pencil' ?>" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Редактировать вызов"></i></button></a>
                <?php
            } else {

                ?>
                <a href="<?= $baseUrl ?>/rig/new/<?= $row['id'] ?>" target="_blank" > <button class="btn btn-xs btn-warning " type="button"><i class="fa <?= ($_SESSION['can_edit'] == 0) ? 'fa-eye' : 'fa-pencil' ?>" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Редактировать вызов"></i></button></a>
                <br><br>
                <a class="<?= ($_SESSION['can_edit'] == 0) ? 'disabled-link' : '' ?>" href="<?= $baseUrl ?>/rig/delete/<?= $row['id'] ?>" target="_blank" > <button class="btn btn-xs btn-danger" type="button"><i class="fa fa-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Удалить вызов"></i></button></a>


                <?php
            }

            ?>
            <br><br>
            <a  href="#" class="create-copy-link <?= ($_SESSION['can_edit'] == 0) ? 'disabled-link' : '' ?>" data-toggle="modal"  data-target="#modal-create-copy" data-id="<?= $row['id'] ?>" data-url="<?= $baseUrl ?>/copy_rig/<?= $row['id'] ?>"  aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Создать копию выезда" > <button class="btn btn-xs btn-info" type="button"><i class="fa fa-copy" ></i></button></a>
        </td>



        </tr>
        <?php
    }
}

?>



</tbody>
</table>





<script>

    $(document).ready(function () {

        var rig_table_vis_type4 = $('#rigTableType4').DataTable({
            //fixedHeader: true,
            // fixedHeader: {
            //header: true,
            //  footer:true
            //headerOffset: 15
            //$('#fixed').height()
            //  },
//           "fixedHeader": {
//      header: true
//    },
            orderCellsTop: true,
            fixedHeader: true,

            "pageLength": 50,
            "order": [],
            language: {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }

            }
//                                 "columnDefs": [
//            {
//                "targets": [ 13 ],
//                "visible": false
//            }
//        ]
        });

        $("tfoot").css("display", "table-header-group");//tfoot of table


        $('a.toggle-vis-rig-table-type4').on('click', function (e) {
            e.preventDefault();

            // Get the column API object
            var column_type4 = rig_table_vis_type4.column($(this).attr('data-column'));

            // Toggle the visibility
            column_type4.visible(!column_type4.visible());


        });


        $('#rigTableType4 tfoot th').each(function (i) {
            var table = $('#rigTableType4').DataTable();
            if (i != 17) {

                if (i == 15 || i == 16 || i == 13 || i == 2) {
                    //выпадающий список
                    var y = 'rigFormType4';
                    var select = $('<select class="' + i + '  noprint" id="sel' + y + i + '"><option value=""></option></select>')
                            .appendTo($(this).empty())
                            .on('change', function () {

                                var val = $(this).val();

                                table.column(i) //Only the first column
                                        .search(val ? '^' + $(this).val() + '$' : val, true, false)
                                        .draw();
                            });

                    var x = $('#rigTableType4 tfoot th').index($(this));
                    table.column(i).data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '" >' + d + '</option>');
                    });


                } else {
                    var title = $('#rigTableType4 tfoot th').eq($(this).index()).text();
                    var x = $('#rigTableType4 tfoot th').index($(this));
                    var y = 'rigFormType4';
                    //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                    $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
                    // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
                }

            }
        });
        $("#rigTableType4 tfoot input").on('keyup change', function () {
            var table = $('#rigTableType4').DataTable();
            table
                    .column($(this).parent().index() + ':visible')
                    .search(this.value)
                    .draw();
        });

    });



    function see_informing(i) {// скрыть/показать детализ инф в табл выездов

        var p = document.getElementById('span_inf' + i);

        if (p.style.display == "none") {
            p.style.display = "block";

        } else {
            p.style.display = "none";
        }

    }
</script>





