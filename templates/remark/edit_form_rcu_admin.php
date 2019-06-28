<!-- <div class="container">-->

<form enctype="multipart/form-data" class="form-signin" style="max-width: 70%" role="form"  method="POST" action="<?= $baseUrl ?>/remark/remark_save/<?= $id_remark ?>">

    <h3 class="form-signin-heading" id="signin-heading">Новое замечание</h3>

    <?php
    foreach ($remark as $value) {
        ?>
    <div class="form-group">
        <label>Описание</label>
        <textarea class="form-control" cols="143" rows="10" name="description" required=""><?= $value['description'] ?></textarea>
    </div>

    <div class="form-group">
        <label>Автор создания (УМЧС, подразделение)</label>
        <textarea class="form-control" cols="143" rows="5" name="author" required=""><?= $value['author'] ?></textarea>
    </div>

    <div class="form-group">
        <label>Контактная информация (с кем связаться при возникновении вопросов)</label>
        <textarea class="form-control" cols="143" rows="5" name="contact" required=""><?= $value['contact'] ?></textarea>
    </div>

    <div class="form-group">
        <label>Примечание</label>
        <textarea class="form-control" cols="143" rows="5" name="note"><?= $value['note'] ?></textarea>
    </div>

        <div class="form-group">
        <label>Примечание (от РЦУРЧС)</label>
        <textarea class="form-control" cols="143" rows="5" name="note_rcu"><?= $value['note_rcu'] ?></textarea>
    </div>

    <div class="form-group">
        <label>Тип замечания (по Вашему мнению)</label>
        <select class="js-example-basic-single form-control" name="type_user"  data-placeholder="Выбрать"  required=""  >
            <?php
            foreach ($remark_type as $re) {

                if($re['id']== $value['type_user']){
                     printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                }
                else
                    printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);

            }

            ?>

            </select>
    </div>

    <div class="form-group">
        <label>Тип замечания (от РЦУРЧС)</label>
        <select class="js-example-basic-single form-control" name="type_rcu_admin"  data-placeholder="Выбрать"  required=""  >
            <?php
            foreach ($remark_type as $re) {
                    if ($re['id'] == $value['type_rcu_admin']) {
                        printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                    } else
                        printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                }

                ?>

        </select>
    </div>

        <div class="form-group">
        <label>Статус задачи (от РЦУРЧС)</label>
        <select class="js-example-basic-single form-control" name="status_rcu_admin"  data-placeholder="Выбрать"  required=""  >
            <?php
            foreach ($remark_status as $re) {

                 if($re['id']== $value['status_rcu_admin']){
                     printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                }
                else
                    printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);

            }

            ?>

            </select>
    </div>

    <?php
    }


    if(isset($value['file_basename']) && !empty($value['file_basename'])){
            $path1=$baseUrl.'/'.$value['file_name'];
        ?>
    Вы загрузили файл:<a href='<?= $path1 ?>'><b> <?= $value['file_basename'] ?></b></a>.<br><br>

    <?php

    }
    ?>



      <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->

    <?php
        if(isset($value['file_basename']) && !empty($value['file_basename'])){
        ?>
  Если хотите загрузить другой файл - выберите новый:
    <?php
    }
    else{
        ?>
 Отправить этот файл:
  <?php
    }
    ?>
    <input name="userfile" type="file" />
 <br>

 <div class="form-group">
     <div class="checkbox checkbox-danger">
         <input id="checkbox1" type="checkbox" name="is_file" value="1" >
         <label for="checkbox1">
             Не прикреплять файл
         </label>
     </div>
 </div>



    <br><br><br>
    <button class="btn btn-lg btn-success btn-block" type="submit">Сохранить замечание</button>
     <br>
        <a href="<?= $baseUrl ?>/remark"> <button class="btn btn-lg btn-warning btn-block" type="button">Отмена</button></a>

</form>

<!-- </div> /container -->

