<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{
    protected function _initDb(){
      $resources = $this->getOption("resources");
      $dbOptions = $resources["db"];

      $adapter = $dbOptions["adapter"];
      $config = $dbOptions["params"];

      $db = Zend_Db::factory($adapter, $config);
      $db->setFetchMode(Zend_Db::FETCH_ASSOC);

      Zend_Registry::set("db", $db);
      Zend_Db_Table::setDefaultAdapter($db);
    }
}
