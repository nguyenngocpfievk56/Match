<?php
class Default_Model_Recommendation extends Zend_Db_Table {
  protected $_name;
  protected $_primary;

  public function getRecommendationByUser($idUser) {
    $db = Zend_Registry::get('db');
    $select = $db->select()
                ->from('recommendation as r')
                ->where('u.id = ?', $idUser, INTEGER)
                ->join('product as d', 'd.id = r.idProduct')
                ->join('user as u', 'r.idUser = u.id', array('u.id'));

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
}
