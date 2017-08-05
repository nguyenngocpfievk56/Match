<?php
class IndexController extends MyZend_Controller_Action {
    protected function indexAction(){
        $this->loadTemplate(TEMPLATE_PATH . "/default","template.ini","homepage");
        $products = new Default_Model_Product();
    }
}
