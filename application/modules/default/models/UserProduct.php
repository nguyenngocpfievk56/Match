<?php
class Default_Model_UserProduct extends Zend_Db_Table {
  protected $_name = "user_product";
  protected $_primary = "id";

  public function insertNewRelation($idUser, $idProduct) {
    if ($this->checkExist($idUser, $idProduct)) {
      return;
    }
    $time = date('Y/m/d h:i:s a', time());
    $data = array(
      "idUser"=>$idUser,
      "idProduct"=>$idProduct,
      "time"=>$time
    );

    return $this->insert($data);
  }

  public function checkExist($idUser, $idProduct) {
    $select = $this->select()
                  ->where('idUser = ?', $idUser)
                  ->where('idProduct = ?', $idProduct);

    $result = $this->fetchAll($select);
    return sizeof($result->toArray()) > 0;
  }

  public function getAllData() {
    $data = $this->fetchAll($this->select());
    return $data->toArray();
  }
}
