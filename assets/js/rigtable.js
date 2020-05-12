$('.create-copy-link').on('click', function (event) {

var url = $(this).attr('data-url');
var id = $(this).attr('data-id');
$('#modal-create-copy #btn-create-copy').attr('href',url);

$('#modal-create-copy .modal-body p span').text('(ID = '+id+')');

});


//$('#modal-create-copy').on('show.bs.modal', function (event) {
//
//var url = $('#').attr('data-url');
//
//$('#btn-create-copy').attr('href',url);
//
//
//});



