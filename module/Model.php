<?php

class Model{
    protected $url = [];        // リクエストされたURL
    protected $page_data = [];  // ページで使用する情報

    function __construct(array $url) {
        $this->url = $url;
    }

    /**
     * Modelの処理を記述する
     */
    public function Action(){}

    /**
     * ページで使用する情報を返す
     */
    final public function getData() :array{
        return $this->page_data;
    }
}

?>