<div class="box-body">
    <a href="<?= $baseUrl ?>/user/new"><button type="button" class="btn btn-success">Создать пользователя</button></a>

    <!--table with users-->

    <br>
</div>

<br>

<span style="background-color: #dff0d8; border: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> - Пользователи, связанные с пользователем в СД


<div class="table-responsive"  >
    <br><br>
    <table class="table table-condensed   table-bordered table-custom" id="userTable" >
        <!-- строка 1 -->
        <thead>
            <tr>
                <th>Имя<br>пользователя</th>
                <th>Логин/<br>Пароль</th>
                <th>Может<br> создавать/ред.<br>выезды</th>
                <th>Админ.</th>
                <th>Авт.<br>заполнение<br>адреса выезда</th>
                <th >Уровень</th>
                <th>Область</th>
                <th>Г(Р)ОЧС</th>
                <th>Ред.</th>
                <th>Уд.</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Имя<br>пользователя</th>
                <th>Логин</th>
                <th>Может<br> создавать/ред. выезды</th>
                <th></th>
                <th></th>
                <th >Уровень</th>
                <th>Область</th>
                <th>Г(Р)ОЧС</th>
                <th></th>
                <th></th>

            </tr>
        </tfoot>
        <tbody>
            <?php
            foreach ($permissions as $value) {
               ?>
            <tr class="<?= (isset($value['id_user_sd']) && !empty($value['id_user_sd'])) ? "success" : ''?>">
               <td><?= $value['user_name'] ?></td>
               <td><?= $value['login'] ?><br><?= $value['password'] ?></td>
                <td><?= $value['can_edit_name'] ?></td>
                <td><?= $value['is_admin_name'] ?></td>
                <td><?= $value['auto_ate_name'] ?></td>
                <td><?= $value['level_name'] ?></td>
                <td><?= $value['region_name'] ?></td>
                <td><?= $value['locorg_name'] ?></td>
                <td> <a href="<?= $baseUrl ?>/user/new/<?= $value['id_user'] ?>"> <button class="btn btn-xs btn-warning " type="button"><i class="fa fa-pencil" aria-hidden="true"></i></button></a></td>
                <td><a href="<?= $baseUrl ?>/user/<?= $value['id_user'] ?>"> <button class="btn btn-xs btn-danger" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></a></td>
            </tr>
  <?php
            }
            ?>




        </tbody>
    </table>

</div>
