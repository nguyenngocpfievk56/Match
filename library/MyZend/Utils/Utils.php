<?php
class MyZend_Utils_Utils {
  public static function reloadMainPage(){
    echo "<script type='text/javascript'>window.parent.location.reload()</script>";
  }

  public static function getExtension($filename){
    $filename = strtolower($filename);
    $temp = explode('.', $filename);
    return $temp[count($temp) - 1];
  }

  public static function getFileName($filePath){
    $temp = explode('/', $filePath);
    return $temp[count($temp) - 1];
  }
}
