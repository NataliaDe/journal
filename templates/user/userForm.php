<?php
//print_r($user);
?>

<br>      <br>
<div class="box-body">

    <form  role="form" id="userForm" method="POST" action="<?= $baseUrl ?>/user/new/<?= $id ?>">
        <b>Заполните поля формы:</b>
        <br><br><br>
        <div class="row">

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="id_region">Область</label>
                    <select class="form-control" name="id_region" id="id_region"  >

                        <?php
                        foreach ($region as $re) {
                            if (isset($user['id_region']) && $re['id'] == $user['id_region']) {
                                printf("<p><option value='%s' selected ><label>%s</label></option></p>", $re['id'], $re['name']);
                            } else {
                                printf("<p><option value='%s' ><label>%s</label></option></p>", $re['id'], $re['name']);
                            }

                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">

                    <label for="id_locorg">Г(Р)ОЧС</label>
                    <select class="form-control" name="id_locorg" id="id_locorg"  >
                        <option value="">Выбрать</option>
                        <?php
                        foreach ($locorg as $lo) {
                            if (isset($user['id_locorg']) && $lo['id_locorg'] == $user['id_locorg']) {
                                printf("<p><option value='%s' class='%s' selected ><label>%s</label></option></p>", $lo['id_locorg'], $lo['id_region'], $lo['locorg_name']);
                            } else {
                                printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $lo['id_locorg'], $lo['id_region'], $lo['locorg_name']);
                            }

                        }
                        ?>

                    </select>
                </div>
            </div>


            <div class="col-lg-2">
                <div class="form-group">
                    <label for="name">Ф.И.О. пользователя</label>
                    <?php
                    if (isset($user['name']) && !empty($user['name'])) {
                        ?>
                        <input type="text" class="form-control"  placeholder="Ф.И.О." name="name" value="<?= $user['name'] ?>" >
                        <?php
                    } else {
                        ?>
                        <input type="text" class="form-control"  placeholder="Ф.И.О." name="name" >
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="login">Логин</label>
                    <?php
                    if (isset($user['login']) && !empty($user['login'])) {
                        ?>
                        <input type="text" class="form-control" placeholder="Логин" name="login" value="<?= $user['login'] ?>" >
                        <?php
                    } else {
                        ?>
                        <input type="text" class="form-control" placeholder="Логин" name="login"  >
                        <?php
                    }
                    ?>
                </div>
            </div>

            <!--            при редактировании пользователя пароль не отображать-->
            <?php
            if (isset($user['id']) && !empty($user['id'])) {
                ?>

                <div class="col-lg-2"  >
                    <div class="form-group">
                        <label for="password">Пароль</label>
                    <?php
                    if (isset($user['password']) && !empty($user['password'])) {
                        ?>
                        <input type="text" class="form-control" placeholder="Пароль" name="password" value="<?= $user['password'] ?>" >
                        <?php
                    } else {
                        ?>
                      <input type="text" class="form-control" placeholder="Пароль" name="password"  >
                        <?php
                    }
                    ?>

                    </div>
                </div>
                <?php
            } else {
                ?>

                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="password">Пароль</label>

                        <input type="text" class="form-control" placeholder="Пароль" name="password"  >
                    </div>
                </div>
                <?php
            }
            ?>


        </div>

        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <div class="checkbox checkbox-success">
                        <?php
                        if (isset($user['can_edit']) && $user['can_edit'] == 1) {
                            ?>
                            <input id="checkbox1" type="checkbox" name="can_edit" value="1" checked="" >
                            <?php
                        } else {
                            ?>
                            <input id="checkbox1" type="checkbox" name="can_edit" value="1" >
                            <?php
                        }
                        ?>
                        <label for="checkbox1">
                            Может создавать/ред.выезды
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <div class="checkbox checkbox-success">
                        <?php
                        if (isset($user['is_admin']) && $user['is_admin'] == 1) {
                            ?>
                            <input id="checkbox2" type="checkbox" name="is_admin" value="1" checked="" >
                            <?php
                        } else {
                            ?>
                            <input id="checkbox2" type="checkbox" name="is_admin" value="1" >
                            <?php
                        }
                        ?>

                        <label for="checkbox2">
                            Администратор
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <div class="checkbox checkbox-danger">
                        <?php
                        if (isset($user['auto_ate']) && $user['auto_ate'] == 1) {
                            ?>
                            <input id="checkbox3" type="checkbox" name="auto_ate" value="1" checked="">
                            <?php
                        } else {
                            ?>
                            <input id="checkbox3" type="checkbox" name="auto_ate" value="1" >
                            <?php
                        }
                        ?>

                        <label for="checkbox3">
                            Заполнять адрес выезда по умолчанию
                        </label>
                    </div>
                </div>
            </div>

        </div>
<!---------------------- Адрес выезда, заполняемый по умолчанию --------------------------------------->
        <p class="line"><span>Адрес выезда, заполняемый по умолчанию</span></p>

            <div class="col-lg-2">
        <div class="form-group" name="local">
            <label for="id_local">Район/Город</label>
            <select class="js-example-basic-single form-control" name="auto_local" id="auto_local" data-placeholder="Выбрать"   >
    <option value="" ></option>
                <?php
                    foreach ($local as $loc) {
                        if (isset($user['auto_local'])&& $user['auto_local']==$loc['id']) {
                            printf("<p><option value='%s'class='%s' selected ><label>%s</label></option></p>", $loc['id'],$loc['id_region'], $loc['name']);
                        }
                       else {
                            printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $loc['id'],$loc['id_region'], $loc['name']);
                        }
                    }

                ?>
            </select>

        </div>
    </div>

        <div class="col-lg-3">
        <div class="form-group">
            <label for="id_locality">Населенный пункт</label>
            <select class="js-example-basic-single form-control" name="auto_locality" id="auto_locality"  data-placeholder="Выбрать"  >
                <option value=""></option>
                <?php
                        foreach ($locality as $row) {
                          if (isset($user['auto_locality'])&& $user['auto_locality']==$row['id']) {
                                printf("<p><option  value='%s' class='%s' selected ><label>%s (%s)</label></option></p>", $row['id'],$row['id_local'], $row['name'],$row['local_name']);
                            }
                            else{
                                 printf("<p><option  value='%s' class='%s' ><label>%s (%s)</label></option></p>", $row['id'],$row['id_local'], $row['name'],$row['local_name']);
                            }
                        }


                ?>
            </select>
        </div>
    </div>

        <!--        id органа поределяем автоматически по выбранному ГРОЧС-->
        <div class="row">
                    <div class="col-lg-2" style="visibility: hidden;" >
            <div class="form-group">

                <label for="id_organ">Орган</label>
                <select class="form-control" name="id_organ" id="id_organ"   >

                    <?php
                    foreach ($locorg as $lo) {
                        printf("<p><option value='%s' class='%s' ><label>%s</label></option></p>", $lo['id_organ'], $lo['id_locorg'], $lo['organ_name']);
                    }
                    ?>

                </select>
            </div>
        </div>
        </div>


        <p class="line"><span>Информация для специального донесения</span></p>


        <div class="row">
            <div class="form-group col-md-3">
                <label for="hs_vid" >Связать с пользователем СД</label>
                <select class="form-control select2-single" name="id_user_sd" id="id_user_sd"  >
                    <option></option>
                    <?php
                     foreach ($users_sd as $usd) {?>
                     <option value="<?=$usd['id_user']?>"
                             <?=(isset($user['id_user_sd']) && $usd['id_user'] == $user['id_user_sd']) ? "selected" : ''?>
                             ><?= $usd['auth_fio']?> <?=$usd['auth_organ_full']?></option>
                    <?php

                     }?>
                </select>
            </div>
        </div>


        <div class="row row-data-for-sd <?=(isset($user['id_user_sd']) && !empty($user['id_user_sd'])) ? "hide" : ''?>">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="fio_for_speciald">Ф.И.О.</label>
                    <?php
                    if (isset($user['fio_for_speciald']) && !empty($user['fio_for_speciald'])) {

                        ?>
                        <input type="text" class="form-control"  placeholder="Ф.И.О." name="fio_for_speciald" value="<?= $user['fio_for_speciald'] ?>" >
                        <?php
                    } else {

                        ?>
                        <input type="text" class="form-control"  placeholder="Ф.И.О." name="fio_for_speciald" >
                        <?php
                    }

                    ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label for="position_for_speciald">Должность</label>
                    <?php
                    if (isset($user['fio_for_speciald']) && !empty($user['fio_for_speciald'])) {

                        ?>
                        <input type="text" class="form-control" placeholder="Должность"  name="position_for_speciald" value="<?= $user['position_for_speciald'] ?>" >
                        <?php
                    } else {

                        ?>
                        <input type="text" class="form-control" placeholder="Должность"  name="position_for_speciald" >
                        <?php
                    }

                    ?>
                </div>
            </div>


            <div class="col-lg-2">
                <div class="form-group" name="local">
                    <label for="id_rank">Звание</label>
                    <select class="js-example-basic-single form-control" name="id_rank"  data-placeholder="Выбрать"   >
                        <option value="" >не выбрано</option>
                        <?php
                        foreach ($ranks as $rank) {
                            if (isset($user['id_rank']) && $user['id_rank'] == $rank['id']) {
                                printf("<p><option value='%s' selected ><label>%s</label></option></p>", $rank['id'], $rank['name']);
                            } else {
                                printf("<p><option value='%s'  ><label>%s</label></option></p>", $rank['id'], $rank['name']);
                            }
                        }

                        ?>
                    </select>

                </div>
            </div>


        </div>

        <div class="row row-data-for-sd <?=(isset($user['id_user_sd']) && !empty($user['id_user_sd'])) ? "hide" : ''?>">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="creator_name_for_speciald">Подразделение (отображается в форме создания спец.донесения как Создатель)</label>
                    <?php
                    if (isset($user['creator_name_for_speciald']) && !empty($user['creator_name_for_speciald'])) {

                        ?>
                        <input type="text" class="form-control" placeholder=""  name="creator_name_for_speciald" value="<?= $user['creator_name_for_speciald'] ?>" >
                        <?php
                    } else {

                        ?>
                        <input type="text" class="form-control" placeholder=""  name="creator_name_for_speciald" >
                        <?php
                    }

                    ?>
                </div>
            </div>

        </div>


        <br>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Сохранить</button>
                    <br>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <a href="<?= $baseUrl ?>/user/">  <button type="button" class="btn btn-warning">Назад</button></a>

                </div>
            </div>
        </div>

    </form>
</div>


