<?php
class AuthController extends MyZend_Controller_Action {
  protected $_arrayParams;

  public function init(){
    parent::init();
    $auth = Zend_Auth::getInstance();
    if ($auth->hasIdentity()){
      $this->view->loggedIn = true;
    } else {
      $this->view->loggedIn = false;
    }

    $this->_arrayParams = $this->_request->getParams();
  }

  protected function loginAction(){
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "blank");

    $this->view->savedUser = $this->_request->getCookie(USER_COOKIE, null);

    $this->view->params = $this->_arrayParams;
    $db = Zend_Registry::get('db');

    $auth = Zend_Auth::getInstance();
    $authAdapter = new Zend_Auth_Adapter_DbTable($db);
    $authAdapter->setTableName('user')
      ->setIdentityColumn('username')
      ->setCredentialColumn('password');

    if ($this->_request->isPost()){
      if ($this->_request->getParam('username') != null && $this->_request->getParam('password') != null){
        $username = $this->_arrayParams['username'];
        $password = $this->_arrayParams['password'];
        $remember = $this->_arrayParams['remember'];

        $authAdapter->setIdentity($username);
        $authAdapter->setCredential(md5($password));

        $result = $auth->authenticate($authAdapter);
        if ($result->isValid()){
          $omitColumns = array('password');
          $user = $authAdapter->getResultRowObject(null, $omitColumns);
          $auth->getStorage()->write($user);

          if ($this->_request->getParam('remember') == 'on'){
            setcookie(USER_COOKIE, $username . '|' . $password, time() + 86400);
          }

          MyZend_Utils_Utils::reloadMainPage();
        } else {
          $this->view->error = "何か間違いました";
        }
      } else {
        $this->view->error = "UsernameとPasswordが必要です";
      }
    }
  }

  protected function logoutAction(){
    $auth = Zend_Auth::getInstance();
    $auth->clearIdentity();
    $this->_redirect($this->view->baseUrl());
    $this->_helper->viewRenderer->setNoRender();
  }
}
