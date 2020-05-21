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
           ?>
        <tr>
            
            <td><?= $row['id'] ?></td>
            <td><?= $row['date_start'] ?></td>
            <td><?= $row['date_end'] ?></td>
            
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