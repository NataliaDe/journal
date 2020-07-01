<?php
/**
 * Object model mapping for relational table `ss.regions`
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Local  {

    public $id;
    public $name;
    public $id_region;


    public function setIdRegion($id_region) {
        $this->id_region=$id_region;
    }
    public function selectAll() {
           return R::getAll('SELECT * FROM locals WHERE id !=123 ORDER BY sort, name ASC');

    }

        public function selectAllByRegion($id_region) {
            $this->setIdRegion($id_region);
           return R::getAll('SELECT * FROM locals WHERE id_region = ? and id !=123 ORDER BY sort, name ASC',array($this->id_region));

    }

          public function selectNameById($id) {
        return R::getCell('SELECT name FROM locals WHERE id = ?', array($id));
    }



    public function get_all_selsovet_by_local($id_local)
    {
        return R::getAll('SELECT * FROM selsovet WHERE id_local = ? order by name', array($id_local));
    }

    public function get_all_locality_by_selsovet($id_selsovet)
    {
return R::getAll('SELECT l.id as locality_id, l.id_region, l.id_local as locality_local, l.name as locality_name,'
    . 'l.id_selsovet as locality_id_selsovet, vl.id as vid_id, vl.name as vid_name  FROM locality as l  left join vidlocality as vl on vl.id=l.id_vid WHERE l.id_selsovet = ? order by l.name', array($id_selsovet));
    }


    public function get_locality_without_selsovet($id_local)
    {
        return R::getAll('SELECT * FROM locality WHERE id_local = ? AND id_selsovet = ? order by name', array($id_local,0));
    }

    public function get_vid_locality()
    {
        return R::getAll('SELECT * FROM vidlocality  order by name');
    }
}
?>