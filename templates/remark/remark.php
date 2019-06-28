<div class="box-body">
<?php
include 'parts/ghost_msg.php';

include 'parts/button_create.php';


?>

</div>


<?php
if(isset($save_remark) && $save_remark == 1){
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


<center><u><b>Замечания на <?= date('d.m.Y H:i:s',strtotime($max_date)) ?></b></u></center>


    <br><br>
    <table class="table table-condensed   table-bordered table-custom" id="remarkTable" >
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
                <th>Тип (по оценке РЦУРЧС)</th>
                <th >Статус (от РЦУРЧС)</th>
                <th>Примечание (от РЦУРЧС)</th>
<th>Созданы<br>мной</th>
                <th>Ред./Уд.</th>


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
                <th>Тип</th>
                <th>Тип<br>(по оценке РЦУРЧС)</th>
                <th >Статус (от РЦУРЧС)</th>
                <th>Примечание (от РЦУРЧС)</th>
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
        <td><?= $value['description'] ?>
            <br>
                <?php
                if (isset($value['file_basename']) && !empty($value['file_basename'])) {
                    $path1 = $baseUrl . '/' . $value['file_name'];

                    ?>
                    <a href='<?= $path1 ?>'><b> <?= $value['file_basename'] ?></b></a>.<br><br>

                    <?php
                }

                ?>

        </td>
        <td><?= $value['date_insert'] ?></td>
        <td><?= $value['author'] ?></td>
        <td><?= $value['contact'] ?></td>
        <td><?= $value['note'] ?></td>
        <td><?= $value['type_user'] ?></td>
        <td><?= $value['type_rcu_admin'] ?></td>
        <td><?= $value['status_rcu_admin'] ?></td>
        <td><?= $value['note_rcu'] ?></td>
                <td><?php

        if(isset($_SESSION['id_user']) && $_SESSION['id_user']== $value['id_journal_user']){
            echo 'да';
        }
        elseif(isset($_SESSION['id_ghost']) && $_SESSION['id_ghost']== $value['id_ghost']){
          echo 'да';
    }
    else{
        echo 'нет';
    }
        ?></td>

            <?php
            if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $value['id_journal_user']) {

                ?>

                <td>
                    <a href="<?= $baseUrl ?>/remark/edit_form/<?= $value['id'] ?>" target="_blank"> <button class="btn btn-xs btn-warning " type="button"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Редактировать замечание"></i></button></a>

                    <?php
                    if($value['status_id'] != 5){
                       ?>
                    <a href="<?= $baseUrl ?>/remark/<?= $value['id'] ?>" target="_blank"> <button class="btn btn-xs btn-danger" type="button"><i class="fa fa-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Удалить замечание"></i></button></a></td>
                    <?php
                    }
                    ?>

                <?php
            } elseif (isset($_SESSION['id_ghost']) && $_SESSION['id_ghost'] == $value['id_ghost']) {

                ?>
                <td>
                    <a href="<?= $baseUrl ?>/remark/edit_form/<?= $value['id'] ?>" target="_blank"> <button class="btn btn-xs btn-warning " type="button"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Редактировать замечание"></i></button></a>

                                        <?php
                    if($value['status_id'] != 5){
                       ?>
                    <a href="<?= $baseUrl ?>/remark/<?= $value['id'] ?>" target="_blank"> <button class="btn btn-xs btn-danger" type="button"><i class="fa fa-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Удалить замечание"></i></button></a></td>
                    <?php
                    }
                    ?>

                <?php
            } else {

                ?>
                <td></td>

                <?php
            }

            ?>


            </tr>
            <?php
            }




            ?>




        </tbody>
    </table>





