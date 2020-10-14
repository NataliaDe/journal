



<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="icon" href="<?= $bu ?>/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?= $bu ?>/favicon.ico" type="image/x-icon" />


        <title><?=$title?></title>

        <style>
            .error-descr{
                position: absolute;
                bottom: 60%;
                left:40%;
                font-weight:600;
            }

            .btn-back{
                position: absolute;
                bottom: 55%;
                left:48%;
                cursor:pointer;
            }

            .body-error-page{
                background-image: url(<?= $bu ?>/assets/images/500_error.png);
            }
            .a-back{

            }
        </style>



    </head>

    <body class="body-error-page">


        <span class="error-descr"><center><?= $msg ?></center></span>

        <a  onclick="javascript:history.back();" class="a-back"><button class="btn-back">Назад</button></a>
    </body>
</html>
