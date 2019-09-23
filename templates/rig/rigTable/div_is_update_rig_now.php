<?php
if((isset($settings_user['update_rig_now']) && $settings_user['update_rig_now']['name_sign'] == 'yes') && isset($row['is_update_now']) && !empty($row['is_update_now'])){//settings
    ?>
<div class="typing-indicator" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="<?= $row['is_update_now'] ?>">

    <span></span>
    <span></span>
    <span></span>
</div>
<?php }?>
