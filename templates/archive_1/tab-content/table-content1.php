<?php
//print_r($result);

?>
<style>
            #archiveTable1_wrapper{
            width: 98%;
        }
        .dataTables_filter{
            display: none !important;
        }
        .inpt-archive-show{
          display: block !important;
        }
        #inptarchiveTable10,#inptarchiveTable11{
            width: 60px;
        }
                #inptarchiveTable12,#inptarchiveTable13,#inptarchiveTable110,#inptarchiveTable111{
            width: 86px;
        }
                        #inptarchiveTable14,#inptarchiveTable15{
            width: 100px;
        }
                        #inptarchiveTable19{
            width: 90px;
        }
        #selrigForm6,#selrigForm7{
              width: 80px;
        }
</style>
<table class="table table-condensed   table-bordered table-custom" id="archiveTable1">
    <thead>
  <tr>
  <th>N</th>
    <th>ID</th>
    <th>Дата</th>
    <th>Время</th>
    <th>Район</th>
    <th>Адрес</th>
	<th>Причина вызова</th>
	<th>Вид работ</th>
	<th>Детализированная информация</th>
	<th>Данные заявителя</th>
        <th>Время локализации</th>
        <th>Время ликвидации</th>
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
        </tr>
</tfoot>

<tbody>
    <?php
    $i=0;
    foreach ($result as $row) {
        $i++;
        ?>
    <tr  style='background-color:rgb(<?=$_SESSION['colors'][$row['id_rig']]?>); '>
  <td><?= $i?></td>
    <td><?= $row['id_rig'] ?></td>
    <td><?= $row['date_msg'] ?></td>
    <td><?= $row['time_msg'] ?></td>
    <td><?= $row['local_name'] ?></td>
    <td><?= $row['address'] ?></td>
	<td><?= $row['reasonrig_name'] ?></td>
	<td><?= $row['view_work'] ?></td>
	<td><?= $row['inf_detail'] ?></td>
	<td><?= $row['people'] ?></td>
        <td><?= $row['time_loc'] ?></td>
	<td><?= $row['time_likv'] ?></td>
    </tr>
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

                $('#archiveTable1').DataTable({
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



  $('#archiveTable1 tfoot th').each(function (i) {
        var table = $('#archiveTable1').DataTable();

            if (i == 6 || i==7 ) {
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

                var x = $('#archiveTable1 tfoot th').index($(this));
                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '" >' + d + '</option>');
                });


            }
            else {
                var title = $('#archiveTable1 tfoot th').eq($(this).index()).text();
                var x = $('#archiveTable1 tfoot th').index($(this));
                var y = 'archiveTable1';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint inpt-archive-show" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
            }


    });
    $("#archiveTable1 tfoot input").on('keyup change', function () {
        var table = $('#archiveTable1').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

          });
        </script>
