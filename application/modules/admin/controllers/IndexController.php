<?php
class Admin_IndexController extends MyZend_Controller_Action {
    protected function indexAction(){
        $this->loadTemplate(TEMPLATE_PATH . "/admin","template.ini","blank");
    }
}
