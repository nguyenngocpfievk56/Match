<?php
class ProfileController extends MyZend_Controller_Action {
  protected function indexAction(){
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "sub");
  }
}
