<?php
//###########################################
// View　アカウント登録画面
//###########################################

include ('../views/layouts/public_default.layout.php');

/*
　表示するページの内容を記述する
　一般公開画面 デフォルト のレイアウトを継承
 */
Class PagePrint extends PublicDefaultLayout{
  function __construct() {
        // ページタイトル指定
        $this->setTitle('アカウント登録');
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
  <div class="mx-auto">
    <div class="text-center">
      <h1>アカウント登録</h1>
    </div>
    <form>
      <div class="form-group">
          <label for="exampleInputUserName">User Name</label>
          <input type="text" class="form-control" id="exampleInputUserName" placeholder="Enter UserName">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<?php
    }
}
?>