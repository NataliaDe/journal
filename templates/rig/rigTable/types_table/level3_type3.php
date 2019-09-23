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
    .br-head{
       color:  #06610d !important;
    }

</style>

<div class="noprint" id="conttabl">
    <b> Выберите столбец, чтобы скрыть/отобразить:  </b>
    <b>

        <a class="toggle-vis-rig-table-type3" id="toggle-vis-rig-table-type3-0"  data-column="0" style="background-color: #fdee8d;  color: black">ID</a>&nbsp&nbsp
        <a class="toggle-vis-rig-table-type3" id="toggle-vis-rig-table-type3-5"  data-column="5" style="background-color: #fdee8d;  color: black">Привлекаемая техника</a>&nbsp&nbsp
        <a class="toggle-vis-rig-table-type3" id="toggle-vis-rig-table-type3-13"  data-column="13" style="background-color: #fdee8d;  color: black">Автор создания</a>

    </b>

</div>

<!--таблица выездов для уровня 3 и для уровня 2 (УМЧС) -->
<br>
<?php

include dirname(dirname(__FILE__))  . '/header_rig_table.php';
//print_r($rig);

?>
<table class="table table-condensed   table-bordered table-custom " id="rigTableType3" style="width: 50%;" >
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
            <th style="width:120px;" >Привлекаемые подразделения</th>
            <th style="width:224px !important;">Привлекаемая<br>техника</th>

            <th style="width:45px;" class="br-head">Погибло<br>в т.ч. детей</th>
            <th style="width:45px;" class="br-head">Спасено</th>

            <th style="width:40px;" class="br-head">Эвак.</th>
            <th style="width:40px;" class="br-head">Травм.</th>


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
             <th></th>
<!--            <th></th>-->
            <th></th>
<!--            <th>Этажность/этаж</th>-->
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
                        <a href="<?= $baseUrl ?>/card_rig/0/<?= $row['id'] ?>" style="color:black" target="_blank" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку вызова">       <?= $row['id'] ?></a>

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
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Погибло">
                             <?= (isset($row['dead_man']) && $row['dead_man'] != 0) ? $row['dead_man'] : '' ?>
                         </span>

                                 <?php
                                 if ((isset($row['dead_child']) && $row['dead_child'] != 0)) {

                                     ?>
                         <br>
                                     <span aria-hidden="true" data-toggle="tooltip" data-placement="top" title="в т.ч. детей">
                                         <?= $row['dead_child']  ?>
                                     </span>
                                     <?php
                                 }

                                 ?>

                    </td>





                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Спасено">
                             <?= (isset($row['save_man']) && $row['save_man'] != 0) ? $row['save_man'] : '' ?>
                        </span>

                    </td>

                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Эвакуировано">
                             <?= (isset($row['ev_man']) && $row['ev_man'] != 0) ? $row['ev_man'] : '' ?>
                        </span></td>
                    <td class="<?= (isset($row['is_neighbor']) && $row['is_neighbor'] == 1) ? 'is-neighbor-td' : '' ?>" >
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Травмировано">
                             <?= (isset($row['inj_man']) && $row['inj_man'] != 0) ? $row['inj_man'] : '' ?>
                        </span></td>





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
/* id of rigs, where silymschs/innerservice are not selected */
                                                        if($row['id_reasonrig'] == 18) {//zanytia

                                    ?>
                                    <a href="<?= $baseUrl ?>/rig/<?= $row['id'] ?>/info" target="_blank">
                                        <i class="fa fa-lg fa-info-circle" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Информирование. Не требует заполнения для указанной причины выезда."></i></a>
                                    <?php
                                }
                                elseif (isset($result_icons['informing']) && in_array($row['id'], $result_icons['informing'])) {

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
                                <i class="fa fa-lg fa-free-code-camp" aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Подача стволов"></i></a>



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






