
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];

?>



<form  role="form" class="form-inline" name="diagramResBattleFormYear" id="diagramResBattleFormYear"  method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">

    <div class="form-group">
        <label for="year">Год</label>
        <select class="form-control select2-single-form" name="year"  id="id-year-year">

            <?php
            foreach (ARCHIVE_YEAR_LIST as $y) {
                if (isset($filter['year']) && !empty($filter['year']) && $filter['year'] == $y) {
                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $y, $y);
                } elseif($y==date('Y')) {
                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $y, $y);
                }
                else {
                    printf("<p><option value='%s' ><label>%s</label></option></p>", $y, $y);
                }
            }

            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="type_save">Вид</label>
        <select class="form-control select2-multiple-form " multiple="" name="type_save[]" id="type-save-id-year"  >
            <option value="1">Погибло всего</option>
            <option value="2">Погибло детей</option>
            <option value="3">Спасено всего</option>
            <option value="4">Спасено детей</option>
        </select>
    </div>




    <div class="form-group">
        <button class="btn bg-light-blue" type="button"  onclick="update(3);" >Показать</button>
    </div>

    <div class="form-group">
        <button class="btn bg-dark" type="button" onclick="resetFilter(3);">Сбросить фильтр</button>
    </div>

<!--    <div class="form-group">
        <button class="btn bg-yellow" type="submit"  name="btn_rep4_excel" >Экспорт в Excel</button>
    </div>-->

    <br> 

</form>


<br>

<!--<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i> -
При указании периода дат - данные формируются с 06:00 до 06:00
<br>-->
<!--<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i><span style="color: red"> -
    ...</span>-->