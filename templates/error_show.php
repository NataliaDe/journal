
    <br><br>
    <div class="container">
        <div class="alert alert-danger">
            <strong>Ошибка!</strong> <br>
            <?php
            foreach ($error as $value) {
                echo  $value."<br>";
            }
            ?>
        </div>
    </div>         
    <br> 
    
    <?php

    if(isset($path_to_form_back) && !empty($path_to_form_back)){    //путь до файла с формой с кнопкой назад

       include dirname(__FILE__)  . $path_to_form_back;

    }
    elseif(isset($url_back) && !empty($url_back)){//назад на конкретную ссылку
       ?>
    <center> <a href="<?= $baseUrl ?>/<?= $url_back ?>">  <button class="btn btn-danger" type="button" data-dismiss="modal">Назад</button></a></center>
    <?php
    }
    else{
        ?>
        <center> <a onclick="javascript:history.back();">  <button class="btn btn-warning" type="button" data-dismiss="modal">Назад</button></a></center>
    <?php
    }
    ?>





