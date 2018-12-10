
<?php
//echo $_SERVER['REQUEST_URI'];
?>
    <br><br>
    <form  role="form" class="form-inline" id="classifForm" method="POST" action="<?= $baseUrl ?>/classif/<?= $classif_active?>/new/0">

        
        
          <?php
        if($classif_active == 'workview'){
            ?>

        <div class="form-group" style="width: 180px">
   
                                             <select class="js-example-basic-single form-control " name="id_reasonrig"  >
                                              
                                            <?php
                                            foreach ($reasonrig as $r) {
                                                if($r['id'] == 0)
                                                      printf("<p><option selected value='%s' ><label>%s</label></option></p>", $r['id'], $r['name']);
                                                else
                                                    printf("<p><option value='%s' ><label>%s</label></option></p>", $r['id'], $r['name']);
                                            }
                                            ?>

                                        </select>
                                    </div>
        
        <?php
        }
        ?>
        
        
                <div class="form-group">
                    <div class="input-group date" id="date_start">
                        <input type="text" class="form-control "  name="name" placeholder="Вид работ" />
                    </div>
                </div>
        
        
        
      
        

                <div class="form-group">
                    <button class="btn bg-green" type="submit"   >Сохранить</button>
                </div>



    </form>
    

    


