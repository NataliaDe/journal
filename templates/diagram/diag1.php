<?php

foreach ($umchs_fair as $row) {
    $dataPoints1[]=array("label"=> $row['name'], "y"=> $row['vsego']);
}

foreach ($umchs_vsego as $row) {
    $dataPoints2[]=array("label"=> $row['name'], "y"=> $row['vsego']);
}
//РОСН, УГЗ, Авиация
foreach ($cp_fair as $row) {
    $dataPoints1[]=array("label"=> $row['name'], "y"=> $row['vsego']);
}

foreach ($cp_vsego as $row) {
    $dataPoints2[]=array("label"=> $row['name'], "y"=> $row['vsego']);
}


//$dataPoints1 = array(
//	array("label"=> "Брестская", "y"=> 36.12),
//	array("label"=> "Витебская", "y"=> 34.87),
//	array("label"=> "Гомельская", "y"=> 40.30),
//	array("label"=> "Гродненская", "y"=> 35.30),
//	array("label"=> "г.Минск", "y"=> 39.50),
//	array("label"=> "Минская обл.", "y"=> 50.82),
//	array("label"=> "Могилевская", "y"=> 74.70)
//);
//$dataPoints2 = array(
//	array("label"=> "Брестская", "y"=> 64.61),
//	array("label"=> "Витебская", "y"=> 70.55),
//	array("label"=> "Гомельская", "y"=> 72.50),
//	array("label"=> "Гродненская", "y"=> 81.30),
//	array("label"=> "г.Минск", "y"=> 63.60),
//	array("label"=> "Минская обл.", "y"=> 69.38),
//	array("label"=> "Могилевская", "y"=> 98.70)
//);
//
//print_r($dataPoints2);

?>

<br><br><br>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: ""
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Пожары",
		indexLabel: "{y}",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "ВСЕГО",
		indexLabel: "{y}",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>


<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="<?= $baseUrl ?>/assets/js/canvas/canvasjs.min.js"></script>