


/*-------- trunk form ------------*/
    $(".chzn-select").chosen();
	    $(".chzn-select-trunk").chosen({
       // allow_single_deselect: true
    });

        $(".chzn-select").chosen();
	    $(".chzn-select-without").chosen({
                allow_single_deselect: true
    });



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

        var $div_new = $('#klon' + num);
        $div_new.find('.np_name').attr('name', 'locality[' + num + '][name]');

        $div_new.find('.np_vid').attr('name', 'locality[' + num + '][id_vid]');
        $div_new.find('.np_id').attr('name', 'locality[' + num + '][id]');

        $div_new.find('.np_id').attr('name', 'locality[' + num + '][id]');
        $div_new.find('.np_selsovet').attr('name', 'locality[' + num + '][id_selsovet]');

        $div_new.find('.np_name').val('');
        $div_new.find('.np_id').val('');



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








