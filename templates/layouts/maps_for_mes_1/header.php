<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php
        //автоматическое обновление страницы general
        if (isset($delay)) {

            ?>
            <meta http-equiv="Refresh" content="<?= $delay ?>" />
            <?php
        }

        ?>

        <link rel="icon" href="<?= $baseUrl ?>/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?= $baseUrl ?>/favicon.ico" type="image/x-icon" />



        <title>
            <?php
            if (isset($title) && !empty($title)) {
                $name_title = $title;
            } else {
                $name_title = ' Журнал ЦОУ';
            }
            echo $name_title;

            ?>

        </title>


        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/maps_for_mes/bootstrap.min.css">
        <!--font-awesome -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/font-awesome/css/font-awesome.min.css">


        <!-- select2 css - поиск в выпад списке -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/js/select2/select2_1.css">



        <link href="<?= $baseUrl ?>/assets/toastr/css/toastr.min.css" rel="stylesheet"/>


        <!-- Chosen CSS -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/chosen_v1.8.2/chosen.css">



        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/leaflet/leaflet.css" />
        <link href="<?= $baseUrl ?>/assets/maps_for_mes/manual_leaflet.css" rel="stylesheet">



        <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>/assets/maps_for_mes/css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>/assets/maps_for_mes/css/demo.css" />
        <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>/assets/maps_for_mes/css/component.css" />
        <script src="<?= $baseUrl ?>/assets/maps_for_mes/js/modernizr.custom.js"></script>


        <style>



        </style>
    </head>
    <body>








