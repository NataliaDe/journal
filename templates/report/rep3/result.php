<?php
include 'form.php';

//print_r($archive_rigs);
//print_r($archive_2019);

?>

<style>

    table tr td:first-child, td:nth-child(2){
        text-align: left;
    }
    </style>

<div class="box-body">


    <div class="tab-content ">


        <center>
            <caption><b><?= $caption ?></b></caption>
            <table class="table table-condensed   table-bordered table-custom" style="width: 50%">
                <thead>
                    <tr>
                        <th style="width: 57px;">№ п/п</th>
                        <th>Наименование показателя</th>
                        <th>За сутки</th>
                        <th>С начала<br>года</th>
                    </tr>
                </thead>

                <tbody>

                    <tr style="background-color: #c4c8cc">
                        <td></td>
                        <td><b>Всего ЧС</b></td>
                        <td ><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="1+2">
                                <?= ((isset($daily_rigs_hs['rig_teh_hs']) && !empty($daily_rigs_hs['rig_teh_hs'])) ? $daily_rigs_hs['rig_teh_hs'] : 0) +
    ((isset($daily_rigs_hs['rig_nature_ltt']) && !empty($daily_rigs_hs['rig_nature_ltt'])) ? $daily_rigs_hs['rig_nature_ltt'] : 0)  ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            ( ((isset($all_hs_journal['rig_teh_hs']) && !empty($all_hs_journal['rig_teh_hs'])) ? $all_hs_journal['rig_teh_hs'] : 0) +
                            ((isset($all_hs_journal['rig_nature_ltt']) && !empty($all_hs_journal['rig_nature_ltt'])) ? $all_hs_journal['rig_nature_ltt'] : 0) +
                            ((isset($archive_rigs['rig_all_hs']) && !empty($archive_rigs['rig_all_hs'])) ? $archive_rigs['rig_all_hs'] : 0) +
                            ((isset($archive_2019['r_teh']) && !empty($archive_2019['r_teh'])) ? $archive_2019['r_teh'] : 0) +
                            ((isset($archive_2019['r_nature_ltt']) && !empty($archive_2019['r_nature_ltt'])) ? $archive_2019['r_nature_ltt'] : 0) )

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>1</td>
                        <td>Техногенного характера:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЧС» вид работ «техногенного хар-ра» + причина выезда «пожар» + 1.2 + 1.3 ">
                                <?=     ((isset($daily_rigs_hs['rig_teh_hs']) && !empty($daily_rigs_hs['rig_teh_hs'])) ? $daily_rigs_hs['rig_teh_hs'] : 0)  ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_hs_journal['rig_teh_hs']) && !empty($all_hs_journal['rig_teh_hs'])) ? $all_hs_journal['rig_teh_hs'] : 0) +
                            ((isset($archive_rigs['rig_teh_hs']) && !empty($archive_rigs['rig_teh_hs'])) ? $archive_rigs['rig_teh_hs'] : 0) +
                            ((isset($archive_2019['r_teh']) && !empty($archive_2019['r_teh'])) ? $archive_2019['r_teh'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>1.1</td>
                        <td>из них на пожары:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «пожар»">
                                <?= ((isset($daily_rigs_hs['rig_fire']) && !empty($daily_rigs_hs['rig_fire'])) ? $daily_rigs_hs['rig_fire'] : 0)  ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_hs_journal['rig_fire']) && !empty($all_hs_journal['rig_fire'])) ? $all_hs_journal['rig_fire'] : 0) +
                            ((isset($archive_rigs['rig_fire']) && !empty($archive_rigs['rig_fire'])) ? $archive_rigs['rig_fire'] : 0) +
                            ((isset($archive_2019['r_teh_fire']) && !empty($archive_2019['r_teh_fire'])) ? $archive_2019['r_teh_fire'] : 0))

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>1.1.1</td>
                        <td>в том числе в жилом секторе:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «пожар» вид работ «на объекте ">
                                <?= ((isset($daily_rigs_hs['rig_live_sector']) && !empty($daily_rigs_hs['rig_live_sector'])) ? $daily_rigs_hs['rig_live_sector'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_hs_journal['rig_live_sector']) && !empty($all_hs_journal['rig_live_sector'])) ? $all_hs_journal['rig_live_sector'] : 0) +
                            ((isset($archive_rigs['rig_live_sector']) && !empty($archive_rigs['rig_live_sector'])) ? $archive_rigs['rig_live_sector'] : 0) +
                            ((isset($archive_2019['r_life_sector']) && !empty($archive_2019['r_life_sector'])) ? $archive_2019['r_life_sector'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>1.2</td>
                        <td>из них на системах жизнеобеспечения:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЧС» вид работ «на системах жизнеобеспечения»">
                                <?= ((isset($daily_rigs_hs['rig_live_support']) && !empty($daily_rigs_hs['rig_live_support'])) ? $daily_rigs_hs['rig_live_support'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_hs_journal['rig_live_support']) && !empty($all_hs_journal['rig_live_support'])) ? $all_hs_journal['rig_live_support'] : 0) +
                            ((isset($archive_rigs['rig_live_support']) && !empty($archive_rigs['rig_live_support'])) ? $archive_rigs['rig_live_support'] : 0) +
                            ((isset($archive_2019['r_live_support']) && !empty($archive_2019['r_live_support'])) ? $archive_2019['r_live_support'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>1.3</td>
                        <td>из них другие ЧС техногенного характера:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЧС» вид работ «другие ЧС техногенного характера»">
                                <?= ((isset($daily_rigs_hs['rig_other_teh_hs']) && !empty($daily_rigs_hs['rig_other_teh_hs'])) ? $daily_rigs_hs['rig_other_teh_hs'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_hs_journal['rig_other_teh_hs']) && !empty($all_hs_journal['rig_other_teh_hs'])) ? $all_hs_journal['rig_other_teh_hs'] : 0) +
                            ((isset($archive_rigs['rig_other_teh_hs']) && !empty($archive_rigs['rig_other_teh_hs'])) ? $archive_rigs['rig_other_teh_hs'] : 0) +
                            ((isset($archive_2019['r_other_teh_hs']) && !empty($archive_2019['r_other_teh_hs'])) ? $archive_2019['r_other_teh_hs'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>природного характера:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЛТТ», причина выезда «ЧС»+ вид работ «природного характера»">
                                <?= ((isset($daily_rigs_hs['rig_nature_ltt']) && !empty($daily_rigs_hs['rig_nature_ltt'])) ? $daily_rigs_hs['rig_nature_ltt'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_hs_journal['rig_nature_ltt']) && !empty($all_hs_journal['rig_nature_ltt'])) ? $all_hs_journal['rig_nature_ltt'] : 0) +
                            ((isset($archive_rigs['rig_nature_ltt']) && !empty($archive_rigs['rig_nature_ltt'])) ? $archive_rigs['rig_nature_ltt'] : 0) +
                            ((isset($archive_2019['r_nature_ltt']) && !empty($archive_2019['r_nature_ltt'])) ? $archive_2019['r_nature_ltt'] : 0))

                            ?>
                        </td>
                    </tr>


                    <?php
                    $all_rigs_archive_2019 = 0;
                    if (isset($archive_2019) && !empty($archive_2019)) {
                        $all_rigs_archive_2019 = $archive_2019['rig_teh_hs'] + $archive_2019['rig_hs_nature'] + $archive_2019['rig_other_zagor'] +
                            $archive_2019['rig_suh_trava'] + $archive_2019['rig_help'] + $archive_2019['rig_signal'] + $archive_2019['rig_demerk'] +
                            $archive_2019['rig_all_zan'] + $archive_2019['rig_false'];
                    }

                    ?>


                    <tr style="background-color: #c4c8cc">
                        <td></td>
                        <td><b>Всего выездов подразделений</b></td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="3 + 4 + 5 + 5.1 + 6 + 7 + 8 + 9 + 10">
                                <?= ((isset($rigs_today['all_rigs']) && !empty($rigs_today['all_rigs'])) ? $rigs_today['all_rigs'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['all_rigs']) && !empty($all_rigs_journal['all_rigs'])) ? $all_rigs_journal['all_rigs'] : 0) +
                            ((isset($archive_rigs['all_rigs']) && !empty($archive_rigs['all_rigs'])) ? $archive_rigs['all_rigs'] : 0) +
                            $all_rigs_archive_2019)

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>На ликвидацию ЧС техногенного характера:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЧС» вид работ «техногенного хар-ра» + причина выезда «пожар» + 3.2 + 3.3">
                                <?= ((isset($rigs_today['rig_teh_hs']) && !empty($rigs_today['rig_teh_hs'])) ? $rigs_today['rig_teh_hs'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_teh_hs']) && !empty($all_rigs_journal['rig_teh_hs'])) ? $all_rigs_journal['rig_teh_hs'] : 0) +
                            ((isset($archive_rigs['teh_hs']) && !empty($archive_rigs['teh_hs'])) ? $archive_rigs['teh_hs'] : 0) +
                            ((isset($archive_2019['rig_teh_hs']) && !empty($archive_2019['rig_teh_hs'])) ? $archive_2019['rig_teh_hs'] : 0))

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>3.1</td>
                        <td>из них на пожары:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «пожар»">
                                <?= ((isset($rigs_today['rig_fire']) && !empty($rigs_today['rig_fire'])) ? $rigs_today['rig_fire'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_fire']) && !empty($all_rigs_journal['rig_fire'])) ? $all_rigs_journal['rig_fire'] : 0) +
                            ((isset($archive_rigs['fire']) && !empty($archive_rigs['fire'])) ? $archive_rigs['fire'] : 0) +
                            ((isset($archive_2019['rig_fire']) && !empty($archive_2019['rig_fire'])) ? $archive_2019['rig_fire'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>3.2</td>
                        <td>из них на системах жизнеобеспечения:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЧС» вид работ «на системах жизнеобеспечения» ">
                                <?= ((isset($rigs_today['rig_life']) && !empty($rigs_today['rig_life'])) ? $rigs_today['rig_life'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_life']) && !empty($all_rigs_journal['rig_life'])) ? $all_rigs_journal['rig_life'] : 0) +
                            ((isset($archive_rigs['live_support']) && !empty($archive_rigs['live_support'])) ? $archive_rigs['live_support'] : 0) +
                            ((isset($archive_2019['rig_life']) && !empty($archive_2019['rig_life'])) ? $archive_2019['rig_life'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>3.3</td>
                        <td>из них на другие ЧС техногенного характера:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЧС» вид работ «другие ЧС техногенного характера» ">
                                <?= ((isset($rigs_today['rig_other_teh_hs']) && !empty($rigs_today['rig_other_teh_hs'])) ? $rigs_today['rig_other_teh_hs'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_other_teh_hs']) && !empty($all_rigs_journal['rig_other_teh_hs'])) ? $all_rigs_journal['rig_other_teh_hs'] : 0) +
                            ((isset($archive_rigs['other_teh_hs']) && !empty($archive_rigs['other_teh_hs'])) ? $archive_rigs['other_teh_hs'] : 0) +
                            ((isset($archive_2019['rig_other_teh_hs']) && !empty($archive_2019['rig_other_teh_hs'])) ? $archive_2019['rig_other_teh_hs'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>На ликвидацию ЧС природного характера:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЛТТ», причина выезда «ЧС»+ вид работ «природного характера»">
                                <?= ((isset($rigs_today['rig_hs_nature']) && !empty($rigs_today['rig_hs_nature'])) ? $rigs_today['rig_hs_nature'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_hs_nature']) && !empty($all_rigs_journal['rig_hs_nature'])) ? $all_rigs_journal['rig_hs_nature'] : 0) +
                            ((isset($archive_rigs['nature_hs']) && !empty($archive_rigs['nature_hs'])) ? $archive_rigs['nature_hs'] : 0) +
                            ((isset($archive_2019['rig_hs_nature']) && !empty($archive_2019['rig_hs_nature'])) ? $archive_2019['rig_hs_nature'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>4.1</td>
                        <td>из них на лесные пожары:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЛТТ – ЧС природного характера» вид работ «лес»">
                                <?= ((isset($rigs_today['rig_les']) && !empty($rigs_today['rig_les'])) ? $rigs_today['rig_les'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_les']) && !empty($all_rigs_journal['rig_les'])) ? $all_rigs_journal['rig_les'] : 0) +
                            ((isset($archive_rigs['les']) && !empty($archive_rigs['les'])) ? $archive_rigs['les'] : 0) +
                            ((isset($archive_2019['rig_les']) && !empty($archive_2019['rig_les'])) ? $archive_2019['rig_les'] : 0))

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>4.2</td>
                        <td>из них на торфяные пожары:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЛТТ – ЧС природного характера» вид работ «торф»">
                                <?= ((isset($rigs_today['rig_torf']) && !empty($rigs_today['rig_torf'])) ? $rigs_today['rig_torf'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_torf']) && !empty($all_rigs_journal['rig_torf'])) ? $all_rigs_journal['rig_torf'] : 0) +
                            ((isset($archive_rigs['torf']) && !empty($archive_rigs['torf'])) ? $archive_rigs['torf'] : 0) +
                            ((isset($archive_2019['rig_torf']) && !empty($archive_2019['rig_torf'])) ? $archive_2019['rig_torf'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>На другие загорания:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «другие загорания» все виды работ, кроме «факт горения не подтвердился»  + 5.1">
                                <?= ((isset($rigs_today['rig_other_zagor']) && !empty($rigs_today['rig_other_zagor'])) ? $rigs_today['rig_other_zagor'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_other_zagor']) && !empty($all_rigs_journal['rig_other_zagor'])) ? $all_rigs_journal['rig_other_zagor'] : 0) +
                            ((isset($archive_rigs['other_zagor']) && !empty($archive_rigs['other_zagor'])) ? $archive_rigs['other_zagor'] : 0) +
                            ((isset($archive_2019['rig_other_zagor']) && !empty($archive_2019['rig_other_zagor'])) ? $archive_2019['rig_other_zagor'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>5.1</td>
                        <td>из них на горение сухой травы, кустарника:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ЛТТ – ЧС природного характера» вид работ «трава»   и вид работ «кустарник»">
                                <?= ((isset($rigs_today['rig_suh_trava']) && !empty($rigs_today['rig_suh_trava'])) ? $rigs_today['rig_suh_trava'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_suh_trava']) && !empty($all_rigs_journal['rig_suh_trava'])) ? $all_rigs_journal['rig_suh_trava'] : 0) +
                            ((isset($archive_rigs['suh_trava']) && !empty($archive_rigs['suh_trava'])) ? $archive_rigs['suh_trava'] : 0) +
                            ((isset($archive_2019['rig_suh_trava']) && !empty($archive_2019['rig_suh_trava'])) ? $archive_2019['rig_suh_trava'] : 0))

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>5.2</td>
                        <td>из них на горение мусора:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «другие загорания» вид  работ «мусор» и «мусор контролируемое сжигание»">
                                <?= ((isset($rigs_today['rig_musor']) && !empty($rigs_today['rig_musor'])) ? $rigs_today['rig_musor'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_musor']) && !empty($all_rigs_journal['rig_musor'])) ? $all_rigs_journal['rig_musor'] : 0) +
                            ((isset($archive_rigs['musor']) && !empty($archive_rigs['musor'])) ? $archive_rigs['musor'] : 0) +
                            ((isset($archive_2019['rig_musor']) && !empty($archive_2019['rig_musor'])) ? $archive_2019['rig_musor'] : 0))

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>5.3</td>
                        <td>из них на тление пищи:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «другие загорания» вид  работ «пища на газ.плите» и «пища на эл.плите контролируемое сжигание»">
                                <?= ((isset($rigs_today['rig_piha']) && !empty($rigs_today['rig_piha'])) ? $rigs_today['rig_piha'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_piha']) && !empty($all_rigs_journal['rig_piha'])) ? $all_rigs_journal['rig_piha'] : 0) +
                            ((isset($archive_rigs['piha']) && !empty($archive_rigs['piha'])) ? $archive_rigs['piha'] : 0) +
                            ((isset($archive_2019['rig_piha']) && !empty($archive_2019['rig_piha'])) ? $archive_2019['rig_piha'] : 0))

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>5.4</td>
                        <td>из них на короткое замыкание электропроводки:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «другие загорания» вид  работ «короткое замыкание эл.проводки» ">
                                <?= ((isset($rigs_today['rig_short_zam']) && !empty($rigs_today['rig_short_zam'])) ? $rigs_today['rig_short_zam'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_short_zam']) && !empty($all_rigs_journal['rig_short_zam'])) ? $all_rigs_journal['rig_short_zam'] : 0) +
                            ((isset($archive_rigs['short_zam']) && !empty($archive_rigs['short_zam'])) ? $archive_rigs['short_zam'] : 0) +
                            ((isset($archive_2019['rig_short_zam']) && !empty($archive_2019['rig_short_zam'])) ? $archive_2019['rig_short_zam'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td>На оказание помощи:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="6.1 + 6.2">
                                <?= ((isset($rigs_today['rig_help']) && !empty($rigs_today['rig_help'])) ? $rigs_today['rig_help'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_help']) && !empty($all_rigs_journal['rig_help'])) ? $all_rigs_journal['rig_help'] : 0) +
                            ((isset($archive_rigs['help_r']) && !empty($archive_rigs['help_r'])) ? $archive_rigs['help_r'] : 0) +
                            ((isset($archive_2019['rig_help']) && !empty($archive_2019['rig_help'])) ? $archive_2019['rig_help'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>6.1</td>
                        <td>из них организациям:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «помощь организациям»">
                                <?= ((isset($rigs_today['rig_help_org']) && !empty($rigs_today['rig_help_org'])) ? $rigs_today['rig_help_org'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_help_org']) && !empty($all_rigs_journal['rig_help_org'])) ? $all_rigs_journal['rig_help_org'] : 0) +
                            ((isset($archive_rigs['help_org']) && !empty($archive_rigs['help_org'])) ? $archive_rigs['help_org'] : 0) +
                            ((isset($archive_2019['rig_help_org']) && !empty($archive_2019['rig_help_org'])) ? $archive_2019['rig_help_org'] : 0))

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>6.2</td>
                        <td>из них населению:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «помощь населению»">
                                <?= ((isset($rigs_today['rig_help_people']) && !empty($rigs_today['rig_help_people'])) ? $rigs_today['rig_help_people'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_help_people']) && !empty($all_rigs_journal['rig_help_people'])) ? $all_rigs_journal['rig_help_people'] : 0) +
                            ((isset($archive_rigs['help_people']) && !empty($archive_rigs['help_people'])) ? $archive_rigs['help_people'] : 0) +
                            ((isset($archive_2019['rig_help_people']) && !empty($archive_2019['rig_help_people'])) ? $archive_2019['rig_help_people'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>7</td>
                        <td>На сигнализацию:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «другие сигнализации»  и «молния»">
                                <?= ((isset($rigs_today['rig_signal']) && !empty($rigs_today['rig_signal'])) ? $rigs_today['rig_signal'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_signal']) && !empty($all_rigs_journal['rig_signal'])) ? $all_rigs_journal['rig_signal'] : 0) +
                            ((isset($archive_rigs['signal_r']) && !empty($archive_rigs['signal_r'])) ? $archive_rigs['signal_r'] : 0) +
                            ((isset($archive_2019['rig_signal']) && !empty($archive_2019['rig_signal'])) ? $archive_2019['rig_signal'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>8</td>
                        <td>Проведение демеркуризационных работ:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «демеркуризация»">
                                <?= ((isset($rigs_today['rig_demerk']) && !empty($rigs_today['rig_demerk'])) ? $rigs_today['rig_demerk'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_demerk']) && !empty($all_rigs_journal['rig_demerk'])) ? $all_rigs_journal['rig_demerk'] : 0) +
                            ((isset($archive_rigs['demerk']) && !empty($archive_rigs['demerk'])) ? $archive_rigs['demerk'] : 0) +
                            ((isset($archive_2019['rig_demerk']) && !empty($archive_2019['rig_demerk'])) ? $archive_2019['rig_demerk'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>9</td>
                        <td>На занятия:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «занятия»">
                                <?= ((isset($rigs_today['rig_all_zan']) && !empty($rigs_today['rig_all_zan'])) ? $rigs_today['rig_all_zan'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_all_zan']) && !empty($all_rigs_journal['rig_all_zan'])) ? $all_rigs_journal['rig_all_zan'] : 0) +
                            ((isset($archive_rigs['zanyatia']) && !empty($archive_rigs['zanyatia'])) ? $archive_rigs['zanyatia'] : 0) +
                            ((isset($archive_2019['rig_all_zan']) && !empty($archive_2019['rig_all_zan'])) ? $archive_2019['rig_all_zan'] : 0))

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>9.1</td>
                        <td>ТСУ:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «занятия»  вид работ «ТСУ»">
                                <?= ((isset($rigs_today['rig_tsu']) && !empty($rigs_today['rig_tsu'])) ? $rigs_today['rig_tsu'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_tsu']) && !empty($all_rigs_journal['rig_tsu'])) ? $all_rigs_journal['rig_tsu'] : 0) +
                            ((isset($archive_rigs['tsu']) && !empty($archive_rigs['tsu'])) ? $archive_rigs['tsu'] : 0) +
                            ((isset($archive_2019['rig_tsu']) && !empty($archive_2019['rig_tsu'])) ? $archive_2019['rig_tsu'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>9.2</td>
                        <td>ТСЗ:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «занятия»  вид работ «ТСЗ»">
                                <?= ((isset($rigs_today['rig_tsz']) && !empty($rigs_today['rig_tsz'])) ? $rigs_today['rig_tsz'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_tsz']) && !empty($all_rigs_journal['rig_tsz'])) ? $all_rigs_journal['rig_tsz'] : 0) +
                            ((isset($archive_rigs['tsz']) && !empty($archive_rigs['tsz'])) ? $archive_rigs['tsz'] : 0) +
                            ((isset($archive_2019['rig_tsz']) && !empty($archive_2019['rig_tsz'])) ? $archive_2019['rig_tsz'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>9.3</td>
                        <td>Другие занятия:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="9 – 9.1 – 9.2">
                                <?= ((isset($rigs_today['rig_other_zanyatia']) && !empty($rigs_today['rig_other_zanyatia'])) ? $rigs_today['rig_other_zanyatia'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_other_zanyatia']) && !empty($all_rigs_journal['rig_other_zanyatia'])) ? $all_rigs_journal['rig_other_zanyatia'] : 0 ) +
                            ((isset($archive_rigs['other_zan']) && !empty($archive_rigs['other_zan'])) ? $archive_rigs['other_zan'] : 0) +
                            ((isset($archive_2019['rig_other_zanyatia']) && !empty($archive_2019['rig_other_zanyatia'])) ? $archive_2019['rig_other_zanyatia'] : 0))

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>10</td>
                        <td>На ложные:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="причина выезда «ложный»">
                                <?= ((isset($rigs_today['rig_false']) && !empty($rigs_today['rig_false'])) ? $rigs_today['rig_false'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['rig_false']) && !empty($all_rigs_journal['rig_false'])) ? $all_rigs_journal['rig_false'] : 0) +
                            ((isset($archive_rigs['false_r']) && !empty($archive_rigs['false_r'])) ? $archive_rigs['false_r'] : 0) +
                            ((isset($archive_2019['rig_false']) && !empty($archive_2019['rig_false'])) ? $archive_2019['rig_false'] : 0))

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>11</td>
                        <td>Прочие:</td>
                        <td><span aria-hidden="true" data-toggle="tooltip" data-placement="right" title="все выезды – 3 – 4 – 5 -5.1 – 6 – 7 – 8 – 9 - 10">
                                <?= ((isset($rigs_today['prohie']) && !empty($rigs_today['prohie'])) ? $rigs_today['prohie'] : 0) ?>
                            </span>
                        </td>
                        <td>
                            <?=
                            (((isset($all_rigs_journal['prohie']) && !empty($all_rigs_journal['prohie'])) ? $all_rigs_journal['prohie'] : 0) +
                            ((isset($archive_rigs['prohie']) && !empty($archive_rigs['prohie'])) ? $archive_rigs['prohie'] : 0) +
                            ((isset($archive_2019['prohie']) && !empty($archive_2019['prohie'])) ? $archive_2019['prohie'] : 0))

                            ?>
                        </td>
                    </tr>


                    <!----------------- posledstvia ------------------------->

                    <tr style="background-color: #c4c8cc">
                        <td></td>
                        <td><b>Последствия ЧС</b></td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>

                    <tr>
                        <td>12</td>
                        <td>Погибло людей при ЧС:</td>
                        <td>
                            <?= ((isset($daily_current['dead_man']) && !empty($daily_current['dead_man'])) ? $daily_current['dead_man'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            ((isset($daily_archive['cnt_dead_man']) && !empty($daily_archive['cnt_dead_man'])) ? $daily_archive['cnt_dead_man'] : 0) + ((isset($all_days_journal_mans['dead_man']) && !empty($all_days_journal_mans['dead_man'])) ? $all_days_journal_mans['dead_man'] : 0) +
                            ((isset($archive_2019['dead_man']) && !empty($archive_2019['dead_man'])) ? $archive_2019['dead_man'] : 0)

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>12.1</td>
                        <td>из них детей:</td>
                        <td>
                            <?= ((isset($daily_current['dead_child']) && !empty($daily_current['dead_child'])) ? $daily_current['dead_child'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_dead_child']) && !empty($daily_archive['cnt_dead_child']) ? $daily_archive['cnt_dead_child'] : 0) + (isset($all_days_journal_mans['dead_child']) && !empty($all_days_journal_mans['dead_child']) ? $all_days_journal_mans['dead_child'] : 0) +
                            ((isset($archive_2019['dead_child']) && !empty($archive_2019['dead_child'])) ? $archive_2019['dead_child'] : 0)

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>12.2</td>
                        <td>в том числе на пожарах:</td>
                        <td>
                            <?= ((isset($daily_current['dead_man_fire']) && !empty($daily_current['dead_man_fire'])) ? $daily_current['dead_man_fire'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_dead_man_fire']) && !empty($daily_archive['cnt_dead_man_fire']) ? $daily_archive['cnt_dead_man_fire'] : 0) + ((isset($all_days_journal_mans['dead_man_fire']) && !empty($all_days_journal_mans['dead_man_fire'])) ? $all_days_journal_mans['dead_man_fire'] : 0) +
                            ((isset($archive_2019['dead_man_fire']) && !empty($archive_2019['dead_man_fire'])) ? $archive_2019['dead_man_fire'] : 0)

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>12.3</td>
                        <td>из них детей:</td>
                        <td>
                            <?= ((isset($daily_current['dead_child_fire']) && !empty($daily_current['dead_child_fire'])) ? $daily_current['dead_child_fire'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_dead_child_fire']) && !empty($daily_archive['cnt_dead_child_fire']) ? $daily_archive['cnt_dead_child_fire'] : 0) + ((isset($all_days_journal_mans['dead_child_fire']) && !empty($all_days_journal_mans['dead_child_fire'])) ? $all_days_journal_mans['dead_child_fire'] : 0) +
                            ((isset($archive_2019['dead_child_fire']) && !empty($archive_2019['dead_child_fire'])) ? $archive_2019['dead_child_fire'] : 0)

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>13</td>
                        <td>Травмировано людей при ЧС:</td>
                        <td>
                            <?= ((isset($daily_current['inj_man']) && !empty($daily_current['inj_man'])) ? $daily_current['inj_man'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_inj_man']) && !empty($daily_archive['cnt_inj_man']) ? $daily_archive['cnt_inj_man'] : 0) + ((isset($all_days_journal_mans['inj_man']) && !empty($all_days_journal_mans['inj_man'])) ? $all_days_journal_mans['inj_man'] : 0) +
                            ((isset($archive_2019['inj_man']) && !empty($archive_2019['inj_man'])) ? $archive_2019['inj_man'] : 0)

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>13.1</td>
                        <td>в том числе на пожарах:</td>
                        <td>
                            <?= ((isset($daily_current['inj_man_fire']) && !empty($daily_current['inj_man_fire'])) ? $daily_current['inj_man_fire'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_inj_man_fire']) && !empty($daily_archive['cnt_inj_man_fire']) ? $daily_archive['cnt_inj_man_fire'] : 0) + ((isset($all_days_journal_mans['inj_man_fire']) && !empty($all_days_journal_mans['inj_man_fire'])) ? $all_days_journal_mans['inj_man_fire'] : 0 ) +
                            ((isset($archive_2019['inj_man_fire']) && !empty($archive_2019['inj_man_fire'])) ? $archive_2019['inj_man_fire'] : 0)

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>14</td>
                        <td>Уничтожено строений в результате ЧС:</td>
                        <td>
                            <?= ((isset($daily_current['des_build']) && !empty($daily_current['des_build'])) ? $daily_current['des_build'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_des_build']) && !empty($daily_archive['cnt_des_build']) ? $daily_archive['cnt_des_build'] : 0) + ((isset($all_days_journal_mans['des_build']) && !empty($all_days_journal_mans['des_build'])) ? $all_days_journal_mans['des_build'] : 0) +
                            ((isset($archive_2019['des_build']) && !empty($archive_2019['des_build'])) ? $archive_2019['des_build'] : 0)

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>14.1</td>
                        <td>из них на пожарах:</td>
                        <td>
                            <?= ((isset($daily_current['des_build_fire']) && !empty($daily_current['des_build_fire'])) ? $daily_current['des_build_fire'] : 0) ?>
                        </td>

                        <td>
                            <?=
                            (isset($daily_archive['cnt_des_build_fire']) && !empty($daily_archive['cnt_des_build_fire']) ? $daily_archive['cnt_des_build_fire'] : 0) + (isset($all_days_journal_mans['des_build_fire']) && !empty($all_days_journal_mans['des_build_fire']) ? $all_days_journal_mans['des_build_fire'] : 0) +
                            ((isset($archive_2019['des_build_fire']) && !empty($archive_2019['des_build_fire'])) ? $archive_2019['des_build_fire'] : 0)

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>15</td>
                        <td>Повреждено строений:</td>
                        <td>
                            <?= ((isset($daily_current['dam_build']) && !empty($daily_current['dam_build'])) ? $daily_current['dam_build'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_dam_build']) && !empty($daily_archive['cnt_dam_build']) ? $daily_archive['cnt_dam_build'] : 0) + (isset($all_days_journal_mans['dam_build']) && !empty($all_days_journal_mans['dam_build']) ? $all_days_journal_mans['dam_build'] : 0) +
                            ((isset($archive_2019['dam_build']) && !empty($archive_2019['dam_build'])) ? $archive_2019['dam_build'] : 0)

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>15.1</td>
                        <td>из них на пожарах:</td>
                        <td>
                            <?= ((isset($daily_current['dam_build_fire']) && !empty($daily_current['dam_build_fire'])) ? $daily_current['dam_build_fire'] : 0) ?>
                        </td>

                        <td>
                            <?=
                            (isset($daily_archive['cnt_dam_build_fire']) && !empty($daily_archive['cnt_dam_build_fire']) ? $daily_archive['cnt_dam_build_fire'] : 0) + (isset($all_days_journal_mans['dam_build_fire']) && !empty($all_days_journal_mans['dam_build_fire']) ? $all_days_journal_mans['dam_build_fire'] : 0) +
                            ((isset($archive_2019['dam_build_fire']) && !empty($archive_2019['dam_build_fire'])) ? $archive_2019['dam_build_fire'] : 0)

                            ?>
                        </td>
                    </tr>



                    <tr>
                        <td>16</td>
                        <td>Уничтожено техники:</td>
                        <td>
                            <?= ((isset($daily_current['des_teh']) && !empty($daily_current['des_teh'])) ? $daily_current['des_teh'] : 0) ?>
                        </td>

                        <td>
                            <?=
                            (isset($daily_archive['cnt_des_teh']) && !empty($daily_archive['cnt_des_teh']) ? $daily_archive['cnt_des_teh'] : 0) + (isset($all_days_journal_mans['des_teh']) && !empty($all_days_journal_mans['des_teh']) ? $all_days_journal_mans['des_teh'] : 0) +
                            ((isset($archive_2019['des_teh']) && !empty($archive_2019['des_teh'])) ? $archive_2019['des_teh'] : 0)

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>16.1</td>
                        <td>из них на пожарах:</td>
                        <td>
                            <?=((isset($daily_current['des_teh_fire']) && !empty($daily_current['des_teh_fire'])) ? $daily_current['des_teh_fire'] : 0) ?>
                        </td>

                        <td>
                            <?=
                            (isset($daily_archive['cnt_des_teh_fire']) && !empty($daily_archive['cnt_des_teh_fire']) ? $daily_archive['cnt_des_teh_fire'] : 0) + (isset($all_days_journal_mans['des_teh_fire']) && !empty($all_days_journal_mans['des_teh_fire']) ? $all_days_journal_mans['des_teh_fire'] : 0) +
                            ((isset($archive_2019['des_teh_fire']) && !empty($archive_2019['des_teh_fire'])) ? $archive_2019['des_teh_fire'] : 0)

                            ?>
                        </td>
                    </tr>





                    <tr>
                        <td>17</td>
                        <td>Повреждено техники:</td>
                        <td>
                            <?= ((isset($daily_current['dam_teh']) && !empty($daily_current['dam_teh'])) ? $daily_current['dam_teh'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_dam_teh']) && !empty($daily_archive['cnt_dam_teh']) ? $daily_archive['cnt_dam_teh'] : 0) + (isset($all_days_journal_mans['dam_teh']) && !empty($all_days_journal_mans['dam_teh']) ? $all_days_journal_mans['dam_teh'] : 0) +
                            ((isset($archive_2019['dam_teh']) && !empty($archive_2019['dam_teh'])) ? $archive_2019['dam_teh'] : 0)

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>17.1</td>
                        <td>из них на пожарах:</td>
                        <td>
                            <?= ((isset($daily_current['dam_teh_fire']) && !empty($daily_current['dam_teh_fire'])) ? $daily_current['dam_teh_fire'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_dam_teh_fire']) && !empty($daily_archive['cnt_dam_teh_fire']) ? $daily_archive['cnt_dam_teh_fire'] : 0) + (isset($all_days_journal_mans['dam_teh_fire']) && !empty($all_days_journal_mans['dam_teh_fire']) ? $all_days_journal_mans['dam_teh_fire'] : 0) +
                            ((isset($archive_2019['dam_teh_fire']) && !empty($archive_2019['dam_teh_fire'])) ? $archive_2019['dam_teh_fire'] : 0)

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>18</td>
                        <td>Ущерб (прямые потери), руб:</td>
                        <td>
                            <?= ((isset($daily_current['dam_money']) && !empty($daily_current['dam_money'])) ? $daily_current['dam_money'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_dam_money']) && !empty($daily_archive['cnt_dam_money']) ? $daily_archive['cnt_dam_money'] : 0) + (isset($all_days_journal_mans['dam_money']) && !empty($all_days_journal_mans['dam_money']) ? $all_days_journal_mans['dam_money'] : 0) +
                            ((isset($archive_2019['dam_money']) && !empty($archive_2019['dam_money'])) ? $archive_2019['dam_money'] : 0)

                            ?>
                        </td>
                    </tr>


                    <!----------------- results battle ------------------------->

                    <tr style="background-color: #c4c8cc">
                        <td></td>
                        <td><b>Результаты работы</b></td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>

                    <tr>
                        <td>19</td>
                        <td>Спасено мат.ценностей, руб:</td>
                        <td>
                            <?= ((isset($daily_current['save_wealth']) && !empty($daily_current['save_wealth'])) ? $daily_current['save_wealth'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_save_wealth']) && !empty($daily_archive['cnt_save_wealth']) ? $daily_archive['cnt_save_wealth'] : 0) + (isset($all_days_journal_mans['save_wealth']) && !empty($all_days_journal_mans['save_wealth']) ? $all_days_journal_mans['save_wealth'] : 0) +
                            ((isset($archive_2019['save_wealth']) && !empty($archive_2019['save_wealth'])) ? $archive_2019['save_wealth'] : 0)

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>20</td>
                        <td>Спасено людей:</td>
                        <td>
                            <?= ((isset($daily_current['save_man']) && !empty($daily_current['save_man'])) ? $daily_current['save_man'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_save_man']) && !empty($daily_archive['cnt_save_man']) ? $daily_archive['cnt_save_man'] : 0) + (isset($all_days_journal_mans['save_man']) && !empty($all_days_journal_mans['save_man']) ? $all_days_journal_mans['save_man'] : 0) +
                            ((isset($archive_2019['save_man']) && !empty($archive_2019['save_man'])) ? $archive_2019['save_man'] : 0)

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>20.1</td>
                        <td>из них детей:</td>
                        <td>
                            <?= ((isset($daily_current['save_child']) && !empty($daily_current['save_child'])) ? $daily_current['save_child'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_save_child']) && !empty($daily_archive['cnt_save_child']) ? $daily_archive['cnt_save_child'] : 0) + (isset($all_days_journal_mans['save_child']) && !empty($all_days_journal_mans['save_child']) ? $all_days_journal_mans['save_child'] : 0) +
                            ((isset($archive_2019['save_child']) && !empty($archive_2019['save_child'])) ? $archive_2019['save_child'] : 0)

                            ?>
                        </td>
                    </tr>


                    <tr>
                        <td>20.2</td>
                        <td>в том числе на пожарах:</td>
                        <td>
                            <?= ((isset($daily_current['save_man_fire']) && !empty($daily_current['save_man_fire'])) ? $daily_current['save_man_fire'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_save_man_fire']) && !empty($daily_archive['cnt_save_man_fire']) ? $daily_archive['cnt_save_man_fire'] : 0) + (isset($all_days_journal_mans['save_man_fire']) && !empty($all_days_journal_mans['save_man_fire']) ? $all_days_journal_mans['save_man_fire'] : 0) +
                            ((isset($archive_2019['save_man_fire']) && !empty($archive_2019['save_man_fire'])) ? $archive_2019['save_man_fire'] : 0)

                            ?>
                        </td>
                    </tr>



                    <tr>
                        <td>20.3</td>
                        <td>из них детей:</td>
                        <td>
                            <?= ((isset($daily_current['save_child_fire']) && !empty($daily_current['save_child_fire'])) ? $daily_current['save_child_fire'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_save_child_fire']) && !empty($daily_archive['cnt_save_child_fire']) ? $daily_archive['cnt_save_child_fire'] : 0) + (isset($all_days_journal_mans['save_child_fire']) && !empty($all_days_journal_mans['save_child_fire']) ? $all_days_journal_mans['save_child_fire'] : 0) +
                            ((isset($archive_2019['save_child_fire']) && !empty($archive_2019['save_child_fire'])) ? $archive_2019['save_child_fire'] : 0)

                            ?>
                        </td>

                    </tr>




                    <tr>
                        <td>20.4</td>
                        <td>в том числе подразделениями МЧС:</td>
                        <td>
                            <?=((isset($daily_current['save_mchs']) && !empty($daily_current['save_mchs'])) ? $daily_current['save_mchs'] : 0) ?>
                        </td>
                        <td>
                            <?=
                            (isset($daily_archive['cnt_save_mchs']) && !empty($daily_archive['cnt_save_mchs']) ? $daily_archive['cnt_save_mchs'] : 0) + (isset($all_days_journal_mans['save_mchs']) && !empty($all_days_journal_mans['save_mchs']) ? $all_days_journal_mans['save_mchs'] : 0) +
                            ((isset($archive_2019['save_mchs']) && !empty($archive_2019['save_mchs'])) ? $archive_2019['save_mchs'] : 0)

                            ?>
                        </td>
                    </tr>




                <td>21</td>
                <td>Эвакуировано людей:</td>
                <td>
                    <?= ((isset($daily_current['ev_man']) && !empty($daily_current['ev_man'])) ? $daily_current['ev_man'] : 0) ?>
                </td>
                <td>
                    <?=
                    (isset($daily_archive['cnt_ev_man']) && !empty($daily_archive['cnt_ev_man']) ? $daily_archive['cnt_ev_man'] : 0) + (isset($all_days_journal_mans['ev_man']) && !empty($all_days_journal_mans['ev_man']) ? $all_days_journal_mans['ev_man'] : 0) +
                    ((isset($archive_2019['ev_man']) && !empty($archive_2019['ev_man'])) ? $archive_2019['ev_man'] : 0)

                    ?>
                </td>
                </tr>


                <tr>
                    <td>21.1</td>
                    <td>из них детей:</td>
                    <td>
                        <?=((isset($daily_current['ev_child']) && !empty($daily_current['ev_child'])) ? $daily_current['ev_child'] : 0) ?>
                    </td>
                    <td>
                        <?=
                        (isset($daily_archive['cnt_ev_child']) && !empty($daily_archive['cnt_ev_child']) ? $daily_archive['cnt_ev_child'] : 0) + (isset($all_days_journal_mans['ev_child']) && !empty($all_days_journal_mans['ev_child']) ? $all_days_journal_mans['ev_child'] : 0) +
                        ((isset($archive_2019['ev_child']) && !empty($archive_2019['ev_child'])) ? $archive_2019['ev_child'] : 0)

                        ?>
                    </td>
                </tr>



                <tr>
                    <td>21.2</td>
                    <td>в том числе на пожарах:</td>
                    <td>
                        <?= ((isset($daily_current['ev_man_fire']) && !empty($daily_current['ev_man_fire'])) ? $daily_current['ev_man_fire'] : 0) ?>
                    </td>
                    <td>
                        <?=
                        (isset($daily_archive['cnt_ev_man_fire']) && !empty($daily_archive['cnt_ev_man_fire']) ? $daily_archive['cnt_ev_man_fire'] : 0) + (isset($all_days_journal_mans['ev_man_fire']) && !empty($all_days_journal_mans['ev_man_fire']) ? $all_days_journal_mans['ev_man_fire'] : 0) +
                        ((isset($archive_2019['ev_man_fire']) && !empty($archive_2019['ev_man_fire'])) ? $archive_2019['ev_man_fire'] : 0)

                        ?>
                    </td>
                </tr>

                <tr>
                    <td>21.3</td>
                    <td>из них детей:</td>
                    <td>
                        <?=((isset($daily_current['ev_child_fire']) && !empty($daily_current['ev_child_fire'])) ? $daily_current['ev_child_fire'] : 0) ?>
                    </td>
                    <td>
                        <?=
                        (isset($daily_archive['cnt_ev_child_fire']) && !empty($daily_archive['cnt_ev_child_fire']) ? $daily_archive['cnt_ev_child_fire'] : 0) + (isset($all_days_journal_mans['ev_child_fire']) && !empty($all_days_journal_mans['ev_child_fire']) ? $all_days_journal_mans['ev_child_fire'] : 0) +
                        ((isset($archive_2019['ev_child_fire']) && !empty($archive_2019['ev_child_fire'])) ? $archive_2019['ev_child_fire'] : 0)

                        ?>
                    </td>
                </tr>


                <tr>
                    <td>21.4</td>
                    <td>в том числе подразделениями МЧС:</td>
                    <td>
                        <?= ((isset($daily_current['ev_mchs']) && !empty($daily_current['ev_mchs'])) ? $daily_current['ev_mchs'] : 0) ?>
                    </td>
                    <td>
                        <?=
                        (isset($daily_archive['cnt_ev_mchs']) && !empty($daily_archive['cnt_ev_mchs']) ? $daily_archive['cnt_ev_mchs'] : 0) + (isset($all_days_journal_mans['ev_mchs']) && !empty($all_days_journal_mans['ev_mchs']) ? $all_days_journal_mans['ev_mchs'] : 0) +
                        ((isset($archive_2019['ev_mchs']) && !empty($archive_2019['ev_mchs'])) ? $archive_2019['ev_mchs'] : 0)

                        ?>
                    </td>
                </tr>



                <tr>
                    <td>22</td>
                    <td>Спасено скота:</td>
                    <td>
                        <?= ((isset($daily_current['save_an']) && !empty($daily_current['save_an'])) ? $daily_current['save_an'] : 0) ?>
                    </td>
                    <td>
                        <?=
                        (isset($daily_archive['cnt_save_an']) && !empty($daily_archive['cnt_save_an']) ? $daily_archive['cnt_save_an'] : 0) + (isset($all_days_journal_mans['save_an']) && !empty($all_days_journal_mans['save_an']) ? $all_days_journal_mans['save_an'] : 0) +
                        ((isset($archive_2019['save_an']) && !empty($archive_2019['save_an'])) ? $archive_2019['save_an'] : 0)

                        ?>
                    </td>
                </tr>




                <tr>
                    <td>22.1</td>
                    <td>в том числе подразделениями МЧС:</td>
                    <td>
                        <?= ((isset($daily_current['save_an_mchs']) && !empty($daily_current['save_an_mchs'])) ? $daily_current['save_an_mchs'] : 0) ?>
                    </td>
                    <td>
                        <?=
                        (isset($daily_archive['cnt_save_an_mchs']) && !empty($daily_archive['cnt_save_an_mchs']) ? $daily_archive['cnt_save_an_mchs'] : 0) + (isset($all_days_journal_mans['save_an_mchs']) && !empty($all_days_journal_mans['save_an_mchs']) ? $all_days_journal_mans['save_an_mchs'] : 0) +
                        ((isset($archive_2019['save_an_mchs']) && !empty($archive_2019['save_an_mchs'])) ? $archive_2019['save_an_mchs'] : 0)

                        ?>
                    </td>
                </tr>


                </tbody>
            </table>

        </center>

    </div>

</div>
