
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];

if($_SESSION['id_level']==1){
     $path=$baseUrl .'/rig/table/for_rcu/'.$id_page ; 
}
else{
   $path=$baseUrl .'/rig/table' ;
}
?>
<br>
    <form  role="form" class="form-inline" id="filterRigForm" method="POST" action=" <?= $path ?> ">

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
                    <button class="btn bg-purple" type="submit" data-toggle="tooltip" data-placement="top" title="С 06:00 до 06:00"  >Фильтр</button>
                </div>
           <div class="form-group">
               <a href="<?= $path ?>"> <button class="btn bg-yellow-active" type="button" >Сбросить</button></a>
                </div>




    </form>
 
    

    


