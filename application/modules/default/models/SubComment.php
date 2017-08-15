<?php
class Default_Model_SubComment extends Zend_Db_Table {
  protected $_name = "subcomment";
  protected $_primary = "id";

  public function getSubCommentById($id) {
    $db = Zend_Registry::get("db");
    $select = $db->select()
                ->from('subcomment AS s')
                ->where("s.id = ?", $id)
                ->join('user AS u', 's.idUser = u.id', array('email', 'name', 'img'));

    return $db->fetchRow($select);
  }

  public function getSubCommentsByComment($idComment) {
    $db = Zend_Registry::get("db");
    $select = $db->select()
                ->from('subcomment AS s')
                ->where("s.idComment = ?", $idComment)
                ->join('user AS u', 's.idUser = u.id', array('email', 'name', 'img'));

    return $db->fetchAll($select);
  }

  public function insertNewComment($content, $idUser, $idComment) {
    $time = date('Y/m/d h:i:s a', time());
    $data = array(
      "content"=>$content,
      "time"=>$time,
      "idUser"=>$idUser,
      "idComment"=>$idComment
    );

    return $this->insert($data);
  }
}
