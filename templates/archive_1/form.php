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
<h2>Архив выездов</h2>

<span class="glyphicon glyphicon-hand-up" style="color: red; font-size: 15px" ></span>
<span style="color: red; font-size: 15px">  При выборе большого диапазона (больше 1 недели) из-за большого объема данных запрос может быть НЕ ОБРАБОТАН.</b></span><br>
<i class="fa fa-book" aria-hidden="true"></i>&nbsp;
При необходимости построения специализированных запросов - обращаться в ОВПО для их реализации.
<br><br><br>
<!-- action="< $_SERVER['REQUEST_URI'] ?>" -->
<form  role="form" class="form" name="archiveForm" id="rep1Form" method="post" >

    <div class="row">

        <div class="col-lg-2">

            <div class="form-group">
                <label for="year">Год</label>
                <select class="form-control" name="archive_year" id="id_archive_year" >

                    <option value="">Не выбран</option>
                    <?php
                    foreach ($archive_year as $ay) {
                        $period = ' (с 01.01 ' . ' по ' . date('d.m', strtotime($ay['max_date'])) . ' 06:00:00)';
                        if (mb_substr($ay['table_name'], 0, -1) == '2019') {
                            $period = ' (с 01.01 06:00:00' . ' по ' . date('d.m', strtotime($ay['max_date'])) . ' 06:00:00*)';
                        } elseif (mb_substr($ay['table_name'], 0, -1) == '2020') {
                            $period = ' (с 01.01 00:00:00*' . ' до ' . date('d.m', strtotime($ay['max_date'])) . ' 06:00:00)';
                        }


                        if (isset($_POST['archive_year']) && $ay['table_name'] == $_POST['archive_year']) {
                            printf("<p><option data-mad='%s' value='%s' selected ><label>%s</label></option></p>", date('Y-m-d', strtotime($ay['max_date'])), $ay['table_name'], mb_substr($ay['table_name'], 0, -1) . $period);
                        } else {
                            printf("<p><option data-mad='%s' value='%s' ><label>%s</label></option></p>", date('Y-m-d', strtotime($ay['max_date'])), $ay['table_name'], mb_substr($ay['table_name'], 0, -1) . $period);
                        }
                    }

                    ?>

                </select>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label for="date_start" >дата начала (с 06:00:00)</label>
                <div class="input-group date" id="date_start">
                    <?php
                    if (isset($_POST['date_start']) && $_POST['date_start'] != '0000-00-00 00:00:00' && $_POST['date_start'] != NULL) {

                        ?>
                        <input type="text" class="form-control datetime"  name="date_start"  value="<?= $_POST['date_start'] ?>"/>

                        <?php
                    } else {

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
                <label for="date_end">&nbsp;дата окончания (до 06:00:00)</label>
                <div class="input-group date" id="date_end">
                    <?php
                    if (isset($_POST['date_end']) && $_POST['date_end'] != '0000-00-00 00:00:00' && $_POST['date_end'] != NULL) {

                        ?>
                        <input type="text" class="form-control datetime"  name="date_end"  value="<?= $_POST['date_end'] ?>"/>

                        <?php
                    } else {

                        ?>
                        <input type="text" class="form-control datetime"  name="date_end" />
                        <?php
                    }

                    ?>

                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>

        </div>




        <div class="col-lg-1">
            <div class="form-group">
                <label for="id_region">Область</label>
                <select class="form-control" name="id_region" id="id_region"  >

                    <option value="">все</option>
                    <?php
                    foreach ($region as $id => $re) {
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
                <input class="form-control" type="text" name="id_local" id="id_local_archive_1" placeholder="Введите первые символы">
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <label for="reasonrig">Причина вызова</label>
                <select class="js-example-basic-single form-control" name="reasonrig"  >
                    <option value="">Все</option>
                    <?php
                    foreach ($reasonrig as $row) {

                        printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
                    }

                    ?>
                </select>
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

<center>
    <div id="preload-get-archive-data" style="display:none;">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br><br>
        Идет загрузка данных...

    </div>
</center>

<center>
    <div id="preload-update-data-search-rig" style="display:none">
        <i class="fa fa-circle-o-notch fa-spin fa-4x fa-fw"></i>
        <span class="sr-only">Запрос выполняется. Ожидайте...</span>
    </div>
</center>

<div id="ajax-content">

</div>

<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script>

    $(document).ready(function () {
        $('body').on('change', '.selected-rig', function (e) {


            var ids = ($('#is_exclude_statistic').val()).split(',') || [];
            var ids_delete = ($('#is_exclude_statistic_for_delete').val()).split(',') || [];

            if ($(this).is(":checked") === true) {

                if (ids_delete.includes($(this).val())) {
                    var del = $(this).val();
                    $(ids_delete).each(function (index, value) {
                        if (value === del) {
                            ids_delete.splice(index, 1);
                        }
                    });
                }



                ids.push($(this).val());
            } else {

                if (ids.includes($(this).val())) {
                    var del = $(this).val();
                    $(ids).each(function (index, value) {
                        if (value === del) {
                            ids.splice(index, 1);
                        }
                    });
                }
                ids_delete.push($(this).val());
            }

            $('#is_exclude_statistic').val(ids);
            $('#is_exclude_statistic_for_delete').val(ids_delete);

            //alert('value=' + $('#is_exclude_statistic').val() + ' value for del = ' + $('#is_exclude_statistic_for_delete').val());

        });
    });




    function excludeStatistics(t) {

        var ids = $('#is_exclude_statistic').val();
        var ids_delete = $('#is_exclude_statistic_for_delete').val();
        var archive_year = $('select[name="archive_year"]').val();

        //alert('value=' + $('#is_exclude_statistic').val() + ' value for del = ' + $('#is_exclude_statistic_for_delete').val());

        $('#preload-update-data-search-rig').css('display', 'block');
        $('body').css('opacity', 0.5);

//$('#preload-get-archive-data').css('display','block');

        if ((ids !== '' || ids_delete !== '') && (ids !== ',' || ids_delete !== ',') && archive_year !== '') {
            $.ajax({
                type: 'POST',
                url: '/journal/archive_1/exclude_statistics',
                // dataType: 'json',
                data: {
                    ids: ids,
                    ids_delete: ids_delete,
                    tbl_name: archive_year
                },

                success: function (response) {

                    $('#modal_is_exclude_statistics').click();
                    $('#is_exclude_statistic').val('');
                    $('#is_exclude_statistic_for_delete').val('');

                    $('#preload-update-data-search-rig').css('display', 'none');
                    $('body').css('opacity', 1);

                    toastr.success('Данные сохранены ', 'Успех!', {timeOut: 5000});


                }
            });

        } else {
            toastr.error('Нет данных для сохранения ', 'Ошибка!', {timeOut: 5000});
            $('#modal_is_exclude_statistics').click();

        }
    }

</script>
