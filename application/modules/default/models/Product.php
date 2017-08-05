<?php
class Default_Model_Product extends Zend_Db_Table {
  protected $_name = "product";
  protected $_primary = "id";

  public function listItem(){
    return $this->fetchAll()->toArray();
  }
}
