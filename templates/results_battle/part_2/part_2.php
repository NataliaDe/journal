<style>
    .check-result-battle-part-1{
        margin-bottom: 0px;
    }
</style>

<?php
//print_r($part_2);
//echo $id_part_2;

?>
<form  role="form" id="resultsBattleFormPart_2" method="POST" action="<?= $baseUrl ?>/results_battle_part_2/<?= $id_rig ?>" >
    <input type="hidden" class="form-control"  name="id_part_2" value="<?= (isset($id_part_2) && !empty($id_part_2)) ? $id_part_2 : 0 ?>" >

    <div class="row">
        <div class="col-lg-3">
            <label>Результаты боевой работы на ЧС:</label>
        </div>
    </div>
    <br>


    <div class="row">

        <div class="col-lg-3">
            <div class="form-group">
                <label for="pred_build_4s">Предотвращено уничтожение строений</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="pred_build_4s" value="<?= (isset($part_2['pred_build_4s'])) ? $part_2['pred_build_4s'] : 0 ?>" >
            </div>
        </div>

        <div class="col-lg-3">
            <div class="form-group">
                <label for="pred_vehicle_4s">Предотвращено уничтожение единиц техники</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="pred_vehicle_4s" value="<?= (isset($part_2['pred_vehicle_4s'])) ? $part_2['pred_vehicle_4s'] : 0 ?>" >
            </div>
        </div>



        <div class="col-lg-2"></div>

        <div class="col-lg-2">
            <div class="box-body">
                <button type="submit" class="btn-save-rig">  <div class="i2Style">Сохранить данные</div></button>
            </div>
        </div>


    </div>



    <p class="line"></p>
     <br> <br>
    <label>При ликвидации использовались:</label>

 <br> <br>
    <p class="line"><span>Авиационная техника на ЧС</span></p>
    <div class="row">

        <div class="col-lg-3">


            <div class="form-group">
                <label for="avia_4s">Количество привлеченной авиационной техники</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="avia_4s" value="<?= (isset($part_2['avia_4s'])) ? $part_2['avia_4s'] : 0 ?>" >
            </div>
        </div>


    </div>


    <p class="line"><span>Аварийно-спасательный и механизированнный инструмент</span></p>

    <div class="row">

        <div class="col-lg-1">
            <div class="form-group">
                <label for="dam_build_l">Механизированный</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="tool_meh" value="<?= (isset($part_2['tool_meh'])) ? $part_2['tool_meh'] : 0 ?>" >
            </div>
        </div>

        <div class="col-lg-1">
            <div class="form-group">
                <label for="dam_build_l">Пневматический</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="tool_pnev" value="<?= (isset($part_2['tool_pnev'])) ? $part_2['tool_pnev'] : 0 ?>" >
            </div>
        </div>

        <div class="col-lg-1">
            <div class="form-group">
                <label for="des_build_l">Гидравлический</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="tool_gidr" value="<?= (isset($part_2['tool_gidr'])) ? $part_2['tool_gidr'] : 0 ?>" >
            </div>
        </div>



    </div>



</form>