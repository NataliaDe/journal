   <br> <br>
   <center><b>
<!--           <= (isset($by_year) && !empty($by_year)) ? ('За '.$by_year.' год') : ('С '.$monday.' по '. $monday_next)?>-->
<?= (isset($head_date) && !empty($head_date)) ? $head_date : ''?>
       <?= (isset($name_region_filter) && !empty($name_region_filter)) ? (', '.$name_region_filter) : '' ?>
       <?= (isset($name_local_filter) && !empty($name_local_filter)) ? (', '.$name_local_filter) : '' ?>
       </b></center>

<br>

<form  role="form" class="form-inline" name="diag-by-obl-form" id="diag-by-obl-form"  method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>" style="padding-left: 15px;">

    <div class="form-group ">
        <label for="id_region">Область</label>
        <select class="form-control js-example-basic-single-diag" name="id_region" id="id_region_diag"  >
            <?php
            if ($_SESSION['id_level'] == 1) {

                ?>
                <option value="">все</option>
                <?php
            }
            foreach ($region as $re) {
                if (isset($filter['id_region']) && !empty($filter['id_region']) && $filter['id_region'] == $re['id']) {
                    printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                } else {
                    printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                }
            }

            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="id_local">Район</label>
        <select class="form-control js-example-basic-single-diag" name="id_local" id="id_local_diag"  >
            <option value="">Все</option>
            <?php
            foreach ($local as $row) {
                if (isset($filter['id_local']) && !empty($filter['id_local']) && $filter['id_local'] == $row['id']) {
                    printf("<p><option value='%s' class='%s'  selected ><label>%s</label></option></p>", $row['id'], $row['id_region'], $row['name']);
                } else {
                    printf("<p><option value='%s'   class='%s' ><label>%s</label></option></p>", $row['id'], $row['id_region'], $row['name']);
                }
            }

            ?>
        </select>
    </div>


    <div class="form-group">
        <button class="btn bg-light-blue" type="button"  onclick="update(2);" >Показать</button>
    </div>

    <div class="form-group">
        <button class="btn bg-dark" type="button" onclick="resetFilter(2);">Сбросить фильтр</button>
    </div>

    <br> <br>
    <br><br>
</form>


<p class="empty-data" style="display: none" id="empty-diag-by-obl-div">нет данных</p>
<!-- line -->
<div class="col-lg-6 border-diag" id="line-id-div">
    <?php
    include 'line_by_month_per_days.php';

    ?>
</div>

<!-- chart -->
<div class="col-lg-4 border-diag" id="chart-id-div" style="margin-left: 50px;">
    <?php
    include 'chart_by_month_per_days.php';

    ?>
</div>

<!--<link rel="stylesheet" href="< $baseUrl ?>/assets/js/select2/select2.min.css">

<script src="< $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript"  src="< $baseUrl ?>/assets/js/jquery.chained.min.js"></script>
<script src="< $baseUrl ?>/assets/js/select2/select2.min.js" type="text/javascript" charset="utf-8"></script>-->


<script>
    $(document).ready(function () {
    $("#id_local_diag").chained("#id_region_diag");
    $('.js-example-basic-single-diag').select2();
    $('.js-example-basic-multiple-daig').select2();
    });


</script>
