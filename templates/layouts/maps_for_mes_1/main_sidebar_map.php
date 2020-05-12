

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

    </section>
    <!-- /.sidebar -->
</aside>