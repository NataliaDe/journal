<?php

/**
 * Object model mapping for relational view `permissions`
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Permissions {

    public $id_user;
    public $user_name;
    public $id_level;
    public $id_region;
    public $id_locorg;
    public $login;
    public $password;
    public $id_organ;
    public $sub;
    public $can_edit;
    public $is_admin;
    public $auto_ate;
    public $level_name;
    public $region_name;
    public $locorg_name;
    public $can_edit_name;
    public $is_admin_name;
    public $auto_ate_name;

        public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
    }


    public function selectAll() {
         return R::getAll('SELECT * FROM journal.permissions');
    }

    public function selectPermisByLogin($login,$password) {
        $this->setLogin($login);
        $this->setPassword($password);

		 return R::findOne('permissions', 'login = ? and password = ?', [$login, $password]);
		 // return R::getAll('select * from permissions WHERE login = ? AND password = ? limit 1 ', array($this->login, $this->password));
    }

        public function selectPermisByCookie($id_user,$cookie) {

          return R::findOne('permissions', 'id_user = ? AND cookie = ?', [$id_user,$cookie]);
    }



}