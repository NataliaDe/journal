<?php
include 'form.php';

?>


<link rel="stylesheet" href="<?= $baseUrl ?>/assets/chosen_v1.8.2/chosen.css">

<style>
    #tags_del_trunk_chosen, #id_edit_trunk_chosen{
        width: 50% !important;
    }

    #selsovet-chosen-div chosen-container{
        width: 231px !important;
    }
</style>

<br>

<div class="box-body">

    <form  role="form" id="np_edit_form" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">

        <!--------------------------------------------------- содержимое вкладок------------------------------------------>
        <div class="tab-content ">
            <br>
            <!--            Обработка вызова-->
            <div class="tab-pane active" id="1">



                <p class="line"><span>Нас. пункты с с/с</span></p>
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
                $i = 0;
                $k = 0;

                if (isset($selsovet) && !empty($selsovet)) {
                    foreach ($selsovet as $key => $row) {
                        $i++;

                        ?>

                        <div class="row" >

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <b><?= $row['name'] ?> с/с</b>
                                </div>
                            </div>

                        </div>

                        <?php
                        if (isset($row['locality']) && !empty($row['locality'])) {
                            foreach ($row['locality'] as $loc) {
                                $k++;

                                ?>
                                <div  class="teacher_row_<?= $k ?>" id="klon<?= $k ?>">


                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <input type="text" class="form-control np_name" placeholder="Нас. пункт" name="locality[<?= $k ?>][name]" value="<?= $loc['locality_name'] ?>" >
                                            </div>
                                        </div>

                                        <input type="hidden" class="form-control np_selsovet" placeholder="Нас. пункт" name="locality[<?= $k ?>][id_selsovet]" value="<?= $row['id'] ?>" >


                                        <div class="col-lg-2">
                                            <select class="form-control chzn-select-trunk np_vid teacher-list_<?= $k ?>" name="locality[<?= $k ?>][id_vid]"  tabindex="2" data-placeholder="Вид н.п."  >
                                                <option value='' ><label></label></option>
                                                <?php
                                                foreach ($vid_locality as $vid) {

                                                    ?>
                                                    <option value="<?= $vid['id'] ?>" <?= (isset($loc['vid_id']) && $loc['vid_id'] == $vid['id']) ? 'selected' : '' ?>><?= $vid['name'] ?></option>
                                                    <?php
                                                }

                                                ?>
                                            </select>

                                        </div>

                                        <input type="hidden" class="form-control np_id" name="locality[<?= $k ?>][id]" value="<?= $loc['locality_id'] ?>" >


                                        <div class="col-lg-1" id="" >
                                            <div class="checkbox checkbox-danger">
                                                <input id="checkbox<?= $k ?>" type="checkbox" name="locality[<?= $k ?>][is_delete]" value="1"  >
                                                <label for="checkbox<?= $k ?>">
                                                    удалить
                                                </label>
                                            </div>
                                        </div>



                                    </div>

                                </div>
                                <?php
                            }
                        }

                        ?>



                        <a href="#" id="add_teacher" data-idcar="<?= $k ?>" >+  добавить еще</a>
                        <br> <br>


                        <?php
                    }

                    ?>

                    <?php
                }

                $k = 0;
                if (isset($locality_without_selsovet) && !empty($locality_without_selsovet)) {

                    ?>
                    <p class="line"><span>Нас. пункты без с/с</span></p>
                    <?php
                    foreach ($locality_without_selsovet as $loc) {
                        $k++;

                        ?>

                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input type="text" class="form-control " placeholder="Нас. пункт" name="without_loc[<?= $k ?>][name]" value="<?= $loc['name'] ?>" >
                                </div>
                            </div>




                            <div class="col-lg-2">
                                <select class="form-control chzn-select-without " name="without_loc[<?= $k ?>][id_vid]"  tabindex="2" data-placeholder="Вид н.п."  >
                                    <option value='' ><label></label></option>
                                    <?php
                                    foreach ($vid_locality as $vid) {

                                        ?>
                                        <option value="<?= $vid['id'] ?>" <?= (isset($loc['id_vid']) && $loc['id_vid'] == $vid['id']) ? 'selected' : '' ?>><?= $vid['name'] ?></option>
                                        <?php
                                    }

                                    ?>
                                </select>

                            </div>

                            <input type="hidden" class="form-control" name="without_loc[<?= $k ?>][id]" value="<?= $loc['id'] ?>" >


                            <div class="col-lg-2" id="selsovet-chosen-div">
                                <select class="form-control chzn-select-without " name="without_loc[<?= $k ?>][id_selsovet]"  tabindex="2" data-placeholder="Сельсовет"  >
                                    <option value='' ><label></label></option>
                                    <?php
                                    foreach ($selsovet as $vid) {

                                        ?>
                                        <option value="<?= $vid['id'] ?>" <?= (isset($loc['id_selsovet']) && $loc['id_selsovet'] == $vid['id']) ? 'selected' : '' ?>><?= $vid['name'] ?></option>
                                        <?php
                                    }

                                    ?>
                                </select>

                            </div>


                            <div class="col-lg-1" id="" >
                                <div class="checkbox checkbox-danger">
                                    <input id="checkbox_without_loc<?= $k ?>" type="checkbox" name="without_loc[<?= $k ?>][is_delete]" value="1"  >
                                    <label for="checkbox_without_loc<?= $k ?>">
                                        удалить
                                    </label>
                                </div>
                            </div>



                        </div>
                        <?php
                    }
                }



                // else {

                ?>

                <input type="hidden" class="form-control " name="id_region" value="<?= $_POST['id_region'] ?>" >
                <input type="hidden" class="form-control " name="id_local" value="<?= $_POST['id_local'] ?>" >
                <div class="form-group">
                    <button class="btn bg-success" type="submit" name="save_edit"  >Сохранить</button>
                </div>
                <!--                    <br><br>
                                    <strong>Нет данных!</strong> Сначала необходимо выбрать привлекаемые силы и средства МЧС на форме создания выезда.-->

                <?php
                //}

                ?>

            </div>

        </div>
        <!--                    tab-content-->

    </form>
</div>





<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?= $baseUrl ?>/assets/toastr/js/toastr.min.js"></script>
<script type="text/javascript"  src="<?= $baseUrl ?>/assets/js/jquery.chained.min.js"></script>
<script>

    jQuery("#loc_id_chaned").chained("#reg_id_chaned");



</script>




