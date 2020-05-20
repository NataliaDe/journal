/* КОЛ-ВО МАШИН МЧС = 30
 *
 */

$(function () {  //всплывающая подсказка
    $("[data-toggle='tooltip']").tooltip();
});






//$('#id_region').trigger('change'); //автоматически заполнить область в выезде для пользователя, у которого есть право auto_ate
 //$('#id_local').trigger('change');




 $('#resultsBattleForm input[name="dead_man"], #resultsBattleForm input[name="save_man"], #resultsBattleForm input[name="inj_man"], #resultsBattleForm input[name="dead_man"], #resultsBattleForm input[name="ev_man"],\n\
 #resultsBattleForm input[name="save_build"], #resultsBattleForm input[name="dam_build"], #resultsBattleForm input[name="des_build"],\n\
#resultsBattleForm input[name="save_teh"], #resultsBattleForm input[name="dam_teh"], #resultsBattleForm input[name="des_teh"],\n\
#resultsBattleForm input[name="save_an"], #resultsBattleForm input[name="dam_an"], #resultsBattleForm input[name="des_an"],#resultsBattleForm input[name="dead_child"], .cnt_means,\n\
#resultsBattleForm input[name="save_child"],#resultsBattleForm input[name="ev_child"],#resultsBattleForm input[name="save_mchs"],#resultsBattleForm input[name="ev_mchs"],#resultsBattleForm input[name="save_an_mchs"], .int-cnt').keypress(function (key) {

   if ((key.charCode < 48) || (key.charCode > 57))
        return false;
});


    $('#resultsBattleForm input[name="save_plan"], #resultsBattleForm input[name="dam_plan"], #resultsBattleForm input[name="des_plan"], #trunkForm input[name="s_bef"], #trunkForm input[name="s_loc"], \n\
    #resultsBattleForm input[name="dam_money"], #resultsBattleForm input[name="save_wealth"], .str-cnt').keypress(function (key) {
     if (((key.charCode < 48)&& (key.charCode != 46)) || (key.charCode > 57) )
        return false;
});



function allowCntMeans(){

  if ((event.which < 48) || (event.which > 57)){
      //alert(event.which);
      event.preventDefault();
       // return false;
    }
}

function allowCntWater(){

 if (((event.which < 48)&& (event.which != 46) && (event.which != 47)) || (event.which > 57) ){
      //alert(event.which);
      event.preventDefault();
       // return false;
    }
}

function allowCntTimePod(){

 if (((event.which < 48)&& (event.which != 45) ) || (event.which > 57) ){
      //alert(event.which);
      event.preventDefault();
       // return false;
    }
}


/*-------- trunk form ------------*/
    $(".chzn-select").chosen();

    $(".chzn-select-trunk").chosen({
        allow_single_deselect: true
    });


     jQuery(".time-pod-mask").mask("99-99");//долгота

$(document).ready(function(){
         $('body').on('click', '#add_teacher', function (e) {
            e.preventDefault();

             var  id_car_block = $(this).attr('data-idcar');
             //alert(id_car_block);

$('.teacher_row_'+id_car_block+' select').last().chosen("destroy");
              // get the last DIV which ID starts with ^= "klon"
  //var $div = $('div#'+id_car_block+' div[id^="klon"]:last');
   var $div = $('div[id^="klon"]:last');
    var $div_for_clon = $('.teacher_row_'+id_car_block+':last');
  //alert($div);
  // Read the Number from that DIV's ID (i.e: 3 from "klon3")
  // And increment that number by 1
   var prev_num=parseInt( $div.prop("id").match(/\d+/g), 10 );
  var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;

  var is=$('div #klon'+num);
while ((is.length > 0)) {
	 var num=num+1;
      var  is=$('div #klon'+num);
}

  // Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
  var $klon = $div_for_clon.clone().prop('id', 'klon'+num );
  // Finally insert $klon wherever you want
  //$div.after( $klon.text('klon'+num) );
 // $div.after( $klon.text('klon'+num) );
     $klon.insertAfter($('.teacher_row_'+id_car_block).last());
     //$(".chzn-select").chosen();
         $(".chzn-select-trunk").chosen({
        allow_single_deselect: true
    });
      jQuery(".time-pod-mask").mask("99-99");//долгота
 //    var prev_val = $("#klon"+prev_num+" .tt option:selected").val();
    // alert(prev_val);
  //   $("#klon"+num+" .tt").val(prev_val).trigger('chosen:updated');
 //    $("#klon"+num+" .cal_a a").attr('data-klond','klon'+num);
  //  var v=$("#klon"+num+" .cal_a a").attr('data-klond');
    //alert(v);
            return false;
        });

});

        $('body').on('click', '.del-teacher', function (e) {

            e.preventDefault();
             var  id_car_block = $(this).attr('data-idcar');
            if ($(".teacher-list_"+id_car_block).length > 1) {

                $(this).parent().parent().remove();
            }
            return false;
        });


                   /* add tags to bd */
        function AddTag() {

            if($('#is_water').prop('checked'))
                var is_water= 1;
            else
                var is_water= 0;
            //alert($('#tag_name').val());
            $.ajax({
                dataType: "json",
                url: '/journal/trunk/add_trunk_ajax',
                method: 'POST',
                data: {
                    name: $('#tag_name').val(),
                    is_water: is_water
                }
            }).done(function (data) {
                $('.trunk-select-on-form').append('<option value="' + data.id + '">' + data.tag_name + '</option>');
                $('.trunk-select-on-form').trigger("chosen:updated");
                $('#tags_del_trunk').append('<option data-is-water="'+data.is_water+'" value="'+data.id+'">' + data.tag_name + data.water_text+ '</option>');
                $('#tags_del_trunk').trigger("chosen:updated");


                $('#id_edit_trunk').append('<option data-is-water="'+data.is_water+'" value="' + data.id + '">' + data.tag_name + '</option>');
                $('#id_edit_trunk').trigger("chosen:updated");

                $('#tag_name').val('');
                $('#is_water').prop('checked', false);

                $('.md-close').click();
                toastr.info(data.message, 'Info:', {timeOut: 5000});
            });
            //$('.md-close').click();
        }



                    /* edit tags to bd */
        function editTag() {

            if($('#is_water_edit').prop('checked'))
                var is_water= 1;
            else
                var is_water= 0;

            //alert($('#tag_name').val());
            $.ajax({
                dataType: "json",
                url: '/journal/trunk/edit_trunk_ajax',
                method: 'POST',
                data: {
                    new_name: $('#edit_tag_name').val(),
                    id: $('#id_edit_trunk').val(),
                    is_water: is_water
                }
            }).done(function (data) {

                $('#id_edit_trunk option[value=' + $('#id_edit_trunk').val() + ']').text(data.tag_name);
                $('#tags_del_trunk option[value=' + $('#id_edit_trunk').val() + ']').text(data.tag_name+ data.water_text);
                $('#tags_del_trunk option[value=' + $('#id_edit_trunk').val() + ']').attr('data-is-water',data.is_water);

                $('.trunk-select-on-form option[value=' + $('#id_edit_trunk').val() + ']').text(data.tag_name);


                $('#id_edit_trunk').trigger("chosen:updated");//select edit
                $('#tags_del_trunk').trigger("chosen:updated");//select delete
                $('.trunk-select-on-form').trigger("chosen:updated");// on form

                $('#edit_tag_name').val('');

                $('.md-close').click();
                toastr.info(data.message, 'Info:', {timeOut: 5000});
            });
            //$('.md-close').click();
        }


            /* delete tags from bd */
        $('body').on('click', '#del_tag_btn', function (e) {
            $('#tags_del_trunk option:selected').each(function () {
                $.ajax({
                    dataType: "json",
                    url: '/journal/trunk/del_trunk_ajax',
                    method: 'POST',
                    data: {
                        id: $(this).val()
                    }
                });
                $('.trunk-select-on-form option[value=' + $(this).val() + ']').remove();
                $('#id_edit_trunk option[value=' + $(this).val() + ']').remove();//edit select
                $(this).remove();
                toastr.error('Тип был удален из БД', 'Info:', {timeOut: 5000});
            });
            $('.trunk-select-on-form').trigger("chosen:updated");
            $('#tags_del_trunk').trigger("chosen:updated");
            $('#id_edit_trunk').trigger("chosen:updated");//select edit
        });





                /* is water edit trunk */
        $('body').on('change', '#id_edit_trunk', function (e) {
                var is_water = $('option:selected', this).attr('data-is-water');

                if (parseInt(is_water) === 1)
                $('#is_water_edit').prop('checked', true);
                else
                $('#is_water_edit').prop('checked', false);
        });








