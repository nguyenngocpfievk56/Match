<?php
class IndexController extends MyZend_Controller_Action {

  public function init(){
    parent::init();
    $auth = Zend_Auth::getInstance();
    if ($auth->hasIdentity()){
      $this->view->loggedIn = true;
    } else {
      $this->view->loggedIn = false;
    }
  }

  protected function indexAction(){
      $this->loadTemplate(TEMPLATE_PATH . "/default","template.ini","homepage");
      $products = new Default_Model_Product();
  }
}
