<div class="box-body">
<?php
      include dirname(__FILE__) . '/destinationForm.php';
?>
    <!--table with users-->

    <br>
</div>
<div class="table-responsive"  >
    <br><br>
    <table class="table table-condensed   table-bordered table-custom" id="destinationTable" >
        <!-- строка 1 -->
        <thead>
            <tr>
                <th style="width:190px;">Ф.И.О.</th>
                <th style="width:190px;">Должность</th>
                <th style="width:150px;">Подразделение</th>
                <th style="width:110px;">Звание</th>
                <th style="width:8px;">Уд.</th>

<!--                  <th>Последние<br>действия</th>                  
<th>Ред.</th>
<th>Уд.</th>-->

            </tr>
        </thead>

        <tbody>
            <?php
            foreach ($list as $value) {
                $id_rank = $value['id_rank'];
                $id_position = $value['id_position'];

                foreach ($position as $p) {
                    if ($p['id'] == $id_position) {
                        $position_name = $p['name'];
                    }
                }

                foreach ($rank as $p) {
                    if ($p['id'] == $id_rank) {
                        $rank_name = $p['name'];
                    }
                }
                ?>
                <tr>
                    <td id="td_fio<?= $value['id'] ?>">
                        <?= $value['fio'] ?>
<!--                        <button class="btn btn-xs btn-warning " type="submit" onclick="javascript:showDestinat('div_fio<?= $value['id'] ?>');">-->
                        <i class="fa fa-pencil" aria-hidden="true" onclick="javascript:showDestinat('div_fio<?= $value['id'] ?>');" data-toggle="tooltip" data-placement="right" title="Редактировать"></i>
<!--                        </button>-->

                        <div id="div_fio<?= $value['id'] ?>" style="display: none">
                            <br>
                            <input name="fio<?= $value['id'] ?>"  value="<?= $value['fio'] ?>" class="fio"> 
                            <button class="btn btn-xs btn-success " type="submit" onclick="javascript:editDestinat(<?= $value['id'] ?>, 'fio', 1);" data-toggle="tooltip" data-placement="right" title="Сохранить изменения">
                                <i class="fa fa-check" aria-hidden="true" ></i></button>
                        </div>
                    </td>

                    <td id="td_id_position<?= $value['id'] ?>">
                        <?= $position_name ?>
<!--                        <button class="btn btn-xs btn-warning " type="submit" onclick="javascript:showDestinat('div_position<?= $value['id'] ?>');">-->
                            <i class="fa fa-pencil" aria-hidden="true" onclick="javascript:showDestinat('div_position<?= $value['id'] ?>');" data-toggle="tooltip" data-placement="right" title="Редактировать"></i>
<!--                        </button>-->

                        <div id="div_position<?= $value['id'] ?>" style="display: none">
                            <br>
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="form-group">

                                        <select class="form-control" name="id_position<?= $value['id'] ?>"  >

                                            <?php
                                            foreach ($position as $p) {
                                                if ($p['id'] == $id_position) {
                                                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $p['id'], $p['name']);
                                                } else {
                                                    printf("<p><option value='%s' ><label>%s</label></option></p>", $p['id'], $p['name']);
                                                }
                                            }
                                            ?>

                                        </select>
 
                                    </div>
                                    

                                </div>

                                <div class="col-lg-1">

                               <button style="margin-top:5px;" class="btn btn-xs btn-success" type="submit" onclick="javascript:editDestinat(<?= $value['id'] ?>, 'id_position', 2);" data-toggle="tooltip" data-placement="right" title="Сохранить изменения">
                                        <i class="fa fa-check" aria-hidden="true"  ></i>
                        </button>     
                                </div>
                            </div>
                        </div>
                    </td>

                    <td id="td_pos_place<?= $value['id'] ?>"> 
                         <?= $value['pos_place'] ?>
<!--                        <button class="btn btn-xs btn-warning " type="submit" onclick="javascript:showDestinat('div_pos_place<?= $value['id'] ?>');">-->
                            <i class="fa fa-pencil" aria-hidden="true" onclick="javascript:showDestinat('div_pos_place<?= $value['id'] ?>');" data-toggle="tooltip" data-placement="right" title="Редактировать"></i>
<!--                        </button>-->
                        
                               <div id="div_pos_place<?= $value['id'] ?>" style="display: none">
                                   <br>
                                   <input name="pos_place<?= $value['id'] ?>"  value="<?= $value['pos_place'] ?>" class="pasp"> 

                        <button class="btn btn-xs btn-success " type="submit" onclick="javascript:editDestinat(<?= $value['id'] ?>, 'pos_place', 1);" data-toggle="tooltip" data-placement="right" title="Сохранить изменения">
                            <i class="fa fa-check" aria-hidden="true"></i></button>
                               </div>
                    </td>

                    <td id="td_id_rank<?= $value['id'] ?>">
                        <?= $rank_name ?>
<!--                        <button class="btn btn-xs btn-warning " type="button" onclick="javascript:showDestinat('div_rank<?= $value['id'] ?>');">-->
                            <i class="fa fa-pencil" aria-hidden="true" onclick="javascript:showDestinat('div_rank<?= $value['id'] ?>');" data-toggle="tooltip" data-placement="right" title="Редактировать"></i>
<!--                        </button>-->
                        <div id="div_rank<?= $value['id'] ?>" style="display: none">
                            <br>
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <select class="form-control" name="id_rank<?= $value['id'] ?>"  >

                                            <?php
                                            foreach ($rank as $p) {
                                                if ($p['id'] == $id_rank) {
                                                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $p['id'], $p['name']);
                                                } else {
                                                    printf("<p><option value='%s' ><label>%s</label></option></p>", $p['id'], $p['name']);
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1">

                                    <button style="margin-top:5px;"  class="btn btn-xs btn-success " type="submit" onclick="javascript:editDestinat(<?= $value['id'] ?>, 'id_rank', 2);" data-toggle="tooltip" data-placement="right" title="Сохранить изменения">
                                        <i class="fa fa-check" aria-hidden="true"></i></button>     
                                </div>
                            </div>
                        </div>
                    </td>

                                    <td>
                    <button class="btn btn-xs btn-danger" type="submit" onclick="javascript:deleteClassif('fio<?= $value['id']  ?>',<?= $value['id'] ?> ,'<?= $classif_active ?>' );" >
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