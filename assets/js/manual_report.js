/*-------------------------  manual js --------------------------------------- */
$(document).ready(function () {  // поиск значения в выпад меню
$(".chosen-select-deselect").chosen({
   allow_single_deselect: true,
   width: '100%'

});

$(".chosen-select-deselect-single").chosen({
   allow_single_deselect: true
   //width: '100%'

});

});


    $('#auto_local').on('change', function(e) {

        var id_region=$('#id_region').val();
        var id_local=$('#auto_local').val();
$('#id_pasp').empty().trigger('chosen:updated');


        if(id_region !== null && id_local !== null && id_local !== ''){
            //get locals by region
            $.ajax({
                dataType: "json",
                url: '/journal/select',
                method: 'POST',
                data: {
                    id_region: id_region,
                    id_local: id_local,
                    action: 'showPaspByLocalForRep1'
                },
             success: function (data) {

                  $(data).each(function(index, value) {

                      $("#id_pasp").append($("<option></option>").attr("value", value.pasp_id).text(value.pasp_name+' ('+value.locorg_name+')')).trigger('chosen:updated');



                    });

            },
            error:function(){
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

    });











