		<?php
//foreach ($result as $value) {
//    print_r($value['innerservice'])  ;
//}

?>
<style>
            #archiveTable4_wrapper{
            width: 98%;
        }
        .dataTables_filter{
            display: none !important;
        }
        .inpt-archive-show{
          display: block !important;
        }
        #inptarchiveTable40,#inptarchiveTable41{
            width: 60px;
        }
                #inptarchiveTable42,#inptarchiveTable43,#inptarchiveTable47,#inptarchiveTable48,
                #inptarchiveTable49,#inptarchiveTable410,#inptarchiveTable412,#inptarchiveTable413,
                #inptarchiveTable414{
            width: 86px;
        }
        #inptarchiveTable46{
             width: 86px;
        }
                        #inptarchiveTable44,#inptarchiveTable45{
            width: 100px;
        }
                        #inptarchiveTable49{
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

<table class="table table-condensed   table-bordered table-custom" id="archiveTable4">
    <thead>
  <tr>
  <th>N</th>
    <th>ID</th>
    <th>Дата</th>
    <th>Время</th>
    <th>Район</th>
    <th>Адрес</th>
		<th>Время сообщения</th>
	<th>Время прибытия</th>
	<th>Служба</th>
	<th>Расстояние</th>
	<th>Примечание</th>
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
    </tr>
</tfoot>

<tbody>
    <?php
    $i=0;
    foreach ($result as $row) {

    $arr= explode('~', $row['innerservice']);

    foreach ($arr as $value) {

        if(!empty($value)){
              $i++;
            $arr_name= explode('#', $value);
        /* fio - before # */
        $service_name=$arr_name[0];

          /* all  after # explode. time_msg,time_exit.... */
$each_time= explode('&', $arr_name[1]);

//$t_exit[]=$each_time[0];
//$t_arrival[]=$each_time[1];
//$t_follow[]=$each_time[2];
//$t_end[]=$each_time[3];
//$t_return[]=$each_time[4];
//$t_distance[]=$each_time[5];
//$t_is_return[]=$each_time[6];
$t_msg=$each_time[0];
$t_arrival=$each_time[1];

$note=explode('%', $each_time[2]);

$t_distance=$note[0];
$t_note=$note[1];

?>
     <tr  style='background-color:rgb(<?=$_SESSION['colors'][$row['id_rig']]?>); '>
                    <td><?= $i ?></td>
                    <td><b><a href="<?= $baseUrl ?>/card_rig/<?=$table_name_year?>/<?= $row['id_rig'] ?>" style="color:black" target="_blank" data-toggle="tooltip" data-placement="top" title="Просмотреть карточку вызова"><?= $row['id_rig'] ?></a></b></td>
                    <td><?= $row['date_msg'] ?></td>
                    <td><?= $row['time_msg'] ?></td>
                    <td><?= $row['local_name'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $t_msg ?></td>
                    <td><?= $t_arrival ?></td>
                      <td><?= $service_name ?></td>
                    <td><?= $t_distance ?></td>
                    <td><?= $t_note ?></td>

                </tr>
            <?php
        }
    }

    }
    ?>

</tbody>
</table>

<br>
<a href="<?=$link_excel?>" id="link_to_excel"><button class="submit" type="submit" >Экспорт в Excel</button></a>
<input type="hidden" value="<?= $link_excel_hidden ?>" id="prev_link_to_excel">


        <script>

            (function ($, undefined) {
    $(function () {

                $('#archiveTable4').DataTable({
          //  "pageLength": 50,
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



  $('#archiveTable4 tfoot th').each(function (i) {
        var table = $('#archiveTable4').DataTable();

            if (i == 11 || i==15 ) {
                //выпадающий список
                var y = 'rigForm';
                var select = $('<select class="' + i + '  noprint" id="sel' + y + i + '" onChange="changeLinkExcel();"><option value=""></option></select>')
                        .appendTo($(this).empty())
                        .on('change', function () {

                            var val = $(this).val();

                            table.column(i) //Only the first column
                                    .search(val ? '^' + $(this).val() + '$' : val, true, false)
                                    .draw();
                        });

                var x = $('#archiveTable4 tfoot th').index($(this));
                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '" >' + d + '</option>');
                });


            }
            else {
                var title = $('#archiveTable4 tfoot th').eq($(this).index()).text();
                var x = $('#archiveTable4 tfoot th').index($(this));
                var y = 'archiveTable4';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint inpt-archive-show" id="inpt' + y + x + '" placeholder="Поиск" onkeyup="keyupField();"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
            }


    });
    $("#archiveTable4 tfoot input").on('keyup change', function () {
        var table = $('#archiveTable4').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

          });



function changeLinkExcel(){

        var id_rig=$('#inptarchiveTable41').val();
        var date_msg=$('#inptarchiveTable42').val();
        var time_msg=$('#inptarchiveTable43').val();
        var local=$('#inptarchiveTable44').val();
        var addr=$('#inptarchiveTable45').val();

       // var reason=$('#selrigForm6').val();
       // var work_view=$('#selrigForm7').val();

      //  var detail_inf=$('#inptarchiveTable18').val();
      //  var people=$('#inptarchiveTable19').val();
       // var time_loc=$('#inptarchiveTable29').val();
       // var time_likv=$('#inptarchiveTable210').val();

      //  var is_likv_before_arrival=$('#selrigForm11').val();

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

        /* if(reason === '' || reason === undefined)
            reason='no';
         if(work_view === '' || work_view === undefined)
            work_view='no';


         if(detail_inf === '' || detail_inf === undefined)
            detail_inf='no';
         if(people === '' || people === undefined)
            people='no';*/
//         if(time_loc === '' || time_loc === undefined)
//            time_loc='no';
//         if(time_likv === '' || time_likv === undefined)
//            time_likv='no';
//         if(is_likv_before_arrival === '' || is_likv_before_arrival === undefined)
//            is_likv_before_arrival='no';




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


