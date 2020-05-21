<style>
.table_blur {
  background: #f5ffff;
  border-collapse: collapse;
  text-align: left;
}
.table_blur th {
  border-top: 1px solid #777777;
  border-bottom: 1px solid #777777;
  box-shadow: inset 0 1px 0 #999999, inset 0 -1px 0 #999999;
  background: linear-gradient(#9595b6, #5a567f);
  color: white;
  padding: 10px 15px;
  position: relative;
}
.table_blur th:after {
  content: "";
  display: block;
  position: absolute;
  left: 0;
  top: 25%;
  height: 25%;
  width: 100%;
  background: linear-gradient(rgba(255, 255, 255, 0), rgba(255,255,255,.08));
}
.table_blur tr:nth-child(odd) {
  background: #ebf3f9;
}
.table_blur th:first-child {
  border-left: 1px solid #777777;
  border-bottom:  1px solid #777777;
  box-shadow: inset 1px 1px 0 #999999, inset 0 -1px 0 #999999;
}
.table_blur th:last-child {
  border-right: 1px solid #777777;
  border-bottom:  1px solid #777777;
  box-shadow: inset -1px 1px 0 #999999, inset 0 -1px 0 #999999;
}
.table_blur td {
  border: 1px solid #e3eef7;
  padding: 10px 15px;
  position: relative;
  transition: all 0.5s ease;
}
.table_blur tbody:hover td {
  color: transparent;
  text-shadow: 0 0 3px #a09f9d;
}
.table_blur tbody:hover tr:hover td {
  color: #444444;
  text-shadow: none;
}
</style>
<br><br>
<center>
Информация по выездам за текущие дежурные сутки <?= date('d.m.Y') ?> (c 6-00)
<br><br>
<table class="table_blur">
  <tr>
    <th>Подразделение</th>
    <th>Всего выездов</th>
    <th>На пожары</th>
    <th>На ЧС</th>
	<th>Обеспечение ПБ<br>(уборка урожая)</th>
    <th>Другие</th>
    </tr>


    <?php
    foreach ($rigs as $value) {
        ?>
      <tr>
    <td><?= $value['name']  ?></td>
    <td><?= $value['vsego']  ?></td>
    <td><?= $value['pogar']  ?></td>
    <td><?= $value['hs']  ?></td>
	<td><?= $value['uborka']  ?></td>
    <td><?= $value['other']  ?></td>
    </tr>
  <tr>
    <?php
    }

    ?>


      <tr>
       <td><b>Итого</b></td>
    <td><?= $itogo['vsego']  ?></td>
    <td><?= $itogo['pogar']  ?></td>
    <td><?= $itogo['hs']  ?></td>
	<td><?= $itogo['uborka']  ?></td>
    <td><?= $itogo['other']  ?></td>
    </tr>
  <tr>


  <tr>
</table>
</center>