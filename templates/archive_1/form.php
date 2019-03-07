<!--Форма для выборки данных из файлов json-->

<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];
?>
<br>

<br><br>

<?php
if (isset($msg) && !empty($msg)) {
    ?>

    <div class="container">
        <div class="alert alert-success alert-success-custom">
            <strong><?= $msg ?></strong>
        </div>
    </div>
    <?php
}
?>
<h2>Архив выездов</h2><br>
<!-- action="< $_SERVER['REQUEST_URI'] ?>" -->
<form  role="form" class="form" name="archiveForm" id="rep1Form" method="post" >

    <div class="row">
        <div class="col-lg-2">
<div class="form-group">
                    <label for="date_start" >дата начала</label>
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



        </div>

        <div class="col-lg-2">

            <div class="form-group">
                    <label for="date_end">&nbsp;дата окончания</label>
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

        </div>


        <div class="col-lg-2">

            <div class="form-group">
                <label for="year">Год</label>
                <select class="form-control" name="archive_year" id="id_archive_year" >

                    <option value="">Не выбран</option>
                    <?php
                    foreach ($archive_year as $ay) {
                        if (isset($_POST['archive_year']) && $ay['table_name'] == $_POST['archive_year']) {
                            printf("<p><option value='%s' selected ><label>%s</label></option></p>", $ay['table_name'], $ay['table_name']);
                        } else {
                            printf("<p><option value='%s' ><label>%s</label></option></p>", $ay['table_name'], $ay['table_name']);
                        }
                    }
                    ?>

                </select>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label for="id_region">Область</label>
                <select class="form-control" name="id_region" id="id_region"  >

                    <option value="">все</option>
                    <?php
                    foreach ($region as $id=>$re) {
                        if (isset($_POST['id_region']) && $id == $_POST['id_region']) {
                            printf("<p><option value='%s' selected ><label>%s</label></option></p>", $id, $re);
                        } else {
                            printf("<p><option value='%s' ><label>%s</label></option></p>", $id, $re);
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label for="id_local">Район</label>
                <input class="form-control" type="text" name="id_local" placeholder="Введите первые символы">
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <button class="btn bg-purple" type="button"  id="getArchiveData">Получить данные</button>
            </div>
        </div>
    </div>
</form>


<div id="ajax-content">
    123
</div>
