<!--Форма для выборки данных из файлов json-->

<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];
?>
<br>
<center><b>В стадии разработки. Для нужд ОВПО РЦУРЧС.</b></center>
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

<form  role="form" class="form" name="archiveForm" id="rep1Form" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">

    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">

                <label for="range_date">Доступные диапазоны</label>
                <select class="js-example-basic-multiple  form-control" name="archive_date[]"   multiple="multiple" onchange="javascript:yearOrDate();" >

                    <?php
                   // если выбран диапазон дат, то выбрать год нельзя и наоборот.
                    foreach ($archive_date as $ad) {
                        $start_d = new DateTime($ad['date_start']);
                        $start = $start_d->Format('d.m.Y');

                        $end_d = new DateTime($ad['date_end']);
                        $end = $end_d->Format('d.m.Y');
                        
                        if (isset($_POST['archive_date']) && in_array($ay['id'], $_POST['archive_date'])) {

                            printf("<p><option value='%s' selected ><label>с %s по %s</label></option></p>", $ad['id'], $start, $end);
                        } else {

                            printf("<p><option value='%s' ><label>с %s по %s</label></option></p>", $ad['id'], $start, $end);
                        }
                    }
                    ?>

                </select>
            </div>
        </div>

        <div class="col-lg-3">

            <div class="form-group">
                <label for="year">Год</label>
                <select class="form-control" name="archive_year" id="id_archive_year" onchange="javascript:yearOrDate();"  >

                    <option value="">Не выбран</option>              
                    <?php
                    foreach ($archive_year as $ay) {
                        if (isset($_POST['archive_year']) && $ay['id'] == $_POST['archive_year']) {
                            printf("<p><option value='%s' selected ><label>%s</label></option></p>", $ay['id'], $ay['year']);
                        } else {
                            printf("<p><option value='%s' ><label>%s</label></option></p>", $ay['id'], $ay['year']);
                        }
                    }
                    ?>

                </select>
            </div>
        </div>
    </div>  




    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="id_region">Область</label>
                <select class="form-control" name="id_region" id="id_region"  >

                    <option value="">все</option>              
                    <?php
                    foreach ($region as $re) {
                        if (isset($_POST['id_region']) && $re['id'] == $_POST['id_region']) {
                            printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                        } else {
                            printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                        }
                    }
                    ?>
                </select>
            </div>
        </div>


        <div class="col-lg-3">
            <div class="form-group">
                <label for="id_local">Район</label>
                <select class="form-control" name="id_local" id="auto_local"  >
                    <option value="">Все</option>
                    <?php
                    foreach ($local as $row) {
                        if (isset($_POST['id_local']) && $row['id'] == $_POST['id_local']) {
                            printf("<p><option value='%s' class='%s'  selected ><label>%s</label></option></p>", $row['id'], $row['id_region'], $row['name']);
                        } else {
                            printf("<p><option value='%s'   class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_region'], $row['name']);
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <button class="btn bg-purple" type="submit">Получить данные</button>
            </div>
        </div>
    </div>
</form>
