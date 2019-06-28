<?php
//print_r($sily);
$i=0;
if(isset($sily)&& !empty($sily)){
    foreach ($sily as $row) {
        $i++;


          if (isset($row['is_return']) && $row['is_return'] == 1) {//отбой техники - другим цветом
              ?>
<strong><span class="car-label-return"><?= $row['mark']  ?> &nbsp;( гос.номер <?= $row['numbsign']  ?>) &nbsp;- &nbsp;<?= $row['locorg_name'] ?>, <?= $row['pasp_name'] ?></span></strong>
<?php

          }
          else{
              ?>
<strong><span class="car-label"><?= $row['mark']  ?> &nbsp;( гос.номер <?= $row['numbsign']  ?>) &nbsp;- &nbsp;<?= $row['locorg_name'] ?>, <?= $row['pasp_name'] ?></span></strong>
<?php
          }
        ?>





<div class="row">
    <input type="hidden" class="form-control"  name="id_sily<?= $i ?>" value="<?= $row['id_sily'] ?>">
    <br>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="time_exit<?= $i ?>">Время выезда</label>
            <div class="input-group date" id="time_exit<?= $i ?>">
                   <?php
                              if (isset($row['time_exit'] ) && $row['time_exit']  != '0000-00-00 00:00:00' && $row['time_exit'] !=NULL) {
                                  ?>
                <input type="text" class="form-control datetime"  name="sily[<?= $row['id_sily'] ?>][time_exit]" value="<?= date('Y-m-d H:i', strtotime($row['time_exit'])) ?>" oninput="setTimeFollow(<?= $row['id_sily'] ?>);" onchange="setTimeFollow(<?= $row['id_sily'] ?>);">

                        <?php
                              }
                              else{
                                  ?>
                <input type="text" class="form-control datetime"   name="sily[<?= $row['id_sily'] ?>][time_exit]" oninput="setTimeFollow(<?= $row['id_sily'] ?>);" onchange="setTimeFollow(<?= $row['id_sily'] ?>);"  />
                        <?php
                              }
                        ?>

                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeExit(<?= $i ?>);" ></span></span>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="time_arrival<?= $i ?>">Время прибытия</label>
            <div class="input-group date" id="time_arrival<?= $i ?>">
                                <?php
                              if (isset($row['time_arrival'] ) && $row['time_arrival']  != '0000-00-00 00:00:00' && $row['time_arrival'] !=NULL) {

                                    if (isset($row['is_return']) && $row['is_return'] == 1) {//отбита
                                        ?>
                <input disabled="" type="text" class="form-control datetime"   name="sily[<?= $row['id_sily'] ?>][time_arrival]"  value="<?=  date('Y-m-d H:i', strtotime($row['time_arrival']))  ?>" oninput="setTimeFollow(<?= $row['id_sily'] ?>);"  />
                <?php
                                    }
                                    else{
                                        ?>
                    <input type="text" class="form-control datetime"   name="sily[<?= $row['id_sily'] ?>][time_arrival]"  value="<?=  date('Y-m-d H:i', strtotime($row['time_arrival']))  ?>" oninput="setTimeFollow(<?= $row['id_sily'] ?>);"  />
                  <?php
                                    }

                              }
                              else{
                                     if (isset($row['is_return']) && $row['is_return'] == 1) {//отбита
                                         ?>
                    <input disabled="" type="text" class="form-control datetime"   name="sily[<?= $row['id_sily'] ?>][time_arrival]" oninput="setTimeFollow(<?= $row['id_sily'] ?>);"  />

                    <?php
                                     }
                                     else{
                                         ?>
                     <input type="text" class="form-control datetime"   name="sily[<?= $row['id_sily'] ?>][time_arrival]" oninput="setTimeFollow(<?= $row['id_sily'] ?>);"  />
                    <?php
                                     }

                              }
                        ?>

                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeArrivalMchs(<?= $i ?>,<?= $row['id_sily'] ?>);" ></span></span>
            </div>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="time_follow<?= $i ?>">Время следования</label>


            <?php


                  if (isset($row['is_return']) && $row['is_return'] == 1) {//отбита
                      ?>
            <input disabled="" type="text" class="form-control"  id="time_follow<?= $i ?>" name="sily[<?= $row['id_sily'] ?>][time_follow]"  placeholder="00:00" value="<?=  (empty($row['time_follow'])) ? '00:00' : date('H:i', strtotime($row['time_follow'])) ?>" onfocus="setTimeFollow(<?= $row['id_sily'] ?>);" >
            <?php
                  }
                  else{
                      ?>
             <input type="text" class="form-control"  id="time_follow<?= $i ?>" name="sily[<?= $row['id_sily'] ?>][time_follow]"  placeholder="00:00" value="<?=  (empty($row['time_follow'])) ? '00:00' : date('H:i', strtotime($row['time_follow']))  ?>" onfocus="setTimeFollow(<?= $row['id_sily'] ?>);" >
            <?php
                  }

            ?>

        </div>
    </div>


    <div class="col-lg-2">
                   <br>
                <div class="form-group">
                    <div class="checkbox checkbox-danger">
                      <?php
                              if (isset($row['is_return']) && $row['is_return'] == 1) {
                                  ?>
                        <input id="checkbox<?= $i ?>" type="checkbox" name="sily[<?= $row['id_sily'] ?>][is_return]" value="1" checked="" onchange="setReturnCar(<?= $row['id_sily'] ?>,0);"  >
                            <?php
                        } else {
                            ?>
                            <input id="checkbox<?= $i ?>" type="checkbox" name="sily[<?= $row['id_sily'] ?>][is_return]"  value="1"  onchange="setReturnCar(<?= $row['id_sily'] ?>,1);">
                            <?php
                        }
                        ?>
                        <label for="checkbox<?= $i ?>">
                             <i  class="fa fa-backward" data-toggle="tooltip" data-placement="right" title=" Отбой техники" ></i>

                        </label>

                    </div>



                </div>
            </div>

</div>

<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label for="time_end<?= $i ?>">Время окончания работ</label>
            <div class="input-group date" id="time_end<?= $i ?>">
                    <?php
                              if (isset($row['time_end'] ) && $row['time_end']  != '0000-00-00 00:00:00' && $row['time_end'] !=NULL) {


                  if (isset($row['is_return']) && $row['is_return'] == 1) {//отбита
                      ?>
                <input disabled="" type="text" class="form-control datetime"   name="sily[<?= $row['id_sily'] ?>][time_end]"   value="<?= date('Y-m-d H:i', strtotime($row['time_end']))  ?>"/>
                <?php
                  }
                  else{
                      ?>
                 <input type="text" class="form-control datetime"   name="sily[<?= $row['id_sily'] ?>][time_end]"   value="<?= date('Y-m-d H:i', strtotime($row['time_end'])) ?>"/>
                <?php
                  }

                              }
                              else{

                                    if (isset($row['is_return']) && $row['is_return'] == 1) {//отбита
                                        ?>
                 <input disabled="" type="text" class="form-control datetime"   name="sily[<?= $row['id_sily'] ?>][time_end]" />
                 <?php
                                    }
                                    else{
                                        ?>
                  <input type="text" class="form-control datetime"   name="sily[<?= $row['id_sily'] ?>][time_end]" />
                 <?php
                                    }

                              }
                        ?>

                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeEnd(<?= $i ?>);"></span></span>
            </div>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="time_return<?= $i ?>">Время возвращения</label>
            <div class="input-group date" id="time_return<?= $i ?>">
                    <?php
                              if (isset($row['time_return'] ) && $row['time_return']  != '0000-00-00 00:00:00' && $row['time_return'] !=NULL) {
                                  ?>
                <input type="text" class="form-control datetime"   name="sily[<?= $row['id_sily'] ?>][time_return]"  value="<?=  date('Y-m-d H:i', strtotime($row['time_return']))?>" />

                        <?php
                              }
                              else{
                                  ?>
                <input type="text" class="form-control datetime"  name="sily[<?= $row['id_sily'] ?>][time_return]"  />
                        <?php
                              }
                        ?>

                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" onclick="getTimeReturn(<?= $i ?>);"></span></span>
            </div>
        </div>
    </div>


    <div class="col-lg-2">
        <div class="form-group">
            <label for="distance<?= $i ?>">Расстояние, км</label>
            <?php

            if (isset($row['is_return']) && $row['is_return'] == 1) {//отбита
                ?>
            <input disabled="" type="text" class="form-control"   name="sily[<?= $row['id_sily'] ?>][distance]"  placeholder="км"  value="<?= $row['distance']  ?>">
            <?php
            }
            else{
                ?>
              <input type="text" class="form-control"   name="sily[<?= $row['id_sily'] ?>][distance]"  placeholder="км"  value="<?= $row['distance']  ?>">
            <?php
            }
            ?>

        </div>
    </div>
</div>
<hr>
<?php
    }
    ?>

<?php
}
 else {
?>
<br><br>
   <strong>Нет данных!</strong> Сначала необходимо выбрать привлекаемые силы и средства МЧС на форме создания выезда.

<?php
}

