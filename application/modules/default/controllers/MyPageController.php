<?php
class MyPageController extends Zend_Controller_Action {
  protected function indexAction(){
    $this->_helper->layout->setLayout("sub_layout");
  }
}
