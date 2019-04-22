<?php
//###########################################
// Layout 一般公開画面 デフォルト
//###########################################
?>
<!doctype html>
<html lang="ja">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<?= $this->getData('css') ?>
		<title>PHP-Study <?= $this->page->getTitle() ?></title>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="#">PHP-Studyブログ</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<?php
						if ($this->getData('page') == 'home') {
							echo '<li class="nav-item active"><a class="nav-link" href="/home">Home <span class="sr-only">(current)</span></a></li>';
						} else {
							echo '<li class="nav-item"><a class="nav-link" href="/home">Home</a></li>';
						}
					?>
					<?php
						//セッションにaccount_idがあればログインしている状態なので、表示するメニューを切り替える
						if ($_SESSION["account_id"]) {
							if($this->getData('page') == 'user'){
								echo '<li class="nav-item active"><a class="nav-link" href="/user">マイページ <span class="sr-only">(current)</span></a></li>';
							} else {
								echo '<li class="nav-item"><a class="nav-link" href="/user/articles">マイページ</a></li>';
							}
							if($this->getData('page') == 'logout'){
								echo '<li class="nav-item active"><a class="nav-link" href="/logout">ログアウト <span class="sr-only">(current)</span></a></li>';
							} else {
								echo '<li class="nav-item"><a class="nav-link" href="/logout">ログアウト</a></li>';
							}
						} else {
							if($this->getData('page') == 'register'){
								echo '<li class="nav-item active"><a class="nav-link" href="/register">アカウント登録 <span class="sr-only">(current)</span></a></li>';
							} else {
								echo '<li class="nav-item"><a class="nav-link" href="/register">アカウント登録</a></li>';
							}
							if($this->getData('page') == 'login'){
								echo '<li class="nav-item active"><a class="nav-link" href="/login">ログイン <span class="sr-only">(current)</span></a></li>';
							} else {
								echo '<li class="nav-item"><a class="nav-link" href="/login">ログイン</a></li>';
							}
						} 
					?>
				</ul>
			</div>
			<form class="form-inline">
				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
		</nav>
		<?php $this->Body() ?>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<!-- Vue JS -->
		<script src="/js/lib/vue.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

		<script src="/js/common.js"></script>
	    <script src="/js/<?= $this->page->getTemplate() ?>.js"></script>
	</body>
</html>