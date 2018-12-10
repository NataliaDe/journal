
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];
?>
<br>
<center><b>Форма для журнала регистрации поступающих сообщений в ЦОУ Г(Р)ОЧС (ПСЧ)</b></center>

<br><br>
    <form  role="form" class="form-inline" name="rep1Form" id="rep1Form" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">

                <div class="form-group">
                    <label for="date_start" >с</label>
                    <div class="input-group date" id="date_start">
                        <?php
                              if (isset($_POST['date_start']) && $_POST['date_start'] != '0000-00-00 00:00:00' && $_POST['date_start'] != NULL) {
                                  ?>
                        <input type="text" class="form-control datetime"  name="date_start"  value="<?= $_POST['date_start'] ?>"/>
                        
                        <?php
                              }
                              else{
                                  ?>
                            <input type="text" class="form-control datetime"  name="date_start" />
                        <?php
                              }
                        ?>
                    
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>


                <div class="form-group">
                    <label for="date_end">&nbsp;по</label>
                    <div class="input-group date" id="date_end">
                            <?php
                              if (isset($_POST['date_end']) && $_POST['date_end'] != '0000-00-00 00:00:00' && $_POST['date_end'] !=NULL) {
                                  ?>
                        <input type="text" class="form-control datetime"  name="date_end"  value="<?= $_POST['date_end'] ?>"/>
                        
                        <?php
                              }
                              else{
                                  ?>
                       <input type="text" class="form-control datetime"  name="date_end" />
                        <?php
                              }
                        ?>
                      
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
        

        <div class="form-group">
                    <label for="id_region">Область</label>
                    <select class="form-control" name="id_region" id="id_region"  >
   <?php
   if($_SESSION['id_level'] == 1){
       ?>
                        <option value="">все</option>              
                        <?php
   }
                        foreach ($region as $re) {
                            if ( $re['id'] == $_SESSION['id_region'] && $_SESSION['id_level'] != 1) {
                                printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                            } elseif($_SESSION['id_level']==1) {
                                printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                            }
                        }
                        ?>
                    </select>
                </div>
        
                <div class="form-group">
                    <label for="id_local">Район</label>
                    <select class="form-control" name="id_local" id="auto_local"  >
                        <option value="">Все</option>
                        <?php
                        
                        foreach ($local as $row) {
                            if ( $row['id'] == $_SESSION['id_local']  && $_SESSION['id_level'] != 1) {
                                printf("<p><option value='%s' class='%s'  selected ><label>%s</label></option></p>", $row['id'],$row['id_region'], $row['name']);
                            } else {
                                printf("<p><option value='%s'   class='%s' ><label>%s</label></option></p>", $row['id'],$row['id_region'], $row['name']);
                            }
                        }
                        ?>
                    </select>
                </div>
            

                <div class="form-group">
                    <button class="btn bg-purple" type="submit"   >Сформировать</button>
                </div>
    </form>
<br><br>

<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i> - 
в соответствии с формой 2 Приложения 5 к Уставу службы органов и подразделений по чрезвычайным ситуациям Республики Беларусь.