<!-- Content Header (Page header) -->
<section class="content-header">

    <!--            bread crumb-->

    <ol class="breadcrumb">
        <li><a href="<?= $baseUrl ?>"><i class="fa fa-lg fa-home"></i> Журнал ЦОУ</a></li>
        <?php
        if (isset($bread_crumb) && !empty($bread_crumb)) {
            $active = array_pop($bread_crumb);
            if (!empty($bread_crumb)) {
                foreach ($bread_crumb as $key => $value) {
                    ?>
                    <li><?= $value ?> </li>
                    <?php
                }
            }
            ?>
            <li class="active" ><?= $active ?> </li>
                <?php
            }
            ?>
    </ol>
</section>