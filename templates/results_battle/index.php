
<div class="box-body">
    <form  role="form" id="resultsBattleForm" method="POST" action="<?= $baseUrl ?>/results_battle/<?=$id_rig ?>" >

        <ul class="nav nav-tabs">
            <li class="active">
                <a  href="#1" data-toggle="tab">Результаты боевой работы</a>
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


                    <input type="hidden" class="form-control"  name="id_battle" value="<?= (isset($id_battle) && !empty($id_battle)) ? $id_battle : 0  ?>" >

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="dead_man_l">Погибло</label>
                            <input type="text" class="form-control" placeholder="0" name="dead_man" value="<?= (isset($battle['dead_man'])) ? $battle['dead_man'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="save_man_l">Спасено</label>
                            <input type="text" class="form-control" placeholder="0" name="save_man" value="<?= (isset($battle['save_man'])) ? $battle['save_man'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="inj_man_l">Травмировано</label>
                            <input type="text" class="form-control" placeholder="0" name="inj_man" value="<?= (isset($battle['inj_man'])) ? $battle['inj_man'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="ev_man_l">Эвакуировано</label>
                            <input type="text" class="form-control" placeholder="0" name="ev_man" value="<?= (isset($battle['ev_man'])) ? $battle['ev_man'] : 0 ?>" >
                        </div>
                    </div>


                     <div class="col-lg-3">

                    </div>

                    <div class="col-lg-2">
                        <div class="box-body">
                            <button type="submit" class="btn-save-rig">  <div class="i2Style">Сохранить данные</div></button>
                        </div>    </div>


                </div>


                <p class="line"><span>Строения</span></p>
                <!--<center><span class="name-part-of-rig-form">Причины</span></center>-->

                <div class="row">

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="dam_build_l">Спасено</label>
                            <input type="text" class="form-control" placeholder="0" name="save_build" value="<?= (isset($battle['save_build'])) ? $battle['save_build'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="dam_build_l">Повреждено</label>
                            <input type="text" class="form-control" placeholder="0" name="dam_build" value="<?= (isset($battle['dam_build'])) ? $battle['dam_build'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="des_build_l">Уничтожено</label>
                            <input type="text" class="form-control" placeholder="0" name="des_build" value="<?= (isset($battle['des_build'])) ? $battle['des_build'] : 0 ?>" >
                        </div>
                    </div>




                </div>

                <p class="line"><span>Техника</span></p>
<!--<center><span class="name-part-of-rig-form">Причины</span></center>-->

                <div class="row">

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="save_teh_l">Спасено</label>
                            <input type="text" class="form-control" placeholder="0" name="save_teh" value="<?= (isset($battle['save_teh'])) ? $battle['save_teh'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="dam_teh_l">Повреждено</label>
                            <input type="text" class="form-control" placeholder="0" name="dam_teh" value="<?= (isset($battle['dam_teh'])) ? $battle['dam_teh'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="des_teh_l">Уничтожено</label>
                            <input type="text" class="form-control" placeholder="0" name="des_teh" value="<?= (isset($battle['des_teh'])) ? $battle['des_teh'] : 0 ?>" >
                        </div>
                    </div>



                </div>


                <p class="line"><span>Животные</span></p>
<!--<center><span class="name-part-of-rig-form">Причины</span></center>-->

                <div class="row">

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="save_an_l">Спасено (голов скота)</label>
                            <input type="text" class="form-control" placeholder="0" name="save_an" value="<?= (isset($battle['save_an'])) ? $battle['save_an'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="dam_an_l">Повреждено (голов скота)</label>
                            <input type="text" class="form-control" placeholder="0" name="dam_an" value="<?= (isset($battle['dam_an'])) ? $battle['dam_an'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="des_an_l">Уничтожено (голов скота)</label>
                            <input type="text" class="form-control" placeholder="0" name="des_an" value="<?= (isset($battle['des_an'])) ? $battle['des_an'] : 0 ?>" >
                        </div>
                    </div>




                </div>

                <p class="line"><span>Корма и технические культуры</span></p>
<!--<center><span class="name-part-of-rig-form">Причины</span></center>-->

                <div class="row">

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="save_plan_l">Спасено (тонн)</label>
                            <input type="text" class="form-control" placeholder="0" name="save_plan" value="<?= (isset($battle['save_plan'])) ? $battle['save_plan'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="dam_plan_l">Повреждено (тонн)</label>
                            <input type="text" class="form-control" placeholder="0" name="dam_plan" value="<?= (isset($battle['dam_plan'])) ? $battle['dam_plan'] : 0 ?>" >
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="des_plan_l">Уничтожено (тонн)</label>
                            <input type="text" class="form-control" placeholder="0" name="des_plan" value="<?= (isset($battle['des_plan'])) ? $battle['des_plan'] : 0 ?>" >
                        </div>
                    </div>




                </div>





            </div>

        </div>
        <!--                    tab-content-->

    </form>
</div>


<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?= $baseUrl ?>/assets/toastr/js/toastr.min.js"></script>
<script>

 if(<?= $is_success ?> === 1)
        toastr.success('Информация сохранена', 'Успех!', {progressBar:     true,timeOut: 5000});
</script>




