<div class="row">
    <div class="col-lg-7">
        <?php
           include dirname(__FILE__) . '/rigTable/form_search.php';//форма поиска с датами
        ?>
    </div>

    <div class="col-lg-1">
          <?php
/*------------------------ кнопка Создать вызов ------------------------*/
 include dirname(__FILE__) . '/buttonCreateRig.php';
    ?>


    </div>



</div>
<?php


/*-------------------- отображение таблицы выездов в зависимости от авт пользователя -------------------*/
 if($_SESSION['id_level']==3){

    include dirname(__FILE__) . '/rigTable/level3.php';
 }
 elseif ($_SESSION['id_level']==2) {

             include dirname(__FILE__) . '/rigTable/level3.php';
}
 else {//РБ по вкладкам

//               include dirname(__FILE__) . '/rigTable/form_search.php';//форма поиска с датами
       include dirname(__FILE__) . '/rigTable/level1/level1.php';
}

 /*-------------------- КОНЕЦ отображение таблицы выездов в зависимости от авт пользователя -------------------*/




