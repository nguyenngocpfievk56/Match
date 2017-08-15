<?php
class Default_Model_Comment extends Zend_Db_Table {
  protected $_name = "comment";
  protected $_primary = "id";

  public function getCommentById($id) {
    $select = $this->select()->where("id = ?", $id);

    return $this->fetchRow($select)->toArray();
  }

  public function getCommentsByProduct($idProduct) {
    $select = $this->select()->where("idProduct = ?", $idProduct);

    return $this->fetchAll($select)->toArray();
  }

  public function insertNewComment($content, $idUser, $idProduct) {
    $time = date('Y/m/d h:i:s a', time());
    $data = array(
      "content"=>$content,
      "time"=>$time,
      "likes"=>0,
      "idUser"=>$idUser,
      "idProduct"=>$idProduct
    );

    return $this->insert($data);
  }

  public function updateLikeAmount($idComment, $likes) {
    $where = $this->getAdapter()->quoteInto('id = ?', $idComment);
    $this->update(array('likes'=>$likes), $where);
  }

  public function getLikeAmount($idComment) {
    $selectLike = $this->select()->where('id = ?', $idComment);
    return $this->fetchRow($selectLike)->toArray();
  }
}
