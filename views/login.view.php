<div class="container">
	<div class="row">
		<div class="col-lg-7 col-sm-12 mx-auto">
			<div class="text-center">
				<h1>ログイン</h1>
			</div>
			<form action="" method="post">
				<?= $this->getData('errorMessage'); ?>
				<div class="form-group">
					<label for="exampleInputEmail1">メールアドレス<span class="text-danger text-outline small">必須</span></label>
					<input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php if (!empty($_POST["email"])) {echo htmlspecialchars($_POST["email"], ENT_QUOTES);} ?>">
					<?= $this->getData('email_errorMessage'); ?>
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">パスワード<span class="text-danger text-outline small">必須</span></label>
					<input type="password" name="password" class="form-control" id="exampleInputPassword1">
					<?= $this->getData('password_errorMessage'); ?>
				</div>
				<button type="submit" name="login" class="btn btn-primary d-block mx-auto">ログイン</button>
			</form>
		</div>
	</div>
</div>