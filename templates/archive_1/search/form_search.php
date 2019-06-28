<!--Форма для выборки данных из файлов json-->

<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];
?>
<br>


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
<h3>Архив выездов. Поиск по ID выезда</h3>
<!--<span class="glyphicon glyphicon-hand-up" style="color: red; font-size: 15px" ></span>
<span style="color: red; font-size: 15px">  При выборе большого диапазона (больше 1 недели) из-за большого объема данных запрос может быть НЕ ОБРАБОТАН.</b></span><br>
<i class="fa fa-book" aria-hidden="true"></i>&nbsp;
При необходимости построения специализированных запросов - обращаться в ОВПО для их реализации.-->
<br>

<!-- action="< $_SERVER['REQUEST_URI'] ?>" -->
<form  role="form" class="form" name="archiveFormSearch" id="searchArchiveForm" method="post" action="<?= $baseUrl ?>/archive_1/search/rig">

    <div class="row">

                <div class="col-lg-2">
<?php
//print_r($archive_year);
?>
            <div class="form-group">
<!--                <label for="year">Год</label>-->
                <select class="form-control" name="archive_year" id="id_archive_year" >

                    <option value="">Выберите год</option>
                    <?php
                    foreach ($archive_year as $ay) {
                        $period=' (с 01.01 '.' по '. date('d.m', strtotime($ay['max_date'])).')';
                        if (isset($_POST['archive_year']) && $ay['table_name'] == $_POST['archive_year']) {
                            printf("<p><option data-mad='%s' value='%s' selected ><label>%s</label></option></p>",date('Y-m-d', strtotime($ay['max_date'])), $ay['table_name'], mb_substr($ay['table_name'], 0, -1).$period);
                        } else {
                            printf("<p><option data-mad='%s' value='%s' ><label>%s</label></option></p>",date('Y-m-d', strtotime($ay['max_date'])), $ay['table_name'], mb_substr($ay['table_name'], 0, -1).$period);
                        }
                    }
                    ?>

                </select>
            </div>
        </div>


        <div class="col-lg-2">
            <div class="form-group">
<!--                <label for="id_local">ID выезда</label>-->
<input class="form-control" type="text" name="id_rig" id="id_rig_seacrh_archive" placeholder="Введите ID выезда" value="<?= ( (isset($_POST['id_rig']))) ? $_POST['id_rig'] :'' ?>">
            </div>
        </div>



        <div class="col-lg-3">
            <div class="form-group">
                <button class="btn bg-purple" type="submit"  id="searchRigArchive"> <i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>

</form>

<?php
if(isset($result_search_empty) && $result_search_empty == 1){
    ?>
<center><b>Поиск не дал результатов.</b></center>
<?php
}

?>




