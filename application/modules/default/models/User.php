<?php
class Default_Model_User extends Zend_Db_Table {
  protected $_name = 'user';
  protected $_primary = 'id';

  public function insertNewAccount($username, $password, $type = 0){
    $data = array(
      'username'=>$username,
      'password'=>md5($password),
      'type'=> $type
    );

    return $this->insert($data);
  }

  public function updateAccount($id, $params){
    $where = $this->getAdapter()->quoteInto('id = ?', $id);
    $this->update($params, $where);
  }

  public function getUserById($id){
    $query =  $this->select()->from('user')->where('id = ?', $id);
    return $this->fetchAll($query)->toArray();
  }
}
