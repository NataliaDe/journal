<div class="row" id="diag-by-rb-year-div" style="margin:0px 0px 0px 0px">

    <center><b>

            <?= (isset($filter['year']) && !empty($filter['year'])) ? ($filter['year'] . ' год') : (date('Y') . ' год') ?>
            <?= (isset($type_save_name) && !empty($type_save_name)) ? (', ' . implode(', ', $type_save_name)) : '' ?>
            по Республике
        </b></center>

    <br>

  <p class="empty-data" style="display: none" id="empty-data-diag-by-rb-year-div">нет данных</p>
        <div class="col-lg-6 border-diag" id="line-id-div" >
            <?php
            include 'line_by_year.php';

            ?>
        </div>



  <div class="col-lg-4 border-diag" id="chart-by-rb-id-div" style="margin-left: 50px;">
            <?php
            include 'chart_by_year.php';

            ?>
        </div>




</div>

