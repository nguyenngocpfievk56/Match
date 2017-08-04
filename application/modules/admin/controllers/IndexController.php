<?php
class Admin_IndexController extends Zend_Controller_Action {
    protected function indexAction(){
        $this->_helper->layout->setLayout("blank_layout");
    }
}
