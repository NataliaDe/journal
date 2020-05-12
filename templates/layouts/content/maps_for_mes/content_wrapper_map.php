<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!--        content - content-header-->
    <?php
    include dirname(__FILE__) . '/content_header_map.php';
    ?>

    <!-- Main content -->
    <section class="content" style="padding-top: 2px">
        <?php
        // echo dirname(__FILE__) ;
        // echo $path_to_view;
        include dirname(__FILE__) . '/../../' . $path_to_view;
        ?>

    </section><!-- /.content -->


</div><!-- /.content-wrapper -->