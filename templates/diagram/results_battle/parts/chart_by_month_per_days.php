<!--chart-->

<ul class="dropdown download-diagram" id="save-as-img-menu-chart-id" style="float: right;" data-toggle="tooltip" data-placement="left" title="Скачать график" >
    <a href="# "  style="color: #222d32;" class="dropdown-toggle navbar-right-customer" data-toggle="dropdown" ><i class="fa fa-download" aria-hidden='true' style="color: #222d32;"></i><b class="caret"></b></a>
    <ul class="dropdown-menu save-as-img-ul" id="waybill-menu">

        <li class="dropdown-submenu" id="save-as-png-chart-id">
            <a tabindex="-1" href="#" class="caret-spr_inf save-as-img-li" ><i class="fa fa-file-image-o save-as-img-i" aria-hidden="true" style="color:red;"></i> Скачать (png)</a>
        </li>

        <li class="dropdown-submenu" id="save-as-jpg-chart-id">
            <a tabindex="-1" href="#" class="caret-spr_inf save-as-img-li" ><i class="fa fa-file-image-o save-as-img-i" aria-hidden="true" style="color:red;"></i> Скачать (jpg)</a>
        </li>


    </ul>
</ul>

  <canvas id="chart-id" ></canvas>





 <script>

   $('#save-as-png-chart-id').click(function(){
       $("#chart-id").get(0).toBlob(function(blob){
           saveAs(blob, "Круговая за месяц.png");
       });
   });

   $('#save-as-jpg-chart-id').click(function(){
       $("#chart-id").get(0).toBlob(function(blob){
           saveAs(blob, "Круговая за месяц.jpg");
       });
   });

    data_chart_per_days = [];
    labels_chart_per_days = [];
    background=[];

<?php
if (isset($filter['type_save']) && !empty($filter['type_save'])) {

    ?>
    <?php
    if (in_array(1, $filter['type_save'])) {

        ?>
            data_chart_per_days.push(<?= $cnt_per_days['dead_man_percent'] ?>);
            labels_chart_per_days.push('Погибло всего: ' +<?= array_sum($cnt_per_days['dead_man']) ?>);
            background.push("rgba(255, 99, 132, 0.7)");
        <?php
    }
    if (in_array(2, $filter['type_save'])) {

        ?>
            data_chart_per_days.push(<?= $cnt_per_days['dead_child_percent'] ?>);
            labels_chart_per_days.push('Погибло детей: ' +<?= array_sum($cnt_per_days['dead_child']) ?>);
            background.push("rgba(255, 159, 64, 0.7)");
        <?php
    }
    if (in_array(3, $filter['type_save'])) {

        ?>
            data_chart_per_days.push(<?= $cnt_per_days['save_man_percent'] ?>);
            labels_chart_per_days.push('Спасено всего: ' +<?= array_sum($cnt_per_days['save_man']) ?> );
            background.push("rgba(255, 205, 86, 0.7)");
        <?php
    }
    if (in_array(4, $filter['type_save'])) {

        ?>
            data_chart_per_days.push(<?= $cnt_per_days['save_child_percent'] ?>);
            labels_chart_per_days.push('Спасено детей: ' +<?= array_sum($cnt_per_days['save_child']) ?>);
            background.push("rgba(75, 192, 192, 0.7)");

        <?php
    }
} else {

    ?>
        data_chart_per_days = [<?= $cnt_per_days['dead_man_percent'] ?>,
    <?= $cnt_per_days['dead_child_percent'] ?>,
    <?= $cnt_per_days['save_man_percent'] ?>,
    <?= $cnt_per_days['save_child_percent'] ?>];

        labels_chart_per_days = [
            'Погибло всего: ' +<?= array_sum($cnt_per_days['dead_man']) ?>+' чел.',
            'Погибло детей: ' +<?= array_sum($cnt_per_days['dead_child']) ?>+' чел.',
            'Спасено всего: ' +<?= array_sum($cnt_per_days['save_man']) ?>+' чел.',
            'Спасено детей: ' +<?= array_sum($cnt_per_days['save_child']) ?>+' чел.'

        ];

        background=["rgba(255, 99, 132, 0.7)", "rgba(255, 159, 64, 0.7)", "rgba(255, 205, 86, 0.7)", "rgba(75, 192, 192, 0.7)"];


    <?php
}

?>

    data = {
        datasets: [{
                data: data_chart_per_days,
                "backgroundColor": background
            }],

        labels: labels_chart_per_days
    };



sum_chart=0;
$.map( data_chart_per_days, function( val, i ) {
  // Do something
  sum_chart=sum_chart+val;
});



if(sum_chart>0){
      $('#empty-diag-by-obl-div').hide();
      $('#save-as-img-menu-chart-id').show();

        var ctx = document.getElementById("chart-id").getContext('2d');
     var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: data,
  options: {
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var labels = data.labels[tooltipItem.index];
//          var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
//            return previousValue + currentValue;
//          });
                        var currentValue = labels + ' - ' + dataset.data[tooltipItem.index];
                        //console.log(labels);

                        // console.log(data);
                        // var precentage = Math.floor(((currentValue/total) * 100)+0.5);
                        return currentValue + "%";
                    }
                }
            }
        }
});
}
else{
     $('#empty-diag-by-obl-div').show();
     $('#save-as-img-menu-chart-id').hide();
}

    </script>