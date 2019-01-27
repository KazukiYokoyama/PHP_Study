<?php

// urlパラメータ取得
$params = explode('/', $_GET['url']);

// 最初のパラメータをリクエストしたページとする
$page = array_shift($params);

// Model読み込み
include ('../models/'.$page.'.php');

// Model::handleから実行結果を取得
$ret = handle($params);
extract($ret);

// View読み込み
include ('../views/'.$page.'.php');

?>
