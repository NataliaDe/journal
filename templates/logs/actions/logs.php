<?php
include dirname(__FILE__) . '/form.php';

?>
<br>

<br><br>
<center>
    <table class="table table-condensed   table-bordered table-custom" id="logsaction_tbl"   >
        <!-- строка 1 -->
        <thead>
            <tr>
                <th>Имя пользователя</th>
                <th>Область</th>
                <th>Подразделение</th>
                <th>Id выезда</th>
                <th>Действие</th>
                <th>Дата выполнения</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Имя пользователя</th>
                <th>Область</th>
                <th>Подразделение</th>
                <th>Id выезда</th>
                <th>Действие</th>
                <th>Дата выполнения</th>

            </tr>
        </tfoot>
        <tbody>
            <?php
            if (isset($logs) && !empty($logs)) {
                foreach ($logs as $row) {

                    ?>
                    <tr>
                        <td><?= $row['s_user_name'] ?></td>
                        <td><?= $row['s_region_name'] ?></td>
                        <td><?= $row['s_locorg_name'] ?></td>
                        <td><?= $row['id_rig'] ?></td>
                        <td><?= $row['action'] ?></td>
                        <td><?php
                            if (!empty($row['date_action']))
                                $d = date('d.m.Y H:i:s', strtotime($row['date_action']));
                            else
                                $d = '';

                            echo $d;

                            ?></td>

                    </tr>
                    <?php
                }
            }

            ?>

        </tbody>
    </table>
</center>



