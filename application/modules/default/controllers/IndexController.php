<?php
class IndexController extends MyZend_Controller_Action {

  private $_user;

  public function init(){
    parent::init();
    $auth = Zend_Auth::getInstance();
    if ($auth->hasIdentity()){
      $this->view->loggedIn = true;
      $this->_user = $auth->getStorage()->read();
    } else {
      $this->view->loggedIn = false;
      $this->_user = null;
    }
  }

  protected function indexAction(){
    $this->loadTemplate(TEMPLATE_PATH . "/default","template.ini","homepage");
    $recommendationModel = new Default_Model_Recommendation();

    if (isset($this->_user)) {
      $recommendation = $recommendationModel->getRecommendationByUser($this->_user->id);

      if (count($recommendation) == 4){
        $this->view->recommendation = $recommendation;
      } else {
        $this->view->recommendation = $recommendationModel->gerRecommendationAsRandom(4);
      }
    } else {
      $this->view->recommendation = $recommendationModel->gerRecommendationAsRandom(4);
    }
  }
}
