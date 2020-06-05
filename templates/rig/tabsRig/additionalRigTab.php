<p class="line"><span>Дополнительная информация по собственнику</span></p>
<div class="row">




    <div class="col-lg-2">
        <div class="form-group" id="firereason-id">
            <label for="id_category">Категория</label>
            <select class="select2-owner form-control" name="id_owner_category"  >
                <option value="">Выбрать</option>
                <?php
                foreach ($owner_categories as $row) {
                    if (isset($rig['id_owner_category']) && $rig['id_owner_category'] == $row['id']) {
                        printf("<p><option value='%s' selected ><label>%s</label></option></p>", $row['id'], $row['name']);
                    } else {
                        printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
                    }
                }

                ?>
            </select>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="owner_fio">Ф.И.О.</label>
            <input type="text" class="form-control"  placeholder="" name="owner_fio"  value="<?= (isset($rig['owner_fio']) ? trim($rig['owner_fio']) : '') ?>">
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="owner_year_birthday">Год рождения</label>
            <input type="number" min="1920" max="<?= date("Y") ?>" class="form-control"  placeholder="" name="owner_year_birthday"  value="<?= (isset($rig['owner_year_birthday']) ? $rig['owner_year_birthday'] : '') ?>">
        </div>
    </div>




    <!--    <div class="col-lg-2">
            <div class="form-group">

                <label for="address">Место жительства</label>
                   <textarea class="form-control" rows="2" cols="22" placeholder="" name="address"><?= $address ?></textarea>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label for="position">Должность</label>
                <input type="text" class="form-control"  placeholder="" name="position"  value="<?= $position ?>">

            </div>
        </div>-->

    <div class="col-lg-5"></div>

    <div class="col-lg-2">
        <?php
        include dirname(__FILE__) . '/buttonSaveRig.php';

        ?>
    </div>


</div>



<div class="row">

    <div class="col-lg-2">
        <div class="form-group">

            <label for="address">Место жительства</label>
            <textarea class="form-control" rows="2" cols="22" placeholder="" name="owner_address"><?= (isset($rig['owner_address']) ? trim($rig['owner_address']) : '') ?></textarea>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="position">Должность</label>
            <input type="text" class="form-control"  placeholder="" name="owner_position"  value="<?= (isset($rig['owner_position']) ? trim($rig['owner_position']) : '') ?>">

        </div>
    </div>


    <div class="col-lg-2">
        <div class="form-group">

            <label for="address">Место работы</label>
            <textarea class="form-control" rows="2" cols="22" placeholder="" name="owner_job"><?= (isset($rig['owner_job']) ? trim($rig['owner_job']) : '') ?></textarea>
        </div>
    </div>
</div>


<p class="line"><span>Дополнительная детализированная информация</span></p>
<br>
<div class="row">

    <div class="col-lg-4">
        <div class="form-group" id="firereason-id">
            <label for="id_firereason">Причина пожара</label>
            <select class="js-example-basic-single form-control" name="id_firereason"  >
                <option value="">Выбрать</option>
                <?php
                foreach ($firereason as $row) {
                    if ($id_firereason == $row['id']) {
                        printf("<p><option value='%s' selected ><label>%s</label></option></p>", $row['id'], $row['name']);
                    } elseif ($row['is_delete'] != 1) {
                        printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
                    }
                }

                ?>
            </select>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="firereason_descr">Причина пожара(пояснение)</label>
            <textarea class="form-control" rows="2" cols="22" placeholder="" name="firereason_descr"><?= $firereason_descr ?></textarea>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="version_reason">Версия причины</label>
            <textarea class="form-control" rows="2" cols="22" placeholder="" name="version_reason"><?= $version_reason ?></textarea>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="inspector">Инспектор</label>
            <input type="text" class="form-control" placeholder="" name="inspector" value="<?= $inspector ?>"  >
        </div>
    </div>


</div>

<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-2"></div>
    <div class="col-lg-2"></div>
    <div class="col-lg-2"></div>
    <div class="col-lg-2">
        <div class="form-group">
            <!--            <label for="id_statusrig">Статус вызова</label>-->
            <!--<select class="js-example-basic-single form-control" name="id_statusrig" hidden="" >
                            <option value="">Выбрать</option>
            <?php
//                foreach ($statusrig as $row) {
//                    if($id_statusrig==$row['id']){
//                         printf("<p><option value='%s'selected ><label>%s</label></option></p>", $row['id'], $row['name']);
//                    }
//                    elseif($row['is_delete'] != 1){
//                          printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
//                    }
//
//
//                }

            ?>
                        </select>-->
            <?php
            $id_statusrig = 0; //не выбрано

            ?>
            <input type="text" value=<?= $id_statusrig ?> name="id_statusrig" hidden="" >
        </div>
    </div>
</div>


<p class="line"><span>Выезд оперативной группы</span></p>
<div class="row">

    <div class="col-lg-1">
        <br>
        <div class="form-group">
            <div class="checkbox checkbox-success">
                <?php
                if (isset($is_opg) && $is_opg == 1) {

                    ?>
                    <input id="checkbox2" type="checkbox" name="is_opg" value="1" checked="" onchange=" setOpgText(0);" >
                    <?php
                } else {

                    ?>
                    <input id="checkbox2" type="checkbox" name="is_opg" value="1" onchange=" setOpgText(1);" >
    <?php
}

?>
                <label for="checkbox2">
                    Да
                </label>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">

            <label for="address">Описание</label>
            <?php
            if (isset($is_opg) && $is_opg == 1) {

                ?>
                <textarea class="form-control" rows="2" cols="22" placeholder="" name="opg_text"><?= $opg_text ?></textarea>
    <?php
} else {

    ?>
                <textarea class="form-control" rows="2" cols="22" placeholder="" name="opg_text" disabled=""><?= $opg_text ?></textarea>
    <?php
}

?>

        </div>
    </div>



</div>

<hr>

