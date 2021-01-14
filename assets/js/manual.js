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
                            max: 12,
                            message: 'от 3 до 12 символов'
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
                            max: 12,
                            message: 'от 3 до 12 символов'
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




$('#date_start').on('dp.change dp.show', function (e) {
    $('#rep1Form').bootstrapValidator('revalidateField', 'date_start');
});

$('#date_end').on('dp.change dp.show', function (e) {
    $('#rep1Form').bootstrapValidator('revalidateField', 'date_end');
});

$('#rep1Form').on('submit', function (e) {
    $('#rep1Form').bootstrapValidator('revalidateField', 'date_start');
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
//                valid: 'glyphicon glyphicon-ok',
//                invalid: 'glyphicon glyphicon-remove',
//                validating: 'glyphicon glyphicon-refresh'
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



$('#date_start').on('dp.change dp.show', function (e) {
    $('#filterRigForm').bootstrapValidator('revalidateField', 'date_start');
});

$('#date_end').on('dp.change dp.show', function (e) {
    $('#filterRigForm').bootstrapValidator('revalidateField', 'date_end');
});
$('#filterRigForm').on('submit', function (e) {
    $('#filterRigForm').bootstrapValidator('revalidateField', 'date_start');
});


//$('#date_start').on('dp.change dp.show', function (e) {
//    $('#filterRigForm').bootstrapValidator('revalidateField', 'date_start');
//});
//
//$('#date_end').on('dp.change dp.show', function (e) {
//    $('#filterRigForm').bootstrapValidator('revalidateField', 'date_end');
//});



/* form rigtable filter */
//$('form#filterRigForm').submit(function (e) {
//
//    // Запрещаем стандартное поведение для кнопки submit
//    e.preventDefault();
//
//
////$('#filterRigForm').bootstrapValidator('revalidateField', 'date_start');
//
//    var date_start = $('#filterRigForm [name="date_start"]').val();
//    var date_end = $('#filterRigForm [name="date_end"]').val();
//
////console.log(diffDates(new Date(date_end), new Date(date_start)));
//
//validateDate(date_start);
//
//    if (date_start == '')
//        toastr.error('Выберите дату начала', 'Ошибка!', {timeOut: 2500});
//    else if (date_end == '') {
//        toastr.error('Выберите дату окончания', 'Ошибка!', {timeOut: 2500});
//    } else if (date_start === date_end) {
//        toastr.error('Дата окончания должна быть больше даты начала ', 'Ошибка!', {timeOut: 2500});
//    } else if (date_start > date_end) {
//        toastr.error('Дата окончания должна быть больше даты начала ', 'Ошибка!', {timeOut: 2500});
//    }
//    else if(diffDates(new Date(date_end), new Date(date_start)) >7){
//        toastr.error('Диапазон не может превышать 1 недели ', 'Ошибка!', {timeOut: 2500});
//    }
//    else {
//        //later you decide you want to submit
//                //$(this).unbind('submit').submit();
//    }
//
//});
//
//
//function diffDates(day_one, day_two) {
//    return (day_one - day_two) / (60 * 60 * 24 * 1000);
//};
//
//function validateDate(date){
//    //var regex=new RegExp("([0-9]{4}[-](0[1-9]|1[0-2])[-]([0-2]{1}[0-9]{1}|3[0-1]{1})|([0-2]{1}[0-9]{1}|3[0-1]{1})[-](0[1-9]|1[0-2])[-][0-9]{4})");
//    var regex=new RegExp("([0-9]{4}[-](0[1-9]|1[0-2])[-]([0-2]{1}[0-9]{1}|3[0-1]{1})|([0-2]{1}[0-9]{1}|3[0-1]{1})[-](0[1-9]|1[0-2])[-][0-9]{4})");
//    var dateOk=regex.test(date);
//    if(dateOk){
//        alert("Ok");
//    }else{
//        alert("not Ok");
//    }
//}

/*----------- END форма поиска выездов по диапазону дат-------------*/



(function ($, undefined) {
    $(function () {
        $('#userTable, #classifTable, #listmailTable').DataTable({
            "pageLength": 50,
            "order": [[2, "desc"]],
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
            "order": [[4, "asc"]],
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



        $('#destinationTable').DataTable({
            "pageLength": 50,
            "order": [[0, "asc"]],
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
            "order": [[0, "desc"]],
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


        $('#logslogin_tbl').DataTable({
            "pageLength": 50,
            "order": [[0, "desc"]],
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


        $('#logsaction_tbl').DataTable({
            "pageLength": 50,
            "order": [[0, "desc"]],
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


        $('#remarkTable').DataTable({
            "pageLength": 50,
            "order": [[0, "desc"]],
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

        $('#remarkTableRcu').DataTable({
            "pageLength": 50,
            "order": [[0, "desc"]],
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


        $('#guide_pasp_tbl').DataTable({
            "pageLength": 50,
            "order": [[1, "asc"]],
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


            } else {
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




    /*---------- table classif of action waybill ------------*/
    $('#classifTableActionWaybill tfoot th').each(function (i) {
        var table = $('#classifTableActionWaybill').DataTable();
        if (i !== 7 && i != 8) {


            if (i == 1) {
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


            } else {

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



    /*---------- таблица с logs login ------------*/
    $('#logslogin_tbl tfoot th').each(function (i) {
        var table = $('#logslogin_tbl').DataTable();

        var title = $('#logslogin_tbl tfoot th').eq($(this).index()).text();
        var x = $('#logslogin_tbl tfoot th').index($(this));
        var y = 'logsForm';
        //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
        $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
        // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');


    });
    $("#logslogin_tbl tfoot input").on('keyup change', function () {
        var table = $('#logslogin_tbl').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

    /*---------- END таблица с logs login------------*/


    /*---------- таблица с logs action ------------*/
    $('#logsaction_tbl tfoot th').each(function (i) {
        var table = $('#logsaction_tbl').DataTable();

        var title = $('#logsaction_tbl tfoot th').eq($(this).index()).text();
        var x = $('#logsaction_tbl tfoot th').index($(this));
        var y = 'logsForm';
        //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
        $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
        // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');


    });
    $("#logsaction_tbl tfoot input").on('keyup change', function () {
        var table = $('#logsaction_tbl').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

    /*---------- END таблица с logs action ------------*/

    /* ------------- remark table ---------------*/
    $('#remarkTable tfoot th').each(function (i) {
        var table = $('#remarkTable').DataTable();
        if (i !== 11 && i != 12) {

            if (i == 6 || i == 7 || i == 8 || i == 10) {
                //выпадающий список
                var y = 'remarkTable';
                var select = $('<select class="' + i + '  noprint" id="sel' + y + i + '"><option value=""></option></select>')
                        .appendTo($(this).empty())
                        .on('change', function () {

                            var val = $(this).val();

                            table.column(i) //Only the first column
                                    .search(val ? '^' + $(this).val() + '$' : val, true, false)
                                    .draw();
                        });

                var x = $('#remarkTable tfoot th').index($(this));
                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '" >' + d + '</option>');
                });


            } else {
                var title = $('#remarkTable tfoot th').eq($(this).index()).text();
                var x = $('#remarkTable tfoot th').index($(this));
                var y = 'remarkTable';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
            }

        }
    });
    $("#remarkTable tfoot input").on('keyup change', function () {
        var table = $('#remarkTable').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

    $('#remarkTableRcu tfoot th').each(function (i) {
        var table = $('#remarkTableRcu').DataTable();
        if (i !== 6 && i !== 7 && i !== 8) {

            if (i == 6 || i == 7 || i == 8 || i == 10) {
                //выпадающий список
                var y = 'remarkTable';
                var select = $('<select class="' + i + '  noprint" id="sel' + y + i + '"><option value=""></option></select>')
                        .appendTo($(this).empty())
                        .on('change', function () {

                            var val = $(this).val();

                            table.column(i) //Only the first column
                                    .search(val ? '^' + $(this).val() + '$' : val, true, false)
                                    .draw();
                        });

                var x = $('#remarkTableRcu tfoot th').index($(this));
                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '" >' + d + '</option>');
                });


            } else {
                var title = $('#remarkTableRcu tfoot th').eq($(this).index()).text();
                var x = $('#remarkTableRcu tfoot th').index($(this));
                var y = 'remarkTable';
                //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
                $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
                // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');
            }

        }
    });
    $("#remarkTableRcu tfoot input").on('keyup change', function () {
        var table = $('#remarkTableRcu').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });
    /* ------------- end remark table ---------------*/


    /*---------- guide_pasp_tbl ------------*/
    $('#guide_pasp_tbl tfoot th').each(function (i) {
        var table = $('#guide_pasp_tbl').DataTable();
        if (i !== 4) {

            var title = $('#guide_pasp_tbl tfoot th').eq($(this).index()).text();
            var x = $('#guide_pasp_tbl tfoot th').index($(this));
            var y = 'guide_pasp_tbl';
            //$(this).html( '<input type="text" placeholder="Поиск '+title+'" />' );
            $(this).html('<input type="text" class="noprint" id="inpt' + y + x + '" placeholder="Поиск"  />');
            // document.getElementById("inpt11").html('placeholder="<i class="fa fa-search" aria-hidden="true"></i>"');


        }
    });
    $("#guide_pasp_tbl tfoot input").on('keyup change', function () {
        var table = $('#guide_pasp_tbl').DataTable();
        table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
    });

    /*---------- END guide_pasp_tbl ------------*/

});




/*--------------------------- Зависимые выпадающие списки -------------------------------*/

jQuery("#id_locorg").chained("#id_region"); // зависимость ГРОЧС от области
jQuery("#id_organ").chained("#id_locorg"); // автоматич определние id органа по ГРОЧС

/************ форма user **************/
jQuery("#auto_local").chained("#id_region"); // зависимость района от области
jQuery("#auto_locality").chained("#auto_local"); // зависимость нас п. от района
/********** END форма user *************/

/******* форма высылка техники ********/
for (i = 1; i <= 30; i++) {// на 30 машин
    jQuery("#id_locorg" + i).chained("#id_region" + i); // зависимость ГРОЧС от области
    jQuery("#id_pasp" + i).chained("#id_locorg" + i); // зависимость ПАСЧ от ГРОЧС
}

/******* КОНЕЦ форма высылка техники ********/

/*--------------------------- END Зависимые выпадающие списки -------------------------------*/



/*-------------------------------------- валидация полей на  ввод символов --------------------------------------------*/
$('.fio').keypress(function (key) {//русск ьуквы
    if (((key.charCode < 46) && (key.charCode != 32) && (key.charCode != 40) && (key.charCode != 41) && (key.charCode != 44) && (key.charCode != 45)) || ((key.charCode > 46) && (key.charCode < 1040)) || (key.charCode > 1103))
        return false;
});
$('.pasp').keypress(function (key) {// русск буквы - . , цифры
    if ((key.charCode < 48 && key.charCode !== 45 && key.charCode !== 44 && key.charCode !== 46 && key.charCode !== 32) || (key.charCode > 57 && key.charCode < 1040))
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


        if (id_region == 3) {//если выбран г.Минск как область - нас.пункт автоматически заполнится г.Минск, и надо сформмировать улицы
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
        } else {
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

}
;
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



    } else {

        if (id_region == 3) {//если область г.Минск и район "все" - то улицы отображать города Минска
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
}
;
/*--------------------- КОНЕЦ функция формирует  нас.п., сельсоветы по району ---------------------*/

/*-------------------------- авт выбор района, сельсовета по нас.п. -------------------------------*/
function changeLocality() {
    var id_locality = $('select[name="id_locality"]').val();
    var id_region = $('select[name="id_region"]').val();
    var id_local = $('select[name="id_local"]').val();
    if (id_locality) {
        //alert(id_locality);
        if (id_locality != 17030) { //если нас.пунктом выбран г.Минск - район не выбирать автоматически
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
    } else {
        if (!id_local) {
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
}
;
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

    } else {
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
}
;
/*------------------------- КОНЕЦ формирование списка нас.п., улиц по сельсовету --------------------------------*/

/*------------- список техники выбранного ПАСЧ -------------------*/
function changePasp(i, j) {

    $('select[name=' + '"' + j + '"' + ']').prop("disabled", true);


    //var id_pasp = $('select[name='+'"'+i+'"'+']').val();
    var a = i.options[i.selectedIndex];

    if (typeof (a) === 'undefined') {
        $('select[name=' + '"' + j + '"' + ']').html('выбор');
    } else {

        var id_pasp = i.options[i.selectedIndex].value;


        if (id_pasp) {
            $('select[name=' + '"' + j + '"' + ']').html('<option selected value="0"> идет загрузка... </option>');
        } else {
            $('select[name=' + '"' + j + '"' + ']').html('');
        }


        if (id_pasp) {

            /*---------  техника данного ПАСЧ --------*/
            $.ajax({
                type: "POST",
                url: "/journal/select",
                data: {action: 'showTehByPasp', id_pasp: id_pasp},
                cache: false,
                success: function (responce) {

                    /*--------- чтобы обновить технику --------*/
                    // $('select[name='+'"'+j+'"'+']').select2("destroy");//уничтожаем
                    //$('select[name='+'"'+j+'"'+']').select2();//создаем заново


                    $('select[name=' + '"' + j + '"' + ']').html(responce);
                    $('select[name=' + '"' + j + '"' + ']').select2().trigger('change');
                    $('select[name=' + '"' + j + '"' + ']').prop("disabled", false);
                    /*--------- чтобы обновить технику --------*/

                    $('select[name=' + '"' + j + '"' + ']').html(responce);
                    return;

                }
            });

        }
    }



}
;

/*------------- очистить технику при изменении области/ГРОЧС -------------------*/
function clearPasp(j) {
    $('select[name=' + '"' + j + '"' + ']').html('<option value="">Выбрать</option>');

}
;


/*----------------------------------------------------------------------------------------------------------------- ВСЕ классификаторы  ------------------------------------------------------------------------------------------------*/
/*------------- редактирование классификатора-------------------*/
function editClassif(i, j, c) {

    var name_classif = $('input[name=' + '"' + i + '"' + ']').val();
    var id_classif = j;//id записи в таблицы, которую редактируем
    var classif_active = c;//имя таблицы классификатора


    if (classif_active === "workview") {//вид работ

        var id_reasonrig = $('select[name= id_reasonrig' + j + ']').val();

        if (id_classif) {
            $.ajax({
                type: "POST",
                url: "/journal/classif/" + classif_active + "/new/" + id_classif,
                data: {action: 'put', name: name_classif, id_reasonrig: id_reasonrig},
                cache: false,
                success: function (responce) {
                    //alert('Изменения успешно сохранены в БД!');
                    location.reload();
                }
            });

        }
    } else {
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


}
;

//редактирование статуса выезда
function editClassifStatusrig(i, color, j, c) {

    var name_classif = $('input[name=' + '"' + i + '"' + ']').val();
    var color_classif = $('input[name=' + '"' + color + '"' + ']').val();
    var id_classif = j;//id записи в таблицы, которую редактируем
    var classif_active = c;//имя таблицы классификатора

    if (id_classif) {
        $.ajax({
            type: "POST",
            url: "/journal/classif/" + classif_active + "/new/" + id_classif,
            data: {action: 'put', name: name_classif, color: color_classif},
            cache: false,
            success: function (responce) {
                //alert('Изменения успешно сохранены в БД!');
                location.reload();
            }
        });

    }
}
;

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
}
;


//показать поле для редактирования лица
function showDestinat(div) {
    //отображаем блок с id=div, где содержится поле для ввода данных
    $('#' + div).toggle();
}


/*---------- таблица с классификатором "информированные лица"  -----------*/
function editDestinat(i, f, x) {
// f - name of field in table
    var name_field = f + i;//fio1
    var id = i;// id table

    if (x == 2) {
        var value_field = $('select[name=' + '"' + name_field + '"' + ']').val();//value field
    } else {
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
            $('#td_' + name_field).css({
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
function editReasonrigUser(id_st, col, j) {

    var id_reasonrig = $('select[name=' + '"' + id_st + '"' + ']').val();
    var color = $('input[name=' + '"' + col + '"' + ']').val();
    var id = j;//id записи в таблицы, которую редактируем


    if (id_reasonrig) {
        $.ajax({
            type: "POST",
            url: "/journal/settings/reason_rig_color/" + id,
            data: {action: 'put', id_reasonrig: id_reasonrig, color: color},
            cache: false,
            success: function (responce) {
                //  alert('Изменения успешно сохранены в БД!');
                location.reload();
            }
        });

    }
}
;

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
}
;

/*------------------------------------------ END  Настройки пользователя ---------------------------------------------------------*/





//$('#id_region').trigger('change'); //автоматически заполнить область в выезде для пользователя, у которого есть право auto_ate
//$('#id_local').trigger('change');


/*------------------------------- маска ввода --------------------------------------*/
jQuery("#coord_lat").mask("99.999999");//долгота
jQuery("#coord_lon").mask("99.999999");//широта

/**** время следования - форма журнала выезда ****/
for (var i = 1; i < 30; i++) {
    //jQuery("#time_follow"+i).mask("99:99:99");
    jQuery("#time_follow" + i).mask("99:99");
}


/*------------------------------- КОНЕЦ маска ввода --------------------------------------*/



// In your Javascript (external .js resource or <script> tag)
$(document).ready(function () {
    $('.js-example-basic-single').select2();

    $('.select2-owner').select2({
        placeholder: "Выберите из списка",
        allowClear: true,
        "language": {
            "noResults": function () {
                return "Ничего не найдено";
            }
        }
    });
});

$(document).ready(function () {
    $('.js-example-basic-multiple').select2();
});


/*--------------- Высчитать время след = вр.приб-вр.выезда    ------------*/
function setTimeFollow(i) {
    // i - номер элемента на форме
    /*---- имена полей ----*/
    var j = 'sily[' + i + '][time_follow]';
    var t_exit = 'sily[' + i + '][time_exit]';
    var t_arr = 'sily[' + i + '][time_arrival]';

    /*----- значения полей ------*/
    var time_exit = $('input[name=' + '"' + t_exit + '"' + ']').val();
    var time_arrival = $('input[name=' + '"' + t_arr + '"' + ']').val();

    var a = new Date(time_exit);//вр.выезда
    var b = new Date(time_arrival);//вр.приб

//  set thye unit values in milliseconds
    var msecPerMinute = 1000 * 60;
    var msecPerHour = msecPerMinute * 60;

    /*-- время след = вр.приб-вр.выезда в миллисекундах --*/
    var interval = b.getTime() - a.getTime();//milliseconds

// calculate hours
    var hours = Math.floor(interval / msecPerHour);
    interval = interval - (hours * msecPerHour);
// calculate minutes
    var minutes = Math.floor(interval / msecPerMinute);
    interval = interval - (minutes * msecPerMinute);
// calculate seconds
    var seconds = Math.floor(interval / 1000);

    var h_len = Math.log(hours) * Math.LOG10E + 1 | 0;//кол-во символов в часах
    var m_len = Math.log(minutes) * Math.LOG10E + 1 | 0;//  в мин
    var s_len = Math.log(seconds) * Math.LOG10E + 1 | 0;//  в сек

    if (h_len < 2) {//формат 00
        var h = "0" + hours;
    } else {
        var h = hours;
    }
    if (m_len < 2) {//формат 00
        var m = "0" + minutes;
    } else {
        var m = minutes;
    }
    if (s_len < 2) {//формат 00
        var s = "0" + seconds;
    } else {
        var s = seconds;
    }
//result
//var t=h+":"+m+":"+s;//00:00:00 - format
    var t = h + ":" + m;//00:00:00 - format
    if (time_exit.length == 16 && time_arrival.length == 16) {

        $('input[name=' + '"' + j + '"' + ']').val(t);
    }

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
    // var distance = 'sily[' + i + '][distance]';


    var is_return = $('input[name="' + is_return_name + '"]').prop('checked');

    //alert(is_return);

    if (is_return == true) {
        $('input[name="' + t_arr + '"]').prop('disabled', true); // disable
        $('input[name="' + t_follow + '"]').prop('disabled', true); // disable
        $('input[name="' + t_end + '"]').prop('disabled', true); // disable
        // $('input[name="' + distance + '"]').prop('disabled', true); // disable

        $('input[name="' + t_arr + '"]').val('');
        $('input[name="' + t_follow + '"]').val('');
        $('input[name="' + t_end + '"]').val('');
        // $('input[name="' + distance + '"]').val('');
    } else {
        $('input[name="' + t_arr + '"]').prop('disabled', false); // enabled
        $('input[name="' + t_follow + '"]').prop('disabled', false); // enabled
        $('input[name="' + t_end + '"]').prop('disabled', false); // enabled
        // $('input[name="' + distance + '"]').prop('disabled', false); // enabled
    }

}

/*------------------- END отбой техники ------------------------*/

function see(i) {// скрыть/показать детализ инф в табл выездов

    var p = document.getElementById('sp' + i);
    if (p.style.display == "none") {
        p.style.display = "block";
    } else {
        p.style.display = "none";
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




    } else {
        $('textarea[name="' + opg_text + '"]').prop('disabled', true); // disable
        $('textarea[name="' + opg_text + '"]').val('');
    }

}

/*------------------- END выезд ОПГ - если отмечен , то поле с описанием доступно ------------------------*/


// скрыть  наименование ПС при развертывании Меню и наоборот
function none_title_for_ivanov() {

    var p = document.getElementById('title_for_ivanov');
    if (p.style.display == "none") {
        p.style.display = "block";


    } else {
        p.style.display = "none";

    }

}


/* workview depends on reasonrig  */
jQuery("#id_workview").chained("#id_reasonrig");


$(window).load(function () {
    // Run code
    //alert('hello');
    $("#toggle-vis-rig-table-13").trigger("click");
    $("#toggle-vis-rig-table-7").trigger("click");

    /* rig table type1 */
    $("#toggle-vis-rig-table-type1-0").trigger("click");
    $("#toggle-vis-rig-table-type1-13").trigger("click");
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
        var date_start = $('input[name="date_start"]').val();
        var date_end = $('input[name="date_end"]').val();

        var archive_year = $('select[name="archive_year"]').val();
        var region = $('select[name="id_region"]').val();
        var local = $('input[name="id_local"]').val();

        var reasonrig = $('select[name="reasonrig"] option:selected').text();

        var max_date = $('select[name="archive_year"]').find(':selected').attr('data-mad');

        if (reasonrig == 'Все')
            var reasonrig = '';


        if (date_start && date_end && archive_year && (date_start !== date_end) && (date_start < max_date)) {


            $('#ajax-content').fadeOut("slow");
            $('#preload-get-archive-data').css('display', 'block');


            $.ajax({
                type: 'POST',
                url: '/journal/archive_1/getInfRig',
                // dataType: 'json',
                data: {
                    date_start: date_start,
                    date_end: date_end,
                    archive_year: archive_year,
                    region: region,
                    local: local,
                    reasonrig: reasonrig

                },

                success: function (response) {

                    $('#preload-get-archive-data').css('display', 'none');

                    // $('#ajax-content').fadeOut("slow", function () {
                    $('#ajax-content').html(response);
                    $('#ajax-content').fadeIn("slow");
                    console.log("it Work");
                    //  });

                }
            });
        } else {
            if (date_start == '')
                toastr.error('Выберите дату начала', 'Ошибка!', {timeOut: 5000});
            else if (date_end == '') {
                toastr.error('Выберите дату окончания', 'Ошибка!', {timeOut: 5000});
            } else if (archive_year == '') {
                toastr.error('Выберите год', 'Ошибка!', {timeOut: 5000});
            } else if (date_start === date_end) {
                toastr.error('Дата окончания должна быть больше даты начала ', 'Ошибка!', {timeOut: 5000});
            } else if (date_start >= max_date) {
                toastr.error('В архиве за выбранный год нет данных, начиная с ' + max_date, 'Ошибка!', {timeOut: 5000});
            }
        }

    }

});






/* processing rig tab. change reasonrig */
$('#rigForm #id_reasonrig').on('change', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var work = $('#rigForm #id_workview').val();
    var object_id = $('#rigForm #object_id').val();
    var coord_lat = $('#rigForm #coord_lat').val();
    var coord_lon = $('#rigForm #coord_lon').val();
    var id_officebelong = $('#rigForm [name="id_officebelong"]').val();
    var id_firereason = $('#rigForm [name="id_firereason"]').val();
    var firereason_descr = $('#rigForm [name="firereason_descr"]').val();
    var inspector = $('#rigForm [name="inspector"]').val();
    //$('#rigForm #object_id').addClass('red-border-input');
    var coord_lat_length = $('#rigForm #coord_lat').val().length;
    //alert(coord_lat);
    if (reason == 34) {//fire

        if (object_id == '') {
            $('#rigForm #object_id').addClass('red-border-input');
        }

        //alert(reason);
        if (coord_lat == '') {
            $('#rigForm #coord_lat').addClass('red-border-input');
        }

        if (coord_lon == '') {
            $('#rigForm #coord_lon').addClass('red-border-input');
        }


        if (id_officebelong == '0') {
            $("#office-belong-id .select2-selection").addClass('red-border-input');
        }

        if (id_firereason == '0') {
            $("#firereason-id .select2-selection").addClass('red-border-input');
            $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
        }

        if (firereason_descr == '') {
            $('#rigForm [name="firereason_descr"]').addClass('red-border-input');
            $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
        }


        $('.inspector_fire_div').removeClass('hide');
        $('.inspector_div').removeClass('hide');
        $('.inspector_div').addClass('hide');

        var inspector = $('#rigForm [name="inspector_fire"]').val();

        if (inspector == '') {
            $('#rigForm [name="inspector_fire"]').addClass('red-border-input');
            //$('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
        }


    }


    //other zagor
    else if (reason == 14) {

          $('.inspector_fire_div').removeClass('hide');
        $('.inspector_div').removeClass('hide');
        $('.inspector_div').addClass('hide');

        var inspector = $('#rigForm [name="inspector_fire"]').val();

        if (inspector == '') {
            $('#rigForm [name="inspector_fire"]').addClass('red-border-input');
            //$('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
        }

        //reset
        $('#rigForm #object_id').removeClass('red-border-input');
        $('#rigForm #coord_lat').removeClass('red-border-input');
        $('#rigForm #coord_lon').removeClass('red-border-input');
        $("#office-belong-id .select2-selection").removeClass('red-border-input');
        $("#firereason-id .select2-selection").removeClass('red-border-input');
        $('#rigForm [name="firereason_descr"]').removeClass('red-border-input');
    }


    else if ( reason == 69) {

        $('.inspector_fire_div').removeClass('hide');
        $('.inspector_fire_div').addClass('hide');
        $('.inspector_div').removeClass('hide');

        var inspector = $('#rigForm [name="inspector"]').val();

        if (inspector == '') {
            $('#rigForm [name="inspector"]').addClass('red-border-input');
            $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
        }

        //reset
        $('#rigForm #object_id').removeClass('red-border-input');
        $('#rigForm #coord_lat').removeClass('red-border-input');
        $('#rigForm #coord_lon').removeClass('red-border-input');
        $("#office-belong-id .select2-selection").removeClass('red-border-input');
        $("#firereason-id .select2-selection").removeClass('red-border-input');
        $('#rigForm [name="firereason_descr"]').removeClass('red-border-input');
    }

    // molnia
    else if (reason == 74) {

        $('.inspector_fire_div').removeClass('hide');
        $('.inspector_fire_div').addClass('hide');
        $('.inspector_div').removeClass('hide');


        if (object_id == '') {
            $('#rigForm #object_id').addClass('red-border-input');
        }

        if (id_officebelong == '0') {
            $("#office-belong-id .select2-selection").addClass('red-border-input');
        }

        $('#rigForm #coord_lat').removeClass('red-border-input');
        $('#rigForm #coord_lon').removeClass('red-border-input');
        $("#firereason-id .select2-selection").removeClass('red-border-input');
        $('#rigForm [name="firereason_descr"]').removeClass('red-border-input');
        $('#rigForm [name="inspector"]').removeClass('red-border-input');

        $('#rigForm .nav-tabs  li:nth-child(3)').removeClass('red-border-input');

    } else {

        $('.inspector_fire_div').removeClass('hide');
        $('.inspector_fire_div').addClass('hide');
        $('.inspector_div').removeClass('hide');

        $('#rigForm #object_id').removeClass('red-border-input');
        $('#rigForm #coord_lat').removeClass('red-border-input');
        $('#rigForm #coord_lon').removeClass('red-border-input');
        $("#office-belong-id .select2-selection").removeClass('red-border-input');
        $("#firereason-id .select2-selection").removeClass('red-border-input');
        $('#rigForm [name="firereason_descr"]').removeClass('red-border-input');
        $('#rigForm [name="inspector"]').removeClass('red-border-input');

        $('#rigForm .nav-tabs  li:nth-child(3)').removeClass('red-border-input');
        //alert('jkl');
    }


    /* podr for select: 18 - zanytia, 47 - hoz work, 75 - ptv, 67-sluzevny+199 proverka podr  */
    if (reason == 18 || reason == 47 || reason == 75 || (reason == 67 && work == 199)) {

        $('#rigForm #div_podr_zanytia').show();
        $("#zanyatia-id .select2-selection").addClass('blue-border-input');
    } else {
        $('#rigForm #div_podr_zanytia').hide();
    }


});

/* processing rig tab. change work */
$('#rigForm #id_workview').on('change', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var work = $('#rigForm #id_workview').val();

    /* podr for select: 18 - zanytia, 47 - hoz work, 75 - ptv, 67-sluzevny+199 proverka podr  */
    if (reason == 18 || reason == 47 || reason == 75 || (reason == 67 && work == 199)) {

        $('#rigForm #div_podr_zanytia').show();
        $("#zanyatia-id .select2-selection").addClass('blue-border-input');
    } else {
        $('#rigForm #div_podr_zanytia').hide();
    }
});


/* change work view */
$('#rigForm #id_workview').on('change', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var work_view = $('#rigForm #id_workview').val();



    /* fio head check */
    if (reason == 18 && work_view == 254) {

        $('#rigForm #div_fio_head_check').show();
        $("#fio-head-check-id input").addClass('blue-border-input');
    } else {
        $("#fio-head-check-id input").val('');
        $('#rigForm #div_fio_head_check').hide();
    }

        /*  number sim */
    if (reason == 74 && work_view == 89) {
        $('#rigForm #div_sim_number').show();
        $("#sim-number-id input").addClass('blue-border-input');
    } else {
        $("#sim-number-id input").val('');
        $('#rigForm #div_sim_number').hide();
    }

});


$('#rigForm #object_id').on('keyup', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var object_id = $('#rigForm #object_id').val();

    if (object_id == '' && (reason == 34 || reason == 74)) {
        $('#rigForm #object_id').addClass('red-border-input');
    } else {
        $('#rigForm #object_id').removeClass('red-border-input');
    }
});


//$('#rigForm #coord_lat').on('keyup', function (e) {
//
// var reason = $('#rigForm #id_reasonrig').val();
//    var coord_lat = $('#rigForm #coord_lat').val();
//
// var coord_lat_length = $('#rigForm #coord_lat').val().length;
//  //  alert(coord_lat_length);
//
//    if (coord_lat == '' && reason == 34) {
//        $('#rigForm #coord_lat').addClass('red-border-input');
//    } else {
//        $('#rigForm #coord_lat').removeClass('red-border-input');
//    }
//});

//$('#rigForm #coord_lon').on('keyup', function (e) {
//
// var reason = $('#rigForm #id_reasonrig').val();
//    var coord_lon = $('#rigForm #coord_lon').val();
//
//    if (coord_lon == '' && reason == 34) {
//        $('#rigForm #coord_lon').addClass('red-border-input');
//    } else {
//        $('#rigForm #coord_lon').removeClass('red-border-input');
//    }
//});


$('#rigForm #coord_lat').on('blur', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var coord_lat = $('#rigForm #coord_lat').val();

    var coord_lat_length = $('#rigForm #coord_lat').val().length;
    //  alert(coord_lat_length);

    if (coord_lat == '' && reason == 34) {
        $('#rigForm #coord_lat').addClass('red-border-input');
    } else {
        $('#rigForm #coord_lat').removeClass('red-border-input');
    }
});

$('#rigForm #coord_lon').on('blur', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var coord_lon = $('#rigForm #coord_lon').val();


    //  alert(coord_lat_length);

    if (coord_lon == '' && reason == 34) {
        $('#rigForm #coord_lon').addClass('red-border-input');
    } else {
        $('#rigForm #coord_lon').removeClass('red-border-input');
    }
});



$('#rigForm [name="id_officebelong"]').on('change', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var id_officebelong = $('#rigForm [name="id_officebelong"]').val();

    if (id_officebelong == 0 && (reason == 34 || reason == 74)) {
        $("#office-belong-id .select2-selection").addClass('red-border-input');
    } else {
        $("#office-belong-id .select2-selection").removeClass('red-border-input');
    }
});


$('#rigForm [name="id_firereason"]').on('change', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var inspector = $('#rigForm [name="inspector"]').val();
    var firereason_descr = $('#rigForm [name="firereason_descr"]').val();
    var id_firereason = $('#rigForm [name="id_firereason"]').val();

    if (id_firereason == 0 && reason == 34) {
        $("#firereason-id .select2-selection").addClass('red-border-input');
        $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
    } else {

        if (firereason_descr == '' && reason == 34) {
            $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
        } else if (inspector == '' && reason == 34) {
            $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
        } else {

            $('#rigForm .nav-tabs  li:nth-child(3)').removeClass('red-border-input');
        }

        $("#firereason-id .select2-selection").removeClass('red-border-input');

    }

});



$('#rigForm [name="firereason_descr"]').on('keyup', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var inspector = $('#rigForm [name="inspector"]').val();
    var firereason_descr = $('#rigForm [name="firereason_descr"]').val();
    var id_firereason = $('#rigForm [name="id_firereason"]').val();

    if (firereason_descr == '' && reason == 34) {
        $('#rigForm [name="firereason_descr"]').addClass('red-border-input');
        $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
    } else {


        if (reason == 34) {
            var inspector = $('#rigForm [name="inspector_fire"]').val();
            if (id_firereason == '0') {
                $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
            } else {

                $('#rigForm .nav-tabs  li:nth-child(3)').removeClass('red-border-input');
            }
        }
        else if(reason == 14){//other zagor

        }
        else {
            if (inspector == '') {
                $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
            } else if (id_firereason == '0') {
                $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
            } else {
                $('#rigForm .nav-tabs  li:nth-child(3)').removeClass('red-border-input');
            }
        }
//
//                if (inspector == '' && reason == 34) {
//            $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
//        } else if (id_firereason == '0' && reason == 34) {
//            $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
//        } else {
//
//            $('#rigForm .nav-tabs  li:nth-child(3)').removeClass('red-border-input');
//        }

        $('#rigForm [name="firereason_descr"]').removeClass('red-border-input');
    }
});


$('#rigForm [name="inspector"]').on('keyup', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var inspector = $('#rigForm [name="inspector"]').val();
    var firereason_descr = $('#rigForm [name="firereason_descr"]').val();
    var id_firereason = $('#rigForm [name="id_firereason"]').val();

    if (inspector == '' && (reason == 34 || reason == 14 || reason == 69)) {
        $('#rigForm [name="inspector"]').addClass('red-border-input');
        $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
    } else {

        if (firereason_descr == '' && reason == 34) {
            $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
        } else if (id_firereason == '0' && reason == 34) {
            $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
        } else {

            $('#rigForm .nav-tabs  li:nth-child(3)').removeClass('red-border-input');
        }

        $('#rigForm [name="inspector"]').removeClass('red-border-input');

    }
});


$('#rigForm [name="inspector_fire"]').on('keyup', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var inspector = $('#rigForm [name="inspector_fire"]').val();
    var firereason_descr = $('#rigForm [name="firereason_descr"]').val();
    var id_firereason = $('#rigForm [name="id_firereason"]').val();

    if (inspector == '') {
        $('#rigForm [name="inspector_fire"]').addClass('red-border-input');
        // $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
    } else {

        if (reason == 34) {
            if (firereason_descr == '') {
                $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
            } else if (id_firereason == '0') {
                $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
            } else {
                $('#rigForm .nav-tabs  li:nth-child(3)').removeClass('red-border-input');
            }
        } else if (reason == 14) {
            $('#rigForm .nav-tabs  li:nth-child(3)').removeClass('red-border-input');
        }

        $('#rigForm [name="inspector_fire"]').removeClass('red-border-input');

    }
});



$('#rigForm [name="id_work_view"]').on('change', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();
    var id_work_view = $('#rigForm [name="id_work_view"]').val();

    if (id_work_view == 0) {
        $("#work-view-id .select2-selection").addClass('red-border-input');
    } else {
        $("#work-view-id .select2-selection").removeClass('red-border-input');
    }
});


$('#rigForm [name="id_reasonrig"]').on('change', function (e) {

    var reason = $('#rigForm #id_reasonrig').val();


    if (reason == 0) {
        $("#reason-rig-id .select2-selection").addClass('red-border-input');
    } else {
        $("#reason-rig-id .select2-selection").removeClass('red-border-input');
    }
});

/* END processing rig tab. change reasonrig */



/* form export to csv */
$('form#exporttoCsvRep1').submit(function (e) {

    // Запрещаем стандартное поведение для кнопки submit
    e.preventDefault();

    var date_start = $('#exporttoCsvRep1 [name="date_start"]').val();
    var date_end = $('#exporttoCsvRep1 [name="date_end"]').val();

//alert(certificate_id);


    if (date_start == '')
        toastr.error('Выберите дату начала', 'Ошибка!', {timeOut: 5000});
    else if (date_end == '') {
        toastr.error('Выберите дату окончания', 'Ошибка!', {timeOut: 5000});
    } else if (date_start === date_end) {
        toastr.error('Дата окончания должна быть больше даты начала ', 'Ошибка!', {timeOut: 5000});
    } else if (date_start > date_end) {
        toastr.error('Дата окончания должна быть больше даты начала ', 'Ошибка!', {timeOut: 5000});
    } else {
        //later you decide you want to submit
        $(this).unbind('submit').submit();
    }

});



/* form search rig in archive */
$('form#searchArchiveForm').submit(function (e) {

    // Запрещаем стандартное поведение для кнопки submit
    e.preventDefault();

    var archive_year = $('select[name="archive_year"]').val();
    var id_rig = $('input[name="id_rig"]').val();

//alert(id_rig);


    if (archive_year == '')
        toastr.error('Выберите год', 'Ошибка!', {timeOut: 5000});

    else if (id_rig == '')
        toastr.error('Введите ID выезда', 'Ошибка!', {timeOut: 5000});
    else {
        //later you decide you want to submit
        $(this).unbind('submit').submit();
    }

});


$('#id_rig_seacrh_archive').keypress(function (key) {
    if (((key.charCode < 48) && (key.charCode != 44)) || (key.charCode > 57))
        return false;
});



$('#id_local_archive_1').keydown(function (event) {
    //alert('ff');
    if (event.keyCode == 13) {
        event.preventDefault();
        return false;
    }
});




$('#rigForm select[name="podr_zanytia"]').on('change', function (e) {


    var podr_zanytia = $('#rigForm select[name="podr_zanytia"]').val();
//alert(podr_zanytia);

    if (podr_zanytia !== '') {
        $("#zanyatia-id .select2-selection").removeClass('blue-border-input');
        $.ajax({
            //dataType: "json",
            type: "POST",
            url: "/journal/select",
            data: {action: 'showAddrPasp', pasp_id: podr_zanytia, sign: 'address'},

            success: function (response) {
                $('#div-address').html();

                $("#div-address").html(response);
                $('#div-address').fadeIn("slow");
                console.log("it Work");



                /* street */
                $.ajax({
                    //dataType: "json",
                    type: "POST",
                    url: "/journal/select",
                    data: {action: 'showAddrPasp', pasp_id: podr_zanytia, sign: 'street'},

                    success: function (response) {
                        $('#div-street').html();

                        $("#div-street").html(response);
                        $('#div-street').fadeIn("slow");
                        console.log("it Work");

                        $(document).ready(function () {
                            // $('.js-example-basic-single').select2();
                            $('.street-block-select-single').select2();

                        });


                    }

                });

                /* housing */
                $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: "/journal/select",
                    data: {action: 'showAddrPasp', pasp_id: podr_zanytia, sign: 'housing'}

                }).done(function (data) {
                    $('#rigForm #coord_lat').val(data.latitude);
                    $('#rigForm #coord_lon').val(data.longitude);

                    $('#rigForm input[name="home_number"]').val(data.home_number);
                    $('#rigForm input[name="housing"]').val(data.housing);


                });

                $(document).ready(function () {
                    // $('.js-example-basic-single').select2();
                    $('.address-block-select-single').select2();

                });

            }
        });
    } else {
        $("#zanyatia-id .select2-selection").addClass('blue-border-input');
    }


//// $('#rigForm select[name="id_street"]').val(data.id_street);
////    $('#rigForm select[name="id_street"]').select2().trigger('change');


});








/*  SD */
$('.select2-single').select2({
    placeholder: "Выберите из списка",
    allowClear: true,
    "language": {
        "noResults": function () {
            return "Ничего не найдено";
        }
    }
});


$('body').on('change', '#userForm #id_user_sd', function (e) {

    e.preventDefault();

    var user_sd = $(this).val();

    if (user_sd !== '') {
        $('#userForm').find('.row-data-for-sd').removeClass("show");
        $('#userForm').find('.row-data-for-sd').addClass("hide");


        var login=$('#userForm #id_user_sd option:selected').data('login');
        var psw=$('#userForm #id_user_sd option:selected').data('psw');
        var fio=$('#userForm #id_user_sd option:selected').data('fio');
        var region=$('#userForm #id_user_sd option:selected').data('region');

        $('#userForm').find('input[name="login"]').val(login);
        $('#userForm').find('input[name="password"]').val(psw);
        $('#userForm').find('input[name="name"]').val(fio);

        $('#userForm').find('select[name="id_region"]').val(region);
        $('#userForm').find('select[name="id_region"]').change();

        $('#userForm').find('input[name="can_edit"]').prop('checked',true);
        $('#userForm').find('input[name="auto_ate"]').prop('checked',true);


    } else {

        $('#userForm').find('.row-data-for-sd').removeClass("hide");
        $('#userForm').find('.row-data-for-sd').addClass("show");

        $('#userForm').find('input[name="login"]').val('');
        $('#userForm').find('input[name="password"]').val('');
        $('#userForm').find('input[name="name"]').val('');
    }
    // alert(user_sd);

});


jQuery("#id_local_bokk").chained("#id_region_bokk");




function changeModeRep1(el) {

    let val = el.checked;
    if (val === true)
        val = 1;
    else
        val = 0;
    let link = $(el).data('link');
    let by_place = $(el).data('place-descr');
    let by_podr = $(el).data('podr-descr');

    var loc=$('#rep1Form').find('#auto_local').val();
    var id_region=$('#id_region').val();

    if (val === 1) {//by car's podr
        // $('#block-mode-rep1-descr').text(by_podr);
        $('input[name="is_neighbor"]').prop('disabled', true);
        $('#block-neighbor-descr').css('opacity', '0.5');

        if(parseInt(loc) === 76){//Molodechno
            $('#rep1Form').find('.row_minobl_paso').removeClass('hide');
        }


        if(id_region !== null && loc !== null && loc !== ''){

            $('#id_pasp').empty().trigger('chosen:updated');
            //get locals by region
            $.ajax({
                dataType: "json",
                url: '/journal/select',
                method: 'POST',
                data: {
                    id_region: id_region,
                    id_local: loc,
                    action: 'showPaspByLocalForRep1'
                },
                success: function (data) {

                    $(data).each(function (index, value) {

                        $("#id_pasp").append($("<option></option>").attr("value", value.pasp_id).text(value.pasp_name + ' (' + value.locorg_name + ')')).trigger('chosen:updated');
                    });

                },
                error: function () {
                    console.log('jj');
                }
            });


            $('#id_pasp_chosen').css('width','260px');
            //show select local
            $('#div_is_pasp').css('display','inline');
            $('#div_id_pasp').css('display','inline');
        }
        else{
            $('#div_is_pasp').css('display','none');
            $('#div_id_pasp').css('display','none');
        }

    } else {
        // $('#block-mode-rep1-descr').text(by_place);
        $('input[name="is_neighbor"]').prop('disabled', false);
        $('#block-neighbor-descr').css('opacity', '1');

        $('#rep1Form').find('.row_minobl_paso').addClass('hide');

//        $('#div_is_pasp').css('display','none');
//        $('#div_id_pasp').css('display','none');

    }

}



function changeNeighborRep1(el) {

    let val = el.checked;
    if (val === true)
        val = 1;
    else
        val = 0;
    let link = $(el).data('link');
    let not_neighbor_descr = $(el).data('not-neighbor-descr');
    let neighbor_descr = $(el).data('neighbor-descr');

    if (val === 1) {
        // $('#block-neighbor-descr').text(neighbor_descr);
        $('#lable-for-neighbor').attr('data-original-title', neighbor_descr);
    } else {
        //$('#block-neighbor-descr').text(not_neighbor_descr);
        $('#lable-for-neighbor').attr('data-original-title', not_neighbor_descr);

    }
}






/*-------------- notifications ------------------*/
$('body').on('click', '.new-notif', function () {
    var id = $(this).attr("id");
    var element = $(this);
    $.ajax({
        type: 'POST',
        url: '/journal/readNotify',
        //  dataType: 'json',
        data: {id: id},
        success: function (data) {
            if (typeof (data.error) != "undefined") {
                alert('error');
            } else {
                toastr.success('Уведомление прочитано', 'Уведомление', {timeOut: 2500, "progressBar": true});
                element.removeClass('new-notif');
                element.removeAttr('id');

                var last_numb = parseInt($("#number_notif").text());
                if (last_numb > 0) {
                    var new_numb = last_numb - 1;

                    if (new_numb > 0) {
                        $(".number_notif").text(new_numb);
                    } else {
                        removeAllNotifications();
                    }
                }

            }

        }
    })

});



$(document).on('click', "#read_all_notify_button", function () {

    var link = $(this).attr('data-link');

    var id = $(this).attr("id");
    var element = $(this);

    $.ajax({
        type: 'POST',
        url: link,
        dataType: 'json',
        data: {id: id},
        success: function (data) {
            if (typeof (data.error) != "undefined") {
                alert('error');
            } else {
                removeAllNotifications();
                toastr.success('Все уведомление прочитаны', 'Уведомление', {timeOut: 2500, "progressBar": true});

                $('.new-notif').each(function (index, val) {
                    $(this).removeClass('new-notif');
                });
            }

        }
    });
});



function removeAllNotifications() {

    $(".number_notif").remove();
    $("#read_all_notify_button").remove();

}

/*-------------- END notifications ------------------*/


    $('#characterForm .distance-sily').keypress(function (key) {
     if (((key.charCode < 48)&& (key.charCode != 46)) || (key.charCode > 57) )
        return false;
});

jQuery("#loc_id_chaned").chained("#reg_id_chaned");




$('#rigs-obl-garnison-modal').on('show.bs.modal', function (e) {

    var btn = $(e.relatedTarget);

    var id_region=btn.data('region');

    $('#rigs-obl-garnison-modal').find('.modal-body').html('');

        $('#rigs-obl-garnison-modal').find('.modal-content').html('');
        $('#preload-get-archive-data').css('display', 'block');

    $.ajax({
        type: 'POST',
        url: btn.data('url'),
        data:{'id_region': id_region}
    }).done(function (response) {


        $('#rigs-obl-garnison-modal').find('.modal-content').html(response);
        $('#preload-get-archive-data').css('display', 'none');

    });

});


function refresh_rigs_obl_table(){

    var url=$('.rigs-obl-garnison').attr('data-url');
    var id_region=$('.rigs-obl-garnison').attr('data-region');
    $.ajax({
        type: 'POST',
        url: url,
        data:{'id_region': id_region}
    }).done(function (response) {


        $('#rigs-obl-garnison-modal').find('.modal-content').html(response);
        $('#preload-get-archive-data').css('display', 'none');

    });
}




function diffDates(day_one, day_two) {
    return (day_one - day_two) / (60 * 60 * 24 * 1000);
};

function validateDate(date){
    //var regex=new RegExp("([0-9]{4}[-](0[1-9]|1[0-2])[-]([0-2]{1}[0-9]{1}|3[0-1]{1})|([0-2]{1}[0-9]{1}|3[0-1]{1})[-](0[1-9]|1[0-2])[-][0-9]{4})");
    var regex=new RegExp("([0-9]{4}[-](0[1-9]|1[0-2])[-]([0-2]{1}[0-9]{1}|3[0-1]{1})|([0-2]{1}[0-9]{1}|3[0-1]{1})[-](0[1-9]|1[0-2])[-][0-9]{4})");
    var dateOk=regex.test(date);
    if(dateOk){
        alert("Ok");
    }else{
        alert("not Ok");
    }
}


//From: http://stackoverflow.com/questions/3066586/get-string-in-yyyymmdd-format-from-js-date-object
Date.prototype.toInputFormat = function () {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();
    return yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0]); // padding
};

$('body').on('click', '#filterRigForm #next_day', function (e) {

    e.preventDefault();

    var d_start = new Date($('#filterRigForm input[name="date_start"]').val());
    var d_end = new Date($('#filterRigForm input[name="date_end"]').val());

    var days = 1;

    if (!isNaN(d_start.getTime())) {
        d_start.setDate(d_start.getDate() + days);

        $('#filterRigForm input[name="date_start"]').val(d_start.toInputFormat());
        $('#filterRigForm input[name="date_start"]').trigger('change');
    } else {
        toastr.error('Неверный формат даты начала периода', 'Ошибка!', {timeOut: 2500});
    }

    if (!isNaN(d_end.getTime())) {
        d_end.setDate(d_end.getDate() + days);
//alert(d_end.toInputFormat());
        $('#filterRigForm input[name="date_end"]').val(d_end.toInputFormat());
        $('#filterRigForm input[name="date_end"]').trigger('change');
    } else {
        toastr.error('Неверный формат даты окончания периода', 'Ошибка!', {timeOut: 2500});
    }

});


$('body').on('click', '#filterRigForm #prev_day', function (e) {

    e.preventDefault();

    var d_start = new Date($('#filterRigForm input[name="date_start"]').val());
    var d_end = new Date($('#filterRigForm input[name="date_end"]').val());

    var days = 1;

    if (!isNaN(d_start.getTime())) {
        d_start.setDate(d_start.getDate() - days);

        $('#filterRigForm input[name="date_start"]').val(d_start.toInputFormat());
        $('#filterRigForm input[name="date_start"]').trigger('change');
    } else {
        toastr.error('Неверный формат даты начала периода', 'Ошибка!', {timeOut: 2500});
    }

    if (!isNaN(d_end.getTime())) {
        d_end.setDate(d_end.getDate() - days);

        $('#filterRigForm input[name="date_end"]').val(d_end.toInputFormat());
        $('#filterRigForm input[name="date_end"]').trigger('change');
    } else {
        toastr.error('Неверный формат даты окончания периода', 'Ошибка!', {timeOut: 2500});
    }

});



