<?php
$thumb_img = "Параметры файлов для загрузки: JPG, PNG, JPEG, DOC, DOCX, XLS, XLSX | 1024x768px | суммарный объем не более 15Мб";

?>
<div class="row form-group" id="upload-img">

    <div class="col-md-12 col-sm-12">


        <?php
        if (isset($images) && !empty($images)) {
            foreach ($images as $key => $row) {

                if ($row['type_source'] == 'file') {

                    ?>
                    <i class="fa fa-file-text-o fa-lg file-icon issue-file-type" style="margin-left: 10px;" data-name="<?= $row['file'] ?>" aria-hidden="true"> <?= $row['file'] ?></i>

                    <i class="fa fa-times-circle-o fa-lg delete-icon-file-type" data-name="<?= $row['file'] ?>" aria-hidden="true" style="margin-left: 5px;"></i>


                    <br>
                    <?php
                } elseif ($row['type_source'] == 'img') {

                    ?>
                    <img src="<?= $baseUrl . '/' . $upload_path . '/remark/' . $row['file'] ?>" class="issue-img-multi" data-name="<?= $row['file'] ?>">
                    <i class="fa fa-times-circle-o fa-lg delete-img-multi" data-name="<?= $row['file'] ?>" aria-hidden="true"></i>

                    <br>
                    <?php
                }
            }
        }

        ?>

        <div class="form-control" id="upload-input">
            <input type="hidden" name="list_files" id="photo-sd-multi" value="">

            <input type="file"  <?= ((isset($images) && !empty($images)) ) ? 'style="display:none"' : ''?> class="adapt-img-multi" multiple=""  data-api-url="<?= $baseUrl ?>/loadApi/remark_rcu_file" data-inp-name="photo-sd-multi" title="Файл не выбран">
            <div class="upload-info">
                <span class="upload-info-text video-file-span" data-text="<?= $thumb_img ?>">
                    
                    <?php
                    if (isset($images) && !empty($images)) {

                        ?>

                        <p><a class="upload-info-clear-multi"
                              href="#">
                                удалить файлы

                            </a>
                        </p>
                        <?php
                    } else {
                        echo $thumb_img;

                        ?>

                        <?php
                    }

                    ?>
                </span>
            </div>
        </div>
        <div class="progress" style="display: none">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
            </div>
        </div>


    </div>
</div>














