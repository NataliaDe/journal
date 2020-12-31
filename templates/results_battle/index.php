<br>
<style>
.li-tabs{
	border: 1px solid #bcc4c7;
	border-radius: 4px 4px 0 0;
}

    .fire{
        border: 2px solid red;
    }


    .checkbox label.label-fire::before {
        border: 2px solid red !important;
    }

</style>
 <?php
    if(isset($is_update_now) && !empty($is_update_now) && (isset($settings_user['update_rig_now']) && $settings_user['update_rig_now']['name_sign'] == 'yes')){
           include dirname(dirname(__FILE__)) . '/rig/tabsRig/info_msg_now_update.php';
    }


	    include dirname(dirname(__FILE__)) . '/rig/title_block.php';
    ?>
<div class="box-body">



    <ul class="nav nav-tabs">
        <?php
        if ($active_tab == 1) {

            ?>
            <li class="active li-tabs" >
                <?php
            } else {

                ?>
            <li class="li-tabs">
                <?php
            }

            ?>
            <a  href="#1" data-toggle="tab">Результаты боевой работы</a>
        </li>

                <?php
        if ($active_tab == 2) {

            ?>
            <li class="active">
                <?php
            } else {

                ?>
            <li class="li-tabs">
                <?php
            }

            ?>
            <a  href="#2" data-toggle="tab">Раздел 1. Боевая работа по ликвидации пожаров</a>
        </li>



        <?php
        if ($active_tab == 3) {

            ?>
            <li class="active">
                <?php
            } else {

                ?>
            <li class="li-tabs">
                <?php
            }

            ?>
            <a  href="#3" data-toggle="tab">Раздел 2. Боевая работа по ликвидации ЧС</a>
        </li>



        <?php
        if ($active_tab == 4) {

            ?>
            <li class="active">
                <?php
            } else {

                ?>
            <li class="li-tabs">
                <?php
            }

            ?>
            <a  href="#4" data-toggle="tab">Раздел 3-4. Общие сведения и другие выезды</a>
        </li>

    </ul>
        <!--------------------------------------------------- содержимое вкладок------------------------------------------>
        <div class="tab-content ">
            <br>

             <div class="tab-pane <?= ($active_tab == 1) ? 'active': ''?>" id="1">

			<form  role="form" id="resultsBattleForm" method="POST" action="<?= $baseUrl ?>/results_battle/<?=$id_rig ?>" >

			<a href="#" class="validate_href" data-form="resultsBattleForm" data-toggle="modal"  data-target="#validate_modal"></a>

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


                    <input type="hidden" class="form-control"  name="id_battle" value="<?= (isset($id_battle) && !empty($id_battle)) ? $id_battle : 0  ?>" >

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="dead_man_l">Погибло</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['dead_man']) || $battle['dead_man'] == 0) ) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="dead_man" value="<?= (isset($battle['dead_man'])) ? $battle['dead_man'] : 0 ?>" >
                        </div>
                    </div>

				     <div class="col-lg-1">
                        <div class="form-group">
                            <label for="dead_child">в т.ч. детей</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['dead_child']) || $battle['dead_child'] == 0) ) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="dead_child" value="<?= (isset($battle['dead_child'])) ? $battle['dead_child'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="save_man_l">Спасено</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['save_man']) || $battle['save_man'] == 0) ) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="save_man" value="<?= (isset($battle['save_man'])) ? $battle['save_man'] : 0 ?>" >
                        </div>
                    </div>


					 <div class="col-lg-1">
                        <div class="form-group">
                            <label for="save_child">в т.ч. детей</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['save_child']) || $battle['save_child'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="save_child" value="<?= (isset($battle['save_child'])) ? $battle['save_child'] : 0 ?>" >
                        </div>
                    </div>

					<div class="col-lg-2">
                        <div class="form-group">
                            <label for="save_mchs">в т.ч. подразделениями МЧС</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['save_mchs']) || $battle['save_mchs'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="save_mchs" value="<?= (isset($battle['save_mchs'])) ? $battle['save_mchs'] : 0 ?>" >
                        </div>
                    </div>


					<div class="col-lg-2"></div>


                    <div class="col-lg-2">
                        <div class="box-body">
                            <button type="submit" class="btn-save-rig">  <div class="i2Style">Сохранить данные</div></button>
                        </div>    </div>



                </div>


				 <div class="row">

				  <div class="col-lg-1">
                        <div class="form-group">
                            <label for="inj_man_l">Травмировано</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['inj_man']) || $battle['inj_man'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="inj_man" value="<?= (isset($battle['inj_man'])) ? $battle['inj_man'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="ev_man_l">Эвакуировано</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['ev_man']) || $battle['ev_man'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="ev_man" value="<?= (isset($battle['ev_man'])) ? $battle['ev_man'] : 0 ?>" >
                        </div>
                    </div>

					<div class="col-lg-1">
                        <div class="form-group">
                            <label for="ev_child">в т.ч. детей</label>
                           <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['ev_child']) || $battle['ev_child'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="ev_child" value="<?= (isset($battle['ev_child'])) ? $battle['ev_child'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="ev_mchs">в т.ч. подразделениями МЧС</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['ev_mchs']) || $battle['ev_mchs'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="ev_mchs" value="<?= (isset($battle['ev_mchs'])) ? $battle['ev_mchs'] : 0 ?>" >
                        </div>
                    </div>


				  </div>


                <p class="line"><span>Строения</span></p>
                <!--<center><span class="name-part-of-rig-form">Причины</span></center>-->

                <div class="row">

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="dam_build_l">Спасено</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['save_build']) || $battle['save_build'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="save_build" value="<?= (isset($battle['save_build'])) ? $battle['save_build'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="dam_build_l">Повреждено</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['dam_build']) || $battle['dam_build'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="dam_build" value="<?= (isset($battle['dam_build'])) ? $battle['dam_build'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="des_build_l">Уничтожено</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['des_build']) || $battle['des_build'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="des_build" value="<?= (isset($battle['des_build'])) ? $battle['des_build'] : 0 ?>" >
                        </div>
                    </div>




                </div>

                <p class="line"><span>Техника</span></p>
<!--<center><span class="name-part-of-rig-form">Причины</span></center>-->

                <div class="row">

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="save_teh_l">Спасено</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['save_teh']) || $battle['save_teh'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="save_teh" value="<?= (isset($battle['save_teh'])) ? $battle['save_teh'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="dam_teh_l">Повреждено</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['dam_teh']) || $battle['dam_teh'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="dam_teh" value="<?= (isset($battle['dam_teh'])) ? $battle['dam_teh'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="des_teh_l">Уничтожено</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['des_teh']) || $battle['des_teh'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="des_teh" value="<?= (isset($battle['des_teh'])) ? $battle['des_teh'] : 0 ?>" >
                        </div>
                    </div>



                </div>


                <p class="line"><span>Животные</span></p>
<!--<center><span class="name-part-of-rig-form">Причины</span></center>-->

                <div class="row">

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="save_an_l">Спасено (голов скота)</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['save_an']) || $battle['save_an'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="save_an" value="<?= (isset($battle['save_an'])) ? $battle['save_an'] : 0 ?>" >
                        </div>
                    </div>



                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="save_an_mchs">в т.ч. подразделениями МЧС</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['save_an_mchs']) || $battle['save_an_mchs'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="save_an_mchs" value="<?= (isset($battle['save_an_mchs'])) ? $battle['save_an_mchs'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="dam_an_l">Повреждено (голов скота)</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['dam_an']) || $battle['dam_an'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="dam_an" value="<?= (isset($battle['dam_an'])) ? $battle['dam_an'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="des_an_l">Уничтожено (голов скота)</label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['des_an']) || $battle['des_an'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="des_an" value="<?= (isset($battle['des_an'])) ? $battle['des_an'] : 0 ?>" >
                        </div>
                    </div>




                </div>

                <p class="line"><span>Корма и технические культуры</span></p>
<!--<center><span class="name-part-of-rig-form">Причины</span></center>-->

                <div class="row">

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="save_plan_l">Спасено (тонн) <i class="fa fa-info-circle info-decimal" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Разделителем целой и дробной части является ТОЧКА (.)"></i></label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['save_plan']) || $battle['save_plan'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="save_plan" value="<?= (isset($battle['save_plan'])) ? $battle['save_plan'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="dam_plan_l">Повреждено (тонн) <i class="fa fa-info-circle info-decimal" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Разделителем целой и дробной части является ТОЧКА (.)"></i></label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['dam_plan']) || $battle['dam_plan'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="dam_plan" value="<?= (isset($battle['dam_plan'])) ? $battle['dam_plan'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="des_plan_l">Уничтожено (тонн) <i class="fa fa-info-circle info-decimal" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Разделителем целой и дробной части является ТОЧКА (.)"></i></label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['des_plan']) || $battle['des_plan'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="des_plan" value="<?= (isset($battle['des_plan'])) ? $battle['des_plan'] : 0 ?>" >
                        </div>
                    </div>




                </div>




				              <p class="line"><span>Ущерб (прямые потери) и материальные ценности</span></p>
<!--<center><span class="name-part-of-rig-form">Причины</span></center>-->

                <div class="row">

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="dam_money">Ущерб (прямые потери), руб. <i class="fa fa-info-circle info-decimal" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Разделителем целой и дробной части является ТОЧКА (.)"></i></label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['dam_money']) || $battle['dam_money'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="dam_money" value="<?= (isset($battle['dam_money'])) ? $battle['dam_money'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="save_wealth">Спасено мат. ценностей, руб. <i class="fa fa-info-circle info-decimal" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Разделителем целой и дробной части является ТОЧКА (.)"></i></label>
                            <input type="text" class="form-control <?= (isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($battle['save_wealth']) || $battle['save_wealth'] == 0)) ? 'fire' : '' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="save_wealth" value="<?= (isset($battle['save_wealth'])) ? $battle['save_wealth'] : 0 ?>" >
                        </div>
                    </div>


                </div>


    </form>
</div>





        <!--  -------------------------          PART 2 --------------------------------->
        <div class="tab-pane <?= ($active_tab == 2) ? 'active': ''?>" id="2">

            <?php
            include dirname(__FILE__) . '/part_1/part_1.php';

            ?>
        </div>

<!--------------------------------        END PART 1 ----------------------------------------->





        <!--  -------------------------          PART 2 --------------------------------->
        <div class="tab-pane <?= ($active_tab == 3) ? 'active' : '' ?>" id="3">

            <?php
            include dirname(__FILE__) . '/part_2/part_2.php';

            ?>
        </div>

        <!--------------------------------        END PART 2 ----------------------------------------->




        <!--  -------------------------          PART 3 --------------------------------->
        <div class="tab-pane <?= ($active_tab == 4) ? 'active' : '' ?>" id="4">

            <?php
            include dirname(__FILE__) . '/part_3/part_3.php';

            ?>
        </div>

        <!--------------------------------        END PART 3 ----------------------------------------->


    </div>
    <!--                    tab-content-->
</div>


<?php
include 'modals/validate_modal.php';

?>

<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?= $baseUrl ?>/assets/toastr/js/toastr.min.js"></script>
<script>





    $(document).ready(function () {
        $('body').on('change', '#resultsBattleFormPart_1 input[name="alone_otd"]', function (e) {

            e.preventDefault();

            var is_check = $(this).is(":checked");
            var alone_shift = $('#resultsBattleFormPart_1 input[name="alone_shift"]');
            var dop_mes = $('#resultsBattleFormPart_1 input[name="dop_mes"]');
            if (is_check === true) {
                alone_shift.prop('checked', false);
                dop_mes.prop('checked', false);
            } else {

            }
        });
    });


    $(document).ready(function () {
        $('body').on('change', '#resultsBattleFormPart_1 input[name="alone_shift"]', function (e) {

            e.preventDefault();

            var is_check = $(this).is(":checked");
            var alone_otd = $('#resultsBattleFormPart_1 input[name="alone_otd"]');
            var dop_mes = $('#resultsBattleFormPart_1 input[name="dop_mes"]');
            if (is_check === true) {
                alone_otd.prop('checked', false);
                dop_mes.prop('checked', false);
            } else {

            }
        });
    });




    $(document).ready(function () {
        $('body').on('change', '#resultsBattleFormPart_1 input[name="dop_mes"]', function (e) {

            e.preventDefault();

            var is_check = $(this).is(":checked");
            var alone_shift = $('#resultsBattleFormPart_1 input[name="alone_shift"]');
            var alone_otd = $('#resultsBattleFormPart_1 input[name="alone_otd"]');
            if (is_check === true) {
                alone_shift.prop('checked', false);
                alone_otd.prop('checked', false);
            } else {

            }
        });
    });





    $(document).ready(function () {
        $('body').on('change', '#resultsBattleFormPart_1 input[name="one_gdzs"]', function (e) {

            e.preventDefault();

            var is_check = $(this).is(":checked");
            var many_gdzs = $('#resultsBattleFormPart_1 input[name="many_gdzs"]');
            if (is_check === true) {
                many_gdzs.prop('checked', false);
            } else {

            }
        });
    });


    $(document).ready(function () {
        $('body').on('change', '#resultsBattleFormPart_1 input[name="many_gdzs"]', function (e) {

            e.preventDefault();

            var is_check = $(this).is(":checked");
            var one_gdzs = $('#resultsBattleFormPart_1 input[name="one_gdzs"]');
            if (is_check === true) {
                one_gdzs.prop('checked', false);
            } else {

            }
        });
    });

 if(<?= $is_success ?> === 1)
        toastr.success('Информация текущей вкладки сохранена.', 'Успех!', {progressBar:     true,timeOut: 5000});







	$('form#resultsBattleForm').on('submit', function (e) {
        e.preventDefault();
        var form = $('form#resultsBattleForm');
        var name_form = 'resultsBattleForm';
        var required = form.find('.required');
        var i = 0;
        $(required).each(function (index, value) {

            if ($(this).val() === 0 || $(this).val() === '' || parseInt($(this).val()) === 0) {
            } else {
                i++;
            }
        });

        if (required.length >0 && i === 0) {
            form.find('.validate_href').click();
            $('#validate_modal #btn_save').attr('data-form', name_form);
        } else {
            form.submit();
        }
    });





    $('form#resultsBattleFormPart_1').on('submit', function (e) {
        e.preventDefault();
        var form = $('form#resultsBattleFormPart_1');
        var name_form = 'resultsBattleFormPart_1';
        var required = form.find('.required');
        var i = 0;
        $(required).each(function (index, value) {

            if ($(this).attr('type') === 'checkbox') {

                if ($(this).is(":checked")) {
                    i++;

                }

            } else {

                if ($(this).val() === 0 || $(this).val() === '' || parseInt($(this).val()) === 0) {
                } else {
                    i++;
                }
            }


        });

        if (required.length >0 && i === 0) {
            form.find('.validate_href').click();
            $('#validate_modal #btn_save').attr('data-form', name_form);
        } else {
            form.submit();
        }
    });






    $('form#resultsBattleFormPart_3').on('submit', function (e) {
        e.preventDefault();
        var form = $('form#resultsBattleFormPart_3');
        var name_form = 'resultsBattleFormPart_3';
        var required = form.find('.required');
        var i = 0;
        $(required).each(function (index, value) {

            if ($(this).attr('type') === 'checkbox') {
                if ($(this).is(":checked")) {
                    i++;
                }
            } else {
                if ($(this).val() === 0 || $(this).val() === '' || parseInt($(this).val()) === 0) {
                } else {
                    i++;
                }
            }
        });

        if (required.length >0 && i === 0) {
            form.find('.validate_href').click();
            $('#validate_modal #btn_save').attr('data-form', name_form);
        } else {
            form.submit();
        }
    });

    $('#validate_modal #btn_save').on('click', function (event) {
        var form = $(this).data('form');
        $('form#' + form).submit();
    });
</script>




