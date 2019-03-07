<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!--        <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?= $baseUrl ?>/assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>Alexander Pierce</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>-->
        <!-- search form -->
        <form  class="sidebar-form" method="POST" action="<?= $baseUrl ?>/search/rig">
            <div class="input-group">

                <input type="text" name="id_rig" class="form-control" placeholder="Поиск по ID выезда...">
                <span class="input-group-btn">

                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">Главное меню</li>

            <li>
                <a href="<?= $baseUrl ?>/rig/new" target="_blank">
                    <i class="fa fa-plus-square"></i><span>Создать выезд</span>
                </a>
            </li>



            <li >
                <a href="<?= $baseUrl ?>/news" target="_blank">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <span>Новости</span>

                </a>
            </li>

            <li>
                <a href="<?= $baseUrl ?>/rig" >
                    <i class="fa fa-table"></i><span>Выезды<small class="label pull-right bg-green" id="count-rigs"></small></span>
                    <small class="label pull-right bg-green" id="count-rigs"></small>
                </a>
            </li>




            <?php
            if (isset($_SESSION['id_organ']) && $_SESSION['id_organ'] == RCU && $_SESSION['is_admin'] == 1) {//RCU
                ?>
                <li>
                    <a href="<?= $baseUrl ?>/user" target="_blank">
                        <i class="fa fa-users"></i><span>Пользователи</span> <small class="label pull-right bg-red" ></small>
                    </a>
                </li>
                <?php
            }
            ?>

            <?php
            if (isset($classif_active) && !empty($classif_active)) {
                $item_active = $classif_active;
                ?>
                <li class="treeview active">
                    <?php
                } else {
                    ?>
                <li class="treeview">
                    <?php
                }
                ?>

                <a href="#">
                    <i class="fa fa-list-ul"></i>
                    <span>Классификаторы</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php
                    if (isset($_SESSION['id_organ']) && $_SESSION['id_organ'] == RCU && $_SESSION['is_admin'] == 1) {//RCU
                        if (isset($item_active) && $item_active == 'reasonrig') {
                            ?>
                            <li class="active">
                            <?php
                        } else {
                            ?>
                            <li>
                                <?php
                            }
                            ?>
                            <a href="<?= $baseUrl ?>/classif/reasonrig"><i class="fa fa-chevron-circle-down"></i> Причина вызова</a>
                        </li>

    <?php
    if (isset($item_active) && $item_active == 'firereason') {
        ?>
                            <li class="active">
                            <?php
                        } else {
                            ?>
                            <li>
                                <?php
                            }
                            ?>
                            <a href="<?= $baseUrl ?>/classif/firereason"><i class="fa fa-chevron-circle-down"></i> Причина пожара</a>
                        </li>

    <?php
    if (isset($item_active) && $item_active == 'service') {
        ?>
                            <li class="active">
                            <?php
                        } else {
                            ?>
                            <li>
                                <?php
                            }
                            ?>
                            <a href="<?= $baseUrl ?>/classif/service"><i class="fa fa-chevron-circle-down"></i> Службы</a>
                        </li>


    <?php
    if (isset($item_active) && $item_active == 'officebelong') {
        ?>
                            <li class="active">
                            <?php
                        } else {
                            ?>
                            <li>
                                <?php
                            }
                            ?>
                            <a href="<?= $baseUrl ?>/classif/officebelong"><i class="fa fa-chevron-circle-down"></i> Ведомство</a>
                        </li>


    <?php
    if (isset($item_active) && $item_active == 'statusrig') {
        ?>
                            <li class="active">
                            <?php
                        } else {
                            ?>
                            <li>
                                <?php
                            }
                            ?>
                            <a href="<?= $baseUrl ?>/classif/statusrig"><i class="fa fa-chevron-circle-down"></i> Статус выезда</a>
                        </li>

    <?php
    if (isset($item_active) && $item_active == 'workview') {
        ?>
                            <li class="active">
                            <?php
                        } else {
                            ?>
                            <li>
                                <?php
                            }
                            ?>
                            <a href="<?= $baseUrl ?>/classif/workview"><i class="fa fa-chevron-circle-down"></i> Вид работ</a>
                        </li>
                            <?php


                                if (isset($item_active) && $item_active == 'listmail') {
        ?>
                            <li class="active">
                            <?php
                        } else {
                            ?>
                            <li>
                                <?php
                            }
                            ?>
                            <a href="<?= $baseUrl ?>/classif/listmail"><i class="fa fa-chevron-circle-down"></i> Список email</a>
                        </li>
                        <?php

                        }


                        if (isset($item_active) && $item_active == 'destination') {
                            ?>
                        <li class="active">
                        <?php
                    } else {
                        ?>
                        <li>
                            <?php
                        }
                        ?>
                        <a href="<?= $baseUrl ?>/classif/destination"><i class="fa fa-chevron-circle-down"></i> Список лиц</a>
                    </li>

                        <?php
    if (isset($item_active) && $item_active == 'actionwaybill') {
        ?>
                            <li class="active">
                            <?php
                        } else {
                            ?>
                            <li>
                                <?php
                            }
                            ?>
                            <a href="<?= $baseUrl ?>/classif/actionwaybill"><i class="fa fa-chevron-circle-down"></i>Меры без.(путевка)</a>
                        </li>

                </ul>
            </li>








            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-o" aria-hidden="true"></i>
                    <span>Отчеты</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= $baseUrl ?>/report/rep1" target="_blank"><i class="fa fa-chevron-circle-down"></i> Журнал</a></li>
<!--                    <li><a href="< $baseUrl ?>/diagram/diag1"><i class="fa fa-chevron-circle-down"></i> Диаграмма</a></li>-->
                    <li><a href=""><i class="fa fa-chevron-circle-down"></i> Отчет3</a></li>
                    <li><a href=""><i class="fa fa-chevron-circle-down"></i> Отчет4</a></li>
                </ul>
            </li>


<?php
if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == 2) {
    ?>
                <li>
                    <a href="<?= $baseUrl ?>/logs" target="_blank">
                        <i class="fa fa-book" aria-hidden="true"></i>
                        <span>Логи</span>

                    </a>
                </li>

                   <li>
                    <a href="<?= $baseUrl ?>/save_to_json" target="_blank">
                        <i class="fa fa-reply-all" aria-hidden="true"></i>
                        <span>Сохранить в json</span>

                    </a>
                </li>
    <?php
}

if (isset($_SESSION['id_user'])) {
    if (!($_SESSION['id_level'] == 1 && $_SESSION['is_admin'] == 1)) {//кроме РЦУ админ
        ?>



                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                            <span>Настройки</span>

                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= $baseUrl ?>/settings/reason_rig_color" target="_blank"><i class="fa fa-chevron-circle-down"></i>Причина вызова</a></li>
                        </ul>
                    </li>


        <?php
    }
}
?>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>