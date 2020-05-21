
<br><br>

<br>
<br>
<?php
//print_r($settings_user);
?>
<div style="width: 50%; margin-left: 30px">
<h4>Настройки пользователя</h4>
<form action="<?= $baseUrl ?>/settings/index/save" method="POST" >
<table class="table table-condensed   table-bordered table-custom"  >

        <!-- строка 1 -->
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Значение</th>

            </tr>
        </thead>
<!--        <tfoot>
            <tr>
                <th></th>
                <th></th>

            </tr>
        </tfoot>-->
        <tbody>

            <?php
            foreach ($all_settings as $setting) {
                $id_setting=$setting['id'];
                ?>
            <tr>
                <td>
                    <?= $setting['name'] ?>
                </td>
                <td>
<?php
if (isset($setting['type']) && $setting['type'] == 'fields_filter') {

                                $settings_user_br_table_1 = array();
                                if (isset($settings_user_br_table))
                                    $settings_user_br_table_1 = $settings_user_br_table;

                                ?>
                                <div class="form-group">
                                    <select class="js-example-basic-multiple form-control" multiple=""  name="fields_filter[]"   >

                                        <?php
                                        foreach ($settings_type[$id_setting] as $type) {

                                            if (!empty($settings_user) && in_array($type['id'], $settings_user)) {
                                                printf("<p><option value='%s' selected ><label>%s</label></option></p>", $type['id'], $type['val']);
                                            } else {
                                                printf("<p><option value='%s' ><label>%s</label></option></p>", $type['id'], $type['val']);
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>

                                <?php
                            } elseif(isset($settings_type[$id_setting])){
    ?>
      <div class="form-group">
                    <select class="form-control" name="type[]"   >

                        <?php



                        foreach ($settings_type[$id_setting] as $type) {

                            if (!empty($settings_user) && in_array($type['id'], $settings_user)) {
                                printf("<p><option value='%s' selected ><label>%s</label></option></p>", $type['id'], $type['val']);
                            } else {
                                printf("<p><option value='%s' ><label>%s</label></option></p>", $type['id'], $type['val']);
                            }

                        }
                        ?>
                    </select>
                </div>
                    <?php
 }
 
 
 elseif(isset($setting['type']) && $setting['type'] == 'br_table'){

     $settings_user_br_table_1=array();
     if(isset($settings_user_br_table))
         $settings_user_br_table_1=$settings_user_br_table;

     ?>

                    <div class="form-group" id="reason-rig-id">
                        <label for="id_reasonrig">Выберите необходимые причины</label>
                        <select class="js-example-basic-multiple form-control" name="id_reasonrig_for_br_table[]" multiple="multiple" >
<!--                            <option value="">Выбрать</option>-->
                            <?php
                            foreach ($reasonrig as $row) {
                                if (in_array($row['id'], $settings_user_br_table_1)) {
                                    printf("<p><option value='%s'selected ><label>%s</label></option></p>", $row['id'], $row['name']);
                                } elseif ($row['is_delete'] != 1 && $row['id'] != 0) {//удаленные записи не отображать
                                    printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
                                }
                            }

                            ?>
                        </select>
                    </div>

                    <?php

 }
 
 
?>


                </td>
            </tr>
            <?php
            }
            ?>


        </tbody>
    </table>
    <br> <br>
     <button class="btn btn-success" type="submit">Сохранить</button>
    <a href="<?= $baseUrl ?>/settings/index"> <button class="btn btn-default" type="button">Отмена</button></a>
</form>
</div>
