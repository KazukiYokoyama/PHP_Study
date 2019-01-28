<?php

include ('../module/Page.php');

//###########################################
// Controller 
// リクエストに応じたモジュールを実行する
//###########################################
Class Controller{

    private $url = [];          // リクエストされたURL
    private $page = 'home';     // リクエストページ

    // URLとリクエストページの設定
    // URLの先頭をリクエストページとする
    function __construct(array $url) {
        $this->url = $url;
        $page = array_shift($this->url);
        if($page !== ''){ $this->page = $page; }
    }

    /**
     * 実行するモジュールの判断を行う
    */
    public function Main(){

        // Model読み込み
        if(file_exists('../models/'.$this->page.'.php')){
            include ('../models/'.$this->page.'.php');
            // Model::handleから実行結果を取得
            // $ret = handle($params);
            // extract($ret);
        }

        $Page = new Page();
        $Page->setPage($this->page);
        $Page->Print();
    }
}

?>