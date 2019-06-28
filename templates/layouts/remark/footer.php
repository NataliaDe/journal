<!-- jQuery 2.1.4 -->
<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= $baseUrl ?>/assets/admin_lte_js/jquery-ui.min.js"></script>

<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<!--bootstrap js -->
<script src="<?= $baseUrl ?>/assets/bootstrap/js/bootstrap.min.js"></script>

<!-- bootstrap validator-->
<script type="text/javascript" src="<?= $baseUrl ?>/assets/bootstrapValidator/js/bootstrapValidator.min.js"></script>

<!--datepicker -->
<script src="<?= $baseUrl ?>/assets/js/datepicker/moment/moment.js"></script>
<script type="text/javascript" src="<?= $baseUrl ?>/assets/js/datepicker/moment-with-locales.min.js"></script>
<script src="<?= $baseUrl ?>/assets/js/datepicker/bootstrap-datetimepicker.min.js"></script>

<!--<script type="text/javascript" src="< $baseUrl ?>/assets/js/jquery.maskedinput.min.js"></script>-->

<!-- Morris.js charts -->
<script src="<?= $baseUrl ?>/assets/admin_lte_js/raphael-min.js"></script>
<!-- Sparkline -->
<script src="<?= $baseUrl ?>/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= $baseUrl ?>/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= $baseUrl ?>/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= $baseUrl ?>/assets/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<!--<script src="<?= $baseUrl ?>/assets/admin_lte_js/moment.min.js"></script>
<script src="<?= $baseUrl ?>/assets/plugins/daterangepicker/daterangepicker.js"></script>-->
<!-- datepicker -->
<!--<script src="<?= $baseUrl ?>/assets/plugins/datepicker/bootstrap-datepicker.js"></script>-->
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= $baseUrl ?>/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?= $baseUrl ?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= $baseUrl ?>/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= $baseUrl ?>/assets/dist/js/app.min.js"></script>


<!-- Chosen jquery js -->
<!--<script src="<?= $baseUrl ?>/assets/chosen_v1.8.2/chosen.jquery.js" type="text/javascript"></script>
<script src="<?= $baseUrl ?>/assets/chosen_v1.8.2/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= $baseUrl ?>/assets/chosen_v1.8.2/docsupport/init.js" type="text/javascript" charset="utf-8"></script> -->

<!-- select2 jquery js - поиск в выпад списке -->
<script src="<?= $baseUrl ?>/assets/js/select2/select2.min.js" type="text/javascript" charset="utf-8"></script>

<!--dataTables-->
<script type="text/javascript"  src="<?= $baseUrl ?>/assets/js/jquery.dataTables.js"></script>

<!--маска ввода-->
<script type="text/javascript" src="<?= $baseUrl ?>/assets/js/jquery.maskedinput.min.js"></script>

<!--chained plugin-->
<script type="text/javascript"  src="<?= $baseUrl ?>/assets/js/jquery.chained.min.js"></script>

<script src="<?= $baseUrl ?>/assets/ckeditor/ckeditor.js"></script>

<script src="<?= $baseUrl ?>/assets/toastr/js/toastr.min.js"></script>

<script type="text/javascript"  src="<?= $baseUrl ?>/assets/js/jquery-tabledit-1.2.3/jquery.tabledit.js"></script>

<script  type="text/javascript" src="<?= $baseUrl ?>/assets/js/manual_datetimepicker.js"></script>
<script  type="text/javascript" src="<?= $baseUrl ?>/assets/js/manual.js"></script>

<script type="text/javascript">
//	CKEDITOR.replace('myeditor1');
//        CKEDITOR.replace('myeditor2');
//        CKEDITOR.replace('myeditor3');

<?php
 $str_remark_type='';
 $str_status='';
if(isset($remark_type)){

    foreach ($remark_type as $value) {
        //$arr_remark_type['"'.$value['id'].'"']=$value['name'];
        if($str_remark_type != '')
        $str_remark_type=$str_remark_type.', '.'"'.$value['id'].'"'.': '.'"'.$value['name'].'"';
        else
            $str_remark_type=$str_remark_type.'"'.$value['id'].'"'.': '.'"'.$value['name'].'"';
    }
}
if(isset($remark_status)){

    foreach ($remark_status as $value) {
        //$arr_remark_type['"'.$value['id'].'"']=$value['name'];
        if($str_status != '')
        $str_status=$str_status.', '.'"'.$value['id'].'"'.': '.'"'.$value['name'].'"';
        else
            $str_status=$str_status.'"'.$value['id'].'"'.': '.'"'.$value['name'].'"';
    }
}
?>

$('#remarkTableRcu').Tabledit({

    url: '<?= $baseUrl ?>/remark/edit_table',
    columns: {
        identifier: [0, 'id'],
        editable: [[1, 'description'], [3, 'author'],[4, 'contact'],[5, 'note'],
//            [6, 'type_user', '{"1": "доработка", "2": "ошибка"}'],
            //[7, 'type_rcu_admin', '{"1": "доработка", "2": "ошибка"}'],
            //            [8, 'status_rcu_admin', '{"1": "ожидает исполнения", "2": "в работе", "3": "выполнено"}'],
            [6, 'type_user', '{<?= $str_remark_type ?>}'],
            [7, 'type_rcu_admin', '{<?= $str_remark_type ?>}'],
            [8, 'status_rcu_admin', '{<?= $str_status ?>}'],
            [9, 'note_rcu']]

    },


    onDraw: function() {
        console.log('onDraw()');
    },
    onSuccess: function(data, textStatus, jqXHR) {
        console.log('onSuccess(data, textStatus, jqXHR)');
//        console.log(data);
//        console.log(textStatus);
//        console.log(jqXHR);
    },
    onFail: function(jqXHR, textStatus, errorThrown) {
        console.log('onFail(jqXHR, textStatus, errorThrown)');
//        console.log(jqXHR);
//        console.log(textStatus);
//        console.log(errorThrown);
    },
    onAlways: function() {
        console.log('onAlways()');
    },
    onAjax: function(action, serialize) {
        console.log('onAjax(action, serialize)');
        //console.log(action);
        //console.log(serialize);

        if (action === 'edit') {

        var values_1 = serialize.split('&');
        //console.log(values_1);
        var id_1 = values_1[0];

        // description
        var notes_1 = values_1[1];
        var values_2 = notes_1.split('=');
        var description = values_2[1];
         //console.log(description);

        //author
        var notes_3 = values_1[2];
        var values_3 = notes_3.split('=');
        var author=values_3[1];
        //console.log(author);

        //contact
        var notes_4 = values_1[3];
        var values_4 = notes_4.split('=');
        var contact=values_4[1];
        //console.log(contact);

        //type user
        var notes_5 = values_1[5];
        var values_5 = notes_5.split('=');
        var type_user=values_5[1];
        //console.log(type_user);

        //type_user_rcu_admin
        var notes_6 = values_1[5];
        var values_6 = notes_6.split('=');
        var type_rcu_admin=values_6[1];
       // console.log(type_rcu_admin);

        //status rcu
        var notes_7 = values_1[5];
        var values_7 = notes_7.split('=');
        var status_rcu_admin=values_7[1];
        //console.log(status_rcu_admin);



        if (description === ""){
        toastr.error('Внесите описание замечания', 'Ошибка!', {timeOut: 5000});
            return false;
        }
        else if(author === ""){
                  toastr.error('Внесите информацию об авторе', 'Ошибка!', {timeOut: 5000});
            return false;
            }
                    else if(contact === ""){
                  toastr.error('Внесите контактную информацию', 'Ошибка!', {timeOut: 5000});
            return false;
            }
                                else if(type_user === ""){
                  toastr.error('Укажите тип замечания', 'Ошибка!', {timeOut: 5000});
            return false;
            }
                                else if(type_rcu_admin === ""){
                  toastr.error('Укажите тип замечания (от РЦУРЧС)', 'Ошибка!', {timeOut: 5000});
            return false;
            }
                                            else if(status_rcu_admin === ""){
                  toastr.error('Укажите статус задачи (от РЦУРЧС)', 'Ошибка!', {timeOut: 5000});
            return false;
            }

            else {
            return true;
        }
    }


    }
});

</script>

</body>
</html>