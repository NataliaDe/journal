<style>
/*.material-switch > label::before {
    background: azure;

}
.material-switch > label::after {
    background: #28a745;
    left: 20px;
}

.material-switch > input[type="checkbox"]:checked + label::before {
    background: #fbfbfb;

}

.material-switch > input[type="checkbox"]:checked + label::after {
    background: #dee2e6;
    left: 20px;
}*/

.material-switch > label::after {
    background: #d6d2d2;
}
.material-switch > label::before {
    background: rgb(255 255 255);
}

.material-switch > input[type="checkbox"]:checked + label::before {
    background: #f4f4f4;
}
.material-switch > input[type="checkbox"]:checked + label::after {
    background: #50bf69;

}



    </style>
<div class="menu scrollable-form-filter" style="height: 100%">

    <!-- Иконка меню -->
    <div class="icon-close">
<!--        <img src="<?= $baseUrl ?>/assets/jquery-side-menu/images/close-btn.png">-->
        <img id="close-btn" src="<?= $baseUrl ?>/assets/jquery-side-menu/images/arrow_left.png" style="width: 45px;" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Скрыть фильтр" >
        <img id="reset_filter" src="<?= $baseUrl ?>/assets/maps_for_mes/images/trash.png" style="width: 45px;     margin-left: 10px;" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Очистить фильтр" >



    </div>


    <?php
    include dirname(dirname(dirname(__FILE__))) . '/maps_for_mes/' . 'form_search_car.php';

    ?>

    <!-- Меню -->

</div>

<!-- Main body -->

<div class="background start-background" style="height: 5%">

    <!--      <div class="icon-menu">

            <img src="<?= $baseUrl ?>/assets/jquery-side-menu/images/question2.png">
            <center><span id="bread_crumb">ИНФОРМАЦИЯ ПО ЗАПРОСУ: АЦ - <u>г.Минск</u></span></center>
          </div>-->


    <ul class="nav navbar-nav icon-menu" style="height: 50px;
        padding-top: 2px;
        padding-bottom: 2px;">
        <li>
            <div class="material-switch pull-left" style="padding-top: 3px; padding-right: 20px;">
                <img src="<?= $baseUrl ?>/assets/jquery-side-menu/images/question2.png" style="width: 40px" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Показать фильтр" id="hide-sidebar-menu" >

            </div>

        </li>


        <li>
            <div class="material-switch pull-center" style="padding-top: 9px; padding-right: 20px;">
                <center><span id="bread_crumb">ИНФОРМАЦИЯ ПО ЗАПРОСУ: АЦ - <u>г.Минск</u></span></center>

            </div>

        </li>





        <li>
            <div class="material-switch pull-right" style=" padding-top: 3px; padding-right: 20px;" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Скрыть меню">
                <img src="<?= $baseUrl ?>/assets/maps_for_mes/images/logo1.png" style="width: 40px" id="hide-header-menu">

            </div>

        </li>
    </ul>

</div>


<div class="div-map" style="height: 95%">
    <?php
// echo dirname(__FILE__) ;
// echo $path_to_view;
    include dirname(dirname(dirname(__FILE__))) . '/' . $path_to_view;

    ?>
</div>

<!--<a id="show-menu"> <i class="fa fa-info-circle"></i> </a>-->
<div id="star-mes-panel" class="fixed t-left close_panel hide" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Отобразить меню">
    <img src="<?= $baseUrl ?>/assets/maps_for_mes/images/logo1.png"  id="star-mes">
</div>

<div id="theme_panel" class="fixed t-left open_panel">



    <a id="theme_panel_button"> <i class="fa fa-info-circle"></i> </a>
    <div class="theme_panel_inner">    </div>
    <div class="theme_panel_inner scrollable" id="theme_panel_inner_table" >

        <?php
        include dirname(dirname(dirname(__FILE__))) . '/maps_for_mes/right_table.php';

        ?>



    </div>



</div>












