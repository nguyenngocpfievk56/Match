<?php
class Admin_AjaxController extends MyZend_Controller_Action {

  private $_arrayParams;

  public function init() {
    parent::init();
    $this->_arrayParams = $this->_request->getParams();
  }

  protected function runaiAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/admin","template.ini","blank");
    $this->_helper->viewRenderer->setNoRender(TRUE);
    $userProductModel = new Default_Model_UserProduct();
    $aiLearn = new MyZend_AI_Learn();
    $data = $userProductModel->getAllData();

    $userModel = new Default_Model_User();
    $userId = $userModel->getAllUserID();

    $recommendModel = new Default_Model_Recommendation();
    $recommendModel->deleteAllRecommendation();

    foreach ($userId as $u) {
      $recommendId = $aiLearn->run($u['id'], $data);
      $recommendModel->insertRecommendation($u['id'], $recommendId);
    }
  }
}
