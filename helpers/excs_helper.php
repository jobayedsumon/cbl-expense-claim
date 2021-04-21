<?php

function excs_debug($data, $die = 0)
{
  echo '<pre>';
  if (is_array($data) || is_object($data)) {
    print_r($data);
  } else if (is_string($data)) {
    echo $data;
  } else {
    var_dump($data);
  }

  if ($die) {
    die();
  } else {
    echo '</pre>';
  }
}

function excs_url($uri = '')
{
  $server = 'http://192.168.0.27/EXCS/backend/api';
  $local_mh = 'http://192.168.1.136/excs/backend/api';
  return $server;
}

function excs_amount($amount) {
    return number_format($amount, 2, '.', '');
}
