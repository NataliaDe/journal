
<!--                столбчатая-->

<ul class="dropdown download-diagram" id="save-as-img-menu-bar-id" style="float: right;" data-toggle="tooltip" data-placement="left" title="Скачать график" >
    <a href="# "  style="color: #222d32;" class="dropdown-toggle navbar-right-customer" data-toggle="dropdown" ><i class="fa fa-download" aria-hidden='true' style="color: #222d32;"></i><b class="caret"></b></a>
    <ul class="dropdown-menu save-as-img-ul" id="waybill-menu">

        <li class="dropdown-submenu" id="save-as-png-bar-id">
            <a tabindex="-1" href="#" class="caret-spr_inf save-as-img-li" ><i class="fa fa-file-image-o save-as-img-i" aria-hidden="true" style="color:red;"></i> Скачать (png)</a>
        </li>

        <li class="dropdown-submenu" id="save-as-jpg-bar-id">
            <a tabindex="-1" href="#" class="caret-spr_inf save-as-img-li" ><i class="fa fa-file-image-o save-as-img-i" aria-hidden="true" style="color:red;"></i> Скачать (jpg)</a>
        </li>


    </ul>
</ul>


<canvas id="bar-id" ></canvas>



<script>


   $('#save-as-png-bar-id').click(function(){
       $("#bar-id").get(0).toBlob(function(blob){
           saveAs(blob, "Столбчатая по РБ за год.png");
       });
   });

   $('#save-as-jpg-bar-id').click(function(){
       $("#bar-id").get(0).toBlob(function(blob){
           saveAs(blob, "Столбчатая по РБ за год.jpg");
       });
   });


mas=[];


 cnt_dead_man = {
                    label: 'Погибло всего',
                    //data: [{{ data.procent_process_study|join(',') }}],
                    data: [<?= $cnt_by_month_per_region['dead_man'][1] ?>,
                    <?= $cnt_by_month_per_region['dead_man'][2] ?>,
                    <?= $cnt_by_month_per_region['dead_man'][3] ?>,
                    <?= $cnt_by_month_per_region['dead_man'][4] ?>,
                    <?= $cnt_by_month_per_region['dead_man'][5] ?>,
                    <?= $cnt_by_month_per_region['dead_man'][6] ?>,
                    <?= $cnt_by_month_per_region['dead_man'][7] ?>],
                            "fill": false,
                            "backgroundColor": ["rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 0.2)",
                                "rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 0.2)"],
                            "borderColor": ["rgb(255, 99, 132)", "rgb(255, 99, 132)", "rgb(255, 99, 132)", "rgb(255, 99, 132)",
                                "rgb(255, 99, 132)", "rgb(255, 99, 132)", "rgb(255, 99, 132)"],
                            "borderWidth": 1,

                            barPercentage: 0.1,
                            categoryPercentage: 0.1,
                            maxBarThickness: 3,
                            minBarLength: 1

                };


                                cnt_dead_child = {
                    label: 'Погибло детей',
                    //data: [{{ data.procent_process_study|join(',') }}],
                    data: [<?= $cnt_by_month_per_region['dead_child'][1] ?>,
                    <?= $cnt_by_month_per_region['dead_child'][2] ?>,
                    <?= $cnt_by_month_per_region['dead_child'][3] ?>,
                    <?= $cnt_by_month_per_region['dead_child'][4] ?>,
                    <?= $cnt_by_month_per_region['dead_child'][5] ?>,
                    <?= $cnt_by_month_per_region['dead_child'][6] ?>,
                    <?= $cnt_by_month_per_region['dead_child'][7] ?>],
                            "fill": false,
                            "backgroundColor": ["rgba(255, 159, 64, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 159, 64, 0.2)",
                        "rgba(255, 159, 64, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 159, 64, 0.2)"],
                    "borderColor": ["rgb(255, 159, 64)", "rgb(255, 159, 64)", "rgb(255, 159, 64)", "rgb(255, 159, 64)",
                        "rgb(255, 159, 64)", "rgb(255, 159, 64)", "rgb(255, 159, 64)"],
                            "borderWidth": 1,

                            barPercentage: 0.1,
                            categoryPercentage: 0.1,
                            maxBarThickness: 3,
                            minBarLength: 1

                };


 cnt_save_man = {
                    label: 'Спасено всего',
                    //data: [{{ data.procent_process_study|join(',') }}],
                    data: [<?= $cnt_by_month_per_region['save_man'][1] ?>,
                    <?= $cnt_by_month_per_region['save_man'][2] ?>,
                    <?= $cnt_by_month_per_region['save_man'][3] ?>,
                    <?= $cnt_by_month_per_region['save_man'][4] ?>,
                    <?= $cnt_by_month_per_region['save_man'][5] ?>,
                    <?= $cnt_by_month_per_region['save_man'][6] ?>,
                    <?= $cnt_by_month_per_region['save_man'][7] ?>],
                            "fill": false,
 "backgroundColor": ["rgba(2, 107, 212, 0.3)", "rgba(2, 107, 212, 0.3)", "rgba(2, 107, 212, 0.3)",
                        "rgba(2, 107, 212, 0.3)", "rgba(2, 107, 212, 0.3)", "rgba(2, 107, 212, 0.3)", "rgba(2, 107, 212, 0.3)"],
                    "borderColor": ["rgb(2, 107, 212)", "rgb(2, 107, 212)", "rgb(2, 107, 212)", "rgb(2, 107, 212)", "rgb(2, 107, 212)",
                        "rgb(2, 107, 212)", "rgb(2, 107, 212)"],
                            "borderWidth": 1,

                            barPercentage: 0.1,
                            categoryPercentage: 0.1,
                            maxBarThickness: 3,
                            minBarLength: 1

                };



                                cnt_save_child = {
                    label: 'Спасено детей',
                    //data: [{{ data.procent_process_study|join(',') }}],
                    data: [<?= $cnt_by_month_per_region['save_child'][1] ?>,
                    <?= $cnt_by_month_per_region['save_child'][2] ?>,
                    <?= $cnt_by_month_per_region['save_child'][3] ?>,
                    <?= $cnt_by_month_per_region['save_child'][4] ?>,
                    <?= $cnt_by_month_per_region['save_child'][5] ?>,
                    <?= $cnt_by_month_per_region['save_child'][6] ?>,
                    <?= $cnt_by_month_per_region['save_child'][7] ?>],
                            "fill": false,
                    "backgroundColor": ["rgba(75, 192, 192, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(75, 192, 192, 0.2)",
                        "rgba(75, 192, 192, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(75, 192, 192, 0.2)"],
                    "borderColor": ["rgb(75, 192, 192)", "rgb(75, 192, 192)", "rgb(75, 192, 192)", "rgb(75, 192, 192)", "rgb(75, 192, 192)",
                        "rgb(75, 192, 192)", "rgb(75, 192, 192)"],
                            "borderWidth": 1,

                            barPercentage: 0.1,
                            categoryPercentage: 0.1,
                            maxBarThickness: 3,
                            minBarLength: 1

                };



<?php
if (isset($filter['type_save']) && !empty($filter['type_save'])) {

    ?>
    <?php
    if (in_array(1, $filter['type_save'])) {

        ?>
            mas.push(cnt_dead_man);
        <?php
    }
    if (in_array(2, $filter['type_save'])) {

        ?>
            mas.push(cnt_dead_child);
        <?php
    }
    if (in_array(3, $filter['type_save'])) {

        ?>
            mas.push(cnt_save_man);
        <?php
    }
    if (in_array(4, $filter['type_save'])) {

        ?>
            mas.push(cnt_save_child);
        <?php
    }
} else {

    ?>
        mas.push(cnt_dead_man);
        mas.push(cnt_dead_child);
        mas.push(cnt_save_man);
        mas.push(cnt_save_child);

    <?php
}

?>



sum_bar_month=0;
$.map( mas, function( val, i ) {
  // Do something
  $.map( val.data, function( val, i ) {
  // Do something
  sum_bar_month=sum_bar_month+val;
});

});



if(sum_bar_month > 0){
     $('#empty-data-all-diag-div').hide();
     $('#save-as-img-menu-bar-id').show();

    var ctx = document.getElementById("bar-id").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            //labels: ["Планируется: {{ data.planned|length }}", "Не начато: {{ data.no_started|length }}", "В процессе: {{ data.process|length }}", "Завершено успешно: {{ data.success_finish|length }}", "завершено неуспешно: {{ data.failed|length }}"],
            labels: ["Брестская", "Витебская", "г. Минск", "Гомельская", "Гродненская", "Минская", "Могилевская"],
            datasets: mas
        },
        "options": {
            "scales": {"yAxes": [{"ticks": {"beginAtZero": true}
                    }]}
        }
    });




    }
    else{
 $('#empty-data-all-diag-div').show();
 $('#save-as-img-menu-bar-id').hide();
}

</script>