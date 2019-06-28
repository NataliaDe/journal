<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

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
                <a href="<?= $baseUrl ?>/remark/remark_form" target="_blank">
                    <i class="fa fa-plus-square"></i><span>Создать замечание</span>
                </a>
            </li>
            <li>
                <a href="<?= $baseUrl ?>/remark" target="_blank">
                    <i class="fa fa-book"></i><span>Все замечания</span>
                </a>
            </li>




        </ul>
    </section>
    <!-- /.sidebar -->
</aside>