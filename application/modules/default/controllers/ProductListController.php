<?php
class ProductListController extends MyZend_Controller_Action {

  protected function indexAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "sub");
    $productModel = new Default_Model_Product();
    $this->view->productData = $productModel->listItem();

    $categories = new Default_Model_Category();
    $this->view->categoriesData = $categories->listCategories();
  }

}
