
<form  role="form" class="form-inline" id="exporttoCsvRep1" method="POST" action=" <?= $baseUrl ?>/export/csv/rep1 ">

    <div class="form-group">
        <label for="date_start" >с</label>
        <div class="input-group date" id="date_start">
            <?php
            if (isset($_POST['date_start']) && $_POST['date_start'] != '0000-00-00 00:00:00' && $_POST['date_start'] != NULL) {

                ?>
                <input type="text" class="form-control datetime"  name="date_start"  value="<?= $_POST['date_start'] ?>"/>

                <?php
            } else {

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
            if (isset($_POST['date_end']) && $_POST['date_end'] != '0000-00-00 00:00:00' && $_POST['date_end'] != NULL) {

                ?>
                <input type="text" class="form-control datetime"  name="date_end"  value="<?= $_POST['date_end'] ?>"/>

                <?php
            } else {

                ?>
                <input type="text" class="form-control datetime"  name="date_end" />
    <?php
}

?>

            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>



    <div class="form-group">
        <label for="id_reasonrig">Причина вызова</label>
        <div class="input-group" >
            <select class="js-example-basic-single form-control" name="id_reasonrig" id="id_reasonrig" >
                <option value="">Выбрать</option>
                <?php
                foreach ($reasonrig as $row) {
                    if (isset($_POST['id_reasonrig']) && $_POST['id_reasonrig'] == $row['id']) {
                        printf("<p><option value='%s'selected ><label>%s</label></option></p>", $row['id'], $row['name']);
                    } elseif ($row['is_delete'] != 1 && $row['id'] != 0) {//удаленные записи не отображать
                        printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
                    }
                }

                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="limit">Кол-во выездов</label>
        <div class="input-group" >
            <input type="number" name="limit" value="<?= (isset($_POST['limit'])) ? $_POST['limit'] : '' ?>">
        </div>
    </div>




    <div class="form-group">
        <button class="btn bg-purple" type="submit" data-toggle="tooltip" data-placement="top" title="С 06:00 до 06:00"  >Фильтр</button>
    </div>
    <div class="form-group">
        <a href=" <?= $baseUrl ?>/export/csv/rep1"> <button class="btn bg-yellow-active" type="button" >Сбросить</button></a>
    </div>

</form>


<?php
if (isset($is_save) && !empty($is_save)) {

    ?>
    <br><br>
    <div class="container">
        <div class="alert alert-<?= $is_save[0] ?>">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Успех!</strong> <?= $is_save[1] ?>
        </div>
    </div>
    <?php
}

?>



