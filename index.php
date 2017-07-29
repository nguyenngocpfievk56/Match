<?php
include 'define.php';

require_once 'Zend/Application.php';

$environment = 'developer';
$options = APPLICATION_PATH . '/configs/application.ini';
$application = new Zend_Application($environment, $options);
$application->bootstrap()->run();