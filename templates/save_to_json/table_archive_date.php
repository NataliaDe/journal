<div class="row">

    <div class="col-lg-6">

        <table class="table table-condensed   table-bordered table-custom" id="archive_date_Table" >
    <!-- строка 1 -->
    <thead>
        <tr>
            <th>ID</th>
            <th>С</th>
            <th>По</th>

        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
       <?php

       foreach ($archive_date as $row) {
             $d_from = new DateTime($row['date_start']);
        $d_from_f =$d_from->Format('d.m.Y'); //время - часы

         $d_to = new DateTime( $row['date_end']);
        $d_to_f =$d_to->Format('d.m.Y'); //время - часы
           ?>
        <tr>

            <td><?= $row['id'] ?></td>
            <td><?= $d_from_f ?></td>
            <td><?= $d_to_f ?></td>

        </tr>
        <?php
       }

       ?>

    </tbody>
        </table>
    </div>


        <div class="col-lg-6">

        <table class="table table-condensed   table-bordered table-custom" id="archive_year_Table" >
    <!-- строка 1 -->
    <thead>
        <tr>
            <th>ID</th>
            <th>Год</th>

        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th></th>

        </tr>
    </tfoot>
    <tbody>
       <?php

       foreach ($archive_year as $row) {
           ?>
        <tr>

            <td><?= $row['id'] ?></td>
            <td><?= $row['year'] ?></td>

        </tr>
        <?php
       }

       ?>

    </tbody>
        </table>
    </div>




</div>