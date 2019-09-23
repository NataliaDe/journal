<div class="col-lg-2">
        <div class="form-group">
            <label for="id_region">Область</label>
            <select class="js-example-basic-single address-block-select-single form-control" name="id_region" id="id_region"   data-placeholder="Выбрать"  onchange="javascript:changeRegion();" >
                <?php
                /* ------------ default region from guide -------------- */
                if ($pasp_id_from_guide != 0) {
                    foreach ($region as $reg) {
                        if ($result['id_region'] == $reg['id']) {
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
            <select class="js-example-basic-single address-block-select-single form-control" name="id_local" id="id_local" data-placeholder="Выбрать"    onchange="javascript:changeLocal();"  >
             <option selected value="">Все</option>
                <!--              список формируется ajax функция-->
                <?php

                if ($pasp_id_from_guide != 0) {//редактирование - заполнить район по умолчанию
                    foreach ($local as $loc) {
                        if ($result['id_local'] == $loc['id']) {
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
            <select class=" js-example-basic-single address-block-select-single form-control" name="id_selsovet" id="id_selsovet" data-placeholder="Выбрать"  onchange="javascript:changeSelsovet();" >
                <option value=""></option>
                <?php
                echo '   <option selected value="">Все</option>';
                if ($pasp_id_from_guide != 0) {//редактирование - заполнить  по умолчанию
                    if (isset($selsovet) && !empty($selsovet)) {
                        foreach ($selsovet as $row) {
                                if ($result['id_selsovet'] == $row['id']) {
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
            <select class="js-example-basic-single address-block-select-single form-control" name="id_locality" id="id_locality"  data-placeholder="Выбрать"  onchange="javascript:changeLocality();"  >

                <!--            список формируется ajax функция-->
<?php

if ($pasp_id_from_guide != 0) {//редактирование - заполнить  по умолчанию
    echo '   <option selected value="">Все</option>';
    if (isset($locality) && !empty($locality)) {
        foreach ($locality as $row) {
            if ($result['id_locality'] == $row['id']) {
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
