<?php
class Default_Model_Recommendation extends Zend_Db_Table {
  protected $_name = 'recommendation';
  protected $_primary = 'id';

  public function getRecommendationByUser($idUser) {
    $db = Zend_Registry::get('db');
    $select = $db->select()
                ->from('recommendation as r')
                ->where('u.id = ?', $idUser, 'INTEGER')
                ->join('product as d', 'd.id = r.idProduct')
                ->join('user as u', 'r.idUser = u.id', array('u.id as idUser'))
                ->order(new Zend_Db_Expr('RAND()'))
                ->limit(4);

    return $db->fetchAll($select);
  }

  public function gerRecommendationAsRandom($amount) {
    $db = Zend_Registry::get('db');
    $select = $db->select()
                  ->from('product as p')
                  ->order(new Zend_Db_Expr('RAND()'))
                  ->limit($amount);

    return $db->fetchAll($select);
  }
  public function deleteAllRecommendation() {
    $db = Zend_Registry::get('db');
    $db->delete($this->_name);
  }

  public function insertRecommendation($userId, $data) {
    $db = Zend_Registry::get('db');

    $query = 'INSERT INTO ' . $db->quoteIdentifier('recommendation') . ' (`idUser`, `idProduct`) VALUES ';
    $values = null;
    foreach ($data as $d) {
      $values[] = '(' . $db->quote($userId) . ',' . $db->quote($d) . ')';
    }

    if (!empty($values)){
      $stmt = $db->query($query . implode(',', $values));
    }
  }
}
