<?php
class ProductController extends MyZend_Controller_Action {

  var $paginatorAttr = array(
    "itemCountPerPage"=>12,
    "pageRange"=>5
  );

  var $_arrayParams;

  public function init() {
    parent::init();
    $auth = Zend_Auth::getInstance();
    if ($auth->hasIdentity()){
      $this->view->loggedIn = true;
    } else {
      $this->view->loggedIn = false;
    }

    $currentUser = $auth->getStorage()->read();
    $this->view->currentUser = $currentUser;

    $this->_arrayParams = $this->_request->getParams();
    $this->view->arrayParams = $this->_arrayParams;
    $this->paginatorAttr["currentPageNumber"] = $this->_request->getParam("page");
  }

  protected function listAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "sub");
    $productModel = new Default_Model_Product();
    $this->view->productData = $productModel->listItem($this->_arrayParams["idcat"],
                                                      $this->_arrayParams["page"],
                                                      $this->paginatorAttr["itemCountPerPage"]);

    $categories = new Default_Model_Category();
    $this->view->categoriesData = $categories->listCategories();

    $itemCount = $productModel->getCountOfProductByCategory($this->_arrayParams["idcat"]);

    $this->view->paginator = MyZend_Utils_Paginator::createPaginator($itemCount, $this->paginatorAttr);
  }

  protected function detailAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "sub");

    $productModel = new Default_Model_Product();
    $productInfo = $productModel->getProductById($this->_arrayParams["id"]);
    $this->view->productInfo = $productInfo;
    $this->view->relation = $productModel->getRelationProduct($productInfo[id], $productInfo['idCat'], 4);

    $commentModel = new Default_Model_Comment();
    $this->view->comments = $commentModel->getCommentsByProduct($this->_arrayParams["id"]);

    $subCommentModel = new Default_Model_SubComment();
    $this->view->subCommentModel = $subCommentModel;

    $userModel = new Default_Model_User();
    $this->view->userModel = $userModel;
  }

  protected function searchAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/default", "template.ini", "sub");
    $searchSession = new Zend_Session_Namespace('Zend_Form_Search');
    $productModel = new Default_Model_Product();

    if ($this->_request->isPost()) {
      $params = $this->_request->getParams();
      $this->view->keyword = $params['search-word'];
      $searchSession->searchWord = $params['search-word'];
      $this->view->productData = $productModel->searchProductsByKeyword($searchSession->searchWord);
    } else {
      $this->view->productData = $productModel->searchProductsByKeyword($searchSession->searchWord);
    }
  }
}
