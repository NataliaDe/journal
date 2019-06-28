<form  role="form" class="form-inline"  method="POST" action=" <?= $baseUrl ?>/remark">
    <label for="type_user" >Тип</label>
    <div class="form-group">

        <select class=" form-control" name="type_user"  data-placeholder="Выбрать"   >
            <option value="">все</option>
            <?php
            foreach ($remark_type as $re) {

                if (isset($_POST['type_user']) && $re['id'] == $_POST['type_user']) {
                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                } else
                    printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
            }

            ?>

        </select>
    </div>

 <label>Тип замечания (от РЦУРЧС)</label>
    <div class="form-group">

        <select class=" form-control" name="type_rcu_admin"  data-placeholder="Выбрать"    >
<option value="">все</option>
            <?php
foreach ($remark_type as $re) {
    if ( isset($_POST['type_rcu_admin']) && $re['id'] == $_POST['type_rcu_admin']) {
        printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
    } else
        printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
}

?>

        </select>
    </div>


  <label>Статус задачи (от РЦУРЧС)</label>
         <div class="form-group">

        <select class=" form-control" name="status_rcu_admin"  data-placeholder="Выбрать"   >
            <option value="">все</option>
  <?php
            foreach ($remark_status as $re) {

                 if(  isset($_POST['status_rcu_admin']) && $re['id']== $_POST['status_rcu_admin']){
                     printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                }
                else
                    printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);

            }

            ?>

            </select>
    </div>

   <label>Состояние</label>
         <div class="form-group">

        <select class=" form-control" name="is_delete"  data-placeholder="Выбрать"   >
            <option value="0" <?= (isset($_POST['is_delete']) && $_POST['is_delete'] == 0 ) ? 'selected': ''  ?>>активные</option>
            <option value="1" <?= (isset($_POST['is_delete']) && $_POST['is_delete'] == 1 ) ? 'selected': ''  ?>>удаленные</option>
            </select>
    </div>



    <div class="form-group">
        <button class="btn bg-purple" type="submit" >Фильтр</button>
    </div>
    <div class="form-group">
        <a href="<?= $baseUrl ?>/remark"> <button class="btn bg-yellow-active" type="button" >Сбросить фильтр</button></a>
    </div>




</form>