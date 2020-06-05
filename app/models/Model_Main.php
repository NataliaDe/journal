<?php
/**
 * Object model mapping for relational table `ss.regions`
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Main
{

    public function get_owner_categories()
    {
        return R::getAll('SELECT * from owner_categories');
    }
}

?>