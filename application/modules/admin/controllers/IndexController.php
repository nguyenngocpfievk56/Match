<?php
class Admin_IndexController extends MyZend_Controller_Action {

  const NOT_LOGIN_YET = 0;
  const BE_NOT_ADMIN = 1;
  const BE_ADMIN = 2;

  private $_arrayParams;
  private $_currentUser;
  private $_auth;

  public function init() {
    parent::init();
    $this->_arrayParams = $this->_request->getParams();
  }

  protected function indexAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/admin","template.ini","blank");
    $this->view->arrayParams = $this->_arrayParams;

    $auth = Zend_Auth::getInstance();
    $db = Zend_Registry::get('db');

    $this->_auth = NOT_LOGIN_YET;
    if ($auth->hasIdentity()){
      $this->_currentUser = $auth->getStorage()->read();
      if ($this->_currentUser->type == 1) {
        $this->_auth = BE_ADMIN;
      } else {
        $this->_auth = BE_NOT_ADMIN;
      }
    }
    $this->view->auth = $this->_auth;
    $this->view->currentUser = $this->_currentUser;


    $this->view->savedUser = $this->_request->getCookie(ADMIN_COOKIE, null);

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
            setcookie(ADMIN_COOKIE, $username . '|' . $password, time() + 86400);
          }

          $this->_redirect($this->view->baseUrl('admin/index/index'));
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
    $this->_redirect($this->view->baseUrl('admin/index'));
    $this->_helper->viewRenderer->setNoRender();
  }
}
