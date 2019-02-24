<div class="container">
  <div class="mx-auto">
    <div class="text-center">
      <h1>アカウント登録</h1>
    </div>
    <form method="POST">
      <div class="form-group">
          <label for="username">User Name</label>
          <input type="text" class="form-control" id="username" placeholder="Enter UserName">
      </div>
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Password">
      </div>
      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
      </div>
      <button type="submit" name="insert" class="btn btn-primary" value="insert">Submit</button>
    </form>
  </div>
</div>