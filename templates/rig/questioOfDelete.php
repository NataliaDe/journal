
<form class="form-inline" role="form" id="formDeleteUser" method="POST" action="<?= $baseUrl ?>/rig/<?= $id ?>">

    <input type="hidden" name="_METHOD" value="DELETE"/>
    <br><br>
    <div class="container">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Внимание!</strong> Удалить выезд из БД?
        </div>
    </div>         
    <center>   <button type="submit" class="btn btn-danger">  Удалить  </button></center>
    <br> 
    <center> <a onclick="window.close()">  <button class="btn btn-warning" type="button" data-dismiss="modal">Назад</button></a></center>
</form>



