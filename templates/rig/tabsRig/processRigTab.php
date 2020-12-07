<style type="text/css">

    #map, .show-map-show {
        position: absolute;
        width: 70%;
        height: 50%;
    }

    .show-map-hide{

        display: none
    }

    /* 	  .leaflet-pane {

        left: 50% !important;
        top: 33% !important;
              } */
</style>

<?php
//print_r($rig);

if (isset($rig) && !empty($rig)) {

    $time_msg = date('Y-m-d H:i', strtotime($rig['time_msg']));
    $description = $rig['description'];
    $id_reasonrig = $rig['id_reasonrig'];
    $id_street = $rig['id_street'];
    $home_number = $rig['home_number'];
    $housing = $rig['housing'];//корпус, кв, подъезд
  //  $apartment = $rig['apartment'];
    $is_opposite = $rig['is_opposite'];
    $id_locality = $rig['id_locality'];
    $id_region = $rig['id_region'];
    $id_local = $rig['id_local'];
    $id_selsovet = $rig['id_selsovet'];
    $longitude = $rig['longitude'];
    $latitude = $rig['latitude'];
    $id_officebelong = $rig['id_officebelong'];
    $additional_field_address = $rig['additional_field_address'];
    $object = $rig['object'];
    $inf_detail = $rig['inf_detail'];
    $id_workview = $rig['id_work_view'];
    $id_firereason = $rig['id_firereason'];
    $firereason_descr = $rig['firereason_descr'];
    $version_reason = $rig['version_reason'];
    $inspector = $rig['inspector'];
    $id_statusrig = $rig['id_statusrig'];
    $is_opg = $rig['is_opg'];
    $opg_text = $rig['opg_text'];
    $id_user=$rig['id_user'];

	$podr_zanytia = $rig['podr_zanytia'];

	$fio_head_check=$rig['fio_head_check'];

    /* ------- выбор вида нас.п. -------- */
	if(isset($locality) && !empty($locality)){
		    foreach ($locality as $l) {
        if ($id_locality == $l['id'])
            $id_locality_vid = $l['id_vid'];
    }
	}


    if (isset($id_locality_vid) && !empty($id_locality_vid)) {
        //echo $id_locality_vid;
        foreach ($vid_locality as $vid_l) {
            if ($vid_l['id'] == $id_locality_vid)
                $vid_of_locality = $vid_l['name'];
        }
    }
    else {
        $vid_of_locality = '';
    }
	$addr_for_map = (isset($bread_crumb_addr) && !empty($bread_crumb_addr)) ? array_pop($bread_crumb_addr) : '';

    /* ------- END выбор вида нас.п. -------- */
} else {
    // $time_msg = $value['time_msg'];
    $description = '';
    $id_reasonrig = 0;
    $id_street = 0;
    $home_number = 0;
    $housing = '';
    $apartment = 0;
    $is_opposite = 0;
    $id_locality = 0;
    $id_region = 0;
    $id_local = 0;
    $id_selsovet = 0;
    $longitude = '';
    $latitude = '';
    $id_officebelong = 0;
    $additional_field_address = '';
    $object = '';
    $inf_detail = '';
    $id_workview = 0;
    $id_firereason = 0;
    $firereason_descr = '';
    $version_reason = '';
    $inspector = '';
    $id_statusrig = 0;
    $is_opg = 0;
    $opg_text = NULL;
    $id_user=$_SESSION['id_user'];

	$podr_zanytia=0;

	$fio_head_check='';


    /* ------- выбор вида нас.п. -------- */
    if (isset($locality) && !empty($locality)) {
        foreach ($locality as $l) {
            if ($_SESSION['auto_locality'] == $l['id'])
                $id_locality_vid = $l['id_vid'];
        }

    }


    if (!empty($id_locality_vid)) {
        //echo $id_locality_vid;
        foreach ($vid_locality as $vid_l) {
            if ($vid_l['id'] == $id_locality_vid)
                $vid_of_locality = $vid_l['name'];
        }
    }
    else {
        $vid_of_locality = '';
    }



    /* ------- END выбор вида нас.п. -------- */
}

if (isset($people) && !empty($people)) {
    $phone = $people['phone'];
    $fio = $people['fio'];
   // $floor_all = $people['floor_all'];
    $floor = $people['floor'];//этажность/этаж
    $address = $people['address'];
    $position = $people['position'];
} else {
    $phone = '';
    $fio = '';
   // $floor_all = '';
    $floor = '';//этажность/этаж
    $address = '';
    $position = '';
}
?>

<div class="row">


    <div class="col-lg-2">
        <div class="form-group">
            <label for="time_msg">Дата и время сообщения</label>
            <div class="input-group date" id="time_msg">
                <?php
                if (isset($time_msg) && $time_msg != '0000-00-00 00:00:00' && $time_msg != NULL) {
                    ?>
                    <input type="text" class="form-control datetime"  name="time_msg" value="<?= $time_msg ?>" />
                    <?php
                } else {
                    ?>
                    <input type="text" class="form-control datetime"  name="time_msg" />
                    <?php
                }
                ?>

                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">

            <label for="phone">Телефон заявителя</label>
            <input type="text" class="form-control" placeholder="Телефон заявителя" name="phone" value="<?= $phone ?>" >
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="fio">Ф.И.О. заявителя</label>
            <input type="text" class="form-control"  placeholder="Ф.И.О." name="fio" value="<?= $fio ?>" >

        </div>
    </div>

    <div class="col-lg-2">
                <?php
            include dirname(__FILE__) . '/buttonSaveRig.php';

            ?>
    </div>



</div>
<style>

</style>


<p class="line"><span>Причины</span></p>
<!--<center><span class="name-part-of-rig-form">Причины</span></center>-->

<div class="row">

    <div class="col-lg-4">
        <div class="form-group">
            <label for="description">Содержание поступившей инф.</label>
            <textarea class="form-control" rows="2" cols="22" placeholder="Содержание поступившей информации" name="description"><?= $description ?></textarea>
        </div>
    </div>


    <div class="col-lg-2">
        <div class="form-group" id="reason-rig-id">
            <label for="id_reasonrig">Причина вызова</label>
            <select class="js-example-basic-single form-control" name="id_reasonrig" id="id_reasonrig" >
<option value="">Выбрать</option>
<?php
foreach ($reasonrig as $row) {
    if ($id_reasonrig == $row['id'] && $id_reasonrig != 0) {
        printf("<p><option value='%s'selected ><label>%s</label></option></p>", $row['id'], $row['name']);
    } elseif ($row['is_delete'] != 1 && $row['id'] != 0) {//удаленные записи не отображать
        printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
    }
}
?>
            </select>
        </div>
    </div>


    <div class="col-lg-2">
        <div class="form-group" id="work-view-id">
            <label for="id_work_view">Вид работ</label>
            <select class="js-example-basic-single form-control" name="id_work_view"  id="id_workview" >
                <option value="">Выбрать</option>
<?php
foreach ($workview as $row) {
    if ($id_workview == $row['id'] && $id_workview  != 0) {
        printf("<p><option value='%s' selected class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_reasonrig'], $row['name']);
    } elseif($row['is_delete'] != 1 && $row['id'] != 0) {
        printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $row['id'],  $row['id_reasonrig'], $row['name']);
    }
}
?>
            </select>
        </div>
    </div>

	    <?php
		/* podr for select: 18 - zanytia, 47 - hoz work, 75 - ptv  */
    if (isset($podr) && !empty($podr)) {

        ?>
	<div class="col-lg-2" id="div_podr_zanytia" style="display: <?= (isset($id_reasonrig) && $id_reasonrig != 0 && ($id_reasonrig == 18 || $id_reasonrig == 47 || $id_reasonrig == 75) ) ? 'block' : 'none'  ?> ">
        <div class="form-group" id="zanyatia-id">
            <label for="podr_zanytia">Выбор подразделения</label>
            <select class="js-example-basic-single form-control" name="podr_zanytia" style=" border: solid 2px #e61010 !important;" >
                <option value="">Выбрать</option>
<?php
foreach ($podr as $row) {
    if(isset($podr_zanytia) && $podr_zanytia == $row['id_pasp'])
        printf("<p><option value='%s' selected ><label>%s</label></option></p>", $row['id_pasp'],  $row['pasp_name']);
        else
   printf("<p><option value='%s'  ><label>%s</label></option></p>", $row['id_pasp'],  $row['pasp_name']);
}
?>
            </select>
        </div>
    </div>
        <?php
    }

    ?>



    <div class="col-lg-2 inspector_fire_div  <?= ($id_reasonrig == $reasonrig_fire || $id_reasonrig == $reasonrig_other_zagor) ? '' : 'hide' ?>">
        <div class="form-group">
            <label for="inspector_fire">Инспектор</label>
            <input type="text" class="form-control" placeholder="" name="inspector_fire" value="<?= $inspector ?>"  >
        </div>
    </div>



	        <div class="col-lg-2" id="div_fio_head_check" style="display: <?= (isset($id_reasonrig) && $id_reasonrig != 0 && $id_reasonrig == 18 && $id_workview  != 0 && $id_workview  == 254) ? 'block' : 'none' ?> ">
            <div class="form-group" id="fio-head-check-id">
                <label for="fio_head_check">Ф.И.О. руководителя проверки</label>
            <input type="text" class="form-control"  placeholder="Ф.И.О." name="fio_head_check" value="<?= $fio_head_check ?>" >
            </div>
        </div>



    <div class="col-lg-2" id="div_sim_number" style="display: <?= (isset($id_reasonrig) && $id_reasonrig != 0 && isset($reasons_for_sim) && isset($work_for_sim) && in_array($id_reasonrig, $reasons_for_sim) && in_array($id_workview, $work_for_sim)) ? 'block' : 'none' ?> ">
        <div class="form-group" id="sim-number-id">
            <label for="number_sim">№ Сим-карты</label>
            <input type="text" class="form-control"  placeholder="" name="number_sim" value="<?= (isset($rig['number_sim'])) ? $rig['number_sim'] : '' ?>" >
        </div>
    </div>

</div>

<p class="line"><span>Адрес</span></p>


<?php
//print_r($locality);
//  echo $_SESSION['id_local'] ;
//echo $_SESSION['auto_local'] ;
?>
<div class="row" id="div-address">

    <div class="col-lg-2">
        <div class="form-group">
            <label for="id_region">Область</label>
            <select class="js-example-basic-single form-control" name="id_region" id="id_region"   data-placeholder="Выбрать"  onchange="javascript:changeRegion();" >
                <?php
                /* ------------ редактирование - заполнить область по умолчанию -------------- */
                if ($id != 0) {
                    foreach ($region as $reg) {
                        if ($id_region == $reg['id']) {
                            printf("<p><option value='%s' selected ><label>%s</label></option></p>", $reg['id'], $reg['name']);
                        } else {
                            printf("<p><option value='%s' ><label>%s</label></option></p>", $reg['id'], $reg['name']);
                        }
                    }
                } else {//заполнить область по умолчанию из сессии - новый выезд
                    foreach ($region as $reg) {
                        /* ------- адрес выезда выбран по умолчанию ------- */
                        if ($reg['id'] == $_SESSION['id_region']) {
                            printf("<p><option value='%s' selected ><label>%s</label></option></p>", $reg['id'], $reg['name']);
                        }
                        /* ------- КОНЕЦ адрес выезда выбран по умолчанию ------- */ else {

                            printf("<p><option value='%s' ><label>%s</label></option></p>", $reg['id'], $reg['name']);
                        }
                    }
                }
                ?>
            </select>
        </div>
    </div>


    <div class="col-lg-2">
        <div class="form-group" name="local">
            <label for="id_local">Район/Город</label>
            <select class="js-example-basic-single form-control" name="id_local" id="id_local" data-placeholder="Выбрать"    onchange="javascript:changeLocal();"  >
             <option selected value="">Все</option>
                <!--              список формируется ajax функция-->
                <?php

                if ($id != 0) {//редактирование - заполнить район по умолчанию
                    foreach ($local as $loc) {
                        if ($id_local == $loc['id']) {
                            printf("<p><option value='%s' selected ><label>%s</label></option></p>", $loc['id'], $loc['name']);
                        } else {
                            printf("<p><option value='%s' ><label>%s</label></option></p>", $loc['id'], $loc['name']);
                        }
                    }
                } else {//заполнить  по умолчанию  - новый выезд
                    foreach ($local as $loc) {

                        if (isset($auto_local_city) && in_array($loc['id'], $auto_local_city) && $loc['id'] == $_SESSION['auto_local']) {//если это город и он выбран у пользователя по умолчанию
                            printf("<p><option value='%s'  selected><label>%s</label></option></p>", $loc['id'], $loc['name']);
                        } elseif ($loc['id'] == $_SESSION['auto_local'])
                            printf("<p><option value='%s'  selected><label>%s</label></option></p>", $loc['id'], $loc['name']);
                        else
                            printf("<p><option value='%s' ><label>%s</label></option></p>", $loc['id'], $loc['name']);
                    }
                }
                ?>
            </select>

        </div>
    </div>
                <?php ?>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="id_selsovet">Сельский совет</label>
            <select class=" js-example-basic-single form-control" name="id_selsovet" id="id_selsovet" data-placeholder="Выбрать"  onchange="javascript:changeSelsovet();" >
                <option value=""></option>
                <?php
                echo '   <option selected value="">Все</option>';
                if ($id != 0) {//редактирование - заполнить  по умолчанию
                    if (isset($selsovet) && !empty($selsovet)) {
                        foreach ($selsovet as $row) {
                                if ($id_selsovet == $row['id']) {
                                    printf("<p><option selected value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
                                } else {
                                    printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
                                }

                        }
                    }
                } else {// при добавлении нового выезда - заполнить  по умолчанию из сессии
                    //если  заполняется автоматом район-список с/с по району
                    if ($_SESSION['auto_local'] != 0 && isset($selsovet)) {
                        foreach ($selsovet as $row) {
                            printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
                        }
                    }
                }
                ?>
                <!--            список формируется ajax функция-->
            </select>
        </div>
    </div>


	    <div class="col-lg-3">
        <div class="form-group">
            <label for="id_locality">Населенный пункт</label>
            <select class="js-example-basic-single form-control" name="id_locality" id="id_locality"  data-placeholder="Выбрать"  onchange="javascript:changeLocality();"  >

                <!--            список формируется ajax функция-->
<?php

if ($id != 0) {//редактирование - заполнить  по умолчанию
    echo '   <option selected value="">Все</option>';
    if (isset($locality) && !empty($locality)) {
        foreach ($locality as $row) {
            if ($id_locality == $row['id']) {
                printf("<p><option data-toggle=tooltip data-placement=left  title='%s'  value='%s' selected ><label>%s</label></option></p>", $row['local_name'], $row['id'], $row['name']);
            } else {
                printf("<option data-toggle='tooltip' data-placement='left'  title='%s'  value='%s' ><label>%s</label></option>", $row['local_name'], $row['id'], $row['name']);
            }
        }
    }
} else {//новый выезд
     echo '   <option selected value="">Все</option>';
    if (isset($locality) && !empty($locality)) {

        foreach ($locality as $row) {
            if (isset($auto_local_city)) {//город
                printf("<p><option data-toggle=tooltip data-placement=left  title='%s'  value='%s' selected ><label>%s</label></option></p>", $row['local_name'], $row['id'], $row['name']);
            } elseif ($_SESSION['id_region'] == 3 && $row['id'] == 17030) {
                printf("<p><option data-toggle=tooltip data-placement=left  title='%s'  value='%s' selected ><label>%s</label></option></p>", $row['local_name'], $row['id'], $row['name']);
            } else {
                printf("<p><option data-toggle=tooltip data-placement=left  title='%s'  value='%s' ><label>%s</label></option></p>", $row['local_name'], $row['id'], $row['name']);
            }
        }
    }
}
?>
            </select>
        </div>
    </div>

</div>



<div class="row">
<?php
// echo $id_street;
?>
    <div class="col-lg-3" id="div-street">
        <div class="form-group">
            <label for="id_street">Улица</label>
            <select class="js-example-basic-single form-control" id="id_street" name="id_street" data-placeholder="Выбрать" >
                <option value="">Все</option>
<?php
if ($id != 0) {//редактирование - заполнить  по умолчанию
    if (isset($street) && !empty($street)) {
        foreach ($street as $row) {
            if ($id_street == $row['id']) {
                printf("<p><option selected value='%s' ><label>%s (%s)</label></option></p>", $row['id'], $row['name'], $row['vid_name']);
            } else {
                printf("<p><option value='%s' ><label>%s (%s)</label></option></p>", $row['id'], $row['name'], $row['vid_name']);
            }
        }
    }
} else {
    if (isset($street) && !empty($street)) {
        foreach ($street as $row) {
            printf("<p><option value='%s' ><label>%s (%s)</label></option></p>", $row['id'], $row['name'], $row['vid_name']);
        }
    }
}
?>
                <!--            список формируется ajax функция-->
            </select>
        </div>
    </div>

    <div class="col-lg-1">
        <div class="form-group">
            <label for="home_number">Дом</label>
            <input type="text" class="form-control" placeholder="Дом" name="home_number" value="<?= $home_number ?>" >
        </div>
    </div>

        <div class="col-lg-2">
        <div class="form-group">
            <label for="housing">Корпус, кв., подъезд</label>
            <input type="text" class="form-control" placeholder="Корпус, кв., подъезд" name="housing" value="<?= $housing ?>" >
        </div>
    </div>

<!--    <div class="col-lg-1">
        <div class="form-group">
            <label for="housing">Корпус</label>
            <input type="text" class="form-control" placeholder="Корпус" name="housing" value="< $housing ?>" >
        </div>
    </div>-->

<!--        <div class="col-lg-1">
        <div class="form-group">
            <label for="floor_all">Этажность</label>
            <input type="text" class="form-control" placeholder="Этажность" name="floor_all" value="< $floor_all ?>" >
        </div>
    </div>-->

<!--    <div class="col-lg-1">
        <div class="form-group">
            <label for="apartment">Квартира</label>
            <input type="text" class="form-control" placeholder="Квартира" name="apartment" value="< $apartment ?>" >
        </div>
    </div>-->
<!--    <div class="col-lg-1">
        <div class="form-group">
            <label for="floor">Этаж</label>
            <input type="text" class="form-control" placeholder="Этаж" name="floor" value="< $floor ?>" >
        </div>
    </div>-->

    <div class="col-lg-1">
        <div class="form-group">
            <label for="floor">Этажность/этаж</label>
            <input type="text" class="form-control" placeholder="Этажность/этаж" name="floor" value="<?= $floor ?>" >
        </div>
    </div>

<!--    <div class="col-lg-1"></div>-->

    <div class="col-lg-2">
        <div class="form-group">
            <div class="checkbox checkbox-success">
<?php
if ($is_opposite == 1) {
    ?>
                    <input id="checkbox1" type="checkbox" name="is_opposite" value="1" checked="">
    <?php
} else {
    ?>
                    <input id="checkbox1" type="checkbox" name="is_opposite" value="1">
                    <?php
                }
                ?>

                <label for="checkbox1">
                    Напротив адреса
                </label>
            </div>
        </div>
    </div>

</div>


<div class="row">
</div>

<div class="row">


    <div class="col-lg-3">
        <div class="form-group">
            <label for="vid_locality">Тип нас.пункта</label>
            <input type="text" class="form-control"  name="vid_locality" disabled="" value="<?= $vid_of_locality ?>" >
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="latitude">Широта</label>
            <input type="text" class="form-control coords" placeholder="Широта" name="latitude" id="coord_lat" value="<?= $latitude ?>"  >
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="longitude">Долгота</label>
            <input type="text" class="form-control coords" placeholder="Долгота" name="longitude" id="coord_lon"  value="<?= $longitude ?>" >
        </div>
    </div>


    <?php
    if (isset($settings_user['test_ver_coord']) && $settings_user['test_ver_coord']['name_sign'] == 'yes') {

        ?>
        <div class="col-lg-1" style="display: none; width: 21px; padding: 0px 2px 0px 0px" id="check-set-coord" >
            <i class="fa fa-check-square-o" style="color:green; margin-top: 34px;" data-toggle="tooltip" data-placement="top" title="Координаты успешно найдены"></i>
        </div>


        <div class="col-lg-1" style="display: none;  width: 21px; padding: 0px 0px 0px 0px" id="check-error-coord" >
            <i class="fa fa-times-circle" aria-hidden="true" style="color:red; margin-top: 34px;" data-toggle="tooltip" data-placement="top" title="Координаты не найдены"></i>
        </div>

        <div class="col-lg-1" style="display: none;  width: 21px; padding: 0px 2px 0px 0px"  id="loader-coord" >
            <i class="fa fa-refresh fa-spin fa-fw" aria-hidden="true" style="color:blue; margin-top: 34px;" data-toggle="tooltip" data-placement="top" title="Идет поиск координат"></i>

        </div>


        <div class="col-lg-1" style="display: none; width: 21px; padding: 0px 5px 0px 0px" id="check-open-coord" >
            <i class="fa fa-question-circle-o fa-lg" aria-hidden="true" style="color:#e28c03; margin-top: 34px;" data-toggle="tooltip" data-placement="top" title="Откройте карту, возможно есть предложенные варианты"></i>
        </div>


        <div class="col-lg-1" style="  width: 40px; padding: 0px 0px 0px 0px; margin-top: 24px; padding-left: 0px; "  >
            <button type="button" id="btn-get-coord" class="btn btn-default" style="background-color: #00800069;"  data-toggle="tooltip" data-placement="top" title="Получить координаты" onclick="setAddressOnMap();">
                <i class="fa fa-arrow-circle-left fa-lg" aria-hidden="true" style="color:#057d10;; margin-top: 0px;"></i></button>
        </div>
        <div class="col-lg-1" style=" width: 38px;" >

            <i class="fa fa-map-marker fa-2x " id="show-map" aria-hidden="true" style="padding-top:25px; cursor: pointer" data-toggle="tooltip" data-placement="top" title="Показать карту"></i>

        </div>
        <?php
    }

    ?>

</div>


<?php
if (isset($settings_user['test_ver_coord']) && $settings_user['test_ver_coord']['name_sign'] == 'yes') {

    ?>
    <div id="map" >

    </div>
    <div class="empty-place" style="display:none">
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>
    <?php
}

?>

<div class="row">
    <div class="col-lg-5">
        <div class="form-group">
            <label for="additional_field_address">Дополнительное поле (если нет адреса или улицы)</label>
            <textarea class="form-control" rows="2" cols="22" placeholder="в пределах улиц или строящихся объектов, МКАД и т.д." name="additional_field_address"><?= $additional_field_address ?></textarea>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="object">Объект</label>
            <textarea class="form-control" rows="6" cols="22" placeholder="описание объекта" name="object" id="object_id"><?= $object ?></textarea>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group" id="office-belong-id">
            <label for="id_officebelong">Ведомственная прин.</label>
            <select class="js-example-basic-single form-control" name="id_officebelong"  >
                <option value="">Выбрать</option>
<?php
foreach ($officebelong as $row) {
    if ($id_officebelong == $row['id']) {
        printf("<p><option value='%s' selected ><label>%s</label></option></p>", $row['id'], $row['name']);
    } elseif ($row['is_delete'] != 1) {
        printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
    }
}
?>
            </select>
        </div>
    </div>
</div>

<p class="line"><span>Детализированная информация</span></p>

<div class="row">

    <div class="col-lg-4">
        <div class="form-group">
            <label for="inf_detail">Детализированная информация</label>
            <textarea class="form-control" rows="6" cols="22" placeholder="инф. о ЧС, аварии и т.д." name="inf_detail"><?= $inf_detail ?></textarea>
        </div>
    </div>



</div>



<!--by settings: additional tab-->
<?php
if (isset($settings_user['is_addit_on_process_tab']) && $settings_user['is_addit_on_process_tab']['name_sign'] == 'yes') {
include dirname(__FILE__) . '/addit_tab_content.php';
}

?>



<?php
if (isset($settings_user['test_ver_coord']) && $settings_user['test_ver_coord']['name_sign'] == 'yes') {

    ?>
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/leaflet-control-geocoder-master/dist/leaflet.css" />
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/leaflet-control-geocoder-master/dist/Control.Geocoder.css" />

    <script src="<?= $baseUrl ?>/assets/leaflet-control-geocoder-master/dist/leaflet-src.js"></script>
    <script src="<?= $baseUrl ?>/assets/leaflet-control-geocoder-master/dist/Control.Geocoder.js"></script>

    <!-- Load Esri Leaflet from CDN -->
<!--    <script src="https://unpkg.com/esri-leaflet@2.3.2/dist/esri-leaflet.js"
            integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ=="
    crossorigin=""></script>-->
    <script src="<?= $baseUrl ?>/assets/leaflet-control-geocoder-master/esri-leaflet.js"
            integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ=="
    crossorigin=""></script>


    <!-- Load Esri Leaflet Geocoder from CDN -->
    <!--  <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.2/dist/esri-leaflet-geocoder.css"
        integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
        crossorigin="">
      <script src="https://unpkg.com/esri-leaflet-geocoder@2.3.2/dist/esri-leaflet-geocoder.js"
        integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ=="
        crossorigin=""></script>-->


    <input type="hidden" id="is_set_coord_success">
    <script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript">

                var map = L.map('map').setView([53.900000, 27.566670], 17);

                var geocoder = L.Control.Geocoder.nominatim();
                if (URLSearchParams && location.search) {
                    // parse /?geocoder=nominatim from URL
                    var params = new URLSearchParams(location.search);
                    var geocoderString = params.get('geocoder');
                    if (geocoderString && L.Control.Geocoder[geocoderString]) {
                        console.log('Using geocoder', geocoderString);
                        geocoder = L.Control.Geocoder[geocoderString]();
                    } else if (geocoderString) {
                        console.warn('Unsupported geocoder', geocoderString);
                    }
                }

                var control = L.Control.geocoder({
                    geocoder: geocoder
                }).addTo(map);
                var marker;

    //var geocodeService = L.esri.Geocoding.geocodeService();

    //'http://tiles.maps.sputnik.ru/{z}/{x}/{y}.png'

                L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors',
                    minZoom: 6
                }).addTo(map);



                var xlng = 0.000256;
                var xlat = 0.000200;
                var selectedPoint = [];
                var searchPoint = [];
                var marker_a = [];


                map.on('click', function (e) {

                    if (searchPoint !== undefined) {
                        map.removeLayer(searchPoint);
                    }

                    var coord = e.latlng;
                    var lat = coord.lat;
                    var lng = coord.lng;
                    console.log("You clicked the map at latitude: " + lat + " and longitude: " + lng);

                    searchPoint = L.marker(e.latlng).addTo(map);
    //
    //    geocoder.reverse(
    //        e.latlng,
    //        map.options.crs.scale(map.getZoom()),
    //        results => {
    //          var r = results[0];
    //          if (r) {
    //            if (marker) {
    //
    //                 map.removeLayer(marker);
    //                 marker =   L.marker(r.center)
    //                .bindPopup(r.name)
    //                .addTo(map)
    //                .openPopup();
    //
    ////              marker
    ////                .setLatLng(r.center)
    ////                .setPopupContent(r.html || r.name)
    ////                .openPopup();
    //            } else {
    //                //alert('h');
    //              marker =   L.marker(r.center)
    //                .bindPopup(r.name)
    //                .addTo(map)
    //                .openPopup();
    //
    //
    //            }
    //            $('#is_set_coord_success').val(1);
    //            $('#loader-coord').css('display','none');
    //            $('#check-set-coord').css('display','inline');
    //            $('#check-error-coord').css('display','none');
    //            $('#check-open-coord').css('display','none');
    //            marker_a = marker;
    //
    //          }
    //        }
    //      );

                    var a = lat.toString();
                    var b = lng.toString();


                    $('#coord_lat').val(a.substr(0, 9));
                    $('#coord_lon').val(b.substr(0, 9));

                    if (a && b) {
                        $('#check-error-coord').css('display', 'none');
                        //$('#check-set-coord').css('display','inline');
                        $('.coords').css('border', '2px solid #00a65a');
                        toastr.success('Выбранные координаты установлены 1', 'Инфо', {progressBar: true, timeOut: 2500});
                    } else {
                        $('#check-set-coord').css('display', 'none');
                        $('#check-error-coord').css('display', 'inline');
                    }

                });



                var not_found = 0;
                /* get address string */
                function generateAddress(i = 0) {


                    var addr = '';

                    var new_street = '';
                    var type_str = '';
                    var local = '';
                    var region = '';
                    var home = '';

                    var region = $("#id_region option:selected").text();
                    var local = $("#id_local option:selected").text();
                    var locality = $("#id_locality option:selected").text();
                    var street = $("#id_street option:selected").text();

                    var home = $("input[name='home_number']").val();


                    var str = street;

                    if (str === 'Все') {

                    } else {
                        var twoParts = str.split(' (');
                        var new_street = twoParts[0];

                        var type_str_arr = twoParts[1].split(')');
                        var type_str = type_str_arr[0];
                        console.log(str);
                    }


                    if (region === 'г.Минск') {


                        if (i === 0) {// minsk+local+street+name_street+home

                            if (local === 'Все') {
                                var local = '';
                            } else {
                                var local = local + ' район';
                            }

                            var addr = region;

                            if (local !== '')
                                addr = addr + ' ' + local;

                            if (type_str !== '') {
                                addr = addr + ' ' + type_str;
                            }


                            if (new_street !== '') {
                                addr = addr + ' ' + new_street;
                            }

                            if (home !== '') {
                                addr = addr + ' ' + home;
                            }

                        } else if (i === 1) {// minsk+local+name_street+street+home

                            if (local === 'Все') {
                                var local = '';
                            } else {
                                var local = local + ' район';
                            }

                            var addr = region;


                            if (local !== '')
                                addr = addr + ' ' + local;

                            if (new_street !== '') {
                                addr = addr + ' ' + new_street;
                            }


                            if (type_str !== '') {
                                addr = addr + ' ' + type_str;
                            }

                            if (home !== '') {
                                addr = addr + ' ' + home;
                            }
                        }
                        /* minsk+street+name_street+home*/
                        else if (i === 2) {

                            var addr = region;

                            if (type_str !== '') {
                                addr = addr + ' ' + type_str;
                            }

                            if (new_street !== '') {
                                addr = addr + ' ' + new_street;
                            }


                            if (home !== '') {
                                addr = addr + ' ' + home;
                            }
                        }
                        /* minsk+name_street+street+home*/
                        else if (i === 2) {

                            var addr = region;

                            if (new_street !== '') {
                                addr = addr + ' ' + new_street;
                            }
                            if (type_str !== '') {
                                addr = addr + ' ' + type_str;
                            }

                            if (home !== '') {
                                addr = addr + ' ' + home;
                            }
                        }
                        /* minsk+street+name_street*/
                        else if (i === 3) {

                            var addr = region;

                            if (type_str !== '') {
                                addr = addr + ' ' + type_str;
                            }
                            if (new_street !== '') {
                                addr = addr + ' ' + new_street;
                            }
                        }
                    } else {//region

                        /* region local locality  street type_street home  */
                        if (i === 0) {

                            if (local === 'Все') {
                                var local_a = '';
                            } else if (local === locality) {
                                var local_a = '';
                            } else {
                                var local_a = local + ' район';
                            }

                            var addr = region;

                            if (local_a !== '')
                                addr = addr + ' ' + local_a;

                            if (local === locality) {
                                var locality_a = '';
                            } else {
                                var locality_a = locality;
                            }

                            if (locality_a !== '')
                                addr = addr + ' ' + locality_a;

                            if (new_street !== '') {
                                addr = addr + ' ' + new_street;
                            }

                            if (type_str !== '') {
                                addr = addr + ' ' + type_str;
                            }


                            if (home !== '') {
                                addr = addr + ' ' + home;
                            }

                        }

                        /* region local locality type_street street home. vitebskay ulica Pravdy 63 k3 */
                        else if (i === 1) {

                            if (local === 'Все') {
                                var local_a = '';
                            } else if (local === locality) {
                                var local_a = '';
                            } else {
                                var local_a = local + ' район';
                            }

                            var addr = region;

                            if (local_a !== '')
                                addr = addr + ' ' + local_a;

                            if (local === locality) {
                                var locality_a = locality;
                            } else {
                                var locality_a = locality;
                            }

                            if (locality_a !== '')
                                addr = addr + ' ' + locality_a;


                            if (type_str !== '') {
                                addr = addr + ' ' + type_str;
                            }

                            if (new_street !== '') {
                                addr = addr + ' ' + new_street;
                            }

                            if (home !== '') {
                                addr = addr + ' ' + home;
                            }
                        }


                        /* region local locality  street type_street  */
                        if (i === 2) {

                            if (local === 'Все') {
                                var local_a = '';
                            } else if (local === locality) {
                                var local_a = '';
                            } else {
                                var local_a = local + ' район';
                            }

                            var addr = region;

                            if (local_a !== '')
                                addr = addr + ' ' + local_a;

                            if (local === locality) {
                                var locality_a = '';
                            } else {
                                var locality_a = locality;
                            }

                            if (locality_a !== '')
                                addr = addr + ' ' + locality_a;

                            if (new_street !== '') {
                                addr = addr + ' ' + new_street;
                            }

                            if (type_str !== '') {
                                addr = addr + ' ' + type_str;
                            }

                        }

                        /* region local locality  */
                        if (i === 3) {

                            if (local === 'Все') {
                                var local_a = '';
                            } else if (local === locality) {
                                var local_a = '';
                            } else {
                                var local_a = local + ' район';
                            }

                            var addr = region;

                            if (local_a !== '')
                                addr = addr + ' ' + local_a;

                            if (local === locality) {
                                var locality_a = '';
                            } else {
                                var locality_a = locality;
                            }

                            if (locality_a !== '')
                                addr = addr + ' ' + locality_a;

                        }
                        //var addr=region+ ' '+ local+' '+' '+type_str+' '+new_street;

                    }


                    /*		    if(region === locality){
                     var region='';
                     }
                     if(local === locality){
                     var local='';
                     }

                     if(local === 'Все'){
                     var local='';
                     }

                     if(region === ''){
                     var addr=local+' '+new_street;
                     }
                     else if(region==='г.Минск'){
                     var region='';
                     }
                     else
                     var region=region+' область';*/


                    // var addr=region+ ' '+ local+' '+locality+' '+new_street;

                    //Витебская область,  г. Витебск,  Правды 63 к7
                    console.log(addr);

                    //$('#search-address-on-map').val('Минск Иерусалимская 4');
                    if (addr !== '')
                        $('#search-address-on-map').val(addr);
                    else
                        not_found = 1;
                }


                iterate_address = 0;
                max_iterate = 3;


                function setAddressOnMap(iter = 0) {


                    if (searchPoint !== undefined) {
                        map.removeLayer(searchPoint);
                    }

                    generateAddress(iter);

                    if ($('#search-address-on-map').val() !== '') {
                        //alert('iter='+iter);

                        var e = jQuery.Event("keydown", {
                            keyCode: 13
                        });
                        //map.setZoom(16);
                        control._keydown(e);

                        isFoundAddress();
                    } else {
                        toastr.warning('Необходимо заполнить адрес выезда', 'Внимание!', {progressBar: true, timeOut: 5000});
                }


                }

                function isFoundAddress() {
                    var e = jQuery.Event("keydown", {
                        keyCode: 13
                    });

                    /* !!! time is important: if  iterate is heigher  - time is heigher */
                    setTimeout(function () {

                        /* not found */
                        if (parseInt($('#is_set_coord_success').val()) === 0) {

                            if ($('.leaflet-control-geocoder-alternatives').css('display') === 'block') {// isset list of address
                                $('#loader-coord').css('display', 'none');
                                $('#check-set-coord').css('display', 'none');
                                $('#check-error-coord').css('display', 'none');
                                $('#check-open-coord').css('display', 'inline');

                                if ($('#map').hasClass('show-map-hide')) {

                                    $('#map').removeClass('show-map-hide');
                                    $('.empty-place').show();
                                }
                                iterate_address = 0;

                            } else {// not found

                                //next iteration
                                iterate_address = iterate_address + 1;
                                //alert(iterate_address);
                                if (iterate_address <= max_iterate) {
                                    //alert('search');
                                    setAddressOnMap(iterate_address);

                                } else {
                                    $('#loader-coord').css('display', 'none');
                                    $('#check-set-coord').css('display', 'none');
                                    $('#check-error-coord').css('display', 'inline');
                                    $('#check-open-coord').css('display', 'none');

                                    iterate_address = 0;
                                }

                            }


                        } else {
                            // alert('g');


                            iterate_address = 0;
                            $('#loader-coord').css('display', 'none');
                            //$('#check-set-coord').css('display','inline');
                            $('.coords').css('border', '2px solid #00a65a');
                            $('#check-error-coord').css('display', 'none');
                            $('#check-open-coord').css('display', 'none');
                        }
                    }, 2000);

                }



                $("#show-map").click(function () {

                    if ($('#map').hasClass('show-map-hide')) {

                        $('#map').removeClass('show-map-hide');
                        $('.empty-place').show();
                    } else {
                        $('#map').addClass('show-map-hide');
                        $('.empty-place').hide();
                    }

                });





    <?php
    if (isset($rig) && !empty($rig) && isset($longitude) && !empty($longitude) && isset($latitude) && !empty($latitude) && isset($addr_for_map) && !empty($addr_for_map)) {

        ?>
                    setCoordToMap(<?= $latitude ?>, <?= $longitude ?>, '<?= $addr_for_map ?>', 1);


        <?php
    }

    ?>
                $("#show-map").trigger('click');


                function setCoordToMap(lat, lon, addr, sign = 0) {

                    var is_open = 0;

                    if (searchPoint !== undefined) {
                        map.removeLayer(searchPoint);
                    }

                    if (sign === 0) {// change pasp name
                        if ($('#map').hasClass('show-map-hide')) {

                            $("#show-map").trigger('click');
                            is_open = 1;
                        }
                    }

                    if (addr !== '') {
                        var s = searchPoint = L.marker([lat, lon]).addTo(map)
                                .bindPopup(addr)
                                .openPopup();

                        if (sign === 0 && is_open === 1) {// change pasp name
                            $("#show-map").trigger('click');
                        }
                    }

                    /* centered */
                    map.setView([lat, lon], 17);

                    if (sign === 0) {// change pasp name
                        toastr.success('Выбранные координаты установлены 2', 'Инфо', {progressBar: true, timeOut: 2500});
                    }
                    //$('#check-set-coord').css('display','inline');
                    $('.coords').css('border', '2px solid #00a65a');
                }



    </script>
    <?php
}

?>



