<?php
//print_r($result);

?>
<style>
            #archiveTable2_wrapper{
            width: 98%;
        }
        .dataTables_filter{
            display: none !important;
        }
        .inpt-archive-show{
          display: block !important;
        }
        #inptarchiveTable20,#inptarchiveTable21{
            width: 60px;
        }
                #inptarchiveTable22,#inptarchiveTable23, #inptarchiveTable26,#inptarchiveTable27,#inptarchiveTable28,
                #inptarchiveTable29,#inptarchiveTable210,#inptarchiveTable212,#inptarchiveTable213,
                #inptarchiveTable214{
            width: 86px;
        }
                        #inptarchiveTable24,#inptarchiveTable25{
            width: 100px;
        }
                        #inptarchiveTable29{
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

<table class="table table-condensed   table-bordered table-custom" id="archiveTable2">
    <thead>
  <tr>
  <th>N</th>
    <th>ID</th>
    <th>Дата</th>
    <th>Время</th>
    <th>Район</th>
    <th>Адрес</th>
	<th>Техника</th>
	<th>Время выезда</th>
	<th>Время прибытия</th>
	<th>Локализация</th>
        <th>Ликвидация</th>
        <th>Ликвидация до прибытия</th>
        <th>Время окончания работ</th>
        <th>Возвращение</th>
        <th>Расстояние до места ЧС, км</th>
        <th>Возврат техники</th>
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
    </tr>
</tfoot>

<tbody>
    <?php
    $i=0;
    foreach ($result as $row) {

        ?>



    <?php
    $arr_silymchs= explode('~', $row['silymchs']);

    foreach ($arr_silymchs as $value) {
        if(!empty($value)){
                $i++;
            $arr_mark= explode('#', $value);
        /* mark - before # */
       // $mark[]=$arr_mark[0];
        $mark=$arr_mark[0];

        /* all after # explode, exit,arrival......is_return , result -all  after ? */
        $arr_time= explode('?', $arr_mark[1]);

          /* all  after ? explode.  exit,arrival......is_return*/
$each_time= explode('&', $arr_time[1]);

//$t_exit[]=$each_time[0];
//$t_arrival[]=$each_time[1];
//$t_follow[]=$each_time[2];
//$t_end[]=$each_time[3];
//$t_return[]=$each_time[4];
//$t_distance[]=$each_time[5];
//$t_is_return[]=$each_time[6];
$t_exit=$each_time[0];
$t_arrival=$each_time[1];
$t_follow=$each_time[2];
$t_end=$each_time[3];
$t_return=$each_time[4];
$t_distance=$each_time[5];
$t_is_return=($each_time[6] == 0)?'нет':'да';


?>
    <tr  style='background-color:rgb(<?=$_SESSION['colors'][$row['id_rig']]?>); '>
                    <td><?= $i ?></td>
                    <td><?= $row['id_rig'] ?></td>
                    <td><?= $row['date_msg'] ?></td>
                    <td><?= $row['time_msg'] ?></td>
                    <td><?= $row['local_name'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $mark ?></td>
                    <td><?= $t_exit ?></td>
                    <td><?= $t_arrival ?></td>
                    <td><?= $row['time_loc'] ?></td>
                    <td><?= $row['time_likv'] ?></td>
                    <td></td>
                    <td><?= $t_end ?></td>
                    <td><?= $t_return ?></td>
                    <td><?= $t_distance ?></td>
                    <td><?= $t_is_return ?></td>

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
	<a href="<?=$link_excel?>"><button class="submit" type="submit" >Экспорт в Excel</button></a>


        <script>

            (function ($, undefined) {
    $(function () {

                $('#archiveTable2').DataTable({
            "pageLength": 50,
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



  $('#archiveTable2 tfoot th').each(function (i) {
        var table = $('#archiveTable2').DataTable();

            if (i == 11 || i==15 ) {
                //выпадающий список
                var y = 'rigForm';
                var select = $('<select class="' + i + '  noprint" id="sel' + y + i + '"><option value=""></option></select>')
                        .appendTo($(this).empty())
                        .on('change', function () {

                            var val = $(this).val();

                            table.column(i) //Only the first column
                                    .search(val ? '^' + $(this).val() + '$' : val, true, false)
                                    .draw();
                        });

                var x = $('#archiveTable2 tfoot th').index($(this));
                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '" >' + d + '</option>');
                });


            }
            else {
                var title = $('#archiveTable2 tfoot th').eq($(this).index()).text();
                var x = $('#archiveTable2 tfoot th').index($(this));
                var y = 'archiveTable2';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint inpt-archive-show" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
            }


    });
    $("#archiveTable2 tfoot input").on('keyup change', function () {
        var table = $('#archiveTable2').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

          });
        </script>
