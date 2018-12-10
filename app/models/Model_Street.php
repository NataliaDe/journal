<?php

/**
 * Object model mapping for relational table `ss.regions` 
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Street {

    public $id;
    public $name;
    public $id_locality;
    public $soato;

    public function setIdLocality($id_locality){
        $this->id_locality=$id_locality;
}



    public function selectAll() {
            return R::getAll('SELECT st.id as id, st.name as name, st.id_locality as id_locality, vs.name as vid_name FROM journal.street as st left join journal.vidstreet as vs'
                . ' on vs.id=st.id_vid  ORDER BY name ASC');
    }
    
        public function selectAllByLocality($id_locality) {
            $this->setIdLocality($id_locality);
        return R::getAll('SELECT st.id as id, st.name as name, st.id_locality as id_locality, vs.name as vid_name FROM journal.street as st left join journal.vidstreet as vs'
                . ' on vs.id=st.id_vid WHERE st.id_locality = ? ORDER BY name ASC',array($this->id_locality));
    }
    
    



}

?>