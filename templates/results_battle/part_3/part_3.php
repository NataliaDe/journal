<style>
    .check-result-battle-part-1{
        margin-bottom: 0px;
    }
</style>

<?php
//print_r($part_2);
//echo $id_part_2;

?>
<form  role="form" id="resultsBattleFormPart_3" method="POST" action="<?= $baseUrl ?>/results_battle_part_3/<?= $id_rig ?>" >

<a href="#" class="validate_href" data-form="resultsBattleFormPart_3" data-toggle="modal"  data-target="#validate_modal"></a>

    <input type="hidden" class="form-control"  name="id_part_3" value="<?= (isset($id_part_3) && !empty($id_part_3)) ? $id_part_3 : 0 ?>" >


    <p class="line"><span>На проведение работ при ликвидации последстий ДТП</span></p>
    <br>
    <div class="row">

        <div class="col-lg-2">
            <div class="form-group">
                <label for="s_peop_dtp">Спасено людей</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="s_peop_dtp" value="<?= (isset($part_3['s_peop_dtp'])) ? $part_3['s_peop_dtp'] : 0 ?>" >
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label for="s_chi_dtp">в том числе детей</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="s_chi_dtp" value="<?= (isset($part_3['s_chi_dtp'])) ? $part_3['s_chi_dtp'] : 0 ?>" >
            </div>
        </div>


        <div class="col-lg-2">
            <div class="form-group">
                <label for="d_dead_dtp">деблокировано погибших</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="d_dead_dtp" value="<?= (isset($part_3['d_dead_dtp'])) ? $part_3['d_dead_dtp'] : 0 ?>" >
            </div>
        </div>



        <div class="col-lg-2"></div>

        <div class="col-lg-2">
            <div class="box-body">
                <button type="submit" class="btn-save-rig">  <div class="i2Style">Сохранить данные</div></button>
            </div>
        </div>


    </div>

    <p class="line"><span>На проведение работ на акваториях водоемов</span></p>
    <br>


    <div class="row">

        <div class="col-lg-2">
            <div class="form-group">
                <label for="s_peop_water">Спасено людей</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="s_peop_water" value="<?= (isset($part_3['s_peop_water'])) ? $part_3['s_peop_water'] : 0 ?>" >
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label for="s_chi_water">в том числе детей</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="s_chi_water" value="<?= (isset($part_3['s_chi_water'])) ? $part_3['s_chi_water'] : 0 ?>" >
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label for="d_dead_water">извлечено погибших</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="d_dead_water" value="<?= (isset($part_3['d_dead_water'])) ? $part_3['d_dead_water'] : 0 ?>" >
            </div>
        </div>


    </div>
    <br>

    <p class="line"><span>Спасено людей в иных случаях</span></p>

    <div class="row">

        <div class="col-lg-3">
            <div class="form-group">
                <label for="s_people_grunt">Спасено людей при обвале грунта</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="s_people_grunt" value="<?= (isset($part_3['s_people_grunt'])) ? $part_3['s_people_grunt'] : 0 ?>" >
            </div>
        </div>

        <div class="col-lg-3">
            <div class="form-group">
                <label for="s_chi_grunt">Спасено детей при обвале грунта</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="s_chi_grunt" value="<?= (isset($part_3['s_chi_grunt'])) ? $part_3['s_chi_grunt'] : 0 ?>" >
            </div>
        </div>



    </div>




    <div class="row">

        <div class="col-lg-3">
            <div class="form-group">
                <label for="s_people_kon">Спасено людей при обрушении строительных конструкций</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="s_people_kon" value="<?= (isset($part_3['s_people_kon'])) ? $part_3['s_people_kon'] : 0 ?>" >
            </div>
        </div>

        <div class="col-lg-3">
            <div class="form-group">
                <label for="s_chi_kon">Спасено детей при обрушении строительных конструкций</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="s_chi_kon" value="<?= (isset($part_3['s_chi_kon'])) ? $part_3['s_chi_kon'] : 0 ?>" >
            </div>
        </div>

		        <div class="col-lg-3">
            <div class="form-group">
                <label for="s_people_cons">Спасено людей при других обстоятельствах</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="s_people_cons" value="<?= (isset($part_3['s_people_cons'])) ? $part_3['s_people_cons'] : 0 ?>" >
            </div>
        </div>

        <div class="col-lg-3">
            <div class="form-group">
                <label for="s_chi_cons">Спасено детей при при других обстоятельствах</label>
                <input type="text" class="form-control int-cnt" placeholder="0" name="s_chi_cons" value="<?= (isset($part_3['s_chi_cons'])) ? $part_3['s_chi_cons'] : 0 ?>" >
            </div>
        </div>



    </div>




    <p class="line"><span>На проведение демеркуризационных работ</span></p>

    <div class="row">

        <div class="col-lg-2">
            <div class="form-group">
                <label for="col_arg">Собрано ртути, кг <i class="fa fa-info-circle info-decimal" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Разделителем целой и дробной части является ТОЧКА (.)"></i></label>
                <input type="text" class="form-control str-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 68 && (!isset($part_3['col_arg']) || $part_3['col_arg'] == 0)) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 68) ? 'required' : '' ?>" placeholder="0" name="col_arg" value="<?= (isset($part_3['col_arg'])) ? $part_3['col_arg'] : 0 ?>" >
            </div>
        </div>

        <div class="col-lg-3">
            <div class="form-group">
                <label for="col_was">Собрано ртутьсодержащих отходов, кг <i class="fa fa-info-circle info-decimal" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Разделителем целой и дробной части является ТОЧКА (.)"></i></label>
                <input type="text" class="form-control str-cnt <?=(isset($current_reason_rig) && $current_reason_rig == 68 && (!isset($part_3['col_was']) || $part_3['col_was'] == 0)) ? 'fire':'' ?> <?= (isset($current_reason_rig) && $current_reason_rig == 68) ? 'required' : '' ?>" placeholder="0" name="col_was" value="<?= (isset($part_3['col_was'])) ? $part_3['col_was'] : 0 ?>" >
            </div>
        </div>

    </div>



    <p class="line"><span>На проведение работ по уничтожению гнезд жалоносных насекомых</span></p>



    <div class="row">

        <div class="col-lg-2 form-group check-result-battle-part-3">

            <div class="checkbox checkbox-danger check-result-battle-part-3">
                <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 80) ? 'required' : '' ?>" type="checkbox" name="ins_kill_free" value="1" id="defaultCheckPart3_1" <?= ((isset($part_3['ins_kill_free'])) && $part_3['ins_kill_free'] == 1) ? 'checked' : '' ?>>
                <label for="defaultCheckPart3_1" class="<?=(isset($current_reason_rig) && $current_reason_rig == 80 && ((!isset($part_3['ins_kill_free']) || $part_3['ins_kill_free'] == 0)) ) ? 'label-fire':'' ?>">
                    на безвозмездной основе
                </label>
            </div>

        </div>


        <div class="col-lg-2 form-group check-result-battle-part-3">

            <div class="checkbox checkbox-danger check-result-battle-part-3">
                <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 80) ? 'required' : '' ?>" type="checkbox" name="ins_kill_free_threat" value="1" id="defaultCheckPart3_3" <?= ((isset($part_3['ins_kill_free_threat'])) && $part_3['ins_kill_free_threat'] == 1) ? 'checked' : '' ?>>
                <label for="defaultCheckPart3_3" class="<?=(isset($current_reason_rig) && $current_reason_rig == 80 && ((!isset($part_3['ins_kill_free_threat']) || $part_3['ins_kill_free_threat'] == 0)) ) ? 'label-fire':'' ?>">
                    наличие прямой угрозы жизни
                </label>
            </div>

        </div>


        <div class="col-lg-2 form-group check-result-battle-part-3">

            <div class="checkbox checkbox-danger check-result-battle-part-3">
                <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 80) ? 'required' : '' ?>" type="checkbox" name="ins_kill_free_before_school" value="1" id="defaultCheckPart3_6" <?= ((isset($part_3['ins_kill_free_before_school'])) && $part_3['ins_kill_free_before_school'] == 1) ? 'checked' : '' ?>>
                <label for="defaultCheckPart3_6" class="<?=(isset($current_reason_rig) && $current_reason_rig == 80 && ((!isset($part_3['ins_kill_free_before_school']) || $part_3['ins_kill_free_before_school'] == 0)) ) ? 'label-fire':'' ?>">
                    дошкольных учреждениях, больницах и т.д (класс Ф 1.1 ТКП 45-2.02-315-2018)
                </label>
            </div>

        </div>


        <div class="col-lg-2 form-group check-result-battle-part-3">

            <div class="checkbox checkbox-danger check-result-battle-part-3">
               <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 80) ? 'required' : '' ?>" type="checkbox" name="ins_kill_free_school" value="1" id="defaultCheckPart3_7" <?= ((isset($part_3['ins_kill_free_school'])) && $part_3['ins_kill_free_school'] == 1) ? 'checked' : '' ?>>
                <label for="defaultCheckPart3_7" class="<?=(isset($current_reason_rig) && $current_reason_rig == 80 && ((!isset($part_3['ins_kill_free_school']) || $part_3['ins_kill_free_school'] == 0)) ) ? 'label-fire':'' ?>">
                    школах и внешкольных учебных заведениях и т.д (класс Ф 4.1 ТКП 45-2.02-315-2018)
                </label>
            </div>

        </div>

    </div>






    <div class="row">

          <div class="col-lg-2 form-group check-result-battle-part-3">

            <div class="checkbox checkbox-danger check-result-battle-part-3">
                <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 80) ? 'required' : '' ?>" type="checkbox" name="ins_kill_charge" value="1" id="defaultCheckPart3_2" <?= ((isset($part_3['ins_kill_charge'])) && $part_3['ins_kill_charge'] == 1) ? 'checked' : '' ?>>
                <label for="defaultCheckPart3_2" class="<?=(isset($current_reason_rig) && $current_reason_rig == 80 && ((!isset($part_3['ins_kill_charge']) || $part_3['ins_kill_charge'] == 0)) ) ? 'label-fire':'' ?>">
                    на платной основе
                </label>
            </div>

        </div>



        <div class="col-lg-2 form-group check-result-battle-part-3">

            <div class="checkbox checkbox-danger check-result-battle-part-3">
                <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 80) ? 'required' : '' ?>" type="checkbox" name="ins_kill_charge_estate" value="1" id="defaultCheckPart3_4" <?= ((isset($part_3['ins_kill_charge_estate'])) && $part_3['ins_kill_charge_estate'] == 1) ? 'checked' : '' ?>>
                <label for="defaultCheckPart3_4" class="<?=(isset($current_reason_rig) && $current_reason_rig == 80 && ((!isset($part_3['ins_kill_charge_estate']) || $part_3['ins_kill_charge_estate'] == 0)) ) ? 'label-fire':'' ?>">
                    объекты находящиеся в личной собственности граждан
                </label>
            </div>

        </div>


        <div class="col-lg-2 form-group check-result-battle-part-3">

            <div class="checkbox checkbox-danger check-result-battle-part-3">
                <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 80) ? 'required' : '' ?>" type="checkbox" name="ins_kill_charge_dog" value="1" id="defaultCheckPart3_5" <?= ((isset($part_3['ins_kill_charge_dog'])) && $part_3['ins_kill_charge_dog'] == 1) ? 'checked' : '' ?>>
                <label for="defaultCheckPart3_5" class="<?=(isset($current_reason_rig) && $current_reason_rig == 80 && ((!isset($part_3['ins_kill_charge_dog']) || $part_3['ins_kill_charge_dog'] == 0)) ) ? 'label-fire':'' ?>">
                    организации по ранее заключенным договорам
                </label>
            </div>

        </div>







    </div>



    <p class="line"><span>Случаи героизма, проявленные л/с при ликвидации ЧС</span></p>
    <div class="row">

        <div class="col-lg-2 form-group check-result-battle-part-3">

            <div class="checkbox checkbox-success check-result-battle-part-3">
                <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="hero_in" value="1" id="defaultCheckPart3_8" <?= ((isset($part_3['hero_in'])) && $part_3['hero_in'] == 1) ? 'checked' : '' ?>>
                <label for="defaultCheckPart3_8" class="<?=(isset($current_reason_rig) && $current_reason_rig == 34 && ((!isset($part_3['hero_in']) || $part_3['hero_in'] == 0))  ) ? 'label-fire':'' ?>">
                    в районе выезда подразделения
                </label>
            </div>

        </div>


        <div class="col-lg-2 form-group check-result-battle-part-3">

            <div class="checkbox checkbox-success check-result-battle-part-3">
                <input class="form-check-input <?= (isset($current_reason_rig) && $current_reason_rig == 34) ? 'required' : '' ?>" type="checkbox" name="hero_out" value="1" id="defaultCheckPart3_9" <?= ((isset($part_3['hero_out'])) && $part_3['hero_out'] == 1) ? 'checked' : '' ?>>
                <label for="defaultCheckPart3_9" class="<?=(isset($current_reason_rig) && $current_reason_rig == 34 && ((!isset($part_3['hero_out']) || $part_3['hero_out'] == 0)  ) ) ? 'label-fire':'' ?>">
                    вне района выезда подразделения
                </label>
            </div>

        </div>

    </div>

</form>