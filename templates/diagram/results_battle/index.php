<div class="box-body">
<!--    filter 1-->
    <?php
    include 'form_year.php';

    ?>

<style>
    .empty-data{
        color: red;
        font-weight: 700;
        text-align: center;
    }

    .download-diagram{
        padding-left: 90px;
        padding-right: 15px;
    }

    .border-diag{
        border: 1px solid #00a65a;
        padding: 10px 0px 10px 0px;
    }
    .save-as-img-ul{
        min-width: 127px !important;

    }
    .save-as-img-li{
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
    .save-as-img-i{
        margin-right: 5px !important;
    }
</style>

    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/js/select2/select2.min.css">

    <script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?= $baseUrl ?>/assets/js/Chart.bundle.js"></script>
    <script src="<?= $baseUrl ?>/assets/js/FileSaver.js"></script>
    <script src="<?= $baseUrl ?>/assets/js/canvas-toBlob.js"></script>
    <script src="<?= $baseUrl ?>/assets/js/select2/select2.min.js" type="text/javascript" charset="utf-8"></script>

    <div class="tab-content " id="year-diag-div">

        <?php
        include 'parts/div-year-diag.php';

        ?>
    </div>
    <br>
    <hr>
<!--    filter 2-->
    <?php
    include 'form.php';

    ?>



    <div class="tab-content " id="all-diag-div">
        <?php
        include 'parts/div-all-diag.php';

        ?>
    </div>

</div>


<script>

    $(document).ready(function () {
        $('.select2-single-form').select2();
    });

    $(document).ready(function () {
        $('.select2-multiple-form').select2();
    });

    function update(all = 0) {

        var data = {};

        if (all === 1 || all === 2) {

            data = $("#diagramResBattleForm").serializeArray();
            var arr_obl_local = $("#diag-by-obl-form").serializeArray();
            data = $.merge(data, arr_obl_local);

            data.push({name: 'all', value: all});
            // data.push({name: 'reset_filter',  value: reset_filter});

            // $.post('/diagram_results_battle', $("#courses-filter").serialize(), function (res) {
            $.post('<?= $baseUrl ?>/diagram_results_battle', data, function (res) {

                if (all === 1) {//update all diags

                    $("#all-diag-div").html('');
                    $("#all-diag-div").html(res);


                } else if (all === 2) {//update div by obl

                    $("#diag-by-obl-div").html('');
                    $("#diag-by-obl-div").html(res);
                }

            });

        } else if (all === 3) {//update div by year

            data = $("#diagramResBattleFormYear").serializeArray();
            data.push({name: 'all', value: all});

            $.post('<?= $baseUrl ?>/diagram_results_battle', data, function (res) {
                $("#diag-by-rb-year-div").html('');
                $("#diag-by-rb-year-div").html(res);
            });
    }
    }


    function resetFilter(all = 0) {

        var cur_year = new Date().getFullYear();
        var cur_month =<?= date('m') ?>;

        if (all === 1) {//update all diags

            $('form#diagramResBattleForm #id-year').val(cur_year);
            $('form#diagramResBattleForm #id-year').trigger('change');

            $('form#diagramResBattleForm #id-month').val(cur_month);
            $('form#diagramResBattleForm #id-month').trigger('change');

            $('form#diagramResBattleForm #type-save-id').val([]).trigger('change');
            //  $('form#diagramResBattleForm #type-save-id').trigger('change');

        } else if (all === 2) {//update div by obl

            $('form#diag-by-obl-form #id_region_diag').val('');
            $('form#diag-by-obl-form #id_region_diag').trigger('change');



        } else if (all === 3) {//update div by year - block 1

            $('form#diagramResBattleFormYear #id-year-year').val(cur_year);
            $('form#diagramResBattleFormYear #id-year-year').trigger('change');

            $('form#diagramResBattleFormYear #type-save-id-year').val([]).trigger('change');



        }
        update(all);

    }
</script>



