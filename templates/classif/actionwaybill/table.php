<div class="box-body">

    <div class="form-group">
        <a href="<?= $baseUrl ?>/classif/<?= $classif_active ?>/addForm">   <button class="btn bg-green" type="button"   >Добавить</button></a>
        <button class="btn bg-red" type="button" id="btn_del_action" >Удалить выбранные элементы</button>
    </div>

</div>


<div class="table-responsive"  >
    <br><br>
    <table class="table table-condensed   table-bordered table-custom" id="classifTableActionWaybill" >
        <!-- строка 1 -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Причина вызова</th>
                <th>Вид работ</th>
                <th>Описание</th>
                <th>Включать в путевку</th>
                <th>Порядок след. в путевке</th>
                <th>Последние<br>действия</th>
                <th>Ред.</th>
                <th>Уд.</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>id</th>
                <th>Причина вызова</th>
                <th>Вид работ</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>

            </tr>
        </tfoot>
        <tbody>
            <?php
            foreach ($classif as $value) {

                ?>
                <tr>
                    <td><?= $value['id'] ?></td>
                    <td><?= $value['reason_name'] ?></td>
                    <td><?= $value['work_name'] ?></td>
                    <td><?= $value['description'] ?></td>
                    <td><?= ($value['is_off'] == 1) ? 'да' : 'нет' ?></td>
                    <td><?= $value['ord'] ?>
                        <a href="<?= $baseUrl ?>/classif/actionwaybill/edit/ord/<?= $value['reason_id'] ?>/<?= $value['id_work_view'] ?>" > <button class="btn btn-xs btn-info " type="submit" >
                                <i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                    </td>
                    <td><?= $value['last_update'] ?></td>
                    <td>
                        <a href="<?= $baseUrl ?>/classif/actionwaybill/edit/<?= $value['id'] ?>" > <button class="btn btn-xs btn-warning " type="submit" >
                                <i class="fa fa-pencil" aria-hidden="true"></i></button></a>

                    </td>


                    <td>

                        <input id="checkbox<?= $value['id'] ?>" type="checkbox" name="is_delete[<?= $value['id'] ?>]" value="<?= $value['id'] ?>" >
                        <!--                    <button class="btn btn-xs btn-danger" type="submit"  >
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>-->

                    </td>

                </tr>
                <?php
            }

            ?>

        </tbody>
    </table>

</div>
