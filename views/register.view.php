<div class="container">
	<div class="mx-auto">
		<div class="text-center">
			<h1>アカウント登録</h1>
		</div>
		<form method="POST">
			<div class="form-group">
					<label for="exampleInputUserName">User Name</label>
					<input type="text" name="account_name" class="form-control" id="exampleInputUserName" placeholder="Enter account_name">
					<?= $this->getData('username_errorMessage'); ?>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="email"  name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
				<?= $this->getData('email_errorMessage'); ?>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password"  name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
				<?= $this->getData('password_errorMessage'); ?>
			</div>
			<div class="form-group form-check">
				<input type="checkbox" class="form-check-input" id="exampleCheck1">
				<label class="form-check-label" for="exampleCheck1">Check me out</label>
			</div>
			<button type="submit" name="insert" class="btn btn-primary" value="insert">Submit</button>
		</form>
	</div>
</div>