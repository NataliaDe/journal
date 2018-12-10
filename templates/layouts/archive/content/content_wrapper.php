<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!--        content - content-header-->
    <?php
    include dirname(__FILE__) . '/content_header.php';
    ?> 

    <!-- Main content -->
    <section class="content">
        <?php
        // echo dirname(__FILE__) ;
        // echo $path_to_view;
        include dirname(__FILE__) . '/../../../' . $path_to_view;
        ?>

    </section><!-- /.content -->


</div><!-- /.content-wrapper -->