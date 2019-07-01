<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

            <link rel="icon" href="<?= $baseUrl ?>/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?= $baseUrl ?>/favicon.ico" type="image/x-icon" />

    <title>Детальная информация по вызову</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= $baseUrl ?>/templates/card_by_id_rig/id/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?= $baseUrl ?>/templates/card_by_id_rig/id/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= $baseUrl ?>/templates/card_by_id_rig/id/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= $baseUrl ?>/templates/card_by_id_rig/id/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">
        <?php
        if (isset($no_btn_back) && $no_btn_back == 1) {
            ?>

        <a onclick="window.close()" style="color: black">  <button type="button" style="position: absolute; margin-left: 50px; margin-top: 25px;"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;назад</button></a>
        <?php

        } else {

            ?>
            <a onclick="javascript:history.back();" style="color: black">  <button type="button" style="position: absolute; margin-left: 50px; margin-top: 25px;"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;назад</button></a>
            <?php
        }

        ?>

        <!-- Page Content -->
        <div id="page-wrapper" style="    margin-left: 150px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?= $result['id_rig'] ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

			 <div class="panel panel-default">
                        <div class="panel-heading">
                            Описание выезда
                        </div>
                        <div class="panel-body">
                            <p>Дата и время сообщения: <?= date('d.m.Y', strtotime($result['date_msg'])) ?> <?= $result['time_msg'] ?></p>
                            <p>Дата и время локализации: <?= (!empty($result['time_loc']) && $result['time_loc'] != '0000-00-00 00:00:00') ? date('d.m.Y H:i:s', strtotime($result['time_loc'])) : '-' ?></p>
                            <p>Дата и время ликвидации: <?= ( !empty($result['time_likv']) && $result['time_likv'] != '0000-00-00 00:00:00') ? date('d.m.Y H:i:s', strtotime($result['time_likv'])) : '-' ?> </p>

                            <h4>Адрес выезда</h4>
                            <address>
<!--                                <strong>г. Пинск</strong>-->
                                <br><strong>
                                    <?php
                                    echo $result['address'];
                                    if ($result['is_address'] == 0) {

                                        ?>
                                        <?= (!empty($result['inf_additional_field'][1])) ? ('(' . $result['inf_additional_field'][1] . ')') : '' ?>
                                        <?php
                                    } else {

                                        ?>
                                        <?= (!empty($result['inf_additional_field'])) ? ('(' . implode(', ', $result['inf_additional_field']) . ')') : '' ?>
                                        <?php
                                    }

                                    ?>



                                </strong>
                                <br><?= (!empty($result['inf_region'])) ? implode(', ', $result['inf_region']) : ''?>
                                <br> Объект: <?= (!empty($result['object'])) ? $result['object'] : '-' ?> <?= (!empty($result['office_name'])) ? (' ('.$result['office_name'].')') : '' ?>.
                                <br> Координаты: <?= (!empty($result['coord'])) ? $result['coord'] : '-' ?>&nbsp;

                                <?php
                                if (!empty($result['coord_link'])) {

                                    $a = implode(', ', $result['coord_link']);
                                                                    echo '('.$a.')';
                                }



                                ?>



<!--                                                                Координаты: 54.343444, 27.343444 (ссылка по возможности)-->

                            </address>

							<address>
                                 <?= (!empty($result['people'])) ? ('Данные заявителя: '.$result['people']) : '' ?>
								<br>
<!--                                Телефон: 209-27-51-->
								<br>
                                                                <strong><?= (!empty($result['reasonrig_name'])) ? ('Причина выезда: '.$result['reasonrig_name']) : '' ?><?= (!empty($result['view_work'])) ? (' ('.$result['view_work'].')') : '' ?> </strong>
								<br>
								<strong> <?= (!empty($result['firereason_name'])) ? ('Причина пожара: '.$result['firereason_name']) : '' ?> </strong>
								<br>
								 <?= (!empty($result['inspector'])) ? ('Инспектор: '.$result['inspector']) : '' ?>

                            </address>
                        </div>
                        <!-- /.panel-body -->
                    </div>

			 <div class="row">
                <div class="col-lg-4">
                    <div class="well">
                        <h4>Содержание поступившей информации</h4>
                        <p><?= $result['description']?></p>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="well">
                        <h4>Детализированная информация</h4>
                        <p><?= $result['inf_detail']?></p>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="well">
                        <h4>Причина пожара (пояснение)</h4>
                        <p>
                            <?= $result['firereason_description']?>
<!--                            В 12-00 произошло самопроизвольное возгарание электропроводки в гараже 32, допонлительно произошло возгарание газов.-->
                        </p>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
            </div>

              <?php
            if(isset($silymchs) &&!empty($silymchs)){
                ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Привлекаемые силы и средства МЧС
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Техника</th>
                                            <th>Подразделение</th>
                                            <th>Сообщение о ЧС</th>
                                            <th>Выезд</th>
                                            <th>Прибытие к месту ЧС</th>
                                            <th>Ликвидация до прибытия</th>
                                            <th>Время окончания работ</th>
                                            <th>Возвращение</th>
                                            <th>Расстояние</th>
                                            <th>Возврат техники</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i=0;
                                        foreach ($silymchs as $value) {

                                            $i++;
                                            ?>
                                        <tr>
                                                <td><?=$i ?></td>
                                                <td><?= $value['mark'] ?><?= (!empty($value['numbsign'])) ? (' ('.$value['numbsign'].')') : '' ?></td>
                                                <td><?= $value['podr'] ?></td>
                                                <td><?= $value['time_msg'] ?></td>
                                                <td><?= $value['t_exit'] ?></td>
                                                <td><?= $value['t_arrival'] ?></td>
                                                <td><?= $value['is_likv_before'] ?></td>
                                                <td><?= $value['t_end'] ?></td>
                                                <td><?= $value['t_return'] ?></td>
                                                <td><?= $value['t_distance'] ?></td>
                                                <td><?= $value['t_is_return'] ?></td>
                                            </tr>
                                        <?php
                                        }


                                        ?>


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>

            <?php
            }
            if(isset($innerservice) &&!empty($innerservice)){
                ?>
            <div class="panel panel-default">
                        <div class="panel-heading">
                            Привлекаемые силы и средства других ведомств
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Служба</th>
                                            <th>Время сообщения</th>
                                            <th>время прибытия</th>
                                            <th>Расстояние</th>
                                            <th>Примечание</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($innerservice as $value) {

                                            $i++;

                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $value['service_name'] ?></td>
                                                <td><?= $value['time_msg'] ?></td>
                                                <td><?= $value['t_arrival'] ?></td>
                                                <td><?= $value['t_distance'] ?></td>
                                                <td><?= $value['note'] ?></td>
                                            </tr>
                                            <?php
                                        }

                                        ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
            <?php
            }

              if(isset($informing) &&!empty($informing)){

            ?>



			 <div class="panel panel-default">
                        <div class="panel-heading">
                            Информирование должностных лиц
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Адресат</th>
                                            <th>Время сообщения о ЧС</th>
                                            <th>Время выезда</th>
                                            <th>Время прибытия</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($informing as $value) {

                                            $i++;

                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $value['fio'] ?></td>

                                                <td><?= $value['time_msg'] ?></td>
                                                <td><?= $value['t_exit'] ?></td>
                                                <td><?= $value['t_arrival'] ?></td>
                                            </tr>
                                            <?php
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>

            <?php
              }
            ?>

        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?= $baseUrl ?>/templates/card_by_id_rig/id/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= $baseUrl ?>/templates/card_by_id_rig/id/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?= $baseUrl ?>/templates/card_by_id_rig/id/js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?= $baseUrl ?>/templates/card_by_id_rig/id/js/sb-admin-2.js"></script>

</body>

</html>

