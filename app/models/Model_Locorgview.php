<?php
/**
 * Object model mapping for relational view `locorgview`
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Locorgview  {

    public function selectAll($id_organ = NULL) {

        if ($id_organ == 1) {//выбрать все подразд кроме РЦУ, УМЧС(там нет техники)
            //$mas=array(4,5);
            $mas=array(5);
            return R::getAll('SELECT * FROM journal.locorgview WHERE id_organ NOT IN ('.  implode(',', $mas).')');
        } else {
            return R::getAll('SELECT * FROM journal.locorgview');
        }
    }

}
?>