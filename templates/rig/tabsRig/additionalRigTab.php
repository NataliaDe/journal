
<!--by settings: additional tab-->
<?php
if (isset($settings_user['is_addit_on_process_tab']) && $settings_user['is_addit_on_process_tab']['name_sign'] == 'yes') {

} else {
    include dirname(__FILE__) . '/addit_tab_content.php';
}

?>

<hr>

