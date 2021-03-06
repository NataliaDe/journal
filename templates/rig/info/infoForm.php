<br>
 <?php
    if(isset($is_update_now) && !empty($is_update_now) && (isset($settings_user['update_rig_now']) && $settings_user['update_rig_now']['name_sign'] == 'yes')){
           include dirname(dirname(__FILE__)) . '/tabsRig/info_msg_now_update.php';
    }

	include dirname(dirname(__FILE__)) . '/title_block.php';
    ?>
<div class="box-body">
    <p class="line"><span>Информирование</span></p>
    <?php
    $k = 6; //начало для новых лиц
    $j = 2; //блок  состоит из  3 единиц, шаг
    ?>

    <form  role="form" id="infoForm" method="POST" action="<?= $baseUrl ?>/rig/<?= $id_rig ?>/info">

        <div class="row">
            <div class="col-lg-2">


                <div class="form-group">
                    <?php
                    include dirname(dirname(__FILE__)) . '/tabsRig/buttonSaveRig.php';
                    ?>

                </div>



            </div>
        </div>


        <div class="row">
            <div class="col-lg-2">

                <div class="form-group">
                    <div class="checkbox checkbox-info">
                        <?php
                        if (isset($is_informing) && $is_informing == 1) {

                            ?>
                            <input id="checkbox3" type="checkbox" name="is_informing" id="is_informing_id" value="1" checked="" onchange="toggleInforming(this);" >
                            <?php
                        } else {

                            ?>
                            <input id="checkbox3" type="checkbox" name="is_informing" id="is_informing_id" value="1" onchange="toggleInforming(this);" >
                            <?php
                        }

                        ?>
                        <label for="checkbox3">
                            не выезжали
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <?php
        /* ----------- Редактируемые адресаты ------------------------- */
        if (isset($informing_by_rig) && !empty($informing_by_rig)) {
            $i = 0;
           // print_r($informing_by_rig);
            foreach ($informing_by_rig as $value) {
                $id_level=$value['id_level_created'];
                $i++;
?>
              <div class="row">

                    <?php
                    if ($id_level != $_SESSION['id_level']) {

                        ?>
                        <input type="hidden" class="form-control "   name="informing[<?= $i ?>][my]" value="0" />
                        <?php
                    } else {

                        ?>
                        <input type="hidden" class="form-control "   name="informing[<?= $i ?>][my]" value="1" />
                        <?php
                    }

                    ?>
                    <input type="hidden" class="form-control "   name="informing[<?= $i ?>][id]" value="<?= $value['id'] ?>" />

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="id_destination">Адресат</label>
                            <?php
                            if ($id_level != $_SESSION['id_level']) {

                                ?>
                                <select disabled=""  class=" js-example-basic-single form-control" name="informing[<?= $i ?>][id_destination]"  >


                                    <option value="">Выбрать</option>
                                    <?php
                                    // if ($id_level != $_SESSION['id_level']) {
                                    //  printf("<p><option value='%s' selected ><label>%s (%s)</label></option></p>", $value['id_destination'], $value['fio'], $value['position_name']);
                                    // } else {
                                    foreach ($destinations as $row) {
                                        if ($value['id_destination'] == $row['id_destination']) {
                                            printf("<p><option value='%s' selected ><label>%s (%s)</label></option></p>", $row['id_destination'], $row['fio'], $row['position_name']);
                                        } elseif ($row['is_delete'] != 1) {
                                            printf("<p><option value='%s' ><label>%s (%s)</label></option></p>", $row['id_destination'], $row['fio'], $row['position_name']);
                                        }
                                    }
                                } else {

                                    ?>
                                    <select class=" js-example-basic-single form-control " name="informing[<?= $i ?>][id_destination]"  >


                                                                                <option value="">Выбрать</option>
                                        <?php
                                        // if ($id_level != $_SESSION['id_level']) {
                                        //  printf("<p><option value='%s' selected ><label>%s (%s)</label></option></p>", $value['id_destination'], $value['fio'], $value['position_name']);
                                        // } else {
                                        foreach ($destinationlist as $row) {
                                            if ($value['id_destination'] == $row['id_destination']) {
                                                printf("<p><option value='%s' selected ><label>%s (%s)</label></option></p>", $row['id_destination'], $row['fio'], $row['position_name']);
                                            } elseif ($row['is_delete'] != 1) {
                                                printf("<p><option value='%s' ><label>%s (%s)</label></option></p>", $row['id_destination'], $row['fio'], $row['position_name']);
                                            }
                                        }
                                    }

                                    ?>

                                </select>
                        </div>
                    </div>

                    <div class="col-lg-2" >
                        <div class="form-group">
                            <label for="destination_text<?= $i ?>">Адресат(при отсутствии в списке)</label>
                            <?php
                            if ($id_level != $_SESSION['id_level']) {

                                ?>
                                <input disabled=""  type="text" class="form-control "  name="informing[<?= $i ?>][destination_text]" value="<?= $value['destination_text'] ?>"  >
                                <?php
                            } else {

                                ?>
                                <input type="text" class="form-control "  name="informing[<?= $i ?>][destination_text]" value="<?= $value['destination_text'] ?>"  >
                                <?php
                            }

                            ?>

                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="time_msg<?= $i ?>">Время сообщения о ЧС</label>
                            <div class="input-group date" id="time_msg<?= $i ?>">
                                <?php
                                if (isset($value['time_msg']) && $value['time_msg'] != '0000-00-00 00:00:00') {

                                    if ($id_level != $_SESSION['id_level']) {

                                        ?>
                                        <input disabled=""  type="text" class="form-control datetime "  name="informing[<?= $i ?>][time_msg]" value="<?= date('Y-m-d H:i', strtotime($value['time_msg'])) ?>"  />
                                        <?php
                                    } else {

                                        ?>
                                        <input type="text" class="form-control datetime "  name="informing[<?= $i ?>][time_msg]" value="<?= date('Y-m-d H:i', strtotime($value['time_msg'])) ?>"  />
                                        <?php
                                    }
                                } else {
                                    if ($id_level != $_SESSION['id_level']) {

                                        ?>
                                        <input disabled=""  type="text" class="form-control datetime "  name="informing[<?= $i ?>][time_msg]" />
                                        <?php
                                    } else {

                                        ?>
                                        <input type="text" class="form-control datetime "  name="informing[<?= $i ?>][time_msg]" />
                                        <?php
                                    }
                                }

                                ?>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeMsg(<?= $i ?>);" ></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="time_exit<?= $i ?>">Время выезда</label>
                            <div class="input-group date" id="time_exit<?= $i ?>">
                                <?php
                                if (isset($value['time_exit']) && $value['time_exit'] != '0000-00-00 00:00:00') {

                                    if ($id_level != $_SESSION['id_level']) {

                                        ?>
                                        <input disabled=""  type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_exit]" value="<?= date('Y-m-d H:i', strtotime($value['time_exit'])) ?>" />
                                        <?php
                                    } else {

                                        ?>
                                        <input type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_exit]" value="<?=  date('Y-m-d H:i', strtotime($value['time_exit'])) ?>" />
                                        <?php
                                    }
                                } else {
                                    if ($id_level != $_SESSION['id_level']) {

                                        ?>
                                        <input disabled=""  type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_exit]" />
                                        <?php
                                    } else {

                                        ?>
                                        <input type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_exit]" />
                                        <?php
                                    }
                                }

                                ?>

                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeExit(<?= $i ?>);"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="time_arrival<?= $i ?>">Время прибытия</label>
                            <div class="input-group date" id="time_arrival<?= $i ?>">
                                <?php
                                if (isset($value['time_arrival']) && $value['time_arrival'] != '0000-00-00 00:00:00') {
                                    if ($id_level != $_SESSION['id_level']) {

                                        ?>
                                        <input disabled=""  type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_arrival]" value="<?=  date('Y-m-d H:i', strtotime($value['time_arrival'])) ?>" />
                                        <?php
                                    } else {

                                        ?>
                                        <input type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_arrival]" value="<?= date('Y-m-d H:i', strtotime($value['time_arrival'])) ?>" />
                                        <?php
                                    }
                                } else {
                                    if ($id_level != $_SESSION['id_level']) {

                                        ?>
                                        <input disabled=""  type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_arrival]" />
                                        <?php
                                    } else {

                                        ?>
                                        <input type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_arrival]" />
                                        <?php
                                    }

                                    ?>

                                    <?php
                                }

                                ?>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeArrival(<?= $i ?>);"></span></span>
                            </div>
                        </div>
                    </div>



                </div>
                <?php
                $i+=1;
                $k = $i + 5;
            }
        } else {
            $i = 1;
        }
        /* ----------- КОНЕЦ Редактируемые адресаты ------------------------- */

        $b = 0;
        for ($i = $i; $i <= $k; $i++) {
            $b++;
            ?>
            <div class="row">
                <input type="hidden" class="form-control datetime"  name="informing[<?= $i ?>][id]" value="0" />
				 <input type="hidden" class="form-control "   name="informing[<?= $i ?>][my]" value="1" />
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="id_destination">Адресат</label>
                        <select class=" js-example-basic-single form-control " name="informing[<?= $i ?>][id_destination]"  >

                            <option value="">Выбрать</option>
                            <?php
                            foreach ($destinationlist as $row) {
                                    if ($row['is_delete'] != 1) {
                                        printf("<p><option value='%s' ><label>%s (%s)</label></option></p>", $row['id_destination'], $row['fio'], $row['position_name']);
                                    }
                                }
                                ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="destination_text<?= $i ?>">Адресат(при отсутствии в списке)</label>
                        <input type="text" class="form-control "  name="informing[<?= $i ?>][destination_text]"  >
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="time_msg<?= $i ?>">Время сообщения о ЧС</label>
                        <div class="input-group date" id="time_msg<?= $i ?>">
                            <input type="text" class="form-control datetime "  name="informing[<?= $i ?>][time_msg]" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeMsg(<?= $i ?>);" ></span></span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="time_exit<?= $i ?>">Время выезда</label>
                        <div class="input-group date" id="time_exit<?= $i ?>">
                            <input type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_exit]" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeExit(<?= $i ?>);"></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="time_arrival<?= $i ?>">Время прибытия</label>
                        <div class="input-group date" id="time_arrival<?= $i ?>">
                            <input type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_arrival]" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeArrival(<?= $i ?>);"></span></span>
                        </div>
                    </div>
                </div>


            </div>
            <?php
        }
        $k++;
        ?>


        <!--дополнительно 2 единицы-->
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <button type="button"  id="collapseButtonReport" class="btn btn-info " name="send" data-toggle="collapse" data-target="#collapse2"><i class="fa fa-plus" aria-hidden="true"></i> Добавить адресатов</span></button>
                </div>
            </div>


        </div>

        <div id="collapse2" class="panel-collapse collapse">
            <?php
            for ($i = $k; $i <= ($k + $j); $i++) {
                ?>
                <div class="row">
                    <input type="hidden" class="form-control datetime"  name="informing[<?= $i ?>][id]" value="0" />
					 <input type="hidden" class="form-control "   name="informing[<?= $i ?>][my]" value="1" />
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="id_destination">Адресат</label>
                            <select class=" js-example-basic-single form-control " name="informing[<?= $i ?>][id_destination]"  >

                                <option value="">Выбрать</option>
                                <?php
                                foreach ($destinationlist as $row) {
                                    printf("<p><option value='%s' ><label>%s (%s)</label></option></p>", $row['id_destination'], $row['fio'], $row['position_name']);
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="destination_text<?= $i ?>">Адресат(при отсутствии в списке)</label>
                            <input type="text" class="form-control "  name="informing[<?= $i ?>][destination_text]"  >
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="time_msg<?= $i ?>">Время сообщения о ЧС</label>
                            <div class="input-group date" id="time_msg<?= $i ?>">
                                <input type="text" class="form-control datetime"  name="informing[<?= $i ?>][time_msg]" />
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeMsg(<?= $i ?>);" ></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="time_exit<?= $i ?>">Время выезда</label>
                            <div class="input-group date" id="time_exit<?= $i ?>">
                                <input type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_exit]" />
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeExit(<?= $i ?>);"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="time_arrival<?= $i ?>">Время прибытия</label>
                            <div class="input-group date" id="time_arrival<?= $i ?>">
                                <input type="text" class="form-control datetime informing_select"  name="informing[<?= $i ?>][time_arrival]" />
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeArrival(<?= $i ?>);"></span></span>
                            </div>
                        </div>
                    </div>

                </div>
                <?php
            }
            ?>
        </div>

    </form>
</div>



<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script>

      function toggleInforming(t) {


    if ($(t).prop('checked') === true) {

 $('.informing_select').val('');
 //$('.dest').val('').trigger('change');

        $('.informing_select').attr('disabled', true);
    } else {
        $('.informing_select').removeAttr('disabled');
    }
}



    <?php
    if (isset($is_informing) && $is_informing == 1) {

        ?>

     $('.informing_select').val('');
     //$('.dest').val('').trigger('change');

            $('.informing_select').attr('disabled', true);
        <?php
    }

    ?>
    </script>