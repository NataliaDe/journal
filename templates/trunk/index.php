<link rel="stylesheet" href="<?= $baseUrl ?>/assets/chosen_v1.8.2/chosen.css">

<style>
    #tags_del_trunk_chosen, #id_edit_trunk_chosen{
        width: 50% !important;
    }
</style>

<br>
 <?php
    if(isset($is_update_now) && !empty($is_update_now) && (isset($settings_user['update_rig_now']) && $settings_user['update_rig_now']['name_sign'] == 'yes')){
           include dirname(dirname(__FILE__)) . '/rig/tabsRig/info_msg_now_update.php';
    }
    //print_r($rig_time);
    ?>
<div class="box-body">
    <form  role="form" id="trunkForm" method="POST" action="<?= $baseUrl ?>/trunk/<?= $id_rig ?>" >
        <input type="hidden" class="form-control datetime"  name="id" value="0" />
        <ul class="nav nav-tabs">
            <li class="active">
                <a  href="#1" data-toggle="tab">Подача стволов</a>
            </li>

        </ul>
        <!--------------------------------------------------- содержимое вкладок------------------------------------------>
        <div class="tab-content ">
            <br>
            <!--            Обработка вызова-->
            <div class="tab-pane active" id="1">

                <div class="row">


                    <!-- <div class="col-lg-2">
                        <div class="form-group">
                            <label for="time_msg">Дата и время сообщения</label>
                            <div class="input-group date" id="time_msg">
                                <input type="text" class="form-control datetime"  name="time_msg" />

                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    -->
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="s_bef_1">Площадь пожара во время прибытия (кв. м) </label>
                            <input type="text" class="form-control" placeholder="0.00" name="s_bef" value="<?= (isset($rig_time['s_bef'])) ? $rig_time['s_bef'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="s_loc_1">Площадь пожара после локализации (кв. м) </label>
                            <input type="text" class="form-control" placeholder="0.00" name="s_loc" value="<?= (isset($rig_time['s_loc'])) ? $rig_time['s_loc'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-2">

                    </div>

                    <div class="col-lg-2">
                        <div class="box-body">
                            <button type="submit" class="btn-save-rig">  <div class="i2Style">Сохранить данные</div></button>
                        </div>    </div>


                </div>


                <p class="line"><span>Информация по каждой технике</span></p>
                <!--<center><span class="name-part-of-rig-form">Причины</span></center>-->
<!--									<b><span>АЦ 5,0-40(533702) ПАСЧ-8 Минского РОЧС</span></b>
                                                    <br>
                                                    <br>-->
                <!--                                    <div class="row">

                                                          <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="time_pod_l">Время подачи стволов (через запятую)</label>
                                                                <input type="text" class="form-control" placeholder="12-30, 12-38" name="time_pod" value="12-30, 12-38" >
                                                            </div>
                                                        </div>

                                                                                                <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label for="means_l">Средства тушения (кол-во, тип) </label>
                                                                <input type="text" class="form-control" placeholder="1 ств. РСК-50, 3 ств. СПРУ" name="means" value="1 ств. РСК-50, 3 ств. СПРУ" >
                                                            </div>
                                                        </div>

                                                                                                <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label for="water_l">Израсходовано воды/ПО (тонн)</label>
                                                                <input type="text" class="form-control" placeholder="10.0" name="water" value="10.0" >
                                                            </div>
                                                        </div>


                                                    </div>-->


                <?php
//print_r($trunk_edit);
                $i = 0;
                $k = 0;
                if (isset($sily) && !empty($sily)) {
                    foreach ($sily as $row) {
                        $i++;

                        ?>

                        <strong><span class="car-label"><?= $row['mark'] ?> &nbsp;( гос.номер <?= $row['numbsign'] ?>) &nbsp;- &nbsp;<?= $row['locorg_name'] ?>, <?= $row['pasp_name'] ?></span></strong>
                        <br><br>

                        <?php
                        if (isset($trunk_edit[$row['id_teh']]) && !empty($trunk_edit[$row['id_teh']])) {
                            foreach ($trunk_edit[$row['id_teh']] as $tr_edit) {
                                $k++;

                                ?>
                                <div  class="teacher_row_<?= $row['id_teh'] ?>" id="klon<?= $k ?>">
                                    <div class="row" >

                                        <div class="col-lg-2">
                                            <label for="time_pod_l">Время подачи ствола</label>
                                        </div>

                                        <div class="col-lg-3">
                                            <label for="means_l">Средства тушения (кол-во, тип) </label>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="water_l">Израсходовано воды/ПО (тонн)</label>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <input type="hidden" class="form-control"  name="id_car" value="<?= $row['id_teh'] ?>" >
                                        <div class="col-lg-2">

                                           <div class=" times">
                                                <input type="time" name="sily[<?= $row['id_teh'] ?>][time_pod][]" value="<?= $tr_edit['time_pod'] ?>" >
                                            </div>

<!--                                            <div class="form-group">
                                                <input type="text" class="form-control time-pod-mask" placeholder="00-00" onkeypress="allowCntTimePod();" name="sily[<?= $row['id_teh'] ?>][time_pod][]" value="<?= $tr_edit['time_pod'] ?>" >
                                            </div>-->
                                        </div>

                                        <div class="col-lg-1" style="width: 5%">
                                            <div class="form-group">

                                                <input  type="text" class="form-control cnt_means" onkeypress="allowCntMeans();" placeholder="0" name="sily[<?= $row['id_teh'] ?>][means][]" value="<?= $tr_edit['cnt'] ?>" >
                                            </div>

                                        </div>

                                        <div class="col-lg-1" style="padding-top: 6px;     width: auto;">

                                            <span>  ств.</span>


                                        </div>


                                        <div class="col-lg-1"  >

                                            <div class="form-group">
                                                <select class="chzn-select form-control teacher-list_<?= $row['id_teh'] ?> trunk-select-on-form" name="sily[<?= $row['id_teh'] ?>][trunk][]"  tabindex="2" data-placeholder="Выбрать"  >
                                                    <option value='' ><label></label></option>


                                                    <?php
                                                    foreach ($trunk_list as $present) {
                                                        if ($present['id'] == $tr_edit['id_trunk_list']) {
                                                            printf("<p><option value='%s' selected><label>%s</label></option></p>", $present['id'], $present['name']);
                                                        } elseif($present['is_delete'] == 0) {
                                                            printf("<p><option value='%s' ><label>%s</label></option></p>", $present['id'], $present['name']);
                                                        }
                                                    }

                                                    ?>

                                                </select>

                                            </div>


                                        </div>


                                        <div class="col-lg-1" style="padding-top: 6px; ">
                                            <a href="#" class="edit-link"  data-placement="right" title="Добавить новый тип" data-toggle="modal" data-target="#modal-edit-tags" ><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:green"></i></a>
                                        </div>


                                        <div class="col-lg-1">
                                            <div class="form-group">

                                                <input type="text" class="form-control" placeholder="0/0" onkeypress="allowCntWater();" name="sily[<?= $row['id_teh'] ?>][water][]" value="<?= $tr_edit['water'] ?>" >
                                            </div>
                                        </div>
                                        <a href="#" class="del-teacher" style="padding-left: 120px;" data-toggle="tooltip" data-placement="right" title="Удалить строку" data-idcar='<?= $row['id_teh'] ?>' ><i class="fa fa-times" aria-hidden="true" style="color:red"></i></a>

                                    </div>

                                </div>
                                <?php
                            }
                        } else {
                            $k++;

                            ?>
                            <div  class="teacher_row_<?= $row['id_teh'] ?>" id="klon<?= $k ?>">
                                <div class="row" >

                                    <div class="col-lg-2">
                                        <label for="time_pod_l">Время подачи стволов</label>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="means_l">Средства тушения (кол-во, тип) </label>
                                    </div>

                                    <div class="col-lg-2">
                                        <label for="water_l">Израсходовано воды/ПО (тонн)</label>
                                    </div>


                                </div>

                                <div class="row">
                                    <input type="hidden" class="form-control"  name="id_car" value="<?= $row['id_teh'] ?>" >
                                    <div class="col-lg-2">
                                           <div class=" times">
                                                <input type="time" name="sily[<?= $row['id_teh'] ?>][time_pod][]" value="" >
                                            </div>
<!--                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="00-00" onkeypress="allowCntTimePod();" name="sily[<?= $row['id_teh'] ?>][time_pod][]" value="" >
                                        </div>-->
                                    </div>

                                    <div class="col-lg-1" style="width: 5%">
                                        <div class="form-group">

                                            <input  type="text" class="form-control cnt_means" onkeypress="allowCntMeans();" placeholder="0" name="sily[<?= $row['id_teh'] ?>][means][]" value="" >
                                        </div>

                                    </div>

                                    <div class="col-lg-1" style="padding-top: 6px;     width: auto;">

                                        <span>  ств.</span>


                                    </div>


                                    <div class="col-lg-1"  >

                                        <div class="form-group">
                                            <select class="chzn-select form-control teacher-list_<?= $row['id_teh'] ?> trunk-select-on-form" name="sily[<?= $row['id_teh'] ?>][trunk][]"  tabindex="2" data-placeholder="Выбрать"  >
<!--                                                <option value=''  ></option>-->

                                                <?php
                                                foreach ($trunk_list as $present) {

                                                    if($present['is_delete'] == 0) {
                                                    printf("<p><option value='%s' ><label>%s</label></option></p>", $present['id'], $present['name']);
                                                    }
                                                }

                                                ?>

                                            </select>
                                        </div>


                                    </div>

                                    <div class="col-lg-1" style="padding-top: 6px; ">
                                        <a href="#" class="edit-link"  data-placement="right" title="Добавить новый тип" data-toggle="modal" data-target="#modal-edit-tags" ><i class="fa fa-pencil-square-o" aria-hidden="true" style="color:green"></i></a>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">

                                            <input type="text" class="form-control" placeholder="0/0" onkeypress="allowCntWater();" name="sily[<?= $row['id_teh'] ?>][water][]" value="" >
                                        </div>
                                    </div>
                                    <a href="#" class="del-teacher" style="padding-left: 120px;" data-toggle="tooltip" data-placement="right" title="Удалить строку" data-idcar='<?= $row['id_teh'] ?>' ><i class="fa fa-times" aria-hidden="true" style="color:red"></i></a>

                                </div>

                            </div>
            <?php
        }

        ?>



                        <a href="#" id="add_teacher" data-idcar="<?= $row['id_teh'] ?>" >+  добавить еще</a>

                        <hr>
                        <?php
                    }

                    ?>

                    <?php
                } else {

                    ?>
                    <br><br>
                    <strong>Нет данных!</strong> Сначала необходимо выбрать привлекаемые силы и средства МЧС на форме создания выезда.

                    <?php
                }

                ?>

            </div>

        </div>
        <!--                    tab-content-->

    </form>
</div>



   <!-- Modal edit tags-->
    <div class="modal fade" id="modal-edit-tags" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">х</button>
                    <h4 class="modal-title ff-l" id="myModalLabel">Типы стволов</h4>
                </div>
                <div class="modal-body">

<p class="line"><span>Добавление</span></p>

                    <div class="form-group">
                        <h4>Добавить новый тип</h4>
                        <input type="text" class="form-control" placeholder="Введите наименование типа" required="" id='tag_name' >
                        <br>
                        <div class="btn-modal">
                            <button type="button" class="btn btn-bd-primary"  onclick="AddTag();return false;">Добавить</button>
                        </div>
                    </div>


                    <br>
                    <p class="line"><span>Редактирование</span></p>

                     <div class="form-group">
                        <h4>Выберите тип для редактирования</h4>
                        <div class="tags-select">
                            <select class="chzn-select" data-placeholder="Выберите из списка" id='id_edit_trunk' style="width:50%">
                                <option value=''  ></option>
                                <?php
                                foreach ($trunk_for_del as $tr) {


                                        printf("<p><option value='%s' ><label>%s</label></option></p>", $tr['id'], $tr['name']);

                                }

                                ?>
                            </select>
                        </div>
                        <br>
                         <input type="text" class="form-control" placeholder="Введите новое наименование" required="" id='edit_tag_name' >
                         <br>
                        <div class="btn-modal">
                             <button type="button" class="btn btn-bd-primary"  onclick="editTag();return false;">Сохранить изменения</button>
                        </div>
                    </div>
                    <br>
<p class="line"><span>Удаление</span></p>
                                        <div class="form-group">
                        <h4>Выберите тип для удаления</h4>
                        <div class="tags-select">
                            <select class="chzn-select" data-placeholder="Выберите из списка" id='tags_del_trunk' style="width:50%">
                                <option value=''  ></option>
                                <?php
                                foreach ($trunk_for_del as $tr) {


                                        printf("<p><option value='%s' ><label>%s</label></option></p>", $tr['id'], $tr['name']);

                                }

                                ?>
                            </select>
                        </div>
                        <br>
                        <div class="btn-modal">
                            <button type="button" class="btn btn-bd-primary" id='del_tag_btn'>Удалить</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?= $baseUrl ?>/assets/toastr/js/toastr.min.js"></script>

<script>

    if (<?= $is_success ?> === 1)
        toastr.success('Информация сохранена', 'Успех!', {progressBar: true, timeOut: 5000});





</script>




