<?php
if (isset($settings_user['vid_rig_table']) && $settings_user['vid_rig_table']['name_sign'] == 'level3_type1') {//type1
    include dirname(__FILE__) . '/types_table/level3_type1.php';
    //echo $_SESSION['id_user'];
    //print_r($settings_user);
} elseif (isset($settings_user['vid_rig_table']) && $settings_user['vid_rig_table']['name_sign'] == 'level3_type2') {//type2
    include dirname(__FILE__) . '/types_table/level3_type2.php';
} elseif (isset($settings_user['vid_rig_table']) && $settings_user['vid_rig_table']['name_sign'] == 'level3_type3') {//type1
    include dirname(__FILE__) . '/types_table/level3_type3.php';
} elseif (isset($settings_user['vid_rig_table']) && $settings_user['vid_rig_table']['name_sign'] == 'level3_type4') {//type4
    include dirname(__FILE__) . '/types_table/level3_type4.php';
} else {//standart table

    ?>

    <style>
        .is-neighbor-td{
            border-top: 2px solid  #999 !important;
            border-bottom:  2px solid  #999 !important;

        }

        #inptrigForm13{
            width: 91px;
        }
    </style>

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
    include dirname(__FILE__) . '/header_rig_table.php';
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
                        } elseif (isset($row['is_not_my']) && $row['is_not_my'] == 1) {

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
                                !&nbsp;  <i class="fa fa-share" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Выезд в соседний гарнизон"></i>
                                <?php
                            }

                            ?>&nbsp;
                            <b> <a href="<?= $baseUrl ?>/card_rig/0/<?= $row['id'] ?>" style="color:black" target="_blank" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку вызова"> <?= $row['id'] ?></a></b>

                            <!--                        is update rig now-->
                <center>
                    <div  id="is_update_rig_now_<?= $row['id'] ?>">


                        <?php
                        if (isset($row['is_update_now']) && $row['is_update_now'] != '') {

                            include dirname(__FILE__) . '/div_is_update_rig_now.php';
                        }

                        ?>
                    </div>
                </center>
                <!--              END          is update rig now-->

            </td>

            <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>"  >

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

                if ($row['is_mes_time'] == 1 && (isset($settings_user['is_mes_time']) && $settings_user['is_mes_time']['name_sign'] == 'yes')) {

                    ?>
                    <i class="fa fa-clock-o is_mes_time" aria-hidden="true"  data-toggle="tooltip" data-placement="right" title="<?= $row['is_mes_time_text'] ?>"></i>
                    <?php
                }

                ?></td>
            <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><?= date('d.m.Y', strtotime($row['date_msg'])) ?></td>
            <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><?= date('H:i', strtotime($row['time_msg'])) ?></td>
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

            <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >


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

            <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

                <?php
                //            short on technic
                if (isset($sily_mchs[$row['id']]) && !empty($sily_mchs[$row['id']])) {

                    foreach ($sily_mchs[$row['id']] as $si) {
                        $teh = '<b>' . $si['mark'] . '</b> ';
                        //$teh = '<b>' . $si['mark'] . '</b> ' . $si['pasp_name'] . ', ' . $si['locorg_name'];
                        echo $teh . '<br>';
                    }
                }

                ?>

            </td>

                                                                <!--                    <td>< $row['floor'] ?></td>-->
            <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
                <?php
                /* id of rigs, where silymschs/innerservice are not selected */
                if (isset($result_icons['car']) && in_array($row['id'], $result_icons['car']) && $row['is_sily_mchs'] != 1) {

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
                    if (in_array($row['id_reasonrig'], $reasonrig_with_informing)) {
                        /* reasonrig: 18 - zanyatia,
                          47 - hoz work
                         * 75 - ispitania PTV
                         * 41 - remont, TO
                         * 33 - platnie uslugi
                         * 71 - zapravka. vid work: 135 - gsm */
                        $no_informing = array(18, 47, 75, 41, 33);

                        if ($row['id_reasonrig'] == 71 && $row['view_work_id'] == 135)
                            $no_informing[] = 71;

                        if (in_array($row['id_reasonrig'], $no_informing)) {

                            ?>
                            <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/info" target="_blank">
                                <i class="fa fa-lg fa-info-circle" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Информирование. Не требует заполнения для указанной причины выезда."></i></a>
                            <?php
                        } elseif ($row['is_informing'] == 1) {

                            ?>
                            <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/info" target="_blank" >
                                <i class="fa fa-lg fa-info-circle" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Информирование. Не выезжали."></i></a>
                            <?php
                        } elseif (isset($result_icons['informing']) && in_array($row['id'], $result_icons['informing'])) {

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
                        <i class="fa fa-lg fa-male <?= (isset($row['is_empty_rb']) && $row['is_empty_rb'] == 1) ? 'rb-warning' : '' ?>" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Результаты боевой работы"></i></a>

                    <a href="<?= $baseUrl ?>/trunk/<?= $row['id'] ?>" target="_blank">
                        <i class="fa fa-lg fa-free-code-camp" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Подача стволов" style="color: <?= (isset($trunk_by_rig) && isset($trunk_by_rig[$row['id']]) && !empty($trunk_by_rig[$row['id']])) ? 'green' : '' ?>"></i></a>



                    <!--                        путевка-->
                    <br><br>

                    <ul class="dropdown" style="float: right;"  >

                        <?php
                        if ($is_show_link_sd == 1) {

                            ?>
                                                <!--                        <a href="<?= $baseUrl ?>/login_to_speciald/<?= $row['id'] ?>" target="_blank" >
                                                                            <img src="<?= $baseUrl ?>/assets/images/sd.png" style="width:20px" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Сформировать СД">
                                                                        </a>-->

                            <?php
                            include 'parts/go_to_sd.php';
                        }

                        ?>


                        <a href="# "  style="color: #222d32;" class="dropdown-toggle navbar-right-customer" data-toggle="dropdown" data-toggle="tooltip" data-placement="left" title="Сформировать путевку"><i class="fa fa-file-text" aria-hidden='true' style="color: #222d32;"></i><b class="caret"></b></a>
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

                    <?php
                } else {// не обрезать

                    ?>
                <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><span id="sp<?= $i ?>"> <?= $row['inf_detail'] ?></span>
                    <?php
                }

                ?>

                <?= (isset($row['number_sim']) && !empty($row['number_sim'])) ? '<br><br>№ Сим-карты: ' . $row['number_sim'] : '' ?>
                   <?= (isset($row['inspector']) && !empty($row['inspector']) && in_array($row['id_reasonrig'], $reason_show_inspector)) ? '<br><br>Инспектор: ' . $row['inspector'] : '' ?>
            </td>

            <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><?= $time_loc ?></td>
            <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" ><?= $time_likv ?></td>
            <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>"><?= $row['auth_locorg'] ?>
                <br>
                <?= (isset($row['date_insert']) && !empty($row['date_insert'])) ? (date('d.m.Y H:i:s', strtotime($row['date_insert']))) : '' ?>
            </td>

            <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >

                <?php
                if ((isset($row['is_neighbor']) && $row['is_neighbor'] == 1) || (isset($row['is_not_my']) && $row['is_not_my'] == 1)) {

                    ?>
                    <a href="<?= $baseUrl ?>/rig/new/<?= $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-warning " type="button"><i class="fa <?= ($_SESSION['can_edit'] == 0) ? 'fa-eye' : 'fa-pencil' ?>" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Редактировать вызов"></i></button></a>
                <!--  <a href="< $baseUrl ?>/rig/new/< $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-default  " type="button"><i class="fa fa-eye fa-lg" style="color:blue" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Подробнее"></i></button></a>-->
                    <?php
                } else {

                    ?>
                    <a  href="<?= $baseUrl ?>/rig/new/<?= $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-warning " type="button"><i class="fa <?= ($_SESSION['can_edit'] == 0) ? 'fa-eye' : 'fa-pencil' ?>" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Редактировать вызов"></i></button></a>
                    <a class="<?= ($_SESSION['can_edit'] == 0) ? 'disabled-link' : '' ?>" href="<?= $baseUrl ?>/rig/delete/<?= $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-danger" type="button"><i class="fa fa-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Удалить вызов"></i></button></a>
                    <?php
                }


                if ((isset($settings_user['is_copy_rig']) && $settings_user['is_copy_rig']['name_sign'] == 'yes')) {

                    ?>
                    <a href="#" class="create-copy-link <?= ($_SESSION['can_edit'] == 0) ? 'disabled-link' : '' ?>" data-toggle="modal"  data-target="#modal-create-copy" data-id="<?= $row['id'] ?>" data-url="<?= $baseUrl ?>/copy_rig/<?= $row['id'] ?>"  aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Создать копию выезда"> <button class="btn btn-xs btn-info" type="button"><i class="fa fa-copy" ></i></button></a>

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

    <?php
    $pageLength = ((isset($settings_user['cnt_rows_rigtable']) && isset($settings_user['cnt_rows_rigtable']['name_sign']))) ? $settings_user['cnt_rows_rigtable']['name_sign'] : 50;
}

?>

<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

<?php
if ((isset($settings_user['update_rig_now']) && $settings_user['update_rig_now']['name_sign'] == 'yes')) {
    if (isset($rig) && !empty($rig)) {
        foreach ($rig as $row) {

            ?>
            <input type="hidden" class="id_rig_input" value="<?= $row['id'] ?>">
            <?php
        }
    }

    ?>
    <script  type="text/javascript" src="<?= $baseUrl ?>/assets/js/is_update_rig_now.js"></script>
    <?php
}

?>





<?php
include 'modals/modal_create_copy.php';

?>
<script  type="text/javascript" src="<?= $baseUrl ?>/assets/js/rigtable.js"></script>



<script>
                            $(document).ready(function () {
                                if ($('#filter-block').hasClass('not-available')) {
                                    $(".not-available-select").prop('disabled', true).trigger('chosen:updated');
                                    $(".not-available-select").val('').trigger('chosen:updated');
                                }

                            });





                            $(document).ready(function () {


                                $("tfoot").css("display", "table-header-group");//tfoot of table




                                /*  rigTable  */
                                var rig_table_vis = $('#rigTable').DataTable({
                                    "pageLength": <?= $pageLength ?>,
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

                                $('a.toggle-vis-rig-table').on('click', function (e) {
                                    e.preventDefault();

                                    // Get the column API object
                                    var column = rig_table_vis.column($(this).attr('data-column'));

                                    // Toggle the visibility
                                    column.visible(!column.visible());


                                });



                                /*---------- таблица с выездами ------------*/
                                $('#rigTable tfoot th').each(function (i) {
                                    var table = $('#rigTable').DataTable();
                                    if (i !== 1 && i != 8 && i != 14) {

                                        if (i == 9) {
                                            //выпадающий список
                                            var y = 'rigForm';
                                            var select = $('<select class="' + i + '  noprint" id="sel' + y + i + '"><option value=""></option></select>')
                                                    .appendTo($(this).empty())
                                                    .on('change', function () {

                                                        var val = $(this).val();

                                                        table.column(i) //Only the first column
                                                                .search(val ? '^' + $(this).val() + '$' : val, true, false)
                                                                .draw();
                                                    });

                                            var x = $('#rigTable tfoot th').index($(this));
                                            table.column(i).data().unique().sort().each(function (d, j) {
                                                select.append('<option value="' + d + '" >' + d + '</option>');
                                            });


                                        } else {
                                            var title = $('#rigTable tfoot th').eq($(this).index()).text();
                                            var x = $('#rigTable tfoot th').index($(this));
                                            var y = 'rigForm';
                                            //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                                            $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
                                            // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
                                        }

                                    }
                                });
                                $("#rigTable tfoot input").on('keyup change', function () {
                                    var table = $('#rigTable').DataTable();
                                    table
                                            .column($(this).parent().index() + ':visible')
                                            .search(this.value)
                                            .draw();
                                });

                                /*---------- END таблица с выездами ------------*/


                            });
</script>