<style>
    .check-result-battle-part-1{
        margin-bottom: 0px;
    }
</style>

<?php
//print_r($part_1);
//echo $id_part_1;
?>
<form  role="form" id="resultsBattleFormPart_1" method="POST" action="<?= $baseUrl ?>/results_battle_part_1/<?= $id_rig ?>" >

<a href="#" class="validate_href" data-form="resultsBattleFormPart_1" data-toggle="modal"  data-target="#validate_modal"></a>

     <input type="hidden" class="form-control"  name="id_part_1" value="<?= (isset($id_part_1) && !empty($id_part_1)) ? $id_part_1 : 0 ?>" >
            <label >
                пожар ликвидирован:
            </label>
            <div class="row">

                <div class="col-lg-12 form-group check-result-battle-part-1">

                        <div class="checkbox checkbox-danger check-result-battle-part-1">
                            <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="people_help" value="1" id="defaultCheck1" <?= ((isset($part_1['people_help'])) && $part_1['people_help'] == 1) ? 'checked': ''?> >
                            <label for="defaultCheck1" class="<?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['people_help']) || $part_1['people_help'] == 0)  ) ? 'label-fire':'' ?>">
                                 населением, работающим до прибытия подразделений МЧС
                            </label>
                        </div>

                </div>


                <div class="col-lg-12 form-group check-result-battle-part-1">

                        <div class="checkbox checkbox-danger check-result-battle-part-1">
                    <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="gos_help" value="1" id="defaultCheck2" <?= ((isset($part_1['gos_help'])) && $part_1['gos_help'] == 1) ? 'checked': ''?>>
                    <label class="<?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['gos_help']) || $part_1['gos_help'] == 0)  ) ? 'label-fire':'' ?>" for="defaultCheck2">
                        ведомственными и добровольными пожарными формированиями до прибытия подразделений МЧС
                    </label>
                        </div>

                </div>






                <div class="col-lg-12 form-group check-result-battle-part-1">
                    <div class="checkbox checkbox-danger check-result-battle-part-1">
                   <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="no_water" value="1" id="defaultCheck6" <?= ((isset($part_1['no_water'])) && $part_1['no_water'] == 1) ? 'checked': ''?>>
                    <label class="form-check-label <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['no_water']) || $part_1['no_water'] == 0)  ) ? 'label-fire':'' ?>" for="defaultCheck6">
                        без установки пожарных аварийно-спасательных автомобилей на водоисточник (водоем, ПГ и т.п.)
                    </label>
                    </div>
                </div>

                <div class="col-lg-12 form-group check-result-battle-part-1">
                    <div class="checkbox checkbox-danger check-result-battle-part-1">
                    <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="water" value="1" id="defaultCheck7" <?= ((isset($part_1['water'])) && $part_1['water'] == 1) ? 'checked': ''?>>
                    <label class="form-check-label <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['water']) || $part_1['water'] == 0)  ) ? 'label-fire':'' ?>" for="defaultCheck7">
                        с установкой пожарных аварийно-спасательных автомобилей на водоисточник (водоем, ПГ и т.п.)
                    </label>
                </div>
                </div>




                 <div class="col-lg-2 form-group check-result-battle-part-1">
                     <div class="checkbox checkbox-danger check-result-battle-part-1">
                    <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="alone_otd" value="1" id="defaultCheck3"  <?= ((isset($part_1['alone_otd'])) && $part_1['alone_otd'] == 1) ? 'checked': ''?>>
                    <label class="form-check-label <?=(isset($current_reason_rig) && $current_reason_rig == 34 && ((!isset($part_1['alone_otd']) || $part_1['alone_otd'] == 0) && (!isset($part_1['alone_shift']) || $part_1['alone_shift'] == 0) && (!isset($part_1['dop_mes']) || $part_1['dop_mes'] == 0)) ) ? 'label-fire':'' ?>" for="defaultCheck3">
                        силами одного отделения
                    </label>
                     </div>
                </div>

                <div class="col-lg-2 form-group check-result-battle-part-1">
                     <div class="checkbox checkbox-danger check-result-battle-part-1">
                    <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="alone_shift" value="1" id="defaultCheck4"  <?= ((isset($part_1['alone_shift'])) && $part_1['alone_shift'] == 1) ? 'checked': ''?>>
                    <label class="form-check-label <?=(isset($current_reason_rig) && $current_reason_rig == 34 && ((!isset($part_1['alone_otd']) || $part_1['alone_otd'] == 0) && (!isset($part_1['alone_shift']) || $part_1['alone_shift'] == 0) && (!isset($part_1['dop_mes']) || $part_1['dop_mes'] == 0)) ) ? 'label-fire':'' ?>" for="defaultCheck4">
                        силами одной смены
                    </label>
                </div>
                     </div>

                <div class="col-lg-3 form-group check-result-battle-part-1">
                    <div class="checkbox checkbox-danger check-result-battle-part-1">
                   <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="dop_mes" value="1" id="defaultCheck5" <?= ((isset($part_1['dop_mes'])) && $part_1['dop_mes'] == 1) ? 'checked': ''?>>
                    <label class="form-check-label <?=(isset($current_reason_rig) && $current_reason_rig == 34 && ((!isset($part_1['alone_otd']) || $part_1['alone_otd'] == 0) && (!isset($part_1['alone_shift']) || $part_1['alone_shift'] == 0) && (!isset($part_1['dop_mes']) || $part_1['dop_mes'] == 0)) ) ? 'label-fire':'' ?>" for="defaultCheck5">
                        с привлечением дополнительных сил МЧС
                    </label>
                    </div>
                </div>


            </div>

<br>
            <p class="line"><span>Аварийно-спасательный и механизированнный инструмент</span></p>

            <div class="row">

                <div class="col-lg-1">
                    <div class="form-group">
                        <label for="dam_build_l">Механизированный</label>
                        <input type="text" class="form-control int-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['tool_meh']) || $part_1['tool_meh'] == 0)  ) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="tool_meh" value="<?= (isset($part_1['tool_meh'])) ? $part_1['tool_meh'] : 0 ?>" >
                    </div>
                </div>

                <div class="col-lg-1">
                    <div class="form-group">
                        <label for="dam_build_l">Пневматический</label>
                        <input type="text" class="form-control int-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['tool_pnev']) || $part_1['tool_pnev'] == 0)  ) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="tool_pnev" value="<?= (isset($part_1['tool_pnev'])) ? $part_1['tool_pnev'] : 0 ?>" >
                    </div>
                </div>

                <div class="col-lg-1">
                    <div class="form-group">
                        <label for="des_build_l">Гидравлический</label>
                        <input type="text" class="form-control int-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['tool_gidr']) || $part_1['tool_gidr'] == 0)  ) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="tool_gidr" value="<?= (isset($part_1['tool_gidr'])) ? $part_1['tool_gidr'] : 0 ?>" >
                    </div>
                </div>


                <div class="col-lg-6"></div>

                <div class="col-lg-2">
                    <div class="box-body">
                        <button type="submit" class="btn-save-rig">  <div class="i2Style">Сохранить данные</div></button>
                    </div>
                </div>

            </div>

            <p class="line"><span>При тушении использовались</span></p>

            <div class="row">



                                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="des_build_l">Количество привлеченной авиационной техники</label>
                        <input type="text" class="form-control int-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['avia_help']) || $part_1['avia_help'] == 0)  ) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="avia_help" value="<?= (isset($part_1['avia_help'])) ? $part_1['avia_help'] : 0 ?>" >
                    </div>
                </div>

<!--                <div class="col-lg-2 form-group check-result-battle-part-1">
                    <div class="checkbox checkbox-info check-result-battle-part-1">
                        <input class="form-check-input" type="checkbox" name="avia_help" value="1" id="defaultCheck8" < ((isset($part_1['avia_help'])) && $part_1['avia_help'] == 1) ? 'checked': ''?>>
                        <label class="form-check-label" for="defaultCheck8">
                            авиационная техника
                        </label>
                    </div>
                </div>-->


                 <div class="col-lg-8 form-group check-result-battle-part-1">
                    <div class="checkbox checkbox-info check-result-battle-part-1">
                    <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="other_mes" value="1" id="defaultCheck9" <?= ((isset($part_1['other_mes'])) && $part_1['other_mes'] == 1) ? 'checked': ''?>>
                    <label class="form-check-label <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['other_mes']) || $part_1['other_mes'] == 0)) ? 'label-fire':'' ?>" for="defaultCheck9">
                        другая техника МЧС (отсутствующая в общем перечне техники в карточке учета сил и средств)
                    </label>
                </div>
                 </div>

                 <div class="col-lg-2 form-group check-result-battle-part-1">
                    <div class="checkbox checkbox-info check-result-battle-part-1">
                    <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="one_gdzs" value="1" id="defaultCheck10" <?= ((isset($part_1['one_gdzs'])) && $part_1['one_gdzs'] == 1) ? 'checked': ''?>>
                    <label class="form-check-label <?=(isset($current_reason_rig) && $current_reason_rig == 34 && ((!isset($part_1['one_gdzs']) || $part_1['one_gdzs'] == 0) && (!isset($part_1['many_gdzs']) || $part_1['many_gdzs'] == 0) ) ) ? 'label-fire':'' ?>" for="defaultCheck10">
                        одно звено ГДЗС
                    </label>
                </div>
                 </div>

                   <div class="col-lg-2 form-group check-result-battle-part-1">
                    <div class="checkbox checkbox-info check-result-battle-part-1">
                    <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="many_gdzs" value="1" id="defaultCheck11" <?= ((isset($part_1['many_gdzs'])) && $part_1['many_gdzs'] == 1) ? 'checked': ''?>>
                    <label class="form-check-label <?=(isset($current_reason_rig) && $current_reason_rig == 34 && ((!isset($part_1['one_gdzs']) || $part_1['one_gdzs'] == 0) && (!isset($part_1['many_gdzs']) || $part_1['many_gdzs'] == 0) ) ) ? 'label-fire':'' ?>" for="defaultCheck11">
                        два и более звеньев ГДЗС
                    </label>
                </div>
                   </div>


            </div>
            <br>


            <p class="line"></p>


            <div class="row">


                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="save_an_l">Переносные порошковые огнетушители</label>
                        <input type="text" class="form-control int-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['powder_mob']) || $part_1['powder_mob'] == 0)  ) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="powder_mob" value="<?= (isset($part_1['powder_mob'])) ? $part_1['powder_mob'] : 0 ?>" >
                    </div>
                </div>


                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="save_an_l">Израсходовано порошка, тонн</label>
                        <input type="text" class="form-control str-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['powder_out']) || $part_1['powder_out'] == 0)  ) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="powder_out" value="<?= (isset($part_1['powder_out'])) ? $part_1['powder_out'] : 0 ?>" >
                    </div>
                </div>


            </div>


            <br>

            <p class="line"><span>Дополнительные результаты боевой работы на пожарах</span></p>
  <br>
            <div class="row">

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="save_an_l">Спасено людей (с применением масок)</label>
                        <input type="text" class="form-control int-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['save_p_mask']) || $part_1['save_p_mask'] == 0)  ) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="save_p_mask" value="<?= (isset($part_1['save_p_mask'])) ? $part_1['save_p_mask'] : 0 ?>" >
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="dam_an_l">Предотвращено уничтожение кормов (тонн)</label>
                        <input type="text" class="form-control str-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['pred_food']) || $part_1['pred_food'] == 0)  ) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="pred_food" value="<?= (isset($part_1['pred_food'])) ? $part_1['pred_food'] : 0 ?>" >
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="des_an_l">Предотвращено уничтожение огнем строений</label>
                        <input type="text" class="form-control int-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['pred_build']) || $part_1['pred_build'] == 0)  ) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="pred_build" value="<?= (isset($part_1['pred_build'])) ? $part_1['pred_build'] : 0 ?>" >
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="des_an_l">Предотвращено уничтожение огнем единиц техники</label>
                        <input type="text" class="form-control int-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 34 && (!isset($part_1['pred_vehicle']) || $part_1['pred_vehicle'] == 0)  ) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" placeholder="0" name="pred_vehicle" value="<?= (isset($part_1['pred_vehicle'])) ? $part_1['pred_vehicle'] : 0 ?>" >
                    </div>
                </div>

            </div>

</form>