<?php
//print_r($rig);
//echo $_SESSION['id_user'];
if (isset($rig) && !empty($rig)) {

    $time_msg = $rig['time_msg'];
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

<!--    <div class="col-lg-2">
        <?php
        //if ($id_user == $_SESSION['id_user'] || ($_SESSION['id_level'] == 1 && $_SESSION['can_edit'] == 1 && $_SESSION['is_admin'] == 1)) {

            ?>



            <?php
//        } else {
//
//          include dirname(__FILE__) . '/infoMsg.php';
//        }

        ?>
    </div>-->



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



</div>

<p class="line"><span>Адрес</span></p>



<div class="row">

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
    <div class="col-lg-3">
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
<?php
//print_r($locality);
//  echo $_SESSION['id_local'] ;
//echo $_SESSION['auto_local'] ;
?>



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
            <input type="text" class="form-control" placeholder="Широта" name="latitude" id="coord_lat" value="<?= $latitude ?>"  >
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="longitude">Долгота</label>
            <input type="text" class="form-control" placeholder="Долгота" name="longitude" id="coord_lon"  value="<?= $longitude ?>" >
        </div>
    </div>


</div>

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
            <textarea class="form-control" rows="2" cols="22" placeholder="описание объекта" name="object" id="object_id"><?= $object ?></textarea>
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





