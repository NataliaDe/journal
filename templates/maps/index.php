<!--Accordion wrapper-->
<div class="accordion md-accordion accordion-3 z-depth-1-half" id="accordionEx194" role="tablist"
  aria-multiselectable="true">
  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header" role="tab" id="heading6">
      <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx194" href="#collapse6"
        aria-expanded="false" aria-controls="collapse6" style="color: #2c3e4f">

          <span>Показать фильтр</span>  <i class="fa fa-chevron-circle-down"></i>

      </a>
    </div>

    <!-- Card body -->
    <div id="collapse6" class="collapse" role="tabpanel" aria-labelledby="heading6"
      data-parent="#accordionEx194">
      <div class="card-body pt-0">
        <?php
        include 'form_query_kusis.php';
        ?>


          <br>
          <center><b><p>
            <?php
            if (date("H:i:s") <= '06:00:00') {//до 06 утра

                ?>
                Выезды <?= (isset($cnt_rigs) && !empty($cnt_rigs)) ? ('(' . $cnt_rigs . ')') : '' ?> с 06:00 <?= date("d.m.Y", time() - (60 * 60 * 24)) ?>  до 06:00 <?= date("d.m.Y") ?>
                <?php
            } else {

                ?>
                Выезды <?= (isset($cnt_rigs) && !empty($cnt_rigs)) ? ('(' . $cnt_rigs . ')') : '' ?> с <span style="color: green; text-decoration: underline;" >06:00 <?= date("d.m.Y") ?></span>  до <span style="color: green; text-decoration: underline;">06:00 <?= date("d.m.Y", time() + (60 * 60 * 24)) ?></span>
                <?php
            }

            ?>

 <i style="color:#fb4343;" class="fa fa-bell"  data-toggle="tooltip" data-placement="right"

    title="<?= implode(', ', $reasons_names) ?>
    ">

 </i>

        </p></b></center>


      </div>
    </div>
  </div>
  <!-- Accordion card -->
</div>
<!--/.Accordion wrapper-->



<div id="mapid"></div>


<script>

</script>

