
/*-------------------------  manual js --------------------------------------- */
$(document).ready(function () {  // поиск значения в выпад меню
$(".chosen-select-deselect").chosen({
allow_single_deselect: true,
        width: '100%'

});
        });
        $(document).ready(function () {
$('.js-name-car-multiple').select2({
placeholder: "Наименование техники"
});
        $('.js-region-multiple').select2({
placeholder: "Область"
});
        $('.js-local-multiple').select2({
placeholder: "Г(Р)ОЧС"
});
        $('.js-pasp-multiple').select2({
placeholder: "ПАСЧ"
});
        $('.js-v-multiple').select2({
placeholder: "Объем цистерны, тонны"
});
        $('.js-type-car-single').select2({
/*placeholder: "Тип техники"*/
});
        $('.js-vid-car-multiple').select2({
placeholder: "Вид техники"
});
        });
        $('#id_region_map').on('change', function (e) {

var ids_region = $('#id_region_map').val();
        $('#id_local_map').empty().trigger('chosen:updated');
        var current_locals = $('#current_local_map').val();
        var arr_current_local = current_locals.split(",");
        console.log(arr_current_local);
        $('#id_pasp_map').empty();
        if (ids_region !== null) {
//get locals by region
$.ajax({
dataType: "json",
        url: '/journal/maps_for_mes/get_grochs_by_region',
        method: 'POST',
        data: {
        ids_region: ids_region
        },
        success: function (data) {

        $(data).each(function (index, value) {


        if (arr_current_local.includes(value.id)) {
        $("#id_local_map").append($("<option selected></option>").attr("value", value.id).text(value.name)).trigger('chosen:updated');
        } else {
        $("#id_local_map").append($("<option></option>").attr("value", value.id).text(value.name)).trigger('chosen:updated');
        }


        });
        },
        error: function () {
        console.log('jj');
        }
});
//$('#id_local_map_chosen').css('width','215px');
        //show select local
        // $('#div_id_local_map').css('display','inline');

} else {

// $('#div_id_local_map').css('display','none');
}






//$('#id_region_map_chosen').removeClass('chosen-with-drop');
//$('#id_region_map_chosen').removeClass('chosen-container-active');

//$('#id_region_map_chosen').trigger("chosen:close");

});
        $('#id_local_map').on('change', function (e) {
var ids_local = $('#id_local_map').val();
        $('#current_local_map').val(ids_local);
        });
        $('#id_local_map').on('change', function (e) {

var ids_local = $('#id_local_map').val();
        $('#id_pasp_map').empty().trigger('chosen:updated');
//var current_locals=$('#current_local_map').val();
//var arr_current_local = current_locals.split(",");
//console.log(arr_current_local);

        if (ids_local !== null) {
//get locals by region
$.ajax({
dataType: "json",
        url: '/journal/maps_for_mes/get_pasp_by_grochs',
        method: 'POST',
        data: {
        ids_grochs: ids_local
        },
        success: function (data) {

        $(data).each(function (index, value) {


        //if(arr_current_local.includes(value.id)){
        // $("#id_local_map").append($("<option selected></option>").attr("value", value.id).text(value.name+' ('+value.region_name+')')).trigger('chosen:updated');
        //}
        // else{
        $("#id_pasp_map").append($("<option></option>").attr("value", value.id).text(value.name + ' ' + value.locorg_name)).trigger('chosen:updated');
                //}


        });
        },
        error: function () {
        console.log('jj');
        }
});
} else {

// $('#div_id_local_map').css('display','none');
}


});
        $('#id_pasp_map').on('change', function (e) {


});
        function getObAC() {
        var id_region = $('#id_region_map').val();
                var id_grochs = $('#id_local_map').val();
                var id_pasp = $('#id_pasp_map').val();
                $('#id_ob_car_map').empty().trigger('chosen:updated');
                if (id_region === null)
                id_region = 0;
                if (id_grochs === null)
                id_grochs = 0;
                if (id_pasp === null)
                id_pasp = 0;
//alert(id_region+', '+id_grochs+', '+id_pasp);


                $.ajax({
                dataType: "json",
                        url: '/journal/maps_for_mes/get_ob_ac',
                        method: 'POST',
                        data: {
                        id_region: id_region,
                                id_grochs: id_grochs,
                                id_pasp: id_pasp

                        },
                        success: function (data) {

                        $(data).each(function (index, value) {


                        //if(arr_current_local.includes(value.id)){
                        // $("#id_local_map").append($("<option selected></option>").attr("value", value.id).text(value.name+' ('+value.region_name+')')).trigger('chosen:updated');
                        //}
                        // else{
                        $("#id_ob_car_map").append($("<option></option>").attr("value", value.v).text(value.v)).trigger('chosen:updated');
                                //}


                        });
                        },
                        error: function () {
                        console.log('jj');
                        }
                });
                }




$("a[data-toggle=collapse]").click(function (e) {

if (!$(this).hasClass('clicked')) { // если класса нет
$(this).addClass('clicked'); // добавляем класс
        $(this).children('i').removeClass('fa-chevron-circle-down');
        $(this).children('i').addClass('fa-chevron-circle-up');
        $(this).children('span').text('Скрыть фильтр');
} else { // если есть
$(this).removeClass('clicked'); // убираем класс
        $(this).children('i').removeClass('fa-chevron-circle-up');
        $(this).children('i').addClass('fa-chevron-circle-down');
        $(this).children('span').text('Показать фильтр');
}
});
        $("#theme_panel_button").click(function() {
/*$( "#theme_panel" ).toggle( "slow", function() {
 // Animation complete.
 $('#theme_panel_button').show();
 });*/


if ($("#theme_panel").hasClass('open_panel')){
$("#theme_panel").removeClass('open_panel');
        $("#theme_panel").addClass('close_panel');
        $("#theme_panel_inner").hide();
        $("#theme_panel_button").show();
}
else{
$("#theme_panel").removeClass('close_panel');
        $("#theme_panel").addClass('open_panel');
        $("#theme_panel_inner").show();
        //$( "#theme_panel_button" ).show();
}



});
$('#show_border').change(function () {


    if ($(this).is(":checked")) {

        border_rb(1);
    } else {

        border_rb(0);

    }
});



$('#show_border_local').change(function () {


    if ($(this).is(":checked")) {

        border_local(1);
    } else {

        border_local(0);

    }
});


$('#show_name_local').change(function () {


    if ($(this).is(":checked")) {

        show_name_local(1);
    } else {

        show_name_local(0);

    }
});

$('#hide-header-menu').click(function () {

    var is_open = $('.background').hasClass('start-background');

    if (is_open) {//close menu
        $('.background').removeClass('start-background');
        $('.background').css('height', '0%');
        $('.div-map').css('height', '100%');
        $('#star-mes-panel').removeClass('hide');
        $('#star-mes-panel').addClass('show');
    } else {

        $('.background').addClass('start-background');
        $('.background').css('height', '5%');
        $('.div-map').css('height', '95%');
                $('#star-mes-panel').removeClass('show');
        $('#star-mes-panel').addClass('hide');

    }
});

$('#star-mes-panel').click(function () {

        $('.background').addClass('start-background');
        $('.background').css('height', '5%');
        $('.div-map').css('height', '95%');
                $('#star-mes-panel').removeClass('show');
        $('#star-mes-panel').addClass('hide');
});








