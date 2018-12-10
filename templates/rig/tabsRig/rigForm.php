<?php
//echo $active_tab ;
//если открываем вкладку по высылке техники ($active_tab = 2) - остальные вкладки не отображаем
?>
<div class="box-body">
    <form  role="form" id="rigForm" method="POST" action="<?= $baseUrl ?>/rig/new/<?= $id ?>/<?= $active_tab ?>" >
 <input type="hidden" class="form-control datetime"  name="id" value="<?= $id ?>" />
        <ul class="nav nav-tabs">
            <?php
            if ($active_tab == 1) {
                ?>
                <li class="active">
                    <?php
                } elseif($active_tab != 2) {
                    ?>
                <li>                     
                    <?php
                }
				
				if($active_tab != 2) {
                ?>
                <a  href="#1" data-toggle="tab">Обработка вызова</a>
            </li>

            <?php
				}
				
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
                <a href="#2" data-toggle="tab">Высылка техники</a>
            </li>

            <?php
            if ($active_tab == 3) {
                ?>
                <li class="active">
                    <?php
                } elseif($active_tab != 2) {
                    ?>
                <li>                     
                    <?php
                }
				
				if($active_tab != 2) {
                ?>
                <a href="#3" data-toggle="tab">Дополнительно</a>
            </li>
			<?php
				}
				?>
        </ul>
<!--------------------------------------------------- содержимое вкладок------------------------------------------>
        <div class="tab-content ">
            <br>
            <!--            Обработка вызова-->
            <?php
            if ($active_tab == 1) {
                ?>
                <div class="tab-pane active" id="1">
                    <?php
                } elseif($active_tab != 2) {
                    ?>
                    <div class="tab-pane " id="1">
                        <?php
                    }
					if($active_tab != 2) 
                    include dirname(__FILE__) . '/processRigTab.php';
                    ?>
                </div>

                <!--Высылка техники-->
                <?php
     
                if ($active_tab == 2) {
                    ?>
                    <div class="tab-pane active" id="2">
                        <?php
                    } else {
                        ?>
                        <div class="tab-pane" id="2">
                            <?php
                        }
                        include dirname(__FILE__) . '/technicsRigTab.php';
                        ?>
                    </div>

                    <!--Дополнительно-->
                    <?php
                    if ($active_tab == 3) {
                        ?>
                        <div class="tab-pane active" id="3">
                            <?php
                        } elseif($active_tab != 2) {
                            ?>
                            <div class="tab-pane" id="3">
                                <?php
                            }
							if($active_tab != 2) 
                            include dirname(__FILE__) . '/additionalRigTab.php';
                            ?>
                        </div>

                    </div> 
<!--                    tab-content-->



                    </form>
                </div>
