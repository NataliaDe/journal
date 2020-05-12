<form  role="form" class="form-inline" name="showPodrForm" id="showPodrForm" method="POST" style="padding-top: 7px; padding-right: 5px">


    <div class="form-group">
        <!--        <label for="id_region">Область</label>-->
        <select class="chosen-select-deselect form-control" name="id_region[]" id="id_region_map" multiple tabindex="4" data-placeholder="Область" >
            <?php
            foreach ($region as $re) {

                printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
            }

            ?>
        </select>
    </div>

    <div class="form-group" id="div_id_local_map" style="display: none">
        <!--        <label for="id_local">Район</label>-->
        <select class="chosen-select-deselect form-control" name="id_local[]" id="id_local_map"  multiple tabindex="4" data-placeholder="Район" >


        </select>
    </div>

    <input type="hidden" id="current_local_map" value="">

    <div class="form-group">
        <button class="btn bg-success" type="button" id="show_podr">Показать подразделения</button>
        <button class="btn bg-secondary" type="button" id="reset_filter">Сбросить фильтр</button>
    </div>


</form>
