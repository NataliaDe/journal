<?php

/**
 * Object model mapping for relational table `Archivedate` 
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Archivedate {
    
    public $last_update;

    public function setLastUpdate() {
        return $this->last_update = date("Y-m-d H:i:s");
    }
    

        public function selectAll() {

        $sql = 'SELECT * FROM journal.archivedate';

        return R::getAll($sql);
    }
    
            public function selectById($array) {

if(is_array($array))
        $sql = 'SELECT * FROM journal.archivedate WHERE id IN('.  implode(',', $array).')';
else
     $sql = 'SELECT * FROM journal.archivedate WHERE id ='. $array;

        return R::getAll($sql);
    }
    
                public function selectByYear($year) {

     $sql = 'SELECT * FROM journal.archivedate WHERE YEAR(date_start) = '. $year;

        return R::getAll($sql);
    }
    

    public function save($date_start,$date_end) {
        

     $archive_date = R::findOne('archivedate', 'date_start = ? and date_end = ?', [$date_start, $date_end]);

        if (!$archive_date) {//новое 
            $archive = R::dispense('archivedate');
            $array['date_start']=$date_start;
            $array['date_end']=$date_end;
                     $array['last_update']=  $this->setLastUpdate();
         
        $archive->import($array);
        R::store($archive);
        }

    }

}

?>