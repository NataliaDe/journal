<header class="main-header">
    <!-- Logo -->

       <?php
    if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1 && isset($id_page) && $id_page != 0) {
        $path = $baseUrl . '/rig/table/for_rcu/' . $id_page . '/0';
    } else {
        $path = $baseUrl . '/rig/table';
    }

    if (isset($_SESSION['id_level']) && $_SESSION['id_level'] == 1) {//rcu

        ?>
        <a href="<?= $path ?>" class="logo">

        <?php
    } else {

        ?>
            <a href="<?= $path ?>/rig" class="logo">

            <?php
        }

        ?>

        <img src="<?= $baseUrl ?>/assets/images/logo.png" width="50" height="50" style="float: left;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
<!--          <span class="logo-mini">Журнал</span>-->
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Журнал </b>ЦОУ <span style="font-size: 14px"><?= VER ?></span></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"  data-placement="left" title="Свернуть/развернуть меню" onclick="none_title_for_ivanov();">


        </a>


        <a href="#" class="logo" style="width: 200px" id="title_for_ivanov">
        <span class="logo-lg" style="display: block "><b>Журнал </b>ЦОУ <span style="font-size: 14px"><?= VER ?></span></span>
    </a>


        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">




<?php
/* br mode  */
if(isset($settings_user_br_table) && !empty($settings_user_br_table)){
    if(isset($_SESSION['br_table_mode']) && $_SESSION['br_table_mode'] == 1){
?>
                <li>
                    <div class="material-switch pull-right" style="padding-top: 15px; padding-right: 20px;">
                        <span style="padding-right: 5px; color: wheat">Краткий вид</span>
                        <input id="someSwitchOptionWarning" name="someSwitchOption001" type="checkbox" checked onchange="changeMode(this)" data-link="<?= $baseUrl ?>/change_mode">
                        <label for="someSwitchOptionWarning" class="label-warning"></label>
                    </div>

                </li>
<?php
}
else{
    ?>
                                <li>
                    <div class="material-switch pull-right" style="padding-top: 15px; padding-right: 20px;">
                        <span style="padding-right: 5px; color: wheat">Общий вид</span>
                        <input id="someSwitchOptionWarning" name="someSwitchOption001" type="checkbox" onchange="changeMode(this)" data-link="<?= $baseUrl ?>/change_mode">
                        <label for="someSwitchOptionWarning" class="label-warning"></label>
                    </div>

                </li>
                <?php
}
}

?>


<?php
if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user']) && in_array($_SESSION['id_user'], array(2,150,433))) {
?>
               <li>
                        <a href="<?= $baseUrl ?>/nii_reports" class="logo"  style="background-color:#3c8dbc" data-placement="left" title="Отчеты для НИИПБиЧС" target='_blank'>

                            <img src="<?= $baseUrl ?>/assets/images/osa.png" width="50" height="50" style="padding-bottom: 5px;">

                        </a>
                    </li>
                <?php
}


               // if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) {

                    ?>

                   <li>
 <a href="http://172.26.200.15/peopleSearch" class="logo"  style="background-color:#3c8dbc" data-placement="left" title="Поиск людей" target='_blank'>

                                <img src="<?= $baseUrl ?>/assets/images/search_people/Sharepoint.png" width="50" height="50" style="padding-bottom: 5px;">

                            </a>
                    </li>


                    <?php
               // }

                ?>



                <?php
                if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) {

                    ?>
                    <li>
                        <a href="/speciald" class="logo"  style="background-color:#3c8dbc" data-placement="left" title="Перейти в ПС «Специальные донесения»" target='_blank'>
                            <img src="<?= $baseUrl ?>/assets/images/writing-pad.png" width="50" height="50" style="padding-bottom: 5px;">
                        </a>
                    </li>

                    <?php
                }
                    ?>



<?php
                if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) {

                    ?>

                    <li>
                        <?php
                        if (isset($_SESSION['id_region']) && $_SESSION['id_region'] == 6) {//minobl

                            ?>
                            <a href="<?= $baseUrl ?>/maps_for_min_obl" class="logo"  style="background-color:#3c8dbc" data-placement="left" title="Карта" >
                                <?php
                            } else {

                                ?>
                                <a href="<?= $baseUrl ?>/maps" class="logo"  style="background-color:#3c8dbc" data-placement="left" title="Карта" >
                                    <?php
                                }

                                ?>

                                <img src="<?= $baseUrl ?>/assets/images/leaflet/GoogleMaps.png" width="50" height="50" style="padding-bottom: 5px;">

                            </a>
                    </li>


                    <?php
                }

                ?>

			                <li>
                    <a href="<?= $baseUrl ?>/remark" class="logo" style="background-color: #3c8dbc;">
                        <img src="<?= $baseUrl ?>/assets/images/feedback.png" width="50" height="50" >

                    </a>
                </li>


                     <!-- справка-->
<!--                <li class="dropdown tasks-menu">
                    <a href="< $baseUrl ?>/archive/" class="item-menu" target="_blank"><span>Архив</span></a>
                </li>-->





                <!-- news-->
                <li class="dropdown tasks-menu">
                    <?php
                    include __DIR__.'/news_head.php';
                    ?>

                </li>


                <!-- справка-->
                <li class="dropdown tasks-menu">
                    <a href="#" class="item-menu"><span  data-toggle="modal" data-target="#myModal" >Справка</span></a>
                </li>

                <?php
                if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) {
                    ?>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
<i class="fa fa-user"></i>
                            <span class="hidden-xs"><?= $_SESSION['user_name'] ?></span>
                        </a>
                        <ul class="dropdown-menu">

                            <li class="user-header">

                                <p>
                                    <?= $_SESSION['locorg_name'] ?><br>
                                    <br>

                                    <small class="title-user">
                                        Право создавать/ред.выезды: <?= $_SESSION['can_edit_name'] ?><br>
                                        Авт. заполнение адреса выезда: <?= $_SESSION['auto_ate_name'] ?><br>
                                        Права администратора: <?= $_SESSION['is_admin_name'] ?>
                                    </small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!--                  <li class="user-body">
                                                <div class="col-xs-4 text-center">
                                                  <a href="#">Followers</a>
                                                </div>
                                                <div class="col-xs-4 text-center">
                                                  <a href="#">Sales</a>
                                                </div>
                                                <div class="col-xs-4 text-center">
                                                  <a href="#">Friends</a>
                                                </div>
                                              </li>-->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div >
                                    <center><a href="<?= $baseUrl ?>/logout" class="btn btn-default btn-flat">Выйти</a></center>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <?php
                }
                ?>



                <!--              quare-code-->
<!--                <img src="$baseUrl ?>/assets/images/qr_rcu.png" width="55" height="50" style="float: right;">-->
                <!--      END        quare-code-->
                <!-- Control Sidebar Toggle Button -->

<!--                <li>
                    <a href="#" data-toggle="control-sidebar">  <i class="fa fa-angle-double-left" data-toggle="tooltip" data-placement="left" title="Меню"></i></a>
                </li>-->
            </ul>
        </div>
    </nav>
</header>

<?php
include 'reference.php';
?>