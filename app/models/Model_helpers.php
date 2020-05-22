<?php

/**
 * Object model mapping for relational table `user`
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Helpers {
    
   function declination_word_by_number($n, $titles)
    {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
    }

}

?>