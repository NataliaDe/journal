
<?php
//echo $_SERVER['REQUEST_URI'];
?>
    <br><br>
    
    <form  role="form" class="form-inline" id="classifForm" method="POST" action="<?= $baseUrl ?>/settings/reason_rig_color">

        Цвет выезда необходимо вводить в одном из форматов: <br>
        <b> 1. буквы английского алфавита, например, <span style="color: red">red</span>;<br>
            2. формат "HEX", например, <span style="color: green">#48c217 </span> </b> <a href="https://colorscheme.ru/color-converter.html" target="_blank">ссылка на цвета</a>
        <br><br>
        
                                    <div class="form-group">
                        
                                        <select class="js-example-basic-single form-control" name="id_reasonrig"  >
                                            <option value="">Выберите причину вызова</option>
                                            <?php
                                            foreach ($statusrig as $p) {
                                                    printf("<p><option value='%s' ><label>%s</label></option></p>", $p['id'], $p['name']);
                                            }
                                            ?>
                                        </select>
                                    </div>
        
        
             <div class="form-group">
                   
                 <input name="color"  placeholder="Введите цвет" class="status_rig_color"> 
        
             </div>
                <div class="form-group">
                    <button class="btn bg-green" type="submit"   >Сохранить</button>
                </div>



    </form>
    

    


