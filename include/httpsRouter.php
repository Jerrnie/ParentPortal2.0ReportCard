<?php 

  function addScheme($url, $scheme = 'https://')
  {
    return parse_url($url, PHP_URL_SCHEME) === null ?
      $scheme . $url : $url;
  }

  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "https") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  if (!isset($_SERVER['HTTPS']) && !isLocalhost() && $_SERVER[HTTP_HOST] != '52.74.3.44') {
    header('Location: ' . addScheme($actual_link));
  }

  function isLocalhost($whitelist = ['127.0.0.1', '::1'])
  {
    return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
  }


?>