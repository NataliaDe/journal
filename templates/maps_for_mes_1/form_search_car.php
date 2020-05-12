<form  role="form" class="form-inline" name="showPodrForm" id="showPodrForm" method="POST" style="padding-top: 7px; padding-right: 5px">

    <div class="row">
        <div class="form-group">
            <!--        <label for="id_region">Область</label>-->
            <p>
            <select class="chosen-select-deselect form-control" name="id_region[]" id="id_region_map" multiple tabindex="4" data-placeholder="Область" >
                <?php
                foreach ($region as $re) {

                    printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                }

                ?>
            </select>
            </p><br><br>
        </div>
    </div>

    <div class="row">
        <div class="form-group" id="div_id_local_map" >
            <!--        <label for="id_local">Район</label>-->
            <p>
            <select class="chosen-select-deselect form-control" name="id_local[]" id="id_local_map"  multiple tabindex="4" data-placeholder="Г(Р)ОЧС" >


            </select>
 </p><br><br>
        </div>

    </div>


    <div class="row">
        <div class="form-group" id="div_id_pasp_map" >
            <!--        <label for="id_local">Район</label>-->
            <p>
                <select class="chosen-select-deselect form-control" name="id_pasp[]" id="id_pasp_map"  multiple tabindex="4" data-placeholder="ПАСЧ" >


            </select>
            </p><br><br>

        </div>
    </div>


    <div class="row">
        <div class="form-group" id="div_id_name_car_map" >
            <!--        <label for="id_local">Район</label>-->
            <p>
            <select class="chosen-select-deselect form-control" name="id_name_car[]" id="id_name_car_map"  multiple tabindex="4" data-placeholder="Наименование техники" >

                <?php
                foreach ($name_car as $re) {

                    printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                }

                ?>

            </select>
             </p><br><br>
        </div>
    </div>


    <div class="row">
        <div class="form-group" id="div_id_type_car_map" >
            <!--        <label for="id_local">Район</label>-->
            <p>
            <select class="chosen-select-deselect form-control" name="id_type_car[]" id="id_type_car_map"  multiple tabindex="4" data-placeholder="Тип техники" >

                <?php
                foreach ($type_car as $re) {

                    printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                }

                ?>

            </select>
                 </p><br><br>
        </div>
    </div>

    <div class="row">

        <div class="form-group" id="div_id_ob_car_map" >
            <!--        <label for="id_local">Район</label>-->
             <p>
            <select class="chosen-select-deselect form-control" name="id_ob_car[]" id="id_ob_car_map"  multiple tabindex="4" data-placeholder="Объем цистерны" >


            </select>
                  </p><br><br>
        </div>
    </div>


    <div class="row">
        <div class="form-group" id="div_id_vid_car_map" >
            <!--        <label for="id_local">Район</label>-->
            <p>
            <select class="chosen-select-deselect form-control" name="id_vid_car[]" id="id_vid_car_map"  multiple tabindex="4" data-placeholder="Вид техники" >

                <?php
                foreach ($vid_car as $re) {

                    printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                }

                ?>
            </select>
                 </p><br><br>
        </div>
    </div>

    <input type="hidden" id="current_local_map" value="">

    <div class="row">
        <div class="form-group">
            <br><br>
            <button class="btn bg-success" type="button" id="show_podr">Показать</button>
            <!--        <button class="btn bg-secondary" type="button" id="reset_filter">Сбросить фильтр</button>-->
        </div>
    </div>


</form>
