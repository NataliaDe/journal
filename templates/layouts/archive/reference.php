<!--Modal-->
<div id="myModal" class="modal fade">
    <div class="modal-dialog " id="modal-about">
        <div class="modal-content instruct">
            <div class="modal-header"><button class="close danger" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><b>Справка</b></h4>
                Программное средство «Журнал ЦОУ». Модуль «Архив».
               
                <br>
            </div>
            <div class="modal-body">
                 <a href='/journal/templates/layouts/spravka/index.html' target='_blank'><span style='color:red'>Инструкция по использованию</span></a> 
                <?php
                if (isset($_GET["file"]))
                    $filename = $_GET["file"];
                else {
                     $filename = "instruct.doc";
                     //$filename1 = "ukazanie.doc";
                }
                if (strpos($filename, "/") !== false)
                    die("Hack atempt detected!");
                if ($fileext = substr($filename, strrpos($filename, ".")) !== ".doc")
                    die("Поддерживается только чтение вордовских документов");

                $p =  $baseUrl.'assets/doc/';
                $path = $p . $filename;
               // $path1 = $p . $filename1;
//echo $path;

               // echo "Скачать <a href='$path'>инструкцию по использованию</a><br> ";
               // echo "Скачать <a href='$path1'>Указание: письмо о внедрении в ОЭ (исх.№ 1/54/350.вн.)</a><br><br> ";
                ?>
   
            <p class="modal-header"></p>
                <b>Контактная информация:</b><br>
                автор идеи - Шилько Сергей Чеславович, 8(017) 209 27 11<br>
                 руководитель - Шульга Максим Константинович, 8(017) 209 27 51<br>   
                разработчик - Дещеня Наталья Александровна, 8(017) 209 27 48<br>

            </div>
 
            <div class="modal-footer">

                <div class="copyright">
                    <span class='glyphicon glyphicon-copyright-mark'></span> 2019, г.Минск, «Республиканский центр управления и реагирования на чрезвычайные ситуации МЧС Республики Беларусь»
                </div>
                <br>
                <button class="btn btn-success" type="button" data-dismiss="modal">Закрыть</button></div>
        </div>
    </div>
</div>
