<div class="box-body">
    <?php
    include 'parts/button_create.php';

    ?>
</div>
<?php
if (isset($save) && $save == 1) {

    ?>
    <div class="container">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Успех!</strong> Информация сохранена в БД!
        </div>
    </div>
    <?php
}

?>


<center><u><b>Замечания на <?= date('d.m.Y H:i:s', strtotime($max_date)) ?></b></u></center>
<br><br>
<?php
include 'search_form.php';

?>

<br><br>
<table class="table table-condensed   table-bordered table-custom" id="remarkTableRcu" >
    <!-- строка 1 -->
    <thead>
        <tr>
            <th>ID</th>
            <th>Описание</th>
            <th>Дата создания</th>
            <th >Автор</th>
            <th >Контактная информация</th>
            <th >Примечание</th>
            <th>Тип</th>
            <th>Тип<br>(по оценке РЦУРЧС)</th>
            <th >Статус (от РЦУРЧС)</th>
            <th>Примечание (от РЦУРЧС)</th>
            <th>Созданы<br>мной</th>



        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Описание</th>
            <th>Дата создания</th>
            <th >Автор</th>
            <th >Контактная информация</th>
            <th >Примечание</th>
            <th></th>
            <th></th>
            <th ></th>
            <th></th>
            <th></th>



        </tr>
    </tfoot>
    <tbody>
        <?php
        foreach ($remarks as $value) {

            ?>
            <tr style="background-color: <?= (isset($value['color_type_rcu']) && $value['color_type_rcu'] != NULL) ? $value['color_type_rcu'] : '' ?>">
                <td><?= $value['id'] ?></td>
                <td><?= $value['description'] ?></td>
                <td><?= $value['date_insert'] ?>


                    <br><br>
                    <?php
                    if (isset($value['file_basename']) && !empty($value['file_basename'])) {
                        $path1 = $baseUrl . '/' . $value['file_name'];

                        ?>
                    <a href='<?= $path1 ?>' download=""><b> <?= $value['file_basename'] ?></b></a>.<br><br>

                        <?php
                    }

                    ?>
<!--                        <a href="< $baseUrl ?>/remark/edit_form/< $value['id'] ?>" download="" target="_blank"> </a>-->




                                    <br>
                    <a href="#" class="a-non-dec btn-show-remark-rcu-file-modal" data-id="<?= $value['id'] ?>" data-toggle="modal" data-target="#modal-media-multi" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Прикрепить">

                        <?php
                        if (isset($value['images_rcu']) && !empty($value['images_rcu'])) {

                            ?>
                            <i class="fa fa-check-circle-o" style="color: green"> файл-ответ</i>
                            <?php
                        } else {

                            ?>
                            файл-ответ
                            <?php
                        }

                        ?>

                    </a>
                </td>
                <td><?= $value['author'] ?></td>
                <td><?= $value['contact'] ?></td>
                <td><?= $value['note'] ?></td>
                <td><?= $value['type_user'] ?></td>
                <td><?= $value['type_rcu_admin'] ?></td>
                <td><?= $value['status_rcu_admin'] ?></td>
                <td><?= $value['note_rcu'] ?></td>
                <td><?php
                    if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $value['id_journal_user']) {
                        echo 'да';
                    } elseif (isset($_SESSION['id_ghost']) && $_SESSION['id_ghost'] == $value['id_ghost']) {
                        echo 'да';
                    } else {
                        echo 'нет';
                    }

                    ?>



                </td>



            </tr>
            <?php
        }

        ?>




    </tbody>
</table>

<?php
include 'modals/modal-media-multi.php';

?>






