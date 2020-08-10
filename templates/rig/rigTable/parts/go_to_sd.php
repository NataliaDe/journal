<ul class="dropdown sd-menu-dropdown"  data-toggle="tooltip" data-placement="left" title="Сформировать СД" >
    <a href="# "  style="color: #222d32;" class="dropdown-toggle navbar-right-customer" data-toggle="dropdown" >
        <img src="<?= $baseUrl ?>/assets/images/sd.png" style="width:20px" >
        <b class="caret"></b></a>
    <ul class="dropdown-menu sd-menu" >
        <li class="dropdown-submenu">
            <a tabindex="-1" href="<?= $baseUrl ?>/login_to_speciald/<?= $row['id'] ?>/standart/0"  class="caret-spr_inf" target="_blank">Стандартное</a>
        </li>
        <li class="dropdown-submenu">
            <a tabindex="-1" href="<?= $baseUrl ?>/login_to_speciald/<?= $row['id'] ?>/simple/ct_1"  class="caret-spr_inf" target="_blank">Простое (шаблон 1)</a>
        </li>
    </ul>
</ul>