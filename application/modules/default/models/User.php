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

  public function getUserById($id, $getAll = false){
    if ($getAll) {
      $query =  $this->select()->where('id = ?', $id);
      return $this->fetchAll($query)->toArray();
    }

    $query =  $this->select()->from($this->_name, array('id', 'username', 'name', 'email', 'img', 'sex'))->where('id = ?', $id);
    return $this->fetchRow($query)->toArray();
  }

  public function checkPasswordById($id, $password){
    $query = $this->select()->where('id = ?', $id)->where('password = ?', $password);

    $result = $this->fetchRow($query);
    if (!empty($result)){
      if (sizeof($result->toArray()) > 0){
        return true;
      }
    }

    return false;
  }
}
