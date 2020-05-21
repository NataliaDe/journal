<?php
include 'form.php';

//print_r($number_1);
//print_r($archive_2019);

?>

<style>

    table tr td:first-child, td:nth-child(2){
        text-align: left;
    }

    span{
        font-weight: 700;
    }
</style>

<div class="box-body">


    <div class="tab-content ">


        <center>
            <caption><b><?= $caption ?></b></caption><br><br>
            <table class="table table-condensed   table-bordered table-custom" style="width: 50%">
                <thead>
                    <tr>
                        <th style="width: 57px;" >№ показателя</th>
                        <th>Наименование показателя</th>
                        <th>Показатели с начала<br>года</th>

                    </tr>

                </thead>

                <tbody>
                    <tr>
                        <td colspan="3"><center><b>Раздел I. Боевая работа по ликвидации пожаров</b></center></td>
                </tr>

                <!---------------------- table 1 ------------------------->

                <tr>
                    <td><b>1.</b></td>
                    <td><b>Всего ликвидировано пожаров ПАСП МЧС, в том числе не подлежащих учету (сумма строк 1.1.-1.5)</b></td>

                    <?php
                    $all_rigs_fire_part_1 = ((isset($number_1['all_fire']) && !empty($number_1['all_fire'])) ? $number_1['all_fire'] : 0) +
                        ((isset($archive_bw['cnt_fire_city_object']) && !empty($archive_bw['cnt_fire_city_object'])) ? $archive_bw['cnt_fire_city_object'] : 0) +
                        ((isset($archive_bw['cnt_ltt_les']) && !empty($archive_bw['cnt_ltt_les'])) ? $archive_bw['cnt_ltt_les'] : 0) +
                        ((isset($archive_bw['cnt_ltt_torf']) && !empty($archive_bw['cnt_ltt_torf'])) ? $archive_bw['cnt_ltt_torf'] : 0) +
                        ((isset($archive_bw['cnt_ltt_trava']) && !empty($archive_bw['cnt_ltt_trava'])) ? $archive_bw['cnt_ltt_trava'] : 0) +
                        ((isset($archive_bw['cnt_zagor']) && !empty($archive_bw['cnt_zagor'])) ? $archive_bw['cnt_zagor'] : 0);

                    ?>
                    <td><?= $all_rigs_fire_part_1 ?></td>
                </tr>




                <tr>
                    <td></td>
                    <td><b><i>в том числе:</i></b></td>
                    <td></td>
                </tr>




                <tr>
                    <td>1.1.</td>
                    <td>на объектах, сооружениях и транспорте в городах и сельской местности <b>(сумма строк 1.1.1.-1.1.3),</b> из них:</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Пожар», вид работ «на объектах», вид работ «на сооружениях», вид работ «на транспорте» в городах и сельской местности">
                        <?=
                        ((isset($number_1['cnt_fire_city_object']) && !empty($number_1['cnt_fire_city_object'])) ? $number_1['cnt_fire_city_object'] : 0) +
                        ((isset($archive_bw['cnt_fire_city_object']) && !empty($archive_bw['cnt_fire_city_object'])) ? $archive_bw['cnt_fire_city_object'] : 0)

                        ?>
                        </span>
                        </td>

                </tr>
                <tr>
                    <td>1.1.1.</td>
                    <td>в городах областного подчинения (г. Минске)</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Пожар» в городах областного подчинения (г. Минске)">
                        <?=
                        ((isset($number_1['cnt_fire_city_obl']) && !empty($number_1['cnt_fire_city_obl'])) ? $number_1['cnt_fire_city_obl'] : 0) +
                        ((isset($archive_bw['cnt_fire_city_obl']) && !empty($archive_bw['cnt_fire_city_obl'])) ? $archive_bw['cnt_fire_city_obl'] : 0)

                        ?>
                            <span>
                        </td>

                </tr>
                <tr>
                    <td>1.1.2.</td>
                    <td>в городах районного подчинения (поселки городского типа) </td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Пожар» в городах районного подчинения (поселки городского типа)">
                        <?=
                        ((isset($number_1['cnt_fire_city_loc']) && !empty($number_1['cnt_fire_city_loc'])) ? $number_1['cnt_fire_city_loc'] : 0) +
                        ((isset($archive_bw['cnt_fire_city_loc']) && !empty($archive_bw['cnt_fire_city_loc'])) ? $archive_bw['cnt_fire_city_loc'] : 0)

                        ?>
                        </span>
                        </td>

                </tr>
                <tr>
                    <td>1.1.3.</td>
                    <td>в сельских населенных пунктах (агрогородках, поселках, деревнях и т.д.)</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Пожар». Разность: 1.1-1.1.1-1.1.2 ">
                        <?=
                        ((isset($number_1['cnt_fire_village']) && !empty($number_1['cnt_fire_village'])) ? $number_1['cnt_fire_village'] : 0) +
                        ((isset($archive_bw['cnt_fire_village']) && !empty($archive_bw['cnt_fire_village'])) ? $archive_bw['cnt_fire_village'] : 0)

                        ?>
                         </span>
                         </td>

                </tr>

                <tr>
                    <td>1.2.</td>
                    <td>в лесах</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЛТТ», вид работ «лес»">
                        <?=
                        ((isset($number_1['cnt_ltt_les']) && !empty($number_1['cnt_ltt_les'])) ? $number_1['cnt_ltt_les'] : 0) +
                        ((isset($archive_bw['cnt_ltt_les']) && !empty($archive_bw['cnt_ltt_les'])) ? $archive_bw['cnt_ltt_les'] : 0)

                        ?>
                         </span>
                         </td>

                </tr>
                <tr>
                    <td>1.3.</td>
                    <td>на торфяниках</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЛТТ», вид работ «торф»">
                        <?=
                        ((isset($number_1['cnt_ltt_torf']) && !empty($number_1['cnt_ltt_torf'])) ? $number_1['cnt_ltt_torf'] : 0) +
                        ((isset($archive_bw['cnt_ltt_torf']) && !empty($archive_bw['cnt_ltt_torf'])) ? $archive_bw['cnt_ltt_torf'] : 0)

                        ?>
                        </span>
                        </td>

                </tr>
                <tr>
                    <td>1.4.</td>
                    <td>горение сухой растительности, кустарника и т.п.</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЛТТ», вид работ «трава», вид работ «кустарник»">
                        <?=
                        ((isset($number_1['cnt_ltt_trava']) && !empty($number_1['cnt_ltt_trava'])) ? $number_1['cnt_ltt_trava'] : 0) +
                        ((isset($archive_bw['cnt_ltt_trava']) && !empty($archive_bw['cnt_ltt_trava'])) ? $archive_bw['cnt_ltt_trava'] : 0)

                        ?>
                         </span>
                         </td>

                </tr>
                <tr>
                    <td>1.5.</td>
                    <td>загорание мусора, пищи и т.п. </td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Другие загорания»">
                        <?=
                        ((isset($number_1['cnt_zagor']) && !empty($number_1['cnt_zagor'])) ? $number_1['cnt_zagor'] : 0) +
                        ((isset($archive_bw['cnt_zagor']) && !empty($archive_bw['cnt_zagor'])) ? $archive_bw['cnt_zagor'] : 0)

                        ?>
                        </span>
                        </td>

                </tr>




                <!--------------------------  table2 ---------------------->
                <tr>
                    <td><b>2.</b></td>
                    <td><b>Пожары ликвидированы (по пожарам на объектах, сооружениях и транспорте в городах и сельской местности)</b></td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма уникальных выездов: 2.1 + 2.2 + 2.3 + 2.4 + 2.5 + 2.6 + 2.7">
                        <?=
                        ((isset($number_2['cnt_fire_sum_2']) && !empty($number_2['cnt_fire_sum_2'])) ? $number_2['cnt_fire_sum_2'] : 0) +
                        ((isset($archive_bw['cnt_fire_sum_2']) && !empty($archive_bw['cnt_fire_sum_2'])) ? $archive_bw['cnt_fire_sum_2'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>2.1.</td>
                    <td>населением, работающими до прибытия подразделений МЧС</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где стоит соответствующая отметка">
                        <?=
                        ((isset($number_2['cnt_fire_people_help']) && !empty($number_2['cnt_fire_people_help'])) ? $number_2['cnt_fire_people_help'] : 0) +
                        ((isset($archive_bw['cnt_fire_people_help']) && !empty($archive_bw['cnt_fire_people_help'])) ? $archive_bw['cnt_fire_people_help'] : 0)

                        ?>
                         </span>
                         </td>
                </tr>

                <tr>
                    <td>2.2.</td>
                    <td>ведомственными и добровольными пожарными формированиями до прибытия подразделений МЧС (в том числе с использованием пожарной техники)</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где стоит соответствующая отметка">
                        <?=
                        ((isset($number_2['cnt_fire_gos_help']) && !empty($number_2['cnt_fire_gos_help'])) ? $number_2['cnt_fire_gos_help'] : 0) +
                        ((isset($archive_bw['cnt_fire_gos_help']) && !empty($archive_bw['cnt_fire_gos_help'])) ? $archive_bw['cnt_fire_gos_help'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>


                <tr>
                    <td>2.3.</td>
                    <td>силами одного отделения</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где стоит соответствующая отметка">
                        <?=
                        ((isset($number_2['cnt_fire_alone_otd']) && !empty($number_2['cnt_fire_alone_otd'])) ? $number_2['cnt_fire_alone_otd'] : 0) +
                        ((isset($archive_bw['cnt_fire_alone_otd']) && !empty($archive_bw['cnt_fire_alone_otd'])) ? $archive_bw['cnt_fire_alone_otd'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>2.4.</td>
                    <td>силами одной смены</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где стоит соответствующая отметка">
                        <?=
                        ((isset($number_2['cnt_fire_alone_shift']) && !empty($number_2['cnt_fire_alone_shift'])) ? $number_2['cnt_fire_alone_shift'] : 0) +
                        ((isset($archive_bw['cnt_fire_alone_shift']) && !empty($archive_bw['cnt_fire_alone_shift'])) ? $archive_bw['cnt_fire_alone_shift'] : 0)

                        ?>
                         </span>
                         </td>
                </tr>

                <tr>
                    <td>2.5.</td>
                    <td>с привлечением дополнительных сил МЧС</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где стоит соответствующая отметка">
                        <?=
                        ((isset($number_2['cnt_fire_dop_mes']) && !empty($number_2['cnt_fire_dop_mes'])) ? $number_2['cnt_fire_dop_mes'] : 0) +
                        ((isset($archive_bw['cnt_fire_dop_mes']) && !empty($archive_bw['cnt_fire_dop_mes'])) ? $archive_bw['cnt_fire_dop_mes'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>2.6.</td>
                    <td>без установки пожарных аварийно-спасательных автомобилей на водоисточник (водоем, ПГ и т.п.)</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где стоит соответствующая отметка">
                        <?=
                        ((isset($number_2['cnt_fire_no_water']) && !empty($number_2['cnt_fire_no_water'])) ? $number_2['cnt_fire_no_water'] : 0) +
                        ((isset($archive_bw['cnt_fire_no_water']) && !empty($archive_bw['cnt_fire_no_water'])) ? $archive_bw['cnt_fire_no_water'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>2.7.</td>
                    <td>с установкой пожарных аварийно-спасательных автомобилей на водоисточник (водоем, ПГ и т.п.)</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где стоит соответствующая отметка">
                        <?=
                        ((isset($number_2['cnt_fire_water']) && !empty($number_2['cnt_fire_water'])) ? $number_2['cnt_fire_water'] : 0) +
                        ((isset($archive_bw['cnt_fire_water']) && !empty($archive_bw['cnt_fire_water'])) ? $archive_bw['cnt_fire_water'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td><b>3.</b></td>
                    <td><b>При тушении использовались:</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td>3.1.</td>
                    <td>один водяной ствол</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где использовался один водяной ствол">
                        <?=
                        ((isset($number_3['cnt_fire_w_1']) && !empty($number_3['cnt_fire_w_1'])) ? $number_3['cnt_fire_w_1'] : 0) +
                        ((isset($archive_bw['cnt_fire_w_1']) && !empty($archive_bw['cnt_fire_w_1'])) ? $archive_bw['cnt_fire_w_1'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>3.2.</td>
                    <td>два водяных ствола</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где использовалось два водяных ствола">
                        <?=
                        ((isset($number_3['cnt_fire_w_2']) && !empty($number_3['cnt_fire_w_2'])) ? $number_3['cnt_fire_w_2'] : 0) +
                        ((isset($archive_bw['cnt_fire_w_2']) && !empty($archive_bw['cnt_fire_w_2'])) ? $archive_bw['cnt_fire_w_2'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>3.3.</td>
                    <td>три - четыре водяных ствола</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где использовалось три - четыре водяных ствола">
                        <?=
                        ((isset($number_3['cnt_fire_w_3']) && !empty($number_3['cnt_fire_w_3'])) ? $number_3['cnt_fire_w_3'] : 0) +
                        ((isset($archive_bw['cnt_fire_w_3']) && !empty($archive_bw['cnt_fire_w_3'])) ? $archive_bw['cnt_fire_w_3'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>3.4.</td>
                    <td>пять и более водяных стволов</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где использовалось пять и более водяных стволов">
                        <?=
                        ((isset($number_3['cnt_fire_w_5']) && !empty($number_3['cnt_fire_w_5'])) ? $number_3['cnt_fire_w_5'] : 0) +
                        ((isset($archive_bw['cnt_fire_w_5']) && !empty($archive_bw['cnt_fire_w_5'])) ? $archive_bw['cnt_fire_w_5'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>3.5.</td>
                    <td>стволы высокого давления</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где применялись стволы высокого давления">
                        <?=
                        ((isset($number_3['cnt_fire_svd']) && !empty($number_3['cnt_fire_svd'])) ? $number_3['cnt_fire_svd'] : 0) +
                        ((isset($archive_bw['cnt_fire_svd']) && !empty($archive_bw['cnt_fire_svd'])) ? $archive_bw['cnt_fire_svd'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>3.6.</td>
                    <td>один ГПС (СВП)</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где использовался один ствол ГПС-600 или один ствол СВП">
                        <?=
                        ((isset($number_3['cnt_fire_gps_1']) && !empty($number_3['cnt_fire_gps_1'])) ? $number_3['cnt_fire_gps_1'] : 0) +
                        ((isset($archive_bw['cnt_fire_gps_1']) && !empty($archive_bw['cnt_fire_gps_1'])) ? $archive_bw['cnt_fire_gps_1'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>3.6.1.</td>
                    <td>израсходовано пенообразователя, тонн</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма тонн израсходованного пенообразователя, если использовался один ствол ГПС-600 или один ствол СВП на пожарах">
                        <?=
                        ((isset($number_3['cnt_fire_gps_1_po_out']) && !empty($number_3['cnt_fire_gps_1_po_out'])) ? $number_3['cnt_fire_gps_1_po_out'] : 0) +
                        ((isset($archive_bw['cnt_fire_gps_1_po_out']) && !empty($archive_bw['cnt_fire_gps_1_po_out'])) ? $archive_bw['cnt_fire_gps_1_po_out'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>3.7.</td>
                    <td>два и более ГПС (СВП)</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где использовалось два и более ГПС-600 или два и более СВП">
                        <?=
                        ((isset($number_3['cnt_fire_gps_2']) && !empty($number_3['cnt_fire_gps_2'])) ? $number_3['cnt_fire_gps_2'] : 0) +
                        ((isset($archive_bw['cnt_fire_gps_2']) && !empty($archive_bw['cnt_fire_gps_2'])) ? $archive_bw['cnt_fire_gps_2'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>
                <tr>
                    <td>3.7.1.</td>
                    <td>израсходовано пенообразователя, тонн</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма тонн израсходованного пенообразователя, если использовался два и более ГПС-600 или два и более СВП на пожарах">
                        <?=
                        ((isset($number_3['cnt_fire_gps_2_po_out']) && !empty($number_3['cnt_fire_gps_2_po_out'])) ? $number_3['cnt_fire_gps_2_po_out'] : 0) +
                        ((isset($archive_bw['cnt_fire_gps_2_po_out']) && !empty($archive_bw['cnt_fire_gps_2_po_out'])) ? $archive_bw['cnt_fire_gps_2_po_out'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

<!--                <tr>
                    <td></td>
                    <td>израсходовано пенообразователя, тонн</td>
                    <td>
                        <
                        ((isset($number_3['cnt_fire_po_out']) && !empty($number_3['cnt_fire_po_out'])) ? $number_3['cnt_fire_po_out'] : 0) +
                        ((isset($archive_bw['cnt_fire_po_out']) && !empty($archive_bw['cnt_fire_po_out'])) ? $archive_bw['cnt_fire_po_out'] : 0)

                        ?>
                    </td>
                </tr>-->

                <tr>
                    <td>3.8.</td>
                    <td>переносные порошковые огнетушители</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во переносных порошковых огнетушителей на пожарах">
                        <?=
                        ((isset($number_2['cnt_fire_powder_mob']) && !empty($number_2['cnt_fire_powder_mob'])) ? $number_2['cnt_fire_powder_mob'] : 0) +
                        ((isset($archive_bw['cnt_fire_powder_mob']) && !empty($archive_bw['cnt_fire_powder_mob'])) ? $archive_bw['cnt_fire_powder_mob'] : 0)

                        ?>
                         </span>
                         </td>
                </tr>

                <tr>
                    <td>3.8.1.</td>
                    <td>израсходовано порошка, тонн</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма тонн израсходованного порошка на пожарах">
                        <?=
                        ((isset($number_2['cnt_fire_powder_out']) && !empty($number_2['cnt_fire_powder_out'])) ? $number_2['cnt_fire_powder_out'] : 0) +
                        ((isset($archive_bw['cnt_fire_powder_out']) && !empty($archive_bw['cnt_fire_powder_out'])) ? $archive_bw['cnt_fire_powder_out'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>


                <?php
                $sum_3_9 = 0;

                if (isset($number_2['sum_tool']) && !empty($number_2['sum_tool']))
                    $sum_3_9 += $number_2['sum_tool'];


                if (isset($archive_bw['cnt_fire_tool_meh']) && !empty($archive_bw['cnt_fire_tool_meh']))
                    $sum_3_9 += $archive_bw['cnt_fire_tool_meh'];
                if (isset($archive_bw['cnt_fire_tool_pnev']) && !empty($archive_bw['cnt_fire_tool_pnev']))
                    $sum_3_9 += $archive_bw['cnt_fire_tool_pnev'];
                if (isset($archive_bw['cnt_fire_tool_gidr']) && !empty($archive_bw['cnt_fire_tool_gidr']))
                    $sum_3_9 += $archive_bw['cnt_fire_tool_gidr'];

                ?>


                <tr>
                    <td>3.9.</td>
                    <td>аварийно-спасательный и механизированный инструмент (сумма строк 3.9.1.-3.9.3), из них:</td>
                    <td>
                <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма строк: 3.9.1.- 3.9.3 ">
                <?= $sum_3_9 ?>
                </span>
                </td>
                </tr>

                <tr>
                    <td>3.9.1.</td>
                    <td>механизированный (бензоинструмент, электроинструмент и т.п.)</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во механизированного инструмента на пожарах ">
                    <?=
                        ((isset($number_2['cnt_fire_tool_meh']) && !empty($number_2['cnt_fire_tool_meh'])) ? $number_2['cnt_fire_tool_meh'] : 0) +
                        ((isset($archive_bw['cnt_fire_tool_meh']) && !empty($archive_bw['cnt_fire_tool_meh'])) ? $archive_bw['cnt_fire_tool_meh'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>3.9.2.</td>
                    <td>пневматический аварийно-спасательный инструмент (домкраты, пневмоподушки и т.п.)</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пневматического аварийно-спасательного инструмента на пожарах ">
                    <?=
                        ((isset($number_2['cnt_fire_tool_pnev']) && !empty($number_2['cnt_fire_tool_pnev'])) ? $number_2['cnt_fire_tool_pnev'] : 0) +
                        ((isset($archive_bw['cnt_fire_tool_pnev']) && !empty($archive_bw['cnt_fire_tool_pnev'])) ? $archive_bw['cnt_fire_tool_pnev'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>3.9.3.</td>
                    <td>гидравлический аварийно-спасательный инструмент (ножницы, кусачки, разжим и т.п.)</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во гидравлического аварийно-спасательного инструмента на пожарах ">
                    <?=
                        ((isset($number_2['cnt_fire_tool_gidr']) && !empty($number_2['cnt_fire_tool_gidr'])) ? $number_2['cnt_fire_tool_gidr'] : 0) +
                        ((isset($archive_bw['cnt_fire_tool_gidr']) && !empty($archive_bw['cnt_fire_tool_gidr'])) ? $archive_bw['cnt_fire_tool_gidr'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>3.10.</td>
                    <td>автомобили быстрого реагирования</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во единиц техники на пожарах">
                    <?=
                        ((isset($number_3_cars['cnt_fire_abr']) && !empty($number_3_cars['cnt_fire_abr'])) ? $number_3_cars['cnt_fire_abr'] : 0) +
                        ((isset($archive_bw['cnt_fire_abr']) && !empty($archive_bw['cnt_fire_abr'])) ? $archive_bw['cnt_fire_abr'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>3.11.</td>
                    <td>пожарные автоцистерны</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во единиц техники на пожарах">
                    <?=
                        ((isset($number_3_cars['cnt_fire_ac']) && !empty($number_3_cars['cnt_fire_ac'])) ? $number_3_cars['cnt_fire_ac'] : 0) +
                        ((isset($archive_bw['cnt_fire_ac']) && !empty($archive_bw['cnt_fire_ac'])) ? $archive_bw['cnt_fire_ac'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>3.12.</td>
                    <td>автолестницы и коленчатые подъемники</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во единиц техники на пожарах">
                    <?=
                        ((isset($number_3_cars['cnt_fire_al']) && !empty($number_3_cars['cnt_fire_al'])) ? $number_3_cars['cnt_fire_al'] : 0) +
                        ((isset($archive_bw['cnt_fire_al']) && !empty($archive_bw['cnt_fire_al'])) ? $archive_bw['cnt_fire_al'] : 0) +
                        ((isset($number_3_cars['cnt_fire_akp']) && !empty($number_3_cars['cnt_fire_akp'])) ? $number_3_cars['cnt_fire_akp'] : 0) +
                        ((isset($archive_bw['cnt_fire_akp']) && !empty($archive_bw['cnt_fire_akp'])) ? $archive_bw['cnt_fire_akp'] : 0)

                        ?>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во единиц техники на пожарах">
                        </td>
                </tr>

                <tr>
                    <td>3.13.</td>
                    <td>автомобили дымоудаления</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_adu']) && !empty($number_3_cars['cnt_fire_adu'])) ? $number_3_cars['cnt_fire_adu'] : 0) +
                        ((isset($archive_bw['cnt_fire_adu']) && !empty($archive_bw['cnt_fire_adu'])) ? $archive_bw['cnt_fire_adu'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.14.</td>
                    <td>пожарные насосные станции</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_pns']) && !empty($number_3_cars['cnt_fire_pns'])) ? $number_3_cars['cnt_fire_pns'] : 0) +
                        ((isset($archive_bw['cnt_fire_pns']) && !empty($archive_bw['cnt_fire_pns'])) ? $archive_bw['cnt_fire_pns'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.15.</td>
                    <td>рукавные автомобили</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_ar']) && !empty($number_3_cars['cnt_fire_ar'])) ? $number_3_cars['cnt_fire_ar'] : 0) +
                        ((isset($archive_bw['cnt_fire_ar']) && !empty($archive_bw['cnt_fire_ar'])) ? $archive_bw['cnt_fire_ar'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.16.</td>
                    <td>автомобили связи и освещения</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_aso']) && !empty($number_3_cars['cnt_fire_aso'])) ? $number_3_cars['cnt_fire_aso'] : 0) +
                        ((isset($archive_bw['cnt_fire_aso']) && !empty($archive_bw['cnt_fire_aso'])) ? $archive_bw['cnt_fire_aso'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.17.</td>
                    <td>автомобили ГДЗС</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_agdzs']) && !empty($number_3_cars['cnt_fire_agdzs'])) ? $number_3_cars['cnt_fire_agdzs'] : 0) +
                        ((isset($archive_bw['cnt_fire_agdzs']) && !empty($archive_bw['cnt_fire_agdzs'])) ? $archive_bw['cnt_fire_agdzs'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.18.</td>
                    <td>автомобили пенного тушения</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_avpt']) && !empty($number_3_cars['cnt_fire_avpt'])) ? $number_3_cars['cnt_fire_avpt'] : 0) +
                        ((isset($archive_bw['cnt_fire_avpt']) && !empty($archive_bw['cnt_fire_avpt'])) ? $archive_bw['cnt_fire_avpt'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.19.</td>
                    <td>автомобили порошкового, комбинированного тушения</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_ap']) && !empty($number_3_cars['cnt_fire_ap'])) ? $number_3_cars['cnt_fire_ap'] : 0) +
                        ((isset($archive_bw['cnt_fire_ap']) && !empty($archive_bw['cnt_fire_ap'])) ? $archive_bw['cnt_fire_ap'] : 0) +
                        ((isset($number_3_cars['cnt_fire_akt']) && !empty($number_3_cars['cnt_fire_akt'])) ? $number_3_cars['cnt_fire_akt'] : 0) +
                        ((isset($archive_bw['cnt_fire_akt']) && !empty($archive_bw['cnt_fire_akt'])) ? $archive_bw['cnt_fire_akt'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.20.</td>
                    <td>автомобили газоводяного тушения</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_agvt']) && !empty($number_3_cars['cnt_fire_agvt'])) ? $number_3_cars['cnt_fire_agvt'] : 0) +
                        ((isset($archive_bw['cnt_fire_agvt']) && !empty($archive_bw['cnt_fire_agvt'])) ? $archive_bw['cnt_fire_agvt'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.21.</td>
                    <td>штабные автомобили</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_ash']) && !empty($number_3_cars['cnt_fire_ash'])) ? $number_3_cars['cnt_fire_ash'] : 0) +
                        ((isset($archive_bw['cnt_fire_ash']) && !empty($archive_bw['cnt_fire_ash'])) ? $archive_bw['cnt_fire_ash'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.22.</td>
                    <td>воздухозаправщики (воздухохранилища)</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_vz']) && !empty($number_3_cars['cnt_fire_vz'])) ? $number_3_cars['cnt_fire_vz'] : 0) +
                        ((isset($archive_bw['cnt_fire_vz']) && !empty($archive_bw['cnt_fire_vz'])) ? $archive_bw['cnt_fire_vz'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.23.</td>
                    <td>аварийно-спасательные автомобили</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_asa']) && !empty($number_3_cars['cnt_fire_asa'])) ? $number_3_cars['cnt_fire_asa'] : 0) +
                        ((isset($archive_bw['cnt_fire_asa']) && !empty($archive_bw['cnt_fire_asa'])) ? $archive_bw['cnt_fire_asa'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.24.</td>
                    <td>автомобиль медицинской службы</td>
                    <td><?=
                        ((isset($number_3_cars['cnt_fire_ams']) && !empty($number_3_cars['cnt_fire_ams'])) ? $number_3_cars['cnt_fire_ams'] : 0) +
                        ((isset($archive_bw['cnt_fire_ams']) && !empty($archive_bw['cnt_fire_ams'])) ? $archive_bw['cnt_fire_ams'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.25.</td>
                    <td>авиационная техника</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во привлеченной авиационной техники на пожарах">
                    <?=
                        ((isset($number_2['cnt_fire_avia_help']) && !empty($number_2['cnt_fire_avia_help'])) ? $number_2['cnt_fire_avia_help'] : 0) +
                        ((isset($archive_bw['cnt_fire_avia_help']) && !empty($archive_bw['cnt_fire_avia_help'])) ? $archive_bw['cnt_fire_avia_help'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>3.26.</td>
                    <td>другая техника МЧС</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где стоит соответствующая отметка">
                    <?=
                        ((isset($number_2['cnt_fire_other_mes']) && !empty($number_2['cnt_fire_other_mes'])) ? $number_2['cnt_fire_other_mes'] : 0) +
                        ((isset($archive_bw['cnt_fire_other_mes']) && !empty($archive_bw['cnt_fire_other_mes'])) ? $archive_bw['cnt_fire_other_mes'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>3.27.</td>
                    <td>одно звено ГДЗС</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где стоит соответствующая отметка">
                    <?=
                        ((isset($number_2['cnt_fire_one_gdzs']) && !empty($number_2['cnt_fire_one_gdzs'])) ? $number_2['cnt_fire_one_gdzs'] : 0) +
                        ((isset($archive_bw['cnt_fire_one_gdzs']) && !empty($archive_bw['cnt_fire_one_gdzs'])) ? $archive_bw['cnt_fire_one_gdzs'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>3.28.</td>
                    <td>два и более звеньев ГДЗС</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во пожаров, где стоит соответствующая отметка">
                    <?=
                        ((isset($number_2['cnt_fire_many_gdzs']) && !empty($number_2['cnt_fire_many_gdzs'])) ? $number_2['cnt_fire_many_gdzs'] : 0) +
                        ((isset($archive_bw['cnt_fire_many_gdzs']) && !empty($archive_bw['cnt_fire_many_gdzs'])) ? $archive_bw['cnt_fire_many_gdzs'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td><b>4.</b></td>
                    <td><b>Результаты боевой работы на пожарах:</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td>4.1.</td>
                    <td>спасено людей:</td>
                    <?php
                    $save_people_on_fire = ((isset($number_4['cnt_fire_save_man']) && !empty($number_4['cnt_fire_save_man'])) ? $number_4['cnt_fire_save_man'] : 0) +
                        ((isset($archive_bw['cnt_fire_save_man']) && !empty($archive_bw['cnt_fire_save_man'])) ? $archive_bw['cnt_fire_save_man'] : 0);

                    ?>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма спасенных людей на пожарах">
                    <?= $save_people_on_fire ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>4.1.1.</td>
                    <td>в том числе с применением дополнительных масок</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма спасенных людей (с применением масок) на пожарах">
                        <?=
                        ((isset($number_2['cnt_fire_save_p_mask']) && !empty($number_2['cnt_fire_save_p_mask'])) ? $number_2['cnt_fire_save_p_mask'] : 0) +
                        ((isset($archive_bw['cnt_fire_save_p_mask']) && !empty($archive_bw['cnt_fire_save_p_mask'])) ? $archive_bw['cnt_fire_save_p_mask'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>4.1.2.</td>
                    <td>в том числе детей</td>
                    <?php
                    $save_child_on_fire = ((isset($number_4['cnt_fire_save_child']) && !empty($number_4['cnt_fire_save_child'])) ? $number_4['cnt_fire_save_child'] : 0) +
                        ((isset($archive_bw['cnt_fire_save_child']) && !empty($archive_bw['cnt_fire_save_child'])) ? $archive_bw['cnt_fire_save_child'] : 0);

                    ?>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма спасенных детей на пожарах">
                    <?= $save_child_on_fire ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>4.2.</td>
                    <td>эвакуировано людей:</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма эвакуированных людей на пожарах">
                        <?=
                        ((isset($number_4['cnt_fire_ev_man']) && !empty($number_4['cnt_fire_ev_man'])) ? $number_4['cnt_fire_ev_man'] : 0) +
                        ((isset($archive_bw['cnt_fire_ev_man']) && !empty($archive_bw['cnt_fire_ev_man'])) ? $archive_bw['cnt_fire_ev_man'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>4.2.1.</td>
                    <td>в том числе детей</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма эвакуированных  детей на пожарах">
                        <?=
                        ((isset($number_4['cnt_fire_ev_child']) && !empty($number_4['cnt_fire_ev_child'])) ? $number_4['cnt_fire_ev_child'] : 0) +
                        ((isset($archive_bw['cnt_fire_ev_child']) && !empty($archive_bw['cnt_fire_ev_child'])) ? $archive_bw['cnt_fire_ev_child'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>4.3.</td>
                    <td>спасено голов скота</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма спасенных голов скота на пожарах">
                        <?=
                        ((isset($number_4['cnt_fire_save_an']) && !empty($number_4['cnt_fire_save_an'])) ? $number_4['cnt_fire_save_an'] : 0) +
                        ((isset($archive_bw['cnt_fire_save_an']) && !empty($archive_bw['cnt_fire_save_an'])) ? $archive_bw['cnt_fire_save_an'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>4.4.</td>
                    <td>предотвращено уничтожение кормов и технических культур (тонн)</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма тонн на пожарах">
                        <?=
                        ((isset($number_2['cnt_fire_pred_food']) && !empty($number_2['cnt_fire_pred_food'])) ? $number_2['cnt_fire_pred_food'] : 0) +
                        ((isset($archive_bw['cnt_fire_pred_food']) && !empty($archive_bw['cnt_fire_pred_food'])) ? $archive_bw['cnt_fire_pred_food'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>4.5.</td>
                    <td>предотвращено уничтожение огнем строений</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма строений на пожарах">
                        <?=
                        ((isset($number_2['cnt_fire_pred_build']) && !empty($number_2['cnt_fire_pred_build'])) ? $number_2['cnt_fire_pred_build'] : 0) +
                        ((isset($archive_bw['cnt_fire_pred_build']) && !empty($archive_bw['cnt_fire_pred_build'])) ? $archive_bw['cnt_fire_pred_build'] : 0)

                        ?>
                        </span>

                        </td>
                </tr>

                <tr>
                    <td>4.6.</td>
                    <td>предотвращено уничтожение огнем единиц техники</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма единиц техники на пожарах">
                        <?=
                        ((isset($number_2['cnt_fire_pred_vehicle']) && !empty($number_2['cnt_fire_pred_vehicle'])) ? $number_2['cnt_fire_pred_vehicle'] : 0) +
                        ((isset($archive_bw['cnt_fire_pred_vehicle']) && !empty($archive_bw['cnt_fire_pred_vehicle'])) ? $archive_bw['cnt_fire_pred_vehicle'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td colspan="3"><center><b>Раздел II. Боевая работа по ликвидации чрезвычайных ситуациях и последствий от них</b></center></td>
                </tr>



                <!--------------------------  table1 PART 2 ---------------------->
                <tr>
                    <td><b>1.</b></td>
                    <td><b>Количество выездов ПАСП МЧС на ликвидацию чрезвычайных ситуаций и последствий от них (сумма строк 1.1 - 1.2):</b></td>
                    <?php
                    $all_rigs_hs_part_2 = ((isset($chapter2_numb_1['hs_sum']) && !empty($chapter2_numb_1['hs_sum'])) ? $chapter2_numb_1['hs_sum'] : 0) +
                        ((isset($archive_bw['cnt_hs_tehn']) && !empty($archive_bw['cnt_hs_tehn'])) ? $archive_bw['cnt_hs_tehn'] : 0) +
                        ((isset($archive_bw['cnt_hs_nature']) && !empty($archive_bw['cnt_hs_nature'])) ? $archive_bw['cnt_hs_nature'] : 0);

                    ?>
                    <td>

                    <?= $all_rigs_hs_part_2 ?>

                    </td>
                </tr>

                <tr>
                    <td>1.1.</td>
                    <td>количество выездов ПАСП МЧС на ликвидацию ЧС техногенного характера и последствий от них (без учета пожаров)</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЧС», вид работ «техногенного характера»,
                              вид работ «на системах жизнеобеспечения», вид работ «другие ЧС техногенного характера» ">
                        <?=
                        ((isset($chapter2_numb_1['cnt_hs_tehn']) && !empty($chapter2_numb_1['cnt_hs_tehn'])) ? $chapter2_numb_1['cnt_hs_tehn'] : 0) +
                        ((isset($archive_bw['cnt_hs_tehn']) && !empty($archive_bw['cnt_hs_tehn'])) ? $archive_bw['cnt_hs_tehn'] : 0)

                        ?>
                        </span>
                        </td>

                </tr>

                <tr>
                    <td>1.2.</td>
                    <td>количество выездов ПАСП МЧС на ликвидацию ЧС природного характера и последствий от них (без учета пожаров в природных экосистемах)</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЧС»,
                              вид работ «природного характера» ">
                        <?=
                        ((isset($chapter2_numb_1['cnt_hs_nature']) && !empty($chapter2_numb_1['cnt_hs_nature'])) ? $chapter2_numb_1['cnt_hs_nature'] : 0) +
                        ((isset($archive_bw['cnt_hs_nature']) && !empty($archive_bw['cnt_hs_nature'])) ? $archive_bw['cnt_hs_nature'] : 0)

                        ?>
                        </span></td>

                </tr>


                <tr>
                    <td><b>2.</b></td>
                    <td><b>Результаты боевой работы на ЧС:</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td>2.1.</td>
                    <td>спасено людей:</td>
                    <?php
                    $save_people_on_hs = ((isset($chapter2_numb_2['cnt_fire_save_man']) && !empty($chapter2_numb_2['cnt_fire_save_man'])) ? $chapter2_numb_2['cnt_fire_save_man'] : 0) +
                        ((isset($archive_bw['cnt_hs_save_man']) && !empty($archive_bw['cnt_hs_save_man'])) ? $archive_bw['cnt_hs_save_man'] : 0);

                    ?>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="на ЧС">
                    <?= $save_people_on_hs ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>2.1.1.</td>
                    <td>в том числе детей</td>
                    <?php
                    $save_child_on_hs = ((isset($chapter2_numb_2['cnt_fire_save_child']) && !empty($chapter2_numb_2['cnt_fire_save_child'])) ? $chapter2_numb_2['cnt_fire_save_child'] : 0) +
                        ((isset($archive_bw['cnt_hs_save_child']) && !empty($archive_bw['cnt_hs_save_child'])) ? $archive_bw['cnt_hs_save_child'] : 0);

                    ?>
                    <td>
                     <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="на ЧС">
                    <?= $save_child_on_hs ?>
                     </span>
                     </td>
                </tr>

                <tr>
                    <td>2.2.</td>
                    <td>эвакуировано людей </td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="на ЧС">
                        <?=
                        ((isset($chapter2_numb_2['cnt_fire_ev_man']) && !empty($chapter2_numb_2['cnt_fire_ev_man'])) ? $chapter2_numb_2['cnt_fire_ev_man'] : 0) +
                        ((isset($archive_bw['cnt_hs_ev_man']) && !empty($archive_bw['cnt_hs_ev_man'])) ? $archive_bw['cnt_hs_ev_man'] : 0)

                        ?>
                         </span>
                         </td>
                </tr>

                <tr>
                    <td>2.2.1.</td>
                    <td>в том числе детей</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="на ЧС">
                        <?=
                        ((isset($chapter2_numb_2['cnt_fire_ev_child']) && !empty($chapter2_numb_2['cnt_fire_ev_child'])) ? $chapter2_numb_2['cnt_fire_ev_child'] : 0) +
                        ((isset($archive_bw['cnt_hs_ev_child']) && !empty($archive_bw['cnt_hs_ev_child'])) ? $archive_bw['cnt_hs_ev_child'] : 0)

                        ?>
                         </span>
                         </td>
                </tr>

                <tr>
                    <td>2.3.</td>
                    <td>спасено голов скота</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="на ЧС">
                        <?=
                        ((isset($chapter2_numb_2['cnt_fire_save_an']) && !empty($chapter2_numb_2['cnt_fire_save_an'])) ? $chapter2_numb_2['cnt_fire_save_an'] : 0) +
                        ((isset($archive_bw['cnt_hs_save_an']) && !empty($archive_bw['cnt_hs_save_an'])) ? $archive_bw['cnt_hs_save_an'] : 0)

                        ?>
                         </span>
                         </td>
                </tr>

                <tr>
                    <td>2.4.</td>
                    <td>предотвращено уничтожение строений</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="на ЧС">
                        <?=
                        ((isset($chapter2_numb_2_part['cnt_hs_pred_build_4s']) && !empty($chapter2_numb_2_part['cnt_hs_pred_build_4s'])) ? $chapter2_numb_2_part['cnt_hs_pred_build_4s'] : 0) +
                        ((isset($archive_bw['cnt_hs_pred_build_4s']) && !empty($archive_bw['cnt_hs_pred_build_4s'])) ? $archive_bw['cnt_hs_pred_build_4s'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>2.5.</td>
                    <td>предотвращено уничтожение единиц техники</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="на ЧС">
                        <?=
                        ((isset($chapter2_numb_2_part['cnt_hs_pred_vehicle_4s']) && !empty($chapter2_numb_2_part['cnt_hs_pred_vehicle_4s'])) ? $chapter2_numb_2_part['cnt_hs_pred_vehicle_4s'] : 0) +
                        ((isset($archive_bw['cnt_hs_pred_vehicle_4s']) && !empty($archive_bw['cnt_hs_pred_vehicle_4s'])) ? $archive_bw['cnt_hs_pred_vehicle_4s'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td><b>3.</b></td>
                    <td><b>При ликвидации использовались:</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td>3.1.</td>
                    <td>Автомобили основного назначения, в том числе:</td>
                    <td></td>
                </tr>

                <tr>
                    <td>3.1.1.</td>
                    <td>автомобили быстрого реагирования</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во единиц техники на ЧС">
                        <?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_abr']) && !empty($chapter_2_numb_3_cars['cnt_fire_abr'])) ? $chapter_2_numb_3_cars['cnt_fire_abr'] : 0) +
                        ((isset($archive_bw['cnt_hs_abr']) && !empty($archive_bw['cnt_hs_abr'])) ? $archive_bw['cnt_hs_abr'] : 0)

                        ?>
                        </span>
                        </td>
                </tr>

                <tr>
                    <td>3.1.2.</td>
                    <td>пожарные автоцистерны</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во единиц техники на ЧС">
                        <?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_ac']) && !empty($chapter_2_numb_3_cars['cnt_fire_ac'])) ? $chapter_2_numb_3_cars['cnt_fire_ac'] : 0) +
                        ((isset($archive_bw['cnt_hs_ac']) && !empty($archive_bw['cnt_hs_ac'])) ? $archive_bw['cnt_hs_ac'] : 0)

                        ?>
                         </span>
                         </td>
                </tr>

                <tr>
                    <td>3.2.</td>
                    <td>Автомобили специального назначения, в том числе:</td>
                    <td></td>
                </tr>

                <tr>
                    <td>3.2.1.</td>
                    <td>аварийно-спасательные автомобили</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во единиц техники на ЧС">
                        <?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_asa']) && !empty($chapter_2_numb_3_cars['cnt_fire_asa'])) ? $chapter_2_numb_3_cars['cnt_fire_asa'] : 0) +
                        ((isset($archive_bw['cnt_hs_asa']) && !empty($archive_bw['cnt_hs_asa'])) ? $archive_bw['cnt_hs_asa'] : 0)

                        ?>
                         </span>
                         </td>
                </tr>

                <tr>
                    <td>3.2.2.</td>
                    <td>автомобили службы химической и радиационной защиты (прицепы)</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во единиц техники на ЧС">
                        <?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_p_hrz']) && !empty($chapter_2_numb_3_cars['cnt_fire_p_hrz'])) ? $chapter_2_numb_3_cars['cnt_fire_p_hrz'] : 0) +
                        ((isset($archive_bw['cnt_hs_p_hrz']) && !empty($archive_bw['cnt_hs_p_hrz'])) ? $archive_bw['cnt_hs_p_hrz'] : 0)

                        ?>
                         </span>
                         </td>
                </tr>

                <tr>
                    <td>3.2.3.</td>
                    <td>автомобиль службы водолазно-спасательных работ (прицепы)</td>
                    <td><?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_p_avs']) && !empty($chapter_2_numb_3_cars['cnt_fire_p_avs'])) ? $chapter_2_numb_3_cars['cnt_fire_p_avs'] : 0) +
                        ((isset($archive_bw['cnt_hs_p_avs']) && !empty($archive_bw['cnt_hs_p_avs'])) ? $archive_bw['cnt_hs_p_avs'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.2.4.</td>
                    <td>автомобиль медицинской службы</td>
                    <td><?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_ams']) && !empty($chapter_2_numb_3_cars['cnt_fire_ams'])) ? $chapter_2_numb_3_cars['cnt_fire_ams'] : 0) +
                        ((isset($archive_bw['cnt_hs_ams']) && !empty($archive_bw['cnt_hs_ams'])) ? $archive_bw['cnt_hs_ams'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.2.5.</td>
                    <td>автомобили связи и освещения</td>
                    <td><?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_aso']) && !empty($chapter_2_numb_3_cars['cnt_fire_aso'])) ? $chapter_2_numb_3_cars['cnt_fire_aso'] : 0) +
                        ((isset($archive_bw['cnt_hs_aso']) && !empty($archive_bw['cnt_hs_aso'])) ? $archive_bw['cnt_hs_aso'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.2.6.</td>
                    <td>автолестницы и коленчатые подъемники</td>
                    <td><?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_al']) && !empty($chapter_2_numb_3_cars['cnt_fire_al'])) ? $chapter_2_numb_3_cars['cnt_fire_al'] : 0) +
                        ((isset($archive_bw['cnt_hs_al']) && !empty($archive_bw['cnt_hs_al'])) ? $archive_bw['cnt_hs_al'] : 0) +
                        ((isset($chapter_2_numb_3_cars['cnt_fire_akp']) && !empty($chapter_2_numb_3_cars['cnt_fire_akp'])) ? $chapter_2_numb_3_cars['cnt_fire_akp'] : 0) +
                        ((isset($archive_bw['cnt_hs_akp']) && !empty($archive_bw['cnt_hs_akp'])) ? $archive_bw['cnt_hs_akp'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.2.7.</td>
                    <td>штабные автомобили</td>
                    <td><?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_ash']) && !empty($chapter_2_numb_3_cars['cnt_fire_ash'])) ? $chapter_2_numb_3_cars['cnt_fire_ash'] : 0) +
                        ((isset($archive_bw['cnt_hs_ash']) && !empty($archive_bw['cnt_hs_ash'])) ? $archive_bw['cnt_hs_ash'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.3.</td>
                    <td>Автомобили инженерного назначения, в том числе:</td>
                    <td></td>
                </tr>

                <tr>
                    <td>3.3.1.</td>
                    <td>автомобильные краны</td>
                    <td><?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_kran']) && !empty($chapter_2_numb_3_cars['cnt_fire_kran'])) ? $chapter_2_numb_3_cars['cnt_fire_kran'] : 0) +
                        ((isset($archive_bw['cnt_hs_kran']) && !empty($archive_bw['cnt_hs_kran'])) ? $archive_bw['cnt_hs_kran'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.3.2.</td>
                    <td>передвижные электростанции (электрогенераторы)</td>
                    <td><?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_pes']) && !empty($chapter_2_numb_3_cars['cnt_fire_pes'])) ? $chapter_2_numb_3_cars['cnt_fire_pes'] : 0) +
                        ((isset($archive_bw['cnt_hs_pes']) && !empty($archive_bw['cnt_hs_pes'])) ? $archive_bw['cnt_hs_pes'] : 0)

                        ?></td>
                </tr>


                <tr>
                    <td>3.4.</td>
                    <td>Вспомогательные автомобили МЧС (топливозаправщики, МТО АТ, медпомощь и др.)</td>
                    <td><?=
                        ((isset($chapter_2_numb_3_cars['cnt_fire_toplivo_z']) && !empty($chapter_2_numb_3_cars['cnt_fire_toplivo_z'])) ? $chapter_2_numb_3_cars['cnt_fire_toplivo_z'] : 0) +
                        ((isset($archive_bw['cnt_hs_toplivo_z']) && !empty($archive_bw['cnt_hs_toplivo_z'])) ? $archive_bw['cnt_hs_toplivo_z'] : 0)

                        ?></td>
                </tr>

                <tr>
                    <td>3.5.</td>
                    <td>авиационная техника</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во привлеченной авиационной техники на ЧС">
                        <?=
                        ((isset($chapter2_numb_2_part['cnt_hs_avia_4s']) && !empty($chapter2_numb_2_part['cnt_hs_avia_4s'])) ? $chapter2_numb_2_part['cnt_hs_avia_4s'] : 0) +
                        ((isset($archive_bw['cnt_hs_avia_4s']) && !empty($archive_bw['cnt_hs_avia_4s'])) ? $archive_bw['cnt_hs_avia_4s'] : 0)

                        ?>
                         </span>
                         </td>
                </tr>




                <?php
                $sum2_tool_3_6 = 0;

                if (isset($chapter2_numb_2_part['sum_tool']) && !empty($chapter2_numb_2_part['sum_tool']))
                    $sum2_tool_3_6 += $chapter2_numb_2_part['sum_tool'];


                if (isset($archive_bw['cnt_hs_tool_meh']) && !empty($archive_bw['cnt_hs_tool_meh']))
                    $sum2_tool_3_6 += $archive_bw['cnt_hs_tool_meh'];
                if (isset($archive_bw['cnt_hs_tool_pnev']) && !empty($archive_bw['cnt_hs_tool_pnev']))
                    $sum2_tool_3_6 += $archive_bw['cnt_hs_tool_pnev'];
                if (isset($archive_bw['cnt_hs_tool_gidr']) && !empty($archive_bw['cnt_hs_tool_gidr']))
                    $sum2_tool_3_6 += $archive_bw['cnt_hs_tool_gidr'];

                ?>

                <tr>
                    <td>3.6.</td>
                    <td>аварийно-спасательный и механизированный инструмент, из них:</td>
                    <td>
                <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма строк: 3.6.1 - 3.6.3">
                <?= $sum2_tool_3_6 ?>
                </span>
                </td>
                </tr>

                <tr>
                    <td>3.6.1.</td>
                    <td>механизированный (бензоинструмент, электроинструмент и т.п.)</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="на ЧС">
                    <?=
                        ((isset($chapter2_numb_2_part['cnt_hs_tool_meh']) && !empty($chapter2_numb_2_part['cnt_hs_tool_meh'])) ? $chapter2_numb_2_part['cnt_hs_tool_meh'] : 0) +
                        ((isset($archive_bw['cnt_hs_tool_meh']) && !empty($archive_bw['cnt_hs_tool_meh'])) ? $archive_bw['cnt_hs_tool_meh'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>3.6.2.</td>
                    <td>пневматический аварийно-спасательный инструмент (домкраты, пневмоподушки и т.п.)</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="на ЧС">
                    <?=
                        ((isset($chapter2_numb_2_part['cnt_hs_tool_pnev']) && !empty($chapter2_numb_2_part['cnt_hs_tool_pnev'])) ? $chapter2_numb_2_part['cnt_hs_tool_pnev'] : 0) +
                        ((isset($archive_bw['cnt_hs_tool_pnev']) && !empty($archive_bw['cnt_hs_tool_pnev'])) ? $archive_bw['cnt_hs_tool_pnev'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>

                <tr>
                    <td>3.6.3.</td>
                    <td>гидравлический аварийно-спасательный инструмент (ножницы, кусачки, разжим и т.п.)</td>
                    <td>
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="на ЧС">
                    <?=
                        ((isset($chapter2_numb_2_part['cnt_hs_tool_gidr']) && !empty($chapter2_numb_2_part['cnt_hs_tool_gidr'])) ? $chapter2_numb_2_part['cnt_hs_tool_gidr'] : 0) +
                        ((isset($archive_bw['cnt_hs_tool_gidr']) && !empty($archive_bw['cnt_hs_tool_gidr'])) ? $archive_bw['cnt_hs_tool_gidr'] : 0)

                        ?>
                    </span>
                    </td>
                </tr>



                <!-- ----------------------------   part -------------------- 3-->
                <tr>
                    <td colspan="3"><center><b>Раздел III. Другие выезды</b></center></td>
                </tr>



<!--            <tr>
                <td><b>2.</b></td>
                <td><b>Общее количество выездов:</b></td>
                <td>

                </td>
            </tr>

            <tr>
                <td>2.1.</td>
                <td>на ликвидацию ЧС и их последствий</td>
                <td>
                <?=
                ((isset($part_3_tbl_1['cnt_hs_fire']) && !empty($part_3_tbl_1['cnt_hs_fire'])) ? $part_3_tbl_1['cnt_hs_fire'] : 0) +
                ((isset($archive_bw['cnt_hs_fire']) && !empty($archive_bw['cnt_hs_fire'])) ? $archive_bw['cnt_hs_fire'] : 0)

                ?>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>из них на ликвидацию пожаров</td>
                <td>
                <?=
                ((isset($part_3_tbl_1['cnt_fire']) && !empty($part_3_tbl_1['cnt_fire'])) ? $part_3_tbl_1['cnt_fire'] : 0) +
                ((isset($archive_bw['cnt_fire']) && !empty($archive_bw['cnt_fire'])) ? $archive_bw['cnt_fire'] : 0)

                ?>
                </td>
            </tr>-->

                <?php
                $signal = ((isset($part_3_tbl_1['cnt_signal']) && !empty($part_3_tbl_1['cnt_signal'])) ? $part_3_tbl_1['cnt_signal'] : 0) +
                    ((isset($archive_bw['cnt_signal']) && !empty($archive_bw['cnt_signal'])) ? $archive_bw['cnt_signal'] : 0) +
                    ((isset($part_3_tbl_1['cnt_molnia']) && !empty($part_3_tbl_1['cnt_molnia'])) ? $part_3_tbl_1['cnt_molnia'] : 0) +
                    ((isset($archive_bw['cnt_molnia']) && !empty($archive_bw['cnt_molnia'])) ? $archive_bw['cnt_molnia'] : 0);


                $false = ((isset($part_3_tbl_1['cnt_false']) && !empty($part_3_tbl_1['cnt_false'])) ? $part_3_tbl_1['cnt_false'] : 0) +
                    ((isset($archive_bw['cnt_false']) && !empty($archive_bw['cnt_false'])) ? $archive_bw['cnt_false'] : 0);

                $help = ((isset($part_3_tbl_1['cnt_help']) && !empty($part_3_tbl_1['cnt_help'])) ? $part_3_tbl_1['cnt_help'] : 0) +
                    ((isset($archive_bw['cnt_help']) && !empty($archive_bw['cnt_help'])) ? $archive_bw['cnt_help'] : 0);

                $demerk = ((isset($part_3_tbl_1['cnt_demerk']) && !empty($part_3_tbl_1['cnt_demerk'])) ? $part_3_tbl_1['cnt_demerk'] : 0) +
                    ((isset($archive_bw['cnt_demerk']) && !empty($archive_bw['cnt_demerk'])) ? $archive_bw['cnt_demerk'] : 0);

                $dtp = ((isset($part_3_tbl_2['cnt_rigs_rb_3_dtp']) && !empty($part_3_tbl_2['cnt_rigs_rb_3_dtp'])) ? $part_3_tbl_2['cnt_rigs_rb_3_dtp'] : 0) +
                    ((isset($archive_bw['cnt_rigs_rb_3_dtp']) && !empty($archive_bw['cnt_rigs_rb_3_dtp'])) ? $archive_bw['cnt_rigs_rb_3_dtp'] : 0);

                $akva = ((isset($part_3_tbl_2['cnt_rigs_rb_3_water']) && !empty($part_3_tbl_2['cnt_rigs_rb_3_water'])) ? $part_3_tbl_2['cnt_rigs_rb_3_water'] : 0) +
                    ((isset($archive_bw['cnt_rigs_rb_3_water']) && !empty($archive_bw['cnt_rigs_rb_3_water'])) ? $archive_bw['cnt_rigs_rb_3_water'] : 0);

                $ins_kill_free_charge = ((isset($part_3_tbl_2['cnt_ins_kill_free_charge']) && !empty($part_3_tbl_2['cnt_ins_kill_free_charge'])) ? $part_3_tbl_2['cnt_ins_kill_free_charge'] : 0) +
                    ((isset($archive_bw['cnt_ins_kill_free_charge']) && !empty($archive_bw['cnt_ins_kill_free_charge'])) ? $archive_bw['cnt_ins_kill_free_charge'] : 0);

                $pavodok = ((isset($part_3_tbl_1['cnt_pavodok']) && !empty($part_3_tbl_1['cnt_pavodok'])) ? $part_3_tbl_1['cnt_pavodok'] : 0) +
                    ((isset($archive_bw['cnt_pavodok']) && !empty($archive_bw['cnt_pavodok'])) ? $archive_bw['cnt_pavodok'] : 0);

                $prohie = ((isset($part_3_tbl_1['cnt_sum']) && !empty($part_3_tbl_1['cnt_sum'])) ? $part_3_tbl_1['cnt_sum'] : 0) +
                    ((isset($archive_bw['cnt_control']) && !empty($archive_bw['cnt_control'])) ? $archive_bw['cnt_control'] : 0) +
                    ((isset($archive_bw['cnt_duty']) && !empty($archive_bw['cnt_duty'])) ? $archive_bw['cnt_duty'] : 0) +
                    ((isset($archive_bw['cnt_hoz']) && !empty($archive_bw['cnt_hoz'])) ? $archive_bw['cnt_hoz'] : 0) +
                    ((isset($archive_bw['cnt_zapravka']) && !empty($archive_bw['cnt_zapravka'])) ? $archive_bw['cnt_zapravka'] : 0) +
                    ((isset($archive_bw['cnt_disloc']) && !empty($archive_bw['cnt_disloc'])) ? $archive_bw['cnt_disloc'] : 0) +
                    ((isset($archive_bw['cnt_to']) && !empty($archive_bw['cnt_to'])) ? $archive_bw['cnt_to'] : 0) +
                    ((isset($archive_bw['cnt_neighbor']) && !empty($archive_bw['cnt_neighbor'])) ? $archive_bw['cnt_neighbor'] : 0) +
                    ((isset($archive_bw['cnt_ptv']) && !empty($archive_bw['cnt_ptv'])) ? $archive_bw['cnt_ptv'] : 0) +
                    ((isset($archive_bw['cnt_pay']) && !empty($archive_bw['cnt_pay'])) ? $archive_bw['cnt_pay'] : 0) +
                    ((isset($archive_bw['cnt_other']) && !empty($archive_bw['cnt_other'])) ? $archive_bw['cnt_other'] : 0);

                ?>

                <tr>
                    <td>1.</td>
                    <td>Другие выезды (сумма строк 1.1 - 1.9)</td>

                    <?php
                    $other_rigs_part_3 = $signal +
                        $false + $help + $demerk + $dtp + $akva + $ins_kill_free_charge + $pavodok + $prohie;

                    ?>

                    <td>
                        <?= $other_rigs_part_3 ?>
                    </td>
                </tr>

                <tr>
                    <td>1.1.</td>
                    <td>на сработку сигнализации</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда  «Другие сигнализации», причина выезда «Молния» ">
                        <?= $signal ?>
                         </span>
                    </td>

                </tr>

                <tr>
                    <td>1.1.1.</td>
                    <td>из них на сработку СПИоЧС "Молния"</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Молния»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_molnia']) && !empty($part_3_tbl_1['cnt_molnia'])) ? $part_3_tbl_1['cnt_molnia'] : 0) +
                        ((isset($archive_bw['cnt_molnia']) && !empty($archive_bw['cnt_molnia'])) ? $archive_bw['cnt_molnia'] : 0)

                        ?>
                         </span>
                    </td>

                </tr>

                <tr>
                    <td>1.2.</td>
                    <td>ложные</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Ложный»">
                        <?= $false ?>
                        </span>
                    </td>

                </tr>

                <tr>
                    <td>1.3.</td>
                    <td>помощь населению, организациям</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Помощь населению»,
                               причина выезда «Помощь организациям»">
                        <?= $help ?>
                         </span>
                    </td>

                </tr>

                <tr>
                    <td>1.4.</td>
                    <td>на проведение демеркуризационных работ/на розлив ртути (ртутьсодержащих отходов)</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Демеркуризация»">
                        <?= $demerk ?>
                         </span>
                    </td>

                </tr>

                <tr>
                    <td>1.4.1.</td>
                    <td>собрано ртути, кг</td>
                    <td>
                        <?=
                        ((isset($part_3_tbl_2['col_arg']) && !empty($part_3_tbl_2['col_arg'])) ? $part_3_tbl_2['col_arg'] : 0) +
                        ((isset($archive_bw['col_arg']) && !empty($archive_bw['col_arg'])) ? $archive_bw['col_arg'] : 0)

                        ?>
                    </td>
                </tr>

                <tr>
                    <td>1.4.2.</td>
                    <td>собрано ртутьсодержащих отходов, кг</td>
                    <td>
                        <?=
                        ((isset($part_3_tbl_2['col_was']) && !empty($part_3_tbl_2['col_was'])) ? $part_3_tbl_2['col_was'] : 0) +
                        ((isset($archive_bw['col_was']) && !empty($archive_bw['col_was'])) ? $archive_bw['col_was'] : 0)

                        ?>
                    </td>
                </tr>

                <tr>
                    <td>1.5.</td>
                    <td>на проведение работ при ликвидации последствий ДТП</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов, где есть пострадавшие при проведении работ при ликвидации последствий ДТП">
                        <?= $dtp ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.5.1.</td>
                    <td>спасено людей</td>
                    <?php
                    $save_people_on_dtp = ((isset($part_3_tbl_2['s_peop_dtp']) && !empty($part_3_tbl_2['s_peop_dtp'])) ? $part_3_tbl_2['s_peop_dtp'] : 0) +
                        ((isset($archive_bw['s_peop_dtp']) && !empty($archive_bw['s_peop_dtp'])) ? $archive_bw['s_peop_dtp'] : 0);

                    ?>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Спасено людей при проведении работ при ликвидации последствий ДТП">
                        <?= $save_people_on_dtp ?>
                         </span>
                    </td>
                </tr>

                <tr>
                    <td>1.5.2.</td>
                    <td>в том числе детей</td>
                    <?php
                    $save_child_on_dtp = ((isset($part_3_tbl_2['s_chi_dtp']) && !empty($part_3_tbl_2['s_chi_dtp'])) ? $part_3_tbl_2['s_chi_dtp'] : 0) +
                        ((isset($archive_bw['s_chi_dtp']) && !empty($archive_bw['s_chi_dtp'])) ? $archive_bw['s_chi_dtp'] : 0);

                    ?>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Спасено детей при проведении работ при ликвидации последствий ДТП">
                        <?= $save_child_on_dtp ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.5.3.</td>
                    <td>деблокировано погибших</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Деблокировано погибших при проведении работ при ликвидации последствий ДТП">
                        <?=
                        ((isset($part_3_tbl_2['d_dead_dtp']) && !empty($part_3_tbl_2['d_dead_dtp'])) ? $part_3_tbl_2['d_dead_dtp'] : 0) +
                        ((isset($archive_bw['d_dead_dtp']) && !empty($archive_bw['d_dead_dtp'])) ? $archive_bw['d_dead_dtp'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.6.</td>
                    <td>на проведение работ на акваториях водоемов</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов, где есть пострадавшие при проведении работ на акваториях водоемов">
                        <?=
                        $akva

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.6.1.</td>
                    <td>спасено людей</td>
                    <?php
                    $save_people_on_akva = ((isset($part_3_tbl_2['s_peop_water']) && !empty($part_3_tbl_2['s_peop_water'])) ? $part_3_tbl_2['s_peop_water'] : 0) +
                        ((isset($archive_bw['s_peop_water']) && !empty($archive_bw['s_peop_water'])) ? $archive_bw['s_peop_water'] : 0);

                    ?>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Спасено людей при проведении работ на акваториях водоемов">
                        <?= $save_people_on_akva ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.6.2.</td>
                    <td>в том числе детей</td>
                    <?php
                    $save_child_on_akva = ((isset($part_3_tbl_2['s_chi_water']) && !empty($part_3_tbl_2['s_chi_water'])) ? $part_3_tbl_2['s_chi_water'] : 0) +
                        ((isset($archive_bw['s_chi_water']) && !empty($archive_bw['s_chi_water'])) ? $archive_bw['s_chi_water'] : 0);

                    ?>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Спасено детей при проведении работ на акваториях водоемов">
                        <?= $save_child_on_akva ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.6.3.</td>
                    <td>извлечено погибших</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Извлечено погибших при проведении работ на акваториях водоемов">
                        <?=
                        ((isset($part_3_tbl_2['d_dead_water']) && !empty($part_3_tbl_2['d_dead_water'])) ? $part_3_tbl_2['d_dead_water'] : 0) +
                        ((isset($archive_bw['d_dead_water']) && !empty($archive_bw['d_dead_water'])) ? $archive_bw['d_dead_water'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.7.</td>
                    <td>на проведение работ по уничтожению гнезд жалоносных насекомых</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов на проведение работ по уничтожению гнезд жалоносных насекомых (соответствующая отметка)">
                        <?=
                        $ins_kill_free_charge

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.7.1.</td>
                    <td><i>на безвозмездной основе в:</i></td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов на проведение работ по уничтожению гнезд жалоносных насекомых (соответствующая отметка)">
                        <?=
                        ((isset($part_3_tbl_2['cnt_ins_kill_free']) && !empty($part_3_tbl_2['cnt_ins_kill_free'])) ? $part_3_tbl_2['cnt_ins_kill_free'] : 0) +
                        ((isset($archive_bw['cnt_ins_kill_free']) && !empty($archive_bw['cnt_ins_kill_free'])) ? $archive_bw['cnt_ins_kill_free'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.7.1.1.</td>
                    <td>случаях наличия прямой угрозы жизни и здоровью людей</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов на проведение работ по уничтожению гнезд жалоносных насекомых (соответствующая отметка)">
                        <?=
                        ((isset($part_3_tbl_2['cnt_ins_kill_free_threat']) && !empty($part_3_tbl_2['cnt_ins_kill_free_threat'])) ? $part_3_tbl_2['cnt_ins_kill_free_threat'] : 0) +
                        ((isset($archive_bw['cnt_ins_kill_free_threat']) && !empty($archive_bw['cnt_ins_kill_free_threat'])) ? $archive_bw['cnt_ins_kill_free_threat'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.7.1.2.</td>
                    <td>дошкольных учреждениях, домах престарелых и инвалидов, больницах, спальных корпусах школ-интернатов и детских учреждений (класс Ф 1.1. согласно ТКП  45-2.02-315-2018)</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов на проведение работ по уничтожению гнезд жалоносных насекомых (соответствующая отметка)">
                        <?=
                        ((isset($part_3_tbl_2['cnt_ins_kill_free_before_school']) && !empty($part_3_tbl_2['cnt_ins_kill_free_before_school'])) ? $part_3_tbl_2['cnt_ins_kill_free_before_school'] : 0) +
                        ((isset($archive_bw['cnt_ins_kill_free_before_school']) && !empty($archive_bw['cnt_ins_kill_free_before_school'])) ? $archive_bw['cnt_ins_kill_free_before_school'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.7.1.3.</td>
                    <td>школах и внешкольных учебных заведениях, средних специальных учебных заведениях, профессионально-технических училищах (класс Ф 4.1. согласно ТКП 45-2.02-315-2018)</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов на проведение работ по уничтожению гнезд жалоносных насекомых (соответствующая отметка)">
                        <?=
                        ((isset($part_3_tbl_2['cnt_ins_kill_free_school']) && !empty($part_3_tbl_2['cnt_ins_kill_free_school'])) ? $part_3_tbl_2['cnt_ins_kill_free_school'] : 0) +
                        ((isset($archive_bw['cnt_ins_kill_free_school']) && !empty($archive_bw['cnt_ins_kill_free_school'])) ? $archive_bw['cnt_ins_kill_free_school'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.7.2.</td>
                    <td><i>на платной основе:</i></td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов на проведение работ по уничтожению гнезд жалоносных насекомых (соответствующая отметка)">
                        <?=
                        ((isset($part_3_tbl_2['cnt_ins_kill_charge']) && !empty($part_3_tbl_2['cnt_ins_kill_charge'])) ? $part_3_tbl_2['cnt_ins_kill_charge'] : 0) +
                        ((isset($archive_bw['cnt_ins_kill_charge']) && !empty($archive_bw['cnt_ins_kill_charge'])) ? $archive_bw['cnt_ins_kill_charge'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.7.2.1.</td>
                    <td>объекты находящиеся в личной собственности граждан</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов на проведение работ по уничтожению гнезд жалоносных насекомых (соответствующая отметка)">
                        <?=
                        ((isset($part_3_tbl_2['cnt_ins_kill_charge_estate']) && !empty($part_3_tbl_2['cnt_ins_kill_charge_estate'])) ? $part_3_tbl_2['cnt_ins_kill_charge_estate'] : 0) +
                        ((isset($archive_bw['cnt_ins_kill_charge_estate']) && !empty($archive_bw['cnt_ins_kill_charge_estate'])) ? $archive_bw['cnt_ins_kill_charge_estate'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.7.2.2.</td>
                    <td>организации по ранее заключенным договорам</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов на проведение работ по уничтожению гнезд жалоносных насекомых (соответствующая отметка)">
                        <?=
                        ((isset($part_3_tbl_2['cnt_ins_kill_charge_dog']) && !empty($part_3_tbl_2['cnt_ins_kill_charge_dog'])) ? $part_3_tbl_2['cnt_ins_kill_charge_dog'] : 0) +
                        ((isset($archive_bw['cnt_ins_kill_charge_dog']) && !empty($archive_bw['cnt_ins_kill_charge_dog'])) ? $archive_bw['cnt_ins_kill_charge_dog'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>1.8.</td>
                    <td>на ликвидацию последствий паводка (без учета ЧС природного характера)</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЧС»,
                              вид работ «ликвидация последствий паводка» ">
                        <?=
                        $pavodok

                        ?>
                         </span>
                    </td>

                </tr>

                <tr>
                    <td>1.9.</td>
                    <td>на прочие:</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «контроль сварочных и огневых работ»;
                               причина выезда «дежурство»; причина выезда «хоз.работы»; причина выезда «запрвка», вид работ «запрвка АСВ»,
                              вид работ «запрвка ГСМ»; причина выезда «передислокация»; причина выезда «ремонт, ТО», вид работ «ремонт», вид работ «ТО-1»,
                              вид работ «ТО-2»; причина выезда «выезд в соседний гарнизон»; причина выезда «испытания ПТВ»;
                              причина выезда «платные услуги»; причина выезда «уборочная кампания» ">
                        <?=
                        $prohie

                        ?>
                         </span>
                    </td>
                </tr>

                <tr>
                    <td>1.9.1.</td>
                    <td>контроль за проведением огневых работ, дозоры</td>
                    <td>
                          <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Контроль за проведением огневых и сварочных работ»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_control']) && !empty($part_3_tbl_1['cnt_control'])) ? $part_3_tbl_1['cnt_control'] : 0) +
                        ((isset($archive_bw['cnt_control']) && !empty($archive_bw['cnt_control'])) ? $archive_bw['cnt_control'] : 0)

                        ?>
                          </span>
                    </td>

                </tr>

                <tr>
                    <td>1.9.2.</td>
                    <td>дежурство по обеспечению пожарной безопасности и взаимодействие с другими службами</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Дежурство»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_duty']) && !empty($part_3_tbl_1['cnt_duty'])) ? $part_3_tbl_1['cnt_duty'] : 0) +
                        ((isset($archive_bw['cnt_duty']) && !empty($archive_bw['cnt_duty'])) ? $archive_bw['cnt_duty'] : 0)

                        ?>
                        </span>
                    </td>

                </tr>

                <tr>
                    <td>1.9.3.</td>
                    <td>хозяйственные работы</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Хоз.работы»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_hoz']) && !empty($part_3_tbl_1['cnt_hoz'])) ? $part_3_tbl_1['cnt_hoz'] : 0) +
                        ((isset($archive_bw['cnt_hoz']) && !empty($archive_bw['cnt_hoz'])) ? $archive_bw['cnt_hoz'] : 0)

                        ?>
                        </span>
                    </td>

                </tr>

                <tr>
                    <td>1.9.4.</td>
                    <td>заправка ГСМ, АСВ</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Заправка»,
                              вид работ «ГСМ»,  вид работ «АСВ»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_zapravka']) && !empty($part_3_tbl_1['cnt_zapravka'])) ? $part_3_tbl_1['cnt_zapravka'] : 0) +
                        ((isset($archive_bw['cnt_zapravka']) && !empty($archive_bw['cnt_zapravka'])) ? $archive_bw['cnt_zapravka'] : 0)

                        ?>
                        </span>
                    </td>


                </tr>

                <tr>
                    <td>1.9.5.</td>
                    <td>передислокация</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Передислокация»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_disloc']) && !empty($part_3_tbl_1['cnt_disloc'])) ? $part_3_tbl_1['cnt_disloc'] : 0) +
                        ((isset($archive_bw['cnt_disloc']) && !empty($archive_bw['cnt_disloc'])) ? $archive_bw['cnt_disloc'] : 0)

                        ?>
                         </span>
                    </td>

                </tr>

                <tr>
                    <td>1.9.6.</td>
                    <td>ТО-1, ТО-2, ремонт</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Ремонт»,
                               вид работ «Ремонт», вид работ «ТО-1», вид работ «ТО-2»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_to']) && !empty($part_3_tbl_1['cnt_to'])) ? $part_3_tbl_1['cnt_to'] : 0) +
                        ((isset($archive_bw['cnt_to']) && !empty($archive_bw['cnt_to'])) ? $archive_bw['cnt_to'] : 0)

                        ?>
                         </span>
                    </td>

                </tr>

                <tr>
                    <td>1.9.7.</td>
                    <td>выезд в соседний гарнизон для ликвидации ЧС</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Выезд в соседний гарнизон»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_neighbor']) && !empty($part_3_tbl_1['cnt_neighbor'])) ? $part_3_tbl_1['cnt_neighbor'] : 0) +
                        ((isset($archive_bw['cnt_neighbor']) && !empty($archive_bw['cnt_neighbor'])) ? $archive_bw['cnt_neighbor'] : 0)

                        ?>
                         </span>
                    </td>

                </tr>

                <tr>
                    <td>1.9.8.</td>
                    <td>испытание ПТВ</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «испытания ПТВ»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_ptv']) && !empty($part_3_tbl_1['cnt_ptv'])) ? $part_3_tbl_1['cnt_ptv'] : 0) +
                        ((isset($archive_bw['cnt_ptv']) && !empty($archive_bw['cnt_ptv'])) ? $archive_bw['cnt_ptv'] : 0)

                        ?>
                         </span>
                    </td>

                </tr>

                <tr>
                    <td>1.9.9.</td>
                    <td>платные услуги</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Платные услуги»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_pay']) && !empty($part_3_tbl_1['cnt_pay'])) ? $part_3_tbl_1['cnt_pay'] : 0) +
                        ((isset($archive_bw['cnt_pay']) && !empty($archive_bw['cnt_pay'])) ? $archive_bw['cnt_pay'] : 0)

                        ?>
                        </span>
                    </td>

                </tr>

                <tr>
                    <td>1.9.10.</td>
                    <td>другие</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Уборочная кампания»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_other']) && !empty($part_3_tbl_1['cnt_other'])) ? $part_3_tbl_1['cnt_other'] : 0) +
                        ((isset($archive_bw['cnt_other']) && !empty($archive_bw['cnt_other'])) ? $archive_bw['cnt_other'] : 0)

                        ?>
                        </span>
                    </td>

                </tr>



                <tr>
                    <td><b>2.</b></td>
                    <td><b>Спасено людей в иных случаях:</b></td>
                    <?php
                    $save_people_other_case = ((isset($part_3_tbl_2['cnt_s_people']) && !empty($part_3_tbl_2['cnt_s_people'])) ? $part_3_tbl_2['cnt_s_people'] : 0) +
                        ((isset($archive_bw['cnt_s_people_grunt']) && !empty($archive_bw['cnt_s_people_grunt'])) ? $archive_bw['cnt_s_people_grunt'] : 0) +
                        ((isset($archive_bw['cnt_s_people_kon']) && !empty($archive_bw['cnt_s_people_kon'])) ? $archive_bw['cnt_s_people_kon'] : 0) +
                        ((isset($archive_bw['cnt_s_people_cons']) && !empty($archive_bw['cnt_s_people_cons'])) ? $archive_bw['cnt_s_people_cons'] : 0);

                    ?>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма строк: 2.1.1 + 2.2.1 + 2.3.1">
                        <?= $save_people_other_case ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>2.1.</td>
                    <td>обвал грунта</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов, где есть пострадавшие при обвале грунта">
                        <?=
                        ((isset($part_3_tbl_2['cnt_s_grunt']) && !empty($part_3_tbl_2['cnt_s_grunt'])) ? $part_3_tbl_2['cnt_s_grunt'] : 0) +
                        ((isset($archive_bw['cnt_s_grunt']) && !empty($archive_bw['cnt_s_grunt'])) ? $archive_bw['cnt_s_grunt'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>2.1.1.</td>
                    <td>спасено людей</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Спасено людей при обвале грунта">
                        <?=
                        ((isset($part_3_tbl_2['cnt_s_people_grunt']) && !empty($part_3_tbl_2['cnt_s_people_grunt'])) ? $part_3_tbl_2['cnt_s_people_grunt'] : 0) +
                        ((isset($archive_bw['cnt_s_people_grunt']) && !empty($archive_bw['cnt_s_people_grunt'])) ? $archive_bw['cnt_s_people_grunt'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>2.1.2.</td>
                    <td>в том числе детей</td>
                    <?php
                    $save_child_on_grunt = ((isset($part_3_tbl_2['cnt_s_chi_grunt']) && !empty($part_3_tbl_2['cnt_s_chi_grunt'])) ? $part_3_tbl_2['cnt_s_chi_grunt'] : 0) +
                        ((isset($archive_bw['cnt_s_chi_grunt']) && !empty($archive_bw['cnt_s_chi_grunt'])) ? $archive_bw['cnt_s_chi_grunt'] : 0);

                    ?>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Спасено детей при обвале грунта">
                        <?= $save_child_on_grunt ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>2.2.</td>
                    <td>обрушение строительных конструкций</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов, где есть пострадавшие при обрушении строительных конструкций">
                        <?=
                        ((isset($part_3_tbl_2['cnt_s_kon']) && !empty($part_3_tbl_2['cnt_s_kon'])) ? $part_3_tbl_2['cnt_s_kon'] : 0) +
                        ((isset($archive_bw['cnt_s_kon']) && !empty($archive_bw['cnt_s_kon'])) ? $archive_bw['cnt_s_kon'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>2.2.1.</td>
                    <td>спасено людей</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Спасено людей при обрушении строительных конструкций">
                        <?=
                        ((isset($part_3_tbl_2['cnt_s_people_kon']) && !empty($part_3_tbl_2['cnt_s_people_kon'])) ? $part_3_tbl_2['cnt_s_people_kon'] : 0) +
                        ((isset($archive_bw['cnt_s_people_kon']) && !empty($archive_bw['cnt_s_people_kon'])) ? $archive_bw['cnt_s_people_kon'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>2.2.2.</td>
                    <td>в том числе детей</td>
                    <?php
                    $save_child_on_kon = ((isset($part_3_tbl_2['cnt_s_chi_kon']) && !empty($part_3_tbl_2['cnt_s_chi_kon'])) ? $part_3_tbl_2['cnt_s_chi_kon'] : 0) +
                        ((isset($archive_bw['cnt_s_chi_kon']) && !empty($archive_bw['cnt_s_chi_kon'])) ? $archive_bw['cnt_s_chi_kon'] : 0);

                    ?>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Спасено детей при обрушении строительных конструкций">
                        <?= $save_child_on_kon ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>2.3.</td>
                    <td>других обстоятельствах</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов, где есть пострадавшие при других обстоятельствах">
                        <?=
                        ((isset($part_3_tbl_2['cnt_s_cons']) && !empty($part_3_tbl_2['cnt_s_cons'])) ? $part_3_tbl_2['cnt_s_cons'] : 0) +
                        ((isset($archive_bw['cnt_s_cons']) && !empty($archive_bw['cnt_s_cons'])) ? $archive_bw['cnt_s_cons'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>2.3.1.</td>
                    <td>спасено людей</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Спасено людей при при других обстоятельствах">
                        <?=
                        ((isset($part_3_tbl_2['cnt_s_people_cons']) && !empty($part_3_tbl_2['cnt_s_people_cons'])) ? $part_3_tbl_2['cnt_s_people_cons'] : 0) +
                        ((isset($archive_bw['cnt_s_people_cons']) && !empty($archive_bw['cnt_s_people_cons'])) ? $archive_bw['cnt_s_people_cons'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>2.3.2.</td>
                    <td>в том числе детей</td>
                    <?php
                    $save_child_on_cons = ((isset($part_3_tbl_2['cnt_s_chi_cons']) && !empty($part_3_tbl_2['cnt_s_chi_cons'])) ? $part_3_tbl_2['cnt_s_chi_cons'] : 0) +
                        ((isset($archive_bw['cnt_s_chi_cons']) && !empty($archive_bw['cnt_s_chi_cons'])) ? $archive_bw['cnt_s_chi_cons'] : 0);

                    ?>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Спасено детей при при других обстоятельствах">
                        <?= $save_child_on_cons ?>
                        </span>
                    </td>
                </tr>


                <tr>
                    <td colspan="3"><center><b>Раздел IV. Общие сведения</b></center></td>
                </tr>

                <tr>
                    <td>1.</td>
                    <td>Общее количество выездов</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма пунктов 1 всех разделов отчета">
                        <?= $all_rigs_fire_part_1 + $all_rigs_hs_part_2 + $other_rigs_part_3 ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Спасено людей</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма спасенных людей">
                        <?= $save_people_on_fire + $save_people_on_hs + $save_people_on_dtp + $save_people_on_akva + $save_people_other_case ?>
                        </span>
                        </td>
                </tr>
                <tr>
                    <td>2.1.</td>
                    <td>в том числе детей</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма спасенных детей">
                        <?=
                        $save_child_on_fire + $save_child_on_hs + $save_child_on_dtp + $save_child_on_akva + $save_child_on_grunt +
                        $save_child_on_kon + $save_child_on_cons

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td><b>3.</b></td>
                    <td><b>Проведено тактико-специальных учений (занятий)</b></td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Сумма 3.1 + 3.2 + 3.3">
                        <?=
                        ((isset($part_3_tbl_1['zan_sum']) && !empty($part_3_tbl_1['zan_sum'])) ? $part_3_tbl_1['zan_sum'] : 0) +
                        ((isset($archive_bw['cnt_tsu']) && !empty($archive_bw['cnt_tsu'])) ? $archive_bw['cnt_tsu'] : 0) +
                        ((isset($archive_bw['cnt_tsz']) && !empty($archive_bw['cnt_tsz'])) ? $archive_bw['cnt_tsz'] : 0) +
                        ((isset($archive_bw['cnt_pasp']) && !empty($archive_bw['cnt_pasp'])) ? $archive_bw['cnt_pasp'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>3.1.</td>
                    <td>проведено ТСУ</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Занятия»,
                              вид работ «ТСУ»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_tsu']) && !empty($part_3_tbl_1['cnt_tsu'])) ? $part_3_tbl_1['cnt_tsu'] : 0) +
                        ((isset($archive_bw['cnt_tsu']) && !empty($archive_bw['cnt_tsu'])) ? $archive_bw['cnt_tsu'] : 0)

                        ?>
                        </span>
                    </td>


                </tr>

                <tr>
                    <td>3.2.</td>
                    <td>проведено ТСЗ</td>
                    <td>
                          <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Занятия»,
                              вид работ «ТСЗ»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_tsz']) && !empty($part_3_tbl_1['cnt_tsz'])) ? $part_3_tbl_1['cnt_tsz'] : 0) +
                        ((isset($archive_bw['cnt_tsz']) && !empty($archive_bw['cnt_tsz'])) ? $archive_bw['cnt_tsz'] : 0)

                        ?>
                          </span>
                    </td>

                </tr>

                <tr>
                    <td>3.2.1.</td>
                    <td>в том числе в ночное время</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Занятия»,
                               вид работ «ТСЗ», вид работ «ТСЗ». Время поступления сообщения с 22 00 до 06 00">
                        <?=
                        ((isset($part_3_tbl_1['cnt_night']) && !empty($part_3_tbl_1['cnt_night'])) ? $part_3_tbl_1['cnt_night'] : 0) +
                        ((isset($archive_bw['cnt_night']) && !empty($archive_bw['cnt_night'])) ? $archive_bw['cnt_night'] : 0)

                        ?>
                         </span>
                    </td>

                </tr>

                <tr>
                    <td>3.3.</td>
                    <td>занятия по ПАСП, отработка нормативов по пожарной аварийно-спасательной подготовке</td>
                    <td>
                         <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «Занятия»,
                               вид работ «занятия ПАСП»">
                        <?=
                        ((isset($part_3_tbl_1['cnt_pasp']) && !empty($part_3_tbl_1['cnt_pasp'])) ? $part_3_tbl_1['cnt_pasp'] : 0) +
                        ((isset($archive_bw['cnt_pasp']) && !empty($archive_bw['cnt_pasp'])) ? $archive_bw['cnt_pasp'] : 0)

                        ?>
                         </span>
                    </td>

                </tr>


                <tr>
                    <td><b>4.</b></td>
                    <td><b>Случаи героизма, проявленные л/с при ликвидации ЧС</b></td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во уникальных выездов, где стоит соответствующая отметка">
                        <?=
                        ((isset($part_3_tbl_2['cnt_hero_in_out']) && !empty($part_3_tbl_2['cnt_hero_in_out'])) ? $part_3_tbl_2['cnt_hero_in_out'] : 0) +
                        ((isset($archive_bw['cnt_hero_in_out']) && !empty($archive_bw['cnt_hero_in_out'])) ? $archive_bw['cnt_hero_in_out'] : 0)

                        ?>

                        </span>
                    </td>
                </tr>

                <tr>
                    <td>4.1.</td>
                    <td>в районе выезда подразделения</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов, где стоит соответствующая отметка">
                        <?=
                        ((isset($part_3_tbl_2['cnt_hero_in']) && !empty($part_3_tbl_2['cnt_hero_in'])) ? $part_3_tbl_2['cnt_hero_in'] : 0) +
                        ((isset($archive_bw['cnt_hero_in']) && !empty($archive_bw['cnt_hero_in'])) ? $archive_bw['cnt_hero_in'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>4.2.</td>
                    <td>вне района выезда подразделения</td>
                    <td>
                        <span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Кол-во выездов, где стоит соответствующая отметка">
                        <?=
                        ((isset($part_3_tbl_2['cnt_hero_out']) && !empty($part_3_tbl_2['cnt_hero_out'])) ? $part_3_tbl_2['cnt_hero_out'] : 0) +
                        ((isset($archive_bw['cnt_hero_out']) && !empty($archive_bw['cnt_hero_out'])) ? $archive_bw['cnt_hero_out'] : 0)

                        ?>
                        </span>
                    </td>
                </tr>




                </tbody>
            </table>

        </center>

    </div>

</div>
