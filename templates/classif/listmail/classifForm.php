
<?php
//echo $_SERVER['REQUEST_URI'];

//print_r($region);


//exit();
?>
    <br><br>
    <form  role="form" class="form-inline" id="classifForm" method="POST" action="<?= $baseUrl ?>/classif/<?= $classif_active?>/new/0">



                <div class="form-group">
                    <label for="id_region">Область</label>
                    <select class="form-control" name="id_region" id="id_region1"  >

                        <?php
                        foreach ($region as $re) {
                                printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                        }
                        ?>
                    </select>
                </div>



                <div class="form-group">

                    <label for="id_locorg">Г(Р)ОЧС</label>
                    <select class="form-control" name="id_locorg" id="id_locorg1"  >
                        <option value="">Выбрать</option>
                        <?php
                        foreach ($locorg as $lo) {
                                printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $lo['id_locorg'], $lo['id_region'], $lo['locorg_name']);
                        }
                        ?>

                    </select>
                </div>
        
        
                        <div class="form-group">

                    <label for="id_pasp">ПАСЧ/ПАСП</label>
                    <select class="form-control" name="id_pasp" id="id_pasp1"   >
                        <option value="">Выбрать</option>
                        <?php
                         foreach ($pasp as $row) {
                                printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_loc_org'], $row['pasp_name']);
                        }
                        ?>

                    </select>
                </div>
        
        
        
                               <div class="form-group">

                    <label for="mail">Адрес эл.почты</label>
                    <input name="name" class="status_rig_color">
                </div>





                <div class="form-group">
                    <button class="btn bg-green" type="submit"   >Сохранить</button>
                </div>



    </form>
    

    


