<header class="main-header">
    <!-- Logo -->

    <a href="<?= $baseUrl ?>/rig" class="logo">
        <img src="<?= $baseUrl ?>/assets/images/logo.png" width="50" height="50" style="float: left;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
<!--          <span class="logo-mini">Журнал</span>-->
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Журнал </b>ЦОУ <span style="font-size: 14px">1.6</span></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"  data-placement="left" title="Свернуть/развернуть меню" onclick="none_title_for_ivanov();">


        </a>


        <a href="#" class="logo" style="width: 200px" id="title_for_ivanov">
        <span class="logo-lg" style="display: block "><b>Журнал </b>ЦОУ <span style="font-size: 14px">1.6</span></span>
    </a>


        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">


                     <!-- справка-->
<!--                <li class="dropdown tasks-menu">
                    <a href="< $baseUrl ?>/archive/" class="item-menu" target="_blank"><span>Архив</span></a>
                </li>-->





                <!-- news-->
                <li class="dropdown tasks-menu">
                    <a  href="<?= $baseUrl ?>/news" target="_blank" class="item-menu"><span>Новости <span style="color: cyan">16.11.2018</span></span></a>
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