<?php
class UserController extends MyZend_Controller_Action {

  protected $_arrayParams;

  public function init(){
    parent::init();
    if (Zend_Auth::getInstance()->hasIdentity()){
      $this->view->loggedIn = true;
    } else {
      $this->view->loggedIn = false;
    }

    $this->_arrayParams = $this->_request->getParams();

    $this->view->arrayParams = $this->_arrayParams;
  }

  protected function profileAction(){
      $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "sub");
      $userAuth = get_object_vars(Zend_Auth::getInstance()->getIdentity());

      $userTable = new Default_Model_User();
      $user = $userTable->getUserById($userAuth['id']);
      $this->view->user = $user;

      if ($this->_request->isPost()){
        $params = $this->_request->getParams();

        $updateData = [];
        if (!empty($params['name'])){
          $updateData['name'] = $params['name'];
        }

        if (!empty($params['email'])){
          $updateData['email'] = $params['email'];
        }

        $updateData['sex'] = $params['sex'];

        $upload = new Zend_File_Transfer_Adapter_Http();
        $file = $upload->getFileInfo();

        if (!empty($file['avatar']['name'])){
          $ext = MyZend_Utils_Utils::getExtension($file['avatar']['name']);
          $newFileName = 'avatar_' . $user['id'] . '.' . $ext;

          $upload ->setDestination(FILES_PATH . '/img');
          $upload->addFilter('Rename', array('target'=> FILES_PATH . '/img/' . $newFileName, 'overwrite'=>true));
          if ($upload->isValid()){
            $upload->receive();
            $updateData['img'] = $this->view->baseUrl(UPLOAD_IMAGES_URL . $newFileName);
          } else {
            echo "Can not upload image, do it again pls!";
          }
        }

        if (!empty($updateData)){
          $userTable->updateAccount($user['id'], $updateData);
          $user = $userTable->getUserById($userAuth['id']);
          $this->view->user = $user;
        }
      }
  }

  protected function createAccountAction(){
    $this->loadTemplate(TEMPLATE_PATH . "/default","template.ini","blank");

    $captchaGenerator = new MyZend_Captcha_CaptchaGenerator();

    $captcha = $captchaGenerator->getCaptcha();
    $captcha_id = $captcha->getId();

    $this->view->captcha = $captcha->render($this->view);
    $this->view->captcha_id = $captcha_id;

    if ($this->_request->isPost()){
      $captcha_id = $this->_arrayParams['captchaId'];
      $captchaSession = new Zend_Session_Namespace('Zend_Form_Captcha_' .  $captcha_id);

      // TODO: check null for params
      if ($this->_arrayParams['password'] == $this->_arrayParams['repassword']){
        if ($captchaSession->word == $this->_arrayParams['captchaBox']){
          $userTable = new Default_Model_User();
          $this->username = $this->_arrayParams['username'];
          $userId = $userTable->insertNewAccount($this->username, $this->_arrayParams['password']);
          $this->_redirect($this->view->baseUrl('user/update-account/userId/' . $userId));
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

  protected function updateAccountAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/default","template.ini","blank");
    $userId = $this->_arrayParams['userId'];

    if ($this->_request->isPost()) {
      if ($this->_arrayParams['submit'] === 'ok') {
        $upload = new Zend_File_Transfer_Adapter_Http();
        $file = $upload->getFileInfo();
        $ext = MyZend_Utils_Utils::getExtension($file['avatar']['name']);

        $newFileName = 'avatar_' . $userId . '.' . $ext;

        $upload ->setDestination(FILES_PATH . '/img');
        $upload->addFilter('Rename', array('target'=> FILES_PATH . '/img/' . $newFileName, 'overwrite'=>true));
        if ($upload->isValid()){
          $upload->receive();
        } else {
          echo "We have some problems, check it again!";
        }

        $userTable = new Default_Model_User();
        $userTable->updateAccount($userId, array('img'=>$this->view->baseUrl(UPLOAD_IMAGES_URL . $newFileName),
                                                  'name'=>$this->_arrayParams['name'],
                                                  'email'=>$this->_arrayParams['email'],
                                                  'sex'=>$this->_arrayParams['sex']));

        $this->view->infor = $userTable->getUserById($userId);
      } else {
        MyZend_Utils_Utils::reloadMainPage();
      }
    }
  }

  public function welcomeAction(){
    $this->loadTemplate(TEMPLATE_PATH . "/default","template.ini","blank");
  }

}
