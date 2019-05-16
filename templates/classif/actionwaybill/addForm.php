<br><br>

<?php
if (isset($msg_success) && !empty($msg_success)) {

    ?>
    <div class="container">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Успех!</strong> <?= $msg_success ?>
        </div>
    </div>
    <?php
}

?>
<br><br>
<form     method="POST" action="<?= $baseUrl ?>/classif/actionwaybill/addForm/0">
    <div class="row">

         <div class="col-lg-2">
    <div class="form-group">
        <label for="exampleInputEmail1">Причина вызова</label>

        <select class="js-example-basic-single form-control " name="id_reasonrig" id="id_reasonrig" >

            <?php
            foreach ($reasonrig as $r) {
                if ($r['id'] != 0)
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
                  if ($row['is_delete'] != 1 && $row['id'] != 0)
                        printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_reasonrig'], $row['name']);

                }

                ?>
            </select>
        </div>
    </div>
    </div>

    <?php
    for ($i = 1; $i <= 3; $i++) {

        ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="exampleInputPassword1">Мера <?= $i ?></label>
                    <textarea id="myeditor<?= $i ?>" name="myeditor[<?= $i ?>]" ></textarea>

                </div>
            </div>

            <div class="col-lg-2">
                <div class="checkbox checkbox-success">

                    <input id="checkbox<?= $i ?>" type="checkbox" name="is_off[<?= $i ?>]" value="1" checked="">
                    <label for="checkbox<?= $i ?>">
                        Включать в путевку
                    </label>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label >
                        Порядок следования в путевке
                    </label>
                    <select class="js-example-basic-single form-control " name="ord[<?= $i ?>]" >

                        <?php
                        for ($k = 1; $k <= 3; $k++) {
                            if ($i == $k)
                                printf("<p><option value='%s' selected ><label>%s</label></option></p>", $k, $k);
                            else
                                printf("<p><option value='%s' ><label>%s</label></option></p>", $k, $k);
                        }

                        ?>

                    </select>

                </div>
            </div>
        </div>
        <?php
    }

    ?>




    <button type="submit" class="btn btn-success">Сохранить</button>
    <button type="submit" class="btn btn-danger" name="next">Сохранить и добавить следующий блок</button>
    <a href="<?= $baseUrl ?>/classif/actionwaybill" ><button type="button" class="btn btn-warning">Отмена</button></a>
</form>

