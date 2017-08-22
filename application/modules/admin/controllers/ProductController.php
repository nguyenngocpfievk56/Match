<?php
class Admin_ProductController extends MyZend_Controller_Action {

  var $paginatorAttr = array(
    "itemCountPerPage"=>15,
    "pageRange"=>5
  );

  var $_arrayParams;
  var $_currentUser;

  public function init() {
    parent::init();
    $this->_arrayParams = $this->_request->getParams();
    $this->paginatorAttr["currentPageNumber"] = $this->_request->getParam("page");

    $auth = Zend_Auth::getInstance();

    if (!$auth->hasIdentity()){
      $this->_redirect($this->view->baseUrl('admin/index/index'));
    }
    $this->_currentUser = $auth->getStorage()->read();
    if ($this->_currentUser->type != 1) {
      $this->_redirect($this->view->baseUrl('admin/index/index'));
    }
  }

  protected function indexAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/admin","template.ini","blank");
    $productModel = new Admin_Model_Product();
    $this->view->productData = $productModel->listItem($this->_arrayParams["idcat"],
                                                      $this->_arrayParams["page"],
                                                      $this->paginatorAttr["itemCountPerPage"]);

    $categories = new Default_Model_Category();
    $this->view->categoriesData = $categories->listCategories();

    $itemCount = $productModel->getCountOfProductByCategory($this->_arrayParams["idcat"]);

    $this->view->paginator = MyZend_Utils_Paginator::createPaginator($itemCount, $this->paginatorAttr);

    $this->view->arrayParams = $this->_arrayParams;
  }

  protected function viewAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/admin","template.ini","blank");

    $productModel = new Admin_Model_Product();
    $productInfo = $productModel->getProductById($this->_arrayParams["id"]);
    $this->view->productInfo = $productInfo;

    $this->view->arrayParams = $this->_arrayParams;
  }

  protected function insertAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/admin","template.ini","blank");
    $this->view->arrayParams = $this->_arrayParams;

    $categories = new Default_Model_Category();
    $this->view->categoriesData = $categories->listCategories();

    if ($this->_request->isPost()){
      $updateData = [];

      $updateData['name'] = $this->_arrayParams['name'];
      $updateData['description'] = $this->_arrayParams['description'];

      if ($this->_request->isPost()){
        $upload = new Zend_File_Transfer_Adapter_Http();
        $file = $upload->getFileInfo();

        if (!empty($file['product']['name'])){
          $ext = MyZend_Utils_Utils::getExtension($file['product']['name']);
          $newFileName = 'product_' . time() . '.' . $ext;

          $upload ->setDestination(FILES_PATH . '/img');
          $upload->addFilter('Rename', array('target'=> FILES_PATH . '/product/' . $newFileName, 'overwrite'=>true));
          if ($upload->isValid()){
            $upload->receive();
            $updateData['img'] = $this->view->baseUrl(UPLOAD_PRODUCT_URL . $newFileName);
          } else {
            echo "Can not upload image, do it again pls!";
          }
        }
      }

      $updateData['idCat'] = $this->_arrayParams['category'];

      $productModel = new Admin_Model_Product();
      $id = $productModel->insertNewProduct($updateData);
      if ($id > 0) {
        $historyModel = new Admin_Model_History();
        $historyModel->insertNewHistory($this->_currentUser->id, $id, 'Insert');

        $this->_redirect($this->view->baseUrl('admin/product/index/idcat/19/page/1'));
      } else {
        echo "Insert Product be Fail, Pls do it again!";
      }
    }
  }

  protected function deleteAction(){
    $this->_helper->viewRenderer->setNoRender(TRUE);
    $productModel = new Admin_Model_Product();
    $productModel->deleteProductById($this->_arrayParams['id']);

    $historyModel = new Admin_Model_History();
    $historyModel->insertNewHistory($this->_currentUser->id, $this->_arrayParams['id'], 'Delete');

    $this->_redirect($this->view->baseUrl('admin/product/index') . '/idcat/' . $this->_arrayParams['idcat'] . '/page/' . $this->_arrayParams['page']);
  }

  protected function reactiveAction(){
    $this->_helper->viewRenderer->setNoRender(TRUE);
    $productModel = new Admin_Model_Product();
    $productModel->reactiveProductById($this->_arrayParams['id']);

    $historyModel = new Admin_Model_History();
    $historyModel->insertNewHistory($this->_currentUser->id, $this->_arrayParams['id'], 'Reactive');

    $this->_redirect($this->view->baseUrl('admin/product/index') . '/idcat/' . $this->_arrayParams['idcat'] . '/page/' . $this->_arrayParams['page']);
  }

  protected function updateAction() {
    $this->loadTemplate(TEMPLATE_PATH . "/admin","template.ini","blank");
    $this->view->arrayParams = $this->_arrayParams;
    $productModel = new Admin_Model_Product();
    $productInfo = $productModel->getProductById($this->_arrayParams['id']);
    $this->view->productInfo = $productInfo;

    $categories = new Default_Model_Category();
    $this->view->categoriesData = $categories->listCategories();

    if ($this->_request->isPost()){
      $updateData = [];

      $updateData['name'] = $this->_arrayParams['name'];
      $updateData['description'] = $this->_arrayParams['description'];

      if ($this->_request->isPost()){
        $upload = new Zend_File_Transfer_Adapter_Http();
        $file = $upload->getFileInfo();

        if (!empty($file['product']['name'])){
          $ext = MyZend_Utils_Utils::getExtension($file['product']['name']);
          $newFileName = 'product_' . time() . '.' . $ext;

          $upload ->setDestination(FILES_PATH . '/img');
          $upload->addFilter('Rename', array('target'=> FILES_PATH . '/product/' . $newFileName, 'overwrite'=>true));
          if ($upload->isValid()){
            $oldFile = MyZend_Utils_Utils::getFileName($productInfo['img']);
            unlink(FILES_PATH . '/product/' . $oldFile);
            $upload->receive();
            $updateData['img'] = $this->view->baseUrl(UPLOAD_PRODUCT_URL . $newFileName);
          } else {
            echo "Can not upload image, do it again pls!";
          }
        }
      }

      $updateData['idCat'] = $this->_arrayParams['category'];
      $productModel->updateProduct($this->_arrayParams['id'], $updateData);

      $historyModel = new Admin_Model_History();
      $historyModel->insertNewHistory($this->_currentUser->id, $this->_arrayParams['id'], 'Update');

      $this->_redirect($this->view->baseUrl('admin/product/view/idcat/' . $this->_arrayParams['idcat'] . '/page/' . $this->_arrayParams['page'] . '/id/' . $this->_arrayParams['id']));
    }
  }
}
