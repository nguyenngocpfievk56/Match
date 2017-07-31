<?php
class IndexController extends Zend_Controller_Action {
    protected function indexAction(){
        $this->_helper->layout->setLayout('homepage_layout');
    }
}
