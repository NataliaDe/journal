
<?php
//echo $_SERVER['REQUEST_URI'];
?>
    <br><br>
    <form  role="form" class="form-inline" id="destinationForm" method="POST" action="<?= $baseUrl ?>/classif/<?= $classif_active?>/new/0">

                <div class="form-group">
                    <div class="input-group" >
                        <input type="text" class="form-control fio "  name="fio" placeholder="Ф.И.О."/>
                    </div>
                </div>
        
        


                                    <div class="form-group">
                                        <select class="form-control" name="id_position"  >

                                            <?php
                                            foreach ($position as $p) {
                                                    printf("<p><option value='%s' ><label>%s</label></option></p>", $p['id'], $p['name']);
                                            }
                                            ?>
                                        </select>
                                    </div>


        
        
        
                        <div class="form-group">
                    <div class="input-group" >
                        <input type="text" class="form-control pasp "  name="pos_place" placeholder="Подразделение" />
                    </div>
                </div>
        
        
        
                                    <div class="form-group">
                                        <select class="form-control" name="id_rank"  >

                                            <?php
                                            foreach ($rank as $p) {
                                                    printf("<p><option value='%s' ><label>%s</label></option></p>", $p['id'], $p['name']);
                                            }
                                            ?>
                                        </select>
                                    </div>

                <div class="form-group">
                    <button class="btn bg-green" type="submit"   >Добавить</button>
                </div>
                        <div class="form-group">
                            <button class="btn bg-yellow-active" type="button"   onclick="location.reload();"   data-toggle="tooltip" data-placement="right" title="Применить внесенные изменения" > <i class="fa fa-refresh" aria-hidden="true" ></i></button>
                </div>



    </form>
    

    



