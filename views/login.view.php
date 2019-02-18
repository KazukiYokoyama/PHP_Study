<div class="container">
  <div class="mx-auto">
    <div class="text-center">
      <h1>ログイン画面</h1>
    </div>
    <form action="" method="post">
    <?= $this->getData('errorMessage'); ?>
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="<?php if (!empty($_POST["email"])) {echo htmlspecialchars($_POST["email"], ENT_QUOTES);} ?>">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      <input type="submit" name="login" class="btn btn-primary" value="login">
    </form>
  </div>
</div>