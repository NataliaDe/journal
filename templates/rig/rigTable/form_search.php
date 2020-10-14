
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];

if($_SESSION['id_level']==1){
     $path=$baseUrl .'/rig/table/for_rcu/'.$id_page ;
}
else{
   $path=$baseUrl .'/rig/table' ;
}



if (date("H:i:s") <= '06:00:00') {//до 06 утра
    $default_start_date = date("Y-m-d", time() - (60 * 60 * 24));
    $default_end_date = date("Y-m-d");
} else {
    $default_start_date = date("Y-m-d");
    $default_end_date = date("Y-m-d", time() + (60 * 60 * 24));
}


$fields_filter = [];
if (isset($settings_user) && !empty($settings_user) && isset($settings_user['fields_filter']) && !empty($settings_user['fields_filter'])) {
    foreach ($settings_user['fields_filter'] as $row) {
        $fields_filter[] = $row['name_sign'];
    }
}
?>
<br>
    <form  role="form" class="form-inline" id="filterRigForm" method="POST" action=" <?= $path ?> ">

                <div class="form-group">
                    <label for="date_start" >с</label>
                    <div class="input-group date" id="date_start">
                        <?php
                              if (isset($_POST['date_start']) && $_POST['date_start'] != '0000-00-00 00:00:00' && $_POST['date_start'] != NULL) {
                                  ?>
                        <input type="text" class="form-control datetime"  name="date_start"  value="<?= $_POST['date_start'] ?>"/>

                        <?php
                              } elseif (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_start']) && !empty($_SESSION['remember_filter_date_start'])) {

                            ?>
                            <input type="text" class="form-control datetime"  name="date_start"  value="<?= $_SESSION['remember_filter_date_start'] ?>"/>
                            <?php
                        }
                              else{
                                  ?>
                            <input type="text" class="form-control datetime"  name="date_start" value="<?= $default_start_date ?>" />
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
                        } elseif (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 && isset($_SESSION['remember_filter_date_end']) && !empty($_SESSION['remember_filter_date_end'])) {

                            ?>
                            <input type="text" class="form-control datetime"  name="date_end"  value="<?= $_SESSION['remember_filter_date_end'] ?>"/>
                            <?php
                        } else {

                            ?>
                            <input type="text" class="form-control datetime"  name="date_end" value="<?= $default_end_date ?>" />
                            <?php
                        }

                        ?>

                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>

        <div class="form-group">
            <div class="checkbox checkbox-success">

                <input id="checkbox1" type="checkbox" name="remember_filter_date" value="1" <?= (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 ) ? 'checked' : '' ?>>
                <label for="checkbox1">
                    запомнить
                </label>
            </div>
        </div>

                <div class="form-group">
                    <button class="btn bg-purple" type="submit" data-toggle="tooltip" data-placement="top" title="С 06:00 до 06:00"  >Фильтр</button>
                </div>
           <div class="form-group">

               <?php
               if ($_SESSION['id_level'] == 1) {//rcu
                   ?>

               <a href="<?= $path ?>/0/1"> <button class="btn bg-yellow-active" type="button" >Сбросить</button></a>
               <?php
               }
               else{
                   ?>
               <a href="<?= $path ?>/1"> <button class="btn bg-yellow-active" type="button" >Сбросить</button></a>
               <?php
               }
               ?>

                </div>

<div id="filter-block" class="row <?= (!in_array('reasonrig', $fields_filter)) ? 'hide' : '' ?>
    <?= (isset($settings_user_br_table) && !empty($settings_user_br_table) && isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1) ? 'not-available' : '' ?>"

         style="padding-left: 27px; padding-top: 15px">
             <?php
             if (isset($settings_user_br_table) && !empty($settings_user_br_table) && isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1) {
                 if (isset($_POST['reasonrig']) && !empty($_POST['reasonrig'])) {
                     unset($_POST['reasonrig']);
                 }
             }

             ?>
        <div class="form-group div-not-available-select">
            <select class="chosen-select-deselect-single form-control not-available-select" data-placeholder="Причина вызова"  name="reasonrig[]" multiple=""  >
                <!--                <option value="">Причина вызова</option>-->
                <?php
                foreach ($reasonrig as $row) {

                    if ($row['id'] != 0) {

                        ?>
                        <option value="<?= $row['id'] ?>" <?=
                        ((isset($_POST['reasonrig']) && !empty($_POST['reasonrig']) && in_array($row['id'], $_POST['reasonrig'])) || (isset($_SESSION['is_remember_filter_date']) && $_SESSION['is_remember_filter_date'] == 1 &&
                        isset($_SESSION['remember_filter_reasonrig']) && !empty($_SESSION['remember_filter_reasonrig']) && in_array($row['id'], $_SESSION['remember_filter_reasonrig']) ) ) ? 'selected' : ''

                        ?>><?= $row['name'] ?></option>
                                <?php
                            }
                        }

                        ?>
            </select>


        </div>

        <label><i style="color:red" class="fa fa-info-circle <?= (isset($settings_user_br_table) && !empty($settings_user_br_table) && isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1) ? 'show' : 'hide' ?>" data-toggle="tooltip" data-placement="right" title='В режиме "Краткий вид" выбор не доступен. Значение не учитывается.'  ></i></label>
    </div>



    </form>




<?php
if ($_SESSION['id_level'] != 1) {

    ?>
    <br>
    <?php
}

?>


<style>
    .div-not-available-select .chosen-container-multi{
        width: 563px !important;
    }
</style>




