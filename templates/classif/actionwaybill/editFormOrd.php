 <br><br>
  <?php
     foreach ($action as $value) {

         $reason=$value['reason_id'];
         $id_work = $value['id_work_view'];

     }
         ?>


 <form     method="POST" action="<?= $baseUrl ?>/classif/actionwaybill/edit/ord/<?= $action_id?>/<?= $id_work ?>">

     <div class="row">
      <div class="col-lg-2">
    <div class="form-group" >
        <label for="exampleInputEmail1">Причина вызова</label>

        <select class="js-example-basic-single form-control " name="id_reasonrig" id="id_reasonrig" >


            <?php
            foreach ($reasonrig as $r) {
                if ($r['id'] == $reason)
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

     <?php
     $j=0;
     foreach ($action as $value) {
$i=$value['id'];
$j++;

    ?>
     <br>
        <p class="line"><span>Мера <?= $j ?></span></p>

     <div class="row">
         <div class="col-lg-6" >
     <div class="form-group">
<!--             <label for="exampleInputPassword1">Мера < $i ?></label>-->
<!--             <textarea id="myeditor<?= $i ?>" name="myeditor[< $i ?>]"  ></textarea>-->
<?= $value['description'] ?>
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
                         $cnt= count($action);
                         for ($k = 1; $k <= $cnt; $k++) {
                             if ($value['ord'] == $k)
                                 printf("<p><option value='%s' selected ><label>%s</label></option></p>", $k, $k);
                             else
                                 printf("<p><option value='%s' ><label>%s</label></option></p>", $k, $k);
                         }

                         ?>

                     </select>

                 </div>
             </div>

</div>
  <br>
     <?php
     }
     ?>


  <button type="submit" class="btn btn-success">Сохранить</button>

</form>

<br>
<a href="<?= $baseUrl ?>/classif/actionwaybill" ><button type="button" class="btn btn-warning">Отмена</button></a>

