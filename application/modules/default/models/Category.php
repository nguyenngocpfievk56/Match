<?php
class Default_Model_Category extends Zend_Db_Table {
  protected $_name = "category";
  protected $_primary = "id";

  public function listCategories(){
    return $this->fetchAll()->toArray();
  }

  public function getCategoryById() {
    
  }
}
