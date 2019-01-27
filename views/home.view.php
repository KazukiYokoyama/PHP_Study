<?php
//###########################################
// View　トップページ
//###########################################

include ('../views/layouts/public_default.layout.php');

/*
　表示するページの内容を記述する
　一般公開画面 デフォルト のレイアウトを継承
 */
Class PagePrint extends PublicDefaultLayout{
    function __construct() {
        // ページタイトル指定
        $this->setTitle('トップページ');
    }

    // bodyの記述
    protected function Body(){
?>

    <h1>Blog Home</h1>

<?php
    }
}
?>
