<?php
if (isset($rig) && !empty($rig) && $rig['is_copy'] == 1) {

    ?>
    <div class="alert alert-danger alert-danger-custom" style="margin-top: 20px;padding-top: 10px;padding-bottom: 10px;">
        <strong>
            ВНИМАНИЕ! Это копия выезда (ID = <?= $rig['copy_rig_id'] ?>).
        </strong>
    </div>
    <?php
}

?>
