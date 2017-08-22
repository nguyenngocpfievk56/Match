<?php
class Admin_HistoryController extends MyZend_Controller_Action {

  var $paginatorAttr = array(
    "itemCountPerPage"=>15,
    "pageRange"=>5
  );

  private $_arrayParams;

  public function init() {
    parent::init();
    $this->_arrayParams = $this->_request->getParams();
    $this->paginatorAttr["currentPageNumber"] = $this->_request->getParam("page");

    $auth = Zend_Auth::getInstance();

    if (!$auth->hasIdentity()){
      $this->_redirect($this->view->baseUrl('admin/index/index'));
    }
    $currentUser = $auth->getStorage()->read();
    if ($currentUser->type != 1) {
      $this->_redirect($this->view->baseUrl('admin/index/index'));
    }
  }

  protected function indexAction() {
      $this->loadTemplate(TEMPLATE_PATH . "/admin","template.ini","blank");
      $this->view->arrayParams = $this->_arrayParams;
      $historyModel = new Admin_Model_History();

      $itemCount = $historyModel->getNumberOfHistory();
      $this->view->paginator = MyZend_Utils_Paginator::createPaginator($itemCount, $this->paginatorAttr);

      $this->view->history = $historyModel->getAllHistory($this->_arrayParams["page"], $this->paginatorAttr["itemCountPerPage"]);
  }
}
