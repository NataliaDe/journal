    <div class="container">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ошибка!</strong>
            <?php

foreach ($errors as $error){
    echo $error.'<br>';
}
?>
        </div>
    </div>




 <center> <a onclick="javascript:history.back();">  <button class="btn btn-warning" type="button" data-dismiss="modal">Назад</button></a></center>
