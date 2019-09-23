
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];
?>
<br>
<center><b>Сведения о боевой работе подразделений по чрезвычайным ситуациям Республики Беларусь</b></center>

<br><br>
    <form  role="form" class="form-inline" name="rep2Form" id="rep2Form" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">

        <div class="form-group">
            <label for="year">Год</label>
            <select class="form-control" name="archive_year"  >

<!--                <option value="">Не выбран</option>-->
                <?php
                foreach ($archive_year as $ay) {
                  //  $period = ' (с 01.01 ' . ' по ' . date('d.m', strtotime($ay['max_date'])) . ')';
                    if (isset($_POST['archive_year']) && $ay['table_name'] == $_POST['archive_year']) {
                        printf("<p><option data-mad='%s' value='%s' selected ><label>%s</label></option></p>", date('Y-m-d', strtotime($ay['max_date'])), $ay['table_name'], mb_substr($ay['table_name'], 0, -1) );
                    } else {
                        printf("<p><option data-mad='%s' value='%s' ><label>%s</label></option></p>", date('Y-m-d', strtotime($ay['max_date'])), $ay['table_name'], mb_substr($ay['table_name'], 0, -1) );
                    }
                }

                ?>

            </select>
        </div>

<?php
$months=array('01'=>'январь', '02'=>'февраль', '03'=>'март', '04'=>'апрель', '05'=>'май', '06'=>'июнь', '07'=>'июль', '08'=>'август'
    , '09'=>'сентябрь', '10'=>'октябрь', '11'=>'ноябрь', '12'=>'декабрь');
?>
        <div class="form-group">
            <label for="month">Месяц</label>
            <select class="form-control" name="archive_month"  >

                <option value="">все</option>
                <?php
                foreach ($months as $k=>$v) {
                  //  $period = ' (с 01.01 ' . ' по ' . date('d.m', strtotime($ay['max_date'])) . ')';
                    if (isset($_POST['archive_month']) && $k == $_POST['archive_month']) {
                        printf("<p><option value='%s' selected ><label>%s</label></option></p>", $k,$v);
                    } else {
                        printf("<p><option value='%s' ><label>%s</label></option></p>", $k,$v );
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

<!--<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i> -
в соответствии с формой 2 Приложения 5 к Уставу службы органов и подразделений по чрезвычайным ситуациям Республики Беларусь.
<br>
<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i><span style="color: red"> -
    рекомендуем строить отчет за период не больше 1 недели в связи с большим объемом данных.</span>-->



<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?= $baseUrl ?>/assets/toastr/js/toastr.min.js"></script>

<script>

    if (<?= $is_error ?> === 1)
        toastr.error('В БД отсутствует информация', 'Ошибка!', {progressBar: true, timeOut: 5000});





</script>