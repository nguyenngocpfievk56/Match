<?php
class MyZend_AI_Learn {
  function run($idUser, $data){
    $input = [];
    $userRate = [];
    foreach ($data as $d) {
      if (!array_key_exists($d['idUser'], $input)){
        $input[$d['idUser']] = [$d['idProduct']];
        $userRate[$d['idUser']] = 0;
      } else {
        array_push($input[$d['idUser']], $d['idProduct']);
      }
    }

    $recommendation = [];
    if (sizeof($input[$idUser]) > 0){
      foreach ($input as $u=> $d) {
        if ($u != $idUser) {
          for ($i=0; $i < sizeof($input[$idUser]); $i++){
            if (in_array($input[$idUser][$i], $d)){
              $userRate[$u] += 1;
            }
          }
        }
      }

      $temp = $userRate;
      rsort($temp);

      foreach ($userRate as $key => $value) {
        if ($value == $temp[0]) {
          $recommendation = $input[$key];
        }
      }

      foreach ($recommendation as $key => $value) {
        if (in_array($value, $input[$idUser])){
          unset($recommendation[$key]);
        }
      }
    }

    return $recommendation;
  }
}
