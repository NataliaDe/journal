<?php
include 'form.php';

?>

<form  role="form"  name="np_edit_form" id="np_edit_form" >

    <center>Результат</center>

    <?php
    //print_r($selsovet);
    $k = 0;

    if (isset($locality_without_selsovet) && !empty($locality_without_selsovet)) {
        //print_r($locality_without_selsovet);
    }

    if (!empty($selsovet)) {
        foreach ($selsovet as $key => $row) {

            ?>
            <div class="row" >

                <div class="col-lg-12">
                    <div class="form-group">
                        <b><?= $row['name'] ?> с/с</b>
                    </div>
                </div>

            </div>

            <?php
            $cnt = 1;

            if (isset($row['locality']) && !empty($row['locality'])) {

                ?>

                <?php
                foreach ($row['locality'] as $loc) {
                    $k++;

                    ?>
                    <div class="row locality_row_<?= $k ?>"  id="klon<?= $k ?>">

                        <div class="col-lg-1">
                            <div class="form-group">
                                <input type="text" class="form-control np_name" placeholder="Нас. пункт" name="locality[<?= $k ?>][name]" value="<?= $loc['locality_name'] ?>" >
                            </div>
                        </div>

                        <input type="hidden" class="form-control np_selsovet" placeholder="Нас. пункт" name="locality[<?= $k ?>][id_selsovet]" value="<?= $row['id'] ?>" >


                        <div class="col-lg-1">
                            <select class="form-control chzn-select-vid np_vid" name="locality[<?= $k ?>][id_vid]"  tabindex="2" data-placeholder="Вид н.п."  >
                                <option value='' ><label></label></option>
                                <?php
                                foreach ($vid_locality as $vid) {

                                    ?>
                                    <option value="<?= $vid['id'] ?>" <?= (isset($loc['vid_id']) && $loc['vid_id'] == $vid['id']) ? 'selected' : '' ?>><?= $vid['name'] ?></option>
                                    <?php
                                }

                                ?>
                            </select>

                        </div>

                        <input type="hidden" class="form-control np_id" name="locality[<?= $k ?>][id]" value="<?= $loc['locality_id'] ?>" >


                    </div>
                    <?php
                }

                ?>
                <div class="col-lg-1">
                    <a href="#" id="add_row" data-idloc="<?= $k ?>" >+  добавить еще</a>
                </div>
                <?php
            }

            ?>


            <?php
        }
    }

    ?>

</form>

<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

<script src="<?= $baseUrl ?>/assets/chosen_v1.8.2/chosen.jquery.js" type="text/javascript"></script>

<script src="<?= $baseUrl ?>/assets/js/select2/select2.min.js" type="text/javascript" charset="utf-8"></script>

<script>
//    $(".chzn-select").chosen();
//
//    $(".chzn-select-vid").chosen({
//        allow_single_deselect: false
//    });

    $('#np_edit_form').find('.chzn-select-vid').select2({
        placeholder: "Выберите из списка",
        allowClear: true,
        "language": {
            "noResults": function () {
                return "Ничего не найдено";
            }
        }
    });




    $('body').on('click', '#add_row', function (e) {
        e.preventDefault();

        var id_loc_block = $(this).attr('data-idloc');


        //$('.locality_row_' + id_loc_block + ' select').last().chosen("destroy");

        var $div = $('div[id^="klon"]:last');
        var $div_for_clon = $('.locality_row_' + id_loc_block + ':last');

        var prev_class = $div_for_clon.attr('id');

        var prev_num = parseInt($div.prop("id").match(/\d+/g), 10);
        var num = parseInt($div.prop("id").match(/\d+/g), 10) + 1;

        var is = $('div #klon' + num);
        while ((is.length > 0)) {
            var num = num + 1;
            var is = $('div #klon' + num);
        }

        // Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
        var $klon = $div_for_clon.clone().prop('id', 'klon' + num);

        $klon.insertAfter($('.locality_row_' + id_loc_block).last());


        var $div_new = $('#klon' + num);
        $div_new.find('.np_name').attr('name', 'locality[' + num + '][name]');

        $div_new.find('.np_vid').attr('name', 'locality[' + num + '][id_vid]');
        $div_new.find('.np_id').attr('name', 'locality[' + num + '][id]');

        $div_new.find('.np_id').attr('name', 'locality[' + num + '][id]');

        $div_new.find('.np_name').val('');
        $div_new.find('.np_id').val('');



        $(id_loc_block).find('.chzn-select-vid').select2({
            placeholder: "Выберите из списка",
            allowClear: true,
            "language": {
                "noResults": function () {
                    return "Ничего не найдено";
                }
            }
        });//apply select2 to my element
        //  alert('#klon'+id_loc_block);
        $(id_loc_block).find('.chzn-select-vid').last().next().next().remove();
$(id_loc_block).find('.chzn-select-vid').val('').trigger('change');

        return false;
    });

</script>