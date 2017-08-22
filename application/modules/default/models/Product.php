<?php
class Default_Model_Product extends Zend_Db_Table {
  protected $_name = "product";
  protected $_primary = "id";

  public function listItem($idCat, $page, $countPerPage, $options = null) {
    $db = Zend_Registry::get("db");
    $select = $db->select()
                ->from("product")
                ->where("idCat = ?", $idCat, INTEGER)
                ->where("deleted = ?", "")
                ->limitPage($page,$countPerPage);
    return $db->fetchAll($select);
  }

  public function getProductById($id) {
    $db = Zend_Registry::get("db");
    $select = $db->select()
                ->from("product")
                ->where("id = ?", $id)
                ->where("deleted = ?", "");
    return $db->fetchRow($select);
  }

  public function getCountOfProductByCategory($idCategory) {
    $db = Zend_Registry::get("db");
    $select = $db->select()
                ->from("product", array("COUNT(id) as itemCount"))
                ->where("deleted = ?", "")
                ->where("idCat = ?", $idCategory, INTEGER);

    return $db->fetchOne($select);
  }

  public function getRelationProduct($idProduct, $idCategory, $amount) {
    $select = $this->select()
                  ->where('id <> ?', $idProduct, INTEGER)
                  ->where('idCat = ?', $idCategory, INTEGER)
                  ->where("deleted = ?", "")
                  ->order(new Zend_Db_Expr('RAND()'))
                  ->limit($amount);
    return $this->fetchAll($select)->toArray();
  }

  public function searchProductsByKeyword($keyword) {
    if (empty($keyword)){
      return null;
    }

    $select = $this->select()
                  ->where('description LIKE ?', '%' . $keyword . '%')
                  ->where("deleted = ?", "")
                  ->limit(20);

    return $this->fetchAll($select)->toArray();
  }
}
