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
  if(isset($title) && !empty($title))  {
      $name_title=$title;
  }
  else{
      $name_title=' Журнал ЦОУ';
  }
  echo $name_title;
?>

           </title>


        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/bootstrap/css/bootstrap.min.css">
        <!--font-awesome -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/font-awesome/css/font-awesome.min.css">

        <!-- Bootstrap validator -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/bootstrapValidator/css/bootstrapValidator.min.css">


         <!--datepicker -->
        <link href="<?= $baseUrl ?>/assets/css/datepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">

        <!--        adminLTE-->

        <!-- Theme style -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/dist/css/AdminLTE.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/dist/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/plugins/iCheck/flat/blue.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/plugins/morris/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/plugins/daterangepicker/daterangepicker-bs3.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

        <!--     end   adminLTE-->



        <!-- Chosen CSS -->
<!--        <link rel="stylesheet" href="<?= $baseUrl ?>/assets/chosen_v1.8.2/chosen.css">-->

        <!-- select2 css - поиск в выпад списке -->
                <link rel="stylesheet" href="<?= $baseUrl ?>/assets/js/select2/select2_1.css">



        <!-- manual -->
        <link href="<?= $baseUrl ?>/assets/css/manual.css" rel="stylesheet">
        <link href="<?= $baseUrl ?>/assets/css/signin.css" rel="stylesheet">

         <link href="<?= $baseUrl ?>/assets/css/archive/archive.css" rel="stylesheet">


        <!-- DataTable CSS -->
        <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>/assets/css/jquery.dataTables.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
  <link href="<?= $baseUrl ?>/assets/toastr/css/toastr.min.css" rel="stylesheet"/>

    </head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">


<!--    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">-->







