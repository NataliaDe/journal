
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];
?>
<br>
<center><b>Форма для журнала регистрации поступающих сообщений в ЦОУ Г(Р)ОЧС (ПСЧ)</b></center>

<br><br>
    <form  role="form" class="form-inline" name="rep1Form" id="rep1Form" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">


    <div class="row" style="padding-left: 20px">
        <div class="form-group " style="    border: solid 1px #f39c12;
             padding-top: 10px;
             padding-bottom: 10px;
             padding-right: 0px;
             padding-left: 10px;
             position: inherit;">

            <div class="material-switch pull-right" style="padding-right: 20px;">
                <span style="padding-right: 5px; font-weight: 600" data-toggle="tooltip" data-placement="right"
                      title="Отчет будет сформирован по месту выезда. Область, район в данном случае означают - куда был совершен выезд.">
                    По месту выезда</span>
                <input id="someSwitchOptionWarning" name="is_switch_by_podr" type="checkbox"  onchange="changeModeRep1(this)" value="1"
                       data-link="<?= $baseUrl ?>/change_mode" data-podr-descr="Отчет будет сформирован по подразделению. Область, район в данном случае означают - откуда был совершен выезд техники."
                       data-place-descr="Отчет будет сформирован по месту выезда. Область, район в данном случае означают - куда был совершен выезд.">
                <label for="someSwitchOptionWarning" class="label-warning"></label>
                <span style="padding-left: 5px; font-weight: 600" data-toggle="tooltip" data-placement="right"
                      title="Отчет будет сформирован по подразделению. Область, район в данном случае означают - откуда был совершен выезд техники.">
                    По технике подразделения</span>
            </div>
        </div>


        <!--        <div class="form-group" id="block-mode-rep1-descr">
                    Отчет будет сформирован по месту выезда. Область, район в данном случае означают - куда был совершен выезд.
                </div>-->

        <br><br><br>
    </div>


	 <div class="row" style="padding-left: 20px">
                <div class="form-group">
                    <label for="date_start" >с</label>
                    <div class="input-group date" id="date_start">
                        <?php
                              if (isset($_POST['date_start']) && $_POST['date_start'] != '0000-00-00 00:00:00' && $_POST['date_start'] != NULL) {
                                  ?>
                        <input type="text" class="form-control datetime"  name="date_start"  value="<?= $_POST['date_start'] ?>"/>

                        <?php
                              }
                              else{
                                  ?>
                            <input type="text" class="form-control datetime"  name="date_start" />
                        <?php
                              }
                        ?>

                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>


                <div class="form-group">
                    <label for="date_end">&nbsp;по</label>
                    <div class="input-group date" id="date_end">
                            <?php
                              if (isset($_POST['date_end']) && $_POST['date_end'] != '0000-00-00 00:00:00' && $_POST['date_end'] !=NULL) {
                                  ?>
                        <input type="text" class="form-control datetime"  name="date_end"  value="<?= $_POST['date_end'] ?>"/>

                        <?php
                              }
                              else{
                                  ?>
                       <input type="text" class="form-control datetime"  name="date_end" />
                        <?php
                              }
                        ?>

                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>


        <div class="form-group">
                    <label for="id_region">Область</label>
                    <select class="form-control" name="id_region" id="id_region"  >
   <?php
   if($_SESSION['id_level'] == 1){
       ?>
<!--                        <option value="">все</option>              -->
                        <?php
   }
                        foreach ($region as $re) {
                            if ( $re['id'] == $_SESSION['id_region'] && $_SESSION['id_level'] != 1) {
                                printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                            } elseif($_SESSION['id_level']==1) {
                                printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_local">Район</label>
                    <select class="form-control" name="id_local" id="auto_local"  >
                        <option value="">Все</option>
                        <?php

                        foreach ($local as $row) {
                            if ( $row['id'] == $_SESSION['id_local']  && $_SESSION['id_level'] != 1) {
                                printf("<p><option value='%s' class='%s'  selected ><label>%s</label></option></p>", $row['id'],$row['id_region'], $row['name']);
                            } else {
                                printf("<p><option value='%s'   class='%s' ><label>%s</label></option></p>", $row['id'],$row['id_region'], $row['name']);
                            }
                        }
                        ?>
                    </select>
                </div>



        <div class="form-group">
            <label for="reasonrig">Причина вызова</label>
            <select class=" chosen-select-deselect-single form-control" data-placeholder="Не выбрана"  name="reasonrig[]" multiple=""  >
                <!--                <option value="">Причина вызова</option>-->
                <?php
                foreach ($reasonrig as $row) {

                    if ($row['id'] != 0)
                        printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
                }

                ?>
            </select>
        </div>




        <div class="form-group">
            <label for="status_teh">Статус техники</label>
            <select class=" chosen-select-deselect-single form-control" data-placeholder="Все"  name="status_teh[]" multiple=""  >
                    <option value="1">боевая</option>
                    <option value="2">резерв</option>
                     <option value="3">ремонт</option>
                    <option value="4">ТО-1</option>
                    <option value="5">ТО-2</option>


            </select>
        </div>

        <div class="form-group">
            <button class="btn bg-purple" type="submit"   >Сформировать</button>
        </div>
</div>


        <br> <br>
        <div class="row">

            <div class="form-group" id="div_is_pasp" style="display: none">
                <div class="checkbox checkbox-danger">
                    <?php
                    if (!isset($_POST['is_pasp']) || $_POST['is_pasp'] == 0) {

                        ?>
                        <input id="checkbox3" type="checkbox" name="is_pasp" value="1"  >
                        <?php
                    } else {

                        ?>
                        <input id="checkbox3" type="checkbox" name="is_pasp" value="1"  checked="" >
                        <?php
                    }

                    ?>
                    <label for="checkbox3">
                        из указанных подразделений
                    </label>
                </div>
            </div>
            <div class="form-group" id="div_id_pasp" style="display: none">
                <select class="chosen-select-deselect form-control" name="id_pasp[]" id="id_pasp"  multiple tabindex="4" data-placeholder="Подразделение" >


                </select>
            </div>

        </div>

 <div class="row">
<div class="form-group" data-toggle="tooltip" data-placement="right" id="lable-for-neighbor"
             title="Будут отображены все выезды в указанную область и(или) район.">
            <div class="checkbox checkbox-success">
                <?php
                if (!isset($_POST['is_neighbor']) || $_POST['is_neighbor'] == 0) {

                    ?>
                    <input id="checkbox2" type="checkbox" data-neighbor-descr="Будут отображены все выезды в указанную область и(или) район."
                           data-not-neighbor-descr="Будут отображены выезды в указанную область и(или) район, которые создал указанный область и(или) район."
                           name="is_neighbor" value="1" checked="" onchange="changeNeighborRep1(this);" >
                           <?php
                       } else {

                           ?>
                    <input id="checkbox2" type="checkbox" data-neighbor-descr="Будут отображены все выезды в указанную область и(или) район."
                           data-not-neighbor-descr="Будут отображены выезды в указанную область и(или) район, которые создал указанный область и(или) район."
                           name="is_neighbor" value="1" onchange="changeNeighborRep1(this);" >
                           <?php
                       }

                       ?>
                <label for="checkbox2" style="font-weight: 600">
                    Учесть выезды в соседний гарнизон
                </label>
            </div>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


</div>






    </form>
<br><br>

<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i> -
в соответствии с формой 2 Приложения 5 к Уставу службы органов и подразделений по чрезвычайным ситуациям Республики Беларусь.
<br>
<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i><span style="color: red"> -
    рекомендуем строить отчет за период не больше 1 недели в связи с большим объемом данных.</span>




<br>
<?php
include dirname(dirname(__FILE__)).'/bokk/form.php';

?>