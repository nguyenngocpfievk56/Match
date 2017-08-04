<?php
class LoginController extends Zend_Controller_Action {
  protected function indexAction(){
    // $this->_helper->layout()->disableLayout();
    $this->_helper->layout->setLayout("blank_layout");
  }
}
