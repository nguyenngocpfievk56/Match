<?php
class LoginController extends MyZend_Controller_Action {
  protected $_arrayParams;

  public function init(){
    $this->_arrayParams = $this->_request->getParams();
  }

  protected function indexAction(){
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "blank");

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
        $authAdapter->setCredential($password);

        $result = $auth->authenticate($authAdapter);
        if ($result->isValid()){
          $omitColumns = array('password');
          $user = $authAdapter->getResultRowObject(null, $omitColumns);
          $auth->getStorage()->write($user);
        } else {
          $this->view->notation = "何か間違いました、チェックしてください";
        }
      } else {
        $this->view->notation = "UsernameとPasswordを入力してください";
      }
    }
  }

  protected function logoutAction(){
    $auth = Zend_Auth::getInstance();
    $auth->clearIdentity();
    $this->_redirect("http://www.match.com/");
    $this->_helper->viewRenderer->setNoRender();
  }
}
