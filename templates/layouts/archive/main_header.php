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
        <a href="<?= $path ?>" class="logo" style="background-color: #e08a02">

        <?php
    } else {

        ?>
            <a href="<?= $path ?>/rig" class="logo" style="background-color: #e08a02">

            <?php
        }

        ?>

   
        <img src="<?= $baseUrl ?>/assets/images/logo.png" width="50" height="50" style="float: left;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
<!--          <span class="logo-mini">Журнал</span>-->
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Архив</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
 
    <nav class="navbar navbar-static-top" role="navigation" style="background-color: #f39c12">
        <!-- Sidebar toggle button-->

        <a href="#" style="background-color: #f39c12" class="sidebar-toggle" data-toggle="offcanvas" role="button"  data-placement="left" title="Свернуть/развернуть меню" onclick="none_title_for_ivanov();">
           
            
        </a>
        
    
        <a href="#" class="logo" style="width: 270px; background-color: #e08a02" id="title_for_ivanov"  >
        <span class="logo-lg" style="display: block "><b>Журнал </b>ЦОУ <span style="font-size: 14px"> Архив</span></span>
    </a>

      
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                
                     <!-- справка-->
                <li class="dropdown tasks-menu">
                    <a href="<?= $baseUrl ?>/" class="item-menu" target="_blank"><span>Журнал ЦОУ</span></a>
                </li>
                
                
                <!-- справка-->
                <li class="dropdown tasks-menu">
                    <a href="#" class="item-menu"><span  data-toggle="modal" data-target="#myModal" >Справка</span></a>
                </li>




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