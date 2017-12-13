<?php
// https://justyy.com/archives/3450
  $s = '';
  if (isset($_GET['s'])) {
     $s = $_GET['s'];
  } else {
    if (isset($_POST['s'])) {
     $s = $_POST['s'];
    }
  }
  $t = false;
  if (isset($_GET['t'])) {
    $t = (bool)($_GET['t']);
  } else {
    if (isset($_POST['t'])) {
     $t = (bool)($_POST['t']);
    }  
  }
  $data = array();
  $db = 'pinyin.txt';
  if (is_file($db)) {
    $result = array();
    $array = preg_split('/$\R?^/m', trim(file_get_contents($db)));
    $hash = array();
    foreach ($array as $v) {
      $v = trim($v);
      $c = substr($v, 0, 3);
      $hash[$c] = substr($v, 3);  
    }
    $slen = mb_strlen($s,'UTF-8');
    for ($i = 0; $i < $slen; $i ++) {
      $c = mb_substr($s, $i, 1);
      $tmp = $hash[$c];
      if (!$t) {
        $tmp = str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), '', $tmp);
      }
      if ($tmp) {
        $result[] = $tmp;
      } else {
        $result[] = $c;
      }
    }
    $data['result'] = $result;
  } else {
    $data['error'] = 'cannot read data';
  }  
  header("Access-Control-Allow-Origin: *");
  header('Content-Type: application/json');
  die(json_encode($data));
