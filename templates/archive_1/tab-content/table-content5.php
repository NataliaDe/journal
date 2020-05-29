<?php
//print_r($result);

?>
<style>
            #archiveTable5_wrapper{
            width: 98%;
        }
        .dataTables_filter{
            display: none !important;
        }
        .inpt-archive-show{
          display: block !important;
        }

        #inptarchiveTable50,#inptarchiveTable51,#inptarchiveTable56,#inptarchiveTable57,#inptarchiveTable58,#inptarchiveTable59
        ,#inptarchiveTable60,#inptarchiveTable61,#inptarchiveTable62,#inptarchiveTable63,#inptarchiveTable64,#inptarchiveTable65{
            width: 38px;
        }
                #inptarchiveTable52,#inptarchiveTable53,#inptarchiveTable510,#inptarchiveTable511, #inptarchiveTable512, #inptarchiveTable513, #inptarchiveTable514
                , #inptarchiveTable515, #inptarchiveTable516, #inptarchiveTable517, #inptarchiveTable518, #inptarchiveTable519, #inptarchiveTable520, #inptarchiveTable521, #inptarchiveTable522{
            width: 53px;
        }
                        #inptarchiveTable54,#inptarchiveTable55{
            width: 100px;
        }

        #selrigForm6,#selrigForm7{
              width: 80px;
        }
</style>
<table class="table table-condensed   table-bordered table-custom" id="archiveTable5">
    <thead>
  <tr>
      <th>N</th>
      <th>ID</th>
      <th>Дата</th>
      <th>Вре-<br>мя</th>
      <th>Район</th>
      <th>Адрес</th>
      <th>Пог.</th>
      <th>В т.ч. детей</th>
      <th>Сп.</th>
      <th>Травм.</th>
      <th>Эвак.</th>
      <th>Сп.<br>(стр.)</th>
      <th>Повр.<br>(стр.)</th>
      <th>Уничт.<br>(стр.)</th>
      <th>Сп.<br>(техн.)</th>
      <th>Повр.<br>(техн.)</th>
      <th>Уничт.<br>(техн.)</th>
      <th>Сп.<br>(г.с.)</th>
      <th>Повр.<br>(г.с.)</th>
      <th>Уничт.<br>(г.с.)</th>
      <th>Сп.<br>(тонн)</th>
      <th>Повр.<br>(тонн)</th>
      <th>Уничт.<br>(тонн)</th>

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

$res_battle=array();
       // $res_battle=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        if(!empty($row['results_battle']))
         $res_battle= explode('#', $row['results_battle']);

        if(isset($res_battle) && !empty($res_battle) && count($res_battle) > 1 &&  max($res_battle) > 0){
             $i++;
            ?>
<tr  style='background-color:rgb(<?= $_SESSION['colors'][$row['id_rig']] ?>); '>
            <td><?= $i ?></td>
            <td><b><a href="<?= $baseUrl ?>/card_rig/<?= $table_name_year ?>/<?= $row['id_rig'] ?>" style="color:black" target="_blank" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку вызова"> <?= $row['id_rig'] ?></a></b></td>
            <td><?= date('d.m.Y', strtotime($row['date_msg'])) ?></td>
            <td><?= date('H:i', strtotime($row['time_msg'])) ?></td>
            <td><?= $row['local_name'] ?></td>
            <td><?= $row['address'] ?></td>
            <td><?= $res_battle[0] ?></td>
            <td><?= $res_battle[1] ?></td>
            <td><?= $res_battle[2] ?></td>
            <td><?= $res_battle[3] ?></td>
            <td><?= $res_battle[4] ?></td>
            <td><?= $res_battle[5] ?></td>
            <td><?= $res_battle[6] ?></td>
            <td><?= $res_battle[7] ?></td>
            <td><?= $res_battle[8] ?></td>
            <td><?= $res_battle[9] ?></td>
            <td><?= $res_battle[10] ?></td>
            <td><?= $res_battle[11] ?></td>
            <td><?= $res_battle[12] ?></td>
            <td><?= $res_battle[13] ?></td>
            <td><?= $res_battle[14] ?></td>
            <td><?= $res_battle[15] ?></td>
            <td><?= $res_battle[16] ?></td>

        </tr>
    <?php
        }
        ?>

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

                $('#archiveTable5').DataTable({
           // "pageLength": 50,
            "lengthMenu": [[-1,10, 25, 50], ["Все",10, 25, 50]],

             "order": [],
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



  $('#archiveTable5 tfoot th').each(function (i) {
        var table = $('#archiveTable5').DataTable();

                var title = $('#archiveTable5 tfoot th').eq($(this).index()).text();
                var x = $('#archiveTable5 tfoot th').index($(this));
                var y = 'archiveTable5';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint inpt-archive-show" id="inpt' + y + x + '" placeholder="Поиск" onkeyup="keyupField();"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');



    });
    $("#archiveTable5 tfoot input").on('keyup change', function () {
        var table = $('#archiveTable5').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

          });



function changeLinkExcel(){

        var id_rig=$('#inptarchiveTable51').val();
        var date_msg=$('#inptarchiveTable52').val();
        var time_msg=$('#inptarchiveTable53').val();
        var local=$('#inptarchiveTable54').val();
        var addr=$('#inptarchiveTable55').val();

//        var reason=$('#selrigForm6').val();
//        var work_view=$('#selrigForm7').val();
//
//        var detail_inf=$('#inptarchiveTable58').val();
//        var people=$('#inptarchiveTable59').val();
//        var time_loc=$('#inptarchiveTable510').val();
//        var time_likv=$('#inptarchiveTable511').val();

     //alert(reason);
      //alert(detail_inf);


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

//         if(reason === '' || reason === undefined)
//            reason='no';
//         if(work_view === '' || work_view === undefined)
//            work_view='no';
//
//
//         if(detail_inf === '' || detail_inf === undefined)
//            detail_inf='no';
//         if(people === '' || people === undefined)
//            people='no';
//         if(time_loc === '' || time_loc === undefined)
//            time_loc='no';
//         if(time_likv === '' || time_likv === undefined)
//            time_likv='no';




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
