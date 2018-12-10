
<?php

if($ok==1){//отпралена успешно
       include dirname(__FILE__) . '/ok.php';
}
elseif($ok==2){//отпралена  с ошибкой
       include dirname(__FILE__) . '/error.php';
}



if (empty($pasp_name)) {
    ?>
    <br><br><br>
    <div class="container">
        <div class="alert alert-danger alert-danger-custom">
            <strong> Список адресатов пуст!</strong>

        </div>
    </div>

    <?php
} else {

    //print_r($id_pasp_on_rig_array);
    ?>
    <br>
    <strong> Путевки будут разосланы тем подразделениям, где установлена соответствующая отметка в столбце "Отправить"</strong>
    <br> <br>
    <div class="box-body">

        <form  role="form" id="characterForm" method="POST" action="<?= $baseUrl ?>/waybill/mail/<?= $id_rig ?>">

            <center>
                <table class="table table-condensed   table-bordered table-custom" style="width:50%" >

                    <thead>
                        <tr>
                            <th>Подразделение (кому)</th>
                            <th>Адрес эл.почты</th>
                            <th>Статус</th>
                            <th style="width:57px;">Отправить</th>
                        </tr>
                    </thead>

                    <tbody>



                        <?php
                        foreach ($pasp_name as $row) {

                            if (isset($mail_send_array[$row['id']])) {//этой ПАСЧ уже высылали путевку
                                ?>
                                <tr class="success">
                                    <?php
                                } else {
                                    if (isset($list_mail_array[$row['id']])) {//если есть адрес ящика в БД   этой ПАСЧ, куда отправить путевку
                                        ?>
                                    <tr class="warning">
                                        <?php
                                    } else {
                                        ?>
                                    <tr class="danger">
                                        <?php
                                    }
                                }
                                ?>



                                <td>   <strong><span ><?= $row['pasp_name'] ?><br><?= $row['locorg_name'] ?> </span></strong></td>

                                <td>

                                    <?php
                                    if (isset($list_mail_array[$row['id']])) {
                                        echo $list_mail_array[$row['id']]['mail'];
                                    } else {
                                        echo ' нет адреса';
                                    }
                                    ?>

                                </td>

                                <?php
                                if (isset($mail_send_array[$row['id']])) {//этой ПАСЧ уже высылали путевку


                                    /* ----- отправить повторно, если есть адрес ящика в БД ---- */
                                    ?>
                                    <td>отправлена &nbsp;<?= $mail_send_array[$row['id']]['date_send'] ?></td>

                                    <?php
                                    if (isset($list_mail_array[$row['id']])) {//есть email
                                        ?>
                                        <td>

                                            <?php
                                            ?>

                                            <div class="col-lg-2">
                                                <br>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-danger">
                                                        <input id="checkbox<?= $row['id'] ?>" type="checkbox" name="id_pasp[<?= $row['id'] ?>]" value="1" >   
                                                        <label for="checkbox<?= $row['id'] ?>">
                                                            отправить повторно

                                                        </label>

                                                    </div>



                                                </div>
                                            </div>
                                        </td> 
                                        <?php
                                    }
                                    /* ----- END отправить повторно, если есть адрес ящика в БД ---- */
                                    else{
                                        ?>
                                        <td></td>
                                        <?php
                                    }
                                } else {// путевка этой ПАСЧ ни разу не высылалась
                                    ?>
                                    <td>не отправлена</td>
                                    <?php
                                    if (isset($list_mail_array[$row['id']])) {//если есть адрес ящика в БД   этой ПАСЧ, куда отправить путевку
                                        ?>

                                        <td>
                                            <div class="col-lg-2">
                                                <br>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-success">
                                                        <input id="checkbox<?= $row['id'] ?>" type="checkbox" name="id_pasp[<?= $row['id'] ?>]" value="1" checked="" >   
                                                        <label for="checkbox<?= $row['id'] ?>">
                                                            отправить
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td> 


                                        <?php
                                    } else { //нет адреса почты для этого ПАСЧ в БД
                                        ?>

                                        <td>

                                        </td>

                                        <?php
                                    }
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>

                </table>
                <br> <br>
                <div class="form-group">
                    <button class="btn btn-success" type="submit" ><i class="fa fa-envelope-open-o" aria-hidden="true" style="color:white"></i> &nbsp;Отправить путевку</button>
                </div>

            </center>

        </form>
    </div>

    <?php
}
?>