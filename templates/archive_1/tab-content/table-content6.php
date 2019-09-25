<?php
//print_r($result);

?>
<style>
            #archiveTable6_wrapper{
            width: 98%;
        }
        .dataTables_filter{
            display: none !important;
        }
        .inpt-archive-show{
          display: block !important;
        }
        #inptarchiveTable60,#inptarchiveTable61,#inptarchiveTable611{
            width: 60px;
        }
                #inptarchiveTable62,#inptarchiveTable63, #inptarchiveTable66,#inptarchiveTable67,#inptarchiveTable68,
                #inptarchiveTable69,#inptarchiveTable610,#inptarchiveTable612,#inptarchiveTable613,
                #inptarchiveTable614{
            width: 86px;
        }
                        #inptarchiveTable64,#inptarchiveTable65{
            width: 100px;
        }
                        #inptarchiveTable69{
            width: 90px;
        }
        #selrigForm11,#selrigForm15{
              width: 80px;
        }
</style>

<?php

//foreach ($colors as $value) {
  ?>
<!--<div style='background-color:rgb(<$value?>); width:10px; height:10px; float:left;'></div>-->
<?php
//echo "<br/>";
//}
?>

<table class="table table-condensed   table-bordered table-custom" id="archiveTable6">
    <thead>
  <tr>
  <th>N</th>
    <th>ID</th>
    <th>Дата</th>
    <th>Время</th>
    <th>Район</th>
    <th>Адрес</th>
	<th>Техника</th>
	<th>Ном.знак</th>
	<th>Подразд.</th>
        <th>Вр.подачи<br>ствола</th>
        <th>Ствол</th>
        <th>Кол-во</th>
        <th>Израсх.воды/ПО<br>(тонн)</th>
	</tr>
</thead>

<tfoot>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>

    </tr>
</tfoot>

<tbody>
    <?php
    $i=0;
    foreach ($result as $row) {

        ?>



    <?php
    $arr_silymchs= explode('~', $row['trunk']);

    foreach ($arr_silymchs as $value) {
        if (!empty($value)) {
            $i++;

            /* mark#numsign$locorg_name%pasp_name?time_pod&trunk_name&cnt&water~mark#...... */
            $arr_mark = explode('#', $value);

            $mark = $arr_mark[0];


            $arr_time = explode('?', $arr_mark[1]);

            /* numsign$locorg_name%pasp_name */
            $car = $arr_time[0];
            $car_detail = explode('$', $car);
            $numbsign = $car_detail[0];

            $grochs_detail = explode('%', $car_detail[1]);
            $locorg_name = $grochs_detail[0];
            $pasp_name = $grochs_detail[1];


            /* all  after ? explode.  time_pod, trunk_name, cnt, water */
            $each_time = explode('&', $arr_time[1]);

            $time_pod = $each_time[0];
            $trunk_name = $each_time[1];
            $cnt = $each_time[2];
            $water = $each_time[3];

            ?>
                            <tr  style='background-color:rgb(<?= $_SESSION['colors'][$row['id_rig']] ?>); '>
                                <td><?= $i ?></td>
                                <td><b><a href="<?= $baseUrl ?>/card_rig/<?= $table_name_year ?>/<?= $row['id_rig'] ?>" style="color:black" target="_blank" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку вызова"><?= $row['id_rig'] ?></a></b></td>
                                <td><?= date('d.m.Y', strtotime($row['date_msg'])) ?></td>
                                <td><?= date('H:i', strtotime($row['time_msg'])) ?></td>
                                <td><?= $row['local_name'] ?></td>
                                <td><?= $row['address'] ?></td>
                                <td><?= $mark ?></td>
                                <td><?= $numbsign ?></td>
                                <td><?= $locorg_name ?>, <?= $pasp_name ?></td>
                                <td><?= ($time_pod == '0000-00-00 00:00:00' || empty($time_pod) || $time_pod == '-') ? '' : date('d.m.Y H:i', strtotime($time_pod)) ?></td>
                                <td><?= (empty($trunk_name) || $trunk_name == '-') ? '' : $trunk_name ?></td>
                                <td><?= (empty($cnt) || $cnt == '-' || $cnt == 0) ? '' : $cnt ?></td>
                                <td><?= (empty($water) || $water == '-' || $water == 0) ? '' : $water ?></td>
                            </tr>
            <?php
        }
    }

    ?>
<!--    <td>
        <
//        foreach ($mark as $value) {
//            echo $value.'<br>';
//        }
    ?>
    </td>
    <td>
        <
//        foreach ($t_exit as $value) {
//            echo $value.'<br>';
//        }
    ?>
    </td>-->
<!--	<td></td>
	<td>< $row['time_loc'] ?></td>
        	<td>< $row['time_likv'] ?></td>
	<td></td>
	<td></td>
        	<td></td>
	<td></td>
	<td></td>-->

    <?php
    }
    ?>
<!--  <tr>
  <td>1</td>
    <td>40000</td>
    <td>27.02.2019</td>
    <td>20:00</td>
    <td>Сморгонский</td>
    <td>ул. Советская 12-23</td>
	<td>платные услуги</td>
	<td>уборка территории</td>
	<td>проведены работы по плановой уборке</td>
	<td>Иванов П.С.</td>
    </tr>
  <tr>
  <td>2</td>
   <td>40001</td>
    <td>27.02.2019</td>
    <td>20:00</td>
    <td>Сморгонский</td>
    <td>ул. Советская 12-23</td>
	<td>платные услуги</td>
	<td>уборка территории</td>
	<td>проведены работы по плановой уборке</td>
	<td>Иванов П.С.</td>
    </tr>
  <tr>
  <td>3</td>
   <td>40002</td>
    <td>27.02.2019</td>
    <td>20:00</td>
    <td>Сморгонский</td>
    <td>ул. Советская 12-23</td>
	<td>платные услуги</td>
	<td>уборка территории</td>
	<td>проведены работы по плановой уборке</td>
	<td>Иванов П.С.</td>
    </tr>-->
</tbody>
</table>

<br>
<a href="<?=$link_excel?>" id="link_to_excel"><button class="submit" type="submit" >Экспорт в Excel</button></a>
<input type="hidden" value="<?= $link_excel_hidden ?>" id="prev_link_to_excel">


        <script>

            (function ($, undefined) {
    $(function () {

                $('#archiveTable6').DataTable({
            "pageLength": 50,
             "lengthMenu": [[-1,10, 25, 50], ["Все",10, 25, 50]],
             "order": [[ 0, "asc" ]],
            language: {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }

            }
        });


    });


})(jQuery);

            $(document).ready(function () {
    $("tfoot").css("display", "table-header-group");//tfoot of table



  $('#archiveTable6 tfoot th').each(function (i) {
        var table = $('#archiveTable6').DataTable();

                var title = $('#archiveTable6 tfoot th').eq($(this).index()).text();
                var x = $('#archiveTable6 tfoot th').index($(this));
                var y = 'archiveTable6';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint inpt-archive-show" id="inpt' + y + x + '" placeholder="Поиск" onkeyup="keyupField();"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');



    });
    $("#archiveTable6 tfoot input").on('keyup change', function () {
        var table = $('#archiveTable6').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

          });



function changeLinkExcel(){

        var id_rig=$('#inptarchiveTable61').val();
        var date_msg=$('#inptarchiveTable62').val();
        var time_msg=$('#inptarchiveTable63').val();
        var local=$('#inptarchiveTable64').val();
        var addr=$('#inptarchiveTable65').val();



         if(id_rig === '' || id_rig === undefined)
            id_rig='no';
         if(date_msg === '' || date_msg === undefined)
            date_msg='no';
         if(time_msg === '' || time_msg === undefined)
            time_msg='no';
         if(local === '' || local === undefined)
            local='no';
         if(addr === '' || addr === undefined)
            addr='no';



      //var link_to_excel=id_rig+'/'+date_msg+'/'+time_msg+'/'+local+'/'+addr+'/'+reason+'/'+work_view+'/'+detail_inf+'/'+people+'/'+time_loc+'/'+time_likv;
      var link_to_excel=id_rig+'/'+date_msg+'/'+time_msg+'/'+local+'/'+addr;
      var prev_link_to_excel=$('#prev_link_to_excel').val();

      var new_link_to_excel=prev_link_to_excel+'/'+link_to_excel;
    //  alert(new_link_to_excel);

$('#link_to_excel').attr("href",new_link_to_excel);

    }


    function keyupField(){
         // Allow controls such as backspace, tab etc.
 //  var arr = [8,9,35,36,37,38,39,40,45,46,47,48,49,50,51,52,53,54,55,56,57,97,98,99,100,101,102,103,104,105,186,188,190,219,221,222];
  var arr = [8,9,35,36,37,38,39,40,45,46,47,48,49,50,51,52,53,54,55,56,57,97,98,99,100,101,102,103,104,105,186,188,190,219,221,222,111,187,189,191,220,226];

  // Allow letters
  for(var i = 65; i <= 90; i++){
    arr.push(i);
  }
//alert(event.which);
                    if(jQuery.inArray(event.which, arr) !== -1){

//alert('aaa');
changeLinkExcel();
  }
    }
        </script>
