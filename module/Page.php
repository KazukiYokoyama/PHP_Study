<?php

//###########################################
// リクエストされたページに応じて、
// タイトルやレイアウト等を適切な組み合わせにして表示する
//###########################################
Class Page{
    private $page;      // Viewのpath
    private $data;      // Modelの実行結果

    /**
     * ページの内容を表示する
     */
    public function Print(){
        if(file_exists('../views/'.$this->getData('page').'.view.php')){
            // ページが有る場合、指定のレイアウトを読み込む
            // 分かりづらいが、レイアウトの方でBody()を呼び出している
            require('../views/layouts/'.$this->getData('layout').'.layout.php');
        }else{
            // ページが無い場合、404（Not Found）を表示する
            // echo ' (´・ω・｀) 無いよ';
        }
    }

    // bodyの読み込み
    private function Body(){
        require('../views/'.$this->getData('page').'.view.php');
    }

    // Modelから渡されたデータの取得
    private function getData(string $property) :string{
        if(isset($this->data[$property])){
            return (string) $this->data[$property];
        }
        return '';
    }

    // Modelの実行結果をセット
    public function setData(array $data){
        $this->data = $data;
    }
}

?>