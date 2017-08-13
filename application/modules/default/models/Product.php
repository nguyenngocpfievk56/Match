<?php
class Default_Model_Product extends Zend_Db_Table {
  protected $_name = "product";
  protected $_primary = "id";

  public function listItem($idCat, $page, $countPerPage, $options = null) {
    $db = Zend_Registry::get("db");
    $select = $db->select()
                ->from("product")
                ->where("idCat = ?", $idCat, INTEGER)
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

  public function searchProductsByKeyword() {

  }

  public function deleteProductById() {

  }

  public function insertNewProduct() {
    
  }
}
