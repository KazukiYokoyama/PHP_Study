<?php

// urlパラメータ取得
$url = filter_input(INPUT_GET, 'url');
$params = explode('/', $url);

// 最初のパラメータをリクエストしたページとする
$page = array_shift($params);

// ページの指定が無い場合、トップページを表示する
if($page == ''){ $page = 'home'; }

// Model読み込み
if(file_exists('../models/'.$page.'.php')){
    include ('../models/'.$page.'.php');

    // Model::handleから実行結果を取得
    $ret = handle($params);
    //extract($ret);
}

// View読み込み
if(file_exists('../views/'.$page.'.view.php')){
    include ('../views/'.$page.'.view.php');
    $page_print = new PagePrint();
    $page_print->PageView();
}else{
    // ページが無い場合、404（Not Found）を表示する
    echo '(´・ω・｀)';
}

exit;

?>
