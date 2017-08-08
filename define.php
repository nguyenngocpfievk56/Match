<?php
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

defined('TEMPLATE_PATH') || define('TEMPLATE_PATH', realpath(dirname(__FILE__) . '/public/templates'));

defined('CAPTCHA_PATH') || define('CAPTCHA_PATH', realpath(dirname(__FILE__) . '/public/captcha'));

set_include_path(implode(PATH_SEPARATOR, array(
    dirname(__FILE__) . '/library',
    get_include_path(),
)));
