<?php
class RecommendationController extends Zend_Controller_Action {
  protected function indexAction(){
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "sub");
  }
}
