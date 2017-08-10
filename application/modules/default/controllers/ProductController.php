<?php
class ProductController extends MyZend_Controller_Action {

  public function init() {
    parent::init();
    $auth = Zend_Auth::getInstance();
    if ($auth->hasIdentity()){
      $this->view->loggedIn = true;
    } else {
      $this->view->loggedIn = false;
    }
  }

  protected function listAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "sub");
    $productModel = new Default_Model_Product();
    $this->view->productData = $productModel->listItem();

    $categories = new Default_Model_Category();
    $this->view->categoriesData = $categories->listCategories();
  }

  protected function detailAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "sub");
  }

  protected function recommendationAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "sub");
  }

  protected function searchAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "sub");
  }
}
