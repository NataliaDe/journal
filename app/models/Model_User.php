<?php

/**
 * Object model mapping for relational table `user`
 */

namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_User {

    public $id;
    public $name;
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
    public $date_insert;
    public $last_update;

    public function setDateInsert() {
        return $this->date_insert = date("Y-m-d H:i:s");
    }

    public function setLastUpdate() {
        return $this->last_update = date("Y-m-d H:i:s");
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function selectUserById($id) {
        $this->setId($id);
        return R::findOne('user', 'id = ?', [$this->id]);
    }

    public function isUser() {

        if ($this->id == 0) {
            $user = R::findOne('user', 'login = ? and password = ?', [$this->login, $this->password]);
        } else {
            $user = R::findOne('user', 'login = ? and password = ? and id <> ?', [$this->login, $this->password, $this->id]);
        }


        if ($user)
            return TRUE;
        else
            return FALSE;
    }

    public function save($array, $id) {

        $this->setId($id);
        $this->setLogin($array['login']);
        $this->setPassword($array['password']);


        if ($this->isUser()) {
            return FALSE;
            exit();
        }


        $user = R::load('user', $this->id);

        if ($this->id == 0) {//insert
            $array['date_insert'] = $this->setDateInsert();
        }
        $array['last_update'] = $this->setLastUpdate();
        $user->import($array);

        if (R::store($user))
            return TRUE;
        else
            return FALSE;
    }

    public function deleteUserById($id) {
        $this->setId($id);
        $user = R::load('user', $this->id);
        $ok=R::trash($user);

        if (empty($ok)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    public function getCntUnseenNotif($id_user)
    {
        return R::getCell('select count(id) from notifications where id_user = ? and is_see = ?',array($id_user,0));
    }

        public function getAllNotif($id_user)
    {
        return R::getAll('select * from notifications where id_user = ? order by date_action desc',array($id_user));
    }


            public function get_rcu_boss()
    {
        return R::getCell('select id from user where is_rcu_boss = ? limit ?',array(1,1));
    }


}

?>