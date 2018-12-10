<?php
/**
 * Object model mapping for relational view `Listmailview ` 
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Listmailview  {
    
    public function selectAll() {

            return R::getAll('SELECT * FROM journal.listmailview WHERE is_delete =? ',array(0));
    
    }

}
?>