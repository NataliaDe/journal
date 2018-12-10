<?php

//print_r($classif);
?>
<div class="box-body">
<?php
//print_r($classif);
      include dirname(__FILE__) . '/classifForm.php';
?>
    <!--table with users-->

    <br>
</div>

<br>
<div class="table-responsive"  >
    <br><br>
    <table class="table table-condensed   table-bordered table-custom" id="listmailTable" >
        <!-- строка 1 -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Наименование подразделения</th>
                  <th>Адрес эл. почты</th>
                  <th>Последние<br>действия</th>                  
                <th>Ред.</th>
                <th>Уд.</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                 <th>id</th>
                <th>Наименование</th>
                 <th>Адрес</th>
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
               <td ><?= $value['pasp_name'] ?><br><?= $value['locorg_name'] ?></td>
               <td><?= $value['mail']  ?></td>
           <td><?= $value['last_update'] ?></td>
           <td><input name="name_put<?= $value['id'] ?>" value="<?= $value['mail'] ?>"> 
               
       <button class="btn btn-xs btn-warning " type="submit" onclick="javascript:editClassif('name_put<?= $value['id']  ?>',<?= $value['id'] ?> ,'<?= $classif_active ?>' );">              

              
                       <i class="fa fa-pencil" aria-hidden="true"></i></button>
<!--               </a>-->
           </td>

           
                <td>
<!--                    <a href="<?= $baseUrl ?>/classif/<?= $classif_active?>/<?= $value['id'] ?>">-->
                    <button class="btn btn-xs btn-danger" type="submit" onclick="javascript:deleteClassif('name_put<?= $value['id']  ?>',<?= $value['id'] ?> ,'<?= $classif_active ?>' );" >
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
<!--                    </a>-->
                </td>
            </tr>          
  <?php
            }
            ?>
             



        </tbody>
    </table>

</div>
