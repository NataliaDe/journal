<style>

    table tr td:first-child, td:nth-child(2){
        text-align: left;
    }
    </style>
<div class="box-body">
    <form  role="form" id="resultsBattleForm" method="POST" action="<?= $baseUrl ?>/results_battle_for_archive_2019/" >

        <ul class="nav nav-tabs">
            <li class="active">
                <a  href="#1" data-toggle="tab">Результаты боевой работы (для УМЧС)</a>
            </li>

        </ul>
        <!--------------------------------------------------- содержимое вкладок------------------------------------------>
        <div class="tab-content ">
            <br>
            <input type="hidden" class="form-control"  name="id_battle_2019" value="<?= (isset($id_battle) && !empty($id_battle)) ? $id_battle : 0  ?>" >
            * заполняется на уровне области после авторизации под своей учетной записью (логин и пароль должен быть областного уровня!)
            <center>
                <caption>С января по сентябрь 2019 года </caption>
            <table class="table table-condensed   table-bordered table-custom" style="width: 50%">
                <thead>
                    <tr>
                        <th style="width: 57px;">№ п/п</th>
                        <th>Наименование показателя</th>
                        <th>Кол-во</th>
                    </tr>
                </thead>

                <tbody>


                    <tr style="background-color: #c4c8cc">
                        <td></td>
                        <td>Всего ЧС</td>
                        <td></td>
                    </tr>

                    <tr >
                        <td>1</td>
                        <td>Техногенного характера:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="r_teh" value="<?= (isset($battle['r_teh']) && !empty($battle['r_teh'])) ? $battle['r_teh'] : 0 ?>" >
                        </td>

                    </tr>

                    <tr>
                        <td>1.1</td>
                        <td>из них на пожары:</td>

                        <td>
                         <input type="text" class="form-control int-cnt"  name="r_teh_fire" value="<?= (isset($battle['r_teh_fire']) && !empty($battle['r_teh_fire'])) ? $battle['r_teh_fire'] : 0 ?>" >
                        </td>
                    </tr>


<tr>
                        <td>1.1.1</td>
                        <td>в том числе в жилом секторе:</td>

                        <td>
                          <input type="text" class="form-control int-cnt"  name="r_life_sector" value="<?= (isset($battle['r_life_sector']) && !empty($battle['r_life_sector'])) ? $battle['r_life_sector'] : 0 ?>" >
                        </td>
                    </tr>

                    <tr>
                        <td>1.2</td>
                        <td>из них на системах жизнеобеспечения:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="r_live_support" value="<?= (isset($battle['r_live_support']) && !empty($battle['r_live_support'])) ? $battle['r_live_support'] : 0 ?>" >

                        </td>
                    </tr>



<tr>
                        <td>1.3</td>
                        <td>из них другие ЧС техногенного характера:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="r_other_teh_hs" value="<?= (isset($battle['r_other_teh_hs']) && !empty($battle['r_other_teh_hs'])) ? $battle['r_other_teh_hs'] : 0 ?>" >

                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>природного характера:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="r_nature_ltt" value="<?= (isset($battle['r_nature_ltt']) && !empty($battle['r_nature_ltt'])) ? $battle['r_nature_ltt'] : 0 ?>" >

                        </td>
                    </tr>




                    <tr style="background-color: #c4c8cc">
                        <td></td>
                        <td>Всего выездов подразделений</td>
                        <td></td>
                    </tr>


                    <tr>
                        <td>3</td>
                        <td>На ликвидацию ЧС техногенного характера:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_teh_hs" value="<?= (isset($battle['rig_teh_hs']) && !empty($battle['rig_teh_hs'])) ? $battle['rig_teh_hs'] : 0 ?>" >

                        </td>
                    </tr>


                    <tr>
                        <td>3.1</td>
                        <td>из них на пожары:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_fire" value="<?= (isset($battle['rig_fire']) && !empty($battle['rig_fire'])) ? $battle['rig_fire'] : 0 ?>" >

                        </td>
                    </tr>



<tr>
                        <td>3.2</td>
                        <td>из них на системах жизнеобеспечения:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_life" value="<?= (isset($battle['rig_life']) && !empty($battle['rig_life'])) ? $battle['rig_life'] : 0 ?>" >

                        </td>
                    </tr>

                    <tr>
                        <td>3.3</td>
                        <td>из них на другие ЧС техногенного характера:</td>

                        <td>
                             <input type="text" class="form-control int-cnt"  name="rig_other_teh_hs" value="<?= (isset($battle['rig_other_teh_hs']) && !empty($battle['rig_other_teh_hs'])) ? $battle['rig_other_teh_hs'] : 0 ?>" >

                        </td>
                    </tr>

<tr>
                        <td>4</td>
                        <td>На ликвидацию ЧС природного характера:</td>

                        <td>
                             <input type="text" class="form-control int-cnt"  name="rig_hs_nature" value="<?= (isset($battle['rig_hs_nature']) && !empty($battle['rig_hs_nature'])) ? $battle['rig_hs_nature'] : 0 ?>" >

                        </td>
                    </tr>

                    <tr>
                        <td>4.1</td>
                        <td>из них на лесные пожары:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_les" value="<?= (isset($battle['rig_les']) && !empty($battle['rig_les'])) ? $battle['rig_les'] : 0 ?>" >

                        </td>
                    </tr>

<tr>
                        <td>4.2</td>
                        <td>из них на торфяные пожары:</td>

                        <td>
                             <input type="text" class="form-control int-cnt"  name="rig_torf" value="<?= (isset($battle['rig_torf']) && !empty($battle['rig_torf'])) ? $battle['rig_torf'] : 0 ?>" >

                        </td>
                    </tr>


            <tr>
                        <td>5</td>
                        <td>На другие загорания:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_other_zagor" value="<?= (isset($battle['rig_other_zagor']) && !empty($battle['rig_other_zagor'])) ? $battle['rig_other_zagor'] : 0 ?>" >

                        </td>
                    </tr>

                    <tr>
                        <td>5.1</td>
                        <td>из них на горение сухой травы, кустарника:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_suh_trava" value="<?= (isset($battle['rig_suh_trava']) && !empty($battle['rig_suh_trava'])) ? $battle['rig_suh_trava'] : 0 ?>" >

                        </td>
                    </tr>

<tr>
                        <td>5.2</td>
                        <td>из них на горение мусора:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_musor" value="<?= (isset($battle['rig_musor']) && !empty($battle['rig_musor'])) ? $battle['rig_musor'] : 0 ?>" >

                        </td>
                    </tr>


                    <tr>
                        <td>5.3</td>
                        <td>из них на тление пищи:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_piha" value="<?= (isset($battle['rig_piha']) && !empty($battle['rig_piha'])) ? $battle['rig_piha'] : 0 ?>" >

                        </td>
                    </tr>



<tr>
                        <td>5.4</td>
                        <td>из них на короткое замыкание электропроводки:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_short_zam" value="<?= (isset($battle['rig_short_zam']) && !empty($battle['rig_short_zam'])) ? $battle['rig_short_zam'] : 0 ?>" >

                        </td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td>На оказание помощи:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_help" value="<?= (isset($battle['rig_help']) && !empty($battle['rig_help'])) ? $battle['rig_help'] : 0 ?>" >

                        </td>
                    </tr>


                    <tr>
                        <td>6.1</td>
                        <td>из них организациям:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_help_org" value="<?= (isset($battle['rig_help_org']) && !empty($battle['rig_help_org'])) ? $battle['rig_help_org'] : 0 ?>" >

                        </td>
                    </tr>


                    <tr>
                        <td>6.2</td>
                        <td>из них населению:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_help_people" value="<?= (isset($battle['rig_help_people']) && !empty($battle['rig_help_people'])) ? $battle['rig_help_people'] : 0 ?>" >

                        </td>
                    </tr>


<tr>
                        <td>7</td>
                        <td>На сигнализацию:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_signal" value="<?= (isset($battle['rig_signal']) && !empty($battle['rig_signal'])) ? $battle['rig_signal'] : 0 ?>" >

                        </td>
                    </tr>

                    <tr>
                        <td>8</td>
                        <td>Проведение демеркуризационных работ:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_demerk" value="<?= (isset($battle['rig_demerk']) && !empty($battle['rig_demerk'])) ? $battle['rig_demerk'] : 0 ?>" >

                        </td>
                    </tr>

              <tr>
                        <td>9</td>
                        <td>На занятия:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_all_zan" value="<?= (isset($battle['rig_all_zan']) && !empty($battle['rig_all_zan'])) ? $battle['rig_all_zan'] : 0 ?>" >

                        </td>
                    </tr>


                    <tr>
                        <td>9.1</td>
                        <td>ТСУ:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_tsu" value="<?= (isset($battle['rig_tsu']) && !empty($battle['rig_tsu'])) ? $battle['rig_tsu'] : 0 ?>" >

                        </td>
                    </tr>


<tr>
                        <td>9.2</td>
                        <td>ТСЗ:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_tsz" value="<?= (isset($battle['rig_tsz']) && !empty($battle['rig_tsz'])) ? $battle['rig_tsz'] : 0 ?>" >

                        </td>
                    </tr>

                    <tr>
                        <td>9.3</td>
                        <td>Другие занятия:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_other_zanyatia" value="<?= (isset($battle['rig_other_zanyatia']) && !empty($battle['rig_other_zanyatia'])) ? $battle['rig_other_zanyatia'] : 0 ?>" >

                        </td>
                    </tr>


                    <tr>
                        <td>10</td>
                        <td>На ложные:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="rig_false" value="<?= (isset($battle['rig_false']) && !empty($battle['rig_false'])) ? $battle['rig_false'] : 0 ?>" >

                        </td>
                    </tr>


                    <tr>
                        <td>11</td>
                        <td>Прочие:</td>

                        <td>
                            <input type="text" class="form-control int-cnt"  name="prohie" value="<?= (isset($battle['prohie']) && !empty($battle['prohie'])) ? $battle['prohie'] : 0 ?>" >

                        </td>
                    </tr>




                     <tr style="background-color: #c4c8cc">
                        <td></td>
                        <td>Последствия ЧС</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>12</td>
                        <td>Погибло людей при ЧС:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="dead_man" value="<?= (isset($battle['dead_man']) && !empty($battle['dead_man'])) ? $battle['dead_man'] : 0  ?>" >
                        </td>
                    </tr>

                    <tr>
                        <td>12.1</td>
                        <td>из них детей:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="dead_child" value="<?= (isset($battle['dead_child']) && !empty($battle['dead_child'])) ? $battle['dead_child'] : 0 ?>" >
                        </td>
                    </tr>

                                        <tr>
                        <td>12.2</td>
                        <td>в том числе на пожарах:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="dead_man_fire" value="<?= (isset($battle['dead_man_fire']) && !empty($battle['dead_man_fire'])) ? $battle['dead_man_fire'] : 0 ?>" >
                        </td>
                    </tr>


                                        <tr>
                        <td>1.3</td>
                        <td>из них детей:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="dead_child_fire" value="<?= (isset($battle["dead_child_fire"]) && !empty($battle["dead_child_fire"])) ? $battle["dead_child_fire"] : 0 ?>" >
                        </td>
                    </tr>


                                        <tr>
                        <td>13</td>
                        <td>Травмировано людей при ЧС:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="inj_man" value="<?= (isset($battle['inj_man']) && !empty($battle['inj_man'])) ? $battle['inj_man'] : 0 ?>" >
                        </td>
                    </tr>

                                                            <tr>
                        <td>13.1</td>
                        <td>в том числе на пожарах:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="inj_man_fire" value="<?= (isset($battle['inj_man_fire']) && !empty($battle['inj_man_fire'])) ? $battle['inj_man_fire'] : 0 ?>" >
                        </td>
                    </tr>

                                                                                <tr>
                        <td>14</td>
                        <td>Уничтожено строений в результате ЧС:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="des_build" value="<?= (isset($battle['des_build']) && !empty($battle['des_build'])) ? $battle['des_build'] : 0 ?>" >
                        </td>
                    </tr>


                                                            <tr>
                        <td>14.1</td>
                        <td>из них на пожарах:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="des_build_fire" value="<?= (isset($battle['des_build_fire']) && !empty($battle['des_build_fire'])) ? $battle['des_build_fire'] : 0 ?>" >
                        </td>
                    </tr>


                                                                                                    <tr>
                        <td>15</td>
                        <td>Повреждено строений:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="dam_build" value="<?= (isset($battle['dam_build']) && !empty($battle['dam_build'])) ? $battle['dam_build'] : 0 ?>" >
                        </td>
                    </tr>


                                                            <tr>
                        <td>15.1</td>
                        <td>из них на пожарах:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="dam_build_fire" value="<?= (isset($battle['dam_build_fire']) && !empty($battle['dam_build_fire'])) ? $battle['dam_build_fire'] : 0 ?>" >
                        </td>
                    </tr>



                                                                                                                        <tr>
                        <td>16</td>
                        <td>Уничтожено техники:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="des_teh" value="<?= (isset($battle['des_teh']) && !empty($battle['des_teh'])) ? $battle['des_teh'] : 0 ?>" >
                        </td>
                    </tr>


                                                            <tr>
                        <td>16.1</td>
                        <td>из них на пожарах:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="des_teh_fire" value="<?= (isset($battle['des_teh_fire']) && !empty($battle['des_teh_fire'])) ? $battle['des_teh_fire'] : 0 ?>" >
                        </td>
                    </tr>





                                                                                                                        <tr>
                        <td>17</td>
                        <td>Повреждено техники:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="dam_teh" value="<?= (isset($battle['dam_teh']) && !empty($battle['dam_teh'])) ? $battle['dam_teh'] : 0 ?>" >
                        </td>
                    </tr>


                                                            <tr>
                        <td>17.1</td>
                        <td>из них на пожарах:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="dam_teh_fire" value="<?= (isset($battle['dam_teh_fire']) && !empty($battle['dam_teh_fire'])) ? $battle['dam_teh_fire'] : 0 ?>" >
                        </td>
                    </tr>


                                                                                <tr>
                        <td>18</td>
                        <td>Ущерб (прямые потери), руб:</td>
                        <td>
                            <input type="text" class="form-control str-cnt"  name="dam_money" value="<?= (isset($battle['dam_money']) && !empty($battle['dam_money'])) ? $battle['dam_money'] : 0 ?>" >
                        </td>
                    </tr>

                    <tr style="background-color: #c4c8cc">
                        <td></td>
                        <td>Результаты работы</td>
                        <td>

                        </td>
                    </tr>

                                                                                                    <tr>
                        <td>19</td>
                        <td>Спасено мат.ценностей, руб:</td>
                        <td>
                            <input type="text" class="form-control str-cnt"  name="save_wealth" value="<?= (isset($battle['save_wealth']) && !empty($battle['save_wealth'])) ? $battle['save_wealth'] : 0 ?>" >
                        </td>
                    </tr>


                                                                                                                        <tr>
                        <td>20</td>
                        <td>Спасено людей:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="save_man" value="<?= (isset($battle['save_man']) && !empty($battle['save_man'])) ? $battle['save_man'] : 0 ?>" >
                        </td>
                    </tr>


                                                                                                                                            <tr>
                        <td>20.1</td>
                        <td>из них детей:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="save_child" value="<?= (isset($battle['save_child']) && !empty($battle['save_child'])) ? $battle['save_child'] : 0 ?>" >
                        </td>
                    </tr>


                                                                                                                                                                <tr>
                        <td>20.2</td>
                        <td>в том числе на пожарах:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="save_man_fire" value="<?= (isset($battle['save_man_fire']) && !empty($battle['save_man_fire'])) ? $battle['save_man_fire'] : 0 ?>" >
                        </td>
                    </tr>



                                                                                                                                                                <tr>
                        <td>20.3</td>
                        <td>из них детей:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="save_child_fire" value="<?= (isset($battle['save_child_fire']) && !empty($battle['save_child_fire'])) ? $battle['save_child_fire'] : 0 ?>" >
                        </td>
                    </tr>




                                                                                                                                                                <tr>
                        <td>20.4</td>
                        <td>в том числе подразделениями МЧС:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="save_mchs" value="<?= (isset($battle['save_mchs']) && !empty($battle['save_mchs'])) ? $battle['save_mchs'] : 0 ?>" >
                        </td>
                    </tr>




                       <td>21</td>
                        <td>Эвакуировано людей:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="ev_man" value="<?= (isset($battle['ev_man']) && !empty($battle['ev_man'])) ? $battle['ev_man'] : 0 ?>" >
                        </td>
                    </tr>


                                                                                                                                            <tr>
                        <td>21.1</td>
                        <td>из них детей:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="ev_child" value="<?= (isset($battle['ev_child']) && !empty($battle['ev_child'])) ? $battle['ev_child'] : 0 ?>" >
                        </td>
                    </tr>



                                                                                                                                            <tr>
                        <td>21.2</td>
                        <td>в том числе на пожарах:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="ev_man_fire" value="<?= (isset($battle['ev_man_fire']) && !empty($battle['ev_man_fire'])) ? $battle['ev_man_fire'] : 0 ?>" >
                        </td>
                    </tr>

                                                                                                                                                                <tr>
                        <td>21.3</td>
                        <td>из них детей:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="ev_child_fire" value="<?= (isset($battle['ev_child_fire']) && !empty($battle['ev_child_fire'])) ? $battle['ev_child_fire'] : 0 ?>" >
                        </td>
                    </tr>


                                                                                                                                                                                 <tr>
                        <td>21.4</td>
                        <td>в том числе подразделениями МЧС:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="ev_mchs" value="<?= (isset($battle['ev_mchs']) && !empty($battle['ev_mchs'])) ? $battle['ev_mchs'] : 0 ?>" >
                        </td>
                    </tr>



                                                                                                                                                                                 <tr>
                        <td>22</td>
                        <td>Спасено скота:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="save_an" value="<?= (isset($battle['save_an']) && !empty($battle['save_an'])) ? $battle['save_an'] : 0 ?>" >
                        </td>
                    </tr>




                                                                                                                                                                                 <tr>
                        <td>22.1</td>
                        <td>в том числе подразделениями МЧС:</td>
                        <td>
                            <input type="text" class="form-control int-cnt"  name="save_an_mchs" value="<?= (isset($battle['save_an_mchs']) && !empty($battle['save_an_mchs'])) ? $battle['save_an_mchs'] : 0 ?>" >
                        </td>
                    </tr>


                </tbody>
            </table>



                        <button type="submit" class="btn btn-success"> Сохранить данные</button>


</center>

            <!--            Обработка вызова-->


        </div>
        <!--                    tab-content-->

    </form>
</div>


<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?= $baseUrl ?>/assets/toastr/js/toastr.min.js"></script>
<script>

 if(<?= $is_success ?> === 1)
        toastr.success('Информация сохранена.', 'Успех!', {progressBar:     true,timeOut: 5000});
</script>




