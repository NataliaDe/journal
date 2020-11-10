<style>
    .tbl-obl-rigs tbody tr:hover {
        background-color: #edf1f9;
    }
    .tbl-obl-rigs .left {
        text-align: left;
    }
    .tbl-obl-rigs tbody  tr td, .tbl-obl-rigs thead th{
        border: 2px solid #00000075 !important
    }

    .tbl-obl-rigs tbody  .tr-itogo{
        background-color: #ffff004a;
        font-weight: 600;
    }
        .tbl-obl-rigs {
       width: 85% !important;
    }
</style>

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
        <th>постра-<br>давшие</th>
        <th>спас/эвак</th>
        <th>др. загорания</th>
        <th>помощь</th>
        <th>демер-<br>куризация</th>
        <th>молния</th>
        <th>др.сигна-<br>лизации</th>
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
                    <td class="left">
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
                        <?= $row['moln'] ?>
                    </td>
                    <td>
                        <?= $row['signl'] ?>
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
            <tr class="tr-itogo">
                <td colspan="2">
                    ИТОГО
                </td>



                <td>
                    <?= ($itogo['fire'] > 0 ? $itogo['fire'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['dead'] > 0 ? $itogo['dead'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['inj'] > 0 ? $itogo['inj'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['save'] > 0 ? $itogo['save'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['o'] > 0 ? $itogo['o'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['help'] > 0 ? $itogo['help'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['demerk'] > 0 ? $itogo['demerk'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['moln'] > 0 ? $itogo['moln'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['signl'] > 0 ? $itogo['signl'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['les'] > 0 ? $itogo['les'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['torf'] > 0 ? $itogo['torf'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['trava'] > 0 ? $itogo['trava'] : '') ?>
                </td>
                <td>
                    <?= ($itogo['false'] > 0 ? $itogo['false'] : '') ?>
                </td>
            </tr>

        </tbody>
    </table>

</div>
<div class="modal-footer">
    <button  type="button" class="btn btn-secondary " data-dismiss="modal" >Закрыть</button>
</div>