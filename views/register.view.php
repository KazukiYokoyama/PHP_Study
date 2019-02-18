<div class="container">
  <div class="mx-auto">
    <div class="text-center">
      <h1>アカウント登録</h1>
    </div>
    <div id="SygnUpForm">
      <div class="form-group">
          <label for="exampleInputUserName">アカウント名</label>
          <input type="text" v-model="SygnUp.account_name" class="form-control" placeholder="Enter UserName">
          <p class="alert-warning" v-text="Alert.Warning.account_name"></p>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">メールアドレス</label>
        <input type="email" v-model="SygnUp.email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        <p class="alert-warning" v-text="Alert.Warning.email"></p>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">パスワード</label>
        <input type="password"  v-model="SygnUp.password" class="form-control" placeholder="Password">
        <p class="alert-warning" v-text="Alert.Warning.password"></p>
      </div>
      <button class="btn btn-primary" @click="submit">アカウント登録</button>
      <p class="alert-danger" v-text="Alert.Warning.failure"></p>
    </div>
  </div>
</div>