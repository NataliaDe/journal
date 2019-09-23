<br><br>
<center>
    <u> <b>
<?= $name_table?>
        </b></u>
<br><br>
<?php
//echo $_SESSION['id_locorg'];
//echo $_SESSION['id_level'];
//print_r($podr);
?>
    <table class="table table-condensed   table-bordered table-custom" id="guide_pasp_tbl" >
        <!-- строка 1 -->
        <thead>
            <tr>
                <th>Подразделение</th>
                <th>Г(Р)ОЧС</th>
                <th>Широта, долгота</th>
                  <th>Адрес</th>
                <th>Ред.</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                 <th></th>
                <th></th>
                <th></th>
                <th></th>

            </tr>
        </tfoot>
        <tbody>

            <?php
            foreach ($podr as $row) {
                ?>
            <tr>
                <td><?= $row['pasp_name'] ?></td>
                <td><?= $row['locorg_name'] ?></td>
                <td><?= $row['latitude'] ?>, <?= $row['longitude'] ?></td>
                <td><?= $row['address'] ?></td>
                <td><a href="<?= $baseUrl ?>/guide_pasp/<?= $row['id'] ?>" target="_blank"> <button class="btn btn-xs btn-warning " type="button"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Редактировать"></i></button></a></td>
            </tr>
            <?php
            }
            ?>




        </tbody>
    </table>
</center>

