	<?php
//print_r($result);

?>
<style>
            #archiveTable3_wrapper{
            width: 98%;
        }
        .dataTables_filter{
            display: none !important;
        }
        .inpt-archive-show{
          display: block !important;
        }
        #inptarchiveTable30,#inptarchiveTable31{
            width: 60px;
        }
                #inptarchiveTable32,#inptarchiveTable33,#inptarchiveTable37,#inptarchiveTable38,
                #inptarchiveTable39,#inptarchiveTable310,#inptarchiveTable312,#inptarchiveTable313,
                #inptarchiveTable314{
            width: 86px;
        }
        #inptarchiveTable36{
             width: 300px;
        }
                        #inptarchiveTable34,#inptarchiveTable35{
            width: 100px;
        }
                        #inptarchiveTable39{
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

<table class="table table-condensed   table-bordered table-custom" id="archiveTable3">
    <thead>
  <tr>
  <th>N</th>
    <th>ID</th>
    <th>Дата</th>
    <th>Время</th>
    <th>Район</th>
    <th>Адрес</th>
	<th>Адресат</th>
	<th>Время сообщения о ЧС</th>
	<th>Время выезда</th>
	<th>Время прибытия</th>
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

    </tr>
</tfoot>

<tbody>
    <?php
    $i=0;
    foreach ($result as $row) {


    $arr= explode('~', $row['informing']);

    foreach ($arr as $value) {
        if(!empty($value)){
               $i++;
            $arr_fio= explode('#', $value);
        /* fio - before # */
        $fio=$arr_fio[0];

          /* all  after # explode. time_msg,time_exit.... */
$each_time= explode('&', $arr_fio[1]);

//$t_exit[]=$each_time[0];
//$t_arrival[]=$each_time[1];
//$t_follow[]=$each_time[2];
//$t_end[]=$each_time[3];
//$t_return[]=$each_time[4];
//$t_distance[]=$each_time[5];
//$t_is_return[]=$each_time[6];
$t_msg=$each_time[0];
$t_exit=$each_time[1];
$t_arrival=$each_time[2];

?>
    <tr  style='background-color:rgb(<?=$_SESSION['colors'][$row['id_rig']]?>); '>
                    <td><?= $i ?></td>
                    <td><?= $row['id_rig'] ?></td>
                    <td><?= $row['date_msg'] ?></td>
                    <td><?= $row['time_msg'] ?></td>
                    <td><?= $row['local_name'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $fio ?></td>
                    <td><?= $t_msg ?></td>
                    <td><?= $t_exit ?></td>
                    <td><?= $t_arrival ?></td>

                </tr>
            <?php
        }
    }

    }
    ?>

</tbody>
</table>

<br>
	<a href="<?=$link_excel?>"><button class="submit" type="submit" >Экспорт в Excel</button></a>


        <script>

            (function ($, undefined) {
    $(function () {

                $('#archiveTable3').DataTable({
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



  $('#archiveTable3 tfoot th').each(function (i) {
        var table = $('#archiveTable3').DataTable();

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

                var x = $('#archiveTable3 tfoot th').index($(this));
                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '" >' + d + '</option>');
                });


            }
            else {
                var title = $('#archiveTable3 tfoot th').eq($(this).index()).text();
                var x = $('#archiveTable3 tfoot th').index($(this));
                var y = 'archiveTable3';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint inpt-archive-show" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
            }


    });
    $("#archiveTable3 tfoot input").on('keyup change', function () {
        var table = $('#archiveTable3').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

          });
        </script>

