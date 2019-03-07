/* КОЛ-ВО МАШИН МЧС = 30
 *
 */

$(function () {  //всплывающая подсказка
    $("[data-toggle='tooltip']").tooltip();
});
//  валидация формы авторизации
$('#loginForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            //live: 'submitted',
//                feedbackIcons: {
//                    valid: 'fab fa-adn',
//                    invalid: 'fab fa-adn',
//                    validating: 'fab fa-address-car'
//                },
            fields: {
                login: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Введите логин'
                        },
                        stringLength: {
                            min: 3,
                            max: 10,
                            message: 'от 3 до 10 символов'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_]+$/,
                            message: 'буквы англ.алфавита, цифры, нижнее подчеркивание '
                        }
                    }
                },
                password: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Введите пароль'
                        },
                        stringLength: {
                            min: 3,
                            max: 7,
                            message: 'от 3 до 7 символов'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: 'буквы англ.алфавита, цифры '
                        }
                    }
                }
            }

        });

//  валидация формы доб/ред пользователя
$('#userForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            //live: 'submitted',
//                feedbackIcons: {
//                    valid: 'fab fa-adn',
//                    invalid: 'fab fa-adn',
//                    validating: 'fab fa-address-car'
//                },
            fields: {
                login: {
                    message: 'The username is not valid',
                    validators: {
//                        notEmpty: {
//                            message: 'Введите логин'
//                        },
                        stringLength: {
                            min: 3,
                            max: 10,
                            message: 'от 3 до 10 символов'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_]+$/,
                            message: 'буквы англ.алфавита, цифры, нижнее подчеркивание '
                        }
                    }
                },
                password: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Введите пароль'
                        },
                        stringLength: {
                            min: 3,
                            max: 7,
                            message: 'от 3 до 7 символов'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_]+$/,
                            message: 'буквы англ.алфавита, цифры, нижнее подчеркивание '
                        }
                    }
                },
                name: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Введите имя пользователя'
                        },
                        stringLength: {
                            min: 3,
                            max: 30,
                            message: 'от 3 до 30 символов'
                        },
                        regexp: {
                            regexp: /^[а-яА-Я0-9\s-.]+$/,
                            message: 'буквы русск.алфавита, пробел,- '
                        }
                    }
                }
            }

        });

        /*----------- форма для rep1 -------------*/
              $('#rep1Form')
        .bootstrapValidator({
            message: 'This value is not valid',
            //live: 'submitted',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                date_start: {
                validators: {
                     notEmpty: {
                            message: 'Выберите дату '
                        },
                    date: {
                       format: 'YYYY-MM-DD',
                        message: 'Неправильный формат'
                    }
                }
            },
                            date_end: {
                validators: {
                     notEmpty: {
                            message: 'Выберите дату '
                        },
                    date: {
                       format: 'YYYY-MM-DD',
                        message: 'Неправильный формат'
                    }
                }
            }


            }


        });




    $('#date_start').on('dp.change dp.show', function(e) {
        $('#rep1Form').bootstrapValidator('revalidateField', 'date_start');
    });

        $('#date_end').on('dp.change dp.show', function(e) {
        $('#rep1Form').bootstrapValidator('revalidateField', 'date_end');
    });
            /*----------- END форма для rep1 -------------*/



        //  валидация формы доб/ред должностного лица
$('#destinationForm')
        .bootstrapValidator({
            message: 'This value is not valid',

            fields: {
                fio: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Введите Ф.И.О.'
                        },
                        stringLength: {
                            min: 3,
                            max: 30,
                            message: 'от 3 до 30 символов'
                        }
                    }
                }
            }

        });



                /*----------- форма поиска выездов по диапазону дат -------------*/
              $('#filterRigForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            //live: 'submitted',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                date_start: {
                validators: {
                     notEmpty: {
                            message: 'Выберите дату '
                        },
                    date: {
                       format: 'YYYY-MM-DD',
                        message: 'Неправильный формат'
                    }
                }
            },
                            date_end: {
                validators: {
                     notEmpty: {
                            message: 'Выберите дату '
                        },
                    date: {
                       format: 'YYYY-MM-DD',
                        message: 'Неправильный формат'
                    }
                }
            }


            }


        });




    $('#date_start').on('dp.change dp.show', function(e) {
        $('#filterRigForm').bootstrapValidator('revalidateField', 'date_start');
    });

        $('#date_end').on('dp.change dp.show', function(e) {
        $('#filterRigForm').bootstrapValidator('revalidateField', 'date_end');
    });
            /*----------- END форма поиска выездов по диапазону дат-------------*/



(function ($, undefined) {
    $(function () {
        $('#userTable, #classifTable, #listmailTable').DataTable({
            "pageLength": 50,
             "order": [[ 2, "desc" ]],
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

                $('#classifTableActionWaybill').DataTable({
            "pageLength": 50,
             "order": [[ 4, "asc" ]],
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



/*  rigTable  */
              var rig_table_vis =  $('#rigTable').DataTable({
            "pageLength": 50,
             "order": [[ 2, "desc" ]],
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
//                                 "columnDefs": [
//            {
//                "targets": [ 13 ],
//                "visible": false
//            }
//        ]
        });

                    $('a.toggle-vis-rig-table').on( 'click', function (e) {
        e.preventDefault();

        // Get the column API object
        var column = rig_table_vis.column( $(this).attr('data-column') );

        // Toggle the visibility
        column.visible( ! column.visible() );


    } );



		        $('#destinationTable').DataTable({
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

                $('#logsTable').DataTable({
            "pageLength": 50,
             "order": [[ 0, "desc" ]],
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


    /*---------- таблица с пользователями ------------*/
    $('#userTable tfoot th').each(function (i) {
        var table = $('#userTable').DataTable();
        if (i !== 8 && i != 9) {

            if (i == 2 || i == 3 || i == 4 || i == 5 || i == 6) {
                //выпадающий список
                var y = 'userForm';
                var select = $('<select class="' + i + '  noprint" id="sel' + y + i + '"><option value=""></option></select>')
                        .appendTo($(this).empty())
                        .on('change', function () {

                            var val = $(this).val();

                            table.column(i) //Only the first column
                                    .search(val ? '^' + $(this).val() + '$' : val, true, false)
                                    .draw();
                        });

                var x = $('#userTable tfoot th').index($(this));
                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '" >' + d + '</option>');
                });


            }
            else {
                var title = $('#userTable tfoot th').eq($(this).index()).text();
                var x = $('#userTable tfoot th').index($(this));
                var y = 'userForm';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
            }

        }
    });
    $("#userTable tfoot input").on('keyup change', function () {
        var table = $('#userTable').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

    /*---------- END таблица с пользователями ------------*/

    /*---------- таблица с выездами ------------*/
    $('#rigTable tfoot th').each(function (i) {
        var table = $('#rigTable').DataTable();
        if (i !== 1 && i != 8 && i != 14) {

            if (i == 9 || i==13 ) {
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

                var x = $('#rigTable tfoot th').index($(this));
                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '" >' + d + '</option>');
                });


            }
            else {
                var title = $('#rigTable tfoot th').eq($(this).index()).text();
                var x = $('#rigTable tfoot th').index($(this));
                var y = 'rigForm';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
            }

        }
    });
    $("#rigTable tfoot input").on('keyup change', function () {
        var table = $('#rigTable').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

    /*---------- END таблица с выездами ------------*/

 /*---------- таблица таблица классификаторов ------------*/
    $('#classifTable tfoot th').each(function (i) {
        var table = $('#classifTable').DataTable();
        if (i !== 3 && i != 4) {

                var title = $('#classifTable tfoot th').eq($(this).index()).text();
                var x = $('#classifTable tfoot th').index($(this));
                var y = 'classifForm';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');


        }
    });
    $("#classifTable tfoot input").on('keyup change', function () {
        var table = $('#classifTable').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

    /*---------- END таблица классификаторов ------------*/



 /*---------- table classif of action waybill ------------*/
    $('#classifTableActionWaybill tfoot th').each(function (i) {
        var table = $('#classifTableActionWaybill').DataTable();
        if (i !== 6 && i != 7) {


                        if (i == 1 ) {
                //выпадающий список
                var y = 'classif_action';
                var select = $('<select class="' + i + '  noprint" id="sel' + y + i + '"><option value=""></option></select>')
                        .appendTo($(this).empty())
                        .on('change', function () {

                            var val = $(this).val();

                            table.column(i) //Only the first column
                                    .search(val ? '^' + $(this).val() + '$' : val, true, false)
                                    .draw();
                        });

                var x = $('#classifTableActionWaybill tfoot th').index($(this));
                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '" >' + d + '</option>');
                });


            }
            else{

                var title = $('#classifTableActionWaybill tfoot th').eq($(this).index()).text();
                var x = $('#classifTableActionWaybill tfoot th').index($(this));
                var y = 'classifForm_actionwaybill';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
            }



        }
    });
    $("#classifTableActionWaybill tfoot input").on('keyup change', function () {
        var table = $('#classifTableActionWaybill').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

    /*---------- END table classif of action waybill ------------*/



     /*---------- таблица таблица классификатора listmailTable ------------*/
    $('#listmailTable tfoot th').each(function (i) {
        var table = $('#listmailTable').DataTable();
        if (i !== 4 && i != 5) {

                var title = $('#listmailTable tfoot th').eq($(this).index()).text();
                var x = $('#listmailTable tfoot th').index($(this));
                var y = 'classifForm';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');


        }
    });
    $("#listmailTable tfoot input").on('keyup change', function () {
        var table = $('#listmailTable').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

    /*---------- END таблица классификатора listmailTable ------------*/


   /*---------- таблица с logs ------------*/
    $('#logsTable tfoot th').each(function (i) {
        var table = $('#logsTable').DataTable();

                var title = $('#logsTable tfoot th').eq($(this).index()).text();
                var x = $('#logsTable tfoot th').index($(this));
                var y = 'logsForm';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');


    });
    $("#logsTable tfoot input").on('keyup change', function () {
        var table = $('#logsTable').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

    /*---------- END таблица с logs------------*/


});




/*--------------------------- Зависимые выпадающие списки -------------------------------*/

jQuery("#id_locorg").chained("#id_region"); // зависимость ГРОЧС от области
jQuery("#id_organ").chained("#id_locorg"); // автоматич определние id органа по ГРОЧС

/************ форма user **************/
jQuery("#auto_local").chained("#id_region"); // зависимость района от области
jQuery("#auto_locality").chained("#auto_local"); // зависимость нас п. от района
/********** END форма user *************/

/******* форма высылка техники ********/
for(i=1;i<=30;i++){// на 30 машин
   jQuery("#id_locorg"+i).chained("#id_region"+i); // зависимость ГРОЧС от области
jQuery("#id_pasp"+i).chained("#id_locorg"+i); // зависимость ПАСЧ от ГРОЧС
}

/******* КОНЕЦ форма высылка техники ********/

/*--------------------------- END Зависимые выпадающие списки -------------------------------*/



/*-------------------------------------- валидация полей на  ввод символов --------------------------------------------*/
    $('.fio' ).keypress(function (key) {//русск ьуквы
        if (((key.charCode < 46) && (key.charCode != 32)&& (key.charCode != 40)&& (key.charCode != 41)&& (key.charCode != 44) && (key.charCode != 45)) || ((key.charCode > 46) && (key.charCode < 1040)) || (key.charCode > 1103))
            return false;
    });
        $('.pasp' ).keypress(function (key) {// русск буквы - . , цифры
        if ((key.charCode < 48 && key.charCode !== 45 && key.charCode !== 44 && key.charCode !== 46 && key.charCode !== 32) || (key.charCode > 57 &&  key.charCode < 1040 ))
            return false;
    });



    /**** поле дата/время  разрешено только . и : *****/
$('.datetime').keypress(function (key) {
    if ((key.charCode < 48 && key.charCode !== 46) || (key.charCode > 57 && key.charCode !== 58))
        return false;
});

/**** поле цвет статуса выезда  разрешены только англ буквы *****/
$('.status_rig_color').keypress(function (key) {
    if (key.charCode < 1105 && key.charCode > 1040)
        return false;
});

/*-------------------------------------- END валидация полей на  ввод символов --------------------------------------------*/



/*--------------------- функция формирует список районов, нас.п. при изменении области ---------------------*/
function changeRegion() {

            var id_region = $('select[name="id_region"]').val();

    if (!id_region) {
        $('select[name="id_local"]').html('<option value="">Выбрать</option>');
        $('select[name="id_locality"]').html('<option value="">Выбрать</option>');

    } else {

        /*-------- сформировать список районов -----------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showLocalByRegion', id_region: id_region},
            cache: false,
            success: function (responce) {
                $('select[name="id_local"]').html(responce);
                       $("#id_local").trigger("chosen:updated");
            }

        });

        /*-------- КОНЕЦ сформировать список районов -----------*/

        /*-------- сформировать список нас.п. -----------*/
        var id_local = $('select[name="id_local"]').val();
        var id_locality = $('select[name="id_locality"]').val();
        // if (id_local) {

        // if(id_locality){////список нас.п. по области
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showLocalityByRegion', id_region: id_region},
            cache: false,
            success: function (responce) {
                $('select[name="id_locality"]').html(responce);
                  $("#id_locality").trigger("chosen:updated");
            }
        });
        /*-------- КОНЕЦ сформировать список нас.п. -----------*/

        $('select[name="id_selsovet"]').html('<option value="">Выбрать</option>');
        $("#id_selsovet").trigger("chosen:updated");


        if(id_region == 3){//если выбран г.Минск как область - нас.пункт автоматически заполнится г.Минск, и надо сформмировать улицы
                           /*---------- улица по нас.п. -----------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showStreetByLocality', id_locality: 17030},
            cache: false,
            success: function (responce) {
                $('select[name="id_street"]').html(responce);
                    $("#id_street").trigger("chosen:updated");
            }
        });
        }
        else{
                  $('select[name="id_street"]').html('<option value="">Выбрать</option>');
        }




        $("#id_street").trigger("chosen:updated");

        //список сельсоветов обнулить
//        $('select[name="id_selsovet"]').html('<option value="">Выбрать</option>');
//         $("#id_selsovet").trigger("chosen:updated");
    }
            $('input[name="vid_locality"]').val('');//вид нас.п. пуст
//     if(selected_street == 0){//по умолчанию улица не выбрана
//          //список улиц empty
//    $('select[name="id_street"]').html('<option value="">Выбрать</option>');
//     $("#id_street").trigger("chosen:updated");
//  }

//  if(selected_selsovet == 0){//по умолчанию selsovet не выбран
//            //список сельсоветов обнулить
//        $('select[name="id_selsovet"]').html('<option value="">Выбрать</option>');
//         $("#id_selsovet").trigger("chosen:updated");
//  }

};
/*--------------------- КОНЕЦ функция формирует список районов, нас.п. при изменении области ---------------------*/

/*--------------------- функция формирует  нас.п., ельсоветы по району ---------------------*/
function changeLocal() {
    var id_local = $('select[name="id_local"]').val();
    var id_region = $('select[name="id_region"]').val();


    if (id_local) {

        /*---------- список нас.п. по району -----------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showLocalityByLocal', id_local: id_local},
            cache: false,
            success: function (responce) {
                $('select[name="id_locality"]').html(responce);
                    $("#id_locality").trigger("chosen:updated");
                    $('#id_locality').trigger('change');


            }
        });


        /*---------- список сельсоветов по району ------------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showSelsovetByLocal', id_local: id_local},
            cache: false,
            success: function (responce) {
                $('select[name="id_selsovet"]').html(responce);
                    $("#id_selsovet").trigger("chosen:updated");
            }
        });



    }
    else {

        if(id_region == 3){//если область г.Минск и район "все" - то улицы отображать города Минска
                          $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showStreetByLocality', id_locality: 17030},
            cache: false,
            success: function (responce) {
                $('select[name="id_street"]').html(responce);
                    $("#id_street").trigger("chosen:updated");
            }
        });
        }




        /*----------- список нас.п. по области ------------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showLocalityByRegion', id_region: id_region},
            cache: false,
            success: function (responce) {
                $('select[name="id_locality"]').html(responce);
                    $("#id_locality").trigger("chosen:updated");
            }
        });

        //список сельсоветов empty
        $('select[name="id_selsovet"]').html('<option value="">Выбрать</option>');
         $("#id_selsovet").trigger("chosen:updated");

    }
     $('input[name="vid_locality"]').val('');//вид нас.п. пуст
    $('select[name="id_street"]').html('<option value="">Выбрать</option>');  //список улиц empty
     $("#id_street").trigger("chosen:updated");
};
/*--------------------- КОНЕЦ функция формирует  нас.п., сельсоветы по району ---------------------*/

/*-------------------------- авт выбор района, сельсовета по нас.п. -------------------------------*/
function changeLocality() {
    var id_locality = $('select[name="id_locality"]').val();
    var id_region = $('select[name="id_region"]').val();
    var id_local = $('select[name="id_local"]').val();
    if (id_locality) {
        //alert(id_locality);
        if(id_locality != 17030){ //если нас.пунктом выбран г.Минск - район не выбирать автоматически
                    /*----------- район по нас.п. -----------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showLocalByLocality', id_locality: id_locality, id_region: id_region},
            cache: false,
            success: function (responce) {
                $('select[name="id_local"]').html(responce);
                    $("#id_local").trigger("chosen:updated");
            }
        });
        }


           /*----------- вид нас.п. -----------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showVidLocality', id_locality: id_locality},
            cache: false,
            success: function (responce) {
                $('input[name="vid_locality"]').val(responce);
            }
        });

            /*----- оставить нас.п. только того района, который установился ----------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showLocalityByActiveLocal', id_locality: id_locality},
            cache: false,
            success: function (responce) {
                $('select[name="id_locality"]').html(responce);
                    $("#id_locality").trigger("chosen:updated");
            }
        });


        /*------------- с/с по нас.п. -----------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showSelsovetByLocality', id_locality: id_locality},
            cache: false,
            success: function (responce) {
                $('select[name="id_selsovet"]').html(responce);
                    $("#id_selsovet").trigger("chosen:updated");
            }
        });

        /*---------- улица по нас.п. -----------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showStreetByLocality', id_locality: id_locality},
            cache: false,
            success: function (responce) {
                $('select[name="id_street"]').html(responce);
                    $("#id_street").trigger("chosen:updated");
            }
        });
    }
    else {
        if(!id_local){
               /*-------- сформировать список районов области -----------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showLocalByRegion', id_region: id_region},
            cache: false,
            success: function (responce) {
                $('select[name="id_local"]').html(responce);
                    $("#id_local").trigger("chosen:updated");
            }
        });

         $('input[name="vid_locality"]').html('');//очистить вид нас. пункта

        }


        //список сельсоветов empty
        $('select[name="id_selsovet"]').html('<option value="">Выбрать</option>');
         $("#id_selsovet").trigger("chosen:updated");
        //список улиц empty
        $('select[name="id_street"]').html('<option value="">Выбрать</option>');
         $("#id_street").trigger("chosen:updated");
    }
};
/*------------------------- КОНЕЦ авт выбор района, сельсовета по нас.п.  --------------------------------*/

/*-------------------------- формирование списка нас.п., улиц по сельсовету  -------------------------------*/
function changeSelsovet() {
    var id_local = $('select[name="id_local"]').val();
    var id_region = $('select[name="id_region"]').val();
    var id_selsovet = $('select[name="id_selsovet"]').val();
    if (id_selsovet) {
        /*---------  нас.п. по с/с --------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showLocalityBySelsovet', id_selsovet: id_selsovet},
            cache: false,
            success: function (responce) {
                $('select[name="id_locality"]').html(responce);
                    $("#id_locality").trigger("chosen:updated");
            }
        });

    }
    else {
        /*-------- нас.п. по району -----------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showLocalityByLocal', id_local: id_local},
            cache: false,
            success: function (responce) {
                $('select[name="id_locality"]').html(responce);
                    $("#id_locality").trigger("chosen:updated");
            }
        });
    }

    $('input[name="vid_locality"]').val('');//очистить вид нас. пункта
      $('select[name="id_street"]').html('<option value="">Выбрать</option>');//список улиц empty
       $("#id_street").trigger("chosen:updated");
};
/*------------------------- КОНЕЦ формирование списка нас.п., улиц по сельсовету --------------------------------*/

/*------------- список техники выбранного ПАСЧ -------------------*/
function changePasp(i,j) {


  //var id_pasp = $('select[name='+'"'+i+'"'+']').val();
  var a=i.options[i.selectedIndex];

  if (typeof (a) === 'undefined') {
            $('select[name='+'"'+j+'"'+']').html('выбор');
  }
  else{

      var id_pasp =i.options[i.selectedIndex].value;

    if (id_pasp) {

        /*---------  техника данного ПАСЧ --------*/
        $.ajax({
            type: "POST",
            url: "/journal/select",
            data: {action: 'showTehByPasp', id_pasp: id_pasp},
            cache: false,
            success: function (responce) {

        /*--------- чтобы обновить технику --------*/
         $('select[name='+'"'+j+'"'+']').select2("destroy");//уничтожаем
           $('select[name='+'"'+j+'"'+']').select2();//создаем заново
            /*--------- чтобы обновить технику --------*/

        $('select[name='+'"'+j+'"'+']').html(responce);
           return;

            }
        });

    }
  }



};

/*------------- очистить технику при изменении области/ГРОЧС -------------------*/
function clearPasp(j) {
$('select[name='+'"'+j+'"'+']').html('<option value="">Выбрать</option>');

};


/*----------------------------------------------------------------------------------------------------------------- ВСЕ классификаторы  ------------------------------------------------------------------------------------------------*/
/*------------- редактирование классификатора-------------------*/
function editClassif(i, j, c) {

    var name_classif = $('input[name=' + '"' + i + '"' + ']').val();
    var id_classif = j;//id записи в таблицы, которую редактируем
    var classif_active = c;//имя таблицы классификатора


    if(classif_active === "workview"){//вид работ

        var id_reasonrig=$('select[name= id_reasonrig' +j+ ']').val();

          if (id_classif) {
        $.ajax({
            type: "POST",
            url: "/journal/classif/" + classif_active + "/new/" + id_classif,
            data: {action: 'put', name: name_classif, id_reasonrig:id_reasonrig},
            cache: false,
            success: function (responce) {
                //alert('Изменения успешно сохранены в БД!');
                location.reload();
            }
        });

    }
    }
    else{
            if (id_classif) {
        $.ajax({
            type: "POST",
            url: "/journal/classif/" + classif_active + "/new/" + id_classif,
            data: {action: 'put', name: name_classif},
            cache: false,
            success: function (responce) {
                //alert('Изменения успешно сохранены в БД!');
                location.reload();
            }
        });

    }
    }


};

//редактирование статуса выезда
function editClassifStatusrig(i,color, j, c) {

    var name_classif = $('input[name=' + '"' + i + '"' + ']').val();
    var color_classif = $('input[name=' + '"' + color + '"' + ']').val();
    var id_classif = j;//id записи в таблицы, которую редактируем
    var classif_active = c;//имя таблицы классификатора

    if (id_classif) {
        $.ajax({
            type: "POST",
            url: "/journal/classif/" + classif_active + "/new/" + id_classif,
            data: {action: 'put', name: name_classif, color:color_classif},
            cache: false,
            success: function (responce) {
                //alert('Изменения успешно сохранены в БД!');
                location.reload();
            }
        });

    }
};

/*------------- delete классификатора-------------------*/
function deleteClassif(i, j, c) {

    var name_classif = $('input[name=' + '"' + i + '"' + ']').val();
    var id_classif = j;//id записи в таблицы, которую редактируем
    var classif_active = c;//имя таблицы классификатора

    var answer = confirm('Удалить запись "' + name_classif + '" из БД?');

    if (answer) {//delete
        $.ajax({
            type: "DELETE",
            url: "/journal/classif/" + classif_active + "/" + id_classif,
            data: {action: 'delete', id: id_classif},
            cache: false,
            success: function (responce) {
               // alert('Запись успешно удалена из БД!');
                location.reload();
            }
        });
    }
};


//показать поле для редактирования лица
function showDestinat(div){
    //отображаем блок с id=div, где содержится поле для ввода данных
    $('#'+div).toggle();
}


/*---------- таблица с классификатором "информированные лица"  -----------*/
function editDestinat(i, f, x) {
// f - name of field in table
    var name_field = f + i;//fio1
    var id = i;// id table

    if(x==2){
        var value_field = $('select[name=' + '"' + name_field + '"' + ']').val();//value field
    }
    else{
            var value_field = $('input[name=' + '"' + name_field + '"' + ']').val();//value field
    }
//    alert(x);
//alert(value_field);

    var classif_active = 'destination';

    $.ajax({
        type: "POST",
        url: "/journal/classif/" + classif_active + "/new/" + id,
        data: {action: 'put', name: f, value: value_field},
        cache: false,
        success: function (responce) {
            //alert('Изменения успешно сохранены в БД!');
           // location.reload();
           $('#td_'+name_field).css({
      "color": "red"
  });
        }
    });
}
;
/*--------- END таблица с классификатором "информированные лица"  --------*/


/*----------------------------------------------------------------------------------------------------------------- END ВСЕ классификаторы  ------------------------------------------------------------------------------------------------*/




/*----------------------------------------- Настройки пользователя ------------------------------------------------------*/

//редактирование статуса выезда
function editReasonrigUser(id_st,col, j) {

    var id_reasonrig = $('select[name=' + '"' + id_st + '"' + ']').val();
    var color = $('input[name=' + '"' + col + '"' + ']').val();
    var id= j;//id записи в таблицы, которую редактируем


    if (id_reasonrig) {
        $.ajax({
            type: "POST",
            url: "/journal/settings/reason_rig_color/" + id,
            data: {action: 'put', id_reasonrig : id_reasonrig , color:color},
            cache: false,
            success: function (responce) {
              //  alert('Изменения успешно сохранены в БД!');
                location.reload();
            }
        });

    }
};

function deleteReasonrigUser(j) {

    var id = j;//id записи в таблицы, которую редактируем

    var answer = confirm('Удалить запись из БД?');

    if (answer) {//delete
        $.ajax({
            type: "DELETE",
            url: "/journal/settings/reason_rig_color/" + id,
            data: {action: 'delete', id: id},
            cache: false,
            success: function (responce) {
               // alert('Запись успешно удалена из БД!');
                location.reload();
            }
        });
    }
};

/*------------------------------------------ END  Настройки пользователя ---------------------------------------------------------*/





//$('#id_region').trigger('change'); //автоматически заполнить область в выезде для пользователя, у которого есть право auto_ate
 //$('#id_local').trigger('change');


 /*------------------------------- маска ввода --------------------------------------*/
       jQuery("#coord_lat").mask("99.9999?99");//долгота
      jQuery("#coord_lon").mask("99.9999?99");//широта

      /**** время следования - форма журнала выезда ****/
      for(var i=1;i<30;i++){
                      jQuery("#time_follow"+i).mask("99:99:99");
      }


 /*------------------------------- КОНЕЦ маска ввода --------------------------------------*/



 // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});


/*--------------- Высчитать время след = вр.приб-вр.выезда    ------------*/
function setTimeFollow(i){
    // i - номер элемента на форме
    /*---- имена полей ----*/
    var j='sily['+i+'][time_follow]';
    var t_exit='sily['+i+'][time_exit]';
     var t_arr='sily['+i+'][time_arrival]';

     /*----- значения полей ------*/
     var time_exit=    $('input[name='+'"'+t_exit+'"'+']').val();
          var time_arrival=    $('input[name='+'"'+t_arr+'"'+']').val();

var a=new Date(time_exit);//вр.выезда
var b=new Date(time_arrival);//вр.приб

//  set thye unit values in milliseconds
var msecPerMinute=1000*60;
var msecPerHour=msecPerMinute*60;

     /*-- время след = вр.приб-вр.выезда в миллисекундах --*/
var interval=b.getTime()-a.getTime();//milliseconds

// calculate hours
var hours=Math.floor(interval/msecPerHour);
interval=interval-(hours*msecPerHour);
// calculate minutes
var minutes=Math.floor(interval/msecPerMinute);
interval=interval-(minutes*msecPerMinute);
// calculate seconds
var seconds=Math.floor(interval/1000);

var h_len=Math.log(hours)*Math.LOG10E+1 | 0;//кол-во символов в часах
var m_len=Math.log(minutes)*Math.LOG10E+1 | 0;//  в мин
var s_len=Math.log(seconds)*Math.LOG10E+1 | 0;//  в сек

if(h_len < 2 ){//формат 00
    var h="0"+hours;
}
else{
        var h=hours;
}
if(m_len < 2){//формат 00
    var m="0"+minutes;
}
else{
        var m=minutes;
}
if(s_len <2){//формат 00
    var s="0"+seconds;
}
else{
     var s=seconds;
}
//result
var t=h+":"+m+":"+s;//00:00:00 - format
    $('input[name='+'"'+j+'"'+']').val(t);

}
/*--------------- END Высчитать время след = вр.приб-вр.выезда    ------------*/

/*----------------- Пересчет кол-ва выездов, пользователей в левом меню ---------------------*/
setInterval(function () {
    function update() {
        $.ajax({
            type: "POST",
            url: "/journal/show/count",
            data: {action: 'showCountRigs'},
            cache: false,
            success: function (responce) {
                $("#count-rigs").html(responce);
            }
        });


    }
    update();
}, 300000);//каждые 5 минут 1msec=1000sec

/*----------------- КОНЕЦ Пересчет кол-ва выездов, пользователей в левом меню ---------------------*/



/*------------------- отбой техники ------------------------*/

function setReturnCar(i, n) {
    // i - номер элемента на форме
    //n=0 - установить поля в disabled
    //n=1 - установить поля в enabled

    /*---- имена полей ----*/
    var is_return_name = 'sily[' + i + '][is_return]';
    var t_arr = 'sily[' + i + '][time_arrival]';
    var t_follow = 'sily[' + i + '][time_follow]';
    var t_end = 'sily[' + i + '][time_end]';
    var distance = 'sily[' + i + '][distance]';


    var is_return = $('input[name="' + is_return_name + '"]').prop('checked');

    //alert(is_return);

    if (is_return == true) {
        $('input[name="' + t_arr + '"]').prop('disabled', true); // disable
        $('input[name="' + t_follow + '"]').prop('disabled', true); // disable
        $('input[name="' + t_end + '"]').prop('disabled', true); // disable
        $('input[name="' + distance + '"]').prop('disabled', true); // disable

        $('input[name="' + t_arr + '"]').val('');
        $('input[name="' + t_follow + '"]').val('');
        $('input[name="' + t_end + '"]').val('');
        $('input[name="' + distance + '"]').val('');
    }
    else {
        $('input[name="' + t_arr + '"]').prop('disabled', false); // enabled
        $('input[name="' + t_follow + '"]').prop('disabled', false); // enabled
        $('input[name="' + t_end + '"]').prop('disabled', false); // enabled
        $('input[name="' + distance + '"]').prop('disabled', false); // enabled
    }

}

  /*------------------- END отбой техники ------------------------*/

          function see(i) {// скрыть/показать детализ инф в табл выездов

var p=document.getElementById('sp'+i);
	if(p.style.display=="none"){
		p.style.display="block";
            }
	else{
		p.style.display="none";
            }

  }


  /*------------------- выезд ОПГ - если отмечен , то поле с описанием доступно ------------------------*/

function setOpgText(n) {
    // i - номер элемента на форме
    //n=0 - установить поля в disabled
    //n=1 - установить поля в enabled

    /*---- имена полей ----*/
    var is_opg = 'is_opg';
     var opg_text = 'opg_text';



    var is_return = $('input[name="' + is_opg + '"]').prop('checked');


    if (is_return == true) {
        $('textarea[name="' + opg_text + '"]').prop('disabled', false); // enabled




    }
    else {
        $('textarea[name="' + opg_text + '"]').prop('disabled', true); // disable
        $('textarea[name="' + opg_text + '"]').val('');
    }

}

  /*------------------- END выезд ОПГ - если отмечен , то поле с описанием доступно ------------------------*/


// скрыть  наименование ПС при развертывании Меню и наоборот
function none_title_for_ivanov(){

    var p=document.getElementById('title_for_ivanov');
    if (p.style.display == "none") {
        p.style.display = "block";


    } else {
        p.style.display = "none";

    }

}


/* workview depends on reasonrig  */
jQuery("#id_workview").chained("#id_reasonrig");


$( window ).load(function() {
  // Run code
  //alert('hello');
  $( "#toggle-vis-rig-table-13" ).trigger( "click" );
  $( "#toggle-vis-rig-table-7" ).trigger( "click" );
});


/* delete actionwaybill from bd  */
$(document).on('click', '#btn_del_action', function (e) {

    var mas = [];
    $(':checkbox:checked').each(function () {
        mas.push(this.value);

    });
    var mas_to_str = mas.toString();

    if (mas_to_str) {
        $.ajax({
            type: 'POST',
            url: "/journal/classif/actionwaybill/delete",
            cache: false,
            data: {ids_del: mas_to_str},
            success: function (responce) {
                alert('Выбранные записи были удалены из бД!');
                location.reload();

            }
        });
    }

});



/*------------------------  archive -------------------------------- */
 $('#getArchiveData').on({
        'click': function (event) {
   // alert('123');

              // alert('1');
   var date_start=$('input[name="date_start"]').val();
   var date_end=$('input[name="date_end"]').val();

   var archive_year=$('select[name="archive_year"]').val();
   var region=$('select[name="id_region"]').val();
   var local=$('select[name="id_local"]').val();



   if(date_start && date_end){
     //  alert('123');
           $.ajax({
        type: 'POST',
        url: '/journal/archive_1/getInfRig',
       // dataType: 'json',
        data: {
            date_start: date_start,
           date_end: date_end,
           archive_year:archive_year,
           region:region,
           local:local

        },

        success: function (response) {

            $('#ajax-content').fadeOut("slow", function () {
              //  $('h1.m-n > *:not(:first)').remove();
                $('#ajax-content').html(response);
               $('#ajax-content').fadeIn("slow");
                console.log("it Work");
            });

        }
    });
   }

        }

    });


