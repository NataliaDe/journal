
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];
?>
<br>

<br><br>
    <form  role="form" class="form-inline" name="logsForm" id="rep1Form" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">

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
                    <button class="btn bg-purple" type="submit"   >Просмотреть</button>
                </div>
    </form>
