$('body').on('click', '#save-remark-rcu-file-multi', function (e) {


    var data = $('#remark-rcu-file-from').serialize();



    $.ajax({
        dataType: "json",
        type: "POST",
        url: "/journal/remark/rcu_upload_file",
        data: data,
        cache: false,
        success: function (responce) {

            if (parseInt(responce.is_ok) === 1) {
                toastr.success(responce.msg, 'Успех!', {timeOut: 2500});
                setTimeout(function () {
                    location.reload();
                }, 2500);
            } else
                toastr.error(responce.msg, 'Ошибка!', {timeOut: 2500});

        }

    });
});



$('body').on('click', '.btn-show-remark-rcu-file-modal', function (e) {

    var id = $(this).attr('data-id');



    $.post('/journal/remark/get_rcu_file_modal', {'id': id}, function (res) {

        $('#modal-media-multi').find("#ajax").html('');
        $('#modal-media-multi').find("#ajax").html(res);

    });



    $('#modal-media-multi').find('#id_remark').val(id);
});



