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

			
			            <div class="row">
                <div class="col-lg-8">
			 <div class="panel panel-default">
                        <div class="panel-heading">
                            Описание выезда
                        </div>
                        <div class="panel-body">
                            <p>Дата и время сообщения: <?= date('d.m.Y', strtotime($result['date_msg'])) ?> <?= date('H:i', strtotime($result['time_msg'])) ?></p>
                            <p>Дата и время локализации: <?= (!empty($result['time_loc']) && $result['time_loc'] != '0000-00-00 00:00:00') ? date('d.m.Y H:i:s', strtotime($result['time_loc'])) : '-' ?></p>
                            <p>Дата и время ликвидации: <?= ( !empty($result['time_likv']) && $result['time_likv'] != '0000-00-00 00:00:00') ? date('d.m.Y H:i:s', strtotime($result['time_likv'])) : '-' ?> </p>

							<br>
                            <h4>Адрес выезда</h4>
                            <address>
<!--                                <strong>г. Пинск</strong>-->
                                <strong>
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
					
					</div>
					
					
					<div class="col-lg-4">

<?php
if (!empty($result['coord'])) {
    $arr_coord = explode(', ', $result['coord']);

    ?>

                      
<!-- apikey is NESSESARY-->
<script src="http://api-maps.yandex.ru/2.1-dev/?apikey=f009fa81-ba29-4ad9-bdbd-4deb99c8b2b6&lang=ru-RU&load=package.full" type="text/javascript"></script>



<!--<div class="left">"._GEOGPS.":</div><div class="center">-->
<script type="text/javascript">
ymaps.ready(init);
function init() {
    var myPlacemark,
                        myMap = new ymaps.Map('YMapsIDgeopoint', {
                        center: [<?=$result['coord']?>],
                        zoom: 17
                      //  controls: ['zoomControl', 'searchControl', 'typeSelector', 'geolocationControl']
                        });
						
						
						    myMap.controls.remove('geolocationControl');
                            myMap.controls.remove('searchControl');
                            myMap.controls.remove('trafficControl');
                            myMap.controls.remove('typeSelector');
                            myMap.controls.remove('fullscreenControl');
                            myMap.controls.remove('rulerControl');

                            // Создаем геообъект с типом геометрии "Точка".
                                myGeoObject = new ymaps.GeoObject({
                                    // Описание геометрии.
                                    geometry: {
                                        type: "Point",
                                        coordinates: [<?=$result['coord']?>]
                                    },
                                    // Свойства.
                                    properties: {
                                        // Контент метки.
                        //                iconContent: 'Я тащусь',
                        //                hintContent: 'Ну давай уже тащи'
                                    }
                                });


var myPlacemark_1=new ymaps.Placemark([<?=$result['coord']?>], {
                                   // balloonContent: 'цвет <strong>носика Гены</strong>',
                                            // iconCaption: 'Очень длиннный, но невероятно интересный текст'
                                        }, {
                                            preset: 'islands#greenDotIconWithCaption'
                                        });

                         myMap.geoObjects
                                .add(myGeoObject)
                                .add(myPlacemark_1);


       var coords_1 =[<?=$result['coord']?>];
            myPlacemark_1.events.add('dragend', function () {
                getAddress_1(myPlacemark_1.geometry.getCoordinates());
            });
        getAddress_1(coords_1);




      // Слушаем клик на карте.
    myMap.events.add('click', function (e) {
        var coords = e.get('coords');

        // Если метка уже создана – просто передвигаем ее.
        if (myPlacemark) {
            myPlacemark.geometry.setCoordinates(coords);
        }
        // Если нет – создаем.
        else {
            myPlacemark = createPlacemark(coords);
            myMap.geoObjects.add(myPlacemark);
            // Слушаем событие окончания перетаскивания на метке.
            myPlacemark.events.add('dragend', function () {
                getAddress(myPlacemark.geometry.getCoordinates());
            });
        }
        getAddress(coords);
    });

    // Создание метки.
    function createPlacemark(coords) {
        return new ymaps.Placemark(coords, {
            iconCaption: 'поиск...'
        }, {
          preset: 'islands#violetDotIconWithCaption',
            //preset: 'islands#greenDotIconWithCaption',
            draggable: true
        });
    }



    // Определяем адрес по координатам (обратное геокодирование).
    function getAddress(coords) {
        myPlacemark.properties.set('iconCaption', 'поиск...');
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);

            myPlacemark.properties
                .set({
                    // Формируем строку с данными об объекте.
                    iconCaption: [
                        // Название населенного пункта или вышестоящее административно-территориальное образование.
                        firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                        // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                        firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                    ].filter(Boolean).join(', '),
                    // В качестве контента балуна задаем строку с адресом объекта.
                    balloonContent: firstGeoObject.getAddressLine()
                });
        });
    }

    function getAddress_1(coords) {
        myPlacemark_1.properties.set('iconCaption', 'поиск...');
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);

            myPlacemark_1.properties
                .set({
                    // Формируем строку с данными об объекте.
                    iconCaption: [
                        // Название населенного пункта или вышестоящее административно-территориальное образование.
                        firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                        // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                        firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                    ].filter(Boolean).join(', '),
                    // В качестве контента балуна задаем строку с адресом объекта.
                    balloonContent: firstGeoObject.getAddressLine()
                            });
                });
            }

    }
                        </script>
                        <div id="YMapsIDgeopoint" style="width:500px; height:420px;"></div>
    <?php
}

?>
                </div>
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
		
		
		
		
<?php

if(isset($results_battle) && !empty($results_battle) && (isset(array_count_values($results_battle)[0]) && array_count_values($results_battle)[0]<count($results_battle))){
    ?>
<div class="panel panel-default">
            <div class="panel-heading">
                Результаты боевой работы
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive table-bordered">
                    <table class="table">
                        <thead>
                            <tr>

                                <th>Погибло</th>
                                <th>в т.ч. детей</th>
                                <th>Спасено людей</th>
                                <th>Травмировано</th>
                                <th>Эвакуировано</th>
                                <th>Спасено голов скота</th>
                                <th>Спасено кормов</th>
                                <th>Спасено строений</th>
                                <th>Спасено техники</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $results_battle['dead_man'] ?></td>
                                <td><?= $results_battle['dead_child'] ?></td>
                                <td><?= $results_battle['save_man'] ?></td>
                                <td><?= $results_battle['inj_man'] ?></td>
                                <td><?= $results_battle['ev_man'] ?></td>
                                <td><?= $results_battle['save_an'] ?></td>
                                <td><?= $results_battle['save_plan'] ?></td>
                                <td><?= $results_battle['save_build'] ?></td>
                                <td><?= $results_battle['save_teh'] ?></td>

                            </tr>

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


        <?php

if(isset($trunk) && !empty($trunk)){
    ?>
<div class="panel panel-default">
            <div class="panel-heading">
                Подача стволов
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive table-bordered">
                    <table class="table">
                        <thead>
                            <tr>

                                <th>Техника</th>
                                    <th>Ном.знак</th>
                                    <th>Подразд.</th>
                                    <th>Вр.подачи<br>ствола</th>
                                    <th>Тип</th>
                                    <th>Кол-во</th>
                                    <th>Израсх.воды/ПО<br>(тонн)</th>

                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                foreach ($trunk as $key => $value) {
                                    $k = 0;

                                    ?>

                                    <?php
                                    foreach ($trunk[$key] as $t) {
                                        $k++;

                                        ?>
                                        <tr >
                                            <?php
                                            if ($k == 1) {

                                                ?>
                                                <td rowspan="<?= count($trunk[$key]) ?>"><?= $key ?></td>
                                                <td rowspan="<?= count($trunk[$key]) ?>"><?= $t['numbsign'] ?></td>
                                                <td rowspan="<?= count($trunk[$key]) ?>"><?= $t['podr'] ?></td>
                                                <?php
                                            }

                                            ?>
                                            <td><?= $t['time_pod'] ?></td>
                                            <td><?= $t['type'] ?></td>
                                            <td><?= $t['cnt'] ?></td>
                                            <td><?= $t['water'] ?></td>

                                        </tr>

                                        <?php
                                    }
                                    ?>

    <?php }
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

