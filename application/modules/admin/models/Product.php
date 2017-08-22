<?php
class Admin_Model_Product extends Zend_Db_Table {
  protected $_name = "product";
  protected $_primary = "id";

  public function listItem($idCat, $page, $countPerPage, $options = null) {
    $db = Zend_Registry::get("db");
    $select = $db->select()
                ->from("product as p")
                ->where("p.idCat = ?", $idCat, INTEGER)
                ->limitPage($page,$countPerPage);

    return $db->fetchAll($select);
  }

  public function getProductById($id) {
    $db = Zend_Registry::get("db");
    $select = $db->select()
                ->from("product")
                ->where("id = ?", $id);
    return $db->fetchRow($select);
  }

  public function getCountOfProductByCategory($idCategory) {
    $db = Zend_Registry::get("db");
    $select = $db->select()
                ->from("product", array("COUNT(id) as itemCount"))
                ->where("idCat = ?", $idCategory, INTEGER);

    return $db->fetchOne($select);
  }

  public function deleteProductById($id) {
    $where = $this->getAdapter()->quoteInto('id = ?', $id);
    $params = array('deleted' => date('Y/m/d h:i:s a', time()));
    $this->update($params, $where);
  }

  public function insertNewProduct($data) {
    return $this->insert($data);
  }

  public function updateProduct($id, $params) {
    $where = $this->getAdapter()->quoteInto('id = ?', $id);
    $this->update($params, $where);
  }

  public function reactiveProductById($id) {
    $where = $this->getAdapter()->quoteInto('id = ?', $id);
    $params = array('deleted' => '');
    $this->update($params, $where);
  }
}
