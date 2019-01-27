<?php
//###########################################
// View　アカウント登録完了画面
//###########################################

include ('../views/layouts/public_default.layout.php');

/*
　表示するページの内容を記述する
　一般公開画面 デフォルト のレイアウトを継承
 */
Class PagePrint extends PublicDefaultLayout{
    function __construct() {
        // ページタイトル指定
        $this->setTitle('アカウント登録完了');
    }

    // bodyの記述
    protected function Body(){
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
    <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
</nav>
<div class="container">
    <div class="text-center">
        <h1>アカウント登録完了</h1>
        <p>アカウントの登録が完了しました！</p>
    </div>
</div>

<?php
    }
}
?>