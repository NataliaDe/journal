
<form  role="form" class="form-inline " name="showPodrForm" id="showPodrForm" method="POST" style="padding-top: 7px; padding-right: 5px">

    <div class="row">
        <div class="form-group" id="div_id_name_car_map" >
            <!--        <label for="id_local">Район</label>-->
            <p>
                <select class="form-control js-name-car-multiple " name="id_name_car[]" id="id_name_car_map"  multiple tabindex="4" data-placeholder="Наименование техники" >

                    <?php
                    foreach ($name_car as $re) {

                        if ($re['id'] == 1) {
                            printf("<p><option value='%s' selected><label>%s</label></option></p>", $re['id'], $re['name']);
                        } else {
                            printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                        }
                    }

                    ?>

                </select>
            </p>
        </div>
    </div>


    <div class="row">
        <div class="form-group">
            <!--        <label for="id_region">Область</label>-->
            <p>
                <!--                chosen-select-deselect-->
                <select class=" js-region-multiple form-control" name="id_region[]" id="id_region_map" multiple tabindex="4" data-placeholder="Область" >
                    <?php
                    foreach ($region as $re) {

                        if ($re['id'] == 3) {
                            printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                        } else {

                            printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                        }
                    }

                    ?>
                </select>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="form-group" id="div_id_local_map" >
            <!--        <label for="id_local">Район</label>-->
            <p>
                <select class="js-local-multiple form-control" name="id_local[]" id="id_local_map"  multiple tabindex="4" data-placeholder="Г(Р)ОЧС" >

                    <?php
                    foreach ($grochs as $re) {

                        printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                    }

                    ?>

                </select>
            </p>
        </div>

    </div>


    <div class="row">
        <div class="form-group" id="div_id_pasp_map" >
            <!--        <label for="id_local">Район</label>-->
            <p>
                <select class="js-pasp-multiple form-control" name="id_pasp[]" id="id_pasp_map"  multiple tabindex="4" data-placeholder="ПАСЧ" >


                </select>
            </p>

        </div>
    </div>






    <div class="row">

        <div class="form-group" id="div_id_ob_car_map" >
            <!--        <label for="id_local">Район</label>-->
            <p>
                <select class="js-v-multiple form-control" name="id_ob_car[]" id="id_ob_car_map"  multiple tabindex="4" data-placeholder="Объем цистерны" >

                    <option value="1">1 - 4</option>
                    <option value="2">4 - 7</option>
                    <option value="3">свыше 8</option>

                </select>
            </p>
        </div>
    </div>


    <div class="row">
        <div class="form-group" id="div_id_vid_car_map" >
            <p>
                <select class="js-vid-car-multiple form-control" name="id_vid_car[]" id="id_vid_car_map"  multiple tabindex="4" data-placeholder="Вид техники" >

                    <?php
                    foreach ($vid_car as $re) {

                        printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                    }

                    ?>
                </select>
            </p>
        </div>
    </div>



    <div class="row">
        <div class="form-group" id="div_id_type_car_map" >
            <!--        <label for="id_local">Район</label>-->
            <p>
                <select class="js-type-car-single form-control" name="id_type_car" id="id_type_car_map"   tabindex="4" data-placeholder="Тип техники" >
                    <option value="" selected="">Все типы техники</option>
                    <?php
                    foreach ($type_car as $re) {

                        printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                    }

                    ?>

                </select>
            </p>
        </div>
    </div>



    <div class="row">
        <br><br>
        <div class="form-group" id="div_id_show_number_pasp" >
            <div class="checkbox checkbox-success" style="padding-left: 8px; cursor: pointer">
                <input id="checkbox1" type="checkbox" name="show_number_pasp" value="1" >
                <label for="checkbox1" style="color: white; cursor: pointer">
                    Показать номера частей
                </label>
            </div>


        </div>
    </div>

    <input type="hidden" id="current_local_map" value="">
    <br>
    <div class="row">

        <div class="form-group" style="margin-left: 16%;">
            <br><br><br>

            <a href="#" class="button19" type="button" id="show_podr">Отобразить на карте</a>
            <!--            <button class="btn bg-success" type="button" id="show_podr">Показать</button>-->
            <!--        <button class="btn bg-secondary" type="button" id="reset_filter">Сбросить фильтр</button>-->

        </div>
        <br>
    </div>

    <div class="row">

        <p class="line"><span>Настройки</span></p>
    </div>

    <div class="row">
        <br>
        <div class="form-group settings-fields" id="div_id_show_border" >
            <div class="checkbox checkbox-warning" style="padding-left: 8px; cursor: pointer">
                <input id="show_border" type="checkbox" name="show_border" value="1" checked="">
                <label for="show_border" style="color: white; cursor: pointer">
                    Границы РБ  и областей
                </label>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="form-group settings-fields" id="div_id_show_border_local" >
            <div class="checkbox checkbox-warning" style="padding-left: 8px; cursor: pointer">
                <input id="show_border_local" type="checkbox" name="show_border_local" value="1" checked="">
                <label for="show_border_local" style="color: white; cursor: pointer">
                    Границы районов
                </label>
            </div>


        </div>
    </div>


<!--     <div class="row">
        <div class="form-group settings-fields" id="div_id_show_border_local" >
            <div class="checkbox checkbox-warning" style="padding-left: 8px; cursor: pointer">
                <input id="show_border_local" type="checkbox" name="show_border_local" value="1" checked="">
                <label for="show_border_local" style="color: white; cursor: pointer">
                    Границы районов
                </label>
            </div>
        </div>
    </div>-->



    <div class="row">
        <br>
        <div class="form-group settings-fields" id="div_id_show_name_local" style="display: none">
            <div class="checkbox checkbox-info" style="padding-left: 8px; cursor: pointer">
                <input id="show_name_local" type="checkbox" name="show_name_local" value="1" checked="" >
                <label for="show_name_local" style="color: white; cursor: pointer">
                    Название районов
                </label>
            </div>


        </div>
    </div>




    <span id="loading" style="display: none">hhhh</span>
</form>


