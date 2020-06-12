<!-- <div class="container">-->

<form enctype="multipart/form-data" class="form-signin" style="max-width: 70%" role="form"  method="POST" action="<?= $baseUrl ?>/remark/remark_save/0">

    <h3 class="form-signin-heading" id="signin-heading">Новое замечание</h3>
    <div class="form-group">
        <label>Описание</label>
        <textarea class="form-control" cols="143" rows="10" name="description" required=""></textarea>
    </div>


	<?php
if((isset($_SESSION['locorg_name']) && isset($_SESSION['user_name']))){
  $author=  $_SESSION['locorg_name'].', '.$_SESSION['user_name'];
}
elseif(isset ($_SESSION['id_ghost'])){
    $author='Гость';
}
else{
    $author='';
}
?>

    <div class="form-group">
        <label>Автор создания (УМЧС, подразделение)</label>
        <textarea class="form-control" cols="143" rows="5" name="author" required=""><?=$author?></textarea>
    </div>

    <div class="form-group">
        <label>Контактная информация (с кем связаться при возникновении вопросов)</label>
        <textarea class="form-control" cols="143" rows="5" name="contact" required=""></textarea>
    </div>

    <div class="form-group">
        <label>Примечание</label>
        <textarea class="form-control" cols="143" rows="5" name="note"></textarea>
    </div>

    <div class="form-group">
        <label>Примечание (от РЦУРЧС)</label>
        <textarea class="form-control" cols="143" rows="5" name="note_rcu"></textarea>
    </div>

    <div class="form-group">
        <label>Тип замечания (по Вашему мнению)</label>
        <select class="js-example-basic-single form-control" name="type_user"  data-placeholder="Выбрать"  required=""  >
            <?php
            foreach ($remark_type as $re) {

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

                    printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);

            }

            ?>

            </select>
    </div>

	         <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="900000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->

 Отправить этот файл: <input name="userfile" type="file" />
 <br>

 <div class="form-group">
     <div class="checkbox checkbox-danger">
         <input id="checkbox1" type="checkbox" name="is_file" value="1" >
         <label for="checkbox1">
             Не прикреплять выбранный файл
         </label>
     </div>
 </div>

    <br><br><br>
    <button class="btn btn-lg btn-success btn-block" type="submit">Сохранить замечание</button>
         <br>
        <a href="<?= $baseUrl ?>/remark"> <button class="btn btn-lg btn-warning btn-block" type="button">Отмена</button></a>

</form>

<!-- </div> /container -->

