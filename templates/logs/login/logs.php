<?php
include dirname(__FILE__) . '/form.php';

?>
<br>

<br><br>
<center>
    <table class="table table-condensed   table-bordered table-custom" id="logslogin_tbl"   >
        <!-- строка 1 -->
        <thead>
            <tr>
                <th>Имя пользователя</th>
                <th>Область</th>
                <th>Подразделение</th>
                <th>Дата входа</th>
                <th>Дата выхода</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Имя пользователя</th>
                <th>Область</th>
                <th>Подразделение</th>
                <th>Дата входа</th>
                <th>Дата выхода</th>

            </tr>
        </tfoot>
        <tbody>
            <?php
            if (isset($logs) && !empty($logs)) {
                foreach ($logs as $row) {

                    ?>
                    <tr>
                        <td><?= $row['user_name'] ?></td>
                        <td><?= $row['region_name'] ?></td>
                        <td><?= $row['locorg_name'] ?></td>
                        <td><?php
                            if (!empty($row['date_in']))
                                $d1 = date('d.m.Y H:i:s', strtotime($row['date_in']));
                            else
                                $d1 = '';

                            echo $d1;

                            ?></td>
                        <td><?php
                            if (!empty($row['date_out']))
                                $d2 = date('d.m.Y H:i:s', strtotime($row['date_out']));
                            else
                                $d2 = '';

                            echo $d2;

                            ?></td>

                    </tr>
                    <?php
                }
            }

            ?>

        </tbody>
    </table>
</center>



