<!--таблица выездов для уровня 1 -->
<br>
<?php
//echo $active_tab;
?>
<div class="box-body">

    <ul class="nav nav-tabs">
        <?php
        if ($active_tab == 1) {
            ?>
            <li class="active">
                <?php
            } else {
                ?>
            <li> 
                <?php
            }
            ?>
            <a  href="<?= $baseUrl ?>/rig/table/for_rcu/1" >Брестская обл.</a> 
        </li>
        <li>
            <?php
            if ($active_tab == 2) {
                ?>
            <li class="active">
                <?php
            } else {
                ?>
            <li> 
                <?php
            }
            ?>
            <a href="<?= $baseUrl ?>/rig/table/for_rcu/2" >Витебская обл</a>
        </li>
        <?php
        if ($active_tab == 4) {
            ?>
            <li class="active">
                <?php
            } else {
                ?>
            <li> 
                <?php
            }
            ?>
            <a href="<?= $baseUrl ?>/rig/table/for_rcu/4" >Гомельская обл.</a> 
        </li>
        <?php
        if ($active_tab == 5) {
            ?>
            <li class="active">
                <?php
            } else {
                ?>
            <li> 
                <?php
            }
            ?>
            <a href="<?= $baseUrl ?>/rig/table/for_rcu/5" >Гродненская обл.</a> 
        </li>
        <?php
        if ($active_tab == 3) {
            ?>
            <li class="active">
                <?php
            } else {
                ?>
            <li> 
                <?php
            }
            ?>
            <a href="<?= $baseUrl ?>/rig/table/for_rcu/3" >г.Минск</a> 
        </li>
        <?php
        if ($active_tab == 6) {
            ?>
            <li class="active">
                <?php
            } else {
                ?>
            <li> 
                <?php
            }
            ?>
            <a href="<?= $baseUrl ?>/rig/table/for_rcu/6" >Минская обл.</a> 
        </li>
        <?php
        if ($active_tab == 7) {
            ?>
            <li class="active">
                <?php
            } else {
                ?>
            <li> 
                <?php
            }
            ?>
            <a href="<?= $baseUrl ?>/rig/table/for_rcu/7" >Могилевская обл.</a>
        </li>
        <?php
        if ($active_tab == 8) {
            ?>
            <li class="active">
                <?php
            } else {
                ?>
            <li> 
                <?php
            }
            ?>
            <a href="<?= $baseUrl ?>/rig/table/for_rcu/8">РОСН</a> 
        </li>
        <?php
        if ($active_tab == 9) {
            ?>
            <li class="active">
                <?php
            } else {
                ?>
            <li> 
                <?php
            }
            ?>
            <a href="<?= $baseUrl ?>/rig/table/for_rcu/9" >УГЗ</a> 
        </li>
        <?php
        if ($active_tab == 12) {
            ?>
            <li class="active">
                <?php
            } else {
                ?>
            <li> 
                <?php
            }
            ?>
            <a href="<?= $baseUrl ?>/rig/table/for_rcu/12">Авиация</a>
        </li>
    </ul>
    <!--------------------------------------------------- содержимое вкладок------------------------------------------>
    <div class="tab-content ">
      
        <?php
               
        include dirname(dirname(__FILE__)) . '/level3.php';
        ?>
    </div> 
    <!--                    tab-content-->


</div>
