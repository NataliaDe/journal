
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];
?>
<br>

<br><br>

<?php

if(isset($msg) && !empty($msg)){
   ?>

            <div class="container">
                <div class="alert alert-success alert-success-custom">
                    <strong><?= $msg ?></strong>
                </div>
            </div>
<?php
}

?>

    <form  role="form" class="form-inline" name="saveJsonForm" id="rep1Form" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">
        <b><span style="color:red; font-size: 16px">  Не забудьте сделать backup БД !!!</span></b><br><br><br>
         <b><span style="color:green; font-size: 14px">1. Сохранять данные за 1 месяц !!! Например, за сентябрь: с 2018-09-01 по 2018-10-01 (берутся выезды с 06 утра до 06 утра) </span></b><br><br>
          <b><span style="color:green; font-size: 14px">2. Удалить за выбранный диапазон дат информацию из БД (выполнить .sql файл) </span></b><br><br>
           <b><span style="color:green; font-size: 14px">3. Сбросить auto_increment </span></b><br><br><br>
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
                    <button class="btn bg-purple" type="submit"   >Сохранить в json-формат</button>
                </div>
    </form>
<br><br><br>
<?php
 include dirname(__FILE__) . '/table_archive_date.php';
 ?>
