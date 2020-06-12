<?php
//print_r($result);

?>
<style>
    #archiveTable5_wrapper{
        width: 98%;
    }
    .dataTables_filter{
        display: none !important;
    }
    .inpt-archive-show{
        display: block !important;
    }

    #inptarchiveTable50,#inptarchiveTable51,#inptarchiveTable56,#inptarchiveTable57,#inptarchiveTable58,#inptarchiveTable59
    ,#inptarchiveTable60,#inptarchiveTable61,#inptarchiveTable62,#inptarchiveTable63,#inptarchiveTable64,#inptarchiveTable65{
        width: 38px;
    }
    #inptarchiveTable52,#inptarchiveTable53,#inptarchiveTable510,#inptarchiveTable511, #inptarchiveTable512, #inptarchiveTable513, #inptarchiveTable514
    , #inptarchiveTable515, #inptarchiveTable516, #inptarchiveTable517, #inptarchiveTable518, #inptarchiveTable519, #inptarchiveTable520, #inptarchiveTable521, #inptarchiveTable522{
        width: 55px;
    }
    #inptarchiveTable54,#inptarchiveTable55{
        width: 100px;
    }

    #selrigForm6,#selrigForm7{
        width: 80px;
    }
    #inptarchiveTable523{
        width: 50px;
    }
</style>
<table class="table table-condensed   table-bordered table-custom" id="archiveTable5">
    <thead>
        <tr>
            <th>N</th>
            <th>ID</th>
            <th>Дата</th>
            <th>Вре-<br>мя</th>
            <th>Район</th>
            <th>Адрес</th>
            <th>Пог.</th>
            <th>В т.ч. детей</th>
            <th>Сп.</th>
            <th>Травм.</th>
            <th>Эвак.</th>
      <!--      <th>Сп.<br>(стр.)</th>
            <th>Повр.<br>(стр.)</th>
            <th>Уничт.<br>(стр.)</th>-->
            <th>Строения</th>
      <!--      <th>Сп.<br>(техн.)</th>
            <th>Повр.<br>(техн.)</th>
            <th>Уничт.<br>(техн.)</th>-->
            <th>Техника</th>
      <!--      <th>Сп.<br>(г.с.)</th>
            <th>Повр.<br>(г.с.)</th>
            <th>Уничт.<br>(г.с.)</th>-->
            <th>Животные</th>
            <th>Корма и технические культуры</th>
            <th>Другие данные</th>

        </tr>
    </thead>

    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
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
        foreach ($result as $row) {

            $res_battle = array();
            $rb_chapter_1=[];
            $rb_chapter_2=[];
            $rb_chapter_3=[];
            // $res_battle=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
            if (!empty($row['results_battle']))
                $res_battle = explode('#', $row['results_battle']);


            if (!empty($row['rb_chapter_1']))
                $rb_chapter_1 = explode('#', $row['rb_chapter_1']);
            if (!empty($row['rb_chapter_2']))
                $rb_chapter_2 = explode('#', $row['rb_chapter_2']);
            if (!empty($row['rb_chapter_3']))
                $rb_chapter_3 = explode('#', $row['rb_chapter_3']);

            if ((isset($res_battle) && !empty($res_battle) && count($res_battle) > 1 && max($res_battle) > 0) ||
                (isset($rb_chapter_1) && !empty($rb_chapter_1) && count($rb_chapter_1) > 1 && max($rb_chapter_1) > 0) ||
                (isset($rb_chapter_2) && !empty($rb_chapter_2) && count($rb_chapter_2) > 1 && max($rb_chapter_2) > 0) ||
                (isset($rb_chapter_3) && !empty($rb_chapter_3) && count($rb_chapter_3) > 1 && max($rb_chapter_3) > 0)) {
                $i++;

                ?>
                <tr  style='background-color:rgb(<?= $_SESSION['colors'][$row['id_rig']] ?>); '>
                    <td><?= $i ?></td>
                    <td><b><a href="<?= $baseUrl ?>/card_rig/<?= $table_name_year ?>/<?= $row['id_rig'] ?>" style="color:black" target="_blank" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку вызова"> <?= $row['id_rig'] ?></a></b></td>
                    <td><?= date('d.m.Y', strtotime($row['date_msg'])) ?></td>
                    <td><?= date('H:i', strtotime($row['time_msg'])) ?></td>
                    <td><?= $row['local_name'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= (isset($res_battle[0]) && !empty($res_battle[0])) ? $res_battle[0] : '' ?></td>
                    <td><?= (isset($res_battle[1]) && !empty($res_battle[1])) ? $res_battle[1] : '' ?></td>
                    <td><?= (isset($res_battle[2]) && !empty($res_battle[2])) ? $res_battle[2] : '' ?></td>
                    <td><?= (isset($res_battle[3]) && !empty($res_battle[3])) ? $res_battle[3] : '' ?></td>
                    <td><?= (isset($res_battle[4]) && !empty($res_battle[4])) ? $res_battle[4] : '' ?></td>



                    <td>
                        <?= (isset($res_battle[5]) && !empty($res_battle[5])) ? 'сп.: ' . $res_battle[5] : '' ?><br>
                        <?= (isset($res_battle[6]) && !empty($res_battle[6])) ? 'повр.: ' . $res_battle[6] : '' ?><br>
                        <?= (isset($res_battle[7]) && !empty($res_battle[7])) ? 'уничт.: ' . $res_battle[7] : '' ?>
                    </td>

                    <td>
                        <?= (isset($res_battle[8]) && !empty($res_battle[8])) ? 'сп.: ' . $res_battle[8] : '' ?><br>
                        <?= (isset($res_battle[9]) && !empty($res_battle[9])) ? 'повр.: ' . $res_battle[9] : '' ?><br>
                        <?= (isset($res_battle[10]) && !empty($res_battle[10])) ? 'уничт.: ' . $res_battle[10] : '' ?>
                    </td>


                    <td>
                        <?= (isset($res_battle[11]) && !empty($res_battle[11])) ? 'сп.: ' . $res_battle[11] : '' ?><br>
                        <?= (isset($res_battle[21]) && !empty($res_battle[21])) ? 'сп. в т.ч. подразд. МЧС: ' . $res_battle[21] : '' ?>
                        <?= (isset($res_battle[12]) && !empty($res_battle[12])) ? 'повр. (голов скота): ' . $res_battle[12] : '' ?><br>
                        <?= (isset($res_battle[13]) && !empty($res_battle[13])) ? 'уничт. (голов скота): ' . $res_battle[13] : '' ?>
                    </td>



                    <td>
                        <?= (isset($res_battle[14]) && !empty($res_battle[14])) ? 'спасено (тонн): ' . $res_battle[14] : '' ?><br>
                        <?= (isset($res_battle[15]) && !empty($res_battle[15])) ? 'повреждено (тонн): ' . $res_battle[15] : '' ?><br>
                        <?= (isset($res_battle[16]) && !empty($res_battle[16])) ? 'уничтожено (тонн): ' . $res_battle[16] : '' ?>
                    </td>


                    <td>
                        <?= (isset($res_battle[17]) && !empty($res_battle[17])) ? 'спасено детей: ' . $res_battle[17] : '' ?><br>
                        <?= (isset($res_battle[18]) && !empty($res_battle[18])) ? '<br>эвак. детей: ' . $res_battle[18] : '' ?>

                        <?= (isset($res_battle[19]) && !empty($res_battle[19])) ? '<br>спасено в т.ч. подразд. МЧС: ' . $res_battle[19] : '' ?>

                        <?= (isset($res_battle[20]) && !empty($res_battle[20])) ? '<br>эвак. в т.ч. подразд. МЧС: ' . $res_battle[20] : '' ?>

                        <?= (isset($res_battle[22]) && !empty($res_battle[22])) ? '<br>спасено мат. ценностей, руб.: ' . $res_battle[22] : '' ?>

                        <?= (isset($res_battle[23]) && !empty($res_battle[23])) ? '<br>ущерб (прямые потери), руб.: ' . $res_battle[23] : '' ?>


                        <?php
                        if ((isset($rb_chapter_1) && !empty($rb_chapter_1) && count($rb_chapter_1) > 1 && max($rb_chapter_1) > 0)) {

                            ?>
                            <u>Боевая работа по ликвидации пожаров:</u>
                            <?php ?>


                            <?php
                            if ((isset($rb_chapter_1[0]) && !empty($rb_chapter_1[0])) || (isset($rb_chapter_1[1]) && !empty($rb_chapter_1[1])) ||
                                (isset($rb_chapter_1[2]) && !empty($rb_chapter_1[2])) || (isset($rb_chapter_1[3]) && !empty($rb_chapter_1[3])) ||
                                (isset($rb_chapter_1[4]) && !empty($rb_chapter_1[4])) || (isset($rb_chapter_1[5]) && !empty($rb_chapter_1[5])) ||
                                (isset($rb_chapter_1[6]) && !empty($rb_chapter_1[6]))) {

                                ?>
                                <br><b>пожар ликвидирован:</b>
                                <?php
                            }

                            ?>
                            <?= (isset($rb_chapter_1[0]) && !empty($rb_chapter_1[0])) ? '<br>нас., работающим до приб. подразд. МЧС' : '' ?>
                            <?= (isset($rb_chapter_1[1]) && !empty($rb_chapter_1[1])) ? '<br>ведомст. и добр. пож. формированиями до приб. подразд. МЧС' : '' ?>
                            <?= (isset($rb_chapter_1[2]) && !empty($rb_chapter_1[2])) ? '<br>без установки пож. аварийно-спасат. автомобилей на водоисточник (водоем, ПГ и т.п.)' : '' ?>
                            <?= (isset($rb_chapter_1[3]) && !empty($rb_chapter_1[3])) ? '<br>с установкой пож. аварийно-спасат. автомобилей на водоисточник (водоем, ПГ и т.п.)' : '' ?>
                            <?= (isset($rb_chapter_1[4]) && !empty($rb_chapter_1[4])) ? '<br>силами одной отделения' : '' ?>
                            <?= (isset($rb_chapter_1[5]) && !empty($rb_chapter_1[5])) ? '<br>силами одной смены' : '' ?>
                            <?= (isset($rb_chapter_1[6]) && !empty($rb_chapter_1[6])) ? '<br>с привлеч. доп. сил МЧС' : '' ?>

                            <?= (isset($rb_chapter_1[7]) && !empty($rb_chapter_1[7])) ? '<br>механиз.инструмент: ' . $rb_chapter_1[7] : '' ?>
                            <?= (isset($rb_chapter_1[8]) && !empty($rb_chapter_1[8])) ? '<br>пневмат. инструмент: ' . $rb_chapter_1[8] : '' ?>
                            <?= (isset($rb_chapter_1[9]) && !empty($rb_chapter_1[9])) ? '<br>гидравл. инструмент: ' . $rb_chapter_1[9] : '' ?>
                            <?= (isset($rb_chapter_1[10]) && !empty($rb_chapter_1[10])) ? '<br>кол-во привлеч. авиац. техники: ' . $rb_chapter_1[10] : '' ?>
                            <?= (isset($rb_chapter_1[11]) && !empty($rb_chapter_1[11])) ? '<br>другая техника МЧС' : '' ?>
                            <?= (isset($rb_chapter_1[12]) && !empty($rb_chapter_1[12])) ? '<br>одно звено ГДЗС' : '' ?>
                            <?= (isset($rb_chapter_1[13]) && !empty($rb_chapter_1[13])) ? '<br>два и более звеньев ГДЗС' : '' ?>
                            <?= (isset($rb_chapter_1[14]) && !empty($rb_chapter_1[14])) ? '<br>переносные порошк. огнетушители: ' . $rb_chapter_1[14] : '' ?>
                            <?= (isset($rb_chapter_1[15]) && !empty($rb_chapter_1[15])) ? '<br>израсходовано порошка, тонн: ' . $rb_chapter_1[15] : '' ?>
                            <?= (isset($rb_chapter_1[16]) && !empty($rb_chapter_1[16])) ? '<br>сп. людей (с прим. масок): ' . $rb_chapter_1[16] : '' ?>
                            <?= (isset($rb_chapter_1[17]) && !empty($rb_chapter_1[17])) ? '<br>пред. уничт. кормов (тонн): ' . $rb_chapter_1[17] : '' ?>
                            <?= (isset($rb_chapter_1[18]) && !empty($rb_chapter_1[18])) ? '<br>пред. уничт. огнем строений: ' . $rb_chapter_1[18] : '' ?>
                            <?= (isset($rb_chapter_1[19]) && !empty($rb_chapter_1[19])) ? '<br>пред. уничт. огнем ед. техники: ' . $rb_chapter_1[19] : '' ?>
                            <?php
                        }


                        if ((isset($rb_chapter_2) && !empty($rb_chapter_2) && count($rb_chapter_2) > 1 && max($rb_chapter_2) > 0)) {

                            ?>
                            <br><u>Боевая работа по ликвидации ЧС:</u>

                            <?= (isset($rb_chapter_2[0]) && !empty($rb_chapter_2[0])) ? '<br>пред. уничт. строений: ' . $rb_chapter_2[0] : '' ?>
                            <?= (isset($rb_chapter_2[1]) && !empty($rb_chapter_2[1])) ? '<br>пред. уничт. ед. техники: ' . $rb_chapter_2[1] : '' ?>
                            <?= (isset($rb_chapter_2[2]) && !empty($rb_chapter_2[2])) ? '<br>кол-во привлеч. авиац. техники: ' . $rb_chapter_2[2] : '' ?>
                            <?= (isset($rb_chapter_2[3]) && !empty($rb_chapter_2[3])) ? '<br>механиз.инструмент: ' . $rb_chapter_2[3] : '' ?>
                            <?= (isset($rb_chapter_2[4]) && !empty($rb_chapter_2[4])) ? '<br>пневмат. инструмент: ' . $rb_chapter_2[4] : '' ?>
                            <?= (isset($rb_chapter_2[5]) && !empty($rb_chapter_2[5])) ? '<br>гидравл. инструмент: ' . $rb_chapter_2[5] : '' ?>

                            <?php
                        }



                        if ((isset($rb_chapter_3) && !empty($rb_chapter_3) && count($rb_chapter_3) > 1 && max($rb_chapter_3) > 0)) {

                            ?>

                            <br><u>Общие сведения и другие выезды:</u>

                            <?php
                            if ((isset($rb_chapter_3[0]) && !empty($rb_chapter_3[0])) || (isset($rb_chapter_3[1]) && !empty($rb_chapter_3[1])) ||
                                (isset($rb_chapter_3[2]) && !empty($rb_chapter_3[2]))) {

                                ?>
                                <br><b>На проведение работ при ликвидации последстий ДТП:</b>

                                <?= (isset($rb_chapter_3[0]) && !empty($rb_chapter_3[0])) ? '<br>сп. людей: ' . $rb_chapter_3[0] : '' ?>
                                <?= (isset($rb_chapter_3[1]) && !empty($rb_chapter_3[1])) ? '<br>в т.ч. детей: ' . $rb_chapter_3[1] : '' ?>
                                <?= (isset($rb_chapter_3[2]) && !empty($rb_chapter_3[2])) ? '<br>деблокировано погибших: ' . $rb_chapter_3[2] : '' ?>


                                <?php
                            }

                            if ((isset($rb_chapter_3[3]) && !empty($rb_chapter_3[3])) || (isset($rb_chapter_3[4]) && !empty($rb_chapter_3[4])) ||
                                (isset($rb_chapter_3[5]) && !empty($rb_chapter_3[5]))) {

                                ?>
                                <br><b>На проведение работ на акваториях водоемов:</b>

                                <?= (isset($rb_chapter_3[3]) && !empty($rb_chapter_3[3])) ? '<br>сп. людей: ' . $rb_chapter_3[3] : '' ?>
                                <?= (isset($rb_chapter_3[4]) && !empty($rb_chapter_3[4])) ? '<br>в т.ч. детей: ' . $rb_chapter_3[4] : '' ?>
                                <?= (isset($rb_chapter_3[5]) && !empty($rb_chapter_3[5])) ? '<br>извлечено погибших: ' . $rb_chapter_3[5] : '' ?>


                                <?php
                            }

                            if ((isset($rb_chapter_3[6]) && !empty($rb_chapter_3[6])) || (isset($rb_chapter_3[7]) && !empty($rb_chapter_3[7])) ||
                                (isset($rb_chapter_3[8]) && !empty($rb_chapter_3[8])) || (isset($rb_chapter_3[9]) && !empty($rb_chapter_3[9])) ||
                                (isset($rb_chapter_3[10]) && !empty($rb_chapter_3[10])) || (isset($rb_chapter_3[11]) && !empty($rb_chapter_3[11]))) {

                                ?>
                                <br><b>Спасено людей в иных случаях:</b>

                                <?= (isset($rb_chapter_3[6]) && !empty($rb_chapter_3[6])) ? '<br>сп. людей при обвале грунта: ' . $rb_chapter_3[6] : '' ?>
                                <?= (isset($rb_chapter_3[7]) && !empty($rb_chapter_3[7])) ? '<br>сп. детей при обвале грунта: ' . $rb_chapter_3[7] : '' ?>
                                <?= (isset($rb_chapter_3[8]) && !empty($rb_chapter_3[8])) ? '<br>сп. людей при обруш. строит. конструкций: ' . $rb_chapter_3[8] : '' ?>
                                <?= (isset($rb_chapter_3[9]) && !empty($rb_chapter_3[9])) ? '<br>сп. детей при обруш. строит. конструкций: ' . $rb_chapter_3[9] : '' ?>
                                <?= (isset($rb_chapter_3[10]) && !empty($rb_chapter_3[10])) ? '<br>сп. людей при др. обстоят.: ' . $rb_chapter_3[10] : '' ?>
                                <?= (isset($rb_chapter_3[11]) && !empty($rb_chapter_3[11])) ? '<br>сп. детей при др. обстоят.: ' . $rb_chapter_3[11] : '' ?>


                                <?php
                            }



                            if ((isset($rb_chapter_3[12]) && !empty($rb_chapter_3[12]) && $rb_chapter_3[12]!=0) || (isset($rb_chapter_3[13]) && !empty($rb_chapter_3[13]) && $rb_chapter_3[13]!=0)) {

                                ?>
                                <br><b>На проведение демеркуризационных работ:</b>

                                <?= (isset($rb_chapter_3[12]) && !empty($rb_chapter_3[12]) && $rb_chapter_3[12]!=0) ? '<br>cобрано ртути, кг: ' . $rb_chapter_3[12] : '' ?>
                                <?= (isset($rb_chapter_3[13]) && !empty($rb_chapter_3[13]) && $rb_chapter_3[13]!=0) ? '<br>cобрано ртутьсодержащих отходов, кг: ' . $rb_chapter_3[13] : '' ?>

                                <?php
                            }


                            if ((isset($rb_chapter_3[14]) && !empty($rb_chapter_3[14])) || (isset($rb_chapter_3[15]) && !empty($rb_chapter_3[15])) ||
                                (isset($rb_chapter_3[16]) && !empty($rb_chapter_3[16])) || (isset($rb_chapter_3[17]) && !empty($rb_chapter_3[17])) ||
                                (isset($rb_chapter_3[18]) && !empty($rb_chapter_3[18])) || (isset($rb_chapter_3[19]) && !empty($rb_chapter_3[19])) ||
                                (isset($rb_chapter_3[20]) && !empty($rb_chapter_3[20]))) {

                                ?>
                                <br><b>На проведение работ по уничтожению гнезд жалоносных насекомых:</b>

                                <?= (isset($rb_chapter_3[14]) && !empty($rb_chapter_3[14])) ? '<br>на безвозмездной основе' : '' ?>
                                <?= (isset($rb_chapter_3[15]) && !empty($rb_chapter_3[15])) ? '<br>на платной основе' : '' ?>
                                <?= (isset($rb_chapter_3[16]) && !empty($rb_chapter_3[16])) ? '<br>наличие прямой угрозы жизни' : '' ?>
                                <?= (isset($rb_chapter_3[17]) && !empty($rb_chapter_3[17])) ? '<br>объекты, находящиеся в личн. собств. граждан' : '' ?>
                                <?= (isset($rb_chapter_3[18]) && !empty($rb_chapter_3[18])) ? '<br>организации по ранее заключ. договорам' : '' ?>
                                <?= (isset($rb_chapter_3[19]) && !empty($rb_chapter_3[19])) ? '<br>дошкольн. учрежд., больницах и т.д (класс Ф 1.1 ТКП 45-2.02-315-2018)' : '' ?>
                                <?= (isset($rb_chapter_3[20]) && !empty($rb_chapter_3[20])) ? '<br>школах и внешкольных уч. завед. и т.д (класс Ф 4.1 ТКП 45-2.02-315-2018)' : '' ?>


                                <?php
                            }




                            if ((isset($rb_chapter_3[21]) && !empty($rb_chapter_3[21])) ||
                                (isset($rb_chapter_3[22]) && !empty($rb_chapter_3[22]))) {

                                ?>
                                <br><b>Случаи героизма, проявленные л/с при ликвидации ЧС:</b>

                                <?= (isset($rb_chapter_3[21]) && !empty($rb_chapter_3[21])) ? '<br>в районе выезда подразделения' : '' ?>
                                <?= (isset($rb_chapter_3[22]) && !empty($rb_chapter_3[22])) ? '<br>вне района выезда подразделения' : '' ?>
                                <?php
                            }
                        }

                        ?>

                    </td>

                </tr>
        <?php
    }

    ?>

            <?php
        }

        ?>
<!--  <tr>
  <td>1</td>
    <td>40000</td>
    <td>27.02.2019</td>
    <td>20:00</td>
    <td>Сморгонский</td>
    <td>ул. Советская 12-23</td>
        <td>платные услуги</td>
        <td>уборка территории</td>
        <td>проведены работы по плановой уборке</td>
        <td>Иванов П.С.</td>
    </tr>
  <tr>
  <td>2</td>
   <td>40001</td>
    <td>27.02.2019</td>
    <td>20:00</td>
    <td>Сморгонский</td>
    <td>ул. Советская 12-23</td>
        <td>платные услуги</td>
        <td>уборка территории</td>
        <td>проведены работы по плановой уборке</td>
        <td>Иванов П.С.</td>
    </tr>
  <tr>
  <td>3</td>
   <td>40002</td>
    <td>27.02.2019</td>
    <td>20:00</td>
    <td>Сморгонский</td>
    <td>ул. Советская 12-23</td>
        <td>платные услуги</td>
        <td>уборка территории</td>
        <td>проведены работы по плановой уборке</td>
        <td>Иванов П.С.</td>
    </tr>-->
    </tbody>
</table>

<br>
<a href="<?= $link_excel ?>" id="link_to_excel"><button class="submit" type="submit" >Экспорт в Excel</button></a>
<input type="hidden" value="<?= $link_excel_hidden ?>" id="prev_link_to_excel">

<script>

    (function ($, undefined) {
        $(function () {

            $('#archiveTable5').DataTable({
                // "pageLength": 50,
                "lengthMenu": [[-1, 10, 25, 50], ["Все", 10, 25, 50]],

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
            });


        });


    })(jQuery);

    $(document).ready(function () {
        $("tfoot").css("display", "table-header-group");//tfoot of table



        $('#archiveTable5 tfoot th').each(function (i) {
            var table = $('#archiveTable5').DataTable();

            var title = $('#archiveTable5 tfoot th').eq($(this).index()).text();
            var x = $('#archiveTable5 tfoot th').index($(this));
            var y = 'archiveTable5';
            //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
            $(this).html('<input type="text" class="noprint inpt-archive-show" id="inpt' + y + x + '" placeholder="Поиск" onkeyup="keyupField();"  />');
            // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');



        });
        $("#archiveTable5 tfoot input").on('keyup change', function () {
            var table = $('#archiveTable5').DataTable();
            table
                    .column($(this).parent().index() + ':visible')
                    .search(this.value)
                    .draw();
        });

    });



    function changeLinkExcel() {

        var id_rig = $('#inptarchiveTable51').val();
        var date_msg = $('#inptarchiveTable52').val();
        var time_msg = $('#inptarchiveTable53').val();
        var local = $('#inptarchiveTable54').val();
        var addr = $('#inptarchiveTable55').val();

//        var reason=$('#selrigForm6').val();
//        var work_view=$('#selrigForm7').val();
//
//        var detail_inf=$('#inptarchiveTable58').val();
//        var people=$('#inptarchiveTable59').val();
//        var time_loc=$('#inptarchiveTable510').val();
//        var time_likv=$('#inptarchiveTable511').val();

//alert(reason);
//alert(detail_inf);


        if (id_rig === '' || id_rig === undefined)
            id_rig = 'no';
        if (date_msg === '' || date_msg === undefined)
            date_msg = 'no';
        if (time_msg === '' || time_msg === undefined)
            time_msg = 'no';
        if (local === '' || local === undefined)
            local = 'no';
        if (addr === '' || addr === undefined)
            addr = 'no';

//         if(reason === '' || reason === undefined)
//            reason='no';
//         if(work_view === '' || work_view === undefined)
//            work_view='no';
//
//
//         if(detail_inf === '' || detail_inf === undefined)
//            detail_inf='no';
//         if(people === '' || people === undefined)
//            people='no';
//         if(time_loc === '' || time_loc === undefined)
//            time_loc='no';
//         if(time_likv === '' || time_likv === undefined)
//            time_likv='no';




        var link_to_excel = id_rig + '/' + date_msg + '/' + time_msg + '/' + local + '/' + addr;
        var prev_link_to_excel = $('#prev_link_to_excel').val();

        var new_link_to_excel = prev_link_to_excel + '/' + link_to_excel;
//  alert(new_link_to_excel);

        $('#link_to_excel').attr("href", new_link_to_excel);

    }


    function keyupField() {
        // Allow controls such as backspace, tab etc.
//  var arr = [8,9,35,36,37,38,39,40,45,46,47,48,49,50,51,52,53,54,55,56,57,97,98,99,100,101,102,103,104,105,186,188,190,219,221,222];
        var arr = [8, 9, 35, 36, 37, 38, 39, 40, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 97, 98, 99, 100, 101, 102, 103, 104, 105, 186, 188, 190, 219, 221, 222, 111, 187, 189, 191, 220, 226];

// Allow letters
        for (var i = 65; i <= 90; i++) {
            arr.push(i);
        }
//alert(event.which);
        if (jQuery.inArray(event.which, arr) !== -1) {

//alert('aaa');
            changeLinkExcel();
        }
    }

</script>
