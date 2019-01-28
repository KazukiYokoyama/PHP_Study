<?php

//###########################################
// リクエストされたページに応じて、
// タイトルやレイアウト等を適切な組み合わせにして表示する
//###########################################
Class Page{
    private $layout;    // ページのレイアウト
    private $page;      // Viewのpath
    private $title;     // ページのタイトル

    /**
     * ページの内容を表示する
     */
    public function Print(){

        $this->PageSetting();

        if(file_exists('../views/'.$this->page.'.view.php')){
            require('../views/layouts/'.$this->layout.'.layout.php');
        }else{
            // ページが無い場合、404（Not Found）を表示する
            echo ' (´・ω・｀) 無いよ';
        }
    }

    // bodyの読み込み
    protected function Body(){
        require('../views/'.$this->page.'.view.php');
    }

    // ページ指定
    public function setPage(string $page){
        $this->page = $page;
    }

    /**
     * ページ毎のタイトルとテンプレートの指定
     */
    private function PageSetting(){
        switch ($this->page) {
            case 'home':
                $this->title = 'トップページ';
                break;
            case 'signup':
                $this->title = 'アカウント登録';
                break;
            case 'registered':
                $this->title = 'アカウント登録完了';
                break;
        }

        // レイアウトのデフォルト指定
        if(!isset($this->layout)){ $this->layout = 'public_default'; }
    }
}

?>