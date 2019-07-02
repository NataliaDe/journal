
<div class="box-body">
    <form  role="form" id="trunkForm" method="POST" action="<?= $baseUrl ?>/trunk/<?=$id_rig ?>" >
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
									<b><span>АЦ 5,0-40(533702) ПАСЧ-8 Минского РОЧС</span></b>
									<br>
									<br>
                                    <div class="row">

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




                                    </div>

									<b><span>АЦ 10,0-40(6317) ПАСЧ-10 Минского РОЧС</span></b>
									<br>
									<br>
                                    <div class="row">

                                          <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="time_pod_l">Время подачи стволов (через запятую)</label>
                                                <input type="text" class="form-control" placeholder="12-30, 12-38" name="time_pod" value="0" >
                                            </div>
                                        </div>

										<div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="means_l">Средства тушения (кол-во, тип) </label>
                                                <input type="text" class="form-control" placeholder="1 ств. РСК-50, 3 ств. СПРУ" name="means" value="0" >
                                            </div>
                                        </div>

										<div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="water_l">Израсходовано воды/ПО (тонн)</label>
                                                <input type="text" class="form-control" placeholder="10.0" name="water" value="0" >
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




