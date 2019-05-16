<!--выгрузка данных в переменные-->
<?php

//print_r($time_character);
if(isset($time_character) && !empty($time_character)){

        $time_loc=$time_character['time_loc'];
        $time_likv=$time_character['time_likv'];

        $is_close=$time_character['is_close'];
        $is_likv_before_arrival=$time_character['is_likv_before_arrival'];

}
else{
    $time_loc=NULL;
    $time_likv=NULL;
}

?>
<!-- КОНЕЦ выгрузка данных в переменные-->
<br>
<div class="box-body">

    <form  role="form" id="characterForm" method="POST" action="<?= $baseUrl ?>/rig/<?= $id ?>/character">

        <p class="line"><span>Временные характеристики по вызову</span></p>

        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="time_loc">Дата и время локализации</label>
                    <div class="input-group date" id="time_loc">
                        <?php
                              if (isset($time_loc) && $time_loc != '0000-00-00 00:00:00' && $time_loc!=NULL) {
                                  ?>
                        <input type="text" class="form-control datetime"  name="time_loc"  value="<?= $time_loc ?>"/>

                        <?php
                              }
                              else{
                                  ?>
                            <input type="text" class="form-control datetime"  name="time_loc" />
                        <?php
                              }
                        ?>

                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
                      <div class="col-lg-2">
                <div class="form-group">
                    <label for="time_likv">Дата и время ликвидации</label>
                    <div class="input-group date" id="time_likv">
                            <?php
                              if (isset($time_likv) && $time_likv != '0000-00-00 00:00:00' && $time_likv!=NULL) {
                                  ?>
                        <input type="text" class="form-control datetime"  name="time_likv"  value="<?= $time_likv ?>"/>

                        <?php
                              }
                              else{
                                  ?>
                       <input type="text" class="form-control datetime"  name="time_likv" />
                        <?php
                              }
                        ?>

                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>


            <div class="col-lg-2">
                   <br>
                <div class="form-group">
                    <div class="checkbox checkbox-success">
                      <?php
                              if (isset($is_close) && $is_close == 1 ) {
                                  ?>
                            <input id="checkbox0" type="checkbox" name="is_close" value="1" checked="" >
                            <?php
                        } else {
                            ?>
                            <input id="checkbox0" type="checkbox" name="is_close" value="1" >
                            <?php
                        }
                        ?>
                        <label for="checkbox0">
                            Не учитывать даты
                        </label>
                    </div>
                </div>
            </div>



            <div class="col-lg-2">
                   <br>
                <div class="form-group">
                    <div class="checkbox checkbox-info">
                      <?php
                              if (isset($is_likv_before_arrival) && $is_likv_before_arrival == 1) {
                                  ?>
                            <input id="checkbox01" type="checkbox" name="is_likv_before_arrival" value="1" checked="" >
                            <?php
                        } else {
                            ?>
                            <input id="checkbox01" type="checkbox" name="is_likv_before_arrival" value="1" >
                            <?php
                        }
                        ?>
                        <label for="checkbox01">
                            Ликвидация до прибытия
                        </label>
                    </div>
                </div>
            </div>

<!--            <div class="col-lg-2"></div>-->


<?php
if ($id_user_rig == $_SESSION['id_user']) {

    ?>
    <div class="col-lg-2">
        <?php
        include dirname(dirname(__FILE__)) . '/tabsRig/buttonSaveRig.php';

        ?>
    </div>
    <?php
} else {

    include dirname(dirname(__FILE__)) . '/tabsRig/infoMsg.php';
}

?>

        </div>


        <p class="line"><span>Журнал выезда</span></p>
        <?php
        /*---------------------------- инф по СиС МЧС-временные характеристики -------------------------*/
                 include dirname(__FILE__) . '/car.php';
        ?>


    </form>
</div>