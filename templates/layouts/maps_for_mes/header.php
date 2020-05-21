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

        <link rel="icon" href="<?= $baseUrl ?>/assets/maps_for_mes/images/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?= $baseUrl ?>/assets/maps_for_mes/images/favicon.ico" type="image/x-icon" />



        <title>
            <?php
            if (isset($title) && !empty($title)) {
                $name_title = $title;
            } else {
                $name_title = 'Силы и средства МЧС';
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
        <link href="<?= $baseUrl ?>/assets/maps_for_mes/manual_leaflet.css?<?php echo time();?>" rel="stylesheet">



        <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>/assets/jquery-side-menu/style.css" />



            <!-- Font Awesome  4  for Extra Markers -->
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" /> -->
    <!-- Font Awesome 5 -->
<!--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">-->
    <!-- Font Awesome 5 SVG -->
    <!-- <script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js" integrity="sha384-EIHISlAOj4zgYieurP0SdoiBYfGJKkgWedPHH4jCzpCXLmzVsw1ouK59MuUtP4a1" crossorigin="anonymous"></script> -->

    <!-- Semantic UI -->
<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.3.1/dist/semantic.min.css">-->


        <!-- Extra Markers -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/leaflet_extra_markers/dist/css/leaflet.extra-markers.min.css" />


        <style>



        </style>
    </head>
    <body>








