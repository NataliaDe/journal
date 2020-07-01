
<!--<div class="box-body">-->
<?php
//echo $_SERVER['REQUEST_URI'];

?>

<br><br>
<form  role="form" class="form-inline" name="np_query_form" id="np_query_form" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">


    <div class="row" style="padding-left: 20px">



        <div class="form-group">
            <label for="id_region">Область</label>
            <select class="form-control" name="id_region" id="reg_id_chaned"  >
                <?php
                foreach ($region as $re) {

                    ?>
                    <option value="<?= $re['id'] ?>" <?= (isset($_POST['id_region']) && $_POST['id_region'] == $re['id']) ? 'selected' : '' ?>><?= $re['name'] ?></option>
                    <?php
                }

                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_local">Район</label>
            <select class="form-control" name="id_local" id="loc_id_chaned"  >
                <option value="">Все</option>

                <?php
                foreach ($local as $row) {

                    ?>
                    <option value="<?= $row['id'] ?>" class="<?= $row['id_region'] ?>" <?= (isset($_POST['id_local']) && $_POST['id_local'] == $row['id']) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                    <?php
                }

                ?>
            </select>
        </div>





        <div class="form-group">
            <button class="btn bg-purple" type="submit"   >Показать</button>
        </div>
    </div>





</form>
