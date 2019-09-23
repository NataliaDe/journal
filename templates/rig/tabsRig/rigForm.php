<?php
//echo $active_tab ;
//если открываем вкладку по высылке техники ($active_tab = 2) - остальные вкладки не отображаем
?>
<div class="box-body">

    <?php
    if(isset($is_update_now) && !empty($is_update_now) && (isset($settings_user['update_rig_now']) && $settings_user['update_rig_now']['name_sign'] == 'yes')){
           include dirname(__FILE__) . '/info_msg_now_update.php';
    }
    ?>
    <form  role="form" id="rigForm" method="POST" action="<?= $baseUrl ?>/rig/new/<?= $id ?>/<?= $active_tab ?>" >
 <input type="hidden" class="form-control datetime"  name="id" value="<?= $id ?>" />
        <ul class="nav nav-tabs">
            <?php
            if ($active_tab == 1) {
                ?>
                <li class="active">
                    <?php
                } elseif($active_tab != 2) {
                    ?>
                <li>
                    <?php
                }

				if($active_tab != 2) {
                ?>
                <a  href="#1" data-toggle="tab">Обработка вызова</a>
            </li>

            <?php
				}

            if ($active_tab == 2) {
                ?>
                <li class="active">
                    <?php
                } else {
                    ?>
                <li>
                    <?php
                }
                ?>
                <a href="#2" data-toggle="tab">Высылка техники</a>
            </li>

            <?php
            if ($active_tab == 3) {
                ?>
                <li class="active">
                    <?php
                } elseif($active_tab != 2) {
                    ?>
                <li>
                    <?php
                }

				if($active_tab != 2) {
                ?>
                <a href="#3" data-toggle="tab">Дополнительно</a>
            </li>
			<?php
				}
				?>
        </ul>
<!--------------------------------------------------- содержимое вкладок------------------------------------------>
        <div class="tab-content ">
            <br>
            <!--            Обработка вызова-->
            <?php
            if ($active_tab == 1) {
                ?>
                <div class="tab-pane active" id="1">
                    <?php
                } elseif($active_tab != 2) {
                    ?>
                    <div class="tab-pane " id="1">
                        <?php
                    }
					if($active_tab != 2)
                    include dirname(__FILE__) . '/processRigTab.php';
                    ?>
                </div>

                <!--Высылка техники-->
                <?php

                if ($active_tab == 2) {
                    ?>
                    <div class="tab-pane active" id="2">
                        <?php
                    } else {
                        ?>
                        <div class="tab-pane" id="2">
                            <?php
                        }
                        include dirname(__FILE__) . '/technicsRigTab.php';
                        ?>
                    </div>

                    <!--Дополнительно-->
                    <?php
                    if ($active_tab == 3) {
                        ?>
                        <div class="tab-pane active" id="3">
                            <?php
                        } elseif($active_tab != 2) {
                            ?>
                            <div class="tab-pane" id="3">
                                <?php
                            }
							if($active_tab != 2)
                            include dirname(__FILE__) . '/additionalRigTab.php';
                            ?>
                        </div>

                    </div>
<!--                    tab-content-->



                    </form>
                </div>


  <script>
  window.onload = function() {
   // alert( 'Документ и все ресурсы загружены' );

       var reason = $('#rigForm #id_reasonrig').val();
    var inspector = $('#rigForm [name="inspector"]').val();
    var firereason_descr = $('#rigForm [name="firereason_descr"]').val();
    var id_firereason = $('#rigForm [name="id_firereason"]').val();

    var id_officebelong = $('#rigForm [name="id_officebelong"]').val();
    var object_id = $('#rigForm #object_id').val();
    var coord_lat = $('#rigForm #coord_lat').val();
    var coord_lon = $('#rigForm #coord_lon').val();

    var work_view = $('#rigForm [name="id_work_view"]').val();


    if(work_view == 0){
        $('#rigForm #work-view-id .select2-selection').addClass('red-border-input');
    }

    if(reason == 34){

      if(inspector == '' || firereason_descr == '' || id_firereason == 0){


           $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');

           if(inspector == ''){

            $('#rigForm [name="inspector"]').addClass('red-border-input');
        }

                   if(firereason_descr == ''){

            $('#rigForm [name="firereason_descr"]').addClass('red-border-input');
        }
                           if(id_firereason == 0){
            $('#rigForm #firereason-id .select2-selection').addClass('red-border-input');
        }
      }



        if (object_id == '') {
            $('#rigForm #object_id').addClass('red-border-input');
        }

        //alert(reason);
        if (coord_lat == '') {
            $('#rigForm #coord_lat').addClass('red-border-input');
        }

        if (coord_lon == '') {
            $('#rigForm #coord_lon').addClass('red-border-input');
        }


        if (id_officebelong == '0') {
            $("#office-belong-id .select2-selection").addClass('red-border-input');
        }


    }

    //drugie, logny
    else if(reason == 14 || reason == 69){
   if(inspector == ''){

         $('#rigForm .nav-tabs  li:nth-child(3)').addClass('red-border-input');
            $('#rigForm [name="inspector"]').addClass('red-border-input');
        }
    }
    //molnia
    else if(reason == 74){

        if (object_id == '') {
            $('#rigForm #object_id').addClass('red-border-input');
        }
                if (id_officebelong == '0') {
            $("#office-belong-id .select2-selection").addClass('red-border-input');
        }
    }
    else if(reason == 0){
         $("#reason-rig-id .select2-selection").addClass('red-border-input');
    }


  <?php
  if (isset($is_sily_mchs) && $is_sily_mchs == 1) {

      ?>
         $('.sily_select').attr('disabled', true);
      <?php
  }

  ?>

  };



  function toggleSilyMchs(t) {
     
    if ($(t).prop('checked') === true) {
        $('.sily_select').attr('disabled', true);
    } else {
        $('.sily_select').removeAttr('disabled');
    }
}



</script>
