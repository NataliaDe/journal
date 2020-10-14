<div class="modal-header" >
    <h4 class="modal-title ff-l header-name" id="myModalLabel">
        <img  src="<?= $baseUrl ?>/assets/images/monitor-refresh.png"  onclick="refresh_rigs_obl_table();" style="width: 35px;cursor: pointer" data-toggle="tooltip" data-placement="top" title="Обновить">
        Выезды подразделений <b><?= $obl_name ?> гарнизона</b>
        <u>с <?= $date1 ?> до <?= $date2 ?></u>
    </h4>


    <button class="close danger" type="button" data-dismiss="modal" style="font-weight: bolder; margin-top: -38px;">×</button>


</div>
<div class="modal-body">

<!--    <button  type="button" class="btn btn-success " onclick="refresh_rigs_obl_table();" >Обновить</button>-->
    <table class="table table-condensed   table-bordered table-custom tbl-obl-rigs ">
        <thead>
        <th>№ п.п</th>
        <th>район</th>
        <th>пожары</th>
        <th>гибель</th>
        <th>пострадав-<br>шие</th>
        <th>спас/эвак</th>
        <th>др. загорания</th>
        <th>помощь</th>
        <th>демеркуриз.</th>
        <th>лес</th>
        <th>торф</th>
        <th>трава</th>
        <th>ложный</th>
        </thead>

        <tbody>
            <?php
            $k = 0;
            foreach ($locals as $loc_name => $row) {
                $k++;

                ?>
                <tr>
                    <td>
                        <?= $k ?>
                    </td>
                    <td>
                        <?= $loc_name ?>
                    </td>
                    <td>
                        <?= $row['fire'] ?>
                    </td>
                    <td class=" <?= (!empty($row['dead'])) ? 'td-red' : '' ?>">
                        <?= $row['dead'] ?>
                    </td>
                    <td>
                        <?= $row['inj'] ?>
                    </td>
                    <td>
                        <?= $row['save'] ?><?= (!empty($row['ev']) && !empty($row['save'])) ? '/' : '' ?><?= $row['ev'] ?>
                    </td>
                    <td>
                        <?= $row['o'] ?>
                    </td>
                    <td>
                        <?= $row['help'] ?>
                    </td>
                    <td>
                        <?= $row['demerk'] ?>
                    </td>
                    <td>
                        <?= $row['les'] ?>
                    </td>
                    <td>
                        <?= $row['torf'] ?>
                    </td>
                    <td>
                        <?= $row['trava'] ?>
                    </td>
                    <td>
                        <?= $row['false'] ?>
                    </td>
                </tr>
                <?php
            }

            ?>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button  type="button" class="btn btn-secondary " data-dismiss="modal" >Закрыть</button>
</div>