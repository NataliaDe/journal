<p class="line"><span>Дополнительная информация по заявителю</span></p>
<div class="row">

    <div class="col-lg-2">
        <div class="form-group">

            <label for="address">Место жительства</label>
               <textarea class="form-control" rows="2" cols="22" placeholder="" name="address"><?= $address ?></textarea>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="position">Должность</label>
            <input type="text" class="form-control"  placeholder="" name="position"  value="<?= $position ?>">

        </div>
    </div> 
    
    <div class="col-lg-5"></div>
    <div class="col-lg-2">
       
    <div class="col-lg-2">
<?php

 include dirname(__FILE__) . '/buttonSaveRig.php';
?>
    </div>
    </div>

</div>

<p class="line"><span>Дополнительная детализированная информация</span></p>
<br>
<div class="row">

    <div class="col-lg-4">
        <div class="form-group">
            <label for="id_firereason">Причина пожара</label>
            <select class="js-example-basic-single form-control" name="id_firereason"  >
                <option value="">Выбрать</option>
                <?php
                foreach ($firereason as $row) {
                    if($id_firereason==$row['id']){
                          printf("<p><option value='%s' selected ><label>%s</label></option></p>", $row['id'], $row['name']);
                    }
                    elseif($row['is_delete'] != 1){
                        printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="firereason_descr">Причина пожара(пояснение)</label>
            <textarea class="form-control" rows="2" cols="22" placeholder="" name="firereason_descr"><?= $firereason_descr ?></textarea>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="version_reason">Версия причины</label>
            <textarea class="form-control" rows="2" cols="22" placeholder="" name="version_reason"><?= $version_reason ?></textarea>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <label for="inspector">Инспектор</label>
            <input type="text" class="form-control" placeholder="" name="inspector" value="<?=  $inspector?>"  >
        </div>
    </div>


</div>

<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-2"></div>
    <div class="col-lg-2"></div>
    <div class="col-lg-2"></div>
        <div class="col-lg-2">
        <div class="form-group">
<!--            <label for="id_statusrig">Статус вызова</label>-->
<!--<select class="js-example-basic-single form-control" name="id_statusrig" hidden="" >
                <option value="">Выбрать</option>
                <?php
//                foreach ($statusrig as $row) {
//                    if($id_statusrig==$row['id']){
//                         printf("<p><option value='%s'selected ><label>%s</label></option></p>", $row['id'], $row['name']);
//                    }
//                    elseif($row['is_delete'] != 1){
//                          printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
//                    }
//                      
//
//                }
                ?>
            </select>-->
<?php
$id_statusrig=0;//не выбрано
?>
<input type="text" value=<?= $id_statusrig ?> name="id_statusrig" hidden="" >
        </div>
    </div>
</div>


<p class="line"><span>Выезд оперативной группы</span></p>
<div class="row">

   <div class="col-lg-1">
                   <br>
                <div class="form-group">
                    <div class="checkbox checkbox-success">
                      <?php
                                    if (isset($is_opg) && $is_opg == 1) {
                                  ?>
                            <input id="checkbox2" type="checkbox" name="is_opg" value="1" checked="" onchange=" setOpgText(0);" >   
                            <?php
                        } else {
                            ?>
                            <input id="checkbox2" type="checkbox" name="is_opg" value="1" onchange=" setOpgText(1);" >                  
                            <?php
                        }
                        ?>
                        <label for="checkbox2">
                          Да
                        </label>
                    </div>
                </div>
            </div>
    
    <div class="col-lg-3">
        <div class="form-group">

            <label for="address">Описание</label>
              <?php
                                 if (isset($is_opg) && $is_opg == 1) {
                                  ?>
                              <textarea class="form-control" rows="2" cols="22" placeholder="" name="opg_text"><?= $opg_text ?></textarea>
                            <?php
                        } else {
                            ?>
                              <textarea class="form-control" rows="2" cols="22" placeholder="" name="opg_text" disabled=""><?= $opg_text ?></textarea>
                            <?php
                        }
                        ?>
            
        </div>
    </div>
    
             
    
</div>

<hr>

