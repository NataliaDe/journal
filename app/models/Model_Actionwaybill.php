<?php
/**
 * Object model mapping for relational table `ss.regions`
 */
namespace App\MODELS;

use \RedBeanPHP\Facade as R;

class Model_Actionwaybill
{

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLastUpdate()
    {
        return $this->last_update = date("Y-m-d H:i:s");
    }

    public function setDateInsert()
    {
        return $this->date_insert = date("Y-m-d H:i:s");
    }

    public function save($array, $id)
    {
        //print_r($array);exit();
        foreach ($array as $val) {
            $w = R::load('actionwaybill', $id);

            if ($id == 0) {//insert
                $val['date_insert'] = $this->setDateInsert();
            }
            $val['last_update'] = $this->setLastUpdate();
            $val['id_user'] = $_SESSION['id_user'];
            $w->import($val);

            R::store($w);
        }
        return true;
    }

    public function selectById($id)
    {

        return R::getAll('SELECT a.id, r.name as reason_name, a.description,a.is_off, a.ord, a.last_update,a.id_work_view, r.id as reason_id,w.name as work_name from journal.actionwaybill as a '
                . 'left join journal.reasonrig as r on a.id_reasonrig=r.id '
            . 'left join journal.workview as w on a.id_work_view=w.id WHERE a.id =? ', array($id));
    }

    public function delete($in_id)
    {

        return R::getAll('DELETE from journal.actionwaybill  WHERE id IN ( '.$in_id.')');
    }


    public function selectAllByIdRig($id_rig)
    {
         return R::getAll('SELECT a.`description` FROM journal.rig as r left join  journal.actionwaybill as a on a.id_reasonrig=r.id_reasonrig WHERE r.id =? AND a.is_off = ? AND r.`id_work_view`= a.`id_work_view` ORDER BY a.ord ', array($id_rig,1));
    }


        public function isOrd($id)
    {

        return R::getAll('SELECT a.ord from journal.actionwaybill as a '
                . ' WHERE a.id =? ', array($id));
    }

            public function editOrd($id_reasonrig,$old_ord,$new_ord,$id_work_view)
    {

                $id=R::getCell('SELECT id FROM journal.actionwaybill  WHERE id_reasonrig =? and id_work_view = ? and ord = ? LIMIT ? ', array($id_reasonrig,$id_work_view,$old_ord,1));

        return R::getAll('UPDATE journal.actionwaybill SET ord = ?  WHERE id = ?  ', array($new_ord,$id));
    }

    public function selectAllActionByIdReason($id_reasonrig,$id_work)
    {
  return R::getAll('SELECT a.id, r.name as reason_name, a.description,a.is_off, a.ord,a.last_update, r.id as reason_id,a.id_work_view  from journal.actionwaybill as a '
                . 'left join journal.reasonrig as r on a.id_reasonrig=r.id WHERE r.id =? and a.id_work_view = ?  ORDER BY a.ord ASC', array($id_reasonrig,$id_work));
    }

}

?>