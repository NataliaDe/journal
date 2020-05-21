
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];

?>
<br><br><br>

<p class="line"><span>
        <img src="<?= $baseUrl ?>/assets/images/bokk.png" style="width: 50px">
        Отчет по привлечению Белорусского общества Красного Креста

    </span></p>
<br><br>
<form  role="form" class="form-inline" name="rep1Form" id="bokkForm" method="POST" action="<?= $baseUrl ?>/report/bokk">

    <div class="form-group">
        <label for="year">Год</label>
        <select class="form-control" name="year" >

<!--            <option value="">Не выбран</option>-->
            <?php
            for ($i = 2020; $i <= date('Y'); $i++) {

                ?>
                <option value="<?= $i ?>" <?= ($i == date('Y')) ? 'selected' : '' ?>  ><?= $i ?></option>
                <?php }

            ?>

        </select>
    </div>




    <div class="form-group">
        <label for="id_region">Область</label>
        <select class="form-control" name="id_region" id="id_region_bokk"  >
            <option value="">Все</option>
            <?php
            if ($_SESSION['id_level'] == 1) {

                ?>
                <!--                        <option value="">все</option>              -->
                <?php
            }
            foreach ($region as $re) {
                if ($re['id'] == $_SESSION['id_region'] && $_SESSION['id_level'] != 1) {
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
        <select class="form-control" name="id_local" id="id_local_bokk"  >
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
    </div>



    <div class="form-group">
        <label for="reasonrig">Причина вызова</label>
        <select class=" chosen-select-deselect-single form-control" data-placeholder="Не выбрана" multiple="" name="reasonrig[]"   >

            <?php
            foreach ($reasonrig as $row) {
                if ($row['id'] != 0)
                    printf("<p><option value='%s' ><label>%s</label></option></p>", $row['id'], $row['name']);
            }

            ?>
        </select>
    </div>

    <div class="form-group">
        <button class="btn bg-purple" type="submit"  id="btn_rep1" >Сформировать</button>
    </div>



</form>
<br><br>
