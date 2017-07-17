<?php

require 'TwistOAuth.php';
require 'TwistException.php';

define('CONSUMER_KEY', '');
define('CONSUMER_SECRET', '');
define('ACCESS_TOKEN', '');
define('ACCESS_TOKEN_SECRET', '');

$header = 'Content-Type: text/plain; charset=utf-8';

try {
     $connection = new TwistOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
      $res = $connection->post('statuses/update', [
      'status' => 'こんにちは'
    ]);
     header($header, true, 200);
     echo "ツイートしました";
  } catch (Exception $e) {
     header($header, true, $e->getCode() ?: 500);
     echo "ツイート失敗: {$e->getMessage()}\n";
}

