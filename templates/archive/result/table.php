<center><u>Запрошены данные:</u><br><br></center>
<?php
if (isset($query_date) && !empty($query_date)) {//запрошены диапазоны
    foreach ($query_date as $row) {
        echo '<center>' . $row['date_start'] . ' - ' . $row['date_end'] . '</center><br>';
    }
} elseif (isset($query_year) && !empty($query_year)) {//запрошен year
    echo '<center>' . $query_year . ' год</center>';
}


if (isset($region_name) && !empty($region_name)) {//запрошен region
    if (isset($local_name) && !empty($local_name)) {//запрошен local
        echo '<center>Область: <b>' . $region_name . '</b>, район: <b>' . $local_name . '</b></center><br>';
    } else {
        echo '<center>Область: <b>' . $region_name . '</b></center><br>';
    }
}
//print_r($result);
//exit();
?>

<div class="noprint" id="conttabl">
    <b> Выберите столбец, чтобы скрыть/отобразить:  </b>
  
    
  
    <b> 
          <a class="toggle-vis" data-column="5" style="background-color: rgb(249, 170, 46);  color: black">Причина</a> -
          <a class="toggle-vis" data-column= "6"  style="background-color:rgb(249, 170, 46); color: black">Детализ. информация</a> - 
        <a class="toggle-vis" data-column= "9"  style="background-color:rgb(249, 170, 46); color: black">Описание</a> -
          <a class="toggle-vis" data-column= "10"  style="background-color:rgb(249, 170, 46); color: black">Причина пожара</a> - 
    <a class="toggle-vis" style="background-color: rgb(249, 170, 46);  color: black" data-column="11">Статус</a> -
    <a class="toggle-vis" style="background-color: rgb(249, 170, 46);  color: black" data-column="12">Инспектор</a>  -
    <a class="toggle-vis" data-column="13" style="background-color: rgb(249, 170, 46);  color: black">Этажность/этаж</a> -
    
    <br>
    
     <a class="toggle-vis" data-column="14" style="background-color: #8dde6c;  color: black">Техника</a> -
     <a class="toggle-vis" data-column="15" style="background-color: #8dde6c;  color: black">Время выезда (техника)</a> -
    <a class="toggle-vis" data-column="16" style="background-color: #8dde6c;  color: black">Время возвращения (техника)</a> -
     <a class="toggle-vis" data-column="17" style="background-color: #8dde6c;  color: black">Время прибытия (техника)</a> -
      <a class="toggle-vis" data-column="18" style="background-color: #8dde6c;  color: black">Время окончания работ (техника)</a> -
       <a class="toggle-vis" data-column="19" style="background-color: #8dde6c;  color: black">Время следования (техника)</a> -
        <a class="toggle-vis" data-column="20" style="background-color: #8dde6c;  color: black">Расстояние (техника)</a> -
        
        <br>
        
             <a class="toggle-vis" data-column="25" style="background-color: #8de7fd;  color: black">Информирование</a> -
      <a class="toggle-vis" data-column="26" style="background-color: #8de7fd;  color: black">Время сообщения (Информирование)</a> -
       <a class="toggle-vis" data-column="27" style="background-color: #8de7fd;  color: black">Время выезда (Информирование)</a> -
        <a class="toggle-vis" data-column="28" style="background-color: #8de7fd;  color: black">Время возвращения (Информирование)</a> -
        
                <br>
        
             <a class="toggle-vis" data-column="21" style="background-color: #fdee8d;  color: black">СиС др. ведомств</a> -
      <a class="toggle-vis" data-column="22" style="background-color: #fdee8d;  color: black">Время сообщения (СиС др. ведомств)</a> -
       <a class="toggle-vis" data-column="23" style="background-color: #fdee8d;  color: black">Время прибытия (СиС др. ведомств)</a> -
        <a class="toggle-vis" data-column="24" style="background-color: #fdee8d;  color: black">Расстояние (СиС др. ведомств)</a> -
    
    </b>

</div>
<br>

<table class="table table-condensed   table-bordered table-custom" id="archive_result_table" >
    <!-- строка 1 -->
    <thead>
        <tr>
            <th>Дата</th>
            <th>Время</th>
            <th>Обл.</th>
            <th>Район</th>
            <th>Адрес</th>
            <th  style="background-color:rgb(249, 170, 46) !important">Причина</th>
            <th style="background-color:rgb(249, 170, 46) !important">Детализ.<br>информация</th>
            <th>Время<br>лок.</th>
            <th>Время<br>ликв.</th>
            <th style="background-color:rgb(249, 170, 46) !important">Описание</th>
            <th style="background-color:rgb(249, 170, 46) !important">Причина<br>пожара</th>
            <th style="background-color:rgb(249, 170, 46)  !important">Статус</th>
            <th style="background-color:rgb(249, 170, 46) !important">Инспектор</th>
            <th style="background-color:rgb(249, 170, 46) !important">Этажн./этаж</th>
            <th style="background-color:#8dde6c !important">Техника</th>
            <th style="background-color:#8dde6c !important">Время выезда</th>
            <th style="background-color:#8dde6c !important">Время возвращ.</th>
            <th style="background-color:#8dde6c !important">Время прибытия</th>
            <th style="background-color:#8dde6c !important">Время окончания работ</th>
            <th style="background-color:#8dde6c !important">Время следования</th>
            <th style="background-color:#8dde6c !important">Расст.,<br>км</th>
            <th style="background-color:#fdee8d !important">СиС др. ведомств</th>
            <th style="background-color:#fdee8d !important">Время сообщ.</th>
            <th style="background-color:#fdee8d !important">Время приб.</th>
            <th style="background-color:#fdee8d !important">Расст., км.<br>Прим.</th>
            <th style="background-color:#8de7fd !important">Информи-<br>рование</th>
            <th style="background-color:#8de7fd !important">Время сообщ.</th>
            <th style="background-color:#8de7fd !important">Время выезда</th>
            <th style="background-color:#8de7fd !important">Время возвращ.</th>
            <th>Заявитель</th>


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
        foreach ($result as $value) {
            foreach ($value as $row) {
                $i = 0;
                ?>
                <tr style="background-color: <?= (isset($statusrig_color[$row['id_statusrig']])) ? $statusrig_color[$row['id_statusrig']] : $row['statusrig_color'] ?>;">
                    <td><?= $row['date_msg'] ?></td> 
                    <td><?= $row['time_msg'] ?></td> 
                    <td><?= $row['region_name'] ?></td> 
                    <td><?= $row['local_name'] ?></td> 


                    <td>
                        <!--                            если адрес пуст-выводим дополнит поле с адресом-->
                        <?=
                        ($row['address'] == NULL ) ? $row['additional_field_address'] : $row['address'];


                        if (!empty($row['object'])) {
                            echo '<br>';
                            echo '(' . $row['object'] . ')';
                        }
                        ?>

                    </td>

                    <td><?= $row['reasonrig_name'] ?></td>


                    <?php
                    $mb_str_len = mb_strlen($row['inf_detail'], 'utf-8');
                    if ($mb_str_len >= 100) {// обрезать текст
                        $locex = mb_substr($row['inf_detail'], 0, 80, 'utf-8');
                        ?>

                        <td  ><span id="archive_sp<?= $i ?>"><?= $locex ?>     <span onclick="see(<?= $i ?>);" data-toggle="collapse" data-target="#collapse<?= $i ?>" style="cursor: pointer" data-toggle="tooltip" data-placement="left" title="Читать далее"><b>...</b></span></span>
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
                    <td><?= $row['time_loc'] ?></td>
                    <td><?= $row['time_likv'] ?></td>

                    <td><?= $row['description'] ?></td>
                    <td><?= $row['firereason_name'] ?></td>
                    <td><?= $row['statusrig_name'] ?></td>
                    <td><?= $row['inspector'] ?></td>
                    <td><?= $row['floor'] ?></td>


                    <!--                      техника МЧС-->


                    <?php
                    if (isset($row['silymchs'])) {
                        ?>
                        <td class="success">
                            <?php
                            $j = 0;
                            foreach ($row['silymchs'] as $silymchs) {
                                $j++;
                                ?>

                                <?php
                                echo $j . '. ' . $silymchs['mark'] . ' ном. ' . $silymchs['numbsign'] . ' ' . $silymchs['locorg_name'] . ' ' . $silymchs['pasp_name'] . ';<br>';
                                echo '<br>';
                                ?>





                                <?php
                            }
                            ?>

                        </td>

                        <!-- время выезда-->
                        <td class="success">
                            <?php
                            $j = 0;
                            foreach ($row['silymchs'] as $silymchs) {
                                $j++;
                                ?>

                                <?php
                                echo $j . '. ' . $silymchs['time_exit'] . ';<br>';
                                echo '<br>';
                                ?>





                <?php
            }
            ?>

                        </td>



                        <!-- время возвращения-->
                        <td class="success">
            <?php
            $j = 0;
            foreach ($row['silymchs'] as $silymchs) {
                $j++;
                ?>

                                <?php
                                echo ((empty($silymchs['time_return'])) ? '' : ($j . '. ' . $silymchs['time_return'] . ';<br>'));
                                echo '<br>';
                                ?>





                <?php
            }
            ?>

                        </td>


                        <!-- время прибытия-->
                        <td class="success">
            <?php
            $j = 0;
            foreach ($row['silymchs'] as $silymchs) {
                $j++;
                ?>

                                <?php
                                echo ((empty($silymchs['time_arrival'])) ? '' : ($j . '. ' . $silymchs['time_arrival'] . ';<br>'));

                                echo '<br>';
                                ?>





                <?php
            }
            ?>

                        </td>


                        <!-- время окончания работ-->
                        <td class="success" >
            <?php
            $j = 0;
            foreach ($row['silymchs'] as $silymchs) {
                $j++;
                ?>

                                <?php
                                echo ((empty($silymchs['time_end'])) ? '' : ($j . '. ' . $silymchs['time_end'] . ';<br>'));
                                echo '<br>';
                                ?>





                                <?php
                            }
                            ?>

                        </td>



                        <!-- время следования-->
                        <td class="success"  >
            <?php
            $j = 0;
            foreach ($row['silymchs'] as $silymchs) {
                $j++;
                ?>

                                <?php
                                echo ((empty($silymchs['time_follow'])) ? '' : ($j . '. ' . $silymchs['time_follow'] . ';<br>'));
                                echo '<br>';
                                ?>



                                <?php
                            }
                            ?>

                        </td>



                        <!-- расстояние-->
                        <td class="success" >
            <?php
            $j = 0;
            foreach ($row['silymchs'] as $silymchs) {
                $j++;
                ?>

                                <?php
                                echo $j . '. ' . $silymchs['distance'] . ' км;' . ( ($silymchs['is_return'] == 1) ? ' отбой' : '') . '<br>';
                                echo '<br>';
                                ?>



                                <?php
                            }
                            ?>

                        </td>


                            <?php
                        } else {
                            ?>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <?php
                    }



//        СиС других ведомств
                    if (isset($row['innerservice'])) {
                        ?>


                        <!-- innerservice-->
                        <td class="warning" >
                        <?php
                        $j = 0;
                        foreach ($row['innerservice'] as $innerservice) {
                            $j++;
                            ?>

                <?php
                echo $j . '. ' . $innerservice['service_name'] . '<br>';
                echo '<br>';
                ?>



                                <?php
                            }
                            ?>

                        </td>



                        <!-- время сообщ-->
                        <td class="warning" >
                            <?php
                            $j = 0;
                            foreach ($row['innerservice'] as $innerservice) {
                                $j++;
                                ?>

                <?php
                echo ((empty($innerservice['time_msg'])) ? '' : ($j . '. ' . $innerservice['time_msg'] . ';<br>'));
                echo '<br>';
                ?>



                                <?php
                            }
                            ?>

                        </td>



                        <!-- время прибытия-->
                        <td class="warning" >
                            <?php
                            $j = 0;
                            foreach ($row['innerservice'] as $innerservice) {
                                $j++;
                                ?>

                <?php
                echo ((empty($innerservice['time_arrival'])) ? '' : ($j . '. ' . $innerservice['time_arrival'] . ';<br>'));
                echo '<br>';
                ?>



                                <?php
                            }
                            ?>

                        </td>



                        <!-- расстояние, примеч-->
                        <td class="warning" >
            <?php
            $j = 0;
            foreach ($row['innerservice'] as $innerservice) {
                $j++;
                ?>

                <?php
                echo ((empty($innerservice['distance'])) ? '' : ($j . '. ' . $innerservice['distance'] . ' км;<br>'));
                echo ((empty($innerservice['note'])) ? '' : ('прим: ' . $innerservice['note'] . ';<br>'));
                echo '<br>';
                ?>



                                <?php
                            }
                            ?>

                        </td>




                            <?php
                        } else {
                            ?>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                            <?php
                        }



//        информирование
                        if (isset($row['informing'])) {
                            ?>

                        <!-- информирование ФИО-->
                        <td class="info" >
            <?php
            $j = 0;
            foreach ($row['informing'] as $informing) {
                $j++;
                ?>

                            <?php
                            echo $j . '. ' . $informing['fio'] . ' (' . $informing['position_name'] . ')' . ';<br>';
                            echo '<br>';
                            ?>



                <?php
            }
            ?>

                        </td>


                        <!-- время сообщ-->
                        <td class="info" >
                            <?php
                            $j = 0;
                            foreach ($row['informing'] as $informing) {
                                $j++;
                                ?>

                <?php
                echo ((empty($informing['time_msg'])) ? '' : ($j . '. ' . $informing['time_msg'] . ';<br>'));
                echo '<br>';
                ?>



                <?php
            }
            ?>

                        </td>


                        <!-- время выезда-->
                        <td class="info" >
                            <?php
                            $j = 0;
                            foreach ($row['informing'] as $informing) {
                                $j++;
                                ?>

                                <?php
                                echo ((empty($informing['time_exit'])) ? '' : ($j . '. ' . $informing['time_exit'] . ';<br>'));
                                echo '<br>';
                                ?>



                                <?php
                            }
                            ?>

                        </td>



                        <!-- время прибытия-->
                        <td class="info" >
                            <?php
                            $j = 0;
                            foreach ($row['informing'] as $informing) {
                                $j++;
                                ?>

                                <?php
                                echo ((empty($informing['time_arrival'])) ? '' : ($j . '. ' . $informing['time_arrival'] . ';<br>'));
                                echo '<br>';
                                ?>



                                <?php
                            }
                            ?>

                        </td>


            <?php
        } else {
            ?>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                            <?php
                        }


                        //заявитель
                        if (isset($row['people'])) {
                            ?>
                        <td class="danger" >
                            <?php
                            $j = 0;

                            $p = ((empty($row['people']['fio'])) ? '' : $row['people']['fio']) . '' . ((empty($row['people']['phone'])) ? '' : (', ' . $row['people']['phone'])) . '' . ((empty($row['people']['address'])) ? '' : (', ' . $row['people']['address'])) . '' . ((empty($row['people']['position'])) ? '' : (', ' . $row['people']['position']));
                            echo $p;
                            ?>
                        </td>
            <?php
        } else {
            ?>
                        <td></td>

                        <?php
                    }
                    ?>




                </tr>
                    <?php
                }
            }
            ?>

    </tbody>
</table>




<center>
    <div class="row">
        <div class="form-group">
            <a onclick="javascript:history.back();">  <button type="button" class="btn btn-warning">Назад</button></a>
        </div>
    </div>
</center>

