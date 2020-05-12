
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];

?>



<br>

<form  role="form" class="form-inline" name="diagramResBattleForm" id="diagramResBattleForm"  method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">

    <div class="form-group">
        <label for="year">Год</label>
        <select class="form-control select2-single-form" name="year"  id="id-year">

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
        <label for="month">Месяц</label>
        <select class="form-control select2-single-form" name="month"  id="id-month">

            <?php
            foreach (LIST_MONTH as $k=>$y) {
                if (isset($filter['month']) && !empty($filter['month']) && $filter['month'] == $k) {
                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $k, $y);
                } elseif($k==date('m')) {
                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $k, $y);
                }
                else {
                    printf("<p><option value='%s' ><label>%s</label></option></p>", $k, $y);
                }
            }

            ?>
        </select>
    </div>





<!--    <div class="form-group">
        <label for="date_start" >с</label>
        <div class="input-group date" id="date_start_rep4" style="width: 140px">
<?php
//if (isset($_POST['date_start']) && $_POST['date_start'] != '0000-00-00 00:00:00' && $_POST['date_start'] != NULL && \DateTime::createFromFormat('d.m', $_POST['date_start'])) {

    ?>
                <input type="text" class="form-control datetime"  name="date_start"  value="<= $_POST['date_start'] ?>"/>

                <?php
          //  } else {

                ?>
                <input type="text" class="form-control datetime"  name="date_start" value="<=$monday_cal?>" />
                <?php
          //  }

            ?>

            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>

        </div>
    </div>


    <div class="form-group">
        <label for="date_end">&nbsp;до</label>
        <div class="input-group date" id="date_end_rep4" style="width: 140px">
<?php
//if (isset($_POST['date_end']) && $_POST['date_end'] != '0000-00-00 00:00:00' && $_POST['date_end'] != NULL && \DateTime::createFromFormat('d.m', $_POST['date_end'])) {

    ?>
                <input type="text" class="form-control datetime"  name="date_end"  value="< $_POST['date_end'] ?>"/>

                <?php
          //  } else {

                ?>
                <input type="text" class="form-control datetime"  name="date_end" value="<=$monday_next_cal?>" />
                <?php
           // }

            ?>

            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>-->



    <div class="form-group">
        <label for="type_save">Вид</label>
        <select class="form-control select2-multiple-form " multiple="" name="type_save[]" id="type-save-id"  >
            <option value="1">Погибло всего</option>
            <option value="2">Погибло детей</option>
            <option value="3">Спасено всего</option>
            <option value="4">Спасено детей</option>
        </select>
    </div>




    <div class="form-group">
        <button class="btn bg-light-blue" type="button"  onclick="update(1);" >Показать</button>
    </div>

    <div class="form-group">
        <button class="btn bg-dark" type="button" onclick="resetFilter(1);">Сбросить фильтр</button>
    </div>

<!--    <div class="form-group">
        <button class="btn bg-yellow" type="submit"  name="btn_rep4_excel" >Экспорт в Excel</button>
    </div>-->

    <br> <br>

</form>


<br>

<!--<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i> -
При указании периода дат - данные формируются с 06:00 до 06:00
<br>-->
<!--<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i><span style="color: red"> -
    ...</span>-->