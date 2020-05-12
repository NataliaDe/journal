
<br><br>
<div class="container">
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Внимание!</strong>
        <?php
        if (isset($msg) && !empty($msg)) {
            echo $msg;
        } else {

            ?>
            У Вас недостаточно прав для выполнения данной операции!
            <?php
        }

        ?>

    </div>
</div>
<br>





