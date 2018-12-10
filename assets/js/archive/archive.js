 // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});



function yearOrDate() {

// если выбран диапазон дат, то выбрать год нельзя и наоборот.
    /*---- имена полей ----*/
    var archive_date = 'archive_date[]';
     var archive_year = 'archive_year';

var is_archive_year= $('select[name="' + archive_year + '"]').val();
var is_archive_date= $('select[name="' + archive_date + '"]').val();


    if (is_archive_date === null) {//диапазон дат не выбран
        $('select[name="' + archive_year + '"]').prop('disabled', false); // enabled

    }
    else{

    $('select[name="' + archive_year + '"]').val('');
         $('select[name="' + archive_year + '"]').prop('disabled', true); // disable

    }

}



          function see(i) {// скрыть/показать детализ инф в табл выездов

var p=document.getElementById('archive_sp'+i);
	if(p.style.display=="none"){
		p.style.display="block";
            }
	else{
		p.style.display="none";
            }

  }




  (function ($, undefined) {
    $(function () {


   /*-------------- скрыть/отобразить колонки таблицы builder absent----------------*/
          var archive_result_table_vis = $('#archive_result_table').DataTable( {
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
//                     "columnDefs": [
//            {
//                "targets": [ 5 ],
//                "visible": false
//            }
//        ]
    } );


            $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();

        // Get the column API object
        var column = archive_result_table_vis.column( $(this).attr('data-column') );

        // Toggle the visibility
        column.visible( ! column.visible() );


    } );


    });



})(jQuery);







$(document).ready(function () {
    $("tfoot").css("display", "table-header-group");//tfoot of table


    /*---------- таблица архива ------------*/
    $('#archive_result_table tfoot th').each(function (i) {
        var table = $('#archive_result_table').DataTable();


            if (i == 2 || i == 5 || i == 10 || i == 11 ) {
                //выпадающий список
                var y = 'archive_result_table';
                var select = $('<select class="' + i + '  noprint" id="sel' + y + i + '"><option value=""></option></select>')
                        .appendTo($(this).empty())
                        .on('change', function () {

                            var val = $(this).val();

                            table.column(i) //Only the first column
                                    .search(val ? '^' + $(this).val() + '$' : val, true, false)
                                    .draw();
                        });

                var x = $('#archive_result_table tfoot th').index($(this));
                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '" >' + d + '</option>');
                });


            }
            else {
                var title = $('#archive_result_table tfoot th').eq($(this).index()).text();
                var x = $('#archive_result_table tfoot th').index($(this));
                var y = 'archive_result_table';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
            }


    });
    $("#archive_result_table tfoot input").on('keyup change', function () {
        var table = $('#archive_result_table').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

    /*---------- END таблица архива ------------*/




});

