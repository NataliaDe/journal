<?php
if($classif_active=='statusrig'){
    $is_statusrig=1;
}
else
    $is_statusrig=0;


if($classif_active == 'workview'){
    $is_workview=1;
}
else {
$is_workview=0;  
}

//print_r($classif);
?>
<div class="box-body">
<?php
      include dirname(__FILE__) . '/classifForm.php';
?>
    <!--table with users-->

    <br>
</div>

<br>
<div class="table-responsive"  >
    <br><br>
    <table class="table table-condensed   table-bordered table-custom" id="classifTable" >
        <!-- строка 1 -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Наименование</th>
                  <th>Последние<br>действия</th>                  
                <th>Ред.</th>
                <th>Уд.</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                 <th>id</th>
                <th>Наименование</th>
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
               <td id="new_name<?= $value['id'] ?>"><?= $value['name'] ?></td>
              
           <td><?= $value['last_update'] ?></td>
           <td><input name="name_put<?= $value['id'] ?>" value="<?= $value['name'] ?>"> 
<!--               <a href="<?= $baseUrl ?>/classif/<?= $classif_active?>/new/<?= $value['id'] ?>"> -->
               
               <?php
               
               if(isset($is_statusrig) && $is_statusrig==1){//статус выезда - можно редактировать цвет
                   ?>
               <input name="color_put<?= $value['id'] ?>" style="background-color:<?= $value['color'] ?>" value="<?= $value['color'] ?>"> 
                <button class="btn btn-xs btn-warning " type="submit" onclick="javascript:editClassifStatusrig('name_put<?= $value['id']  ?>','color_put<?= $value['id']  ?>',<?= $value['id'] ?> ,'<?= $classif_active ?>' );">
               <?php
               }
 else {
     
         if(isset($is_workview) && $is_workview==1){//вид работ - можно редактировать причину выезда, к которой относится вид работ
                      $id_reasonrig=$value['id_reasonrig'];
                   ?>
                       <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Причина вызова</label>
                      <select class="js-example-basic-single form-control " name="id_reasonrig<?= $value['id'] ?>"  >

                                            <?php
                                            foreach ($reasonrig as $r) {
                                                if ($r['id'] == $id_reasonrig) {
                                                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $r['id'], $r['name']);
                                                } else {
                                                    printf("<p><option value='%s' ><label>%s</label></option></p>", $r['id'], $r['name']);
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                       </div>
     
     <?php
         }
     
     ?>
       <button class="btn btn-xs btn-warning " type="submit" onclick="javascript:editClassif('name_put<?= $value['id']  ?>',<?= $value['id'] ?> ,'<?= $classif_active ?>' );">              
                    <?php
 }
               
               ?>
              
                       <i class="fa fa-pencil" aria-hidden="true"></i></button>
<!--               </a>-->
           </td>

           
                <td>
                    <?php
                    if($value['id'] != 0){//запись с 0 удалить нельзя
                    ?>
                    
<!--                    <a href="<?= $baseUrl ?>/classif/<?= $classif_active?>/<?= $value['id'] ?>">-->
                    <button class="btn btn-xs btn-danger" type="submit" onclick="javascript:deleteClassif('name_put<?= $value['id']  ?>',<?= $value['id'] ?> ,'<?= $classif_active ?>' );" >
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
<!--                    </a>-->
                </td>
                <?php
                    }
                ?>
            </tr>          
  <?php
            }
            ?>
             



        </tbody>
    </table>

</div>
