<?php
class CreateAccountController extends MyZend_Controller_Action {

  protected $_arrayParams;

  public function init() {
    $this->_arrayParams = $this->_request->getParams();
  }

  protected function indexAction(){
    $this->loadTemplate(TEMPLATE_PATH . "/default","template.ini","blank");

    $captchaGenerator = new MyZend_Captcha_CaptchaGenerator();

    $captcha = $captchaGenerator->getCaptcha();
    $captcha_id = $captcha->getId();

    $this->view->captcha = $captcha->render($this->view);
    $this->view->captcha_id = $captcha_id;

    if ($this->_request->isPost()){
      $captcha_id = $this->_arrayParams['captchaId'];
      $captchaSession = new Zend_Session_Namespace('Zend_Form_Captcha_' .  $captcha_id);

      if ($this->_arrayParams['password'] == $this->_arrayParams['repassword']){
        if ($captchaSession->word == $this->_arrayParams['captchaBox']){
          $userTable = new Default_Model_User();
          $userTable->insertNewAccount($this->_arrayParams['username'], $this->_arrayParams['password']);
          // TODO: Go to conform infomation page
        } else {
          $this->view->error = "キャプチャが間違った";
        }
      } else {
          $this->view->error = "確認のパスワードはパスワードと違う";
      }

      $captchaImgPath = CAPTCHA_PATH . '/images/' . $captcha_id . $captcha->getSuffix();
      unlink($captchaImgPath);
    }
  }
}
