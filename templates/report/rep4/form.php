
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];

?>
<br>
<center><b>Сведения о чрезвычайных ситуациях (в том числе пожарах), и их последствиях и боевой работе органов и подразделений по чрезвычайным ситуациям</b></center>
<!--<a href="<?= $baseUrl ?>/report/rep2" target="_blank" style="float: right; color: #b80509; border: 1px solid #b80509;" data-toggle="tooltip" data-placement="top" title="Перейти">
      <img src="<?= $baseUrl ?>/assets/images/3.png" style="width: 40px">
      &nbsp;Краткий отчет по боевой работе&nbsp;
  </a>-->
<br><br>

<form  role="form" class="form-inline" name="rep1Form"  method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">

    <div class="form-group">
        <label for="year">Год</label>
        <select class="form-control" name="year"  >

            <?php
            foreach (ARCHIVE_YEAR_LIST as $y) {
                if (isset($filter['year']) && !empty($filter['year']) && $filter['year'] == $y) {
                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $y, $y);
                } elseif(!isset($filter['year']) && $y== date('Y') ) {
                    printf("<p><option value='%s' selected><label>%s</label></option></p>", $y, $y);
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
                if (isset($filter['id_region']) && !empty($filter['id_region']) && $filter['id_region'] == $re['id']) {
                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                } elseif ($re['id'] == $_SESSION['id_region'] && $_SESSION['id_level'] != 1) {
                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                } elseif ($_SESSION['id_level'] == 1) {
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
                if (isset($filter['id_local']) && !empty($filter['id_local']) && $filter['id_local'] == $row['id']) {
                    printf("<p><option value='%s' class='%s'  selected ><label>%s</label></option></p>", $row['id'], $row['id_region'], $row['name']);
                }
                else {
                    printf("<p><option value='%s'   class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_region'], $row['name']);
                }
//                elseif ($row['id'] == $_SESSION['id_local'] && $_SESSION['id_level'] != 1) {
//                    printf("<p><option value='%s' class='%s'  selected ><label>%s</label></option></p>", $row['id'], $row['id_region'], $row['name']);
//                } elseif ($_SESSION['id_level'] == 1) {
//                    printf("<p><option value='%s'   class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_region'], $row['name']);
//                }
            }

            ?>
        </select>
    </div>




<!--    <div class="form-group">
        <label for="date_start" >с</label>
        <div class="input-group date" id="date_start_rep4" style="width: 140px">
<?php
//if (isset($_POST['date_start']) && $_POST['date_start'] != '0000-00-00 00:00:00' && $_POST['date_start'] != NULL && \DateTime::createFromFormat('d.m', $_POST['date_start'])) {

    ?>
                <input type="text" class="form-control datetime"  name="date_start"  value="< $_POST['date_start'] ?>"/>

                <?php
           // } else {

                ?>
                <input type="text" class="form-control datetime"  name="date_start" />
                <?php
           // }

            ?>

            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>


    <div class="form-group">
        <label for="date_end">&nbsp;по</label>
        <div class="input-group date" id="date_end_rep4" style="width: 140px">
<?php
//if (isset($_POST['date_end']) && $_POST['date_end'] != '0000-00-00 00:00:00' && $_POST['date_end'] != NULL && \DateTime::createFromFormat('d.m', $_POST['date_end'])) {

    ?>
                <input type="text" class="form-control datetime"  name="date_end"  value="< $_POST['date_end'] ?>"/>

                <?php
           // } else {

                ?>
                <input type="text" class="form-control datetime"  name="date_end" />
                <?php
           // }

            ?>

            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>-->




    <div class="form-group">
        <button class="btn bg-purple" type="submit"   >Сформировать</button>
    </div>

    <div class="form-group">
        <button class="btn bg-yellow" type="submit"  name="btn_rep4_excel" >Экспорт в Excel</button>
    </div>

    <br> <br>

</form>
<br>

<!--<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i> -
При указании периода дат - данные формируются с 06:00 до 06:00
<br>-->
<!--<i class="fa fa-hand-o-up" aria-hidden="true" style="color: red"></i><span style="color: red"> -
    ...</span>-->