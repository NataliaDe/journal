<div class="container" style="margin-left: 0px; margin-right: 0px">
    <ul id="gn-menu" class="gn-menu-main">
        <li class="gn-trigger">
        <a class="gn-icon gn-icon-menu" id="gn-icon-button"><span>Menu</span></a>
        </li>
        <!--        <li class="gn-trigger">
                    <a class="gn-icon gn-icon-menu"><span>Menu</span></a>
                    <nav class="gn-menu-wrapper fixed t-left open_panel">
                        <div class="gn-scroller">


        <?php
        // include dirname(dirname(dirname(__FILE__))) . '/maps_for_mes/' . 'form_search_car.php';

        ?>

                        </div> /gn-scroller
                    </nav>
                </li>-->
        <li><a href="http://tympanus.net/codrops">Codrops</a></li>
        <li><a class="codrops-icon codrops-icon-prev" href="http://tympanus.net/Development/HeaderEffects/"><span>Previous Demo</span></a></li>
        <li><a class="codrops-icon codrops-icon-drop" href="http://tympanus.net/codrops/?p=16030"><span>Back to the Codrops Article</span></a></li>
    </ul>

</div>

<!-- /container -->






<style>


</style>



<div id="theme_panel" class="fixed t-left open_panel">
<!--    <a id="theme_panel_button"> <i class="fa fa-gear">123</i> </a>-->
<!--    <div class="theme_panel_inner">    </div>-->
    <div class="theme_panel_inner">


        <?php
        include dirname(dirname(dirname(__FILE__))) . '/maps_for_mes/' . 'form_search_car.php';

        ?>


    </div>



</div>




<?php
// echo dirname(__FILE__) ;
// echo $path_to_view;
include dirname(dirname(dirname(__FILE__))) . '/' . $path_to_view;

?>

