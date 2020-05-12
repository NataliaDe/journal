<!--линейная-->

<ul class="dropdown download-diagram" id="save-as-img-menu-line-id" style="float: right;" data-toggle="tooltip" data-placement="left" title="Скачать график" >
    <a href="# "  style="color: #222d32;" class="dropdown-toggle navbar-right-customer" data-toggle="dropdown" ><i class="fa fa-download" aria-hidden='true' style="color: #222d32;"></i><b class="caret"></b></a>
    <ul class="dropdown-menu save-as-img-ul" id="waybill-menu">

        <li class="dropdown-submenu" id="save-as-png-line-id">
            <a tabindex="-1" href="#" class="caret-spr_inf save-as-img-li" ><i class="fa fa-file-image-o save-as-img-i" aria-hidden="true" style="color:red;"></i> Скачать (png)</a>
        </li>

        <li class="dropdown-submenu" id="save-as-jpg-line-id">
            <a tabindex="-1" href="#" class="caret-spr_inf save-as-img-li" ><i class="fa fa-file-image-o save-as-img-i" aria-hidden="true" style="color:red;"></i> Скачать (jpg)</a>
        </li>


    </ul>
</ul>

<canvas id="line-id" ></canvas>


<script>

   $('#save-as-png-line-id').click(function(){
       $("#line-id").get(0).toBlob(function(blob){
           saveAs(blob, "Линейный за месяц по дням.png");
       });
   });

   $('#save-as-jpg-line-id').click(function(){
       $("#line-id").get(0).toBlob(function(blob){
           saveAs(blob, "Линейный за месяц по дням.jpg");
       });
   });

    d = [];

    cnt_per_day_dead_man = {
        label: 'Погибло всего',
        //data: [{{ data.procent_process_study|join(',') }}],
        data: [<?= implode(',',$cnt_per_days['dead_man']) ?>],
        "fill": false,
        "borderColor": "rgb(255, 99, 132, 0.7)",
        "lineTension": 0.1

    };
console.log(cnt_per_day_dead_man);

    cnt_per_day_dead_child = {
        label: 'Погибло детей',
        //data: [{{ data.procent_process_study|join(',') }}],
        data: [<?= implode(',',$cnt_per_days['dead_child']) ?>],
        "fill": false,
        "borderColor": "rgb(255, 159, 64, 0.7)",
        "lineTension": 0.1

    };




    cnt_per_day_save_man = {
        label: 'Спасено всего',
        //data: [{{ data.procent_process_study|join(',') }}],
        data: [<?= implode(',',$cnt_per_days['save_man']) ?>],
        "fill": false,
        "borderColor": "rgb(255, 205, 86, 0.7)",
        "lineTension": 0.1


    };


    cnt_per_day_save_child = {
        label: 'Спасено детей',
        //data: [{{ data.procent_process_study|join(',') }}],
        data: [<?= implode(',',$cnt_per_days['save_child']) ?>],
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
            d.push(cnt_per_day_dead_man);
        <?php
    }
    if (in_array(2, $filter['type_save'])) {

        ?>
            d.push(cnt_per_day_dead_child);
        <?php
    }
    if (in_array(3, $filter['type_save'])) {

        ?>
            d.push(cnt_per_day_save_man);
        <?php
    }
    if (in_array(4, $filter['type_save'])) {

        ?>
            d.push(cnt_per_day_save_child);
        <?php
    }
} else {

    ?>
        d.push(cnt_per_day_dead_man);
        d.push(cnt_per_day_dead_child);
        d.push(cnt_per_day_save_man);
        d.push(cnt_per_day_save_child);

    <?php
}

?>

sum_2=0;
$.map( d, function( val, i ) {
  // Do something
  $.map( val.data, function( val, i ) {
  // Do something
  sum_2=sum_2+val;
});

});


if(sum_2 > 0){
     $('#empty-diag-by-obl-div').hide();
     $('#save-as-img-menu-line-id').show();

    var ctx = document.getElementById("line-id").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            //labels: ["Планируется: {{ data.planned|length }}", "Не начато: {{ data.no_started|length }}", "В процессе: {{ data.process|length }}", "Завершено успешно: {{ data.success_finish|length }}", "завершено неуспешно: {{ data.failed|length }}"],
            labels: [<?= implode(',',$cnt_per_days['days']) ?>],
            datasets: d
        },
        "options": {
            "scales": {"yAxes": [{"ticks": {"beginAtZero": true}
                    }]}
        }
    });

}
else{
 $('#empty-diag-by-obl-div').show();
 $('#save-as-img-menu-line-id').hide();
}
</script>