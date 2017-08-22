<?php
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

defined('TEMPLATE_PATH') || define('TEMPLATE_PATH', realpath(dirname(__FILE__) . '/public/templates'));

defined('CAPTCHA_PATH') || define('CAPTCHA_PATH', realpath(dirname(__FILE__) . '/public/captcha'));

define('FILES_PATH', TEMPLATE_PATH . '/default/uploadfiles');

define('UPLOAD_IMAGES_URL', 'public/templates/default/uploadfiles/img/');

define('UPLOAD_PRODUCT_URL', 'public/templates/default/uploadfiles/product/');

define('USER_COOKIE', 'user_cookie');

define('ADMIN_COOKIE', 'admin_cookie');

set_include_path(implode(PATH_SEPARATOR, array(
    dirname(__FILE__) . '/library',
    get_include_path(),
)));
