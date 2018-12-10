<?php
include dirname(__FILE__) . '/form.php';
?>
<br>

<br><br>

<table class="table table-condensed   table-bordered table-custom" id="logsTable" >
    <!-- строка 1 -->
    <thead>
        <tr>
            <th>Дата</th>
            <th>Действие</th>
            <th style="width:220px !important;">Данные</th>

        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Дата</th>
            <th>Действие</th>
            <th>Данные</th>

        </tr>
    </tfoot>
    <tbody>
        <?php
        if (isset($file) && !empty($file)) {
            foreach ($file as $string) {

                if (!strpos($string, 'SlimMonoLogger.ERROR:')) {
                    $pos = strpos($string, '[]', 1);
                    $row = substr($string, 0, $pos);
                    //echo $row;


                    /* ------ дата ----- */
                    $date_pos = strpos($row, 'Slim');
                    $row_date = substr($row, 0, $date_pos);
//    echo $row_date;
//     echo '<br>';


                    $action_pos = strpos($row, '::');
                    $row_action = substr($row, $action_pos);
                    // echo $row_action;
                    // echo '<br>';


                    /* ------ данные ----- */
                    $data_pos = strpos($row_action, '{');
                    $row_data = substr($row_action, $data_pos);
//    echo $row_data;
//     echo '<br>';


                    /* ------ действие ----- */
                    $action_pos = strpos($row_action, '::');
                    $action = substr($row_action, $action_pos, $data_pos);
                    //echo $action;

                    $r = explode(',', $row_data);
                    ?>
                    <tr>
                        <td><?= $row_date ?></td>
                        <td><?= $action ?></td>
                        <td>
                            <?php
                            foreach ($r as $v) {
                                echo $v . '<br>';
                            }
                            ?>

                        </td>

                    </tr>          

                    <?php
                }
            }
        }
        ?>

    </tbody>
</table>



