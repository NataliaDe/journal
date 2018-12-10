<?php

/**
 * Object model mapping for relational table `ss.regions` 
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Locality {

    public $id;
    public $name;
    public $id_region;
    public $id_local;
    public $id_selsovet;

    public function setIdLocality($id) {
        $this->id = $id;
    }

    public function setIdSelsovet($id_selsovet) {
        $this->id_selsovet = $id_selsovet;
    }

    public function setIdLocal($id_local) {
        $this->id_local = $id_local;
    }

    public function setIdRegion($id_region) {
        $this->id_region = $id_region;
    }

    public function selectAll() {
        return R::getAll('SELECT loc.name as local_name,l.name, l.id, l.id_local,l.id_selsovet,l.id_region, l.id_vid FROM'
                . ' journal.locality as l left join locals as loc on loc.id=l.id_local  ORDER BY l.name ASC');
    }

    public function selectIdSelsovet($id) {
        $this->setIdLocality($id);
        return R::getCell('SELECT id_selsovet FROM journal.locality  WHERE id = ?', array($this->id));
    }

    public function selectIdLocalByLocality($id) {
        $this->setIdLocality($id);
        return R::getCell('SELECT id_local FROM journal.locality  WHERE id = ?', array($this->id));
    }

    //выбор всего по id с/с
    public function selectAllBySelsovet($id_selsovet) {
        $this->setIdSelsovet($id_selsovet);
        return R::getAll('SELECT loc.name as local_name,l.name, l.id, l.id_local,l.id_selsovet,l.id_region FROM'
                . ' journal.locality as l left join locals as loc on loc.id=l.id_local WHERE l.id_selsovet = ? ORDER BY l.name ASC', array($this->id_selsovet));
    }

    //выбор всего по id local
    public function selectAllByLocal($id_local) {
        $this->setIdLocal($id_local);
        return R::getAll('SELECT loc.name as local_name,l.name, l.id, l.id_local,l.id_selsovet,l.id_region, is_city, l.id_vid FROM'
                . ' journal.locality as l left join locals as loc on loc.id=l.id_local WHERE l.id_local = ? ORDER BY l.name ASC', array($this->id_local));
    }

    public function selectAllByRegion($id_region) {
        $this->setIdRegion($id_region);
        return R::getAll('SELECT loc.name as local_name,l.name, l.id, l.id_local,l.id_selsovet,l.id_region, l.id_vid FROM'
                . ' journal.locality as l left join locals as loc on loc.id=l.id_local WHERE l.id_region = ? ORDER BY l.name ASC', array($this->id_region));
    }
    
    // вид нас.пункта по выбранному нас.п.
     public function selectVidByIdLocality($id=NULL) {
        if($id !=NULL){
                    return R::getAll('SELECT vl.name,vl.slag FROM'
                . ' journal.locality as l left join vidlocality as vl ON vl.id=l.id_vid WHERE l.id=? ORDER BY l.name ASC ',array($id));
        }
        else{
                    return R::getAll('SELECT vl.name,vl.slag FROM'
                . ' journal.locality as l left join vidlocality as vl ON vl.id=l.id_vid ORDER BY l.name ASC');
        }

    }

}

?>