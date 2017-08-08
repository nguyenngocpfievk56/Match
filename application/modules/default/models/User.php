<?php
class Default_Model_User extends Zend_Db_Table {
  protected $_name = 'user';
  protected $_primary = 'id';

  public function insertNewAccount($username, $password){
    $data = array(
      'username'=>$username,
      'password'=>$password,
    );

    $this->insert($data);
  }
}
