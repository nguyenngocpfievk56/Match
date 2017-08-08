<?php
class MyZend_Captcha_CaptchaGenerator {
  protected $captcha;

  function __construct(){
    $this->captcha = new Zend_Captcha_Image();
    $this->captcha->setImgDir(CAPTCHA_PATH . '/images');
    $this->captcha->setImgUrl('/public/captcha/images');
    $this->captcha->setWordlen(4);
    $this->captcha->setFont(CAPTCHA_PATH . '/fonts/noteworthy.ttc');
    $this->captcha->setFontSize(30);
    $this->captcha->setWidth(150);
    $this->captcha->setHeight(50);
    $this->captcha->generate();

    $captchaSession = new Zend_Session_Namespace('Zend_Form_Captcha_' . $this->captcha->getId());
    $captchaSession->word = $this->captcha->getWord();
  }

  public function getCaptcha(){
    return $this->captcha;
  }
}
