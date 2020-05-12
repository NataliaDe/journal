<!-- line by RB by year -->

<ul class="dropdown download-diagram" id="save-as-img-menu-line_by_rb_year_id" style="float: right;" data-toggle="tooltip" data-placement="left" title="Скачать график" >
    <a href="# "  style="color: #222d32;" class="dropdown-toggle navbar-right-customer" data-toggle="dropdown" ><i class="fa fa-download" aria-hidden='true' style="color: #222d32;"></i><b class="caret"></b></a>
    <ul class="dropdown-menu save-as-img-ul" id="waybill-menu">

        <li class="dropdown-submenu" id="save-as-png-line_by_rb_year_id">
            <a tabindex="-1" href="#" class="caret-spr_inf save-as-img-li" ><i class="fa fa-file-image-o save-as-img-i" aria-hidden="true" style="color:red;"></i> Скачать (png)</a>
        </li>

        <li class="dropdown-submenu" id="save-as-jpg-line_by_rb_year_id">
            <a tabindex="-1" href="#" class="caret-spr_inf save-as-img-li" ><i class="fa fa-file-image-o save-as-img-i" aria-hidden="true" style="color:red;"></i> Скачать (jpg)</a>
        </li>


    </ul>
</ul>
<canvas id="line_by_rb_year_id" ></canvas>




<script>

   $('#save-as-png-line_by_rb_year_id').click(function(){
       $("#line_by_rb_year_id").get(0).toBlob(function(blob){
           saveAs(blob, "Линейный по РБ за год.png");
       });
   });

   $('#save-as-jpg-line_by_rb_year_id').click(function(){
       $("#line_by_rb_year_id").get(0).toBlob(function(blob){
           saveAs(blob, "Линейный по РБ за год.jpg");
       });
   });


    d = [];

    cnt_per_month_by_year_dead_man = {
        label: 'Погибло всего',
        //data: [{{ data.procent_process_study|join(',') }}],
        data: [<?= $cnt_per_month_by_year['dead_man'][1] ?>, <?= $cnt_per_month_by_year['dead_man'][2] ?>, <?= $cnt_per_month_by_year['dead_man'][3] ?>,
<?= $cnt_per_month_by_year['dead_man'][4] ?>, <?= $cnt_per_month_by_year['dead_man'][5] ?>, <?= $cnt_per_month_by_year['dead_man'][6] ?>,
<?= $cnt_per_month_by_year['dead_man'][7] ?>,
<?= $cnt_per_month_by_year['dead_man'][8] ?>,
<?= $cnt_per_month_by_year['dead_man'][9] ?>,
<?= $cnt_per_month_by_year['dead_man'][10] ?>,
<?= $cnt_per_month_by_year['dead_man'][11] ?>,
<?= $cnt_per_month_by_year['dead_man'][12] ?>],
        "fill": false,
        "borderColor": "rgb(255, 99, 132, 0.7)",
        "lineTension": 0.1

    };


    cnt_per_month_by_year_dead_child = {
        label: 'Погибло детей',
        //data: [{{ data.procent_process_study|join(',') }}],
        data: [<?= $cnt_per_month_by_year['dead_child'][1] ?>, <?= $cnt_per_month_by_year['dead_child'][2] ?>,
<?= $cnt_per_month_by_year['dead_child'][3] ?>,
<?= $cnt_per_month_by_year['dead_child'][4] ?>, <?= $cnt_per_month_by_year['dead_child'][5] ?>,
<?= $cnt_per_month_by_year['dead_child'][6] ?>,
<?= $cnt_per_month_by_year['dead_child'][7] ?>,
<?= $cnt_per_month_by_year['dead_child'][8] ?>,
<?= $cnt_per_month_by_year['dead_child'][9] ?>,
<?= $cnt_per_month_by_year['dead_child'][10] ?>,
<?= $cnt_per_month_by_year['dead_child'][11] ?>,
<?= $cnt_per_month_by_year['dead_child'][12] ?>],
        "fill": false,
        "borderColor": "rgb(255, 159, 64, 0.7)",
        "lineTension": 0.1

    };




    cnt_per_month_by_year_save_man = {
        label: 'Спасено всего',
        //data: [{{ data.procent_process_study|join(',') }}],
        data: [<?= $cnt_per_month_by_year['save_man'][1] ?>,
<?= $cnt_per_month_by_year['save_man'][2] ?>,
<?= $cnt_per_month_by_year['save_man'][3] ?>,
<?= $cnt_per_month_by_year['save_man'][4] ?>,
<?= $cnt_per_month_by_year['save_man'][5] ?>,
<?= $cnt_per_month_by_year['save_man'][6] ?>,
<?= $cnt_per_month_by_year['save_man'][7] ?>,
<?= $cnt_per_month_by_year['save_man'][8] ?>,
<?= $cnt_per_month_by_year['save_man'][9] ?>,
<?= $cnt_per_month_by_year['save_man'][10] ?>,
<?= $cnt_per_month_by_year['save_man'][11] ?>,
<?= $cnt_per_month_by_year['save_man'][12] ?>],
        "fill": false,
        "borderColor": "rgb(255, 205, 86, 0.7)",
        "lineTension": 0.1


    };


    cnt_per_month_by_year_save_child = {
        label: 'Спасено детей',
        //data: [{{ data.procent_process_study|join(',') }}],
        data: [<?= $cnt_per_month_by_year['save_child'][1] ?>,
<?= $cnt_per_month_by_year['save_child'][2] ?>,
<?= $cnt_per_month_by_year['save_child'][3] ?>,
<?= $cnt_per_month_by_year['save_child'][4] ?>,
<?= $cnt_per_month_by_year['save_child'][5] ?>,
<?= $cnt_per_month_by_year['save_child'][6] ?>,
<?= $cnt_per_month_by_year['save_child'][7] ?>,
<?= $cnt_per_month_by_year['save_child'][8] ?>,
<?= $cnt_per_month_by_year['save_child'][9] ?>,
<?= $cnt_per_month_by_year['save_child'][10] ?>,
<?= $cnt_per_month_by_year['save_child'][11] ?>,
<?= $cnt_per_month_by_year['save_child'][12] ?>],
        "fill": false,
        "borderColor": "rgb(75, 192, 192)",
        "lineTension": 0.1

    };

<?php
if (isset($filter['type_save']) && !empty($filter['type_save'])) {

    ?>
    <?php
    if (in_array(1, $filter['type_save'])) {

        ?>
            d.push(cnt_per_month_by_year_dead_man);
        <?php
    }
    if (in_array(2, $filter['type_save'])) {

        ?>
            d.push(cnt_per_month_by_year_dead_child);
        <?php
    }
    if (in_array(3, $filter['type_save'])) {

        ?>
            d.push(cnt_per_month_by_year_save_man);
        <?php
    }
    if (in_array(4, $filter['type_save'])) {

        ?>
            d.push(cnt_per_month_by_year_save_child);
        <?php
    }
} else {

    ?>
        d.push(cnt_per_month_by_year_dead_man);
        d.push(cnt_per_month_by_year_dead_child);
        d.push(cnt_per_month_by_year_save_man);
        d.push(cnt_per_month_by_year_save_child);

    <?php
}

?>

sum_year=0;
$.map( d, function( val, i ) {
  // Do something
  $.map( val.data, function( val, i ) {
  // Do something
  sum_year=sum_year+val;
});

});


if(sum_year > 0){
     $('#empty-data-diag-by-rb-year-div').hide();
     $('#save-as-img-menu-line_by_rb_year_id').show();

    var ctx = document.getElementById("line_by_rb_year_id").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {

            labels: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
            datasets: d
        },
        "options": {
            "scales": {"yAxes": [{"ticks": {"beginAtZero": true}
                    }]}
        }
    });
}
else{
    $('#empty-data-diag-by-rb-year-div').show();
    $('#save-as-img-menu-line_by_rb_year_id').hide();
}
</script>