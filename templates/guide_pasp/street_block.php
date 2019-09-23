        <div class="form-group">
            <label for="id_street">Улица</label>
            <select class="js-example-basic-single street-block-select-single form-control" id="id_street" name="id_street" data-placeholder="Выбрать" >
                <option value="">Все</option>
<?php
if ($pasp_id_from_guide != 0) {//редактирование - заполнить  по умолчанию
    if (isset($street) && !empty($street)) {
        foreach ($street as $row) {
            if ($result['id_street'] == $row['id']) {
                printf("<p><option selected value='%s' ><label>%s (%s)</label></option></p>", $row['id'], $row['name'], $row['vid_name']);
            } else {
                printf("<p><option value='%s' ><label>%s (%s)</label></option></p>", $row['id'], $row['name'], $row['vid_name']);
            }
        }
    }
} else {
    if (isset($street) && !empty($street)) {
        foreach ($street as $row) {
            printf("<p><option value='%s' ><label>%s (%s)</label></option></p>", $row['id'], $row['name'], $row['vid_name']);
        }
    }
}
?>
                <!--            список формируется ajax функция-->
            </select>
        </div>