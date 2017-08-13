<?php
class MyZend_Utils_Paginator {
  static public function createPaginator($itemCount, $paginatorAttr, $options = null){
    $adapter = new Zend_Paginator_Adapter_Null($itemCount);
    $paginator = new Zend_Paginator($adapter);
    $paginator->setItemCountPerPage($paginatorAttr['itemCountPerPage']);
    $paginator->setPageRange($paginatorAttr['pageRange']);
    $paginator->setCurrentPageNumber($paginatorAttr['currentPageNumber']);
    return $paginator;
  }
}
