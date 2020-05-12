<!--chart by rb-->


<ul class="dropdown download-diagram" id="save-as-img-menu-chart-by-rb-year-id" style="float: right;" data-toggle="tooltip" data-placement="left" title="Скачать график" >
    <a href="# "  style="color: #222d32;" class="dropdown-toggle navbar-right-customer" data-toggle="dropdown" ><i class="fa fa-download" aria-hidden='true' style="color: #222d32;"></i><b class="caret"></b></a>
    <ul class="dropdown-menu save-as-img-ul" id="waybill-menu">

        <li class="dropdown-submenu" id="save-as-png-chart-by-rb-year-id">
            <a tabindex="-1" href="#" class="caret-spr_inf save-as-img-li" ><i class="fa fa-file-image-o save-as-img-i" aria-hidden="true" style="color:red;"></i> Скачать (png)</a>
        </li>

        <li class="dropdown-submenu" id="save-as-jpg-chart-by-rb-year-id">
            <a tabindex="-1" href="#" class="caret-spr_inf save-as-img-li" ><i class="fa fa-file-image-o save-as-img-i" aria-hidden="true" style="color:red;"></i> Скачать (jpg)</a>
        </li>


    </ul>
</ul>



<canvas id="chart-by-rb-year-id" ></canvas>



<script>


   $('#save-as-png-chart-by-rb-year-id').click(function(){
       $("#chart-by-rb-year-id").get(0).toBlob(function(blob){
           saveAs(blob, "Круговая по РБ за год.png");
       });
   });

   $('#save-as-jpg-chart-by-rb-year-id').click(function(){
       $("#chart-by-rb-year-id").get(0).toBlob(function(blob){
           saveAs(blob, "Круговая по РБ за год.jpg");
       });
   });


    data_chart_by_year = [];
    labels_chart_by_year = [];
    background=[];

<?php
if (isset($filter['type_save']) && !empty($filter['type_save'])) {

    ?>
    <?php
    if (in_array(1, $filter['type_save'])) {

        ?>
            data_chart_by_year.push(<?= $cnt_per_month_by_year['dead_man_percent'] ?>);
            labels_chart_by_year.push('Погибло всего: ' +<?= array_sum($cnt_per_month_by_year['dead_man']) ?>);
            background.push("rgba(255, 99, 132, 0.7)");
        <?php
    }
    if (in_array(2, $filter['type_save'])) {

        ?>
            data_chart_by_year.push(<?= $cnt_per_month_by_year['dead_child_percent'] ?>);
            labels_chart_by_year.push('Погибло детей: ' +<?= array_sum($cnt_per_month_by_year['dead_child']) ?>);
            background.push("rgba(255, 159, 64, 0.7)");
        <?php
    }
    if (in_array(3, $filter['type_save'])) {

        ?>
            data_chart_by_year.push(<?= $cnt_per_month_by_year['save_man_percent'] ?>);
            labels_chart_by_year.push('Спасено всего: ' +<?= array_sum($cnt_per_month_by_year['save_man']) ?> );
            background.push("rgba(255, 205, 86, 0.7)");
        <?php
    }
    if (in_array(4, $filter['type_save'])) {

        ?>
            data_chart_by_year.push(<?= $cnt_per_month_by_year['save_child_percent'] ?>);
            labels_chart_by_year.push('Спасено детей: ' +<?= array_sum($cnt_per_month_by_year['save_child']) ?>);
            background.push("rgba(75, 192, 192, 0.7)");

        <?php
    }
} else {

    ?>
        data_chart_by_year = [<?= $cnt_per_month_by_year['dead_man_percent'] ?>,
    <?= $cnt_per_month_by_year['dead_child_percent'] ?>,
    <?= $cnt_per_month_by_year['save_man_percent'] ?>,
    <?= $cnt_per_month_by_year['save_child_percent'] ?>];

        labels_chart_by_year = [
            'Погибло всего: ' +<?= array_sum($cnt_per_month_by_year['dead_man']) ?>+' чел.',
            'Погибло детей: ' +<?= array_sum($cnt_per_month_by_year['dead_child']) ?>+' чел.',
            'Спасено всего: ' +<?= array_sum($cnt_per_month_by_year['save_man']) ?>+' чел.',
            'Спасено детей: ' +<?= array_sum($cnt_per_month_by_year['save_child']) ?>+' чел.'

        ];

        background=["rgba(255, 99, 132, 0.7)", "rgba(255, 159, 64, 0.7)", "rgba(255, 205, 86, 0.7)", "rgba(75, 192, 192, 0.7)"];


    <?php
}

?>

    data = {
//        datasets: [{
//                data: [<= $cnt_per_month_by_year['dead_man_percent'] ?>,
//                <= $cnt_per_month_by_year['dead_child_percent'] ?>,
//                <= $cnt_per_month_by_year['save_man_percent'] ?>,
//                <= $cnt_per_month_by_year['save_child_percent'] ?>],
//                "backgroundColor": ["rgba(255, 99, 132, 0.7)", "rgba(255, 159, 64, 0.7)", "rgba(255, 205, 86, 0.7)", "rgba(75, 192, 192, 0.7)"]
//            }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
//        labels: [
//            'Погибло всего: '+<= array_sum($cnt_per_month_by_year['dead_man']) ?>,
//            'Погибло детей: '+<= array_sum($cnt_per_month_by_year['dead_child']) ?>,
//            'Спасено всего: '+<= array_sum($cnt_per_month_by_year['save_man']) ?>,
//            'Спасено детей: '+<= array_sum($cnt_per_month_by_year['save_child']) ?>
//
//        ]


        datasets: [{
                data: data_chart_by_year,
                "backgroundColor": background
            }],

        labels: labels_chart_by_year
    };



sum=0;
$.map( data_chart_by_year, function( val, i ) {
  // Do something
  sum=sum+val;
});


if(sum > 0){
     $('#empty-data-diag-by-rb-year-div').hide();
     $('#save-as-img-menu-chart-by-rb-year-id').show();

var ctx = document.getElementById("chart-by-rb-year-id").getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: data,
         options: {
   tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          var dataset = data.datasets[tooltipItem.datasetIndex];
           var labels = data.labels[tooltipItem.index];
//          var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
//            return previousValue + currentValue;
//          });
          var currentValue = labels+' - '+dataset.data[tooltipItem.index];
          //console.log(labels);

         // console.log(data);
         // var precentage = Math.floor(((currentValue/total) * 100)+0.5);
          return currentValue + "%";
        }
      }
    }
      }
    }
                //   options: options
    );
}
else{
  $('#empty-data-diag-by-rb-year-div').show();
  $('#save-as-img-menu-chart-by-rb-year-id').hide();
}



</script>