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
<!--        <form  class="sidebar-form" method="POST" action="<?= $baseUrl ?>/search/rig">
            <div class="input-group">

                <input type="text" name="id_rig" class="form-control" placeholder="Поиск по ID выезда...">
                <span class="input-group-btn">

                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>-->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">Главное меню</li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-archive-o" aria-hidden="true"></i>
                    <span>Навигация</span>


                </a>
                <ul class="treeview-menu">


                    <li>
                        <a href="<?= $baseUrl ?>/archive_1" target="_blank">
                            <i class="fa fa-file"></i><span>Архив</span>
                        </a>
                    </li>
                                        <li>
                        <a href="<?= $baseUrl ?>/archive" target="_blank">
                            <i class="fa fa-file"></i><span>Архив (json)<br>для ОВПО</span>
                        </a>
                    </li>
					
                </ul>
            </li>


					<li class="treeview">
                <a href="<?= $baseUrl ?>/archive_1/search_form" target="_blank">
                    <i class="fa fa-search"></i>
                    <span>Поиск по ID выезда</span>


                </a>

            </li>



        </ul>
    </section>
    <!-- /.sidebar -->
</aside>