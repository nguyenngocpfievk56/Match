<?php
class MyZend_Utils_Utils {
  public static function reloadMainPage(){
    echo "<script type='text/javascript'>window.parent.location.reload()</script>";
  }
}
