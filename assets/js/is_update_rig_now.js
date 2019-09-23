setInterval(function () {
    function is_update() {

var arr=[];
        $( ".id_rig_input" ).each(function() {
  arr.push($( this ).val());
});
//console.log(arr);
if(arr.length>0){
           $.ajax({
            type: "POST",
            url: "/journal/is_update_rig_now",
            data: {id_rigs: arr},
            cache: false,
            success: function (responce) {
               // console.log(responce);

                for(var i = 0; i<arr.length;i++){
                   // $("#is_update_rig_now_"+arr[i]).html(responce);
                   $("#is_update_rig_now_"+arr[i]).html(JSON.parse(responce)[arr[i]]);
                }


                //$("#is_update_rig_now_186583").html(responce);
            }
        });
}

    }
    is_update();
}, 600000);//каждые 5 минут 1msec=1000sec

