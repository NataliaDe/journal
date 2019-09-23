<?php
//echo $edit_podr['id'];
if (isset($edit_podr['id']) && $edit_podr['id'] != 0) {


    $id_street = $edit_podr['id_street'];
    $home_number = $edit_podr['home_number'];
    $housing = $edit_podr['housing'];//корпус, кв, подъезд

    $id_locality = $edit_podr['id_locality'];
    $id_region = $edit_podr['id_region'];
    $id_local = $edit_podr['id_local'];
    $id_selsovet = $edit_podr['id_selsovet'];



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


    $id_street = 0;
    $home_number = 0;
    $housing = '';

    $id_locality = 0;
    $id_region = 0;
    $id_local = 0;
    $id_selsovet = 0;

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
?>

<br><br>
<center>
    <u> <b>
            <?= $podr['pasp_name'] ?>,
            <?= $podr['locorg_name'] ?>
        </b></u>
    <br><br>
</center>

<div class="box-body">

    <form    role="form"  method="POST" action="<?= $baseUrl ?>/guide_pasp">

        <input type="hidden" class="form-control "   name="id_pasp" value="<?= $podr['id'] ?>" />



        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="latitude">Широта
                        <i class="fa fa-check-square-o" aria-hidden="true" style="color:green" data-toggle="tooltip" data-placement="right" title="Взята из карточки учета сил и средств ОПЧС"></i>
                    </label>

                    <input type="text" class="form-control "  value="<?= $podr['latitude'] ?>" disabled=""/>

                </div>
            </div>


            <div class="col-lg-2">
                <div class="form-group">
                    <label for="longitude" >Долгота
                        <i class="fa fa-check-square-o" aria-hidden="true" style="color:green" data-toggle="tooltip" data-placement="right" title="Взята из карточки учета сил и средств ОПЧС"></i>
                    </label>

                    <input type="text" class="form-control "  value="<?= $podr['longitude'] ?>" disabled="" />

                </div>
            </div>
        </div>



        <div class="row">

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="id_region">Область</label>
                    <select class="js-example-basic-single form-control" name="id_region" id="id_region"   data-placeholder="Выбрать"  onchange="javascript:changeRegion();" >
                        <?php
                        /* ------------ редактирование - заполнить область по умолчанию -------------- */
                        if ($edit_podr['id']  != 0) {
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
                        if ($edit_podr  != 0) {//редактирование - заполнить район по умолчанию
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



            <div class="col-lg-2">
                <div class="form-group">
                    <label for="id_selsovet">Сельский совет</label>
                    <select class=" js-example-basic-single form-control" name="id_selsovet" id="id_selsovet" data-placeholder="Выбрать"  onchange="javascript:changeSelsovet();" >
                        <option value=""></option>
                        <?php
                        echo '   <option selected value="">Все</option>';
                        if ($edit_podr  != 0) {//редактирование - заполнить  по умолчанию
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


            <div class="col-lg-2">
                <div class="form-group">
                    <label for="id_locality">Населенный пункт</label>
                    <select class="js-example-basic-single form-control" name="id_locality" id="id_locality"  data-placeholder="Выбрать"  onchange="javascript:changeLocality();"  >

                        <!--            список формируется ajax функция-->
                        <?php
                        if ($edit_podr  != 0) {//редактирование - заполнить  по умолчанию
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


    <div class="col-lg-2">
        <div class="form-group">
            <label for="vid_locality">Тип нас.пункта</label>
            <input type="text" class="form-control"  name="vid_locality" disabled="" value="<?= $vid_of_locality ?>" >
        </div>
    </div>

        </div>

        <div class="row">

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="id_street">Улица</label>
                    <select class="js-example-basic-single form-control" id="id_street" name="id_street" data-placeholder="Выбрать" >
                        <option value="">Все</option>
                        <?php
                        if ($edit_podr  != 0) {//редактирование - заполнить  по умолчанию
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

        </div>



        <br>
        <center> <button class="btn btn-success" type="submit" >Сохранить</button></center>
        <br>
        <center> <a href="<?= $baseUrl ?>/guide_pasp">  <button class="btn btn-danger" type="button" data-dismiss="modal">Отмена</button></a></center>
    </form>

</div>
