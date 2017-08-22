<?php
class Admin_Model_History extends Zend_Db_Table {

  protected $_name = "history";
  protected $_primary = "id";

  public function getAllHistory($page, $countPerPage) {
    $db = Zend_Registry::get('db');
    $select = $db->select()
                ->from('history as h')
                ->join('product as d', 'd.id = h.idProduct')
                ->join('user as u', 'h.idUser = u.id', array('u.id as idUser', 'u.username', 'u.name as fullname'))
                ->order('time DESC')
                ->limitPage($page,$countPerPage);

    return $db->fetchAll($select);
  }

  public function getNumberOfHistory() {
    $db = Zend_Registry::get('db');
    $select = $db->select()
                ->from('history', array('COUNT(id) as count'));

    return $db->fetchOne($select);
  }

  public function insertNewHistory($idUser, $idProduct, $type) {
    $time = date('Y/m/d h:i:s a', time());
    $params = array('idUSer' => $idUser, 'idProduct' => $idProduct,
                    'time' => $time, 'type' => $type);

    return $this->insert($params);
  }
}
