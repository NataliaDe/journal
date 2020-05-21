
<?php
if (isset($id_rig) && !empty($id_rig) && isset($settings_user['vid_rig_table']) && $settings_user['vid_rig_table']['name_sign'] == 'level3_type4') {

    ?>
    <ul class="nav nav-tabs">
        <li>
            <a href="<?= $baseUrl ?>/rig/new/<?= $id_rig ?>/10">Обработка вызова</a>
        </li>

        <li>
            <a href="<?= $baseUrl ?>/rig/new/<?= $id_rig ?>/20">Высылка техники</a>
        </li>

        <li>
            <a href="<?= $baseUrl ?>/rig/new/<?= $id_rig ?>/30" >Дополнительно</a>
        </li>

		 <?php
        if (isset($current_reason_rig) && in_array($current_reason_rig, $reasonrig_with_informing)) {
        ?>
        <li class="<?=($title_block == 'info') ? 'active':''?>">
            <a href="<?= $baseUrl ?>/rig/<?= $id_rig ?>/info"  aria-hidden='true' data-toggle="tooltip" data-placement="bottom" title="Информирование">
                <i class="fa fa-lg fa-info-circle" ></i>
            </a>
        </li>
		        <?php
        }
        ?>

        <li class="<?=($title_block == 'time') ? 'active':''?>">


            <a href="<?= $baseUrl ?>/rig/<?= $id_rig ?>/character"  aria-hidden='true' data-toggle="tooltip" data-placement="bottom" title="Временные характеристики">
                <i class="fa fa-lg fa-clock-o" ></i>
            </a>
        </li>

        <li class="<?=($title_block == 'rb') ? 'active':''?>">

            <a href="<?= $baseUrl ?>/results_battle/<?= $id_rig ?>"  aria-hidden='true' data-toggle="tooltip" data-placement="bottom" title="Результаты боевой работы">
                <i class="fa fa-lg fa-male" ></i></a>


        </li>
        <li class="<?=($title_block == 'trunks') ? 'active':''?>">


            <a href="<?= $baseUrl ?>/trunk/<?= $id_rig ?>"  aria-hidden='true' data-toggle="tooltip" data-placement="bottom" title="Подача стволов" >
                <i class="fa fa-lg fa-free-code-camp" style="color: <?= (isset($trunk_by_rig) && isset($trunk_by_rig[$row['id']]) && !empty($trunk_by_rig[$row['id']])) ? 'green' : '' ?>"></i></a>

        </li>

    </ul>

    <?php
}

?>
