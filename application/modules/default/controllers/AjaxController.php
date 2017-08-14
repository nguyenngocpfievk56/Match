<?php
class AjaxController extends Zend_Controller_Action {
  private $_arrayParams;

  public function init() {
    $this->_helper->layout->disableLayout();

    $this->_arrayParams = $this->_request->getParams();
  }

  protected function addCommentAction() {
    $commentModel = new Default_Model_Comment();
    $currentId = $commentModel->insertNewComment($this->_arrayParams['content'], $this->_arrayParams['idUser'], $this->_arrayParams['idProduct']);
    $currentComment = $commentModel->getCommentById($currentId);

    $userModel = new Default_Model_User();
    $commentedUser = $userModel->getUserById($currentComment['idUser']);

    $this->view->commentedUser = $commentedUser;
    $this->view->currentComment = $currentComment;
  }

  protected function likeAction() {
    $this->_helper->viewRenderer->setNoRender(TRUE);
    $idComment = $this->_arrayParams['id-comment'];

    $commentModel = new Default_Model_Comment();
    $comment = $commentModel->getLikeAmount($idComment);
    $likes = $comment['likes'] + 1;
    $commentModel->updateLikeAmount($idComment,$likes);

    echo $likes;
  }
}
