<center><b>

        <?= (isset($head_date) && !empty($head_date)) ? $head_date : '' ?>
        <?= (isset($type_save_name) && !empty($type_save_name)) ? (', ' . implode(', ', $type_save_name)) : '' ?>
        по Республике
        <!--<= (isset($by_year) && !empty($by_year)) ? ('За '.$by_year.' год') : ('С '.$monday.' по '. $monday_next)?>
        -->
    </b></center>
<br>
<div class="row">

 <p class="empty-data" style="display: none" id="empty-data-all-diag-div">нет данных</p>

        <!-- bar by RB-->
        <div class="col-lg-6 border-diag" id="bar-id-div">

            <?php
            include 'bar_by_month.php';

            ?>
        </div>


        <!-- chart by RB-->
        <div class="col-lg-4 border-diag" id="chart-by-rb-id-div" style="margin-left: 50px;">
        
            <?php
            include 'chart_by_month.php';

            ?>
        </div>



</div>



<div class="row" id="diag-by-obl-div">


    <!--<div class="box-body">-->
    <?php
    include 'div-per-days-diag.php';

    ?>


</div>



