<div class="container">
  <div class="mx-auto">
    <div class="text-center">
      <h1>ログイン画面</h1>
    </div>
    <div id="LoginForm">
      <div class="form-group">
        <label for="exampleInputEmail1">メールアドレス</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" v-model="Athentication.email">
        {{ Error.email }}

      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">パスワード</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" v-model="Athentication.password">
        {{ Error.password }}
      </div>
      <button class="btn btn-primary" @click="login">ログイン</button>
    </div>
  </div>
</div>