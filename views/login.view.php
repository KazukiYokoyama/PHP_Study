<div class="container">
  <div class="mx-auto">
    <div class="text-center">
      <h1>ログイン画面</h1>
    </div>
    <div id="LoginForm" ref="form">
      <div class="form-group">
        <label>メールアドレス</label>
        <input type="email" v-model="Athentication.email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
        <p class="alert-warning" v-text="Alert.Warning.email"></p>
      </div>
      <div class="form-group">
        <label>パスワード</label>
        <input type="password" v-model="Athentication.password" class="form-control" placeholder="Password">
        <p class="alert-warning" v-text="Alert.Warning.password"></p>
      </div>
      <button class="btn btn-primary" @click="submit">ログイン</button>
    </div>
  </div>
</div>