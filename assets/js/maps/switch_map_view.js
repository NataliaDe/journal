function changeMapView(el) {

    let val = el.checked;
    if (val===true) val = 1; else  val = 0;
    let link = $(el).data('link');

    $.ajax({
        type: 'POST',
        url: link,
        data: {
            'val': val,
        },
        dataType: 'json',
        success: function (data) {
            if (data) {
                toastr.success('Вид изменён', '', {timeOut: 2000});

                setTimeout(function () {
                    location.reload();
                }, 2300);
            }

        }
    })
}

