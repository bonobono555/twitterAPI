<?php

require '../build/TwistOAuth.phar';
require 'TwistOAuth.php';
require 'TwistException.php';

$consumer_key = '';
$consumer_secret = '';
$access_token = '';
$access_token_secret = '';


$connection = new TwistOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);


// jsonの取得----------------
// キーワードによるツイート検索
//$tweets_params = ['q' => '夜景,きれい OR キレイ OR 綺麗' ,'count' => '10'];
$tweets_params = ['q' => 'ほっこり OR ホッコリ' ,'count' => '10'];
$tweets = $connection->get('search/tweets', $tweets_params)->statuses;

// ハッシュタグによるツイート検索
$hash_params = ['q' => '#html5,#css3' ,'count' => '10', 'lang'=>'ja'];
$hash = $connection->get('search/tweets', $hash_params)->statuses;

// 指定位置（geo情報）から投稿されたツイート検索
$geo_params = ['geocode' => '35.710063,139.8107,0.2km' ,'count' => '10'];
$geo = $connection->get('search/tweets', $geo_params)->statuses;

// 自分のタイムラインを取得
$home_params = ['count' => '10'];
$home = $connection->get('statuses/home_timeline', $home_params);

// 自分のツイートを取得
$user_params = ['count' => '10'];
$user = $connection->get('statuses/user_timeline', $user_params);

// ニックネームからユーザ情報を取得
$users_params = ['screen_name' => 'yokoh9'];
$users = $connection->get('users/show', $users_params);


// JSONから表示する情報を抜き出す----------------
foreach ($tweets as $value) {
    $text = htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8', false);
    // 検索キーワードをマーキング
    $keywords = preg_split('/,|\sOR\s/', $tweets_params['q']); //配列化
    foreach ($keywords as $key) {
        $text = str_ireplace($key, '<span class="keyword">'.$key.'</span>', $text);
    }
    // ツイート表示のHTML生成
    disp_tweet($value, $text);
}

// 抜き出した情報をHTMLに流し込む----------------
function disp_tweet($value, $text){
    $icon_url = $value->user->profile_image_url;
    $screen_name = $value->user->screen_name;
    $updated = date('Y/m/d H:i', strtotime($value->created_at));
    $tweet_id = $value->id_str;
    $url = 'https://twitter.com/' . $screen_name . '/status/' . $tweet_id;

    echo '<div class="tweetbox">' . PHP_EOL;
    echo '<div class="thumb">' . '<img alt="" src="' . $icon_url . '">' . '</div>' . PHP_EOL;
    echo '<div class="meta"><a target="_blank" href="' . $url . '">' . $updated . '</a>' . '<br>@' . $screen_name .'</div>' . PHP_EOL;
    echo '<div class="tweet">' . $text . '</div>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
}
