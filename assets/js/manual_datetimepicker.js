
/*----------------------------------- Calendar ---------------------------------------*/
$(function () {
    /* дата и время поступления сообщения */
    $('#time_msg').datetimepicker({
        language: 'ru',
        defaultDate: new Date(),
        format: 'YYYY-MM-DD HH:mm:ss'
                // autoclose: true
    });


    /* дата и время локализации */
    $('#time_loc').datetimepicker({
        language: 'ru',
        format: 'YYYY-MM-DD HH:mm:ss'
                // autoclose: true
    });

    /* дата и время ликвидации */
    $('#time_likv').datetimepicker({
        language: 'ru',
        format: 'YYYY-MM-DD HH:mm:ss'
                // autoclose: true
    });
    
      /*------  дата и время локализации < дата и время ликвидации ------*/
    $('#time_loc').on("dp.change", function (e) {
        $('#time_likv').data("DateTimePicker").setMinDate(e.date);
    });

    $('#time_likv').on("dp.change", function (e) {
        $('#time_loc').data("DateTimePicker").setMaxDate(e.date);
    });
    /* ------- END дата и время локализации < дата и время ликвидации -------*/
    
    
    
       /* дата без времени*/
    $('#date_start').datetimepicker({
        language: 'ru',
        format: 'YYYY-MM-DD',
        pickTime: false
                // autoclose: true
    });

       /* дата без времени*/
    $('#date_end').datetimepicker({
        language: 'ru',
        format: 'YYYY-MM-DD',
        pickTime: false
                // autoclose: true
    });
    
          /*------  начальная дата < конечная дата ------*/
    $('#date_start').on("dp.change", function (e) {
        $('#date_end').data("DateTimePicker").setMinDate(e.date);
    });

    $('#date_end').on("dp.change", function (e) {
        $('#date_start').data("DateTimePicker").setMaxDate(e.date);
    });
    /* ------- END начальная дата < конечная дата -------*/

});

//если на форме несколько идентичных полей даты-отличие только номером j
function getTimeMsg(j) {
//силы и ср-ва др ведомств-время сообщения
    $('#time_msg' + j).datetimepicker({
        language: 'ru',
        defaultDate: new Date(),
        format: 'YYYY-MM-DD HH:mm:ss'
    });

}


/*----------------- время прибытия - форма привлекаемых служб --------------------*/
function getTimeArrival(j) {

    //силы и ср-ва др ведомств-время прибытия
    $('#time_arrival' + j).datetimepicker({
        language: 'ru',
                defaultDate: new Date(),
        format: 'YYYY-MM-DD HH:mm:ss'
    });
}
/*----------------- КОНЕЦ время прибытия -  форма привлекаемых служб --------------------*/

/*----------------- время прибытия - форма журнал выезда - для машин МЧС --------------------*/
function getTimeArrivalMchs(j, i) {
// i - номер поля времени выезда
    var t_exit = 'sily[' + i + '][time_exit]';//имя поля времени выезда
    /*----- значения времени выезда ------*/
    var time_exit = $('input[name=' + '"' + t_exit + '"' + ']').val();

    //силы и ср-ва др ведомств-время прибытия
    $('#time_arrival' + j).datetimepicker({
        language: 'ru',
        'minDate': new Date(time_exit), //дата прибытия д б > дата выезда
        format: 'YYYY-MM-DD HH:mm:ss'
    });
    
   

}
/*----------------- КОНЕЦ  время прибытия - форма журнал выезда - для машин МЧС --------------------*/

//если на форме несколько идентичных полей даты-отличие только номером j
function getTimeExit(j) {
    //информирование-время выезда
    $('#time_exit' + j).datetimepicker({
        language: 'ru',
        defaultDate: new Date(),
        format: 'YYYY-MM-DD HH:mm:ss'
    });
}

//если на форме несколько идентичных полей даты-отличие только номером j
function getTimeEnd(j) {
    //информирование-время окончания работ
    $('#time_end' + j).datetimepicker({
        language: 'ru',
        format: 'YYYY-MM-DD HH:mm:ss'
    });
}
//если на форме несколько идентичных полей даты-отличие только номером j
function getTimeReturn(j) {
    //информирование-время возвращения
    $('#time_return' + j).datetimepicker({
        language: 'ru',
        format: 'YYYY-MM-DD HH:mm:ss'
    });
}




/*------------------------------------- END Calendar -----------------------------------*/