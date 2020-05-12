
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];

?>

<br>
<center><b>СУТОЧНАЯ СВОДКА о выезде пожарных аварийно-спасательных подразделений МЧС Республики Беларусь</b></center>

<br><br>
<form  role="form" class="form-inline" name="rep1Form"  method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">

    <div class="form-group">
        <label for="year">Год</label>
        <select class="form-control" name="year"  >

            <?php
            foreach (ARCHIVE_YEAR_LIST as $y) {
                if (isset($filter['year']) && !empty($filter['year']) && $filter['year'] == $y) {
                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $y, $y);
                }
                elseif(!isset($filter['year']) && $y== date('Y') ) {
                     printf("<p><option value='%s' selected ><label>%s</label></option></p>", $y, $y);

                }
                else {
                    printf("<p><option value='%s' ><label>%s</label></option></p>", $y, $y);
                }
            }

            ?>
        </select>
    </div>


    <div class="form-group">
        <label for="id_region">Область</label>
        <select class="form-control" name="id_region" id="id_region"  >
            <?php
            if ($_SESSION['id_level'] == 1) {

                ?>
                                        <option value="">все</option>
                <?php
            }
            foreach ($region as $re) {
                if(isset($filter['id_region']) && !empty($filter['id_region']) && $filter['id_region'] == $re['id']){
printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                }
                elseif ($re['id'] == $_SESSION['id_region'] && $_SESSION['id_level'] != 1) {
                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                } elseif ($_SESSION['id_level'] == 1) {
                    printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                }
            }

            ?>
        </select>
    </div>

<!--    <div class="form-group">
        <label for="id_local">Район</label>
        <select class="form-control" name="id_local" id="auto_local"  >
            <option value="">Все</option>
            <?php
            foreach ($local as $row) {
                if ($row['id'] == $_SESSION['id_local'] && $_SESSION['id_level'] != 1) {
                    printf("<p><option value='%s' class='%s'  selected ><label>%s</label></option></p>", $row['id'], $row['id_region'], $row['name']);
                } else {
                    printf("<p><option value='%s'   class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_region'], $row['name']);
                }
            }

            ?>
        </select>
    </div>-->









    <div class="form-group">
        <button class="btn bg-purple" type="submit"   >Сформировать</button>
    </div>

    <div class="form-group">
        <button class="btn bg-yellow" type="submit"  name="btn_rep3_excel" >Экспорт в Excel</button>
    </div>

    <br> <br>

</form>
<br>

<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i> -
Данные в столбце &laquo;С начала года&raquo; формируются автоматически, начиная с 1 октября 2019 года.
Для единовременного ввода данных за 2019 год с января по сентябрь  2019 года - обращаться в ОВПО РЦУРЧС.
<br>
<a href="<?= $baseUrl ?>/results_battle_for_archive_2019/0">ссылка для единовременного ввода данных за 2019 год с января по сентябрь 2019 года</a>
<!--<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i><span style="color: red"> -
    ...</span>-->