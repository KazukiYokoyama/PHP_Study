<?php

include_once ('../module/Page.php');

//###########################################
// Controller 
// リクエストに応じたモジュールを実行する
//###########################################
Class Controller{

    private $url = [];          // リクエストされたURL
    private $page = 'home';     // リクエストページ

    /**
     * URLとリクエストページの設定
     * URLの先頭をリクエストページとする
     */
    function __construct(array $url) {
        $this->url = $url;
        $page = array_shift($this->url);
        if($page !== ''){ $this->page = $page; }
    }

    /**
     * 実行するモジュールの判断を行う
     * Modelの実行内容をViewに渡し、編集したページを表示する
     */
    public function Main(){
        $page_data = [];    // ページで使用する情報

        // Modelの処理を実行
        if(file_exists('../models/'.$this->page.'.php')){
            include_once ('../models/'.$this->page.'.php');

            // Modelから実行結果を取得
            $model = new $this->page($this->url);
            $model->Action();
            $page_data = $model->getData();
        }

        if ($this->page === '404'){
            $page_data = [
                'page' => '404',
                'layout' => 'public_default',
                'title' => '404 not found'
            ];
        }

        // 編集したページを表示
        $Page = new Page();
        $Page->setData($page_data);
        $Page->Print();
    }
}

?>