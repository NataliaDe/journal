<?php

//print_r($classif);
?>
<div class="box-body">
<?php
      include dirname(__FILE__) . '/reasonrigcolorForm.php';
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
                <th>Наименование<br>Цвет</th>
                <th>Ред./Уд.</th>

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
            foreach ($list as $value) {
               ?>
                        <tr>
               <td><?= $value['id'] ?></td>
               <td id="new_name<?= $value['id'] ?>"><?= $value['name'] ?></td>
              
           <td><?= $value['last_update'] ?></td>
           <td>
<!--               <input name="name_put<?= $value['id'] ?>" value="<?= $value['name'] ?>"> -->
               
                         <label for="name" >Цвет <?= $value['color'] ?></label>
                         <input name="color<?= $value['id'] ?>" style="background-color:<?= $value['color'] ?>" value="<?= $value['color'] ?>" class="status_rig_color"> 
                 
               
               <div class="col-lg-3">
               <select class="js-example-basic-single form-control" name="id_reasonrig<?= $value['id'] ?>"  >
                                          
                                            <?php
                                            foreach ($statusrig as $p) {
                                                if($p['id'] == $value['id_reasonrig'])
                                                     printf("<p><option value='%s' selected ><label>%s</label></option></p>", $p['id'], $p['name']);
                                                else
                                                    printf("<p><option value='%s' ><label>%s</label></option></p>", $p['id'], $p['name']);
                                            }
                                            ?>
                                        </select>

               </div>
      
               <?php
               
             
                   ?>

                
<!--               </a>-->
           </td>
           
           
           

           
                <td>
                    <button class="btn btn-xs btn-warning " type="submit" onclick="javascript:editReasonrigUser('id_reasonrig<?= $value['id']  ?>','color<?= $value['id']  ?>',<?= $value['id'] ?>  );">

              
                       <i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button class="btn btn-xs btn-danger" type="submit" onclick="javascript:deleteReasonrigUser(<?= $value['id'] ?>); " >
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                </td>
            </tr>          
  <?php
            }
            ?>
             



        </tbody>
    </table>

</div>
