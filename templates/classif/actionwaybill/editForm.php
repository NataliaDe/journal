<?php
foreach ($action as $value) {
    $reason_id = $value['reason_id'];
    $desc = $value['description'];
    $is_off = $value['is_off'];
    $id = $value['id'];
    $ord = $value['ord'];
    $id_work = $value['id_work_view'];
}

?>


<form     method="POST" action="<?= $baseUrl ?>/classif/actionwaybill/addForm/<?= $id ?>">

    <div class="row">
     <div class="col-lg-2">
    <div class="form-group">
        <label for="exampleInputEmail1">Причина вызова</label>

        <select class="js-example-basic-single form-control " name="id_reasonrig" id="id_reasonrig" >

            <?php
            foreach ($reasonrig as $r) {
                if ($r['id'] == $reason_id)
                    printf("<p><option selected value='%s' ><label>%s</label></option></p>", $r['id'], $r['name']);
                elseif ($r['id'] != 0)
                    printf("<p><option value='%s' ><label>%s</label></option></p>", $r['id'], $r['name']);
            }

            ?>

        </select>
    </div>
     </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="id_work_view">Вид работ</label>
            <select class="js-example-basic-single form-control" name="id_work_view"  id="id_workview" >
                <!--                <option value="">Выбрать</option>-->
                <?php
                foreach ($workview as $row) {
                    if ($row['is_delete'] != 1 && $row['id'] != 0 && $row['id'] == $id_work)
                        printf("<p><option value='%s' class='%s' selected><label>%s</label></option></p>", $row['id'], $row['id_reasonrig'], $row['name']);
                    elseif ($row['id'] != 0)
                        printf("<p><option value='%s' class='%s'><label>%s</label></option></p>", $row['id'], $row['id_reasonrig'], $row['name']);
                }

                ?>
            </select>
        </div>
    </div>
    </div>


    <div class="row">
        <div class="col-lg-5">
            <div class="form-group">
                <label for="exampleInputPassword1">Мера</label>
                <textarea id="myeditor1" name="myeditor[1]" ><?= $desc ?></textarea>

            </div>
        </div>

        <div class="col-lg-2">
            <div class="checkbox checkbox-success">


                <?php
                if (isset($is_off) && $is_off == 1) {

                    ?>
                    <input id="checkbox0" type="checkbox" name="is_off[1]" value="1" checked="" >
                    <?php
                } else {

                    ?>
                    <input id="checkbox0" type="checkbox" name="is_off[1]" value="1" >
                    <?php
                }

                ?>

                <label for="checkbox0">
                    Включать в путевку
                </label>
            </div>

        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label >
                    Порядок следования в путевке
                </label>
                <select class="js-example-basic-single form-control " name="ord[1]" >

                    <?php
                    for ($k = 1; $k <= 3; $k++) {
                        if ($ord == $k)
                            printf("<p><option value='%s' selected ><label>%s</label></option></p>", $k, $k);
                        else
                            printf("<p><option value='%s' ><label>%s</label></option></p>", $k, $k);
                    }

                    ?>

                </select>

            </div>
        </div>
    </div>





    <button type="submit" class="btn btn-success">Сохранить изменения</button>

</form>
<br>
<a href="<?= $baseUrl ?>/classif/actionwaybill" ><button type="button" class="btn btn-warning">Отмена</button></a>