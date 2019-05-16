<link href="<?= $baseUrl ?>/assets/css/archive/style.css" rel="stylesheet">
<center>Результат</center>


<main>

    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1">Информация по выездам</label>

    <input id="tab2" type="radio" name="tabs">
    <label for="tab2">Информация по технике</label>

    <input id="tab3" type="radio" name="tabs">
    <label for="tab3">Информация по информированию</label>

    <input id="tab4" type="radio" name="tabs">
    <label for="tab4">Информация по другим службам</label>

    <section id="content1" class="sec">
        <p>
            В данной вкладке находится общая информация по выездам.
        </p>

        <center>
        <div id="preload-table-content1" style="display:none;">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br><br>
Идет загрузка данных...

        </div>
        </center>
        <div id="table-content1">

            <button class="btn btn-default"  type="button" onclick="refreshTable('table-content1');">Выполнить запрос</button>
            <br>
            <br>

        </div>


    </section>

    <section id="content2" class="sec">
        <p>
            В данной вкладке находится общая информация по выезжавшей технике.
            <span class="glyphicon glyphicon-hand-up" style="color: red; font-size: 13px" ></span>
 <span style="color: red; font-size: 13px">  После применения в таблице фильтра по технике (и информации связанной с ней, например, время выезда) при экспорте в Excel данный фильтр не учитывается.</b></span>
        </p>

        <center>
        <div id="preload-table-content2" style="display:none;">
   <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br><br>
Идет загрузка данных...
        </div>
        </center>

        <div id="table-content2">
            <button class="btn btn-default"   type="button" onclick="refreshTable('table-content2');">Выполнить запрос</button>
            <br>
            <br>

        </div>


    </section>

    <section id="content3" class="sec">
        <p>
            В данной вкладке находится общая информация по информированию должностных лиц.
              <span class="glyphicon glyphicon-hand-up" style="color: red; font-size: 13px" ></span>
 <span style="color: red; font-size: 13px">  После применения в таблице фильтра по адресату (и информации связанной с ним, например, время выезда) при экспорте в Excel данный фильтр не учитывается.</b></span>
        </p>

                <center>
        <div id="preload-table-content3" style="display:none;">
   <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br><br>
Идет загрузка данных...
        </div>
        </center>

        <div id="table-content3">
            <button class="btn btn-default"   type="button" onclick="refreshTable('table-content3');">Выполнить запрос</button>
            <br>
            <br>

        </div>



    </section>

    <section id="content4" class="sec">
        <p>
            В данной вкладке находится общая информация по привлечению сил других ведомств.
             <span class="glyphicon glyphicon-hand-up" style="color: red; font-size: 13px" ></span>
 <span style="color: red; font-size: 13px">  После применения в таблице фильтра по службе (и информации связанной с ней, например, время прибытия) при экспорте в Excel данный фильтр не учитывается.</b></span>
        </p>


                <center>
        <div id="preload-table-content4" style="display:none;">
   <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br><br>
Идет загрузка данных...
        </div>
        </center>

        <div id="table-content4">
            <button class="btn btn-default"   type="button" onclick="refreshTable('table-content4');">Выполнить запрос</button>
            <br>
            <br>

        </div>


    </section>

</main>

<script>

    function refreshTable(content) {
        // alert(content);

        var date_start = $('input[name="date_start"]').val();
        var date_end = $('input[name="date_end"]').val();

        var archive_year = $('select[name="archive_year"]').val();
        var region = $('select[name="id_region"]').val();
        var local = $('input[name="id_local"]').val();



        if (date_start && date_end) {
             $('#' + content).fadeOut("slow");
            $('#preload-'+content).css('display','block');


            //  alert('123');
            $.ajax({
                type: 'POST',
                url: '/journal/archive_1/getTabContent/' + content,
                // dataType: 'json',
                data: {
                    date_start: date_start,
                    date_end: date_end,
                    archive_year: archive_year,
                    region: region,
                    local: local

                },

                success: function (response) {
 $('#preload-'+content).css('display','none');
                   // $('#' + content).fadeOut("slow", function () {
                        //  $('h1.m-n > *:not(:first)').remove();
                        $('#' + content).html(response);
                        $('#' + content).fadeIn("slow");
                      //  console.log("it Work");
                   // });

                }
            });
        }
    }

</script>