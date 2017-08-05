<?php
class MyZend_Controller_Action extends Zend_Controller_Action {
  public function init(){

  }

  public function loadTemplate($templatePath, $configFile, $configSession){
    $this->view->headTitle()->set('');
    $this->view->headLink()->getContainer()->exchangeArray(array());
    $this->view->headScript()->getContainer()->exchangeArray(array());
    $this->view->headMeta()->getContainer()->exchangeArray(array());

    $filename = $templatePath . "/" . $configFile;
    $config = new Zend_Config_Ini($filename, $configSession);
    $config = $config->toArray();

    $baseUrl = $this->_request->getBaseUrl();
    $templateUrl = $baseUrl . $config["url"];
    $cssUrl = $templateUrl . $config['cssDir'];
    $jsUrl = $templateUrl . $config['jsDir'];
    $imgUrl = $templateUrl . $config['imagesDir'];

    $this->view->headTitle($config["title"]);

    if (count($config["cssLink"]) > 0){
      foreach ($config["cssLink"] as $key => $value) {
        $this->view->headLink()->appendStylesheet($value, "screen");
      }
    }

    if (count($config["jsLink"]) > 0){
      foreach ($config["jsLink"] as $key => $value) {
        $this->view->headScript()->appendFile($value, "text/javascript");
      }
    }

    if (count($config["cssFile"]) > 0) {
      foreach ($config["cssFile"] as $key => $value) {
        $this->view->headLink()->appendStylesheet($cssUrl . $value, "screen");
      }
    }

    if (count($config["jsFile"]) > 0){
      foreach ($config["jsFile"] as $key => $value) {
        $this->view->headScript()->appendFile($jsUrl . $value,"text/javascript");
      }
    }

    $this->view->imgUrl = $imgUrl;

    $option = array("layoutPath" => $templatePath , "layout" => $config["layout"] );
    Zend_Layout::startMvc($option);
  }
}
