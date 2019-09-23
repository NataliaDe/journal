<p class="line"><span>Привлекаемые силы и средства МЧС</span></p>

<div class="row">
<div class="col-lg-2">

                <div class="form-group">
                    <div class="checkbox checkbox-info">
                      <?php
                        if (isset($is_sily_mchs) && $is_sily_mchs == 1) {
                                  ?>
                        <input id="checkbox3" type="checkbox" name="is_sily_mchs" id="is_sily_mchs_id" value="1" checked="" onchange="toggleSilyMchs(this);" >
                            <?php
                        } else {
                            ?>
                            <input id="checkbox3" type="checkbox" name="is_sily_mchs" id="is_sily_mchs_id" value="1" onchange="toggleSilyMchs(this);" >
                            <?php
                        }
                        ?>
                        <label for="checkbox3">
                          Силы МЧС не привлекались
                        </label>
                    </div>
                </div>
            </div>
     </div>

<br>
<?php
//$k = 3; //начало
//$j = 2; //блок техники состоит из  3 единиц, шаг
//$k1 = 3; //начало-для техники из др ведомств
$k = 4; //начало
$j = 3; //блок техники состоит из  3 единиц, шаг
$k1 = 3; //начало-для техники из др ведомств
?>
<!--По умолчанию выводить 3 единицы техники     -->
<div id="div-sily-mchs" >
<?php
/* ------------------------ редактируемые СиС МЧС --------------------------- */
//print_r($silymchs);
if (isset($silymchs) && !empty($silymchs)) {
    $i = 0;
    /*     * ** техника МЧС  на выезде-отметить в списке как (В) *** */
    foreach ($teh_on_rig as $value) {
        $on_rig[] = $value['id_teh'];
    }
    /*     * *** END техника МЧС  на выезде-отметить в списке как (В) **** */

    if (isset($silymchs['delete_teh'])) {
        $delete_teh_by_pasp = $silymchs['delete_teh'];    //вырезать из массива удаленную технику
        unset($silymchs['delete_teh']);
    }


    foreach ($silymchs as $key => $value) {
        $i++;
        ?>
        <div class="row col-color-custom">

            <div class="col-lg-2 ">
                <div class="form-group ">
                    <label for="id_region">Область</label>
                    <select class="form-control sily_select" name="silymchs[<?= $i ?>][id_region]" id="id_region<?= $i ?>" onchange="javascript:clearPasp('silymchs[<?= $i ?>][id_teh][]');" >

                        <option value="">Выбрать</option>
                        <?php
                        foreach ($region as $re) {
                            if ($value['id_region'] == $re['id']) {
                                printf("<p><option selected value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                            } else {
                                printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">

                    <label for="id_locorg">Г(Р)ОЧС</label>
                    <select class="js-example-basic-single form-control sily_select " name="silymchs[<?= $i ?>][id_locorg]" id="id_locorg<?= $i ?>" onchange="javascript:clearPasp('silymchs[<?= $i ?>][id_teh][]');"  >

                        <option value="">Все</option>
                        <?php
                        foreach ($locorg as $lo) {
                            if ($value['id_locorg'] == $lo['id_locorg']) {
                                printf("<p><option value='%s' class='%s' selected ><label>%s</label></option></p>", $lo['id_locorg'], $lo['id_region'], $lo['locorg_name']);
                            } else {
                                printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $lo['id_locorg'], $lo['id_region'], $lo['locorg_name']);
                            }
                        }
                        ?>

                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">

                    <label for="id_pasp">ПАСЧ/ПАСП</label>
                    <select class="js-example-basic-single form-control sily_select" name="silymchs[<?= $i ?>][id_pasp]"  id="id_pasp<?= $i ?>"  onchange="javascript:changePasp(this, 'silymchs[<?= $i ?>][id_teh][]');" >

<!--onchange="javascript:changePasp('silymchs[< $i ?>][id_pasp]', 'silymchs[< $i ?>][id_teh][]');"-->
                        <option value="">Выбрать</option>
                        <?php
                        foreach ($pasp as $row) {
                            if ($key == $row['id']) {
                                printf("<p><option selected value='%s' class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_loc_org'], $row['pasp_name']);
                            } else {
                                printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_loc_org'], $row['pasp_name']);
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="form-group">

                    <label for="id_teh">Выбор техники</label>
                    <select class="js-example-basic-multiple  form-control sily_select" name="silymchs[<?= $i ?>][id_teh][]"  name="id_silymchs[<?= $i ?>]"  multiple="multiple"  >

                        <?php
                        $select_teh = array();
                        /* ------- Вся техника текущего ПАСЧ, которая уже выбрана --------- */
                        foreach ($value['teh'] as $teh) {
                            printf("<p><option selected value='%s'  ><label>%s: %s</label></option></p>", $teh['id_teh'], $teh['mark'], $teh['numbsign']);

                            $select_teh[] = $teh['id_teh'];
                        }
                        /* ------- END Вся техника текущего ПАСЧ, которая уже выбрана --------- */

                        /* ------- Вся техника текущего ПАСЧ --------- */
                        if (isset($value['all_teh']) && !empty($value['all_teh'])) {
                            foreach ($value['all_teh'] as $all_teh) {
                                if (!in_array($all_teh['id_teh'], $select_teh)) {//выбранную технику не отображать повторно
                                    if (in_array($all_teh['id_teh'], $on_rig)) {//если техника на выезде - отметить как (В)
                                        printf("<p><option  value='%s'  ><label>%s: %s (В)</label></option></p>", $all_teh['id_teh'], $all_teh['mark'], $all_teh['numbsign']);
                                    } elseif (in_array($all_teh['id_teh'], $value['reserve_teh'])) {//если техника из др ПАСЧ - пометить как (К)
                                        printf("<p><option  value='%s'  ><label>%s: %s (К)</label></option></p>", $all_teh['id_teh'], $all_teh['mark'], $all_teh['numbsign']);
                                    } else {
                                        printf("<p><option  value='%s'  ><label>%s: %s</label></option></p>", $all_teh['id_teh'], $all_teh['mark'], $all_teh['numbsign']);
                                    }
                                }
                            }
                        }
                        /* ------- END Вся техника текущего ПАСЧ --------- */
                        ?>
                        <!--                    ajax запрос-->
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <?php
                /* ------- Вся техника текущего ПАСЧ, которая была удалена из КУСиС --------- */
                if (!empty($delete_teh_by_pasp)) {
                    if (!empty($delete_teh_by_pasp[$key])) {
                        echo '<br>';
                        ?>
                        <i style="color:red;" class="fa fa-exclamation-circle" data-toggle="tooltip" data-placement="right"

                           title="<?php
                foreach ($delete_teh_by_pasp[$key] as $d) {
                    echo $d['mark'] . ' (' . $d['numbsign'] . '), ';
                }
                        ?> была удалена из карточки учета сил и средств">

                        </i>

                        <?php
                        unset($delete_teh_by_pasp[$key]);
                    }
                }
                /* ------- END Вся техника текущего ПАСЧ, которая была удалена из КУСиС  --------- */
                ?>
            </div>
        </div>

        <?php
    }

    /* ------------------ техника, удаленная из КУСиС и не принадлежащая ни одному из вышеуказанных ПАСЧ -------------------- */
    if (!empty($delete_teh_by_pasp)) {
        ?>
        <div class="row col-color-custom" >
            &nbsp;&nbsp;&nbsp;&nbsp;
            <i style="color:red;" class="fa fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title=" Данная техника была удалена из карточки учета сил и средств" ></i>
            <?php
            foreach ($delete_teh_by_pasp as $k => $d) {
                foreach ($d as $val) {
                    echo $val['mark'] . ' (' . $val['numbsign'] . '), ' . '<br>';
                }
            }
            ?>
            <br>
        </div>
        <?php
    }
    /* ------------------ END техника, удаленная из КУСиС и не принадлежащая ни одному из вышеуказанных ПАСЧ -------------------- */

    $i+=1;
   // $k = $i + 2;
    $k = $i + 3;
} else {
    $i = 1;
}
/* ------------------------ END редактируемые СиС МЧС --------------------------- */
$s = 0;
for ($i = $i; $i <= $k; $i++) {
    $s++;
    ?>
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <label for="id_region">Область</label>
                <select class="form-control sily_select" name="silymchs[<?= $i ?>][id_region]" id="id_region<?= $i ?>" onchange="javascript:clearPasp('silymchs[<?= $i ?>][id_teh][]');"  >

                    <option value="">Выбрать</option>
                    <?php
                    foreach ($region as $re) {
                        if ($_SESSION['id_region'] == $re['id']) {
                            printf("<p><option selected value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                        } else {
                            printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">

                <label for="id_locorg">Г(Р)ОЧС</label>
                <select class="js-example-basic-single form-control sily_select " name="silymchs[<?= $i ?>][id_locorg]" id="id_locorg<?= $i ?>" onchange="javascript:clearPasp('silymchs[<?= $i ?>][id_teh][]');"  >

                    <option value="">Все</option>
    <?php
    foreach ($locorg as $lo) {
        if ($_SESSION['id_level'] == 3 && $_SESSION['id_locorg'] == $lo['id_locorg']) {
            printf("<p><option selected value='%s' class='%s' ><label>%s</label></option></p>", $lo['id_locorg'], $lo['id_region'], $lo['locorg_name']);
        } else {
            printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $lo['id_locorg'], $lo['id_region'], $lo['locorg_name']);
        }
    }
    ?>

                </select>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">

                <label for="id_pasp">ПАСЧ/ПАСП</label>
                <select class="js-example-basic-single form-control sily_select" name="silymchs[<?= $i ?>][id_pasp]"  id="id_pasp<?= $i ?>" onchange="javascript:changePasp(this, 'silymchs[<?= $i ?>][id_teh][]');" >
<!--onchange="javascript:changePasp('silymchs[<?= $i ?>][id_pasp]', 'silymchs[<?= $i ?>][id_teh][]');"-->
  <option value="">Выбрать</option>
<!--                    <option value="">Выбрать</option>-->
    <?php
    foreach ($pasp as $row) {
        printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_loc_org'], $row['pasp_name']);
    }
    ?>
                </select>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="form-group">

                <label for="id_teh">Выбор техники</label>
                <select class="js-example-basic-multiple form-control sily_select" name="silymchs[<?= $i ?>][id_teh][]"  id="id_si<?= $i ?>"   multiple="multiple" >

                    <!--                    ajax запрос-->
                </select>
            </div>
        </div>

    <?php
    if ($s == 1) {
        ?>

            <div class="col-lg-2">
            <?php
            include dirname(__FILE__) . '/buttonSaveRig.php';
            ?>
            </div>
                    <?php
                }
                ?>
    </div>
    <?php
}
$k++;
?>
<!------------------------------------дополнительная техника МЧС ------------------------------------------>
<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <button type="button"  id="collapseButtonReport" class="btn btn-info" name="send" data-toggle="collapse" data-target="#collapseF"><i class="fa fa-plus" aria-hidden="true"></i> Добавить технику</span></button>
        </div>
    </div>
</div>

<div id="collapseF" class="panel-collapse collapse">
<?php
for ($i = $k; $i <= ($k + $j); $i++) {
    ?>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="id_region">Область</label>
                    <select class="form-control sily_select" name="silymchs[<?= $i ?>][id_region]" id="id_region<?= $i ?>" onchange="javascript:clearPasp('silymchs[<?= $i ?>][id_teh][]');"  >

                        <option value="">Выбрать</option>
    <?php
    foreach ($region as $re) {
        if ($_SESSION['id_region'] == $re['id']) {
            printf("<p><option selected value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
        } else {
            printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
        }
    }
    ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">

                    <label for="id_locorg">Г(Р)ОЧС</label>
                    <select class="js-example-basic-single form-control sily_select " name="silymchs[<?= $i ?>][id_locorg]" id="id_locorg<?= $i ?>" onchange="javascript:clearPasp('silymchs[<?= $i ?>][id_teh][]');"  >

                        <option value="">Все</option>
    <?php
    foreach ($locorg as $lo) {
        if ($_SESSION['id_level'] == 3 && $_SESSION['id_locorg'] == $lo['id_locorg']) {
            printf("<p><option selected value='%s' class='%s' ><label>%s</label></option></p>", $lo['id_locorg'], $lo['id_region'], $lo['locorg_name']);
        } else {
            printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $lo['id_locorg'], $lo['id_region'], $lo['locorg_name']);
        }
    }
    ?>

                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">

                    <label for="id_pasp">ПАСЧ/ПАСП</label>
                    <select class="js-example-basic-single form-control sily_select" name="silymchs[<?= $i ?>][id_pasp]"  id="id_pasp<?= $i ?>" onchange="javascript:changePasp(this, 'silymchs[<?= $i ?>][id_teh][]');" >
<!--                        onchange="javascript:changePasp('silymchs[< $i ?>][id_pasp]', 'silymchs[< $i ?>][id_teh][]');"-->


<!--                        <option value="">Выбрать</option>-->
    <?php
    foreach ($pasp as $row) {
        printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_loc_org'], $row['pasp_name']);
    }
    ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="form-group">

                    <label for="id_teh">Выбор техники</label>
                    <select class="js-example-basic-multiple form-control sily_select" name="silymchs[<?= $i ?>][id_teh][]"  multiple="multiple" >

                        <!--                    ajax запрос-->
                    </select>
                </div>
            </div>

        </div>
    <?php
}
?>

</div>
</div>
<br><br>
<span class="glyphicon glyphicon-download-alt" style="color: red;" ></span>&nbsp;&nbsp;
Техника берется из <a  href="/str " target="_blank" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Перейти" style="text-transform: uppercase" >
    <span style="color:red;">строевой записки</span></a>, <b>(К) </b>- техника, заступившая из другого подразделения; <b>&#155; </b>- техника на выезде; <b>(Р) </b>- техника в ремонте;
<!--    <b>(ТО) </b>- техника на ТО;-->
    <b>(Бр) </b>- техника в боевом расчете; <b>(Рез) </b>- техника в резерве.
<br>
<b>*</b>Технику, находящуюся на ТО, можно использовать для высылки.
<br><br><br>
<!------------------------------------------------Привлекаемые силы и средства других ведомств----------------------------------------------------------->
<p class="line"><span>Привлекаемые силы и средства других ведомств</span></p>
<br>
<!--По умолчанию выводить 3 единицы техники     -->
<?php
/* ----------- Редактируемая техника других ведомств ------------------------- */
if (isset($innerservice)) {
    $i = 0;
    foreach ($innerservice as $value) {
        $i++;
        ?>
        <div class="row col-color-custom">

            <input type="hidden" class="form-control datetime"  name="service[<?= $i ?>][id]" value="<?= $value['id'] ?>" />

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="time_msg<?= $i ?>">Время сообщения</label>
                    <div class="input-group date" id="time_msg<?= $i ?>">
        <?php
        if (isset($value['time_msg']) && $value['time_msg'] != '0000-00-00 00:00:00') {
            ?>
                        <input type="text" class="form-control datetime"  name="service[<?= $i ?>][time_msg]" value="<?= date('Y-m-d H:i', strtotime($value['time_msg']))?>" />
            <?php
        } else {
            ?>
                            <input type="text" class="form-control datetime"  name="service[<?= $i ?>][time_msg]" />
                            <?php
                        }
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeMsg(<?= $i ?>);" ></span></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="time_arrival<?= $i ?>">Время прибытия</label>
                    <div class="input-group date" id="time_arrival<?= $i ?>">
        <?php
        if (isset($value['time_arrival']) && $value['time_arrival'] != '0000-00-00 00:00:00') {
            ?>
                            <input type="text" class="form-control datetime"  name="service[<?= $i ?>][time_arrival]" value="<?=  date('Y-m-d H:i', strtotime($value['time_arrival'])) ?>" />
            <?php
        } else {
            ?>
                            <input type="text" class="form-control datetime"  name="service[<?= $i ?>][time_arrival]" />
                            <?php
                        }
                        ?>

                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeArrival(<?= $i ?>);"></span></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="id_service<?= $i ?>">Служба</label>
                    <select class="js-example-basic-single form-control" name="service[<?= $i ?>][id_service]"  >

                        <option value="">Выбрать</option>
        <?php
        foreach ($service as $row) {
            if ($value['id_service'] == $row['id']) {
                printf("<p><option value='%s' selected ><label>%s</label></option></p>", $row['id'], $row['name']);
            } elseif ($row['is_delete'] != 1) {
                printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
            }
        }
        ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="distance<?= $i ?>">Расстояние, км</label>
                    <input type="text" class="form-control" placeholder="км" name="service[<?= $i ?>][distance]" value="<?= $value['distance'] ?>"  >
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="note<?= $i ?>">Примечание</label>
                    <textarea class="form-control" rows="2" cols="22" placeholder="Примечание" name="service[<?= $i ?>][note]"><?= $value['note'] ?></textarea>
                </div>
            </div>


        </div>
        <?php
    }
    $i+=1;
    $k1 = $i + 2;
} else {
    $i = 1;
}

/* ----------- КОНЕЦ Редактируемая техника других ведомств ------------------- */

for ($i = $i; $i <= $k1; $i++) {
    ?>
    <div class="row">

        <input type="hidden" class="form-control datetime"  name="service[<?= $i ?>][id]" value="0" />

        <div class="col-lg-2">
            <div class="form-group">
                <label for="time_msg<?= $i ?>">Время сообщения</label>
                <div class="input-group date" id="time_msg<?= $i ?>">
                    <input type="text" class="form-control datetime"  name="service[<?= $i ?>][time_msg]" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeMsg(<?= $i ?>);" ></span></span>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label for="time_arrival<?= $i ?>">Время прибытия</label>
                <div class="input-group date" id="time_arrival<?= $i ?>">
                    <input type="text" class="form-control datetime"  name="service[<?= $i ?>][time_arrival]" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeArrival(<?= $i ?>);"></span></span>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label for="id_service<?= $i ?>">Служба</label>
                <select class="js-example-basic-single form-control" name="service[<?= $i ?>][id_service]"  >

                    <option value="">Выбрать</option>
    <?php
    foreach ($service as $row) {
        if ($row['is_delete'] != 1)
            printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
    }
    ?>
                </select>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label for="distance<?= $i ?>">Расстояние, км</label>
                <input type="text" class="form-control" placeholder="км" name="service[<?= $i ?>][distance]"  >
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label for="note<?= $i ?>">Примечание</label>
                <textarea class="form-control" rows="2" cols="22" placeholder="Примечание" name="service[<?= $i ?>][note]"></textarea>
            </div>
        </div>


    </div>
    <?php
}
$k1++;
?>
<!--дополнительно 3 ед техники-->
<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <button type="button"  id="collapseButtonReport" class="btn btn-info" name="send" data-toggle="collapse" data-target="#collapse2"><i class="fa fa-plus" aria-hidden="true"></i> Добавить технику</span></button>
        </div>
    </div>
</div>

<div id="collapse2" class="panel-collapse collapse">
<?php
for ($i = $k1; $i <= ($k1 + $j); $i++) {
    ?>
        <div class="row">

            <input type="hidden" class="form-control datetime"  name="service[<?= $i ?>][id]" value="0" />

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="time_msg<?= $i ?>">Время сообщения</label>
                    <div class="input-group date" id="time_msg<?= $i ?>">
                        <input type="text" class="form-control datetime"  name="service[<?= $i ?>][time_msg]" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeMsg(<?= $i ?>);" ></span></span>
                    </div>
                </div>
            </div>


            <div class="col-lg-2">
                <div class="form-group">
                    <label for="time_arrival<?= $i ?>">Время прибытия</label>
                    <div class="input-group date" id="time_arrival<?= $i ?>">
                        <input type="text" class="form-control datetime"  name="service[<?= $i ?>][time_arrival]" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeArrival(<?= $i ?>);" ></span></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="id_service<?= $i ?>">Служба</label>
                    <select class="js-example-basic-single form-control" name="service[<?= $i ?>][id_service]"  >

                        <option value="">Выбрать</option>
    <?php
    foreach ($service as $row) {
        if ($row['is_delete'] != 1)
            printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
    }
    ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="distance<?= $i ?>">Расстояние, км</label>
                    <input type="text" class="form-control" placeholder="км" name="service[<?= $i ?>][distance]"  >
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="note<?= $i ?>">Примечание</label>
                    <textarea class="form-control" rows="2" cols="22" placeholder="Примечание" name="service[<?= $i ?>][note]"></textarea>
                </div>
            </div>

        </div>
    <?php
}
?>

</div>
